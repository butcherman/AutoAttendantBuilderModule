<?php

namespace Modules\AutoAttendantBuilderModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlowChartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'node_data' => 'required|array',
            'uuid'      => 'string|nullable',
        ];
    }
}
