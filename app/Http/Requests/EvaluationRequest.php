<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EvaluationRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'enseignant_id' => 'required|exists:enseignants,id',
            'coefficient' => 'required|numeric|min:1|max:10',
            'type' => 'required|string|max:100',
            'note_max' => 'required|numeric|min:1',
            'statut' => 'required|in:brouillon,validee',
            'date_evaluation' => 'required|date',
            'libelle' => 'nullable|string|max:255',
            'periode_id' => 'required|exists:periodes,id',
        ];
    }
}
