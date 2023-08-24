@extends('layouts.admin')

@section('content')
<div>
<div class="accordion" id="accordionPanelsStayOpenExample">
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
        <div>
            <h5>Loan Requests<span class="btn btn-info" style="border-radius:50%;">{{count($loan_req)}}</span></h5>
        </div>
    </button>
    </h2>
    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
      <div class="accordion-body" style=" background-color: white !important;">
        <div class=" mt-2">
      <strong><div class="shadow-sm  bg-white"> <em>Client submitted loan requests awaitng approval.</em></div></strong>
      <div class="mt-3">
    <div class="search">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6 mb-3">
                    <div class="input-group">
                        <input id="searchInput" type="text" class="form-control " placeholder="Enter search...">
                        <button class="btn btn-primary" type="button" onclick="performSearchLoan()">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <table id="dataTable" class="table table-striped table-hover table-light">
        <thead>
            <tr>
                <th scope="col">Client</th>
                <th scope="col">Full Name</th>
                <th scope="col">Phone Number</th>
                <th scope="col">Request Amount</th>
                <th scope="col">Previous Loan Progress Status</th>
                <th scope="col">Average Loan Performance</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if ($loan_req === null || count($loan_req) === 0)
                <tr>
                    <td colspan="7">No Requests yet!</td>
                </tr>
            @else
                @foreach ($loan_req as $client)
                <tr class="p-2 hover-bg-slate">
                    <td>{{ $client->client_id }}</td>
                    <td>{{ $client->clientName }}</td>
                    <td>{{ $client->phone_number }}</td>
                    <td>{{ $client->loan_request_amount }}</td>
                    <td>
                        @if ($client->loan_progress_status !== null)
                            {{ $client->loan_progress_status }}
                        @else
                            <strong style="color: red;"><em>New Member</em></strong>
                        @endif
                    </td>
                    <td>{{ $client->loan_performance }}</td>
                    <td>
                        <a href="{{ route('admin.requests', ['client_id' => $client->client_id]) }}">
                            <button type="button" class="btn btn-success">Set Interest</button>
                        </a>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

    </div>
  </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
        <h5 class="text-center">Pending Login Requests   <span class="btn btn-info" style="border-radius:50%;">{{count($data)}}</span></h5>
      </button>
    </h2>
    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
      <div class="accordion-body" style=" background-color: white !important;">
        <div class=" mt-2">
          <strong>
            <div class="shadow-sm  bg-white"><em>Pending client login request issues.  </em></div>
          </strong>
          <div class="mt-3">
                    <form action="" class="mb-3" method="get">
                        <div class="container mt-5">
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <!-- Use a unique ID for the search input in this accordion item -->
                                        <input id="searchInputPending" type="text" class="form-control" placeholder="Enter Client Name, Reference Number, etc..">
                                        <!-- Call the correct search function for this accordion item -->
                                        <button class="btn btn-primary" type="button" onclick="performSearchPending()">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

    <div class="search"></div>
    <table  id="dataTablePending" class="table table-striped table-hover table-light">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Full Name</th>
            <th scope="col">Phone Number</th>
            <th scope="col">Reference Number</th>
            <th scope="col">Update Password</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $client)
        <tr class="p-2 hover-bg-slate">
            <td>{{ $client['client_id'] }} </td>
            <td>{{ $client['client_name'] }}</td>
            <td>{{ $client['phone_number'] }}</td>
            <td>{{ $client['latest_ref_number'] }}</td>
            <td>
                <form action="{{ route('admin.requests.pending', ['client_id' => $client['client_id'], 'latest_ref_number' => $client['latest_ref_number']]) }}" method="post">
                    @csrf
                    <input type="text" class="form-control" name="password">
            </td>
            <td>
                <button type="submit" class="btn btn-info">Update</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>



        </div>
      </div>
    </div>
  
</div>

<!--  Scripts to perform a search  -->
<script>
    function performSearch() {
        const searchInput = document.getElementById('searchInput');
        const dataTable = document.getElementById('dataTable');
        const tableRows = dataTable.getElementsByTagName('tr');
        const searchText = searchInput.value.toLowerCase();

        for (let i = 1; i < tableRows.length; i++) {
            const row = tableRows[i];
            const rowData = row.textContent.toLowerCase();
            
            if (rowData.includes(searchText)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }

        // Show "No result match" message if no rows are visible
        const visibleRows = Array.from(tableRows).slice(1).filter(row => row.style.display !== 'none');
        if (visibleRows.length === 0) {
            dataTable.innerHTML = '<tbody><tr><td colspan="6">No result match</td></tr></tbody>';
        }
    }
</script>

<script>
    function performSearchPending() {
        const searchInput = document.getElementById('searchInputPending');
        const dataTable = document.getElementById('dataTablePending');
        const tableRows = dataTable.getElementsByTagName('tr');
        const searchText = searchInput.value.toLowerCase();

        for (let i = 1; i < tableRows.length; i++) {
            const row = tableRows[i];
            const rowData = row.textContent.toLowerCase();

            if (rowData.includes(searchText)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }

        const visibleRows = Array.from(tableRows).slice(1).filter(row => row.style.display !== 'none');
        if (visibleRows.length === 0) {
            dataTable.innerHTML = '<tbody><tr><td colspan="6">No result match</td></tr></tbody>';
        }
    }
</script>
</div>
@endsection