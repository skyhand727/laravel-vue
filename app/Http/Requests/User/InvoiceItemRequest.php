<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\BadRequestErrorResponseException;

class InvoiceItemRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $id = $this->route('invoiceitem');
        // store
        if(empty($id)) {
            return [
                'invoice_id' => 'exists:invoices,id|numeric',
                'name' => 'required|max:50',
                'quantity' => 'required|numeric',
                'unit' => 'required|max:50',
                'price' => 'required|numeric',
                'total' => 'required|numeric',
                'sort_order' => 'required|numeric',
            ];
        }
        // update
        return [
            'name' => 'max:50',
            'quantity' => 'numeric',
            'unit' => 'max:50',
            'price' => 'numeric',
            'total' => 'numeric',
            'sort_order' => 'numeric',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new BadRequestErrorResponseException(
            response()->json($validator->errors(), 400)
        );
    }
}
