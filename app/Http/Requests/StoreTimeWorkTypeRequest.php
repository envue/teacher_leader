<?php

namespace App\Http\Requests;

use App\Models\TimeWorkType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTimeWorkTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('time_work_type_create');
    }

    public function rules()
    {
        return [
            'name'        => [
                'string',
                'required',
            ],
            'description' => [
                'string',
                'nullable',
            ],
            'color'       => [
                'string',
                'max:7',
                'nullable',
            ],
        ];
    }
}
