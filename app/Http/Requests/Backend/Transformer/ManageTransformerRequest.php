<?php

namespace App\Http\Requests\Backend\Transformer;

use Illuminate\Foundation\Http\FormRequest;

class ManageTransformerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return true;
        return access()->allow('manage-transformer');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'street_id' => 'required',
            'transformer_name' => 'required',
            'qrcode' => 'required',
        ];
    }
}
