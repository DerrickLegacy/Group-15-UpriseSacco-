<!-- Loan Modal -->
  <div class="modal fade" id="depositmodal" tabindex="-1" role="dialog" aria-labelledby="depositmodal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <form >
            <div class="modal-header">
                <h2 class="modal-title text-center" id="loanModalLabel">Uprise Sacco Deposit Performance Report {{ date('Y') . '/' . (date('Y') + 1) }}</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="row g-3">
              <div class="col-md-6">
                <label for="loanAmount"><strong>Financial Year</strong></label>
                <input type="text" class="form-control" value="{{ date('Y') . '/' . (date('Y') + 1) }}" disabled aria-label="financialYear">
              </div>
              <div class="col-md-6">
                  <label for="loanAmount"><strong>Deposit Or Contribution Target</strong></label>
                  <input type="text" class="form-control" value="Shs. 1,200,000" disabled aria-label="financialYear">
              </div>
              <div class="col">
                <label for="loanAmount"><strong>Total  Deposits Made</strong></label>
                <input type="text" disabled class="form-control" value="Shs. {{ $total_contribution ?? 'N/A' }}" aria-label="loan_amount">
              </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="loanAmount"><strong>Average Deposit as of Target(Shs. 1,200,00)</strong></label>
                    <input type="text" disabled class="form-control" value="Shs. {{ $total_loan_paid_100[0]->total_loans_cleared ?? 'N/A' }}" aria-label="loanRepaid">
                </div>
            
                <div class="col-md-6">
                    <label for="loanAmount"><strong>Highest Deposit Made</strong></label>
                    <input type="text" disabled class="form-control" value="Shs. {{ $recordWithHighestPledge->max_client_pledge_cleared ?? 'N/A' }}"  aria-label="Last name">
                    <h6 class="mt-2"><strong>
                        <em>{{"  "}}By : {{ $recordWithHighestPledge->clientName ?? 'N/A' }}</em>
                    </strong></h6>
                </div>
            </div>

            <div class="form-group">
                <label for="loanAmount"><strong>Total Number Of Clients That Have Deposited </strong></label>
                <input type="text" disabled class="form-control" value="{{ $member_count ?? 'N/A' }}"   aria-label="Last name">
              </div>
              <div class="form-group">
                <label for="loanAmount"><strong>Average Deposits Performance</strong></label>
                <input type="text" class="form-control" value="{{ $average ?? 'N/A' }}"  disabled aria-label="First name">
              </div>
               <hr>
              <h4>Client Performance Table Ranking For The Financial Year {{ date('Y') . '/' . (date('Y') + 1) }} </h4>
              <table class="table table-striped table-hover table-light">
      <thead>
        <tr>
          <th scope="col">#Id</th>
          <th scope="col">Client Name</th>
          <th scope="col">Phone Number</th>
          <th scope="col">Total Deposit Made/1,200,000</th>
          <th scope="col">Deposit Progress</th>
        </tr>
      </thead>
      <tbody>
        @foreach($table as $row)
        <tr>
          <th scope="row">{{ $row->client_id }}</th>
          <td>{{ $row->clientName }}</td>
          <td>{{ $row->phone_number }}</td>
          <td>{{ $row->max_client_pledge_cleared }}</td>
          <td>{{ $row->max_contribution_progress }}</td>
        </tr>
        @endforeach
        <tr  class="table-secondary">
          
          <Strong>
            <td colspan="4">Average Deposit Performance</td>
          <td>{{  $average ?? 'N/A'  }}</td>
          </Strong>
        </tr>
      </tbody>
    </table>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <!-- <button type="button" class="btn btn-info">Send To Clients</button> -->
          <a href="/admin/reports/deposit" target="_blank" rel="noopener noreferrer">
            <button type="button" class="btn btn-primary">Download Report</button>
        </a> 
          
        </div>
          </form>
        </div>
      </div>
    </div>
  </div>