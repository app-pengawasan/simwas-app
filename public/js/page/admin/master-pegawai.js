$(function () {
    let table;

    if ($("#table-master-pegawai").length) {
        table = $("#table-master-pegawai")
            .dataTable({
                dom: "Bfrtip",
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                buttons: [
                    {
                        extend: "excel",
                        className: "btn-success",
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3],
                            orthogonal: "sort",
                        },
                        customizeData: function (data) {
                            for (var i = 0; i < data.body.length; i++) {
                                for (var j = 0; j < data.body[i].length; j++) {
                                    data.body[i][j] =
                                        "\u200C" + data.body[i][j];
                                }
                            }
                        },
                    },
                    {
                        extend: "pdf",
                        className: "btn-danger",
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        exportOptions: {
                            columns: [0, 1, 2, 3],
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
                pageLength: 25,
            })
            .api();

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
            "Cari berdasarkan NIP atau Nama"
        );
        // add padding x 10px to .dataTables_filter input
        $(".dataTables_filter input").css("padding", "0 10px");
        $(".dt-buttons").appendTo("#download-button");

        function filterTable() {
            let filterUnitKerja = $("#filter-unit-kerja").val();

            if (filterUnitKerja == "Semua") {
                filterUnitKerja = "";
            }

            if (filterUnitKerja == "") {
                table.column(3).search(filterUnitKerja, true, false).draw();
            } else if (filterUnitKerja !== "") {
                table
                    .column(3)
                    .search("^" + filterUnitKerja + "$", true, false)
                    .draw();
            } else if (filterUnitKerja == "") {
                table.column(3).search(filterUnitKerja, true, false).draw();
            } else {
                table
                    .column(3)
                    .search("^" + filterUnitKerja + "$", true, false)
                    .draw();
            }

            // reset numbering in table first column
            table
                .column(0, { search: "applied", order: "applied" })
                .nodes()
                .each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
        }
        $("#filter-unit-kerja").on("change", function () {
            filterTable();
        });
    }
    // restart numbering if data table is filter input is changed
    $("#table-master-pegawai").on("search.dt", function () {
        table
            .column(0, { search: "applied", order: "applied" })
            .nodes()
            .each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
    });
});

// Kembali ke Halaman sebelumnya
$("#btn-back, #btn-back2").on("click", function (e) {
    e.preventDefault();
    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Data pegawai belum tersimpan.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--primary)",
        cancelButtonColor: "var(--danger)",
        confirmButtonText: "Yakin",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            // window.location.href("admin/master-pegawai");
            window.location.href = "/admin/master-pegawai";
        }
    });
});

// Menghapus pegawai
$(".delete-btn").on("click", function (e) {
    e.preventDefault();
    let dataId = $(this).attr("data-id");
    let token = $("meta[name='csrf-token']").attr("content");

    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Pegawai yang dinonaktifkan tidak bisa dilibatkan dalam rencana kinerja!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--primary)",
        cancelButtonColor: "var(--danger)",
        confirmButtonText: "Nonaktifkan",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            // let formDelete = $("#form-delete");
            // formDelete[0].action = formDelete[0].action.replace(":id", dataId);
            // formDelete[0].submit();
            // console.log(formDelete.button);
            $.ajax({
                url: `/admin/master-pegawai/${dataId}`,
                method: "DELETE",
                cache: false,
                data: {
                    _token: token,
                },
                success: function (response) {
                    Swal.fire({
                        type: "success",
                        icon: "success",
                        title: "Berhasil!",
                        text: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000,
                    });
                    // redirect to master pegawai page
                    setTimeout(() => {
                        window.location.href = "/admin/master-pegawai";
                    }, 300);
                },
                error: function (error) {
                    Swal.fire({
                        title: "Gagal!",
                        text: `${error.responseJSON.message}`,
                        icon: "error",
                        confirmButtonColor: "var(--primary)",
                    });
                },
            });
        }
    });
});

$(".activate-btn").on("click", function (e) {
    e.preventDefault();
    let dataId = $(this).attr("data-id");
    let token = $("meta[name='csrf-token']").attr("content");

    $.ajax({
        url: `/admin/master-pegawai/activate/${dataId}`,
        method: "POST",
        cache: false,
        data: {
            _token: token,
        },
        success: function (response) {
            Swal.fire({
                type: "success",
                icon: "success",
                title: "Berhasil!",
                text: `${response.message}`,
                showConfirmButton: false,
                timer: 3000,
            });
            // redirect to master pegawai page
            setTimeout(() => {
                window.location.href = "/admin/master-pegawai";
            }, 1000);
        },
        error: function (error) {
            Swal.fire({
                title: "Gagal!",
                text: `${error.responseJSON.message}`,
                icon: "error",
                confirmButtonColor: "var(--primary)",
            });
        },
    });
});

document.forms["addPegawai"].reset();

$("#name").on("change", function (e) {
    let nip = $(this).find(":selected").data("nip");
    Swal.fire({
        title: "Mengambil Data",
        html: "Mohon tunggu sebentar",
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
        },
        allowOutsideClick: () => !Swal.isLoading(),
    });
    $.ajax({
        url: `/admin/master-pegawai/getPegawai/${nip}`,
        method: "GET",
        cache: false,
        // data: {
        //     _token: token,
        // },
        success: function (response) {
            $("#email").val(response[0]["email"]);
            $("#nip").val(response[0]["attributes"]["attribute-nip"][0]);
            $("#pangkat").val(
                response[0]["attributes"]["attribute-golongan"][0]
            );
            // switch(response[0]['attributes']['attribute-organisasi'][0]) {
            //     case '000000081000':
            //         $('#unit_kerja').val('Inspektorat Wilayah I');
            //         break;
            //     case '000000082000':
            //         $('#unit_kerja').val('Inspektorat Wilayah II');
            //         break;
            //     case '000000083000':
            //         $('#unit_kerja').val('Inspektorat Wilayah III');
            //         break;
            //     default:
            //         $('#unit_kerja').val('Inspektorat Utama');
            // }
            let unit_kerja =
                response[0]["attributes"]["attribute-organisasi"][0];
            $("#unit_kerja").val(
                unit_kerja.substring(7, unit_kerja.length - 1)
            );
            // $('#jabatan').val(response[0]['attributes']['attribute-jabatan'][0]);
            $("#jabatan").val(0);
            Swal.close();
        },
        error: function (error) {
            // console.log(error);
            // let errorResponses = error.responseJSON;
            // let errors = Object.entries(errorResponses.errors);

            // errors.forEach(([key, value]) => {
            //     let errorMessage = document.getElementById(`error-${key}`);
            //     errorMessage.innerText = `${value}`;
            // });
            Swal.close();
        },
    });
});
