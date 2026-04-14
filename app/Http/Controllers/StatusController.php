<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentFee;
use App\Models\StudentFeeDetail;
use App\Models\StudentPayment;
use App\Models\StudentPaymentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{

//        ALTER TABLE `student_payment_details` DROP FOREIGN KEY `student_payment_details_student_fee_detail_id_foreign`;
//
//        ALTER TABLE `student_payment_details` ADD CONSTRAINT `student_payment_details_student_fee_detail_id_foreign` FOREIGN KEY (`student_fee_detail_id`) REFERENCES `student_fee_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
//
//
//        ALTER TABLE `student_payment_details` DROP FOREIGN KEY `student_payment_details_student_fee_detail_id_foreign`;
//
//        ALTER TABLE `student_payment_details` ADD CONSTRAINT `student_payment_details_student_fee_detail_id_foreign` FOREIGN KEY (`student_fee_detail_id`) REFERENCES `student_fee_details` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
//
//
//        ALTER TABLE `student_payment_details` DROP FOREIGN KEY `student_payment_details_student_fee_id_foreign`;
//
//        ALTER TABLE `student_payment_details` ADD CONSTRAINT `student_payment_details_student_fee_id_foreign` FOREIGN KEY (`student_fee_id`) REFERENCES `student_fees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
//
//
//        ALTER TABLE `student_payment_details` DROP FOREIGN KEY `student_payment_details_student_fee_id_foreign`;
//
//        ALTER TABLE `student_payment_details` ADD CONSTRAINT `student_payment_details_student_fee_id_foreign` FOREIGN KEY (`student_fee_id`) REFERENCES `student_fees` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
//

    public function removeFee(){
         $data=DB::select("Select * FROM `student_fees` GROUP BY `student_id`,`title` HAVING COUNT(`id`)>1");
         if(!empty($data)){
             foreach($data as $value){
                    DB::select("DELETE FROM `student_fee_details` WHERE `student_fee_id`=$value->id");
                    DB::select("DELETE FROM `student_fees` WHERE `id`=$value->id");
                 }
         }
         echo "<pre>";
         print_r($data);
         echo "</pre>";
    }

//    public function remove_fee_extra(){
//        $data=DB::select("Select * FROM `students` WHERE `session_id`=3");
//        if(!empty($data)) {
//            foreach ($data as $value) {
//                $data1=DB::select("Select * FROM `student_fees` WHERE `student_id`=$value->id AND `title`='Tuition fee of September, 2021'");
//                if(!empty($data1)) {
//                    foreach ($data1 as $value1) {
//                        DB::select("DELETE FROM `student_fee_details` WHERE `student_fee_id`=$value1->id");
//                        DB::select("DELETE FROM `student_fees` WHERE `id`=$value1->id");
//                    }
//                }
//            }
//        }
//        echo "Done";
//    }



    public function developmentFeeUpdate() {
        $studentList = Student::where('session_id', 6)->where('student_category_id', 2)->where('course_id', 1)->get();

        DB::beginTransaction();
        try {
            $newDevelopmentFee = 42000;
            foreach ($studentList as $student) {
                $studentFee = StudentFee::where('student_id', $student->id)->get();
                foreach ($studentFee as $fee) {
                    $newStudentFee = StudentFee::where('id', $fee->id)->update([
                        'total_amount'=> $newDevelopmentFee,
                        'discount_amount'=> $fee->discount_amount,
                        'payable_amount'=> $newDevelopmentFee - $fee->discount_amount ?? 0,
                        'paid_amount'=> $fee->paid_amount,
                        'due_amount'=> $newDevelopmentFee - $fee->paid_amount,
                    ]);
                    $studentFeeDetails = StudentFeeDetail::where('student_fee_id', $fee->id)->get();
                    foreach ($studentFeeDetails as $feeDetails) {
                        $newStudentFeeDetails = StudentFeeDetail::where('id', $feeDetails->id)->update([
                            'total_amount'=> $newDevelopmentFee,
                            'discount_amount'=> $feeDetails->discount_amount ?? 0,
                            'payable_amount'=> $newDevelopmentFee - $feeDetails->discount_amount ?? 0,
                            'due_amount'=> $newDevelopmentFee - $fee->paid_amount,
                        ]);
                    }
                }
                $studentPayment = StudentPayment::where('student_id', $student->id)->get();
                $newDevelopmentFeeTemp = $newDevelopmentFee;
                foreach ($studentPayment as $payment) {
                    $newStudentPayment = StudentPayment::where('id', $payment->id)->update([
                        'due_amount'=> $newDevelopmentFeeTemp,
                        'amount'=> $payment->amount,
                        'discount_amount'=> $payment->discount_amount,
                        'available_amount'=> $payment->available_amount,
                    ]);
                    $newDevelopmentFeeTemp = $newDevelopmentFeeTemp - $payment->amount;
                    $studentPaymentDetails = StudentPaymentDetail::where('student_payment_id', $payment->id)->get();
                    foreach ($studentPaymentDetails as $paymentDetail) {
                        $newStudentPaymentDetails = StudentPaymentDetail::where('id', $paymentDetail)->update([
                            'amount'=> $paymentDetail->amount,
                        ]);
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            dd($e);
        }

        dd($studentList);
    }

}
