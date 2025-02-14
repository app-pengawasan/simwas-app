let table;

if ($("#table-norma-hasil").length) {
    table = $("#table-norma-hasil")
        .dataTable({
            dom: "Bfrtip",
            responsive: false,
            lengthChange: false,
            autoWidth: false,
            scrollX: true,
            pageLength: 25,
            buttons: [
                {
                    extend: "excel",
                    className: "btn-success",
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    },
                },
                {
                    extend: "pdf",
                    className: "btn-danger",
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    },
                },
            ],
            oLanguage: {
                sSearch: "Cari:",
                sZeroRecords: "Data tidak ditemukan",
                sEmptyTable: "Data tidak ditemukan",
                sInfo: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                sInfoEmpty: "Menampilkan 0 - 0 dari 0 data",
                sInfoFiltered: "(disaring dari _MAX_ data)",
                sLengthMenu: "Tampilkan _MENU_ data",
                oPaginate: {
                    sPrevious: "Sebelumnya",
                    sNext: "Selanjutnya",
                },
            },
        })
        .api();
    
    localStorage.setItem("mini-sidebar", "true");
    setTimeout( function () {
        table.columns.adjust();
    }, 800);

    //update ukuran tabel saat ukuran sidebar berubah
    $('.nav-link').on("click", function () {
        setTimeout( function () {
            table.columns.adjust();
        }, 500);
    });

    // move datatable button to inside download button
    $(".dt-buttons").appendTo("#download-button");
    $(".dt-buttons").appendTo("#download-button");
    $(".dataTables_filter").appendTo("#filter-search-wrapper");
    $(".dataTables_filter").find("input").addClass("form-control");
    // .dataTables_filter width 100%
    $(".dataTables_filter").css("width", "100%");
    // .dataTables_filter label width 100%
    $(".dataTables_filter label").css("width", "100%");
    // input height 35px
    $(".dataTables_filter input").css("height", "35px");
    // make label text bold and black
    $(".dataTables_filter label").css("font-weight", "bold");
    // remove bottom margin from .dataTables_filter
    $(".dataTables_filter label").css("margin-bottom", "0");

    $(".dataTables_filter input").attr(
        "placeholder",
        "Cari"
    );
    // add padding x 10px to .dataTables_filter input
    $(".dataTables_filter input").css("padding", "0 10px");
    $(".dt-buttons").appendTo("#download-button");
}
// restart numbering if data table is filter input is changed
$("#table-norma-hasil").on("search.dt", function () {
    table
        .column(0, { search: "applied", order: "applied" })
        .nodes()
        .each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
});

function filterTable() {
    let filterSurat = $("#filter-surat").val();
    let filterStatus = $("#filter-status").val();

    if (filterSurat == "Semua") {
        filterSurat = "";
    }
    if (filterStatus == "Semua") {
        filterStatus = "";
    }

    table
        .column(3)
        .search(filterSurat, true, false)
        .column(6)
        .search(filterStatus, true, false)
        .draw();

    // reset numbering in table first column
    table
        .column(0, { search: "applied", order: "applied" })
        .nodes()
        .each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
}
$("#filter-surat, #filter-status").on("change", function () {
    filterTable();
});

$("#filter-unit-kerja").on("change", function () {
    let unitKerja = $("#filter-unit-kerja").val();
    let url = new URL(window.location.href);
    url.searchParams.set("unit_kerja", unitKerja);
    // reload page
    window.location.href = url.href;
});

$("#filter-tahun").on("change", function () {
    let year = $("#filter-tahun").val();
    let url = new URL(window.location.href);
    url.searchParams.set("year", year);
    // reload page
    window.location.href = url.href;
});

