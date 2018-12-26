<?php
	include 'config.php';
	
	$BAList_array =array();
	$masterBA_array = array();
	$detailBA_array = array();
	
	$fetch_masterBA = mysqli_query($mysqli, "select * from transaksi_pengadaan where kodelokasi = '133100040400000' limit 100") or die(mysqli_error($mysqli));
	while ($row_masterBA = mysqli_fetch_assoc($fetch_masterBA)) {
    $masterBA_array['nomerberitaacara'] = $row_masterBA['nomerberitaacara'];
	
	$masterBA_array['detail'] = array();
	
	$fetch_detailBA = mysqli_query($mysqli, "select * from transaksi_pengadaandetail where nomerberitaacara = '".$row_masterBA['nomerberitaacara']."'") or die(mysqli_error($mysqli));
    while ($row_detailBA = mysqli_fetch_assoc($fetch_detailBA)) {
        $detailBA_array['kodebarang']=$row_detailBA['kodebarang'];
        $detailBA_array['jumlah']=$row_detailBA['jumlahbarang'];
		$detailBA_array['hargasatuan']=$row_detailBA['hargasatuan'];
		$detailBA_array['hargatotal']=$row_detailBA['hargatotal'];
        array_push($masterBA_array['detail'],$detailBA_array);
    }
	
	array_push($BAList_array,$masterBA_array);
	}

/*$jsonData = json_encode($usersList_array, JSON_PRETTY_PRINT);*/
$jsonData = json_encode($BAList_array);

echo $jsonData; 
?>