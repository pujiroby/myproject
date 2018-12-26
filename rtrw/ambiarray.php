<?php
	$hello=$_POST['aku'];
	$jml=count($hello);
	
	$hasil = '';
	foreach ($hello as $key => $value) {
			$hasil .= $value.', ';
	}
	$hasil = rtrim($hasil,', ');
	echo $hasil.';' ;
	
?>