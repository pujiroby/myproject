 <?php
   		
	 include_once 'config.php';
	 include_once 'key.php';
	 
	 if (isset($_GET['key'])){
		
		$key = $_GET['key'];	
		
				
		if ($key == $genkey) {
			
		$nama = '';
		$tahun = '';
		$bulan = '';
		
			if(isset($_POST['nama'])){
				$nama = $_POST['nama'];	
			}
			
			if(isset($_POST['tahun'])){
				$tahun = $_POST['tahun'];			
			}

			$query = 'select bulan_masuk, tahun_masuk from warga where nama = "'.$nama.'"';
			$result = $mysqli->query($query);
			$awalmasuk = $result->fetch_array();
			if (mysqli_num_rows($result) > 0){
					$bulan_masuk = $awalmasuk['bulan_masuk'];
					$tahun_masuk = $awalmasuk['tahun_masuk'];			
				}
				
			$i = 0;
			
			$query = 'select bb.id_bulan,bb.bulan, IFNULL(iu.status,0) as sts from
						(select * from master_bulan)as bb
						left join (select iuran.* from iuran where id_warga = (select id_warga from warga where nama = "'.$nama.'")
						and tahun = "'.$tahun.'")as iu on bb.id_bulan = iu.bulan order by id_bulan' ;
						
			$result = $mysqli->query($query);						
			if (mysqli_num_rows($result) > 0){
				$arr = array();
				while($data = $result->fetch_array())
				{
					$i++;
					  $temp = array(
						"bulan"=>$data['bulan'],
						"status"=>$data['sts']
				);
				
				array_push($arr, $temp);
				}
				$warga = json_encode($arr);
				echo "{\"bulan_masuk\":$bulan_masuk,\"tahun_masuk\":$tahun_masuk,\"data\": $warga }";
				} 
		} 
	}
    
 ?>
