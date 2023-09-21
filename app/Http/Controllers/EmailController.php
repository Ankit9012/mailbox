<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class EmailController extends Controller
{
    public function sendEmails(Request $request)
    {

        try {

            $file = $request->file('mail_file');

            $spreadsheet = IOFactory::load($file->getRealPath());

            $sheet = $spreadsheet->getActiveSheet();

            $row_limit = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();

            $row_range = range(2, $row_limit);
            $column_range = range('A', $column_limit);

            $startCount = 2;
            $data = [];

            foreach ($row_range as $row) {
                $data[] = [
                    'email' => $sheet->getCell('A' . $row)->getValue()
                ];
            }



            return response()->json($data, 200);
        } catch (Exception $th) {
            return response()->json(['error' => $th], 500);
        }
    }
}
