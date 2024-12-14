<?php include '../templates/new_header.php';?>
<?php include 'menu.php';
include 'config.php';?>
<div class="content-wrapper">
    
        <div class="row">
            <div class="col-md-12">
            <br/>  
              <div class="panel panel-default">
                  <div class="panel-heading text-2xl mb-3">
                    Form Sub Kriteria
                  </div>
                  <div class="panel-body">
                      <form method="post" action="update_subkriteria.php" enctype="multipart/form-data">
                          <?php if (!empty($_GET['error_msg'])): ?>
                              <div class="alert alert-danger">
                                  <?= $_GET['error_msg']; ?>
                              </div>
                          <?php endif ?>
                          <?php foreach ($db->select('*','sub_kriteria')->where('id_subkriteria='.$_GET['id'])->get() as $data): ?>
                              <input type="hidden" name="id" value="<?= $data[0]?>">
                                <div class="form-group mb-3">
                                    <label for="nama">Nama Sub Kriteria</label>
                                    <input type="text" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" id="subkriteria" name="subkriteria" value="<?= $data['subkriteria']?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="nama">Nama Kriteria</label>
                                    <select required class="form-control" id="id_kriteria" name="id_kriteria">
                                        <?php  foreach ($db->select('*','kriteria')->get() as $val): ?> 
                                        <option value="<?php echo $val['id_kriteria']; ?>"<?php if($data['id_kriteria'] == $val['id_kriteria']) { echo ' selected="selected"'; } ?>>
                                        <?= $val['kriteria'] ?></option>
                                        <?php endforeach ?>
                                    </select>   
                                </div>
                                <div class="form-group mb-3">
                                    <label>Nilai</label>
                                    <input type="number" name="nilai" id="nilai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?= $data['nilai']?>" pattern="^[0-9\.\-\/]+$">
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
<?php include '../templates/new_footer.php';?>
<script type="text/javascript">
    $(function(){
        $("#sk").addClass('menu-top-active');
    });
</script>