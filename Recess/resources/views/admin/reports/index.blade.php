@extends('layouts.admin')

@section('content')
<div class="text-center">
    <h1>Reports</h1>
  </div>
<div class="row justify-content-center align-items-center">

  <div class="col-sm-6 mb-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Loan Performance Reports</h5>
        <p class="card-text">Get a high level overview 0r summary of the Uprise Sacco Performance</p>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loanModal">
          View Report
        </button>
      </div>
    </div>
  </div>
  <div class="col-sm-6 mb-4">
    <div class="card" >
      <div class="card-body">
        <h5 class="card-title">Deposit Performance Reports</h5>
        <p class="card-text">Unlocking Insights: Exploring Deposit Performance Reports</p>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#depositmodal">
          View Report
        </button>
      </div>
    </div>
  </div>
   <!-- <hr> -->
    

    <div class="row">
      <h2>Loans</h2>
        <div class="col-sm-12 col-md-6">
            <div class="card p-2">
                <h3>{{ $total_loaned_memb[0]->total_members ?? 'N/A' }} </h3>
                <p class="text-muted">Granted Loans</p>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
        <div class="card p-2">
            <h3>Ugx {{ $total_loan_req[0]->total_loans_requested ?? 'N/A' }}</h3>
            <p class="text-muted">Total Granted Loan amount</p>
        </div>
    </div>

    <div class="row">
      <h3>Deposit</h3>
        <div class="col-sm-12 col-md-6">
            <div class="card p-2">
                <h3>{{ $member_count ?? 'N/A' }} </h3>
                <p class="text-muted"> Deposits Made </p>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
        <div class="card p-2">
            <h3>Ugx {{ $total_contribution ?? 'N/A' }}</h3>
            <p class="text-muted">Total Deposit Amounts</p>
        </div>
    </div>
    

 <!-- Accordions -->
 

<div class="accordion mt-3" style="background-color: white;" id="accordionPanelsStayOpenExample">
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
        <h5>Active Unpaid Accepted Loans<span class="btn btn-info" style="border-radius:50%;">{{count($unpaid_loans)}}</span></h5>  
      </button>
    </h2>
    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
      <div class="accordion-body">
        <table id="dataTable" class="table table-striped table-hover table-light">
        <thead>
            <tr>
                <th>Aplication No.</th>
                <th scope="col">ClientId</th>
                <th scope="col">Full Name</th>
                <!-- <th scope="col">Phone Number</th> -->
                <th scope="col">Requested Amount</th>
                <th scope="col">Amount + Interests</th>
                <th scope="col">Cleared Amount</th>

                <th scope="col">Balance</th>

                <th scope="col">Progress Status(%)</th>
                <th scope="col">End Date</th>
                <th scope="col">Payment Period</th>
                <th scope="col">Action</th>



                
            </tr>
        </thead>
        <tbody>
          @foreach ($unpaid_loans as $unpaid_loan)
           <tr>
            <td>{{ $unpaid_loan->loan_application_no }}</td>
            <td>{{ $unpaid_loan->client_id}}</td>
            <td>{{ $unpaid_loan->clientName }}</td>
            <!-- <td>{{ $unpaid_loan->phone_number }}</td> -->
            <td>{{ $unpaid_loan->loan_request_amount }}</td>
            <td>{{ $unpaid_loan->amount }}</td>
            <td>{{ $unpaid_loan->clearance_status }}</td>


            <td>{{ ($unpaid_loan->amount)-($unpaid_loan->loan_request_amount) }}</td>

            <td>{{ $unpaid_loan->loan_progress_status }}</td>
            <td>{{ $unpaid_loan->end_date }}</td>
            <td>{{ $unpaid_loan->payment_period }}</td>
            <td>
    <a href="tel:{{ $unpaid_loan->phone_number }}"  style="font-size: 14px;" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $unpaid_loan->phone_number }}">
        <i class="fa fa-phone" aria-hidden="true"></i> Call
    </a>
</td>

          @endforeach
           </tr>
        </tbody>
        <tfoot>
            <tr style="color: blue ;" >
            <td colspan="3"><strong>SUMMARY</strong></td>
            <td><strong>{{$loan_request_amounts}}</strong></td>
            <td><strong>{{$total_to_pay}}</strong></td>
            <td><strong>{{$cleared_yet}}</strong></td>
            <td><strong>{{ $bal }}</strong></td>
            <td colspan="5"><strong>{{ (100-(($bal)/($total_to_pay))*100) }}</strong></td>
          </tr>
          <tr style="color: red ;" >
            <td colspan="7"><strong>Expected Profits</strong></td>
            
            <td colspan="5"><strong>{{ $total_to_pay-$loan_request_amounts }}</strong></td>
          </tr>
          
        </tfoot>
    </table>
      </div>
    </div>
  </div>
  
</div>



  <!-- Add similar cards for other sections -->
@include('admin.partials.depositmodal')
@include('admin.partials.loan_performance_modal')
</div>
@endsection
