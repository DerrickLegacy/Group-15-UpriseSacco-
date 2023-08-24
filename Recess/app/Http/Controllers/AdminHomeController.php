<?php
namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminHomeController extends Controller
{
    public function index()
    {   DB::update('UPDATE loan SET loan_performance = ((DATEDIFF(clearance_date, end_date) / 31) / payment_period) * 100 ');
        DB::update("UPDATE contributions SET contribution_progress = ((client_pledge_cleared/1200000) * 100)");
        // PieChart 1
        $total_loan_requests = DB::select("
            SELECT MONTHNAME(start_date) AS month, SUM(loan_request_amount) AS total_requested_loan
            FROM loan
            WHERE grant_status = 'Granted' AND client_decision = 'Accepted'
            GROUP BY YEAR(start_date), MONTH(start_date), start_date
            ORDER BY YEAR(start_date) DESC, MONTH(start_date) DESC
        ");
        
        $data = "";
        foreach ($total_loan_requests as $key => $val) {
            $data .= "['" . $val->month . "', " . $val->total_requested_loan . "],";
        }
        $chartData = $data;
        // dd($chartData);
        $membersCount = Member::all();

         $active_members = DB::select('SELECT COUNT(DISTINCT client_id) as active
        FROM contributions
        WHERE YEAR(deposit_date) = YEAR(CURRENT_DATE())
              AND MONTH(deposit_date) >= 6
              OR (YEAR(deposit_date) = YEAR(CURRENT_DATE()) + 1 AND MONTH(deposit_date) <= 6)
    ');

    $activeCount = $active_members[0]->active; // Extracting the active count

    $total_contributions =DB::select('select sum(client_pledge_cleared) as total from contributions');
    $total_cont = $total_contributions[0]->total;
    $unpaid= DB::select('SELECT sum(amount) as total FROM loan WHERE client_decision="Accepted" and loan_progress_status < 100');
    $loans = $unpaid[0]->total;
    // dd($total_contributions);

        // Querying data to display in the sacco bar chart
    $unpaid_loans = DB::select('
    SELECT
        MONTHNAME(l.start_date) AS loan_month,
        YEAR(l.start_date) AS loan_year,
        SUM(l.loan_request_amount) AS total_loan_amount
    FROM
        loan l
    JOIN
        members m ON m.id = l.client_id
    WHERE
        l.grant_status = "Granted"
        AND l.client_decision = "Accepted"
        AND l.loan_progress_status != 100
    GROUP BY
        loan_year, loan_month
');
//  dd($unpaid_loans);
    $contributions_made =DB::select('SELECT
        MONTHNAME(c.deposit_date) AS contribution_month,
        YEAR(c.deposit_date) AS contribution_year,
        SUM(c.client_pledge_cleared) AS total_contribution
    FROM
        contributions c
    GROUP BY
        contribution_year, contribution_month;
    ');
    // dd($contributions_made);

    $paid_loans = DB::select(' SELECT
            YEAR(start_date) AS loan_year,
            MONTHNAME(start_date) AS loan_month,
            SUM(clearance_status) AS total_clearance_status
        FROM
            loan
        WHERE
            loan_progress_status = 100
        GROUP BY
            loan_year, loan_month
        ORDER BY
            MONTH(start_date);
        ');
//  dd($paid_loans);




return view('admin.home.index', compact('membersCount', 'unpaid_loans' ,'paid_loans', 'contributions_made', 'chartData', 'total_cont', 'loans', 'activeCount'));
    }
}
