<?php
	 include_once 'config.php';
	 include_once 'key.php';
	 
	 if (isset($_GET['key'])){
		 
			$key = $_GET['key'];				
			if ($key == $genkey) {
		 
				if(isset($_GET['act'])){
				
					$act = $_GET['act'];
					
						if ($act=='view'){
							// aksi tampil data
									$i = 0;									
									
									if (isset($_POST['tglawal'])){$tglawal=$_POST['tglawal'];}else{$tglawal=date('Y-m-d');}
									if (isset($_POST['tglakhir'])){$tglakhir=$_POST['tglakhir'];}else{$tglakhir=date('Y-m-d');}
									
									$query = 'select sum(if(kas.aksi=1,kas.jumlah,-(kas.jumlah)))as saldo from kas
												where kas.tanggal < "'.$tglawal.'";';
									$result = $mysqli->query($query);			
									$data = $result->fetch_array(); 
									$awal = $data['saldo'];
									
									$query = 'select sum(if(kas.aksi=1,kas.jumlah,-(kas.jumlah)))as saldo from kas
												where tanggal between "'.$tglawal.'" and "'.$tglakhir.'"';
									$result = $mysqli->query($query);			
									$data = $result->fetch_array(); 
									$akhir = $data['saldo'];									
									
									$query = 'select kas.id_kas, kas.tanggal, kas.keterangan, kas.no_bukti, kas.aksi, kas.jumlah from kas
												where tanggal between "'.$tglawal.'" and "'.$tglakhir.'"';
									
									$result = $mysqli->query($query);						
									if (mysqli_num_rows($result) > 0){
										$arr = array();
										while($data = $result->fetch_array())
										{
											$i++;
											  $temp = array(
												"id_kas"=>$data['id_kas'],
												"tanggal"=>$data['tanggal'],
												"keterangan"=>$data['keterangan'],
												"no_bukti"=>$data['no_bukti'],
												"aksi"=>$data['aksi'],
												"jumlah"=>$data['jumlah']
											);										
											array_push($arr, $temp);
										}
										$kas = json_encode($arr);
										echo "{\"awal\":\"$awal\",\"saldo\":\"$akhir\",\"data\": $kas }";
									}else{
										$arr = array(
													array(
													"id_kas"=>"",
													"tanggal"=>"",
													"keterangan"=>"",
													"no_bukti"=>"",
													"aksi"=>"",
													"jumlah"=>""
													)
												);
										$kas = json_encode($arr);
										echo "{\"awal\":\"$awal\",\"saldo\":\"$akhir\",\"data\": $kas }";
									}
 
						} elseif ($act=='insert'){
								// insert ke tabel kas
								if (isset($_POST['tanggal'])){$tanggal=$_POST['tanggal'];}else{$tanggal=date('Y-m-d');}
								if (isset($_POST['keterangan'])){$keterangan=$_POST['keterangan'];}else{$keterangan='';}
								if (isset($_POST['no_bukti'])){$no_bukti=$_POST['no_bukti'];}else{$no_bukti='';}
								if (isset($_POST['aksi'])){$aksi=$_POST['aksi'];}else{$aksi='';}
								if (isset($_POST['jumlah'])){$jumlah=$_POST['jumlah'];}else{$jumlah='';}
								if (isset($_POST['user'])){$user=$_POST['user'];}else{$user='';}
												
									$query = 'INSERT INTO kas (tanggal, keterangan, no_bukti, aksi, jumlah, user, data_update)
												VALUES ("'.$tanggal.'","'.$keterangan.'","'.$no_bukti.'","'.$aksi.'","'.$jumlah.'","'.$user.'",now())';									
													
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

						} elseif ($act=='detail'){
								if (isset($_POST['detail'])){$detail=$_POST['detail'];}else{$detail=' - ';}
								$dtl = explode("-",$detail);
								
								$query = 'select kas.tanggal, kas.keterangan, kas.no_bukti, kas.jumlah from kas where kas.id_kas = "'.$dtl[0].'";';
								
								$i = 0;
								$result = $mysqli->query($query);						
									if (mysqli_num_rows($result) > 0){
										$arr = array();
										while($data = $result->fetch_array())
										{
											$i++;
											  $temp = array(												
												"tanggal"=>$data['tanggal'],
												"keterangan"=>$data['keterangan'],
												"no_bukti"=>$data['no_bukti'],
												"jumlah"=>$data['jumlah']		
											);										
											array_push($arr, $temp);
										}
										$kas = json_encode($arr);
										echo "{\"data\": $kas }";
									}else{
										$arr = array(
													array(													
													"tanggal"=>"",
													"keterangan"=>"",
													"no_bukti"=>"",
													"jumlah"=>""
													)
												);
										$kas = json_encode($arr);
										echo "{\"data\": $kas }";
									}
								
						} elseif ($act=='edit'){
							if (isset($_POST['id_kas'])){$id_kas=$_POST['id_kas'];}else{$id_kas=date('id_kas');}
							if (isset($_POST['tanggal'])){$tanggal=$_POST['tanggal'];}else{$tanggal=date('Y-m-d');}
							if (isset($_POST['keterangan'])){$keterangan=$_POST['keterangan'];}else{$keterangan='';}
							if (isset($_POST['no_bukti'])){$no_bukti=$_POST['no_bukti'];}else{$no_bukti='';}
							if (isset($_POST['aksi'])){$aksi=$_POST['aksi'];}else{$aksi='';}
							if (isset($_POST['jumlah'])){$jumlah=$_POST['jumlah'];}else{$jumlah='';}
							if (isset($_POST['user'])){$user=$_POST['user'];}else{$user='';}
							
							$query = 'UPDATE kas SET tanggal ="'.$tanggal.'", keterangan = "'.$keterangan.'", no_bukti = "'.$no_bukti.'", jumlah = "'.$jumlah.'", user = "'.$user.'", data_update = now()
										WHERE id_kas = "'.$id_kas.'"';
														
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
							
						}elseif ($act=='delete'){
							if (isset($_POST['id_kas'])){$id_kas=$_POST['id_kas'];}else{$id_kas=date('id_kas');}							
							
							$query = 'DELETE FROM kas WHERE id_kas = "'.$id_kas.'"';
														
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
				
		 }
		 
	 }
?>