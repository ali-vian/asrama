<?php
	include 'config.php';
	extract($_POST);
	$ids = array();

	foreach($_POST['place'] as $val)
	{
	$ids[] = (int) $val;
	}

	$ids[] = (int) $db->select('nim,count(nim) as jml','absensi')->where("jenis_absen LIKE '%Harian%' and status_kehadiran='Hadir' and nim=".$id_calon_kr." group by nim")->get()[0]['jml'];
	$ids[] = (int) $db->select('nim,count(nim) as jml','absensi')->where("jenis_absen='Kegiatan' and status_kehadiran='Hadir' and nim=".$id_calon_kr." group by nim")->get()[0]['jml'];
	$ids[] = (int) $db->select('nim,count(nim) as jml','absensi')->where("jenis_absen='Ekstrakurikuler' and status_kehadiran='Hadir' and nim=".$id_calon_kr." group by nim")->get()[0]['jml'];
    
	echo $ids = implode(',', $ids);
	if($db->insert('hasil_tpa',"'','$id_calon_kr',$ids")->count() == 1){
		header('location:tampil_tpa.php');
	}
	
?>