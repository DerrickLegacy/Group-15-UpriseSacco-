@extends('layouts.admin')

@section('content')

<div class="row" style="color: black; font-size: 46px; text-align:center;" >
<div class="text-center">
    <h2><strong>Uprise Sacco Performance Overview</strong></h2>
      
    </div>
  <div class="col-md-6 mb-3" >
    <div class="card text-center p-2 d-flex justify-content-center align-items-center">
      <div>
        <h3 class=" text-uppercase">Total members</h3>
        <img src="{{ asset('images/users.png') }}" alt="" class="mx-auto my-3" width="100">
        <p class="h1">{{count($membersCount)}}</p>
      </div>
    </div>
  </div>
  <div class="col-md-6 mb-3">
    <div class="card text-center p-2 d-flex justify-content-center align-items-center">
      <div>
    <h3 class="text-uppercase">Active clients</h3>
    <img src="{{ asset('images/meme.png') }}" alt="" class="mx-auto my-3" width="100">
    <p class="h1">{{ $activeCount }}</p>
</div>

    </div>
  </div>
  <div class="col-md-6 mb-3">
    <div class="card text-center p-2 d-flex justify-content-center align-items-center">
      <div>
        <h3 class=" text-uppercase">loans</h3>
        <img src="{{ asset('images/Coins.png') }}" alt="" class="mx-auto my-3" width="100">
        <p class="h1">Shs. {{ $loans }}</p>
      </div>
    </div>
  </div>
  <div class="col-md-6 mb-3">
    <div class="card text-center p-2 d-flex justify-content-center align-items-center">
      <div>
        <h3 class=" text-uppercase">sacco funds</h3>
        <img src="{{ asset('images/moneybag.png') }}" alt="" class="mx-auto my-3" width="100">
        <p class="h1">Shs. {{ $total_cont }}</p>
      </div>
    </div>
  </div>
</div>

  <div class="row">
    <div class="text-center">
    <h2><strong>Sacco Graphical Tracker</strong></h2>
      
    </div>
    <div class="col-md-6 mb-3">
        <div class="card text-center p-2 d-flex justify-content-center align-items-center">
            <p><strong>Graphical Overview of the Sacco Monthly Contribution Performance</strong></p>
            
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                google.charts.load("current", {packages:["corechart"]});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Month', 'Contributions'],
                        <?php echo $chartData ?>
                    ]);

                    var options = {
                        chart:{
                          title: 'Monthly Contributions',
                        pieSliceText: 'label',
                        slices: {
                            2: {offset: 0.2},
                            4: {offset: 0.2},
                            6: {offset: 0.2},
                            8: {offset: 0.3},
                            10: {offset: 0.2},
                        },
                        }
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                    chart.draw(data, options);
                }
            </script>

            <div id="piechart_3d" style="height: 300px; width:100%; "></div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
    <div class="card text-center p-2 d-flex justify-content-center align-items-center">
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages':['bar']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Month(2023)', 'Contributions', 'Unpaid Loan', 'Paid Loan'],
                    @php
                        $months = [
                            'January', 'February', 'March', 'April', 'May', 'June',
                            'July', 'August', 'September', 'October', 'November', 'December'
                        ];

                        foreach($months as $month) {
                            $foundContribution = false;

                            foreach($contributions_made as $contribution) {
                                if($contribution->contribution_month == $month) {
                                    echo "['{$month}', {$contribution->total_contribution}, 0, 0],";
                                    $foundContribution = true;
                                    break;
                                }
                            }

                            if(!$foundContribution) {
                                echo "['{$month}', 0, 0, 0],";
                            }

                            $foundUnpaid = false;
                            foreach($unpaid_loans as $loan) {
                                if($loan->loan_month == $month) {
                                    echo "['{$month}', 0, {$loan->total_loan_amount}, 0],";
                                    $foundUnpaid = true;
                                    break;
                                }
                            }

                            if(!$foundUnpaid) {
                                echo "['{$month}', 0, 0, 0],";
                            }

                            $foundPaid = false;
                            foreach($paid_loans as $loan) {
                                if($loan->loan_month == $month) {
                                    echo "['{$month}', 0, 0, {$loan->total_clearance_status}],";
                                    $foundPaid = true;
                                    break;
                                }
                            }

                            if(!$foundPaid) {
                                echo "['{$month}', 0, 0, 0],";
                            }
                        }
                    @endphp
                ]);

                var options = {
                    chart: {
                        title: 'Sacco Performance and Loans',
                        subtitle: 'Contributions, Unpaid Loans, Paid Loan',
                    },
                    bars: 'vertical'
                };

                var chart = new google.charts.Bar(document.getElementById('barchart_material'));

                chart.draw(data, google.charts.Bar.convertOptions(options));
            }
        </script>
        <div id="barchart_material" style="width: 100%; height: 500px;"></div>
    </div>
</div>


</div>


  
  
</div>
@endsection
<!-- <div id="piechart_3d" style="width: 60%; height: 500px; border: 2px solid black"></div> -->