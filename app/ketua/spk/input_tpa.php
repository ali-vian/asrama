<?php
session_start();
if (!isset($_SESSION['nim']) && !$_SESSION['role'] == 'ketua') {
    header("Location: ../../../index.php");
    exit;
}
include '../templates/new_header.php';?>

<?php include 'menu.php';
include 'config.php';?>

<div class="content-wrapper">
    
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                  <div class="panel-heading text-2xl mb-6">
                    Form Kriteria
                  </div>
                  <div class="panel-body">
                      <form method="post" action="insert_tpa.php" enctype="multipart/form-data">
                          <?php if (!empty($_GET['error_msg'])): ?>
                              <div class="alert alert-danger">
                                  <?= $_GET['error_msg']; ?>
                              </div>
                          <?php endif ?>
                          <div class="form-group col-md-12 mb-3">
                                <div class="alert alert-info">
                                  <i class="fa fa-info-circle"></i> Warga Yang Ditampilkan adalah nama warga yang belum dinilai...
                                </div>
                                <label for="nama">Nama Warga</label>
                                <select required class="form-control p-2" name="id_calon_kr">
                                <?php  foreach ($db->select('*','warga')->where('nim not in (select id_calon_kr from hasil_tpa)')->get() as $val): ?> 
                                <option value="<?= $val['nim']?>"><?= $val['nama'] ?></option>
                                <?php endforeach ?>
                                </select>
                          </div>
                          <div class="flex justify-between">
                                <?php foreach ($db->select('id_kriteria,kriteria','kriteria')->get() as $r): ?>
                                    <?php if($r['kriteria'] !== 'Absensi_Harian' and $r['kriteria'] !== 'Absensi_Kegiatan' and $r['kriteria'] != 'Absensi_Extra'): ?>
                                    <div class="form-group col-md-5 mb-6">
                                        <label><?= $r['kriteria']?></label>
                                        <!-- <input type="number" name="place[]" class="form-control"> -->
                                        <select required class="form-control p-2" name="place[]">
                                            <?php  foreach ($db->select('*','sub_kriteria')->where('id_kriteria = '.$r['id_kriteria'].'')->get() as $val): ?> 
                                                <option value="<?= $val['id_subkriteria']?>"> <?= $val['subkriteria'] ?> (Nilai = <?= $val['nilai'] ?>)</option>
                                            <?php endforeach ?>
                                        </select>
                                </div>
                          <?php endif ?>
                          
                          <?php endforeach ?>
                        </div>
                                </div>
                          <div class="form-group col-md-12">
                              <button class="btn btn-primary">Simpan</button>
                          </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<script type="text/javascript">
    $(function(){
        $("#tpa").addClass('menu-top-active');
    });
</script>
<?php 
include "../templates/new_footer.php"
?>