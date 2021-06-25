<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Employe;
use App\Qrcode;

class ScannController extends Controller
{
    public function scan(Request $request){
        $employes = Employe::all();
        return view('scanner.scann')->with('employes', $employes);
    }
    public function manageQrScan(){
        // $qrcode =  new Qrcode();
        // $qrcode->contenu = $request->text;
        // //dd($qrcode);
        // $qrcode->save(); 

        // $qrcode = strtolower($qrcode);
        // $employes = Employe::all();
        // $email =[];
        
        $email = $_GET['email'];

        if($_GET['action'] == "getHistory")
        {
            $qrcode = DB::select('select * from qrcodes where email = ? ORDER BY id DESC limit 1',[$email]);
            print_r(json_encode($qrcode));
        }
        
        
        if($_GET['action'] == "addHistoryArrival")
            DB::insert('insert into qrcodes (id, email, motif) values (?, ?, ?)', [0, $email,'ARRIVEE']);

        if($_GET['action'] == "addHistoryDeparture")
            DB::insert('insert into qrcodes (id, email, motif) values (?, ?, ?)', [0, $email,'DEPART']);
    
       // return redirect('scann');

    }

}
