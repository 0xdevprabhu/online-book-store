<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Allows form submission only if admin is logged in
        return session()->has('admin_logged_in') && session('admin_logged_in') === true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title'        => 'required|string|max:255',
            'author'       => 'required|string|max:255',
            'price'        => 'required|numeric|min:0|max:999999.99', // According to database constraints
            'is_available' => 'required|boolean',                     // 1 or 0
            'description'  => 'nullable|string|max:2000',
            'category_id'  => 'nullable|exists:categories,id',        // Checks if category ID is valid, if category exists
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'title.required'        => 'Book title is required.',
            'author.required'       => 'Author name is required.',
            'price.required'        => 'Book price is required.',
            'price.numeric'         => 'Price must be numeric.',
            'price.min'             => 'Price cannot be less than 0.',
            'is_available.required' => 'Select availability of the book.',
        ];
    }
}