<?php
// require __DIR__ . '/../../../vendor/autoload.php';

// include 'config.php';
// extract($_POST);

// class MYPDF extends TCPDF {

//     public $isLastPage = true;

//     // Page header
//     public function Header() {
//         if ($this->page == 1) {
//             // Logo
//             $image_file = K_PATH_IMAGES . 'tcpdf_logo.jpg';
//             $this->Image($image_file, 15, 10, 20, 20, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

//             // Text Header
//             $html = '
//             <div style="text-align: center;">
//                 <strong><font size="14">ASRAMA MAHASISWA</font></strong><br/>
//                 <strong><font size="16">UNIVERSITAS TRUNOJOYO MADURA</font></strong><br/>
//                 <span style="font-size: 10px;">
//                     Jl. Raya Telang, Kamal, Perumahan Telang Indah, Telang, Kec. Kamal, Kabupaten Bangkalan, Jawa Timur 69162<br/>
//                     Telepon: (031) 3011146 | Email: asrama@trunojoyo.ac.id
//                 </span>
//             </div>
//             <hr style="border-top: 2px solid black;">
//             ';
//             $this->writeHTMLCell(0, 0, 15, 10, $html, 0, 0, false, true, 'C', true);
//         }
//     }

//     // Page footer
//     public function Footer() {
//         if ($this->isLastPage) {
//             $tgl = date("d F Y");
//             $html = '
//             <div style="text-align: right; font-size: 10px;">
//                 Bangkalan, ' . $tgl . '<br/><br/><br/><br/>
//                 <strong>Ketua Umum</strong>
//             </div>
//             ';
//             $this->writeHTMLCell(0, 0, '', -40, $html, 0, 0, false, true, 'R', true);
//         }
//         // Position at 15 mm from bottom
//         $this->SetY(-15);
//         // Set font
//         $this->SetFont('helvetica', 'I', 8);
//         // Page number
//         $this->Cell(0, 10, 'Halaman ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
//     }
// }

// $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// // Set default monospaced font
// $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// // Set margins (4333 margins are assumed as 43mm left and right, 33mm top and bottom)
// $pdf->SetMargins(43, 33, 43);
// $pdf->SetHeaderMargin(10);
// $pdf->SetFooterMargin(20);

// // Set auto page breaks
// $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// // Set image scale factor
// $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// // Add a page
// $pdf->AddPage();

// // Data table
// $htmlTable = '
// <table border="1">
//     <thead>
//         <tr style="background-color: #f2f2f2; text-align: center;">
//             <th width="10%">No.</th>
//             <th width="25%">NIM</th>
//             <th width="35%">Nama</th>
//             <th width="20%">Hasil Penilaian</th>
//             <th width="10%">Status</th>
//         </tr>
//     </thead>
//     <tbody>';
// $no = 1;

// foreach ($db->select("nama, nim, id_calon_kr, hasil_spk, status", 'warga, hasil_spk')->where("nim=id_calon_kr")->order_by("hasil_spk", 'desc')->get() as $data) {
//     $htmlTable .= '
//         <tr>
//             <td align="center">' . $no . '</td>
//             <td align="center">' . $data['nim'] . '</td>
//             <td>' . $data['nama'] . '</td>
//             <td align="center">' . $data['hasil_spk'] . '</td>
//             <td align="center">' . $data['status'] . '</td>
//         </tr>';
//     $no++;
// }

// $htmlTable .= '
//     </tbody>
// </table>';
// $pdf->writeHTML($htmlTable, true, false, true, false, '');

// ob_end_clean();

// // Output the PDF
// $pdf->Output('laporan_penilaian_warga.pdf', 'I');

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
require __DIR__ . '/../../../vendor/autoload.php';

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
