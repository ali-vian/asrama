<?php
session_start();
if (!isset($_SESSION['nim']) && !$_SESSION['role'] == 'ketua') {
    header("Location: ../../../index.php");
    exit;
}require __DIR__ . '/../../../vendor/autoload.php';

include 'config.php';

extract($_POST);

class MYPDF extends TCPDF {
    // Page header
    public function Header() {
        $this->SetFont('times', 'N', 12);
        $image_file = K_PATH_IMAGES . 'asrama.jpg'; // Ganti dengan path logo Anda
        $html = '
        <table cellspacing="0" cellpadding="1">
            <tr>
                <td width="15%"><img src="' . $image_file . '" width="80"/></td>
                <td width="85%" align="center">
                    KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI<br/>
                    UNIVERSITAS TRUNOJOYO MADURA<br/>
                    <strong>ASRAMA MAHASISWA</strong><br/>
                    Jl. Raya Telang, PO Box 2 Kamal, Bangkalan - Madura Telp.(031) 3011146<br/>
                    Laman: https://asrama.trunojoyo.ac.id/<br/>
                </td>
            </tr>
        </table>
        <hr>';
        $this->writeHTML($html, true, false, false, false, '');
    }
    
}

// Buat objek PDF
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set margin dan auto-break
$pdf->SetMargins(20, 50, 20);
$pdf->setAuthor('Asrama Mahasiswa UTM');
$pdf->SetTitle('Pengumuman Warga Asrama Mahasiswa UTM');
$pdf->setFont('times', '', 12); 
$pdf->SetHeaderMargin(15);
$pdf->SetFooterMargin(15);
$pdf->SetAutoPageBreak(TRUE, 25);

// Tambah halaman
$pdf->AddPage();

// Konten surat
$html = '
<h3 align="center">PENGUMUMAN</h3>
<p align="center">Nomor: B/6617/UN46/KM.01.00/2024</p>
<p align="center">
    TENTANG KELOLOSAN PENDAFTARAN WARGA LAMA ASRAMA UNIVERSITAS TRUNOJOYO MADURA TAHUN 2024
</p>
<table border="1">
    <thead>
        <tr style="background-color: #f2f2f2; text-align: center;">
            <th align="center"  width="6%">No.</th>
            <th align="center" width="23.5%">NIM</th>
            <th align="center" width="23.5%">Nama</th>
            <th align="center" width="23.5%">Hasil Penilaian</th>
            <th align="center" width="23.5%">Status</th>
        </tr>
    </thead>
    <tbody>';
$no = 1;

foreach ($db->select("nama, nim, id_calon_kr, hasil_spk, status", 'warga, hasil_spk')->where("nim=id_calon_kr")->order_by("hasil_spk", 'desc')->get() as $data) {
    $html .= '
        <tr>
            <td align="center" width="6%">' . $no . '</td width="10%"d>
            <td align="center" width="23.5%" >' . $data['nim'] . '</td>
            <td align="center" width="23.5%" >' . $data['nama'] . '</td>
            <td align="center" width="23.5%" >' . $data['hasil_spk'] . '</td>
            <td align="center" width="23.5%" >' . $data['status'] . '</td>
        </tr>';
    $no++;
}

$html .= '
    </tbody>
</table>';

$tgl = date("d F Y");
$html .= '
<p align="right">
    Bangkalan, ' . $tgl . '<br/><br/><br/><br/><br/>
    Ketua Umum
</p>
';

// Tulis konten ke PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF
$pdf->Output('surat_pengumuman.pdf', 'I');

?>
