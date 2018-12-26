 <?php
   		
	 include_once 'config.php';
	 include_once 'key.php';
	 
	 if (isset($_GET['key'])){
		
		$key = $_GET['key'];	
		
				
		if ($key == $genkey) {
				if (isset($_POST['nama'])){$nama=$_POST['nama'];}else{$nama='';}				
				if (isset($_POST['bulan'])){$bulan=$_POST['bulan'];}else{$bulan='';}
				if (isset($_POST['tahun'])){$tahun=$_POST['tahun'];}else{$tahun='';}				
												
				$query = 'DELETE FROM iuran WHERE';
				
				foreach ($bulan as $key => $value) {
								$query .= '(id_warga = (select id_warga from warga where nama = "'.$nama.'") and bulan = "'.$value.'" and tahun = "'.$tahun.'")or ';
						}										
				
				$query = rtrim($query,'or ');
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
