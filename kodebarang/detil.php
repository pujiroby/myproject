 <?php
    include_once 'config.php';
	
	$default = '{"data": [{"no":"","kode":"","nama":"","golongan":""}]}';
	
	if (isset($_GET['key'])&& isset($_POST['cari']) && !empty($_POST['cari'])){
		
		$key = $_GET['key'];
		$cari = $_POST['cari'];
		
		if (substr($_POST['cari'],0,2) == '07'){
			$kata = substr($cari,0,10); 
		} else {
			$kata = substr($cari,0,8);
		}
		
			
		if ($key == '1234567') {

			$i = 0;
			$sql = 'select a.kode, a.nama, g.golongan, a.spek from
					(select mid(master_kodekelompokbarangsubsub.kodebarang,1,8)as gol, 
					(master_kodekelompokbarangsubsub.kodebarang)as kode,
					(master_kodekelompokbarangsubsub.namakelompokbarangsubsub)as nama, (master_kodekelompokbarangsubsub.spesifikasi) as spek from master_kodekelompokbarangsubsub where master_kodekelompokbarangsubsub.kelompokbarangsubsub <> "00" )as a
					left join (select master_kodekelompokbarangsub.kodekelompokbarangsub, (master_kodekelompokbarangsub.namakelompokbarangsub)as golongan
					from master_kodekelompokbarangsub)as g
					on a.gol = g.kodekelompokbarangsub where a.kode like "'.$kata.'%"';
			
					
			$query = $sql;
			
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
					"golongan"=>$data["spek"]			
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
