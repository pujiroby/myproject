 <?php
    include_once 'config.php';
	include_once 'key.php';
	
	$respon['value']=0;
	$respon['pesan']='Gagal';
	$default = json_encode($respon);
	
	if (isset($_GET['key'])){
		
		$key = $_GET['key'];		
				
		if ($key == $genkey) {
			
			$user = '';
			$pass = '';
			
			if(isset($_POST['user'])){$user = $_POST['user'];}
			if(isset($_POST['pass'])){$pass = $_POST['pass'];}

			$i = 0;
			$query = 'select username from user where username = "'.$user.'" and password = md5("'.$pass.'") ';
			
			$result = $mysqli->query($query);
			if (mysqli_num_rows($result) > 0){
					$respon['value']=1;
					$respon['pesan']='Sukses';
					echo json_encode($respon);
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
