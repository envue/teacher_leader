<?php

namespace App\Http\Requests;

use App\Models\TimePopulationType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTimePopulationTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('time_population_type_edit');
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
