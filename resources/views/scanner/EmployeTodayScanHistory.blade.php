<?php 
    $email = $_GET['email'];

    if($_GET['action'] == "getHistory")
    {
        $qrcode = DB::select('select * from qrcode where email = ? ORDER BY id DESC limit 1', $email);
        print_r($qrcode);
    }
       
    
    if($_GET['action'] == "addHistoryArrival")
        DB::insert('insert into qrcode (id, email) values (?, ?, ?)', [0, $email,'ARRIVEE']);

    if($_GET['action'] == "addHistoryDeparture")
        DB::insert('insert into qrcode (id, email) values (?, ?, ?)', [0, $email,'DEPART']);
?>