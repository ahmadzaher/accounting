<?php

namespace App\Http\Requests;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreClientRequest extends FormRequest
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
            'phonenumber' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id'
        ];
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        $data = $this->input();
        $data['user_id'] = Auth::id();
        return $data;
    }
}
