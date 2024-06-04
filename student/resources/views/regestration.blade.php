<!-- resources/views/registration.blade.php -->

<form method="POST" action="{{ route('register.submit') }}">
    @csrf

    <div>
        <label for="document">Select Document:</label>
        <select id="document" name="document">
            @foreach ($documents as $document)
                <option value="{{ $document->id }}">{{ $document->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name">
    </div>

    <div>
        <label for="student_id">Student ID:</label>
        <input type="text" id="student_id" name="student_id">
    </div>

    <!-- Additional fields based on the selected document -->
    <div id="additional-fields" style="display: none;">
        <div id="internship-fields" class="additional-fields">
            <div>
                <label for="company_name">Company Name:</label>
                <input type="text" id="company_name" name="company_name">
            </div>
            <div>
                <label for="internship_duration">Internship Duration:</label>
                <input type="text" id="internship_duration" name="internship_duration">
            </div>
        </div>
        <div id="other-document-fields" class="additional-fields">
            <div>
                <label for="other_field">Other Field:</label>
                <input type="text" id="other_field" name="other_field">
            </div>
        </div>
    </div>

    <div>
        <button type="submit">Register</button>
    </div>
</form>

<script>
    // JavaScript code to show/hide additional fields based on the selected document

    document.getElementById('document').addEventListener('change', function () {
        var documentId = this.value;

        // Hide all additional fields
        var additionalFields = document.getElementsByClassName('additional-fields');
        for (var i = 0; i < additionalFields.length; i++) {
            additionalFields[i].style.display = 'none';
        }

        // Show the additional fields for the selected document
        if (documentId === '1') {
            document.getElementById('internship-fields').style.display = 'block';
        } else if (documentId === '2') {
            document.getElementById('other-document-fields').style.display = 'block';
        }
    });
</script>