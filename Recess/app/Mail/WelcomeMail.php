<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailData; // Add this property to hold the data

    public function __construct($emailData)
    {
        $this->emailData = $emailData; // Assign the data to the property
    }

    public function build()
    {
        return $this->view('admin.email-reports.index') // Use your email template view
            ->subject(' Uprise Sacco performance report')
            ->with('emailData', $this->emailData); // Pass the data to the email view
    }
}