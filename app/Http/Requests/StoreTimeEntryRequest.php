<?php

namespace App\Http\Requests;

use App\Models\TimeEntry;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTimeEntryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('time_entry_create');
    }

    public function rules()
    {
        return [
            'start_time'   => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
            ],
            'end_time'     => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
            ],
            'work_type_id' => [
                'required',
                'integer',
            ],
            'description'  => [
                'string',
                'nullable',
            ],
        ];
    }
}
