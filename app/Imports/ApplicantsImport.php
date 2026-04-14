<?php

namespace App\Imports;

use App\Models\AdmissionParent;
use App\Models\Session;
use App\Services\Admin\Admission\AdmissionService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ApplicantsImport implements ToCollection, WithHeadingRow
{
    private const LOCAL_PHONE_PATTERN = '/^[0-9]{11}$/';
    private const INTERNATIONAL_PHONE_PATTERN = '/^\+\d{1,3}(?:[-.\s]?\(?\d{1,4}\)?)?[-.\s]?\d{1,6}[-.\s]?\d{1,10}$/';
    private const DEFAULT_NATIONALITY = 18;
    private const DEFAULT_STUDENT_CATEGORY = 1;
    public $info = [];
    public $importedCount = 0;
    protected $admissionService;
    protected $admissionParent;
    protected $request;

    public function __construct($request, AdmissionService $admissionService, AdmissionParent $admissionParent)
    {
        $this->request = $request;
        $this->admissionService = $admissionService;
        $this->admissionParent = $admissionParent;
    }

    /**
     * Process the imported collection of rows
     *
     * @param Collection $rows
     * @return array
     */
    public function collection(Collection $rows): array
    {
        try {
            DB::beginTransaction();

            foreach ($rows as $index => $row) {
                $errors = $this->validateRow($row);

                if ($errors) {
                    return $this->info = [
                        'message' => sprintf('%s in row %d.', $errors[0], $index + 2),
                        'status' => false,
                    ];
                }

                if ($this->isDuplicateMobile($row)) {
                    return $this->info = [
                        'message' => sprintf('Duplicate mobile number %s detected in row %d.', $row['mobile'], $index + 2),
                        'status' => false,
                    ];
                }

                $this->processRow($row);
            }

            DB::commit();

            return $this->info = [
                'message' => 'Applicants Excel Import Done. ' . $this->importedCount . ' applicants imported successfully.',
                'status' => true,
            ];
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Applicants Import Error: ' . $e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    private function validateRow($row)
    {
        $errors = [];
        $studentCategory = explode('-', $row['student_category'])[0];
        $requiredFields = [
            'name' => 'Name',
            'mobile' => 'Mobile',
            'gender' => 'Gender',
            'date_of_birth' => 'Date of Birth',
            'place_of_birth' => 'Place of Birth',
            'form_fillup_date' => 'Form Fill-Up Date',
            'father_name' => 'Father Name',
            'mother_name' => 'Mother Name',
            'father_mobile' => 'Father Mobile'
        ];

        // Check for missing fields
        foreach ($requiredFields as $field => $label) {
            if (empty($row[$field])) {
                $errors[] = "{$label} is required";
            }
        }

        // Validate phone numbers if they're provided
        if (!empty($row['mobile']) || !empty($row['father_mobile'])) {
            $validationPattern = $studentCategory != 2 ?
                self::LOCAL_PHONE_PATTERN :
                self::INTERNATIONAL_PHONE_PATTERN;

            if (!empty($row['mobile']) && !preg_match($validationPattern, $row['mobile'])) {
                $errors[] = "Invalid student mobile number format";
            }

            if (!empty($row['father_mobile']) && !preg_match($validationPattern, $row['father_mobile'])) {
                $errors[] = "Invalid father mobile number format";
            }
        }

        return $errors;
    }

    private function isDuplicateMobile($row)
    {
        // Check for duplicate mobile number in both student tables
        return $this->admissionService->findBy(['mobile' => $row['mobile']]);
    }

    private function processRow($row)
    {
        try {
            // Filter out numeric keys and null values
            $row = collect($row)->filter(function ($value, $key) {
                return !is_numeric($key) && !is_null($value);
            })->toArray();

            $parent = $this->admissionParent->where('father_phone', $row['father_mobile'])->first();

            if (empty($parent)) {
                $parent = $this->admissionParent->create($this->prepareParentData($row));
            }

            $applicant = $parent->admissionStudents()->create($this->prepareApplicantData($row));

            $applicant->admissionEducationHistories()->createMany($this->prepareEducationHistory($row));

            $this->importedCount++;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    private function prepareParentData($row)
    {
        return [
            'father_name' => $row['father_name'],
            'mother_name' => $row['mother_name'],
            'father_phone' => $row['father_mobile'],
            'annual_income' => $this->getNullableValue($row['annual_income']),
            'finance_during_study' => $this->getNullableValue($row['finance_during']),
            'address' => $this->getNullableValue($row['permanent_address']),
        ];
    }

    /**
     * Get nullable value with proper type handling
     *
     * @param mixed $value
     * @return mixed
     */
    private function getNullableValue($value)
    {
        return $value ?? null;
    }

    private function prepareApplicantData($row)
    {
        // Extract commonly used variables
        $sessionId = $this->request->get('session_id');
        $courseId = $this->request->get('course_id');
        $startYear = Session::find($sessionId)->start_year;
        $address = $this->getNullableValue($row['permanent_address']);
        $presentAddress = $address ?: $this->getNullableValue($row['permanent_address']);

        // Prepare and return the applicant data array
        return [
            'session_id' => $sessionId,
            'course_id' => $courseId,
            'student_category_id' => $row['student_category'] ? explode('-', $row['student_category'])[0] : self::DEFAULT_STUDENT_CATEGORY,
            'full_name_en' => $row['name'],
            'mobile' => $row['mobile'],
            'gender' => $row['gender'],
            'nationality' => $row['nationality'] ? explode('-', $row['nationality'])[0] : self::DEFAULT_NATIONALITY,
            'date_of_birth' => $this->formateDate($row['date_of_birth']),
            'place_of_birth' => $row['place_of_birth'],
            'form_fillup_date' => $this->formateDate($row['form_fillup_date']),
            'permanent_address' => $address,
            'present_address' => $presentAddress,
            'same_as_permanent' => $address == $presentAddress ? 1 : 0,
            'admission_year' => $startYear,
            'commenced_year' => $startYear,
        ];
    }

    private function formateDate($date)
    {
        return Date::excelToDateTimeObject($date)->format('d/m/Y');
    }

    private function prepareEducationHistory($row)
    {
        return [
            [
                'education_level' => 1,
                'education_board_id' => explode('-', $row['ssc_education_board'])[0],
                'pass_year' => $row['ssc_year'],
                'gpa' => $row['ssc_gpa'],
                'gpa_biology' => $row['ssc_gpa_of_biology'],
                'institution' => $row['ssc_institution'],
            ],
            [
                'education_level' => 2,
                'education_board_id' => explode('-', $row['hsc_education_board'])[0],
                'pass_year' => $row['hsc_year'],
                'gpa' => $row['hsc_gpa'],
                'gpa_biology' => $row['hsc_gpa_of_biology'],
                'institution' => $row['hsc_institution'],
            ],
        ];
    }
}
