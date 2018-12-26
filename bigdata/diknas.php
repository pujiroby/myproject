<?php
	include 'config.php';
	
	$query = 'select b.*,r.ruangan  from 
					(select 
					transaksi_kib_b.kodelokasi,
					master_user.namapengguna,
					transaksi_kib_b.kodebarang,
					master_kodekelompokbarangsubsub.namakelompokbarangsubsub,
					transaksi_kib_b.tahun,
					transaksi_kib_b.nomerregister,
					transaksi_kib_b.koderuang,
					transaksi_kib_b.type,
					transaksi_kib_b.merk,
					transaksi_kib_b.ukuran,
					transaksi_kib_b.bahan,
					transaksi_kib_b.nopabrik,
					transaksi_kib_b.norangka,
					transaksi_kib_b.nomesin,
					transaksi_kib_b.nopolisi,
					transaksi_kib_b.nobpkb,
					transaksi_kib_b.hargaperolehan,
					transaksi_kib_b.nomerberitaacara,
					transaksi_kib_b.tanggalberitaacara,
					transaksi_kib_b.umurekonomis
					from (transaksi_kib_b left join master_kodekelompokbarangsubsub on transaksi_kib_b.kodebarang = master_kodekelompokbarangsubsub.kodebarang
					) left join master_user on transaksi_kib_b.kodelokasi = `master_user`.username
					where transaksi_kib_b.kodelokasi = "133100030100000" and transaksi_kib_b.tahun between "1901" and "2017")b 
					left join (select master_kodelokasiruangan.koderuangan, master_kodelokasiruangan.ruangan 
					from master_kodelokasiruangan where master_kodelokasiruangan.kodelokasi = "133100030100000")r
					on b.koderuang = r.koderuangan' ;
					
		$result = $mysqli->query($query);										
					if (mysqli_num_rows($result) > 0){
							$arr = array();
							while($data = $result->fetch_array()){								
								$temp = array(
												"skpd"=>$data['kodelokasi'],
												"pengguna"=>$data['namapengguna'],
												"kodebarang"=>$data['kodebarang'],
												"namabarang"=>$data['namakelompokbarangsubsub'],
												"register"=>$data['nomerregister'],
												"tahun"=>$data['tahun'],
												"ruangan"=>$data['ruangan'],
												"type"=>$data['type'],
												"merk"=>$data['merk'],
												"ukuran"=>$data['ukuran'],
												"bahan"=>$data['bahan'],
												"nopabrik"=>$data['nopabrik'],
												"norangka"=>$data['norangka'],
												"nomesin"=>$data['nomesin'],
												"nopolisi"=>$data['nopolisi'],
												"nobpkb"=>$data['nobpkb'],
												"nomerberitaacara"=>$data['nomerberitaacara'],
												"tanggalberitaacara"=>$data['tanggalberitaacara'],												
												"hargaperolehan"=>$data['hargaperolehan'],
												"umurekonomis"=>$data['umurekonomis']																							
								);						
								array_push($arr, $temp);
							}
								$detail = json_encode($arr);
								echo "{\"data\": $detail }";						
					}
?>