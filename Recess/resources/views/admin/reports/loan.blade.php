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
                <h2 class="modal-title" id="loanModalLabel">Uprise Sacco Loan Performance Report {{ date('Y') . '/' . (date('Y') + 1) }}</h2>
            </div>
            <div class="col-md-6">
                <label for="loanAmount"><strong>Financial Year</strong></label>
                <input type="text" class="form-control" value="{{ date('Y') . '/' . (date('Y') + 1) }}" disabled aria-label="financialYear">
            </div>
            <div class="col-md-6">
                <label for="loanAmount"><strong>Total Loan Amount</strong></label>
                <input type="text" disabled class="form-control" value="Shs. 100,000,000" aria-label="loan_amount">
            </div>
            <div class="col-md-6">
                <label for="loanAmount"><strong>Loans Repaid</strong></label>
                <input type="text" disabled class="form-control" value="Shs. 1000,000" aria-label="loanRepaid">
            </div>
            <div class="col-md-6">
                <label for="loanAmount"><strong>Pending Unpaid</strong></label>
                <input type="text" disabled class="form-control" value="Shs. 2000,000" aria-label="Last name">
            </div>
            <div class="col-md-6">
                <label for="loanAmount"><strong>Total Number Of Clients Loaned in Financial Year </strong></label>
                <input type="text" disabled class="form-control" value="100" aria-label="Last name">
            </div>
            <div class="col-md-6">
                <label for="loanAmount"><strong>Average loan Performance</strong></label>
                <input type="text" class="form-control" value="2023/2024" disabled aria-label="First name">
            </div>
        </form>
    </div>
</body>
</html>
 