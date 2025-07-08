<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreEntryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'required|string|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
            'date' => 'required|date',
            'origin' => 'nullable|string|in:salary,investment,gift,other|required_if:type,income|prohibited_if:type,expense',
            'category' => 'nullable|string|in:food,transport,entertainment,bills,health,clothing,education,other|required_if:type,expense|prohibited_if:type,income',
        ];
    }
}
