<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testcase;

class TestcaseController extends Controller
{
    public function import(Request $request)
    {
        $alert = 'error'; $message = '';
        if($request->isMethod('post')) {
            $filePath = $request->csvfile->path();
            $lineErrors = $this->isValidRowNumber($filePath, 9);
            if(!empty($lineErrors)){
                $message = "Row number is invalid. It must be 9. ";
                $error = implode(',', $lineErrors);
                $message .= "Line error: " . $error;
            }
            elseif ($file = fopen($filePath, "r")) {
                $header = fgets($file);   // get header
                $remember = [0=>null, 1=>null, 2=>null, 3 =>null, 4=>null, 5=>null, 6=>null, 7=>null, 8=>null];
                while(!feof($file)) {
                    $line = fgets($file);
                    $row = explode(',', $line);

                    if($this->isEmpty($row)){
                        continue;
                    }
                    else{
                        // reset
                        $this->rememberRow($remember, $row);

                        $timenow = date('Y-m-d H:i:s');
                        $dbRow = [];

                        $dbRow['category1'] = $remember[0];
                        $dbRow['category2'] = $remember[1];
                        $dbRow['category3'] = $remember[2];
                        $dbRow['process1'] = $remember[3];
                        $dbRow['process2'] = $remember[4];
                        $dbRow['expected_result'] = $remember[5];
                        $dbRow['note'] = $remember[6];
                        $dbRow['project_name'] = $remember[7];;
                        $dbRow['screen_name'] = $remember[8];
                        $dbRow['created_at'] = $timenow;
                        $dbRow['updated_at'] = $timenow;
                        Testcase::insert($dbRow);
                        $alert = 'success';
                        $message = "Import successfully.";
                    }
                }
                fclose($file);
            }
        }

        return view('testcase.import', compact('message', 'alert'));
    }

    public function isEmpty($array)
    {
        foreach ($array as $key => $item) {
            if(!empty($item) && trim($item) != ''){
                return false;
            }
        }
        return true;
    }

    public function isValidRowNumber($filePath, $number)
    {
        $lineError = [];
        if ($file = fopen($filePath, "r")) {
            $counter = 1;
            while (!feof($file)) {
                $line = fgets($file);
                $row = explode(',', $line);
                if (count($row) != $number && trim($line) != '') {
                    // File format is invalid
                    $lineError[]  = $counter;
                }
                $counter++;
            }
            fclose($file);
        }
        return $lineError;
    }

    public function rememberRow(&$remember, $row)
    {
        $index = 0;
        foreach($row as $key => $item){
            if(trim($item) != ''){
                $index = $key;
                break;
            }
        }
        for($i = $index; $i <= 8; $i++){
            $remember[$i] = trim($row[$i]);
        }
    }

}
