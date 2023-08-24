@extends('layouts.admin')

@section('content')
    <!-- Required JS and CSS for tooltip-->
    <!-- Add these links to your HTML's <head> section -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->


    <h1>Deposits</h1>
    <div class="row mt-3">
        <div class="col-sm-12 col-md-4">
            <div class="card p-2">
                <h1>{{ count($member_count) }}</h1>
                <p class="text-muted">Registered Deposits Made</p>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="card p-2">
                <h1>Ugx {{$sum_deposit}} </h1>
                <p class="text-muted">Total Deposists</p>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#makeDeposit">Make deposit</button>
        </div>
    </div>
    @include('admin.deposits.depositmodal')
    <div class="text-center mt-4">
            <h2     ><strong>Upload CSV's</strong></h2>
        </div>
    <div class="card mt-3">
        <div class="card-body">
            <div class="row mt-3">        
        <div class="col-md-6">
            <div class="">
                <h4 class="text-left mt-4">Upload Deposit CSV</h4>
                <div class="row align-items-center justify-content-center mt-4">
                    <div class="col-md-12">
                        <form action="{{ route('upload.csv') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="p-1 dotted h-100 d-flex align-items-center btn btn-outline-danger justify-content-center rounded-5" style="width: 100%;" id="uploadSection">
                                <div id="uploadContent"> 
                                    <label class="text-center">
                                        <input required id="fileInput" class="text-center text-primary" accept=".csv" type="file" name="csv_file" style="display: none;">
                                        <span class="btn ">
                                            <h3 class="text-center">Choose CSV file</h3>
                                            <p class="text-muted text-xl text-center">
                                                <i class="feather-upload text-4xl"></i>
                                            </p>
                                        </span>
                                    </label>
                                </div>
                                <div id="fileDisplay" style="display: none;">
                                    <p id="fileName" class="text-center">No file chosen</p>
                                    <img id="fileImage" class="img-fluid mx-auto d-block" style="max-height: 100px; display: none;">
                                </div>
                            </div>
                            <div class="mt-3 d-flex justify-content-end align-items-center gap-2">
                                <button id="cancelButton" type="button" class="btn btn-outline-info shadow-sm" style="display: none;">Cancel</button>
                                <div class="d-flex align-items-center">
                                    <button id="uploadButton" type="submit" class="btn btn-outline-primary text shadow-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Please choose a CSV file first.">Upload CSV</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="">
                <h4 class="text-left mt-4">Upload Deposit CSV</h4>
                <div class="row align-items-center justify-content-center mt-4">
                    <div class="col-md-12">
                        <form action="{{ route('uploadloan.csv') }}" method="POST" enctype="multipart/form-data" >
                            @csrf
                            <div class="p-1 dotted h-100 d-flex align-items-center btn btn-outline-danger justify-content-center rounded-5" style="width: 100%;" id="uploadSection">
                                <div id="uploadContent"> 
                                    <label class="text-center">
                                        <input required id="fileInput" class="text-center text-primary" accept=".csv" type="file" name="csv_file" style="display: none;">
                                        <span class="btn ">
                                            <h3 class="text-center">Choose CSV file</h3>
                                            <p class="text-muted text-xl text-center">
                                                <i class="feather-upload text-4xl"></i>
                                            </p>
                                        </span>
                                    </label>
                                </div>
                                <div id="fileDisplay" style="display: none;">
                                    <p id="fileName" class="text-center">No file chosen</p>
                                    <img id="fileImage" class="img-fluid mx-auto d-block" style="max-height: 100px; display: none;">
                                </div>
                            </div>
                            <div class="mt-3 d-flex justify-content-end align-items-center gap-2">
                                <button id="cancelButton" type="button" class="btn btn-outline-info shadow-sm" style="display: none;">Cancel</button>
                                <div class="d-flex align-items-center">
                                    <button id="uploadButton" type="submit" class="btn btn-outline-primary text shadow-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Please choose a CSV file first.">Upload CSV</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- -->

        
    </div>
        </div>
    </div>
    
    
</div>

    

    <!-- JS Script to render file image and name -->
    <script>
    const fileInput = document.getElementById('fileInput');
    const fileDisplay = document.getElementById('fileDisplay');
    const fileName = document.getElementById('fileName');
    const fileImage = document.getElementById('fileImage');
    const uploadContent = document.getElementById('uploadContent');
    const cancelButton = document.getElementById('cancelButton');
    const uploadButton = document.getElementById('uploadButton');
    let uploadStatus = false;

    fileInput.addEventListener('change', function () {
        if (fileInput.files.length > 0) {
            const selectedFile = fileInput.files[0];
            fileName.textContent = selectedFile.name;

            const imageSrc = '{{ asset("images/csv.png") }}'; // Replace with your image's actual path
            fileImage.src = imageSrc;
            fileImage.style.display = 'block';
            fileDisplay.style.display = 'block';
            uploadContent.style.display = 'none';
            uploadStatus = true;
            cancelButton.style.display = 'block'; // Show the Cancel button
        } else {
            fileName.textContent = 'No file chosen';
            fileImage.style.display = 'none';
            cancelButton.style.display = 'none'; // Hide the Cancel button
            uploadStatus = false;
        }
        
        // Reset the data-bs-toggle attribute based on uploadStatus
        if (!uploadStatus) {
            uploadButton.setAttribute('data-bs-toggle', 'tooltip');
        } else {
            uploadButton.setAttribute('data-bs-toggle', '');
        }
    });

    cancelButton.addEventListener('click', function () {
        fileInput.value = ''; // Clear the selected file
        fileName.textContent = 'No file chosen';
        fileImage.style.display = 'none';
        cancelButton.style.display = 'none';
        uploadContent.style.display = 'block'; // Show the upload content
        uploadStatus = false;
    });

    // Add a click event listener to the Upload button to disable submission if uploadStatus is false
    uploadButton.addEventListener('click', function (event) {
        if (!uploadStatus) {
            event.preventDefault(); // Prevent form submission
        }
    });

    // Initialize Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>
@endsection

