<?php

namespace App\Imports;

use App\Events\UpdateStudentCredit;
use App\Models\Student;
use App\Models\StudentFeeDetail;
use App\Models\StudentPayment;
use App\Models\User;
use App\Services\StudentFeeService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PaymentBulkImport implements ToCollection, WithHeadingRow
{
    private const DEFAULT_PAYMENT_METHOD_ID = 1;
    public $info = [];
    public $importedCount = 0;
    private array $seenUserPaymentCombos = [];

    public function __construct()
    {
        //
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

            // Filter only non-empty rows before loop
            $filteredRows = $rows->filter(function ($row) {
                // Only named keys (non-numeric)
                $namedData = collect($row)->filter(function ($value, $key) {
                    return !is_numeric($key);
                });

                // Check if the row has at least one non-empty value
                return $namedData->filter(fn($v) => !is_null($v) && $v !== '')->isNotEmpty();
            });

            if ($filteredRows->isEmpty()) {
                return $this->info = [
                    'message' => 'No valid data found in the uploaded file.',
                    'status' => false,
                ];
            }

            foreach ($filteredRows as $index => $row) {
                // Filter only named keys (non-numeric keys)
                $filteredRow = collect($row)->filter(function ($value, $key) {
                    return !is_numeric($key);
                });
                $row = $filteredRow->toArray();

                $errors = $this->validateRow($row);

                if ($errors) {
                    return $this->info = [
                        'message' => sprintf('%s in row %d.', $errors[0], $index + 2),
                        'status' => false,
                    ];
                }

                if ($this->isDuplicateUserIdPaymentDate($row)) {
                    return $this->info = [
                        'message' => sprintf(
                            'Duplicate entry detected for User ID: %s on Payment Date: %s (row %d). Each user can have only one payment per date.',
                            $row['user_id'],
                            $this->formatDate($row['payment_date']),
                            $index + 2
                        ),
                        'status' => false,
                    ];
                }

                $this->processRow($row);
            }

            DB::commit();

            return $this->info = [
                'message' => 'Payments Excel Import Done. ' . $this->importedCount . ' payments imported successfully.',
                'status' => true,
            ];
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Payments Import Error: ' . $e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    private function validateRow($row)
    {
        $errors = [];
        $requiredFields = [
            'user_id' => 'User ID',
            'payment_date' => 'Payment Date',
        ];

        // Check for missing fields
        foreach ($requiredFields as $field => $label) {
            if (empty($row[$field])) {
                $errors[] = "{$label} is required";
            }
        }

        // Validate phone numbers if they're provided
        if (!empty($row['user_id'])) {
            $validUserId = User::where('user_id', $row['user_id'])->exists();
            if (!$validUserId) {
                $errors[] = 'Invalid User ID';
            }
        }

        $paymentTypes = [
            'discount_development_fee',
            'development_fee',
            'discount_admission_fee',
            'admission_fee',
            'discount_tuition_fee',
            'tuition_fee',
            'discount_class_absent_fee',
            'class_absent_fee',
            'discount_late_fee',
            'late_fee',
            'discount_re_admission_fee',
            're_admission_fee',
        ];

        // Check if at least one payment type is provided
        $hasPaymentType = collect($paymentTypes)->contains(fn($type) => !is_null($row[$type]) && $row[$type] > 0);

        if (!$hasPaymentType) {
            $errors[] = 'At least one payment type must be provided';
        }

        // Validate that all payment types are numeric if provided
        foreach ($paymentTypes as $type) {
            if (isset($row[$type]) && !is_numeric($row[$type])) {
                $errors[] = ucfirst(str_replace('_', ' ', $type)) . ' must be a number';
            }
        }

        return $errors;
    }

    private function isDuplicateUserIdPaymentDate($row): bool
    {
        $userId = $row['user_id'] ?? null;
        $paymentDate = $this->formatDate($row['payment_date']);
        $comboKey = $userId . '-' . $paymentDate;
        // If already seen, skip this row
        if (isset($this->seenUserPaymentCombos[$comboKey])) {
            return true;
        }

        // Mark as seen and allow this row
        $this->seenUserPaymentCombos[$comboKey] = true;
        return false;
    }

    /**
     * @param $date
     * @return string
     */
    private function formatDate($date)
    {
        return Date::excelToDateTimeObject($date)->format('d/m/Y');
    }

    private function processRow($row)
    {
        try {
            // Get student
            $student = Student::with('user')->whereHas('user', function ($q) use ($row) {
                $q->where('user_id', $row['user_id']);
            })->first();

            $studentId = $student->id ?? null;

            if (!$studentId) {
                throw new Exception("Student not found for user_id: {$row['user_id']}");
            }

            $dataValue = [];
            if (!is_null($row['development_fee']) || !is_null($row['discount_development_fee'])) {
                $dataValue[1] = 1;
            }
            if (!is_null($row['admission_fee']) || !is_null($row['discount_admission_fee'])) {
                $dataValue[2] = 2;
            }
            if (!is_null($row['tuition_fee']) || !is_null($row['discount_tuition_fee'])) {
                $dataValue[3] = 3;
            }
            if (!is_null($row['class_absent_fee']) || !is_null($row['discount_class_absent_fee'])) {
                $dataValue[4] = 4;
            }
            if (!is_null($row['late_fee']) || !is_null($row['discount_late_fee'])) {
                $dataValue[5] = 5;
            }
            if (!is_null($row['re_admission_fee']) || !is_null($row['discount_re_admission_fee'])) {
                $dataValue[6] = 6;
            }

            $lastId = StudentPayment::orderBy('id', 'desc')->pluck('id')->first() ?? 0;
            $invoiceNo = $lastId . date('ymd') . date('His');
            $paymentDate = $this->formatDate($row['payment_date']);

            if (!empty($dataValue)) {
                foreach ($dataValue as $key => $paymentTypeId) {
                    $allFees = StudentFeeDetail::whereHas('fee', function ($q) use ($studentId) {
                        $q->where('student_id', $studentId);
                    })
                                               ->where('payment_type_id', $paymentTypeId)
                                               ->where('status', '<>', 1)
                                               ->with('fee')
                                               ->get();

                    $this->processStudentPayments($row, $allFees, $paymentTypeId, $invoiceNo, $studentId, $paymentDate);
                }

                event(new UpdateStudentCredit($studentId));

                $this->importedCount++;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    private function processStudentPayments($row, $allFees, $paymentTypeId, $invoiceNo, $studentId, $paymentDate)
    {
        try {
            $amountMap = [
                1 => 'development_fee',
                2 => 'admission_fee',
                3 => 'tuition_fee',
                4 => 'class_absent_fee',
                5 => 'late_fee',
                6 => 're_admission_fee',
            ];

            $discountMap = [
                1 => 'discount_development_fee',
                2 => 'discount_admission_fee',
                3 => 'discount_tuition_fee',
                4 => 'discount_class_absent_fee',
                5 => 'discount_late_fee',
                6 => 'discount_re_admission_fee',
            ];

            $amount = (float)($row[$amountMap[$paymentTypeId]] ?? 0);
            $discount = (float)($row[$discountMap[$paymentTypeId]] ?? 0);
            $remarks = $row['remarks'] ?? null;
            $bankId = $row['bank_id'] ?? null;
            $bankCopy = $row['bank_copy'] ?? null;
            $paymentMethodId = self::DEFAULT_PAYMENT_METHOD_ID ?? null;

            // Create payment
            $payment = StudentPayment::create([
                'student_id' => $studentId,
                'invoice_no' => $invoiceNo,
                'payment_type_id' => $paymentTypeId,
                'payment_method_id' => $paymentMethodId,
                'bank_id' => checkEmpty($bankId),
                'bank_copy' => checkEmpty($bankCopy),
                'due_amount' => 0,
                'amount' => $amount,
                'discount_amount' => $discount,
                'available_amount' => $amount,
                'payment_date' => $paymentDate,
                'verify_payment' => 1,
                'remarks' => checkEmpty($remarks),
                'status' => 1,
            ]);

            $availableAmount = $amount;
            $payable = 0;

            foreach ($allFees as $feeDetails) {
                if ($availableAmount <= 0 && $discount <= 0) {
                    break;
                }

                // Apply discount
                if ($discount > 0) {
                    $applyDiscount = min($discount, $feeDetails->due_amount);
                    $feeDetails->discount_amount += $applyDiscount;
                    $feeDetails->due_amount -= $applyDiscount;
                    $feeDetails->payable_amount = $feeDetails->total_amount - $feeDetails->discount_amount;
                    $discount -= $applyDiscount;
                    $feeDetails->save();
                }

                // Apply amount
                if ($availableAmount > 0 && $feeDetails->due_amount > 0) {
                    $payable = min($availableAmount, $feeDetails->due_amount);
                    $availableAmount -= $payable;

                    // Create payment detail
                    $payment->studentPaymentDetails()->create([
                        'student_fee_id' => $feeDetails->student_fee_id,
                        'student_fee_detail_id' => $feeDetails->id,
                        'amount' => $payable,
                        'status' => 1,
                    ]);

                    //update fee details
                    $feeDetails->due_amount -= $payable;
                    $feeDetails->status = $feeDetails->due_amount == 0 ? 1 : 2;
                    $feeDetails->save();

                    // Update fee summary
                    $fee = $feeDetails->fee;
                    $fee->discount_amount += $feeDetails->discount_amount;
                    $fee->paid_amount += $payable;
                    $fee->due_amount -= ($payable + $feeDetails->discount_amount);
                    $fee->payable_amount = $fee->total_amount - $fee->discount_amount;

                    $remainingDetails = StudentFeeDetail::where('student_fee_id', $feeDetails->student_fee_id)
                                                        ->where('status', '<>', 1)
                                                        ->count();
                    $fee->status = $remainingDetails == 0 ? 1 : 2;
                    $fee->save();

                    // Update due and available amount on payment
                    $payment->due_amount = $fee->due_amount;
                    $payment->available_amount = $availableAmount;
                    $payment->save();
                }
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }
}
