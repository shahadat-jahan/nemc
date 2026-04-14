<?php

namespace App\Services\Admin;

use App\Models\Guardian;
use App\Models\Message;
use App\Models\MessageReply;
use App\Models\Student;
use App\Models\User;
use App\Services\BaseService;
use App\Services\UtilityServices;
use Carbon\Carbon;
use DataTables;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class MessageService extends BaseService
{

    /**
     * @var $model
     */
    protected $model;
    protected $messageReplyModel;
    protected $notificationService;
    /**
     * @var string
     */
    // protected $url = 'admin/message';

    public function __construct(Message $message, NotificationService $notificationService, MessageReply $messageReply)
    {
        $this->model               = $message;
        $this->messageReplyModel   = $messageReply;
        $this->notificationService = $notificationService;
    }

    public function getAllData($request)
    {
        //take login user info
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
        } else if (Auth::guard('student_parent')->check()) {
            $user = Auth::guard('student_parent')->user();
        }
        //get all messages related to login user
        $query = $this->model->where('user_id', $user->id)->orWhere('created_by', $user->id)->select();

        return Datatables::of($query)
                         ->addColumn('action', function ($row) {
                             $actions = '';

                             if (Auth::guard('web')->check()) {
                                 $user = Auth::guard('web')->user();
                             } else if (Auth::guard('student_parent')->check()) {
                                 $user = Auth::guard('student_parent')->user();
                             }

                             if ($user->student || $user->parent) {
                                 $actions .= '<a href="' . route('frontend.message.show', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';
                             } else {
                                 $actions .= '<a href="' . route('message.show', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';
                             }

                             return $actions;
                         })
                         ->editColumn('user_id', function ($row) {
                             if (!empty($row->user)) {
                                 if ($row->user->teacher) {
                                     return $row->user->teacher->full_name;
                                 }

                                 if ($row->user->student) {
                                     return $row->user->student->full_name_en;
                                 }

                                 if ($row->user->parent) {
                                     return $row->user->parent->father_name;
                                 }

                                 return $row->user->user_id;
                             }
                         })
                         ->editColumn('created_by', function ($row) {
                             if (!empty($row->createdBy)) {
                                 if ($row->createdBy->teacher) {
                                     return $row->createdBy->teacher->full_name;
                                 }

                                 if ($row->createdBy->student) {
                                     return $row->createdBy->student->full_name_en;
                                 }

                                 if ($row->createdBy->parent) {
                                     return $row->createdBy->parent->father_name;
                                 }

                                 return $row->createdBy->user_id;
                             }
                         })
                         ->editColumn('file_path', function ($row) {
                             return isset($row->file_path) ? '<a href="' . asset('nemc_files/message/' . $row->file_path) . '" class=" btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" target="_blank" title="Download attachment file" download><i class="fa fa-download"></i></a>' : '--';
                         })
                         ->editColumn('is_seen', function ($row) {
                             return messageStatus($row->is_seen);
                         })
                         ->editColumn('is_replied', function ($row) {
                             return messageReplyStatus($row->is_replied);
                         })
                         ->rawColumns(['file_path', 'action', 'is_seen', 'is_replied'])
                         ->filter(function ($query) use ($request) {
                             if ($request->get('subject')) {
                                 $query->where('subject', 'like', '%' . $request->get('subject') . '%');
                             }

                             if (!empty($request->get('date_start')) && !empty($request->get('date_end'))) {
                                 //change date format
                                 $startDate = $fromDate = Carbon::createFromFormat('d/m/Y', $request->date_start)->format('Y-m-d');
                                 $endDate   = $fromDate = Carbon::createFromFormat('d/m/Y', $request->date_end)->format('Y-m-d');
                                 $query->whereBetween('created_at', [$startDate, $endDate]);
                             } elseif (!empty($request->get('date_start'))) {
                                 $startDate = $fromDate = Carbon::createFromFormat('d/m/Y', $request->date_start)->format('Y-m-d');
                                 $query->where('created_at', 'like', '%' . $startDate . '%');
                             } elseif (!empty($request->get('date_end'))) {
                                 $endDate = $fromDate = Carbon::createFromFormat('d/m/Y', $request->date_end)->format('Y-m-d');
                                 $query->where('created_at', 'like', '%' . $endDate . '%');
                             }
                         })
                         ->make(true);
    }

    /**
     * @param $request
     */
    public function saveMessage($request)
    {
        if ($request->hasFile('attachment')) {
            //accept file from file type field
            $file        = $request->file('attachment');
            $currentDate = Carbon::now()->toDateString();
            //create file name
            $fileName = $currentDate . '_' . uniqid() . '_' . $file->getClientOriginalName();
            //if directory not exist make directory
            if (!file_exists('nemc_files/message')) {
                mkdir('nemc_files/message', 0777, true);
            }
            //move file to directory
            $file->move('nemc_files/message', $fileName);
            //assign file name to request file_path
            $request['file_path'] = $fileName;
        }

        try {
            DB::beginTransaction();
            //save data to message table
            $messageData = $this->model->create($request->except('attachment'));

            //send sms or email start
            $massageText = strip_tags(str_replace(['<p>', '</p>'], ['', PHP_EOL], $request->get('message')));
            $user        = User::where('id', $request->get('user_id'))->first();

            if ($user->user_group_id == 6) {
                $parent       = Guardian::where('user_id', $request->get('user_id'))->first();
                $student      = Student::where('parent_id', $parent->id)->first();
                $mobileNumber = $student->parent->father_phone;
                $email        = $student->parent->father_email;
            } else {
                $student      = Student::where('user_id', $request->get('user_id'))->first();
                $mobileNumber = $student->mobile;
                $email        = $student->email;
            }

            if ($student->category_id != 2 && $student->nationality == 18) {
                $client      = new Client();
                $data        = $client->post('https://gpcmp.grameenphone.com/ecmapigw/webresources/ecmapigw.v2', [
                    'json' => [
                        "username"    => "NEMPLdt058",
                        "password"    => "Nemc@1998",
                        "apicode"     => "1",
                        "msisdn"      => $mobileNumber,
                        "countrycode" => "880",
                        "cli"         => "NEMC",
                        "messagetype" => "1",
                        "message"     => $massageText,
                        "messageid"   => "0",
                    ]
                ]);
                $response    = $data->getBody()->getContents();
                $response    = json_decode($response);
                $messageType = 'sms';
                $email       = NULL;
            } else {
                $template = 'emails.defaultEmailTemplate';
                $subject  = 'Message From NEMC';
                $to       = $email;
                $cc       = '';
                if ($to) {
                    Mail::send($template, ['body' => $massageText], function ($message) use ($subject, $to, $cc) {
                        $message->subject($subject);
                        $message->from(config('mail.from.address'), config('mail.from.name'));
                        $message->to(trim($to));
                        if ($cc) {
                            $message->cc($cc);
                        }
                    });
                    $messageType  = 'email';
                    $mobileNumber = NULL;
                    $response     = true;
                } else {
                    $response = false;
                }
            }

            if ($response) {
                DB::table('email_sms_histories')->insertGetId(
                    array(
                        'user_id'       => $request->get('user_id'),
                        'user_group_id' => $user->user_group_id,
                        'message_type'  => $messageType,
                        'purpose'       => 'other',
                        'message'       => $request->get('message'),
                        'email'         => $email,
                        'phone'         => $mobileNumber,
                        'response'      => json_encode($response),
                        'created_by'    => Auth::user()->id,
                        'created_at'    => Carbon::now(),
                        'updated_at'    => Carbon::now()
                    )
                );
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return $e->getMessage();
        }

        //save data to notification table
        if (!empty($messageData)) {
            $this->notificationService->create([
                'notification_type' => 'message',
                'user_id'           => $messageData->user_id,
                'resource_id'       => $messageData->id,
                'resource_type'     => UtilityServices::$notificationModels[3],
                'message'           => $messageData->subject,
            ]);
        }
        return $messageData;
    }

    //Save reply message to message reply table
    public function saveReplyMessageData($messageId, $data)
    {
        $message  = $this->find($messageId);
        $userName = '';
        //get message for whom this reply occur
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            if ($user->teacher) {
                $userName = $user->teacher->full_name;
            } elseif ($user->adminUser) {
                $userName = $user->adminUser->full_name;
            } else {
                $userName = $user->name;
            }
        } else if (Auth::guard('student_parent')->check()) {
            $user = Auth::guard('student_parent')->user();

            if ($user->student) {
                $userName = $user->student->full_name_en;
            } elseif ($user->parent) {
                $userName = $user->parent->father_name;
            } else {
                $userName = $user->name;
            }
        }

        //check who reply on message and save to message reply table
        if ($message->user_id == $user->id) {
            $notifyUserId = $message->created_by;
        } else {
            $notifyUserId = $message->user_id;
        }

        $replyMessage = $this->messageReplyModel->create([
            'message_id'    => $messageId,
            'reply_message' => $data['reply_message'],
            'user_id'       => $notifyUserId
        ]);
        //update message seen and reply status after reply
        $message->update(['is_seen' => 1, 'is_replied' => 1]);

        //save data to notification table on reply message
        if (!empty($replyMessage)) {
            $this->notificationService->create([
                'notification_type' => 'message',
                'user_id'           => $notifyUserId,
                'resource_id'       => $message->id,
                'resource_type'     => UtilityServices::$notificationModels[3],
                'message'           => '<strong>' . $userName . '</strong> reply on your message: ' . $message->subject,
            ]);
        }

        return $replyMessage;
    }

}
