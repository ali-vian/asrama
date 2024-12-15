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
    <div>
        <div class="row">
            <div class="col-md-12">
            <br/>  
              <div class="panel panel-default">
                  <div class="panel-heading text-2xl mb-3">
                    Form Kriteria
                  </div>
                  <div class="panel-body">
                      <form method="post" action="update_kriteria.php" enctype="multipart/form-data">
                          <?php if (!empty($_GET['error_msg'])): ?>
                              <div class="alert alert-danger">
                                  <?= $_GET['error_msg']; ?>
                              </div>
                          <?php endif ?>
                          <?php foreach ($db->select('*','kriteria')->where('id_kriteria='.$_GET['id'])->get() as $data): ?>
                              <input type="hidden" name="id" value="<?= $data[0]?>">
                              <div class="form-group mb-3">
                                  <label for="nama">Nama Kriteria</label>
                                  <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" id="kriteria" name="kriteria" value="<?= $data['kriteria']?>">
                              </div>
                              <div class="form-group mb-3">
                                  <label>Bobot</label>
                                  <input type="number" name="bobot" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?= $data['bobot']?>" pattern="^[0-9\.\-\/]+$">
                              </div>
                              <div class="form-group mb-3">
                                  <label>Type</label>
                                  <select class="form-control" name="type">
                                      <option value="Cost" <?php if($data['type']=='Cost'){ echo 'selected'; }?>>Cost</option>
                                      <option value="Benefit" <?php if($data['type']=='Benefit'){ echo 'selected'; }?>>Benefit</option>
                                  </select>
                              </div>  
                          <?php endforeach ?>
                          
                          <div class="form-group">
                              <button class="btn btn-primary">Simpan</button>
                          </div>
                      </form>
                  </div>
              </div>
            </div>
        </div>
        </div>
    </div>
</div>
<?php include '../templates/new_footer.php';?>
<script type="text/javascript">
    $(function(){
        $("#ds").addClass('menu-top-active');
    });
</script>