<?php 
include 'header.php';
include 'menu.php';
$data = $db->select("nama,nim,id_calon_kr,hasil_spk,status",'warga,hasil_spk')->where("nim=id_calon_kr")->order_by("hasil_spk",'desc')->get();
$i=1;
if(isset($_GET['kuota'])){
    echo $_GET['kuota'];
    foreach($data as $d){
        if($i <= $_GET['kuota']){
            $db->update('hasil_spk',"status='Lulus'")->where('id_calon_kr='.$d['nim'])->count();
        }else{

            $db->update('hasil_spk',"status='Tidak Lulus'")->where('id_calon_kr='.$d['nim'])->count();
        }
        $i++;
    }
    $data = $db->select("nama,nim,id_calon_kr,hasil_spk,status",'warga,hasil_spk')->where("nim=id_calon_kr")->order_by("hasil_spk",'desc')->get();
}


?>
<div class="content-wrapper">
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <br/>  
              <div class="panel panel-default">
                  <div class="panel-heading">
                  Daftar Keputusan
                  </div>
                  <div class="panel-body">
                    <form action="lap_penilaian.php" method="get">

                        <div class="form-group">
                            <label for="kuota"> Masukkan Jumlah Kuota</label>
                            <input type="number" id="kuota" name="kuota" class="form-control" require>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success center-block" type="submit"">Tampilkan Hasil</button>
                        </div>
                    </form>
                        <div>
                            <form method="post" action="pdf_lap_penilaian.php" enctype="multipart/form-data">
                                <?php if (!empty($_GET['error_msg'])): ?>
                                    <div class="alert alert-danger">
                                        <?= $_GET['error_msg']; ?>
                                    </div>
                                    <?php endif ?>
                                    <div class="form-group">
                                        <a class="btn-primary" style="padding: 8px;" href="email.php">Umumkan</a>
                                        <button class="btn btn-primary">Cetak</button>
                                </div>
                            </form>
                            <table border="1" class="table table-striped table-bordered table-hover">
                                <tr>
                                    <td>No</td>
                                    <td>NIM</td>
                                    <td>Nama</td>
                                    <td>Hasil Penilaian</td>
                                    <td>Status</td>
                                </tr>
                                <?php $no=1; foreach($data as $i): ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $i['nim'] ?></td>
                                    <td><?= $i['nama'] ?></td>
                                    <td><?= $i['hasil_spk'] ?></td>
                                    <td><?= $i['status'] ?></td>
                                </tr>
                                <?php $no++; endforeach; ?>
                            </table>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
        </div>
    </div>
</div>
</div>
<?php include 'footer.php';?>
<script type="text/javascript">
    $(function(){
        $("#lap").addClass('menu-top-active');
        // $.ajax({
        //     url:'truncate_tpa.php',
        //     success:function(data){
        //         //alert(data);
                    
        //     }
        // });
    });
    function tmpl(){
       $("#tabel").show();    
    }
</script>