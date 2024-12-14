<?php include '../templates/new_header.php';?>
<?php include 'menu.php';
include 'config.php';?>
<div class="content-wrapper">
    <div>
        <div class="row">
            <div class="col-md-12">
            <br/>  
              <div class="panel panel-default">
                  <div class="panel-heading mb-6 text-2xl">
                    Form Sub Kriteria
                  </div>
                  <div class="panel-body">
                      <form method="post" action="insert_subkriteria.php" enctype="multipart/form-data">
                          <?php if (!empty($_GET['error_msg'])): ?>
                              <div class="alert alert-danger">
                                  <?= $_GET['error_msg']; ?>
                              </div>
                          <?php endif ?>    
                          <div class="mb-6">
                                <label for="nama-krit" class="block mb-2 font-medium text-gray-900">Nama Sub Kriteria</label>
                                <input type="text" id="nama-krit" name="subkriteria" require class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            </div>
                          <div class="mb-6">
                            <label for="nama">Nama Kriteria</label>
                            <select required class="bg-gray-50 border border-gray-300 text-gray-900 text rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" name="id_kriteria">
                                <?php  foreach ($db->select('*','kriteria')->get() as $val): ?> 
                                    <option value="<?= $val['id_kriteria']?>"><?= $val['kriteria'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="mb-6">
                                    <label for="nilai" class="block mb-2 font-medium text-gray-900">Nilai</label>
                                    <input type="number" id="nilai" name="nilai" pattern="^[0-9\.\-\/]+$"  require class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                </div>                  
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
        $("#sk").addClass('menu-top-active');
    });
</script>