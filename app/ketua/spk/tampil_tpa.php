<?php include 'header.php';?>
<?php include 'menu.php';?>
    <div class="content-wrapper">
        <div class="container">
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
                <div><a href="input_tpa.php" class="btn btn-info">Tambah Data</a></div>
                <br>
                <div class="table-responsive">
                    <table id="example1" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <?php foreach ($db->select('kriteria','kriteria')->get() as $kr ): ?>
                                <th><?= $kr['kriteria']?></th>
                                <?php endforeach ?>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($db->select('warga.nim,warga.nama,hasil_tpa.*','warga,hasil_tpa')->where('warga.nim=hasil_tpa.id_calon_kr')->get() as $data): ?>
                            <tr>
                                <td><?= $no;?></td>
                                <td><?= $data['nama']?></td>
                                <?php foreach ($db->select('kriteria','kriteria')->get() as $k): ?>
                                    <?php if($k['kriteria'] !== 'Absensi_Harian' and $k['kriteria'] !== 'Absensi_Kegiatan' and $k['kriteria'] != 'Absensi_Extra'): ?>
                                        <td><?= $db->getnamesubkriteria($data[$k['kriteria']])?> (Nilai = <?= $db->getnilaisubkriteria($data[$k['kriteria']])?>)</td>
                                    <?php else: ?>
                                        <td><?= $data[$k['kriteria']]?></td>
                                    <?php endif; ?>
                                <?php endforeach ?>
                                <td>
                                    <a class="btn btn-warning" href="edit_tpa.php?id=<?php echo $data[0]?>">Edit</a>
                                    <a class="btn btn-danger" onclick="return confirm('Yakin Hapus?')" href="delete_tpa.php?id=<?php echo $data[0]?>">Hapus</a>
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

<?php include 'footer.php'; ?>
<script type="text/javascript">
    $(function(){
        $("#tpa").addClass('menu-top-active');
    });
</script>
<script type="text/javascript">
            $(function() {
                $('#example1').dataTable();
            });
        </script>