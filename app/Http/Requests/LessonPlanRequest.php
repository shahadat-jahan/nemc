<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonPlanRequest extends FormRequest
{
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
        $inputMethod = $this->input('input_method', 'form');
        $isPdfUpload = $inputMethod === 'pdf';
        $isUpdate = $this->isMethod('put') || $this->isMethod('patch');

        // Base rules that apply to both methods
        $rules = [
            'title' => 'required|string|max:100',
            'speaker_id' => 'required|integer|exists:teachers,id',
            'input_method' => 'required|in:form,pdf',
        ];

        if ($isPdfUpload) {
            // When PDF is uploaded
            if ($isUpdate) {
                // On update, check if lesson plan has existing PDF
                $lessonPlanId = $this->route('id');
                $hasExistingPdf = false;

                if ($lessonPlanId) {
                    try {
                        $lessonPlan = \App\Models\LessonPlan::find($lessonPlanId);
                        if ($lessonPlan && $lessonPlan->pdf_file) {
                            $hasExistingPdf = file_exists(public_path($lessonPlan->pdf_file));
                        }
                    } catch (\Exception $e) {
                        // If can't find lesson plan, assume no existing PDF
                    }
                }

                // Require PDF only if switching from form to PDF (no existing PDF)
                // If existing PDF exists, allow optional upload to replace it
                if ($hasExistingPdf) {
                    $rules['pdf_file'] = 'nullable|file|mimes:pdf|max:10240';
                } else {
                    // Switching from form to PDF or creating new PDF - PDF is required
                    $rules['pdf_file'] = 'required|file|mimes:pdf|max:10240';
                }
            } else {
                // On create, PDF is required
                $rules['pdf_file'] = 'required|file|mimes:pdf|max:10240';
            }
            // Keep basic fields required for relations and future use
            $rules['audience'] = 'required|string|max:100';
            // Make time fields optional for PDF mode
            $rules['start_time'] = 'nullable';
            $rules['end_time'] = 'nullable';
        } else {
            // When form is filled, require form fields
            $rules['audience'] = 'required|string|max:100';
            $rules['start_time'] = 'required';
            $rules['end_time'] = 'required';
            $rules['pdf_file'] = 'nullable|file|mimes:pdf|max:10240';
        }

        // Common optional fields
        $commonRules = [
            'date' => 'nullable|date',
            'place' => 'nullable|string|max:100',
            'duration' => 'nullable|string|max:100',
            'method_of_instruction' => 'nullable|string|max:100',
            'instructional_material' => 'nullable|string|max:100',
            'objectives' => 'nullable|string',
            'time_allocation' => 'nullable|json',
        ];

        return array_merge($rules, $commonRules);
    }
    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'The title is required.',
            'speaker_id.required' => 'The speaker is required.',
            'audience.required' => 'The audience is required.',
            'start_time.required' => 'The start time is required.',
            'end_time.required' => 'The end time is required.',
            'pdf_file.required' => 'The PDF file is required when uploading PDF.',
            'pdf_file.file' => 'The uploaded file must be a valid file.',
            'pdf_file.mimes' => 'The PDF file must be a PDF document.',
            'pdf_file.max' => 'The PDF file may not be greater than 10MB.',
            'input_method.required' => 'Please select an input method.',
            'input_method.in' => 'Invalid input method selected.',
            'date.date' => 'The date must be a valid date.',
            'place.max' => 'The place may not be greater than 100 characters.',
            'duration.max' => 'The duration may not be greater than 100 characters.',
            'method_of_instruction.max' => 'The method of instruction may not be greater than 100 characters.',
            'instructional_material.max' => 'The instructional material may not be greater than 100 characters.',
            'objectives.string' => 'The objectives must be a string.',
            'time_allocation.json' => 'The time allocation must be a valid JSON string.',
        ];
    }
}
