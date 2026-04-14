<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentDetailRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //$query = PaymentDetail::where('payment_type_id', $request->payment_type_id)->where('student_category_id', $request->student_category_id)->where('course_id', $request->course_id);
        if ($this->request->has('payment_type_id') and $this->request->has('student_category_id') and $this->request->has('course_id')){
            $paymentTypeId = $this->payment_type_id;
            $studentCategoryId = $this->course_id;
            $courseId = $this->course_id;
            $paymentDetailId = isset($this->payment_detail) ? $this->payment_detail : '';
        }
        if (Request::isMethod('post')){
            return [
                //payment_type_id unique for current student_category_id and student_category_id and so on
                'payment_type_id' => [
                    'required',
                    Rule::unique('payment_details')->where(function ($query) use($paymentTypeId, $studentCategoryId, $courseId) {
                        return $query->where('payment_type_id', $paymentTypeId)
                            ->where('student_category_id', $studentCategoryId)
                            ->where('course_id', $courseId);
                    }),
                ],
                'student_category_id' => [
                    'required',
                    Rule::unique('payment_details')->where(function ($query) use($paymentTypeId, $studentCategoryId, $courseId) {
                        return $query->where('payment_type_id', $paymentTypeId)
                            ->where('student_category_id', $studentCategoryId)
                            ->where('course_id', $courseId);
                    }),
                ],
                'course_id' => [
                    'required',
                    Rule::unique('payment_details')->where(function ($query) use($paymentTypeId, $studentCategoryId, $courseId) {
                        return $query->where('payment_type_id', $paymentTypeId)
                            ->where('student_category_id', $studentCategoryId)
                            ->where('course_id', $courseId);
                    }),
                ],
                'amount' => 'required',
                'currency_code' => 'required',
            ];
        }else{

            return [
                //payment_type_id unique for current student_category_id and student_category_id and so on
                'payment_type_id' => [
                    'required',
                    Rule::unique('payment_details')->where(function ($query) use($paymentTypeId, $studentCategoryId, $courseId, $paymentDetailId) {
                        return $query->where('payment_type_id', $paymentTypeId)
                            ->where('student_category_id', $studentCategoryId)
                            ->where('course_id', $courseId)
                            ->where('id', '<>', $paymentDetailId);
                    }),
                ],
                'student_category_id' => [
                    'required',
                    Rule::unique('payment_details')->where(function ($query) use($paymentTypeId, $studentCategoryId, $courseId, $paymentDetailId) {
                        return $query->where('payment_type_id', $paymentTypeId)
                            ->where('student_category_id', $studentCategoryId)
                            ->where('course_id', $courseId)
                            ->where('id', '<>', $paymentDetailId);
                    }),
                ],
                'course_id' => [
                    'required',
                    Rule::unique('payment_details')->where(function ($query) use($paymentTypeId, $studentCategoryId, $courseId, $paymentDetailId) {
                        return $query->where('payment_type_id', $paymentTypeId)
                            ->where('student_category_id', $studentCategoryId)
                            ->where('course_id', $courseId)
                            ->where('id', '<>', $paymentDetailId);
                    }),
                ],
                'amount' => 'required',
                'currency_code' => 'required',
            ];
        }

    }

    public function messages()
    {
        return [
            'payment_type_id.required' => 'Payment type is required',
            'payment_type_id.unique' => 'Amount already exist for this payment type, student category & course',
            'student_category_id.required' => 'Student category is required',
            'student_category_id.unique' => 'Amount already exist for this payment type, student category & course',
            'course_id.required' => 'Course is required',
            'course_id.unique' => 'Amount already exist for this payment type, student category & course',
            'currency_code.required' => 'Currency is required',
        ];
    }
}
