<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreInvoiceRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'type' => 'required|integer',
            'description' => 'nullable|string',
            'client_id' => 'nullable|exists:clients,id',
        ];
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        $data = $this->input();
        return $data;
    }
}
