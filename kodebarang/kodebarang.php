 <?php
    include_once 'config.php';
	
	$default = '{"data": [{"no":"","kode":"","nama":"","golongan":""}]}';
	
	if (isset($_GET['key'])&& isset($_POST['cari']) && !empty($_POST['cari'])){
		
		$key = $_GET['key'];
		$cari = $_POST['cari'];
		$modal = 'modal ';
		$habis_pakai = 'persediaan ';
		
		$aset = '';
		$persediaan = '';
		$caritext = $cari;
				
		if(strpos($cari,$modal) !== false){
				$aset = 'and a.kode not like "07%" ';				
				$caritext = substr($cari, 6);
		} elseif(strpos($cari,$habis_pakai) !== false){
				$persediaan = 'and a.kode like "07%" ';				
				$caritext = substr($cari, 11);
		} 	
		
		if ($key == '1234567') {

			$i = 0;
			$sql = 'select a.kode, a.nama, g.golongan from
					(select mid(master_kodekelompokbarangsubsub.kodebarang,1,8)as gol, 
					(master_kodekelompokbarangsubsub.kodebarang)as kode,
					(master_kodekelompokbarangsubsub.namakelompokbarangsubsub)as nama from master_kodekelompokbarangsubsub
					where master_kodekelompokbarangsubsub.kelompokbarangsubsub <> "00")as a
					left join (select master_kodekelompokbarangsub.kodekelompokbarangsub, (master_kodekelompokbarangsub.namakelompokbarangsub)as golongan
					from master_kodekelompokbarangsub)as g
					on a.gol = g.kodekelompokbarangsub where a.nama like "%'.$caritext.'%"';
			
					
			$query = $sql.$aset.$persediaan.' limit 500';
			
			$result = $mysqli->query($query);
			if (mysqli_num_rows($result) > 0){
				$arr = array();
				while($data = $result->fetch_array())
				{
				$i++;
				  $temp = array(
					"no"=>$i,
					"kode"=>$data["kode"],
					"nama"=>$data["nama"],
					"golongan"=>$data["golongan"]			
				);
				
				array_push($arr, $temp);
				}
				$barang = json_encode($arr);
				echo "{\"data\": $barang }";
				} else {
					echo $default;
				}
		} else {
			echo $default;
		}
	} else {
		echo $default;
	}
	

    
    ?>
