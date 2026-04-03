<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
        $studentId = $this->route('id');

        return [
            'nom' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\s\-]+$/',
            'prenom' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ\s\-]+$/',
            'date_naissance' => 'required|date|before:today|after:2000-01-01',
            'email' => [
                'required',
                'email',
                'max:255',
                \Illuminate\Validation\Rule::unique('students')->ignore($studentId),
            ],
            'phone' => 'required|string|regex:/^[\+]?[0-9\-\(\)\s]+$/|max:20',
            'sexe' => 'required|in:M,F,Homme,Femme',
            'address' => 'required|string|max:500',
            'parent_id' => 'nullable|exists:parents,id',
            'parent_nom' => 'required_without:parent_id|string|max:255',
            'parent_prenom' => 'required_without:parent_id|string|max:255',
            'parent_telephone' => 'required_without:parent_id|string|max:20',
            'parent_email' => 'nullable|email|max:255',
            'parent_adresse' => 'required_without:parent_id|string|max:255',
            'relation' => 'required|in:mere,pere,frere,soeur,tuteur',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nom.regex' => 'Le nom ne doit contenir que des lettres.',
            'prenom.regex' => 'Le prénom ne doit contenir que des lettres.',
            'phone.regex' => 'Le format du numéro de téléphone est invalide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'date_naissance.before' => 'La date de naissance doit être antérieure à aujourd\'hui.',
            'date_naissance.after' => 'La date de naissance doit être postérieure à 2000-01-01.',
            'parent_id.exists' => 'Le parent sélectionné n\'existe pas.',
            'relation.in' => 'La relation sélectionnée est invalide.',
            'photo.image' => 'Le fichier doit être une image.',
            'photo.mimes' => 'Le fichier doit être au format JPEG, PNG, JPG ou GIF.',
            'photo.max' => 'Le fichier ne doit pas dépasser 2 Mo.',
            'address.max' => 'L\'adresse ne doit pas dépasser 500 caractères.',
            'address.required' => 'L\'adresse est requise.',
            'sexe.in' => 'Le sexe doit être M, F, Homme ou Femme.',
            'sexe.required' => 'Le sexe est requis.',
            'phone.max' => 'Le numéro de téléphone ne doit pas dépasser 20 caractères.',
            'phone.required' => 'Le numéro de téléphone est requis.',
            'email.max' => 'L\'email ne doit pas dépasser 255 caractères.',
            'email.required' => 'L\'email est requis.',
            'email.email' => 'L\'email doit être un email valide.',
            'date_naissance.max' => 'La date de naissance doit être antérieure à aujourd\'hui.',
            'date_naissance.required' => 'La date de naissance est requise.',
            'prenom.max' => 'Le prénom ne doit pas dépasser 255 caractères.',
            'prenom.required' => 'Le prénom est requis.',
            'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'nom.required' => 'Le nom est requis.',
   
        ];
    }
}
