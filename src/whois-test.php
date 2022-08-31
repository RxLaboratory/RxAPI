<?php
    require_once("whois/whois.main.php");


    $ip = $_SERVER['REMOTE_ADDR'];


    $whois = new Whois();
    $whois->deep_whois = false;
    $ip = $_SERVER['REMOTE_ADDR'];
    $data = $whois->Lookup($ip);

    echo json_encode($data);
    
    if(!isset( $data['regrinfo'] )) return "unknown";
    if(!isset( $data['regrinfo']['network'] )) return "unknown";
    if(!isset( $data['regrinfo']['network']['country'] )) return "unknown";

    //$country = explode("#", $data['regrinfo']['network']['country'])[0];
    //return trim($country);
?>