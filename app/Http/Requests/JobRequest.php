<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:35|min:3',
            'type' => 'required|string',
            'description' => 'required|string|max:1000',
            'skills' => 'required|string',
            'qualifications' => 'nullable|string|max:600|min:3',
            'salary' => 'nullable|integer',
            'salary_interval' => 'required_with:salary|nullable|string',
            'close_date' => 'required|string',
            'close_time' => 'nullable|integer',
            'user_id'   => 'required|integer',
            'companyName'   => 'required|string'
        ];
    }
}
