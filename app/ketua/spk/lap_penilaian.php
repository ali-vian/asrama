<?php 
include '../templates/new_header.php';
include 'menu.php';
include 'config.php';
$data = $db->select("nama,nim,id_calon_kr,hasil_spk,status",'warga,hasil_spk')->where("nim=id_calon_kr")->order_by("hasil_spk",'desc')->get();
$i=1;
if(isset($_GET['kuota'])){
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
    <div>
        <div class="row">
            <div class="col-md-12">
            <br/>  
              <div class="panel panel-default">
                  <div class="panel-heading text-2xl mb-3">
                  Daftar Keputusan
                  </div>
                  <div class="panel-body">
                    <form action="lap_penilaian.php" method="get">
                        <div class="mb-6">
                            <label for="kuota" class="block mb-2 font-medium text-gray-900">Masukkan Jumlah Kuota</label>
                            <input type="number" id="kuota" name="kuota" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <div class="flex justify-center">
                            <button type="submit" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-2">Tampilkan Hasil</button>
                        </div>
                    </form>
                        <div class="mt-6">
                            <form method="post" action="pdf_lap_penilaian.php" enctype="multipart/form-data">
                                <?php if (!empty($_GET['error_msg'])): ?>
                                    <div class="alert alert-danger">
                                        <?= $_GET['error_msg']; ?>
                                    </div>
                                    <?php endif ?>
                                    <div class="form-group">
                                        <a class="btn btn-primary rounded-md mr-3" style="padding: 8px;" href="email.php">Umumkan</a>
                                        <button class="btn btn-primary p-2 rounded-md">Cetak</button>
                                </div>
                            </form>
                            <table border="1" class="mt-6 table table-striped table-bordered table-hover">
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
            <?php include '../templates/new_footer.php';?>