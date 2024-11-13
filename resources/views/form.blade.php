<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold text-center mb-8">Registration Form</h1>

        <!-- Accessibility improvement: Added aria-live="assertive" for screen reader announcements -->
        <div id="alert-box" class="hidden p-4 mb-4 rounded-lg" role="alert" aria-live="assertive"></div>

        <form id="registrationForm" class="max-w-lg mx-auto bg-white p-8 rounded shadow">
            @csrf
            <div class="mb-4">
                <label for="name" class="block font-bold">Name</label>
                <input type="text" id="name" name="name" class="w-full p-2 border border-gray-300 rounded"
                    required>
            </div>
            <div class="mb-4">
                <label for="country_code" class="block font-bold">Country Code</label>
                <input type="text" id="country_code" name="country_code"
                    class="w-full p-2 border border-gray-300 rounded" required placeholder="+1">
            </div>
            <div class="mb-4">
                <label for="mobile" class="block font-bold">Mobile</label>
                <input type="text" id="mobile" name="mobile" class="w-full p-2 border border-gray-300 rounded"
                    required>
            </div>
            <div class="mb-4">
                <label for="email" class="block font-bold">Email</label>
                <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded"
                    required>
            </div>
            <div class="mb-4">
                <label for="gender" class="block font-bold">Gender</label>
                <select id="gender" name="gender" class="w-full p-2 border border-gray-300 rounded" required>
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded" id="submit-btn">Submit</button>

            <!-- Loading Spinner -->
            <div id="spinner" class="hidden flex justify-center items-center mt-4">
                <div class="w-8 h-8 border-t-4 border-blue-500 border-solid rounded-full animate-spin"></div>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#registrationForm').on('submit', function(event) {
                event.preventDefault();

                // Show the loading spinner and hide the submit button
                $('#spinner').removeClass('hidden');
                $('#submit-btn').attr('disabled', true);

                $.ajax({
                    url: "{{ route('register.submit') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#alert-box')
                                .removeClass('hidden')
                                .addClass('bg-green-100 text-green-800')
                                .text(response.message);
                        }
                        // Hide spinner and enable the submit button
                        $('#spinner').addClass('hidden');
                        $('#submit-btn').attr('disabled', false);
                        $('#registrationForm')[0].reset();
                        
                    },
                    error: function(xhr) {
                        var errorMessage = 'Error occurred. Please try again.';
                        if (xhr.status === 422) { // If validation errors occurred
                            var errors = xhr.responseJSON.errors;
                            errorMessage = '';
                            $.each(errors, function(key, value) {
                                errorMessage += value.join(' ') + ' ';
                            });
                        }
                        // Hide spinner and enable the submit button
                        $('#spinner').addClass('hidden');
                        $('#submit-btn').attr('disabled', false);
                        $('#alert-box')
                            .removeClass('hidden')
                            .addClass('bg-red-100 text-red-800')
                            .text(errorMessage);

                    }
                });
            });
        });
    </script>
</body>

</html>
