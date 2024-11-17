<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionaryFormRequest;
use Illuminate\Http\Request;

class QuestionaryFormController extends Controller
{
    public function getFormFields()
    {
        return response()->json([
            'fields' => [
                ['name' => 'lastName', 'type' => 'text', 'label' => 'Прізвище', 'required' => true],
                ['name' => 'firstName', 'type' => 'text', 'label' => 'Ім’я', 'required' => true],
                ['name' => 'gender', 'type' => 'select', 'label' => 'Стать', 'required' => true, 'options' => ['Чоловік', 'Жінка']],
                ['name' => 'dateOfBirth', 'type' => 'date', 'label' => 'Дата народження', 'required' => true],
                ['name' => 'organization', 'type' => 'text', 'label' => 'Організація', 'required' => true],
                ['name' => 'position', 'type' => 'text', 'label' => 'Посада', 'required' => true],
                ['name' => 'email', 'type' => 'email', 'label' => 'Пошта', 'required' => true],
                ['name' => 'phoneNumber', 'type' => 'text', 'label' => 'Номер телефону', 'required' => true],
                ['name' => 'document', 'type' => 'text', 'label' => 'Серія та номер документу', 'required' => false],
            ],
            'rules' => (new QuestionaryFormRequest())->rules(),
            'messages' => (new QuestionaryFormRequest())->messages(),
        ]);
    }

    public function submitForm(QuestionaryFormRequest $request)
    {
        // Get validated data
        $validatedData = $request->validated();

        // Generate a unique filename (e.g., timestamped)
        $filename = 'form_submission_' . now()->timestamp . '.json';

        // Save the data to storage/app/form_submissions/<filename>.json
        \Storage::disk('local')->put(
            'form_submissions/' . $filename,
            json_encode($validatedData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        // Return a success response
        return response()->json([
            'message' => 'Form submitted successfully!',
            'data' => $validatedData,
        ], 200);
    }
}
