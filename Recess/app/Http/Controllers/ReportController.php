<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use PDF;
use DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{   
    // Loan Report
    $total_loan_req = DB::select('SELECT sum(loan_request_amount) as total_loans_requested from loan where client_decision="Accepted"');
    $total_loan_paid_100 = DB::select('SELECT sum(clearance_status) as total_loans_cleared from loan where loan_progress_status=100');
    $total_loan_paid_less_100 = DB::select('SELECT sum(clearance_status) as total_loans_uncleared from loan where loan_progress_status < 100');
    $total_loaned_memb = DB::select('SELECT count(*) as total_members from loan');
    $average_loan_perf = DB::select('SELECT AVG(COALESCE(loan_performance, 0)) as average_loan_perf FROM loan');

    // Performance report
    $table = DB::select('SELECT c.client_id, AVG(c.contribution_progress) AS max_contribution_progress, SUM(c.client_pledge_cleared) AS max_client_pledge_cleared, m.clientName, m.phone_number FROM contributions c JOIN members m ON c.client_id = m.id GROUP BY c.client_id, m.clientName, m.phone_number;
');
     // Initialize the variable
$sumFromTable = 0; 
$highestPledge = 0;  
$recordWithHighestPledge = null;
$averagePerformance=0;

$member_count = count($table);

foreach ($table as $row) {
    $sumFromTable += (float) $row->max_client_pledge_cleared;
    $averagePerformance +=(float) $row->max_contribution_progress;
    if ((float) $row->max_client_pledge_cleared > $highestPledge) {
        $highestPledge = (float) $row->max_client_pledge_cleared;
         $recordWithHighestPledge = $row;
    }
}
$total_contribution =$sumFromTable;
$average = $averagePerformance/$member_count;
    // $maximum = DB::select('SELECT MAX(client_pledge_cleared) from contributions')
    // dd($average);
    $unpaid_loans =DB::select(' SELECT DISTINCT * from loan l join members m on m.id = l.client_id where l.grant_status ="Granted" and l.client_decision = "Accepted" and l.loan_progress_status != 100; '); 
    $loan_request_amounts = 0;
    $total_to_pay = 0;
    $cleared_yet = 0;



    foreach ($unpaid_loans as $row) {
        $loan_request_amounts += (float) $row->loan_request_amount;
        $total_to_pay += (float) $row->amount;
        $cleared_yet += (float) $row->clearance_status;
    }
    $bal = $total_to_pay -$cleared_yet;
    // dd($cleared_yet);
    return view('admin.reports.index',  compact('total_loan_req', 'bal','cleared_yet' ,'loan_request_amounts' , 'total_to_pay','average', 'unpaid_loans', 'member_count', 'recordWithHighestPledge','total_contribution', 'table','total_loaned_memb','average_loan_perf','total_loan_paid_less_100', 'total_loan_paid_100'));
}


    public function gen_pdf()
    {
        $total_loan_req = DB::select('SELECT sum(loan_request_amount) as total_loans_requested from loan where client_decision="Accepted"');
        $total_loan_paid_100 = DB::select('SELECT sum(clearance_status) as total_loans_cleared from loan where loan_progress_status=100');
        $total_loan_paid_less_100 = DB::select('SELECT sum(clearance_status) as total_loans_uncleared from loan where loan_progress_status < 100');
        $total_loaned_memb = DB::select('SELECT count(*) as total_members from loan');
        $average_loan_perf = DB::select('SELECT AVG(COALESCE(loan_performance, 0)) as average_loan_perf FROM loan');

        $data = [
            'total_loan_req' => $total_loan_req,
            'total_loan_paid_100' => $total_loan_paid_100,
            'total_loan_paid_less_100' => $total_loan_paid_less_100,
            'total_loaned_memb' => $total_loaned_memb,
            'average_loan_perf' => $average_loan_perf,
        ];
        // dd($data);

        $pdf = PDF::loadView('admin.reports.loan', $data);
        return $pdf->stream();
    }
    public function gen_perf_pdf()
{
    $table = DB::select('SELECT c.client_id, AVG(c.contribution_progress) AS max_contribution_progress, SUM(c.client_pledge_cleared) AS max_client_pledge_cleared, m.clientName, m.phone_number FROM contributions c JOIN members m ON c.client_id = m.id GROUP BY c.client_id, m.clientName, m.phone_number;');

    // Initialize variables
    $sumFromTable = 0;
    $highestPledge = 0;
    $recordWithHighestPledge = null;
    $averagePerformance = 0;
    $member_count = count($table);

    foreach ($table as $row) {
        $sumFromTable += (float) $row->max_client_pledge_cleared;
        $averagePerformance += (float) $row->max_contribution_progress;
        if ((float) $row->max_client_pledge_cleared > $highestPledge) {
            $highestPledge = (float) $row->max_client_pledge_cleared;
            $recordWithHighestPledge = $row;
        }
    }

    $total_contribution = $sumFromTable;
    $average = $averagePerformance / $member_count;

    // Modify the $dataArray variable
    $dataArray = [
        'total_contribution' => $total_contribution,
        'average' => $average,
        'table' => $table,
        'recordWithHighestPledge' => $recordWithHighestPledge,
        'member_count' => $member_count,
    ];
    // dd($table);

    $pdf = PDF::loadView('admin.reports.deposit', compact('total_contribution', 'average', 'recordWithHighestPledge', 'member_count'));

    return $pdf->download('invoice.pdf');
}
    
    /**
     * Show the form for creating a new resource.
     */
    public function depo()
    {
        return view('admin.reports.deposit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
    public function deposit(){
    return view('admin.reports.deposit');
  }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }
}
