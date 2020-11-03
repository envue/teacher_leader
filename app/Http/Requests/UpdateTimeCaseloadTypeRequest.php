<?php

namespace App\Http\Requests;

use App\Models\TimeCaseloadType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTimeCaseloadTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('time_caseload_type_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
        ];
    }
}
