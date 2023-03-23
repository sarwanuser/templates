<?php

namespace App\Http\Controllers;
@include(app_path('Providers/Functions/allogin/login.php'));
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App;
use Lang;
use Cookie;
use Mpdf\Mpdf;


class Genpdf extends Controller {
	
	public function get_html(){
		
	}
	
    public function index($orderid){ 

        if($orderidc > 0){

            /*--Init PDF configs--*/

            $mpdf = new \Mpdf\Mpdf([
                'tempDir' => storage_path('app/public/temp')
            ]);

			$html = $this->get_html();

            $mpdf->WriteHTML($html);

            $pdfname = "hawan-".$hawanid."-".$hawandata->hawandate.".pdf";  
            $mpdf->Output("invoices/".$pdfname, \Mpdf\Output\Destination::FILE);

            $pdfurl = url('invoices')."/".$pdfname;

            return redirect($pdfurl);

        }else{
            return redirect('/');
        }
    }
}
