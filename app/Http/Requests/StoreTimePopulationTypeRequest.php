<?php

namespace App\Http\Requests;

use App\Models\TimePopulationType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTimePopulationTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('time_population_type_create');
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
