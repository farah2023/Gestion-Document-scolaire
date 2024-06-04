<?php

// app/Http/Controllers/RegistrationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;

class RegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        // Retrieve the documents from the database
        $documents = Document::all();

        return view('registration', compact('documents'));
    }

    public function register(Request $request)
    {
        // Process the form submission
        // Retrieve the selected document ID from the request
        $documentId = $request->input('document');

        // Retrieve the document details from the database
        $document = Document::findOrFail($documentId);

        // Retrieve other required fields based on the selected document

        // Example fields: name and ID
        $name = $request->input('name');
        $studentId = $request->input('student_id');

        // Additional fields based on the selected document
        $additionalFields = $request->except('_token', 'document', 'name', 'student_id');

        // Save the student's information to the database or perform any other necessary actions

        return redirect()->back()->with('success', 'Student registered successfully!');
    }
}
