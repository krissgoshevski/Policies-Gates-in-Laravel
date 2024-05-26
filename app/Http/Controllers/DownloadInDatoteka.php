<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadInDatoteka extends Controller
{
    //
    public function downloadTxt()
    {
        $text = "SMOKI" ;

        // %5 

        $filename = 'datoteka.in'; 
        $path = storage_path('app/' . $filename);

        file_put_contents($path, $text);

        return response()->download($path, $filename);
    }
}
