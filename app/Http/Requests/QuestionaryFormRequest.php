<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionaryFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'firstName' => 'required|string|regex:/^[a-zA-Zа-яА-ЯіІїЇєЄ]{3,}$/u|max:255',
            'lastName' => 'required|string|regex:/^[a-zA-Zа-яА-ЯіІїЇєЄ]{3,}$/u|max:255',
            'gender' => 'required|string|in:Чоловік,Жінка',
            'dateOfBirth' => 'required|date|before:today',
            'organization' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phoneNumber' => [
                'required',
                'string',
                'regex:/^\+380\d{9}$/',
            ],
            'document' => 'nullable|string|max:255',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'firstName.required' => 'Поле "Ім’я" є обов’язковим.',
            'firstName.regex' => 'Поле "Ім’я" має містити лише літери та бути довжиною не менше 3 символів.',
            'lastName.required' => 'Поле "Прізвище" є обов’язковим.',
            'lastName.regex' => 'Поле "Прізвище" має містити лише літери та бути довжиною не менше 3 символів.',
            'gender.required' => 'Поле "Стать" є обов’язковим.',
            'gender.in' => 'Поле "Стать" має бути "Чоловік" або "Жінка".',
            'dateOfBirth.required' => 'Поле "Дата народження" є обов’язковим.',
            'dateOfBirth.before' => 'Поле "Дата народження" не може бути в майбутньому.',
            'organization.required' => 'Поле "Організація" є обов’язковим.',
            'position.required' => 'Поле "Посада" є обов’язковим.',
            'email.email' => 'Поле "Пошта" має бути валідною електронною адресою.',
            'phoneNumber.required' => 'Поле "Номер телефону" є обов’язковим.',
            'phoneNumber.regex' => 'Поле "Номер телефону" має бути у форматі +380XXXXXXXXX.',
        ];
    }
}
