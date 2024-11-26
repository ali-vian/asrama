<?php 
$koneksi = mysqli_connect("localhost","root","","asrama");

$id_formulir_kegiatan = $_GET['id'];

$query = "DELETE FROM formulir_kegiatan WHERE id_formulir_kegiatan = $id_formulir_kegiatan";
$hasil = mysqli_query($koneksi,$query);

if ($hasil){
    header("Location: aspirasi.php");
}else{
    echo "data gagal dihapus";
}
?>