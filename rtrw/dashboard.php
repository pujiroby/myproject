<?php
	include_once 'config.php';
	include_once 'key.php';
	
	if (isset($_GET['key'])){$key = $_GET['key'];}
	if ($key = $genkey){
		
		$query = 'select count(id_warga) as jml from warga where main = "1" and status_aktif = "1"';
		$result = $mysqli->query($query);
		$data = $result->fetch_array();
		$respon['jmlkk'] = $data['jml'];								
				
		$query = 'select ifnull((sum(if(kas.aksi=1,kas.jumlah,-(kas.jumlah)))),0)as saldo from kas';				
		$result = $mysqli->query($query);			
		$data = $result->fetch_array(); 
		$respon['kas'] = $data['saldo'];	
	
		echo json_encode($respon);
	}
?>