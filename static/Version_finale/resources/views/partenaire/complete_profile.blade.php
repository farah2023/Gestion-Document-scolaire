@include('layouts.sidebar_par')
<style>
    .btn-custom {
        background-color: #ff6600; /* Custom color for the button */
        color: white; /* Text color */
        border: none; /* No border */
        padding: 10px 20px; /* Padding for the button */
        margin: 5px; /* Margin around the button */
        border-radius: 5px; /* Rounded corners for the button */
        font-size: 16px; /* Text size */
    }

    .btn-custom:hover {
        background-color: #cc5200; /* Darker shade for hover effect */
        color: white;
    }

    .form-buttons {
        display: flex;
        justify-content: space-between; /* Align buttons with space between */
    }
</style>
<section id="content">
    <!-- NAVBAR -->
    <nav>
        <i class='bx bx-menu'></i>
        <div style="margin-left: 800px;">
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center my-5">
            <div class="col-lg-6"> <!-- Central column for the form -->
                <div class="card border-primary shadow-lg">
                    <div class="card-header bg-primary text-white">Complete Your Profile by Adding Your Services</div>
                    <div class="card-body">
                        <form action="{{ route('complete_profile_par') }}" method="POST" id="profileForm">
                            @csrf

                            <div class="mb-3">
                                <label for="Service1" class="form-label">Service 1:</label>
                                <input type="text" class="form-control" id="Service1" name="Service1" value="">
                            </div>
                            <div class="mb-3">
                                <label for="creneau1" class="form-label">Availability Slot:</label>
                                <input type="text" class="form-control" id="creneau1" name="creneau1" value="">
                            </div>
                            <div class="mb-3">
                                <label for="prix1" class="form-label">Service Price:</label>
                                <input type="text" class="form-control" id="prix1" name="prix1" value="">
                            </div>

                            <div id="additionalFields"></div>

                            <div class="form-buttons">
                                <button type="button" id="addMoreFields" class="btn btn-custom">Add More</button>
                                <button type="submit" class="btn btn-custom">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var counter = 2;

            $('#addMoreFields').click(function() {
                var newFields = `
                    <div class="mb-3">
                        <label for="Service${counter}" class="form-label">Service ${counter}:</label>
                        <input type="text" class="form-control" id="Service${counter}" name="Service${counter}" value="">
                    </div>
                    <div class="mb-3">
                        <label for="creneau${counter}" class="form-label">Availability Slot:</label>
                        <input type="text" class="form-control" id="creneau${counter}" name="creneau${counter}" value="">
                    </div>
                    <div class="mb-3">
                        <label for="prix${counter}" class="form-label">Service Price:</label>
                        <input type="text" class="form-control" id="prix${counter}" name="prix${counter}" value="">
                    </div>
                `;
                $('#additionalFields').append(newFields);
                counter++;
            });
        });
    </script>
</section>
