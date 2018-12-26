<?php
  session_start();
  
  ini_set("display_errors", 1);
  error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
  $tok = 17; //token;
  $chr = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
  $enc = $_POST["encrypt"];
  
  if(!$_POST["data"] && !$_GET["debug"]) {
  	echo "Tunnel of TWSQuery, by maskofa18@gmail.com (Version : 3.22)";
  	exit;
  }
   
  function AZToInt($text){
  	global $chr;
    $sss = trim($text);
    $xxx = 0;
    $cnt = strlen($sss);
    
    for($iii = $cnt - 1; $iii >= 0; $iii--) {
    	$ccc = $sss[$iii];
    	$ppp = strpos($chr, $ccc);
      $eee = $cnt - ($iii + 1); 
      $kkk = pow(strlen($chr), $eee);
    	
      if($ppp === false) {
        return -1;
      }

      $xxx += $ppp * $kkk;
    }

    return $xxx;
  }
  
  function IntToAZ($int) { 
  	global $chr;
  	
    $cnt = strlen($chr);
    $sis = $int %  $cnt;
    $has = intval($int / $cnt);
    $sss = $chr[$sis];

    while($has > 0) {
      $sis = $has % $cnt;
      $has = intval($has / $cnt);
      $sss = $chr[$sis].$sss;
    }

    return substr("00".$sss, -2);
  }
  
  function Decode($txt) {
  	global $enc;
  	global $tok;

  	if($enc == "false") return $txt;
  	
  	//re-arrange by token;
  	$txt = strrev($txt);
  	$cod = substr($txt, 0, 3);
  	$txt = substr($txt, 3, strlen($txt));
  	$sss = substr($txt, 0, $tok - 1).$cod.substr($txt, $tok - 1, strlen($txt));
  	$txt = $sss;
    	  	
  	$key = AZToInt(substr($txt, 0, 2));
  	$key = $key < 0 ? $key + strlen($chr) : $key;
  	$cnt = strlen($txt);
    $xxx = intval(($cnt - 2) / 2);
    $sss = "";

    for($iii = 1; $iii <= $xxx; $iii++) {
      $ddd  = $iii * 2;
      $yyy  = AZToInt(substr($txt, $ddd, 2)) - $key;
      $sss .= chr($yyy);
    }
  	
    return $sss;
  }
  
  function Encode($txt) {
  	global $enc;
  	global $tok;
  	
  	if($enc == "false") return $txt;
  	
  	$xxx = rand(0, 255);
  	$xxx = rand(0, 255);
    $key = IntToAZ($xxx);
    $sss = $key;
    $cnt = strlen($txt);

    for($iii = 0; $iii < $cnt; $iii++) {
      $yyy  = $xxx + ord($txt[$iii]);
      $sss .= IntToAZ($yyy);
    }

  	//re-Arrange by token;
  	$cod = substr($sss, $tok - 1, 3);
  	$sss = $cod.substr($sss, 0, $tok - 1).substr($sss, $tok + 2, strlen($sss));
  	
    return $sss;
  }
  
  function isSelect($txt) {
  	$sel = "select";
  	$txt = trim($txt);
  	$txt = strtolower($txt);
  	$txt = substr($txt, 0, 6);
  	return $txt == $sel ? $sel : "";
  }
  
  //A = 10; AA = 630;
  $dlm = '|';
  $par = $_POST["data"]; 
  $par = explode($dlm, $par);
  $par = $par[0]; 
  $par = Decode($par);
  $jso = json_decode($par);

  if($jso->connect) {
    $hst = $jso->dbhost; 
    $usr = $jso->dbuser; 
    $pas = $jso->dbpass; 
    $dbn = $jso->dbname;
    $prt = $jso->dbport;
 
    $con = new mysqli($hst, $usr, $pas, $dbn, $prt);
  
    if($con->connect_errno) {
      $die = $con->connect_error;
      $die = "{\"status\":\"error\",\"message\":\"$die\",\"data\":\"\"}";
      $die = Encode($die).$dlm;  
      echo $die;
      exit;
    } else {
    	$_SESSION["connect"] = "true";
    	$_SESSION["dbhost"]  = $hst;
    	$_SESSION["dbuser"]  = $usr;
    	$_SESSION["dbpass"]  = $pas;
    	$_SESSION["dbname"]  = $dbn;
    	$_SESSION["dbport"]  = $prt;
    	
  	  $res->status        = "oke";
  	  $res->message       = "Connection Succesfull";
  	  $res->data->session = session_id();
      $jso = json_encode($res);
      $jso = str_replace(":null", ":\"\"", $jso);
      $jso = Encode($jso);
      echo $jso.$dlm;
    	exit;
    }
  }
  
  if(!$_SESSION["connect"]) {
    $die = "{\"status\":\"error\",\"message\":\"Connection error or Session Expired\",\"data\":\"\"}";
    $die = Encode($die).$dlm; 
    echo $die;
    exit;
  }
  
  $hst = $_SESSION["dbhost"];
  $usr = $_SESSION["dbuser"];
  $pas = $_SESSION["dbpass"];
  $dbn = $_SESSION["dbname"];
  $prt = $_SESSION["dbport"];
  
  $con = new mysqli($hst, $usr, $pas, $dbn, $prt);
  
  if($con->connect_errno) {
     $die = $con->connect_error;
     $die = "{\"status\":\"error\",\"message\":\"$die\",\"data\":\"\"}";
     $die = Encode($die).$dlm;  
     echo $die;
     exit;
  }
  
  $sql = $jso->sqltext;

  if(!trim($sql)) {
    $die = "{\"status\":\"error\",\"message\":\"Empty SQL\",\"data\":\"\"}";
    $die = Encode($die).$dlm; 
    echo $die;
    exit;
  }
  
  $obj = $con->query($sql);

  if($con->error) {
  	$res->status  = "error";
  	$res->message = $con->error;
  	$res->data    = "";
  } else {
  	$res->status  = "oke";
  	$res->message = "Execute Query Success";
  	
  	if(isSelect($sql)) {
  	  if($obj->num_rows)
  	  while($row = $obj->fetch_object()) {
  	  	$arr = array();
  	  	if($row) foreach($row as $idx => $itm) {
  	  		$arr[$idx] = utf8_encode($itm);
  	  	}
  	    $dat[] = $arr;
  	  }
  	
  	  $xxx = 0;
  	  foreach($obj->fetch_fields() as $val) {
  	    $xxx++;
  	    $fld[$xxx] = $val->name;  
  	  }
  	
  	  $res->data->field  = $fld;
  	  $res->data->record = $dat; 
    } else {
    	$res->data->field  = "";
  	  $res->data->record = ""; 
    }
  }
  $obj->free;

  $jso = json_encode($res);
  $jso = str_replace(":null", ":\"\"", $jso);
 
  if(!$jso) {
    $die = "{\"status\":\"error\",\"message\":\"Empty tunnel result\",\"data\":\"\"}";
    $die = Encode($die).$dlm; 
    echo $die;
    exit;
  }
  
  $jso = Encode($jso).$dlm;
  
  echo $jso;
  mysqli_close();
?>