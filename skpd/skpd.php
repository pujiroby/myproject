 <?php
    include_once 'config.php';
	
	$default = '{"data": [{"no":"","user":"","pass":"","pengguna":""}]}';
	
	if (isset($_GET['key'])&& isset($_POST['cari']) && !empty($_POST['cari'])){
		
		$key = $_GET['key'];
		$cari = $_POST['cari'];		
			
		if ($key == '1234567') {

			$i = 0;
			$sql = 'select username, password, namapengguna from master_user
					where namapengguna like "%'.$cari.'%" and namapengguna not like "UPT%" and
					namapengguna not like "SD%" and
					namapengguna not like "SMP%" and
					namapengguna not like "SMA%" and
					namapengguna not like "Puskes%"';
			
					
			$query = $sql;
			
			$result = $mysqli->query($query);
			if (mysqli_num_rows($result) > 0){
				$arr = array();
				while($data = $result->fetch_array())
				{
				$i++;
				  $temp = array(
					"no"=>$i,
					"user"=>$data["username"],
					"pass"=>$data["password"],
					"pengguna"=>$data["namapengguna"]			
				);
				
				array_push($arr, $temp);
				}
				$skpd = json_encode($arr);
				echo "{\"data\": $skpd }";
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
