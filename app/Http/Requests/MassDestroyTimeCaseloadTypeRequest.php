<?php

namespace App\Http\Requests;

use App\Models\TimeCaseloadType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTimeCaseloadTypeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('time_caseload_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:time_caseload_types,id',
        ];
    }
}
