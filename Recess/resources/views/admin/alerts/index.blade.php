@extends('layouts.admin')

@section('content')
<div class="p-4">
  <h1>Alerts</h1>
  <div class="mt-4 card p-4">
    <div class="table table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Alert</th>
            <th>Reference</th>
            <th>Time</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Loan Request</td>
            <td>64533</td>
            <td>30 minutes ago</td>
            <td>Done</td>
          </tr>
          <tr>
            <td>Deposit</td>
            <td>64533</td>
            <td>30 minutes ago</td>
            <td>Waiting</td>
          </tr>
          <tr>
            <td>Loan Request</td>
            <td>64533</td>
            <td>30 minutes ago</td>
            <td>Delayed</td>
          </tr>
          <tr>
            <td>Deposit</td>
            <td>64533</td>
            <td>30 minutes ago</td>
            <td>Waiting</td>
          </tr>
          <tr>
            <td>Deposit</td>
            <td>64533</td>
            <td>30 minutes ago</td>
            <td>Done</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection