<?php 
$koneksi = mysqli_connect("localhost","root","","asrama");

$id_formulir_kepuasan = $_GET['id'];

$query = "DELETE FROM formulir_kepuasan WHERE id_formulir = $id_formulir_kepuasan";
$hasil = mysqli_query($koneksi,$query);

if ($hasil){
    header("Location: aspirasi.php");
}else{
    echo "data gagal dihapus";
}
?>