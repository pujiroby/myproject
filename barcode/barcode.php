<?php
    include_once 'config.php';
	include_once 'key.php';	
	
	if (isset($_GET['key'])){
		
		$key = $_GET['key'];		
				
		if ($key == $genkey) {
			
			if (isset($_POST['scan'])){$scan=$_POST['scan'];}else{$scan='';}
			
			$jml = strlen($scan);
			
			if ($jml==33){
				$skpd = substr($scan,0,15);
				$kodebarang = substr($scan,15,10);
				$register = substr($scan,25,4);
				$tahun = substr($scan,29,4);
			} else if ($jml==30){
				$skpdlama = substr($scan,0,12);
				$skpdarray = array("133108010000"=>"133100030100000",
									"133107010000"=>"133100030200000",
									"133122040000"=>"133100030200020",
									"133105010000"=>"133100030300000",
									"133115010000"=>"133100040200000",
									"133106010000"=>"133100031000000",
									"133116010000"=>"133100030700000",
									"133105020000"=>"133100030400000",
									"133110010000"=>"133100030800000",
									"133109030000"=>"133100030900000",
									"133109020000"=>"133100030500000",
									"133109010000"=>"133100030600000",
									"133112020000"=>"133100031200000",
									"133117010000"=>"133100031400000",
									"133108020000"=>"133100031500000",
									"133118010000"=>"133100040600000",
									"133109040000"=>"133100040700000",
									"133114020000"=>"133100050000000",
									"133104040100"=>"133100010000111",
									"133104040200"=>"133100010000112",
									"133104040300"=>"133100010000133",
									"133104050100"=>"133100010000123",									
									"133104050200"=>"133100010000121",
									"133104060300"=>"133100010000113",
									"133104060100"=>"133100010000132",
									"133101020100"=>"133100010000131",
									"133104050300"=>"133100010000134",
									"133101020000"=>"133100020000000",
									"133114010000"=>"133100040100000",
									"133119010000"=>"133100040300000",
									"133113030000"=>"133100031300000",
									"133113010000"=>"133100040500000",
									"133151000000"=>"133100000200000",
									"133150000000"=>"133100000100000",
									"133152010000"=>"133100000300000",
									"133154010000"=>"133100000500000",
									"133153000000"=>"133100000400000",									
									"133113040000"=>"133100040400000",									
									"133108030000"=>"133100031600000",
									"133121010000"=>"133100031100000",
									"133111010000"=>"133100031900000",
									"133112010000"=>"133100031800000",
									"133113020000"=>"133100031700000",
									"133151020000"=>"133100000201001",
									"133151030000"=>"133100000201002",
									"133151040000"=>"133100000201003",
									"133151050000"=>"133100000201004",
									"133151060000"=>"133100000201005",
									"133151070000"=>"133100000201006",
									"133151080000"=>"133100000201007",
									"133151090000"=>"133100000201008",
									"133151100000"=>"133100000201009",
									"133151110000"=>"133100000201010",
									"133151120000"=>"133100000201011",
									"133150060000"=>"133100000101005",
									"133150040000"=>"133100000101003",
									"133150030000"=>"133100000101002",
									"133150050000"=>"133100000101004",
									"133150070000"=>"133100000101006",
									"133150080000"=>"133100000101007",
									"133150090000"=>"133100000101008",
									"133150100000"=>"133100000101009",
									"133150110000"=>"133100000101010",
									"133150120000"=>"133100000101011",
									"133150020000"=>"133100000101001",
									"133152070000"=>"133100000301006",
									"133152020000"=>"133100000301001",
									"133152030000"=>"133100000301002",
									"133152040000"=>"133100000301003",
									"133152050000"=>"133100000301004",
									"133152060000"=>"133100000301005",
									"133152080000"=>"133100000301007",
									"133152090000"=>"133100000301008",
									"133152100000"=>"133100000301009",
									"133152110000"=>"133100000301010",
									"133152120000"=>"133100000301011",
									"133152130000"=>"133100000301012",
									"133154120000"=>"133100000501011",
									"133154050000"=>"133100000501004",
									"133154060000"=>"133100000501005",
									"133154070000"=>"133100000501006",
									"133154080000"=>"133100000501007",
									"133154090000"=>"133100000501008",
									"133154100000"=>"133100000501009",
									"133154110000"=>"133100000501010",
									"133154130000"=>"133100000501012",
									"133154020000"=>"133100000501001",
									"133154040000"=>"133100000501003",
									"133154030000"=>"133100000501002",
									"133153060000"=>"133100000401005",
									"133153020000"=>"133100000401001",
									"133153030000"=>"133100000401002",
									"133153040000"=>"133100000401003",
									"133153050000"=>"133100000401004",
									"133153070000"=>"133100000401006",
									"133153080000"=>"133100000401007",
									"133153090000"=>"133100000401009",
									"133153100000"=>"133100000401008",
									"133153110000"=>"133100000401010",
									"133153120000"=>"133100000401011");
				$skpd = $skpdarray[$skpdlama];
				$kodebarang = substr($scan,12,10);
				$register = substr($scan,22,4);
				$tahun = substr($scan,26,4);
			}	
						
			
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
					where transaksi_kib_b.kodelokasi = "'.$skpd.'" and transaksi_kib_b.kodebarang = "'.$kodebarang.'"
					and transaksi_kib_b.nomerregister = "'.$register.'" and transaksi_kib_b.tahun = "'.$tahun.'")b 
					left join (select master_kodelokasiruangan.koderuangan, master_kodelokasiruangan.ruangan 
					from master_kodelokasiruangan where master_kodelokasiruangan.kodelokasi ="'.$skpd.'")r
					on b.koderuang = r.koderuangan';
													
									$result = $mysqli->query($query);
									if (mysqli_num_rows($result) > 0){
										$arr = array();
										while($data = $result->fetch_array())
										{												
											$tahunaset = $data['tahun'];
											$tahunini = date('Y');
											
											if($tahunaset<"2002"){
													$posisi = 'sebelum';
													$umurekonomisbaru = $data['umurekonomis']-(2002-$data['tahun']); 
													$jedaberjalan = $tahunini- 2002 +1;
											} else {
													$posisi = 'sesudah';
													$umurekonomisbaru = $data['umurekonomis'];													
													$jedaberjalan = $tahunini-$tahunaset+1;
											}
											
											if($umurekonomisbaru<=0){
												$beban = 0;
											}else {
												$beban = $data['hargaperolehan']/$umurekonomisbaru;
											}
											
											$barujalan = $umurekonomisbaru-$jedaberjalan;
											
											if($barujalan<0){
													$coverage = 0;
											}else {
													$coverage = $jedaberjalan;
											}

											if($coverage==0){
												$bebanlap = 0;
												$umurberjalan = 0;
												$akm = $data['hargaperolehan'];
												$sisamanfaat = 0;
											}else {
												$bebanlap = $beban;
												$umurberjalan = $coverage;
												$akm = $beban*$coverage;
												$sisamanfaat = $umurekonomisbaru-$umurberjalan;
											}
											
											$nb = $data['hargaperolehan'] - $akm;
											
											
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
												"hargaperolehan"=>"".str_replace(".",",",$data['hargaperolehan'])."",
												"umurekonomis"=>$data['umurekonomis'],
												"sisamanfaat"=>"$sisamanfaat",
												"beban"=>"".round($bebanlap,0)."",
												"akumulasi"=>"".round($akm,0)."",
												"nilaibuku"=>"".round($nb,0).""
											);										
											array_push($arr, $temp);
										}
										$data = json_encode($arr);
										echo "{\"result\":\"1\",\"data\": $data }";
									} else {
										echo "{\"result\":\"0\",\"data\": [{}] }";
									}									
		} 
	} 
	

    
    ?>