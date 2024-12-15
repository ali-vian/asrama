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
                <h3 class="mt-6 text-2xl">Tabel Hasil TPA</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>### </th>
                                <?php foreach ($db->select('kriteria','kriteria')->get() as $k): ?>
                                <th>
                                    <?php
                                        $tmp = explode('_',$k['kriteria']);
                                        echo ucwords(implode(' ',$tmp));
                                    ?>
                                </th>
                                <?php endforeach ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($db->select('warga.nama,hasil_tpa.*','warga,hasil_tpa')->where('warga.nim=hasil_tpa.id_calon_kr')->get() as $data):
                            ?>
                                <tr>
                                    <td><?= $data['nama']?></td>
                                    <?php foreach ($db->select('kriteria','kriteria')->get() as $td): ?>
                                    <?php if($td['kriteria'] != 'Absensi_Harian' and $td['kriteria'] != 'Absensi_Kegiatan' and $td['kriteria'] != 'Absensi_Extra'): ?>
                                    <td><?= $db->getnilaisubkriteria($data[$td['kriteria']])?></td>
                                    <?php else: ?>
                                    <td><?= number_format($data[$td['kriteria']],2);?></td>
                                    <?php endif; ?>
                                    <?php endforeach ?>
                                </tr>
                            <?php
                                endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <button class="btn btn-success" onclick="tpl()">PROSES</button>
                </div>
            </div>
            <br>
            <div id="proses_spk" style="display: none;">
                <div class="row" >
                <h3 class="mt-6 text-2xl">Normalisasi</h3>
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>### </th>
                                <?php foreach ($db->select('kriteria','kriteria')->get() as $k): ?>
                                <th>
                                    <?php
                                        $tmp = explode('_',$k['kriteria']);
                                        echo ucwords(implode(' ',$tmp));
                                    ?>
                                </th>
                                <?php endforeach ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($db->select('warga.nama,hasil_tpa.*','warga,hasil_tpa')->where('warga.nim=hasil_tpa.id_calon_kr')->get() as $data):
                            ?>
                                <tr>
                                    <td><?= $data['nama']?></td>
                                    <?php foreach ($db->select('kriteria','kriteria')->get() as $td): ?>
                                    <?php if($td['kriteria'] != 'Absensi_Harian' and $td['kriteria'] != 'Absensi_Kegiatan' and $td['kriteria'] != 'Absensi_Extra'): ?>
                                    <td><?= number_format($db->rumus($db->getnilaisubkriteria($data[$td['kriteria']]),$td['kriteria']),2);?></td>
                                    <?php else: ?>
                                    <td><?= number_format($db->rumus1($data[$td['kriteria']],$td['kriteria']),2)?></td>
                                    <?php endif; ?>
                                    <?php endforeach ?>
                                </tr>
                            <?php
                                endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <h3 class="mt-6 text-2xl">Proses Penentuan</h3>
                <div class="table-responsive">
                    <table id="example3" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Nama </th>
                                <th>Hasil</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($db->select('warga.nim,warga.nama,hasil_tpa.*','warga,hasil_tpa')->where('warga.nim=hasil_tpa.id_calon_kr')->get() as $data):
                            ?>
                                <tr>
                                    <td><?= $data['nama']?></td>
                                    <td>
                                    <?php 
                                        $hasil = [];

                                        foreach($db->select('kriteria','kriteria')->get() as $dt){
                                           
                                            if($td['kriteria'] != 'Absensi_Harian' and $td['kriteria'] != 'Absensi_Kegiatan' and $td['kriteria'] != 'Absensi_Extra'){
                                                array_push($hasil,$db->rumus($db->getnilaisubkriteria($data[$dt['kriteria']]),$dt['kriteria'])*$db->bobot($dt['kriteria']));
                                            }else{
                                                array_push($hasil,$db->rumus1($data[$dt['kriteria']],$dt['kriteria'])*$db->bobot($dt['kriteria']));
                                            }
                                        }
                                        echo $h = number_format(array_sum($hasil),2);
                                        if($db->select('id_calon_kr','hasil_spk')->where("id_calon_kr='$data[id_calon_kr]'")->count() == 0){
                                            $db->insert('hasil_spk',"'','$data[id_calon_kr]','$h',NULL")->count();
                                        } else {
                                            $db->update('hasil_spk',"hasil_spk='$h'")->where("id_calon_kr='$data[id_calon_kr]'")->count();
                                        }
                                        
                                        ?>
                                    </td>
                                </tr>
                            <?php
                                endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <h3 class="mt-6 text-2xl">Perankingan</h3>
                <div class="table-responsive">
                    <table id="example4" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Hasil </th>
                                <?php $no = 1; foreach ($db->select('kriteria','kriteria')->get() as $th): ?>
                                <th>K<?= $no?></th>
                                <?php $no++; endforeach ?>
                                <th rowspan="2" style="padding-bottom:25px">Hasil</th>
                                <th rowspan="2" style="padding-bottom:25px">Ranking</th>
                            </tr>
                            <tr>
                                <th>Bobot </th>
                                <?php foreach ($db->select('bobot','kriteria')->get() as $th): ?>
                                <th><?= $th['bobot']?></th>
                                <?php endforeach ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                foreach ($db->select('distinct(warga.nama),hasil_tpa.*,hasil_spk.*','warga,hasil_tpa,hasil_spk')->where('warga.nim=hasil_tpa.id_calon_kr and warga.nim=hasil_spk.id_calon_kr')->order_by('hasil_spk.hasil_spk','desc')->get() as $data):
                            ?>
                                <tr>
                                    <td><?= $data['nama']?></td>
                                    <?php foreach ($db->select('kriteria','kriteria')->get() as $td): ?>
                                    <?php if($td['kriteria'] != 'Absensi_Harian' and $td['kriteria'] != 'Absensi_Kegiatan' and $td['kriteria'] != 'Absensi_Extra'): ?>
                                    <td><?= number_format($db->rumus($db->getnilaisubkriteria($data[$td['kriteria']]),$td['kriteria']),2);?></td>
                                    <?php else: ?>
                                    <td><?= number_format($db->rumus1($data[$td['kriteria']],$td['kriteria']),2)?></td>
                                    <?php endif; ?>
                                    <?php endforeach ?>
                                    <td>
                                    <?php 
                                        $hasil = [];
                                        foreach($db->select('kriteria','kriteria')->get() as $dt){
                                            if($td['kriteria'] != 'Absensi_Harian' and $td['kriteria'] != 'Absensi_Kegiatan' and $td['kriteria'] != 'Absensi_Extra'){
                                                array_push($hasil,$db->rumus($db->getnilaisubkriteria($data[$dt['kriteria']]),$dt['kriteria'])*$db->bobot($dt['kriteria']));
                                            }else{
                                                array_push($hasil,$db->rumus1($data[$dt['kriteria']],$dt['kriteria'])*$db->bobot($dt['kriteria']));
                                            }
                                        }
                                        echo $r = number_format(array_sum($hasil),2);
                                    ?>
                                    </td>
                                    <td>
                                        <?= $no?>
                                    </td>
                                </tr>
                            <?php
                                $no++;
                                endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>    
            </div>
            
    </div>
</div>
    <!-- CONTENT-WRAPPER SECTION END-->
<script type="text/javascript">
    $(function(){
        $("#proses").addClass('menu-top-active');
        // $.ajax({
        //     url:'truncate_tpa.php',
        //     success:function(data){
        //         //alert(data);
                    
        //     }
        // });
    });
    function tpl(){
       $("#proses_spk").show();    
    }
</script>
<?php include '../templates/new_footer.php'; ?>
