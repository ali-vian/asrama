/* DROPDOWN */

window.onclick = function(event) {
    const absensiContent = document.getElementById("absensiContent");
    const kegiatanContent = document.getElementById("kegiatanContent");
    const bulanContent = document.getElementById("bulanContent");

    absensiContent.style.display = "none";
    kegiatanContent.style.display = "none";
    bulanContent.style.display = "none";

    if (event.target.matches('.select-btn')) {
        absensiContent.style.display = absensiContent.style.display === "block" ? "none" : "block";
    } else if (event.target.matches('.kegiatan-btn')) {
        kegiatanContent.style.display = kegiatanContent.style.display === "block" ? "none" : "block";
    } else if (event.target.matches('.bulan-btn')) {
        bulanContent.style.display = bulanContent.style.display === "block" ? "none" : "block";
    }
}


/* Absensi */

function dropdownAbsensi() {
    const content = document.getElementById("absensiContent");
    content.style.display = content.style.display === "block" ? "none" : "block";
}

function selectAbsensi(element) {
    const btnAbsensi = document.querySelector(".select-btn");
    btnAbsensi.textContent = element.textContent;
    dropdownAbsensi(); 

    const goTo = element.getAttribute("data-value");
    if (goTo) {
        window.location.href = goTo;
    }
}

/* Bulan */


const months = [
    "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
    "Agustus", "September", "Oktober", "November", "Desember"
];

const currentMonthIndex = new Date().getMonth();

const urlParams = new URLSearchParams(window.location.search);
const selectedMonthParam = urlParams.get('month');
const selectedMonthIndex = selectedMonthParam ? parseInt(selectedMonthParam) - 1 : currentMonthIndex;

document.addEventListener("DOMContentLoaded", function() {
    const monthBtn = document.querySelector(".bulan-btn.text-bulan");
    const monthContent = document.getElementById("bulanContent");

    monthBtn.textContent = months[selectedMonthIndex];

    months.forEach((month, index) => {
        const monthOption = document.createElement("div");
        monthOption.classList.add("bulan-option");
        monthOption.textContent = month;

        if (index === selectedMonthIndex) {
            monthOption.classList.add("selected-option");
        }

        monthOption.onclick = function() {
            selectBulan(monthOption);
        };

        monthContent.appendChild(monthOption);
    });
});


function bulanDropdown() {
    const content = document.getElementById("bulanContent");
    content.style.display = content.style.display === "block" ? "none" : "block";
}


function selectBulan(element) {
    const btn = document.querySelector(".bulan-btn.text-bulan");
    btn.textContent = element.textContent;
    bulanDropdown();

    const monthIndex = Array.from(element.parentElement.children).indexOf(element) + 1;
    const currentPage = window.location.pathname;
    
    window.location.href = `${currentPage}?month=${monthIndex}`;
}




/* Kegiatan */

function kegiatanDropdown() {
    const content = document.getElementById("kegiatanContent");
    content.style.display = content.style.display === "block" ? "none" : "block";
}

function selectKegiatan(element) {
    const selectedId = element.getAttribute('data-id');
    const currentPage = window.location.pathname;
    window.location.href = `${currentPage}?month=${month}&kegiatan=${selectedId}`;
}


/* CETAK */

function exportHarian(){
        
    const wb = XLSX.utils.book_new();

    const keteranganData = [
        ['Keterangan:', ''],
        ['H', '= Hadir'],
        ['I', '= Izin'],
        ['A', '= Alfa']
    ];

    const keteranganSheet = XLSX.utils.aoa_to_sheet(keteranganData);
    XLSX.utils.book_append_sheet(wb, keteranganSheet, 'Keterangan');

    const table = document.getElementById('tableExcel');
    const tableSheet = XLSX.utils.table_to_sheet(table);

    let sheetTitle = '';

    const selectedMonth = selectedMonthParam ? months[parseInt(selectedMonthParam) - 1] : months[new Date().getMonth()];
    const currentYear = new Date().getFullYear();

    sheetTitle = `Absensi Harian (${selectedMonth} ${currentYear})`.slice(0, 31);

    XLSX.utils.book_append_sheet(wb, tableSheet, sheetTitle);

    const fileName = `Rekap Absensi Harian (${selectedMonth} ${currentYear}).xlsx`;

    XLSX.writeFile(wb, fileName);
}

function exportEkstra(){
        
    const wb = XLSX.utils.book_new();

    const keteranganData = [
        ['Keterangan:', ''],
        ['H', '= Hadir'],
        ['I', '= Izin'],
        ['A', '= Alfa']
    ];

    const keteranganSheet = XLSX.utils.aoa_to_sheet(keteranganData);
    XLSX.utils.book_append_sheet(wb, keteranganSheet, 'Keterangan');

    const table = document.getElementById('tableExcel');
    const tableSheet = XLSX.utils.table_to_sheet(table);

    let sheetTitle = '';
    kegiatan = kegiatan.replace(/[:\\/?*[\]]/g, '');  

    const selectedMonth = selectedMonthParam ? months[parseInt(selectedMonthParam) - 1] : months[new Date().getMonth()];
    const currentYear = new Date().getFullYear();

    sheetTitle = `Absensi Ekstrakulikuler (${kegiatan} - ${selectedMonth} ${currentYear})`.slice(0, 31);

    XLSX.utils.book_append_sheet(wb, tableSheet, sheetTitle);

    const fileName = `Rekap Absensi Ekstrakulikuler (${kegiatan} - ${selectedMonth} ${currentYear}).xlsx`;

    XLSX.writeFile(wb, fileName);
}


function exportBesar() {
    const wb = XLSX.utils.book_new();

    const table = document.getElementById('tableExcel');
    const tableSheet = XLSX.utils.table_to_sheet(table);

    let sheetTitle = '';
    kegiatan = kegiatan.replace(/[:\\/?*[\]]/g, '');  

    const currentYear = new Date().getFullYear();

    sheetTitle = `Absensi Hari Besar (${kegiatan} - ${currentYear})`.slice(0, 31);

    XLSX.utils.book_append_sheet(wb, tableSheet, sheetTitle);

    const fileName = `Rekap Absensi Hari Besar (${kegiatan} - ${currentYear}).xlsx`;

    XLSX.writeFile(wb, fileName);
}