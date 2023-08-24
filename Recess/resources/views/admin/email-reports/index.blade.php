<div class="modal-body">
                <h4>Financial Year: {{ date('Y') . '/' . (date('Y') + 1) }}</h4>
                <table class="table">
                    <tr>
                        <th>Deposit Or Contribution Target</th>
                        <td>Shs. 1,200,000</td>
                    </tr>
                    <tr>
                        <th>Total Deposits Made</th>
                        <td>Shs. {{ $emailData[$total_contribution ?? 'N/A'] }}</td>
                    </tr>
                    <tr>
                        <th>Average Deposit as of Target (Shs. 1,200,000)</th>
                        <td>Shs. {{$emailData[ $total_loan_paid_100[0]->total_loans_cleared ?? 'N/A']}}</td>
                    </tr>
                    <tr>
                        <th>Highest Deposit Made</th>
                        <td>Shs. {{$emailData [$recordWithHighestPledge->max_client_pledge_cleared ?? 'N/A'] }}</td>
                    </tr>
                    <tr>
                        <th>By</th>
                        <td>{{$emailData [$recordWithHighestPledge->clientName ?? 'N/A'] }}</td>
                    </tr>
                    <tr>
                        <th>Total Number Of Clients That Have Deposited</th>
                        <td>{{$emailData [$member_count ?? 'N/A'] }}</td>
                    </tr>
                    <tr>
                        <th>Average Deposits Performance</th>
                        <td>{{$emailData [$average ?? 'N/A'] }}</td>
                    </tr>
                </table>

                <hr>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Total Loan Amount Requests</td>
                            <td>Shs. {{ $total_loan_req[0]->total_loans_requested ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Fully Repaid Total Loans (100%)</td>
                            <td>Shs. {{ $total_loan_paid_100[0]->total_loans_cleared ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Partialy Cleared Loans (less than 100%)</td>
                            <td>Shs. {{ $total_loan_paid_less_100[0]->total_loans_uncleared ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Total Number Of Clients Loaned in Financial Year</td>
                            <td>{{ $total_loaned_memb[0]->total_members ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Average loan Performance</td>
                            <td>{{ $average_loan_perf[0]->average_loan_perf ?? 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>