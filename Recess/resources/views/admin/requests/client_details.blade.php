@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <h1>Client Details</h1>
        <form  action="{{ route( 'admin.update_interest') }}"  method="post">
            @csrf    
        <!-- Personal Details -->
            <fieldset class="border p-3 mb-4">
                <legend class="w-auto">Personal Details</legend>
                <div class="form-group row">
                    <label for="clientName" class="col-md-2 col-form-label">Client Name :</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="clientName" value="{{ $client->clientName }}" readonly>
                    </div>
                    
                    <label for="phone" class="col-md-2 col-form-label">Phone Number :</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="phone" value="{{ $client->phone_number }}" readonly>
                    </div>
                </div>


                <div class="form-group">
                    <label for="email">Username :</label>
                    <input type="text" class="form-control" id="email" value="{{ $client->username }}" readonly>
                </div>
                
                <div class="form-group">
                    <label for="client_id">Client ID :</label>
                    <input type="text" class="form-control" name="client_id" id="client_id" value="{{ $client->id }}" readonly>
                </div>
                <!-- Add more personal details fields here -->
            </fieldset>

            <!-- Loan Status -->
            <fieldset class="border p-3 mb-4">
                <legend class="w-auto">Loan Status</legend>
                <div class="form-group">
                    <label for="loanProgress">Loan Application Number</label>
                    <input type="text" name="loan_application_no" class="form-control" id="loanProgress" value="{{ $client->loan_application_no }}" readonly>
                </div>
                <div class="form-group row">
                    <label for="clientName" class="col-md-2 col-form-label">Grant Status :</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="clientName" value="{{ $client->grant_status }}" readonly>
                    </div>
                    
                    <label for="phone" class="col-md-2 col-form-label">Loan Amount <em>(Shs.)</em>:</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="loanAmount" value="{{ $client->loan_request_amount !== null ? $client->loan_request_amount : 'null' }}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="loanAmount">Previous Average Loan Performance <em>(%)</em></label>
                        <input type="text" class="form-control" id="phone" value="{{ $client->loan_performance }}" readonly>
                </div>

                <div class="form-group row">
                    <label for="clientName" class="col-md-2 col-form-label">Submission Date :</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="clientName" value="{{ $client->req_sub_date }}" readonly>
                    </div>
                    <label for="clientName" class="col-md-2 col-form-label">Loan Month Request :</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="clientName" value="{{ $client->payment_period }}"  readonly>
                    </div>
                </div>
            </fieldset>
            <fieldset class="border p-3 mb-4">
                <legend class="w-auto">Set Interest Info</legend>
                <div class="form-group">
                    <label for="loanProgress">Interest Rate</label>
                    <input type="text" required class="form-control" name="interest" id="loanProgress" >
                </div>
                <div class="form-group row">
                    <label for="start_date" class="col-md-2 col-form-label">Start Date :</label>
                    <div class="col-md-4">
                        <input type="date" class="form-control" name="start_date" required id="start_date" >
                    </div>
                    
                    <label for="payment_period" class="col-md-2 col-form-label">Payment Period <em> (months)</em>:</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control"  value="{{ $client->payment_period }}" id="payment_period" name="payment_period" >
                    </div>
                </div>
                <button class="btn btn-primary">Save</button>               
            </fieldset>
            <div class="text-right">
                <a href="/admin/requests" class="btn btn-primary ml-2"><strong><<</strong>Back</a>
                
                <a href="#" class="btn btn-info ml-2">Top <strong>^</strong></a>
            </div>
        </form>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
