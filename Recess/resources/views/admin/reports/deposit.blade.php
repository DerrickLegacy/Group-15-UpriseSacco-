<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Loan Report</title>  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>  
</head>
<body class="vh-100 d-flex align-items-center justify-content-center">
    <div class="container">
        <form class="row g-3">
            <div class="col-12 text-center mb-4">
                <h1 class="modal-title" id="loanModalLabel">Uprise Sacco Deposit Performance Report {{ date('Y') . '/' . (date('Y') + 1) }}</h1>
            </div>
            <div class="col-md-6">
                <label for="loanAmount"><strong>Financial Year</strong></label>
                <input type="text" class="form-control" value="{{ date('Y') . '/' . (date('Y') + 1) }}" disabled aria-label="financialYear">
            </div>
            <div class="col-md-6">
                <label for="loanAmount"><strong>Deposit Or Contribution Target</strong></label>
                <input type="text" class="form-control" value="Shs. 1,200,000" disabled aria-label="financialYear">
            </div>
            <div class="col-md-6">
                <label for="loanAmount"><strong>Total  Deposits Made</strong></label>
                <input type="text" disabled class="form-control" value="Shs. {{ $total_contribution ?? 'N/A' }}"  aria-label="loanRepaid">
            </div>
            <div class="col-md-6">
                <label for="loanAmount"><strong>Average Deposit as of Target(Shs. 1,200,00)</strong></label>
                <input type="text" disabled class="form-control" value="Shs. {{ $average ?? 'N/A' }}"  aria-label="Last name">
            </div>
            <div class="col-md-6">
                <label for="loanAmount"><strong>Highest Deposit Made</strong></label>
                <input type="text" disabled class="form-control"  value="Shs. {{ $recordWithHighestPledge->max_client_pledge_cleared ?? 'N/A' }}"  aria-label="Last name">
                <h6 class="mt-2"><strong>
                        <em>{{"  "}}By : {{ $recordWithHighestPledge->clientName ?? 'N/A' }}</em>
                    </strong></h6>
            </div>
            <div class="form-group">
                <label for="loanAmount"><strong>Total Number Of Clients That Have Deposited </strong></label>
                <input type="text" disabled class="form-control" value="{{ $member_count ?? 'N/A' }}"   aria-label="Last name">
              </div>
            <div class="col-md-6">
                <label for="loanAmount"><strong>Average Deposit Performance</strong></label>
                <input type="text" class="form-control"value="{{ $average ?? 'N/A' }}"  disabled aria-label="First name">
            </div>
            <div class="form-group">
                <label for="loanAmount"><strong>Total Number Of Clients That Have Deposited </strong></label>
                <input type="text" disabled class="form-control" value="{{ $member_count ?? 'N/A' }}"   aria-label="Last name">
              </div>
            <div class="col-12 text-center mb-4">
                <h4>Client Performance Table Ranking For The Financial Year {{ date('Y') . '/' . (date('Y') + 1) }} </h4>
                <div>
                    
                </div>
            </div>
             
              
        </form>
    </div>
</body>
</html>
 