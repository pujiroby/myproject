 <?php
   		
	 include_once 'config.php';
	 include_once 'key.php';
	 
	 if (isset($_GET['key'])){
		
		$key = $_GET['key'];	
		
				
		if ($key == $genkey) {
				if (isset($_POST['nama'])){$nama=$_POST['nama'];}else{$nama='';}
				if (isset($_POST['tanggal'])){$tanggal=$_POST['tanggal'];}else{$tanggal=date('Y-m-d');}
				if (isset($_POST['bulan'])){$bulan=$_POST['bulan'];}else{$bulan='';}
				if (isset($_POST['tahun'])){$tahun=$_POST['tahun'];}else{$tahun='';}
				if (isset($_POST['id_jenis'])){$id_jenis=$_POST['id_jenis'];}else{$id_jenis='1';}
				if (isset($_POST['user'])){$user=$_POST['user'];}else{$user='';}
				if (isset($_POST['keterangan'])){$keterangan=$_POST['keterangan'];}else{$keterangan='';}	
				if (isset($_POST['status'])){$status=$_POST['status'];}else{$status='1';}
												
				$query = 'INSERT INTO iuran (id_warga, tanggal, bulan, tahun, id_jenis, keterangan, status, user, date_update) VALUES';
				
				foreach ($bulan as $key => $value) {
								$query .= '((select id_warga from warga where nama="'.$nama.'"),"'.$tanggal.'","'.$value.'","'.$tahun.'","'.$id_jenis.'","'.$keterangan.'","'.$status.'","'.$user.'",now()), ';
						}										
				
				$query = rtrim($query,', ');
				$result = $mysqli->query($query);
				if ($result){
					$respon['value']=1;
					$respon['pesan']='Sukses';
					echo json_encode($respon);
				}else{
					$respon['value']=0;
					$respon['pesan']='Gagal';
					echo json_encode($respon);
				}	
		
		} 
	}
    
 ?>
