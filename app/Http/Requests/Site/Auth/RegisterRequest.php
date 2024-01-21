<?php

namespace App\Http\Requests\Site\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Custom messages for rules
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'surname.required'              => 'Поле должно быть заполнено',
            'firstName.required'            => 'Поле должно быть заполнено',
            'email.required'                => 'Поле должно быть заполнено',
            'phone.required'                => 'Поле должно быть заполнено',
            'personalAgreement.required'    => 'Поле должно быть заполнено',
            'region.required'               => 'Поле должно быть заполнено',
            'city.required'                 => 'Поле должно быть заполнено',
            'inn.required'                  => 'Поле должно быть заполнено',
            'bik.required'                  => 'Поле должно быть заполнено',
            'checkingAccount.required'      => 'Поле должно быть заполнено',
            'accountingEmail.required'      => 'Поле должно быть заполнено',
            'site.required'                 => 'Поле должно быть заполнено',
            'organisation.required'         => 'Поле должно быть заполнено',
            'agreement1.required'           => 'Поле должно быть заполнено',
            'agreement2.required'           => 'Поле должно быть заполнено',
            'agreement3.required'           => 'Поле должно быть заполнено',
            'agreement4.required'           => 'Поле должно быть заполнено',
            'phone.regex'                   => 'Минимальная длина 7, максимальная длина 12 символов',
            'email.email'                   => 'Неверный формат',
            'accountingEmail.email'         => 'Неверный формат',
            'inn.regex'                     => 'Некорректный формат ИНН',
            'bik.digits'                    => 'Необходимая длина 9 цифр',
            'checkingAccount.digits'        => 'Необходимая длина 20 цифр',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'surname'               => 'required',
            'firstName'             => 'required',
            'patronymic'            => 'nullable',
            'email'                 => 'required|email:rfc,dns',
            'phone'                 => 'required|regex:/^[\d+]{7,12}$/',
            'personalAgreement'     => 'required',
            'region'                => 'required',
            'city'                  => 'required',
            'inn'                   => ['required', 'regex:/^\d{10}$|^\d{12}$/'],
            'bik'                   => 'required|digits:9',
            'checkingAccount'       => 'required|digits:20',
            'accountingEmail'       => 'required|email',
            'site'                  => 'required',
            'agreement1'            => 'required',
            'agreement2'            => 'required',
            'agreement3'            => 'required',
            'agreement4'            => 'required',
            'organisation'          => 'required',
        ];
    }
}
