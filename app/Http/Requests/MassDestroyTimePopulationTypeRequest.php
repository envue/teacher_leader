<?php

namespace App\Http\Requests;

use App\Models\TimePopulationType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTimePopulationTypeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('time_population_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:time_population_types,id',
        ];
    }
}
