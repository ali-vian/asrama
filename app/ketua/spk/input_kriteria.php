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
    <div >
        <div class="row">
            <div class="col-md-12">
            <br/>  
              <div class="panel panel-default">
                  <div class="text-2xl text-gray-900 mb-3">
                    Form Kriteria
                  </div>
                  <div class="panel-body">
                      <form method="post" action="insert_kriteria.php" enctype="multipart/form-data">
                          <?php if (!empty($_GET['error_msg'])): ?>
                              <div class="alert alert-danger">
                                  <?= $_GET['error_msg']; ?>
                              </div>
                          <?php endif ?>
                          <div class="mb-6">
                                <label for="nama-krit" class="block mb-2 font-medium text-gray-900">Nama Kriteria</label>
                                <input type="text" id="nama-krit" name="kriteria" require class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            </div>
                          <div class="mb-6">
                                <label for="bobot" class="block mb-2 font-medium text-gray-900">Bobot</label>
                                <input type="number" id="bobot" name="bobot" pattern="^[0-9\.\-\/]+$"  require class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            </div>
                        <label for="type" class="block mb-2 font-medium text-gray-900">Type</label>
                        <select id="typr" name="type" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="Cost">Cost</option>
                            <option value="Benefit">Benefit</option>
                        </select>
                          <div class="form-group mt-6">
                              <button class="btn btn-primary rounded-lg">Simpan</button>
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