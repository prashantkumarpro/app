<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\FormData;

class FormController extends Controller
{
    // Method to show the form
    public function showForm()
    {
        return view("form");
    }

    // Method to handle form submission
    // public function submitForm(Request $request)
    // {
    //     echo "<br>";
    //     print_r($request->all());
    //     return redirect()->back()->with('success', 'Form submitted successfully!');
    // }
    public function submitForm(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:255', // Only letters and spaces
            'country_code' => 'required|string|regex:/^\+?[1-9]{1}[0-9]{1,3}$/', // Valid country code: optional "+" and 1-4 digits
            'mobile' => 'required|string|regex:/^\+?[1-9]{1}[0-9]{1,14}$/', // Valid phone number with optional "+" and up to 15 digits
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('form_data', 'email'), // Ensure the email is unique in the 'form_data' table
            ],
            'gender' => 'required|in:male,female,other', // Ensure the gender is selected from the available options
        ]);
        FormData::create($validatedData);

        return response()->json(['success' => true, 'message' => 'Form submitted successfully']);
    }



}