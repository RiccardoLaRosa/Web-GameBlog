<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
            'tag' => 'nullable|array',
            'tag.*' => 'exists:tags,id',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Inserisci il titolo.',
            'title.max' => 'Il titolo è troppo lungo.',
            'description.required' => 'Inserisci la descrizione.',
            'image.image' => "Il file deve essere un'immagine.",
            'image.max' => "L'immagine non può superare i 2 MB.",
            'category_id.required' => 'Seleziona una categoria.',
            'category_id.exists' => 'La categoria selezionata non esiste.',
            'tag.*.exists' => 'Uno dei tag selezionati non esiste.',
        ];
    }
}
