<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\DB;

class EmailReportController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Fetch the data you need from the database
            // ... (your existing queries)

            $clientIds = DB::select("
                SELECT DISTINCT client_id
                FROM contributions
                WHERE (YEAR(deposit_date) = YEAR(CURRENT_DATE()) AND MONTH(deposit_date) >= 6)
                OR (YEAR(deposit_date) = YEAR(CURRENT_DATE()) + 1 AND MONTH(deposit_date) <= 6) 
            ");

            $successClients = [];

            foreach ($clientIds as $key => $clientIdObject) {
                $clientId = $clientIdObject->client_id;

                // Fetch client's email based on the client_id
                $client = DB::table('members')->where('id', $clientId)->first();

                if ($client) {
                    try {
                        // Prepare the data to pass to the WelcomeMail
                        $emailData = [
                            'total_contribution' => $total_contribution,
                            'total_loan_paid_100' => $total_loan_paid_100,
                            // ... (other data)
                        ];

                        Mail::to($client->username)->send(new WelcomeMail($emailData));

                        $successClients[] = $client->username; // Store the successful clients

                    } catch (\Exception $e) {
                        // Handle the exception (e.g., log it)
                        // This might help you identify any issues with email sending
                        // You can add a log entry or use dd($e->getMessage()) to see the error
                    }
                }
            }

            // Debug the contents of $successClients
            // dd($successClients);

            // Determine the success message based on $successClients
            $successMessage = (!empty($successClients))
                ? 'Emails sent successfully to clients with usernames: ' . implode(', ', $successClients)
                : 'No emails sent.';

            return response()->json(['success' => $successMessage]);

        } catch (\Exception $ex) {
            // Handle the exception (e.g., log it) and provide an error response
            return response()->json(['error' => 'An error occurred.']);
        }
    }
}