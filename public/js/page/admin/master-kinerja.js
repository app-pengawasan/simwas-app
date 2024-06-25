$(document).on("click", ".edit-button", function () {
    var id = $(this).data("id");
    $("#edit-form").attr("action", "/admin/master-kinerja/" + id);
    $.ajax({
        url: "/admin/master-kinerja/detail/" + id,
        method: "GET",
        success: function (data) {
            $("#editId").val(data.id);
            $("#editMasterUnsurId").val(data.masterUnsurId);
            $("#editMasterSubUnsurId").val(data.master_subunsur_id);
            $("#editNamaHasilKerja").val(data.nama_hasil_kerja);
            $("#editHasilKerjaTim").val(data.hasil_kerja_tim);
            $("#editPengendaliTeknis").val(data.pengendali_teknis);
            $("#editKetuaTim").val(data.ketua_tim);
            $("#editPicKoordinator").val(data.pic);
            $("#editAnggotaTim").val(data.anggota_tim);

            if (data.kategori_pelaksana == "ngt") {
                $("#editStatus1").prop("checked", true);
                $("#edit-picKoordinator").show();
                $("#editPicKoordinator").attr("required", true);
                $("#edit-pengendali-teknis").hide();
                $("#edit-ketua-tim").hide();
                $("#editPengendaliTeknis").attr("required", false);
                $("#editKetuaTim").attr("required", false);
                $("#ngt").prop("checked", true);
            } else {
                $("#editStatus2").prop("checked", true);
                $("#edit-picKoordinator").hide();
                $("#editPicKoordinator").attr("required", false);
                $("#edit-pengendali-teknis").show();
                $("#edit-ketua-tim").show();
                $("#edit-pengendaliTeknis").attr("required", true);
                $("#edit-ketuaTim").attr("required", true);
                // check radio button input with id ngt
            }
        },
    });
});

$(document).on("click", ".hapus-button", function () {
    var id = $(this).data("id");

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
            $("#form-" + id).trigger("submit");
        }
    });
});

$(function () {
    let table;

    if ($("#master-kinerja").length) {
        table = $("#master-kinerja")
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
                        filename: "Master Hasil Kerja",
                    },
                    {
                        extend: "pdf",
                        className: "btn-danger",
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        filename: "Master Hasil Kerja",
                    },
                ],
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

        $(".dataTables_filter input").attr("placeholder", "Cari");
        // add padding x 10px to .dataTables_filter input
        $(".dataTables_filter input").css("padding", "0 10px");
        $(".dt-buttons").appendTo("#download-button");
    }
    // restart numbering if data table is filter input is changed
    $("#master-kinerja").on("search.dt", function () {
        table
            .column(0, { search: "applied", order: "applied" })
            .nodes()
            .each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
    });
});

$("#editHasilKerjaID").on("change", function () {
    var id = $(this).val();
    $.ajax({
        url: "/admin/master-hasil-kerja/detail/" + id,
        method: "GET",
        success: function (data) {
            $("#edit-status").val(data.kategori_pelaksana);

            if (data.kategori_pelaksana == "ngt") {
                console.log("ngt");
                $("#edit-gugus-tugas").hide();
                $("#edit-gugus-tugas")
                    .find("input, select, textarea")
                    .removeAttr("required")
                    .prop("disabled", true);

                $("#edit-non-gugus-tugas").show();
                $("#edit-non-gugus-tugas")
                    .find("input, select, textarea")
                    .attr("required", true)
                    .prop("disabled", false);
            } else {
                $("#edit-gugus-tugas").show();
                $("#edit-gugus-tugas")
                    .find("input, select, textarea")
                    .attr("required", true)
                    .prop("disabled", false);
                $("#edit-non-gugus-tugas").hide();
                $("#edit-non-gugus-tugas")
                    .find("input, select, textarea")
                    .removeAttr("required")
                    .prop("disabled", true);
            }
        },
    });
});

$("#hasilKerjaID").on("change", function () {
    var id = $(this).val();
    $.ajax({
        url: "/admin/master-hasil-kerja/detail/" + id,
        method: "GET",
        success: function (data) {
            $("#create-status").val(data.kategori_pelaksana);
            if (data.kategori_pelaksana == "ngt") {
                $("#gugus-tugas").hide();
                $("#gugus-tugas")
                    .find("input, select, textarea")
                    .removeAttr("required")
                    .prop("disabled", true);

                $("#non-gugus-tugas").show();
                $("#non-gugus-tugas")
                    .find("input, select, textarea")
                    .attr("required", true)
                    .prop("disabled", false);
            } else {
                $("#gugus-tugas").show();
                $("#gugus-tugas")
                    .find("input, select, textarea")
                    .attr("required", true)
                    .prop("disabled", false);
                $("#non-gugus-tugas").hide();
                $("#non-gugus-tugas")
                    .find("input, select, textarea")
                    .removeAttr("required")
                    .prop("disabled", true);
            }
        },
    });
});

$(".btn-delete").on("click", function () {
    event.preventDefault();
    var id = $(this).data("id");
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
            $("#form-delete-" + id).trigger("submit");
        }
    });
});

$(".btn-edit").on("click", function () {
    event.preventDefault();
    var id = $(this).data("id");
    // create roles key value
    let roles = {
        1: "pengendaliTeknis",
        2: "ketuaTim",
        3: "PIC",
        4: "anggotaTim",
        5: "penanggungJawabKegiatan",
    };
    // ajax
    $.ajax({
        url: "master-kinerja/detail/" + id,
        method: "GET",
        success: function (data) {
            $("#edit-status").val(data.master_hasil_kerja.kategori_pelaksana);
            $("#editHasilKerjaID").val(data.hasil_kerja_id);
            $("#editHasilKerjaID").trigger("change");
            if (data.master_hasil_kerja.kategori_pelaksana == "ngt") {
                $("#edit-gugus-tugas").hide();
                $("#edit-gugus-tugas")
                    .find("input, select, textarea")
                    .removeAttr("required")
                    .prop("disabled", true);

                $("#edit-non-gugus-tugas").show();
                $("#edit-non-gugus-tugas")
                    .find("input, select, textarea")
                    .attr("required", true)
                    .prop("disabled", false);
            } else {
                $("#edit-gugus-tugas").show();
                $("#edit-gugus-tugas")
                    .find("input, select, textarea")
                    .attr("required", true)
                    .prop("disabled", false);
                $("#edit-non-gugus-tugas").hide();
                $("#edit-non-gugus-tugas")
                    .find("input, select, textarea")
                    .removeAttr("required")
                    .prop("disabled", true);
            }

            data.master_kinerja_pegawai.forEach((item) => {
                for (const [key, value] of Object.entries(roles)) {
                    if (item.pt_jabatan == key) {
                        $(`#editHasilKerja_${value}`).val(item.hasil_kerja);
                        $(`#editRencanaKinerja_${value}`).val(
                            item.rencana_kinerja
                        );
                        $(`#editIki_${value}`).val(item.iki);
                        $(`#editKegiatan_${value}`).val(item.kegiatan);
                        $(`#editCapaian_${value}`).val(item.capaian);
                    }
                }
            });
        },
        // looping trough roles
    });
});

$("#submit-create-btn").on("click", function () {
    event.preventDefault();
    var roles = {};
    if ($("#create-status").val() == "ngt") {
        roles = {
            3: "PIC",
            4: "anggotaTim",
            5: "penanggungJawabKegiatan",
        };
    } else {
        roles = {
            1: "pengendaliTeknis",
            2: "ketuaTim",
            4: "anggotaTim",
        };
    }

    let error = false;
    // remove all is-invalid class
    $(".is-invalid").removeClass("is-invalid");
    for (const [key, value] of Object.entries(roles)) {
        if ($(`#hasilKerja_${value}`).val() == "") {
            error = true;
            $(`#hasilKerja_${value}`).addClass("is-invalid");
        }
        if ($(`#rencanaKinerja_${value}`).val() == "") {
            error = true;
            $(`#rencanaKinerja_${value}`).addClass("is-invalid");
        }
        if ($(`#iki_${value}`).val() == "") {
            error = true;
            $(`#iki_${value}`).addClass("is-invalid");
        }
        if ($(`#kegiatan_${value}`).val() == "") {
            error = true;
            $(`#kegiatan_${value}`).addClass("is-invalid");
        }
        if ($(`#capaian_${value}`).val() == "") {
            error = true;
            $(`#capaian_${value}`).addClass("is-invalid");
        }
    }
    if (error) {
        return;
    }
    $(this).attr("disabled", true);
    $(this).closest("form").submit();
});

$("#submit-edit-button").on("click", function () {
    // if no error submit form
    event.preventDefault();
    var roles = {};
    if ($("#edit-status").val() == "ngt") {
        roles = {
            3: "PIC",
            4: "anggotaTim",
            5: "penanggungJawabKegiatan",
        };
    } else {
        roles = {
            1: "pengendaliTeknis",
            2: "ketuaTim",
            4: "anggotaTim",
        };
    }
    let error = false;
    // remove all is-invalid class
    $(".is-invalid").removeClass("is-invalid");
    for (const [key, value] of Object.entries(roles)) {
        if ($(`#editHasilKerja_${value}`).val() == "") {
            error = true;
            console.log(value);
            $(`#editHasilKerja_${value}`).addClass("is-invalid");
        }
        if ($(`#editRencanaKinerja_${value}`).val() == "") {
            error = true;
            console.log(value);
            $(`#editRencanaKinerja_${value}`).addClass("is-invalid");
        }
        if ($(`#editIki_${value}`).val() == "") {
            error = true;
            console.log(value);

            $(`#editIki_${value}`).addClass("is-invalid");
        }
        if ($(`#editKegiatan_${value}`).val() == "") {
            error = true;
            console.log(value);

            $(`#editKegiatan_${value}`).addClass("is-invalid");
        }
        if ($(`#editCapaian_${value}`).val() == "") {
            error = true;
            console.log(value);

            $(`#editCapaian_${value}`).addClass("is-invalid");
        }
    }
    if (error) {
        return;
    }
    $(this).attr("disabled", true);
    $(this).closest("form").submit();
});

$("#modal-edit-master-kinerja").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget);
    var id = button.data("id");
    $("#form-edit-master-kinerja").attr(
        "action",
        "/admin/master-kinerja/update/" + id
    );
});
