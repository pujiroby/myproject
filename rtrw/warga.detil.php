 <?php
    include_once 'config.php';
	include_once 'key.php';
	
	$default = '{"data": [{"no":"","id":"","nama":"","blok":"","no_blok":""}]}';
	
	if (isset($_GET['key'])){
		
		$key = $_GET['key'];
		$cari = '';
		$cari_text = '';
		$cari_id = '';
		$id = '';
		
		if(isset($_POST['id'])){
			$id_warga = $_POST['id'];	
		}		
				
		if ($key == $genkey) {

			$i = 0;
			$sql = 'select * from warga where id_warga = "'.$id_warga.'" ';					
			
			$result = $mysqli->query($sql);
			if (mysqli_num_rows($result) > 0){
				$arr = array();
				while($data = $result->fetch_array())
				{					
					  $temp = array(
						"nik"=>$data["nik"],
						"nama"=>$data["nama"],
						"tmp_tgl_lahir"=>$data["tmp_tgl_lahir"],
						"alamat"=>$data["alamat"],
						"kota"=>$data["kota"],
						"blok"=>$data["blok"],
						"nomer_blok"=>$data["nomer_blok"],
						"agama"=>$data["agama"],
						"jenis_kelamin"=>$data["jenis_kelamin"],
						"pekerjaan"=>$data["pekerjaan"]
				);
				
				array_push($arr, $temp);
				}
				$warga = json_encode($arr);
				echo "{\"data\": $warga }";
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
