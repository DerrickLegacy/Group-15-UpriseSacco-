<!-- Loan Modal -->
  <div class="modal fade" id="loanModal" tabindex="-1" role="dialog" aria-labelledby="loanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <!-- Add your form elements here -->
          <form >
            <div class="modal-header">
                <h5 class="modal-title text-center" id="loanModalLabel">Uprise Sacco Loan Performance Report {{ date('Y') . '/' . (date('Y') + 1) }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="row g-3">
              <div class="col-md-6">
                <label for="loanAmount"><strong>Financial Year</strong></label>
                <input type="text" class="form-control" value="{{ date('Y') . '/' . (date('Y') + 1) }}" disabled aria-label="financialYear">
            </div>
              <div class="col">
                <label for="loanAmount"><strong>Total Loan Amount Requests</strong></label>
                <input type="text" disabled class="form-control" value="Shs. {{ $total_loan_req[0]->total_loans_requested ?? 'N/A' }}" aria-label="loan_amount">
              </div>
            </div>
            <div class="form-group">
              <label for="loanAmount"><strong>Fully Repaid Total Loans (100%)</strong></label>
              <input type="text" disabled class="form-control" value="Shs. {{ $total_loan_paid_100[0]->total_loans_cleared ?? 'N/A' }}" aria-label="loanRepaid">
            </div>
            <div class="form-group">
              <label for="loanAmount"><strong>Partialy Cleared Loans (less than 100%)</strong></label>
              <input type="text" disabled class="form-control" value="Shs. {{ $total_loan_paid_less_100[0]->total_loans_uncleared ?? 'N/A' }}"  aria-label="Last name">
            </div>
            <div class="form-group">
                <label for="loanAmount"><strong>Total Number Of Clients Loaned in Financial Year </strong></label>
                <input type="text" disabled class="form-control" value="{{ $total_loaned_memb[0]->total_members ?? 'N/A' }}"   aria-label="Last name">
              </div>
              <div class="form-group">
                <label for="loanAmount"><strong>Average loan Performance</strong></label>
                <input type="text" class="form-control" value="{{ $average_loan_perf[0]->average_loan_perf ?? 'N/A' }}"  disabled aria-label="First name">
              </div>
              <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <!-- <button type="button" class="btn btn-info">Send To Clients</button> -->
          <a href="/admin/reports/loan" target="_blank" rel="noopener noreferrer">
            <button type="button" class="btn btn-primary">Download</button>
        </a> 
          
        </div>
          </form>
        </div>
      </div>
    </div>
  </div>