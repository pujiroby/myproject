 <?php
    include_once 'config.php';
	if (isset($_GET['key'])&& isset($_POST['sub']) && !empty($_POST['sub'])){
		
		$key = $_GET['key'];
		$sub = $_POST['sub'];
		if ($key == '1234567') {

		$i = 0;
		$sql = 'select master_kodekelompokbarangsubsub.kodebarang as kode,
					master_kodekelompokbarangsubsub.namakelompokbarangsubsub as nama,
					if((mid(master_kodekelompokbarangsubsub.kodebarang,1,2)) = "01" ,"tanah",
					if((mid(master_kodekelompokbarangsubsub.kodebarang,1,2)) = "02","Peralatan Mesin",
					if((mid(master_kodekelompokbarangsubsub.kodebarang,1,2)) = "03","Bangunan",
					if((mid(master_kodekelompokbarangsubsub.kodebarang,1,2)) = "04","Jaringan",
					if((mid(master_kodekelompokbarangsubsub.kodebarang,1,2)) = "05","Lain-lain",
					if((mid(master_kodekelompokbarangsubsub.kodebarang,1,2)) = "06","KDP",
					if((mid(master_kodekelompokbarangsubsub.kodebarang,1,2)) = "07","Persediaan",
					if((mid(master_kodekelompokbarangsubsub.kodebarang,1,2)) = "08","Tak Berwujud",""))))))))as golongan
					from master_kodekelompokbarangsubsub
					where (master_kodekelompokbarangsubsub.kelompokbarangsubsub = "00"
					or master_kodekelompokbarangsubsub.kelompokbarangsubsub = "0000")
					and master_kodekelompokbarangsubsub.kelompokbarangsub <> "00" ';
		$pilih = '';
		switch ($sub) {
				case 'Tanah' :
					$pilih = '01';
					break;
				case 'Peralatan dan Mesin' :
					$pilih = '02';
					break;
				case 'Bangunan' :
					$pilih = '03';
					break;
				case 'Jalan dan Jaringan' :
					$pilih = '04';
					break;
				case 'Lain-lain' :
					$pilih = '05';
					break;
				case 'KDP' :
					$pilih = '06';
					break;
				case 'Persediaan' :
					$pilih = '07';
					break;
				case 'Tak Berwujud' :
					$pilih = '08';
					break;
		}
		
			
		$query = $sql.'and master_kodekelompokbarangsubsub.kodebarang like "'.$pilih.'%" order by nama ASC';
		$result = $mysqli->query($query); 
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
			echo '{"data": [{"no":"","kode":"","nama":"","golongan":""}]}';
		}
	} else{
		echo '{"data": [{"no":"","kode":"","nama":"","golongan":""}]}';
	}
	

    
    ?>
