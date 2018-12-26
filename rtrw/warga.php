 <?php
    include_once 'config.php';
	include_once 'key.php';
	
	$default = '{"data": [{"no":"","id":"","nama":"","blok":"","no_blok":""}]}';
	
	if (isset($_GET['key'])){
		
		$key = $_GET['key'];
		$act = $_GET['act'];
				
			if ($key == $genkey) {
				
				if ($act=='view'){
					$i = 0;
					$query = 'select warga.id_warga, warga.nama, (master_blok.blok), warga.nomer_blok, warga.status_aktif from warga left join master_blok
					on warga.blok = master_blok.id_blok where main = "1" order by blok, id_warga';				
					
					$result = $mysqli->query($query);
					if (mysqli_num_rows($result) > 0){
						$arr = array();
						while($data = $result->fetch_array()){
							$i++;
							  $temp = array(	
								"no"=>$i,
								"id"=>$data["id_warga"],
								"nama"=>$data["nama"],
								"blok"=>$data["blok"],
								"no_blok"=>$data["nomer_blok"],
								"status_aktif"=>$data["status_aktif"]
								);						
							array_push($arr, $temp);
						}
							$warga = json_encode($arr);
							echo "{\"data\": $warga }";						
					}				
				} elseif ($act=='detail'){
					if (isset($_POST['nama'])){$nama=$_POST['nama'];}else{$nama='';}
					
					$query = 'select id_warga, nik, nama, tmp_lahir, tgl_lahir, alamat, kota, blok, nomer_blok, agama, jenis_kelamin,
							pekerjaan, status_aktif,status_tmp_tinggal, keterangan, status_pernikahan, status_hubungan, pendidikan, bulan_masuk, tahun_masuk
							from warga where nama = "'.$nama.'"';
					$result = $mysqli->query($query);										
					if (mysqli_num_rows($result) > 0){
							$arr = array();
							while($data = $result->fetch_array()){								
								$temp = array(
									"id_warga"=>$data["id_warga"],
									"nik"=>$data["nik"],
									"nama"=>$data["nama"],
									"tmp_lahir"=>$data["tmp_lahir"],
									"tgl_lahir"=>$data["tgl_lahir"],
									"alamat"=>$data["alamat"],
									"kota"=>$data["kota"],
									"blok"=>$data["blok"],
									"nomer_blok"=>$data["nomer_blok"],
									"agama"=>$data["agama"],
									"jenis_kelamin"=>$data["jenis_kelamin"],
									"pekerjaan"=>$data["pekerjaan"],
									"status_aktif"=>$data["status_aktif"],
									"status_tmp_tinggal"=>$data["status_tmp_tinggal"],
									"keterangan"=>$data["keterangan"],
									"status_pernikahan"=>$data["status_pernikahan"],
									"status_hubungan"=>$data["status_hubungan"],
									"pendidikan"=>$data["pendidikan"],
									"bulan_masuk"=>$data["bulan_masuk"],
									"tahun_masuk"=>$data["tahun_masuk"]
								);						
								array_push($arr, $temp);
							}
								$detail = json_encode($arr);
								echo "{\"data\": $detail }";						
					}
					
				} elseif ($act=='insert'){
					// insert ke tabel kas
					if (isset($_POST['nik'])){$nik=$_POST['nik'];}else{$nik='';}
					if (isset($_POST['nama'])){$nama=$_POST['nama'];}else{$nama='';}
					if (isset($_POST['tmp_lahir'])){$tmp_lahir=$_POST['tmp_lahir'];}else{$tmp_lahir='';}
					if (isset($_POST['tgl_lahir'])){$tgl_lahir=$_POST['tgl_lahir'];}else{$tgl_lahir='';}
					if (isset($_POST['alamat'])){$alamat=$_POST['alamat'];}else{$alamat='';}
					if (isset($_POST['kota'])){$kota=$_POST['kota'];}else{$kota='';}
					if (isset($_POST['blok'])){$blok=$_POST['blok'];}else{$blok='';}
					if (isset($_POST['nomer_blok'])){$nomer_blok=$_POST['nomer_blok'];}else{$nomer_blok='';}
					if (isset($_POST['agama'])){$agama=$_POST['agama'];}else{$agama='';}
					if (isset($_POST['jenis_kelamin'])){$jenis_kelamin=$_POST['jenis_kelamin'];}else{$jenis_kelamin='';}
					if (isset($_POST['pekerjaan'])){$pekerjaan=$_POST['pekerjaan'];}else{$pekerjaan='';}
					if (isset($_POST['main'])){$main=$_POST['main'];}else{$main='';}
					if (isset($_POST['parent'])){$parent=$_POST['parent'];}else{$parent='';}
					if (isset($_POST['status_aktif'])){$status_aktif=$_POST['status_aktif'];}else{$status_aktif='';}
					if (isset($_POST['status_tmp_tinggal'])){$status_tmp_tinggal=$_POST['status_tmp_tinggal'];}else{$status_tmp_tinggal='';}
					if (isset($_POST['keterangan'])){$keterangan=$_POST['keterangan'];}else{$keterangan='';}
					if (isset($_POST['status_pernikahan'])){$status_pernikahan=$_POST['status_pernikahan'];}else{$status_pernikahan='';}
					if (isset($_POST['status_hubungan'])){$status_hubungan=$_POST['status_hubungan'];}else{$status_hubungan='';}
					if (isset($_POST['pendidikan'])){$pendidikan=$_POST['pendidikan'];}else{$pendidikan='';}
					if (isset($_POST['telp'])){$telp=$_POST['telp'];}else{$telp='';}
					if (isset($_POST['bulan_masuk'])){$bulan_masuk=$_POST['bulan_masuk'];}else{$bulan_masuk='0';}
					if (isset($_POST['tahun_masuk'])){$tahun_masuk=$_POST['tahun_masuk'];}else{$tahun_masuk='0';}
												
					$query = 'INSERT INTO warga (nik, nama, tmp_lahir, tgl_lahir, alamat, kota, blok, nomer_blok, agama, jenis_kelamin,
							pekerjaan, main, parent, status_aktif,status_tmp_tinggal, keterangan, status_pernikahan, status_hubungan, pendidikan, dateupdate)
							VALUES ("'.$nik.'","'.$nama.'","'.$tmp_lahir.'","'.$tgl_lahir.'","'.$alamat.'","'.$kota.'","'.$blok.'","'.$nomer_blok.'","'.$agama.'","'.$jenis_kelamin.'",
							"'.$pekerjaan.'","'.$main.'","'.$parent.'","'.$status_aktif.'","'.$status_tmp_tinggal.'","'.$keterangan.'","'.$status_pernikahan.'","'.$status_hubungan.'","'.$pendidikan.'",now())';									
													
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
					
				} elseif ($act=='edit'){
					if (isset($_POST['id_warga'])){$id_warga=$_POST['id_warga'];}else{$id_warga='';}
					if (isset($_POST['nik'])){$nik=$_POST['nik'];}else{$nik='';}
					if (isset($_POST['nama'])){$nama=$_POST['nama'];}else{$nama='';}
					if (isset($_POST['tmp_lahir'])){$tmp_lahir=$_POST['tmp_lahir'];}else{$tmp_lahir='';}
					if (isset($_POST['tgl_lahir'])){$tgl_lahir=$_POST['tgl_lahir'];}else{$tgl_lahir='';}
					if (isset($_POST['alamat'])){$alamat=$_POST['alamat'];}else{$alamat='';}
					if (isset($_POST['kota'])){$kota=$_POST['kota'];}else{$kota='';}
					if (isset($_POST['blok'])){$blok=$_POST['blok'];}else{$blok='';}
					if (isset($_POST['nomer_blok'])){$nomer_blok=$_POST['nomer_blok'];}else{$nomer_blok='';}
					if (isset($_POST['agama'])){$agama=$_POST['agama'];}else{$agama='';}
					if (isset($_POST['jenis_kelamin'])){$jenis_kelamin=$_POST['jenis_kelamin'];}else{$jenis_kelamin='';}
					if (isset($_POST['pekerjaan'])){$pekerjaan=$_POST['pekerjaan'];}else{$pekerjaan='';}
					if (isset($_POST['main'])){$main=$_POST['main'];}else{$main='';}
					if (isset($_POST['parent'])){$parent=$_POST['parent'];}else{$parent='';}
					if (isset($_POST['status_aktif'])){$status_aktif=$_POST['status_aktif'];}else{$status_aktif='';}
					if (isset($_POST['status_tmp_tinggal'])){$status_tmp_tinggal=$_POST['status_tmp_tinggal'];}else{$status_tmp_tinggal='';}
					if (isset($_POST['keterangan'])){$keterangan=$_POST['keterangan'];}else{$keterangan='';}
					if (isset($_POST['status_pernikahan'])){$status_pernikahan=$_POST['status_pernikahan'];}else{$status_pernikahan='';}
					if (isset($_POST['status_hubungan'])){$status_hubungan=$_POST['status_hubungan'];}else{$status_hubungan='';}
					if (isset($_POST['pendidikan'])){$pendidikan=$_POST['pendidikan'];}else{$pendidikan='';}
					if (isset($_POST['telp'])){$telp=$_POST['telp'];}else{$telp='';}
					if (isset($_POST['bulan_masuk'])){$bulan_masuk=$_POST['bulan_masuk'];}else{$bulan_masuk='0';}
					if (isset($_POST['tahun_masuk'])){$tahun_masuk=$_POST['tahun_masuk'];}else{$tahun_masuk='0';}
												
					$query = 'UPDATE warga SET nik="'.$nik.'", nama="'.$nama.'", tmp_lahir="'.$tmp_lahir.'", tgl_lahir="'.$tgl_lahir.'", alamat="'.$alamat.'", kota="'.$kota.'",
							blok="'.$blok.'", nomer_blok="'.$nomer_blok.'", agama="'.$agama.'", jenis_kelamin="'.$jenis_kelamin.'",
							pekerjaan="'.$pekerjaan.'", main="'.$main.'", parent="'.$parent.'", status_aktif="'.$status_aktif.'",
							status_tmp_tinggal="'.$status_tmp_tinggal.'", keterangan="'.$keterangan.'", status_pernikahan="'.$status_pernikahan.'",
							status_hubungan="'.$status_hubungan.'", pendidikan="'.$pendidikan.'", bulan_masuk="'.$bulan_masuk.'", tahun_masuk="'.$tahun_masuk.'", dateupdate=now() 
							where id_warga="'.$id_warga.'"' ;									
													
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
					
				} elseif ($act=='delete'){
					
					if (isset($_POST['id_warga'])){$id_warga=$_POST['id_warga'];}else{$id_warga='';}					
												
					$query = 'DELETE FROM warga where id_warga = "'.$id_warga.'"';
					
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
					
				} elseif($act=='kk'){
					if (isset($_POST['id_warga'])){$id_warga=$_POST['id_warga'];}else{$id_warga='';}
					
					$query = 'select nik, nama, tmp_lahir, tgl_lahir, alamat, kota, blok, nomer_blok, agama, jenis_kelamin,
							pekerjaan, status_aktif,status_tmp_tinggal, keterangan, status_pernikahan, status_hubungan, pendidikan
							from warga where parent = "'.$id_warga.'" ';
					$result = $mysqli->query($query);										
					if (mysqli_num_rows($result) > 0){
							$arr = array();
							while($data = $result->fetch_array()){								
								$temp = array(	
									"nik"=>$data["nik"],
									"nama"=>$data["nama"],
									"tmp_lahir"=>$data["tmp_lahir"],
									"tgl_lahir"=>$data["tgl_lahir"],
									"alamat"=>$data["alamat"],
									"kota"=>$data["kota"],
									"blok"=>$data["blok"],
									"nomer_blok"=>$data["nomer_blok"],
									"agama"=>$data["agama"],
									"jenis_kelamin"=>$data["jenis_kelamin"],
									"pekerjaan"=>$data["pekerjaan"],
									"status_aktif"=>$data["status_aktif"],
									"status_tmp_tinggal"=>$data["status_tmp_tinggal"],
									"keterangan"=>$data["keterangan"],
									"status_pernikahan"=>$data["status_pernikahan"],
									"status_hubungan"=>$data["status_hubungan"],
									"pendidikan"=>$data["pendidikan"]
								);						
								array_push($arr, $temp);
							}
								$detail = json_encode($arr);
								echo "{\"data\": $detail }";		
					}
				}

					
			}	
		}
    
    ?>
