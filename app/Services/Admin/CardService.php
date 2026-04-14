<?php
/**
 * Created by PhpStorm.
 * User: office
 * Date: 2/19/19
 * Time: 2:16 PM
 */

namespace App\Services\Admin;


use App\Models\Card;
use App\Models\CardItem;
use App\Models\Exam;
use App\Models\ExamSubject;
use App\Models\Student;
use App\Services\Admin\Admission\StudentGroupService;
use App\Services\BaseService;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Setting;

/**
 * Class CardService
 * @package App\Services\Admin
 */
class CardService extends BaseService
{

    protected $cardItem;
    protected $exam;
    protected $examSubject;
    protected $student;
    protected $studentGroupService;

    /**
     * CardService constructor.
     * @param Card $card
     */
    public function __construct(Card $card, CardItem $cardItem, Exam $exam, ExamSubject $examSubject, Student $student, StudentGroupService $studentGroupService)
    {
        $this->model = $card;
        $this->cardItem = $cardItem;
        $this->exam = $exam;
        $this->examSubject = $examSubject;
        $this->student = $student;
        $this->studentGroupService = $studentGroupService;
    }

    /**
     * @param $request
     * @return \App\Services\insert_id
     */
    public function saveCards($request){
        return $this->create([
            'title' => $request->card_name,
            'subject_id' => $request->subject_id,
            'phase_id' => checkEmpty($request->phase_id),
            'term_id' => checkEmpty($request->term_id),
            'description' => checkEmpty($request->description),
        ]);
    }

    /**
     * @param $request
     * @return mixed
     */
    public  function getDatatable($request){

        $query = $this->model->with('cardItems', 'subject', 'phase', 'term')->select();

        if (Auth::guard('web')->check()){
            $user = Auth::guard('web')->user();
            if ($user->teacher){
                $query = $query->whereHas('subject', function ($q) use($user){
                    $q->whereIn('id', getSubjectsIdByTeacherId($user->teacher->id, $user->teacher->course_id));
                });
            }
        }elseif (Auth::guard('student_parent')->check()){
            $user = Auth::guard('student_parent')->user();
            //if login user is student
            if ($user->student){
                $query = $query->whereHas('subject', function ($q) use($user){
                    $q->whereIn('id', getSubjectsIdByCourseId($user->student->course_id));
                });
            }
            //if login user is parent
            elseif ($user->parent){
                $query = $query->whereHas('topicHead', function ($q) use($user){
                    $q->whereIn('subject_id', getSubjectsIdByCourseId($user->parent->students->first()->course_id));
                });
            }
        }

        return Datatables::of($query)
            ->addColumn('subject_id', function ($row) {
                return isset($row->subject) ? $row->subject->title : '';
            })
            ->addColumn('phase_id', function ($row) {
                return isset($row->phase) ? $row->phase->title : '';
            })
            ->addColumn('term_id', function ($row) {
                return isset($row->term) ? $row->term->title : '';
            })
            /*->addColumn('items', function ($row) {
                if (isset($row->cardItems)){
                   return $items = count($row->cardItems);
                } else{
                    return $items = 0;
                }
            })*/
            /*->addColumn('items', function ($row) {
                return isset($row->cardItems) ? '<a href="'.route('cardItems.index', ['card_id' => $row->id]).'">'.count($row->cardItems).'</a>' : 0;
            })*/
            ->addColumn('items', function ($row) {
                if(Auth::guard('web')->check()){
                    return isset($row->cardItems) ? '<a href="'.route(customRoute('cardItems.index'), ['card_id' => $row->id]).'">'.count($row->cardItems).'</a>' : 0;
                }else{
                    return isset($row->cardItems) ? count($row->cardItems) : 0;
                }
            })
            ->addColumn('action', function ($row) {
                $actions = '';

                if (hasPermission('cards/edit')) {
                    $actions.= '<a href="' . route('cards.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Installments"><i class="flaticon-edit"></i></a>';
                }

                if (hasPermission('cards/view')) {
                    $actions.= '<a href="' . route(customRoute('cards.show'), [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';
                }

                return $actions;
            })
            ->editColumn('status', function ($row) {
                return setStatus($row->status) ;
            })
            ->rawColumns(['items','description','status', 'action'])

            ->filter(function ($query) use ($request) {

                if (!empty($request->get('course_id'))) {
                    $query->whereHas('subject.subjectGroup', function ($q) use($request){
                        $q->where('course_id', $request->get('course_id'));
                    });
                }
                if (!empty($request->get('subject_group_id'))) {
                    $query->whereHas('subject', function ($q) use($request){
                        $q->where('subject_group_id', $request->get('subject_group_id'));
                    });
                }

                if (!empty($request->get('subject_id'))) {
                    $query->where('subject_id', $request->get('subject_id'));
                }

            })

            ->make(true);
    }

    /**
     * @param $request
     * @param $id
     * @return \phpDocumentor\Reflection\Types\Boolean
     */
    public function updateCards($request, $id){
        return $this->update([
            'title' => $request->card_name,
            'subject_id' => $request->subject_id,
            'phase_id' => checkEmpty($request->phase_id),
            'term_id' => checkEmpty($request->term_id),
            'status' => $request->status,
            'description' => checkEmpty($request->description),
        ], $id);
    }

    public function getCardsBySubjectId($subjectId){
        return $this->model->where('subject_id', $subjectId)->get();
    }

    public function addCardItems($request){
        $items = [];
        if (!empty($request->title)){
            foreach ($request->title as $key => $title){
                $items[$key] = [
                    'title' => $title,
                    'serial_number' => $request->serial_number[$key]
                ];

            }
            return $this->model->find($request->card_id)->cardItems()->createMany($items);
        }
    }

    public  function getCardItemsDatatable($request){

        $query = $this->cardItem->with(['card','card.subject'])->select()->orderBy('serial_number', 'asc');

        if (Auth::guard('web')->check()){
            $user = Auth::guard('web')->user();
            if ($user->teacher){
                $query = $query->whereHas('card', function ($q) use($user){
                    $q->whereIn('subject_id', getSubjectsIdByTeacherId($user->teacher->id, $user->teacher->course_id));
                });
            }
        }elseif (Auth::guard('student_parent')->check()){
            $user = Auth::guard('student_parent')->user();
            //if login user is student
            if ($user->student){
                $query = $query->whereHas('card', function ($q) use($user){
                    $q->whereIn('subject_id', getSubjectsIdByCourseId($user->student->course_id));
                });
            }
            //if login user is parent
            elseif ($user->parent){
                $query = $query->whereHas('card', function ($q) use($user){
                    $q->whereIn('subject_id', getSubjectsIdByCourseId($user->parent->students->first()->course_id));
                });
            }
        }

        return Datatables::of($query)
            ->addColumn('card_id', function ($row) {
                return isset($row->card) ? $row->card->title : '';
            })
            ->addColumn('subject_id', function ($row) {
                return isset($row->card) ? $row->card->subject->title : '';
            })
            ->addColumn('items', function ($row) {
                return isset($row->cardItems) ? count($row->cardItems) : 0;
            })
            ->addColumn('action', function ($row) {
                $actions = '';

                if (hasPermission('exams/create')) {
                    $actions.= '<a href="' . route('exams.item.create', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Exam"><i class="fas fa-archway"></i></a>';
                }
                if (hasPermission('cards/edit')) {
                    $actions.= '<a href="' . route('cardItems.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit Item"><i class="flaticon-edit"></i></a>';
                }
                return $actions;
            })
            ->editColumn('status', function ($row) {
                return setStatus($row->status) ;
            })
            ->rawColumns(['description','status', 'action'])
            ->filter(function ($query) use ($request) {
                if (!empty($request->get('card_id'))) {
                    $query->where('card_id', $request->get('card_id'));
                }
                if (!empty($request->get('subject_id'))) {
                    $query->whereHas('card.subject', function ($q) use($request){
                        $q->where('id', $request->get('subject_id'));
                    });
                }
            })
            ->make(true);
    }

    public function getCardItemById($id){
        return $this->cardItem->find($id);
    }

    public function updateCardItems($request, $id){
        return $this->cardItem->find($id)->update([
            'title' => $request->title,
            'serial_number' => $request->serial_number,
            'card_id' => $request->card_id,
            'status' => $request->status
        ]);
    }

    public function ItemSerialNumberExist($cardId, $itemId, $itemSerialNumber){
        return $this->cardItem->where('id', '<>', $itemId)->where('card_id', $cardId)->where('serial_number', $itemSerialNumber)->count();
    }



    public function saveItemExamMarks($request, $itemId){
//        $authUser = Auth::guard('web')->user();
        //take responsible teacher/user id
//        if (!$authUser->teacher){
//            $responsibleUserId = $authUser->id;
//        } elseif ($authUser->teacher){
//            $responsibleUserId = $authUser->teacher->id;
//        }

        $request->merge(['exam_category_id' => 1]);
        $cardInfo = $this->cardItem->find($itemId);
        $check = $this->exam->whereHas('examSubjects', function ($q) use($itemId){
                $q->where('card_item_id', $itemId);
            })->where('session_id', $request->session_id)->where('course_id', $request->course_id)
            ->where('phase_id', $request->phase_id)->where('term_id', $request->term_id)->first();

        DB::beginTransaction();

        try {
            if (empty($check)) {
                $exam = $this->exam->create([
                    'session_id'       => $request->session_id,
                    'course_id'        => $request->course_id,
                    'exam_category_id' => $request->exam_category_id,
                    'phase_id'         => $request->phase_id,
                    'term_id'          => $request->term_id,
                    'title'            => $request->title,
                ]);

                $this->examSubject->create([
                    'exam_id'             => $exam->id,
                    'subject_group_id'    => $cardInfo->card->subject->subject_group_id,
                    'subject_id'          => $cardInfo->card->subject_id,
                    'card_id'             => $cardInfo->card_id,
                    'card_item_id'        => $itemId,
                    'exam_type_id'        => 4,    //viva type exam
                    'exam_date'           => Carbon::now()->format('d/m/Y'),
                    'result_published'    => 0,
                    'result_publish_date' => Carbon::now()->format('d/m/Y'),
                ]);

                $exam->examMarks()->create([
                    'subject_id'       => $cardInfo->card->subject_id,
                    'exam_sub_type_id' => 20,    //viva sub-type exam
                    'total_marks'      => Setting::getSiteSetting()->item_exam_mark,
                ]);
            } else {
                $exam = $check;
            }

            $studentsResults = [];
            $passPercentage  = Setting::getSiteSetting()->pass_mark;
            foreach ($request->student_id as $key => $student) {
                //absent
                $passStatus   = 4;
                $resultStatus = 'Absent';
                if (!empty($request->marks[$key])) {
                    $checkPercentage = ($request->marks[$key] * 100) / Setting::getSiteSetting()->item_exam_mark;
                    //pass
                    if ($checkPercentage >= $passPercentage) {
                        $passStatus   = 1;
                        $resultStatus = 'Pass';
                    } else {
                        //fail
                        $passStatus   = 2;
                        $resultStatus = 'Fail';
                    }
                }
//                if (!empty($request->marks[$key])) {
                //check entry exist
                $studentsResults[$key] = [
                    'student_id'    => $student,
                    'responsible_teacher_id' => $request->teacher_id,
                    'marks'         => !empty($request->marks[$key]) ? $request->marks[$key] : 0,
                    'result_date'   => checkEmpty($request->clear_date[$key]),
                    'remarks'       => checkEmpty($request->remarks[$key]),
                    'pass_status'   => $passStatus,
                    'result_status' => $resultStatus,
                ];
//            }

            }
            $exam->examMarks->first()->result()->createMany($studentsResults);

            DB::commit();

            return $exam;
        } catch (Exception $exception) {
            DB::rollBack();

            return $exception->getMessage() . $exception->getLine() . $exception->getCode();
        }
    }

    public function getCardsAndItemsBySubjectId($subjectId){
        return $this->model->with('cardItems.examSubjects.exam.examMarks.result')
            ->where('subject_id', $subjectId)->orderBy('title', 'asc')->get();
    }

    public function getCardsItemsAndStudentResultBySubjectStudentAndPhaseId($subjectId, $studentId, $phaseId){
        return $this->model->with(['cardItems.examSubjects.exam.examMarks.result' => function($q) use($studentId){
            $q->where('student_id', $studentId);
        }])
            ->where('subject_id', $subjectId)
            ->where('phase_id', $phaseId)->orderBy('title', 'asc')->get();
    }

    public function getCardsItemsAndStudentResultBySubjectPhaseAndCourseId($subjectId, $phaseId, $courseId, $sessionId=''){
        //$lastSession = $this->student->where('course_id', $courseId)->where('phase_id', $phaseId)->first();
        //$lastSession=$sessionId;
        return $this->model
            ->with([
                'cardItems' => function ($q) {
                    $q->orderBy('serial_number', 'asc');
                },
                'cardItems.examSubjects',
                'cardItems.examSubjects.exam' => function ($q) use ($courseId, $phaseId, $sessionId) {
                    $q->where('session_id', $sessionId)
                      ->where('course_id', $courseId)
                      ->where('phase_id', $phaseId);
                },
                'cardItems.examSubjects.exam.examMarks',
                'cardItems.examSubjects.exam.examMarks.result' => function ($q) {
                    $q->select('id', 'exam_subject_mark_id', 'pass_status');
                }
            ])
            ->where('subject_id', $subjectId)
            ->where('phase_id', $phaseId)
            ->where('status', 1)
            ->orderBy('term_id', 'asc')
            ->get();
    }

    public function getTotalCardsByCourseIdAndDepartmentId($courseId, $deptId){
       return $this->model->whereHas('subject', function ($q) use($deptId){
            $q->where('department_id', $deptId);
        })->whereHas('subject.subjectGroup', function ($q) use($courseId){
            $q->where('course_id', $courseId);
        })->count();
    }

    public function getTotalItemsByCourseIdAndDepartmentId($courseId, $deptId){
       return $this->cardItem->whereHas('card.subject', function ($q) use($deptId){
            $q->where('department_id', $deptId);
        })->whereHas('card.subject.subjectGroup', function ($q) use($courseId){
            $q->where('course_id', $courseId);
        })->count();
    }

    public  function getCardItemsByCardId($cardId){
        return $this->cardItem->where('card_id', $cardId)->get();
    }

    public function checkExamMarkAlreadyGivenToStudentGroupByRollRangeAndItemId($request){
        $exam = $this->exam->whereHas('examSubjects', function ($q) use($request){
            $q->where('card_item_id', $request->itemId);
        })->where('session_id', $request->session_id)->where('course_id', $request->course_id)
            ->where('phase_id', $request->phase_id)->where('term_id', $request->term_id)->first();
        if (!empty($exam)){
            $examResult = $exam->examMarks->first()->result()->get();

            $students = $examResult->map(function ($result) {
                return $result->student;
            });
        }

        if (!empty($students)){
            $exist = 0;
            if ($request->student_group_id && $request->student_group_id != 'all') {
                $studentGroup = $this->studentGroupService->find($request->student_group_id);
                if ($studentGroup) {
                    $studentGroupArray = $studentGroup->students->pluck('id')->toArray();
                    $exist             = $students->whereIn('id', $studentGroupArray)->count();
                }
            } elseif ($request->student_group_id == 'all') {
                $maxRollNo = $students->max('roll_no');
                $exist     = $students->whereBetween('roll_no', [1, $maxRollNo])->count();
            }
            return $exist;
        }
    }

    //item max serial number by cardId
    public function getCardItemMaxSerialByCardId($cardId){
        return $this->cardItem->where('card_id', $cardId)->max('serial_number');
    }

    //item list by cardId
    public function getCardItemListByCardId($cardId){
        return $this->cardItem->where('card_id', $cardId)->pluck('title');
    }
}
