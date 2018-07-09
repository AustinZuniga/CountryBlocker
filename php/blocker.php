<?php

//  PHP SNIPPET FOR RESTRICTING USERS FROM ACCESSING THE WEBSITE BASED IN BLOCKED LIST OF COUNTRIES LOCATED IN src/blocked_country.txt
// Author: Earl Austin Zuniga
//         BS COMPUTER SCIENCE
//         BICOL UNIVERSITY



// class for site restriction
class SiteRestriction{

    // Function to get Public IP Address
    function getIp(){
        $getIp = file_get_contents('http://checkip.dyndns.com/');
        preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $getIp, $data);
        return $ipAddress = $data[1];
    }

    // Getting data from IP Address using 3rd party web netip.de
    function getDataFromIp($ip){
        // check if IP addess is Valid
         if(!filter_var($ip, FILTER_VALIDATE_IP)){
            throw new InvalidArgumentException("IP Address is not valid");
         }

         $response=@file_get_contents('http://www.netip.de/search?query='.$ip);
         
         if (empty($response)){
            throw new InvalidArgumentException("Connection Error: Please Check Your Internet Connection");
         }

         $info=array();
       // $info["domain"] = '#Domain: (.*?)&nbsp;#i';
         $info["country"] = '#Country: (.*?)&nbsp;#i';
       // $info["state"] = '#State/Region: (.*?)<br#i';
       // $info["town"] = '#City: (.*?)<br#i';

         $ipInfo=array();

         foreach ($info as $key => $data){
            $ipInfo[$key] = preg_match($data,$response,$value) && !empty($value[1]) ? $value[1] : 'not found';
         }

        //$geoIP  = json_decode(file_get_contents("http://freegeoip.net/json/$ip"), true); 

        return $ipInfo;
    }

    // Check if IP's Country is one of the blocked countries
    function checkifblocked($country){

        if (file_exists('src/blocked_country.txt') ) {
          // get data from file blocked_country.txt
            $filename = 'src/blocked_country.txt';
            $fp = @fopen($filename, 'r'); 

            // Add each line to an array
             if ($fp) {
            $deny_country = explode("\n", fread($fp, filesize($filename)));
                }

         // $deny_country = explode("\n", file_get_contents('src/blocked_country.txt'));
        }
         
        // check if user's country is in blocked list
        if ( (array_search($country, $deny_country))!== FALSE ) {
          header("Location: error.html");
        }
        else{
          header("index.php");
        }

    }

}

// class for updating
class update_list{
    // remove country from list
    function remove_country($remove){
        $fn = "../src/blocked_country.txt";
        $str=file_get_contents("../src/blocked_country.txt");

        if (empty($str)){
            die('Failed to fetch data');
        }else{
            $oldMessage = $remove;
            //$oldMessage = "PH - Philippines";
            $deletedFormat = "";
            $str = str_replace($oldMessage, $deletedFormat,$str);
            $a = file_put_contents('../src/blocked_country.txt',$str);
            header("Location: ../config.php");
        }

    }
    // add country from list
    function add_country($add){
        $country = $add;
        //file_put_contents('../src/blocked_country.txt',"\n", FILE_APPEND);
        file_put_contents('../src/blocked_country.txt',$country, FILE_APPEND);
        header("Location: ../config.php");
    }

}


// MAIN

// declare class
$update_list = new update_list;
$SiteRestriction = new SiteRestriction;

// remove data from blacklist
if(isset($_POST['remove'])){
    $update_list->remove_country($_POST['countries']);
}
//add data to blacklist
elseif(isset($_POST['add'])){
    $update_list->add_country($_POST['countries']);
}
// get result from blocker
else{
    // get IP Address and store to $ip
    $ip= $SiteRestriction->getIp();
    // get data from IP Address and store to $data
    $data = $SiteRestriction->getDataFromIp($ip);
    // get the counrty from IP Address
    $country = $data['country'];
    // Check if Country is in Blocked list
    $SiteRestriction->checkifblocked($country);
}
//end
?>