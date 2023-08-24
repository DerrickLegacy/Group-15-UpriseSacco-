<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class CsvController extends Controller
{
    public function uploadCsv(Request $request){
            if ($request->hasFile('csv_file')) {
                $path = $request->file('csv_file')->getRealPath();
                $file = fopen($path, 'r'); // Open the CSV file for reading

                $header = fgetcsv($file); // Get the header row

                while (($row = fgetcsv($file)) !== false) {
                    if (count($header) === count($row)) {
                        $record = array_combine($header, $row);

                        // Insert $record data into the MySQL database
                        DB::table('contributions')->insert($record);
                    } else {
                        // Handle the case where the number of columns doesn't match
                        // You can log an error or handle it according to your needs
                    }
                }

                fclose($file); // Close the CSV file

                return redirect('admin')->back()->with('success', 'CSV file uploaded and data inserted.');
            }


            return redirect()->back()->with('error', 'No CSV file uploaded.');
    }




    public function uploadloanCsv(Request $request){
        if ($request->hasFile('csv_file')) {
                $path = $request->file('csv_file')->getRealPath();
                $file = fopen($path, 'r'); // Open the CSV file for reading

                $header = fgetcsv($file); // Get the header row

                while (($row = fgetcsv($file)) !== false) {
                    if (count($header) === count($row)) {
                        $record = array_combine($header, $row);

                        // Insert $record data into the MySQL database
                        DB::table('loan')->insert($record);
                    } else {
                        // Handle the case where the number of columns doesn't match
                        // You can log an error or handle it according to your needs
                    }
                }

                fclose($file); // Close the CSV file

                return redirect('admin')->back()->with('success', 'CSV file uploaded and data inserted.');
            }


            return redirect()->back()->with('error', 'No CSV file uploaded.');
    }
}
