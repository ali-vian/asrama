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
            <br/>  
              <div class="panel panel-default">
                  <div class="panel-heading text-2xl mb-3">
                    Form Kriteria
                  </div>
                  <div class="panel-body">
                      <form method="post" action="update_tpa.php">
                          <?php if (!empty($_GET['error_msg'])): ?>
                              <div class="alert alert-danger">
                                  <?= $_GET['error_msg']; ?>
                              </div>
                          <?php endif ?>
                          <?php foreach ($db->select('hasil_tpa.*,warga.nim,warga.nama','hasil_tpa,warga')->where('hasil_tpa.id_calon_kr=warga.nim and hasil_tpa.id_calon_kr='.$_GET['id'])->get() as $data): ?>
                          	  <input type="hidden" name="id" value="<?= $data['id_calon_kr']?>">
                                <div class="form-group mb-3">
                                  <label for="nama">Nama</label>
                                  <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" id="nama" name="nama" value="<?= $data['nama']?>" readonly>
                              </div>
                              <?php foreach ($db->select('id_kriteria,kriteria','kriteria')->get() as $r): ?>
                            <?php if($r['kriteria'] !== 'Absensi_Harian' and $r['kriteria'] !== 'Absensi_Kegiatan' and $r['kriteria'] != 'Absensi_Extra'): ?>
	                          <div class="form-group mb-3">
	                              <label><?= $r['kriteria']?></label>
                                <select required class="form-control" name="kriteria[]">
                                <?php  foreach ($db->select('*','sub_kriteria')->where('id_kriteria = '.$r['id_kriteria'].'')->get() as $val): ?> 
                                <option value="<?= $val['id_subkriteria']?>"
                                <?php if($db->getnamesubkriteria($data[$r['kriteria']]) == $val['subkriteria']) { echo ' selected="selected"'; } ?>
                                ><?= $val['subkriteria'] ?> (Nilai = <?= $val['nilai'] ?>)</option>
                                <?php endforeach ?>
                                </select>
	                          </div>
                              <?php endif; ?>
	                          <?php endforeach ?>
                          <?php endforeach ?>
                          
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
<?php include 'footer.php';?>
<script type="text/javascript">
    $(function(){
        $("#tpa").addClass('menu-top-active');
    });
</script>