let tableProyek;
if ($("#table-proyek").length) {
    tableProyek = $("#table-proyek")
        .dataTable({
            dom: "Bfrtip",
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            buttons: [],
            bPaginate: false,
            bInfo: false,
            oLanguage: {
                sSearch: "Cari:",
                sZeroRecords: "Data tidak ditemukan",
                sEmptyTable: "Data tidak ditemukan",
            },
        })
        .api();
    $("#table-proyek_filter").appendTo("#filter-search-wrapper");
    $("#table-proyek_filter").find("input").addClass("form-control");
    $("#table-proyek_filter").css("width", "100%");
    $("#table-proyek_filter label").css("width", "100%");
    $("#table-proyek_filter input").css("height", "35px");
    $("#table-proyek_filter label").css("font-weight", "bold");
    $("#table-proyek_filter label").css("margin-bottom", "0");
    $("#table-proyek_filter input").css("padding", "0 10px");
    $("#table-proyek_filter input").attr("placeholder", "Cari Proyek");
    // hide dt-buttons
    $(".dt-buttons").hide();
    // hide dt
}

let tableTugas;
if ($("#table-tugas").length) {
    tableTugas = $("#table-tugas")
        .dataTable({
            dom: "Bfrtip",
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            buttons: [],
            bPaginate: false,
            bInfo: false,
            oLanguage: {
                sSearch: "Cari:",
                sZeroRecords: "Data tidak ditemukan",
                sEmptyTable: "Data tidak ditemukan",
            },
        })
        .api();
    $("#table-tugas_filter").appendTo("#filter-search-wrapper-tugas");
    $("#table-tugas_filter").find("input").addClass("form-control");
    $("#table-tugas_filter").css("width", "100%");
    $("#table-tugas_filter label").css("width", "100%");
    $("#table-tugas_filter input").css("height", "35px");
    $("#table-tugas_filter label").css("font-weight", "bold");
    $("#table-tugas_filter label").css("margin-bottom", "0");
    $("#table-tugas_filter input").css("padding", "0 10px");
    $("#table-tugas_filter input").attr("placeholder", "Cari Tugas");
    $(".dt-buttons").hide();
}

function filterTableTugas() {
    let filterProyek = $("#filter-proyek").val();

    if (filterProyek == "Semua") {
        filterProyek = "";
    }

    if (filterProyek !== "") {
        tableTugas
            .column(1)
            .search("^" + filterProyek + "$", true, false)
            .draw();
    } else {
        tableTugas.column(1).search("").draw();
    }

    // reset numbering in table first column
    tableTugas
        .column(0, { search: "applied", order: "applied" })
        .nodes()
        .each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
}
$("#filter-proyek").on("change", function () {
    filterTableTugas();
});

let table;
if ($("#tim-kerja").length) {
    table = $("#tim-kerja")
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
                        columns: [0, 1, 2, 3, 4, 5, 6],
                    },
                },
                {
                    extend: "pdf",
                    className: "btn-danger",
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6],
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

    $(".dt-buttons").appendTo("#download-button");
    $(".dt-buttons").appendTo("#download-button");
    $(".dataTables_filter").appendTo("#filter-search-wrapper");
    $(".dataTables_filter").find("input").addClass("form-control");
    $(".dataTables_filter").css("width", "100%");
    $(".dataTables_filter label").css("width", "100%");
    $(".dataTables_filter input").css("height", "35px");
    $(".dataTables_filter label").css("font-weight", "bold");
    $(".dataTables_filter label").css("margin-bottom", "0");
    $(".dataTables_filter input").attr("placeholder", "Cari rencana kerja");
    $(".dataTables_filter input").css("padding", "0 10px");
    $(".dt-buttons").appendTo("#download-button");
}

// Show rencana kinerja
$("#btn-modal-create-tugas").on("click", function () {
    $("#error-tugas").text("");
    $("#error-mulai").text("");
    $("#error-selesai").text("");
    $("#error-hasilkerja").text("");
});

$("#create-hasilkerja").on("change", function () {
    let dataId = $("#create-hasilkerja option:selected").val();
    $.ajax({
        url: `/admin/master-hasil/${dataId}`,
        type: "GET",
        cache: false,
        success: function (response) {
            console.log(response);
            $("#create-unsur").val(response.data[0].unsur);
            $("#create-subunsur1").val(response.data[0].subunsur1);
            $("#create-subunsur2").val(response.data[0].subunsur2);
            $("#create-kategori_pelaksana").val(
                response.data[0].kategori_pelaksana
            );
        },
        error: function (e) {
            console.log(e);
        },
    });
});

$("#btn-tambah-tugas").on("click", function (e) {
    event.preventDefault();
    $("#error-tugas").text("");
    $("#error-hasil_kerja").text("");
    $("#error-unsur").text("");
    $("#error-subunsur").text("");
    $("#error-kategori_pelaksana").text("");
    $("#error-proyek").text("");

    if (
        $("#create-tugas").val() == "" ||
        $("#create-hasil_kerja").val() == "" ||
        $("#create-hasil_kerja").val() == null ||
        $("#unsur").val() == "" ||
        $("#subunsur").val() == "" ||
        $("#pelaksana-tugas").val() == "" ||
        $("#create-proyek").val() == null ||
        $("#create-proyek").val() == ""
    ) {
        if ($("#create-tugas").val() == "") {
            $("#error-tugas").text("Tugas harus diisi");
        }
        if ($("#create-hasil_kerja").val() == null) {
            $("#error-hasil_kerja").text("Hasil Kerja harus diisi");
        }
        if ($("#create-hasil_kerja").val() == "") {
            $("#error-hasil_kerja").text("Hasil Kerja harus diisi");
        }
        if (
            $("#create-proyek").val() == "" ||
            $("#create-proyek").val() == null
        ) {
            $("#error-proyek").text("Proyek harus diisi");
        }
        return;
    }

    let token = $("meta[name='csrf-token']").attr("content");
    let id_timkerja = $("#id_timkerja").val();
    let tugas = $("#create-tugas").val();
    let hasilkerja = $("#create-hasil_kerja").val();
    let kategori_pelaksana = $("#pelaksana-tugas").val();
    if (kategori_pelaksana == "Gugus Tugas") {
        kategori_pelaksana = "gt";
    } else if (kategori_pelaksana == "Non Gugus Tugas") {
        kategori_pelaksana = "ngt";
    }
    let id_proyek = $("#create-proyek").val();

    if (
        tugas == "" ||
        hasilkerja == ""
    ) {
        return;
    }
    Swal.fire({
        title: "Menyimpan Data",
        html: "Mohon tunggu sebentar",
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
        },
        allowOutsideClick: () => !Swal.isLoading(),
    });

    $.ajax({
        url: `/ketua-tim/rencana-kinerja`,
        type: "POST",
        cache: false,
        data: {
            _token: token,
            id_timkerja: id_timkerja,
            id_proyek: id_proyek,
            tugas: tugas,
            hasilkerja: hasilkerja,
            kategori_pelaksana: kategori_pelaksana,
        },
        success: function (response) {
            Swal.fire({
                type: "success",
                icon: "success",
                title: "Berhasil!",
                text: "Data berhasil disimpan",
                showConfirmButton: false,
                timer: 3000,
            });
            location.reload();
        },
        error: function (error) {
            Swal.fire({
                type: "error",
                icon: "error",
                title: "Gagal!",
                text: `${error.message}`,
                showConfirmButton: false,
                timer: 3000,
            });
            console.log(error);
            let errorResponses = error.responseJSON;
            let errors = Object.entries(errorResponses.errors);

            errors.forEach(([key, value]) => {
                let errorMessage = document.getElementById(`error-${key}`);
                errorMessage.innerText = `${value}`;
            });
        },
    });
});

$("#btn-edit-tugas").on("click", function (e) {
    event.preventDefault();
    $("#error-edit-tugas").text("");
    $("#error-edit-hasil_kerja").text("");
    $("#error-edit-unsur").text("");
    $("#error-edit-subunsur").text("");
    $("#error-edit-kategori_pelaksana").text("");
    $("#error-edit-proyek").text("");

    if (
        $("#edit-tugas").val() == "" ||
        $("#edit-hasil_kerja").val() == "" ||
        $("#edit-hasil_kerja").val() == null ||
        $("#edit-unsur").val() == "" ||
        $("#edit-subunsur").val() == "" ||
        $("#edit-pelaksana-tugas").val() == "" ||
        $("#edit-proyek").val() == null ||
        $("#edit-proyek").val() == ""
    ) {
        if ($("#edit-tugas").val() == "") {
            $("#error-edit-tugas").text("Tugas harus diisi");
        }
        if ($("#edit-hasil_kerja").val() == null) {
            $("#error-edit-hasil_kerja").text("Hasil Kerja harus diisi");
        }
        if ($("#edit-hasil_kerja").val() == "") {
            $("#error-edit-hasil_kerja").text("Hasil Kerja harus diisi");
        }
        if ($("#edit-proyek").val() == "" || $("#edit-proyek").val() == null) {
            $("#error-edit-proyek").text("Proyek harus diisi");
        }
        return;
    }

    let id_tugas = $("#edit-id_tugas").val();
    let id_proyek = $("#edit-proyek").val();
    let token = $("meta[name='csrf-token']").attr("content");
    let tugas = $("#edit-tugas").val();
    let hasilkerja = $("#edit-hasil_kerja").val();
    let kategori_pelaksana = $("#pelaksana-tugas").val();
    if (kategori_pelaksana == "Gugus Tugas") {
        kategori_pelaksana = "gt";
    } else if (kategori_pelaksana == "Non Gugus Tugas") {
        kategori_pelaksana = "ngt";
    }
    let melaksanakan = $("#edit-melaksanakan").val();
    let capaian = $("#edit-capaian").val();

    if (
        tugas == "" ||
        hasilkerja == ""
    ) {
        return;
    }
    Swal.fire({
        title: "Menyimpan Data",
        html: "Mohon tunggu sebentar",
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
        },
        allowOutsideClick: () => !Swal.isLoading(),
    });

    $.ajax({
        url: `/ketua-tim/rencana-kinerja/${id_tugas}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            proyek: id_proyek,
            tugas: tugas,
            hasilkerja: hasilkerja,
            kategori_pelaksana: kategori_pelaksana,
        },
        success: function (response) {
            Swal.fire({
                type: "success",
                icon: "success",
                title: "Berhasil!",
                text: "Data berhasil disimpan",
                showConfirmButton: false,
                timer: 3000,
            });
            location.reload();
        },
        error: function (error) {
            Swal.fire({
                type: "error",
                icon: "error",
                title: "Gagal!",
                text: "Data gagal disimpan",
                showConfirmButton: false,
                timer: 3000,
            });
            let errorResponses = error.responseJSON;
            let errors = Object.entries(errorResponses.errors);

            errors.forEach(([key, value]) => {
                let errorMessage = document.getElementById(`error-${key}`);
                errorMessage.innerText = `${value}`;
            });
        },
    });
});

$("#id_hasilkerja").on("change", function () {
    let dataId = $("#id_hasilkerja option:selected").val();
    console.log(dataId);
    $.ajax({
        url: `/admin/master-hasil/${dataId}`,
        type: "GET",
        cache: false,
        success: function (response) {
            console.log(response);
            $("#subunsur1").val(response.data[0].subunsur1);
            $("#subunsur2").val(response.data[0].subunsur2);
            $("#kategori_hasilkerja").val(response.data[0].kategori_hasilkerja);
            $("#kategori_pelaksana").val(response.data[0].kategori_pelaksana);
        },
        error: function (e) {
            console.log(e);
        },
    });
});

$("#id_sasaran").on("change", function () {
    let idtujuan = $("#id_sasaran option:selected").data("idtujuan");
    $("#id_tujuan").val(idtujuan);
});

$("#edit-id_sasaran").on("change", function () {
    let id_tujuan = $("#edit-id_sasaran option:selected").data("idtujuan");
    $("#edit-id_tujuan").val(id_tujuan);
});

$(".edit-btn").on("click", function () {
    let dataId = $(this).attr("data-id");
    dataId = JSON.stringify(dataId);
    let url = "/pegawai/tim-pelaksana/" + dataId;
    console.log(url);
});

$("#btn-edit-submit").on("click", function (e) {
    e.preventDefault();

    let token = $("meta[name='csrf-token']").attr("content");

    let id_tujuan = $("#edit-id_tujuan").val();
    let id_sasaran = $("#edit-id_sasaran").val();
    let id_iku = $("#edit-id_iku").val();
    let iku = $("#edit-iku").val();

    $.ajax({
        url: `/admin/master-iku/${id_iku}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            id_iku: id_iku,
            id_sasaran: id_sasaran,
            iku: iku,
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

            $("#modal-edit-masteriku").modal("hide");
            setTimeout(location.reload(), 1000);
            console.log(response.data[0]);
        },
        error: function (error) {
            console.log(error.responseJSON);
        },
    });
});

// Delete Data
$(".delete-btn").on("click", function (e) {
    e.preventDefault();
    let dataId = $(this).attr("data-id");
    let token = $("meta[name='csrf-token']").attr("content");

    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Data tidak dapat dipulihkan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--primary)",
        cancelButtonColor: "var(--danger)",
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/ketua-tim/rencana-kinerja/${dataId}`,
                type: "DELETE",
                cache: false,
                data: {
                    _token: token,
                },
                success: function (response) {
                    Swal.fire({
                        type: "success",
                        icon: "success",
                        title: "Berhasil!",
                        text: "Data berhasil dihapus",
                        showConfirmButton: false,
                        timer: 3000,
                    });
                    location.reload();
                },
            });
        }
    });
});

$("#btn-send-rencana-kerja").on("click", function (e) {
    e.preventDefault();
    let id_timkerja = $("#id_timkerja").val();
    let token = $("meta[name='csrf-token']").attr("content");

    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Rencana Kerja yang telah dikirim tidak dapat diubah kembali!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--primary)",
        cancelButtonColor: "var(--danger)",
        confirmButtonText: "Kirim",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/ketua-tim/rencana-kinerja/send/${id_timkerja}`,
                type: "PUT",
                cache: false,
                data: {
                    _token: token,
                    id_timkerja: id_timkerja,
                },
                success: function (response) {
                    location.reload();
                },
                error: function (e) {
                    console.log(e);
                },
            });
        }
    });
});

$("#btn-admin-submit-rk").on("click", function (e) {
    e.preventDefault();
    let id_timkerja = $("#id_timkerja").val();
    let token = $("meta[name='csrf-token']").attr("content");

    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Rencana Kerja yang telah dikirim tidak dapat diubah kembali!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--primary)",
        cancelButtonColor: "var(--danger)",
        confirmButtonText: "Kirim",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/rencana-kinerja/send/${id_timkerja}`,
                type: "PUT",
                cache: false,
                data: {
                    _token: token,
                    id_timkerja: id_timkerja,
                },
                success: function (response) {
                    location.reload();
                },
                error: function (e) {
                    console.log(e);
                },
            });
        }
    });
});

$("#btn-admin-send-back").on("click", function (e) {
    e.preventDefault();
    let id_timkerja = $("#id_timkerja").val();
    let token = $("meta[name='csrf-token']").attr("content");

    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Rencana Kerja akan dikembalikan untuk direvisi!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--primary)",
        cancelButtonColor: "var(--danger)",
        confirmButtonText: "Kirim",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/rencana-kinerja/return/${id_timkerja}`,
                type: "PUT",
                cache: false,
                data: {
                    _token: token,
                    id_timkerja: id_timkerja,
                },
                success: function (response) {
                    location.reload();
                },
                error: function (e) {
                    console.log(e);
                },
            });
        }
    });
});

$("#btn-edit-tim").on("click", function () {
    event.preventDefault();
    let id_timkerja = $("#id_timkerja").val();
    let token = $("meta[name='csrf-token']").attr("content");
    let uraian_tugas = $("#edit-uraian_tugas").val();
    let rk_ketua = $("#edit-rk_ketua").val();
    let iki_ketua = $("#edit-iki_ketua").val();
    $("#error-edit-uraian").text("");
    $("#error-edit-rk").text("");
    $("#error-edit-iki").text("");
    if (uraian_tugas == "" || rk_ketua == "" || iki_ketua == "") {
        if (uraian_tugas == "") {
            $("#error-edit-uraian").text("Uraian Tugas harus diisi");
        }
        if (rk_ketua == "") {
            $("#error-edit-rk").text("RK Ketua harus diisi");
        }
        if (iki_ketua == "") {
            $("#error-edit-iki").text("IKI Ketua harus diisi");
        }
        return;
    }
    Swal.fire({
        title: "Menyimpan Data",
        html: "Mohon tunggu sebentar",
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
        },
        allowOutsideClick: () => !Swal.isLoading(),
    });
    $.ajax({
        url: `/admin/tim-kerja/${id_timkerja}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            id_timkerja: id_timkerja,
            uraian_tugas: uraian_tugas,
            rk_ketua: rk_ketua,
            iki_ketua: iki_ketua,
        },
        success: function (response) {
            location.reload();
        },
        error: function (e) {
            Swal.fire({
                type: "error",
                icon: "error",
                title: "Gagal!",
                text: `${e.message}`,
                showConfirmButton: false,
                timer: 3000,
            });
        },
    });
});

$("#btn-create-proyek").on("click", function () {
    event.preventDefault();
    let id_timkerja = $("#id_timkerja").val();
    let nama_proyek = $("#create-nama_proyek").val();
    let token = $("meta[name='csrf-token']").attr("content");
    $("#error-nama_proyek").text("");
    if (nama_proyek == "") {
        if (nama_proyek == "") {
            $("#error-nama_proyek").text("Nama Proyek harus diisi");
        }
        return;
    }
    // swal loading
    Swal.fire({
        title: "Menyimpan Data",
        html: "Mohon tunggu sebentar",
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
        },
        allowOutsideClick: () => !Swal.isLoading(),
    });

    $.ajax({
        url: `/ketua-tim/rencana-kinerja/proyek`,
        type: "POST",
        cache: false,
        data: {
            _token: token,
            id_timkerja: id_timkerja,
            nama_proyek: nama_proyek,
        },
        success: function (response) {
            Swal.fire({
                type: "success",
                icon: "success",
                title: "Berhasil!",
                text: "Data berhasil disimpan",
                showConfirmButton: false,
                timer: 3000,
            });
            location.reload();
        },
        error: function (e) {
            Swal.fire({
                type: "error",
                icon: "error",
                title: "Gagal!",
                text: `Data gagal disimpan`,
                showConfirmButton: false,
                timer: 3000,
            });
        },
    });
});

$("#btn-edit-proyek").on("click", function () {
    event.preventDefault();
    let id_proyek = $("#edit-id_proyek").val();
    let nama_proyek = $("#edit-nama_proyek").val();
    let rk_anggota = $("#edit-rk_anggota").val();
    let token = $("meta[name='csrf-token']").attr("content");
    $("#error-edit-nama_proyek").text("");
    $("#error-edit-rk_anggota").text("");
    if (nama_proyek == "" ) {
        if (nama_proyek == "") {
            $("#error-edit-nama_proyek").text("Nama Proyek harus diisi");
        }
        return;
    }
    // swal loading
    Swal.fire({
        title: "Menyimpan Data",
        html: "Mohon tunggu sebentar",
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
        },
        allowOutsideClick: () => !Swal.isLoading(),
    });

    $.ajax({
        url: `/ketua-tim/rencana-kinerja/proyek/update/${id_proyek}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            nama_proyek: nama_proyek,
        },
        success: function (response) {
            Swal.fire({
                type: "success",
                icon: "success",
                title: "Berhasil!",
                text: "Data berhasil disimpan",
                showConfirmButton: false,
                timer: 3000,
            });
            location.reload();
        },
        error: function (e) {
            Swal.fire({
                type: "error",
                icon: "error",
                title: "Gagal!",
                text: `Data gagal disimpan`,
                showConfirmButton: false,
                timer: 3000,
            });
        },
    });
});

// create-hasil_kerja onchange
$("#create-hasil_kerja").on("change", function () {
    let dataId = $("#create-hasil_kerja option:selected").val();
    $.ajax({
        url: `/admin/master-hasil-kerja/detail/${dataId}`,
        type: "GET",
        cache: false,
        success: function (response) {
            $("#unsur").val(response.masterUnsurName);
            $("#subunsur").val(response.masterSubUnsurName);
            let pelaksana = response.kategori_pelaksana;
            if (pelaksana == "gt") {
                $("#pelaksana-tugas").val("Gugus Tugas");
            } else if (pelaksana == "ngt") {
                $("#pelaksana-tugas").val("Non Gugus Tugas");
            }
        },
        error: function (e) {
            console.log(e);
        },
    });
});
$("#edit-hasil_kerja").on("change", function () {
    let dataId = $("#edit-hasil_kerja option:selected").val();
    $.ajax({
        url: `/admin/master-hasil-kerja/detail/${dataId}`,
        type: "GET",
        cache: false,
        success: function (response) {
            $("#edit-unsur").val(response.masterUnsurName);
            $("#edit-subunsur").val(response.masterSubUnsurName);
            let pelaksana = response.kategori_pelaksana;
            if (pelaksana == "gt") {
                $("#edit-pelaksana-tugas").val("Gugus Tugas");
            } else if (pelaksana == "ngt") {
                $("#edit-pelaksana-tugas").val("Non Gugus Tugas");
            }
        },
        error: function (e) {
            console.log(e);
        },
    });
});

// Taruh dipaling bawah, Soalnya nanti ngaruh ke function yang laen
let rupiah = document.getElementsByClassName("rupiah");
for (i = 0; i <= rupiah.length - 1; i++) {
    let tmp = rupiah[i].innerText.toString();
    rupiah[i].innerText = formatRupiah(tmp, "Rp. ");
}

function filterTable() {
    let filterUnitKerja = $("#filter-unit-kerja").val();

    if (filterUnitKerja == "Semua") {
        filterUnitKerja = "";
    }

    if (filterUnitKerja !== "") {
        table
            .column(2)
            .search("^" + filterUnitKerja + "$", true, false)
            .draw();
    } else {
        table.column(2).search("").draw();
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

$("#yearSelect").on("change", function () {
    let year = $(this).val();
    $("#yearForm").attr("action", `?year=${year}`);
    $("#yearForm").find('[name="_token"]').remove();
    $("#yearForm").submit();
});

$("#modal-edit-proyek").on("show.bs.modal", function (e) {
    let id_proyek = $(e.relatedTarget).data("id");
    let nama_proyek = $(e.relatedTarget).data("nama");
    let rk_anggota = $(e.relatedTarget).data("rencana");
    let iki_anggota = $(e.relatedTarget).data("iki");

    $("#edit-id_proyek").val(id_proyek);
    $("#edit-nama_proyek").val(nama_proyek);
    $("#edit-rk_anggota").val(rk_anggota);
    $("#edit-iki_anggota").val(iki_anggota);
});

$("#modal-edit-tugas").on("show.bs.modal", function (e) {
    let id_tugas = $(e.relatedTarget).data("id");
    let tugas = $(e.relatedTarget).data("tugas");
    let hasil_kerja = $(e.relatedTarget).data("hasil");
    let melaksanakan = $(e.relatedTarget).data("melaksanakan");
    let capaian = $(e.relatedTarget).data("capaian");
    let id_proyek = $(e.relatedTarget).data("proyek");
    let unsur = $(e.relatedTarget).data("unsur");
    let subunsur = $(e.relatedTarget).data("subunsur");
    let kategori_pelaksana = $(e.relatedTarget).data("pelaksana");

    if (kategori_pelaksana == "gt") {
        kategori_pelaksana = "Gugus Tugas";
    } else if (kategori_pelaksana == "ngt") {
        kategori_pelaksana = "Non Gugus Tugas";
    }

    $("#edit-subunsur").val(subunsur);
    $("#edit-unsur").val(unsur);
    $("#edit-id_tugas").val(id_tugas);
    $("#edit-tugas").val(tugas);
    $("#edit-hasil_kerja").val(hasil_kerja);
    $("#edit-hasil_kerja").trigger("change");
    $("#edit-pelaksana-tugas").val(kategori_pelaksana);

    $("#edit-melaksanakan").val(melaksanakan);
    $("#edit-capaian").val(capaian);
    $("#edit-proyek").val(id_proyek);
    $("#edit-proyek").trigger("change");
});
