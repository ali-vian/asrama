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
                    <?php if (!empty($_GET['error_msg'])): ?>
                      <div class="alert alert-danger">
                          <?= $_GET['error_msg']; ?>
                      </div>
                    <?php endif ?>
                </div>
            </div>  
            <div class="row">
                <div><a href="input_subkriteria.php" class="btn btn-info mb-5">Tambah Data</a></div>
                <br>
                <div class="table-responsive">
                    <table id="example1" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kriteria</th>
                                <th>Sub Kriteria</th>
                                <th>Nilai</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($db->select('sub_kriteria.id_subkriteria,sub_kriteria.subkriteria,kriteria.kriteria,sub_kriteria.nilai','sub_kriteria,kriteria')->where('sub_kriteria.id_kriteria=kriteria.id_kriteria')->get() as $data): ?>
                            <tr>
                                <td><?= $no;?></td>
                                <td><?= $data['kriteria']?></td>
                                <td><?= $data['subkriteria']?></td>
                                <td><?= $data['nilai']?></td>
                                <td>
                                    <a class="btn btn-warning" href="edit_subkriteria.php?id=<?php echo $data[0]?>">Edit</a>
                                    <a class="btn btn-danger" onclick="return confirm('Yakin Hapus?')" href="delete_subkriteria.php?id=<?php echo $data[0]?>">Hapus</a>
                                </td>
                            </tr>
                            <?php $no++; endforeach; ?>
                        </tbody>
                    </table>    
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->

    <script type="text/javascript">
        $(function(){
            $("#sk").addClass('menu-top-active');
        });
    </script>
<script type="text/javascript">
    $(function() {
        $('#example1').dataTable();
    });
    </script>
    <?php include '../templates/new_footer.php'; ?>