$(document).on("click", ".edit-button", function () {
    var id = $(this).data("id");
    $("#edit-form").attr("action", "/admin/master-hasil-kerja/" + id);
    $.ajax({
        url: "/admin/master-hasil-kerja/detail/" + id,
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

$(document).on("change", "#masterUnsurId", function () {
    var id = $(this).val();
    $.ajax({
        url: "/admin/master-subunsur/unsur/" + id,
        method: "GET",
        success: function (data) {
            $("#masterSubUnsurId").attr("disabled", false);
            var html = "";
            data.forEach((item) => {
                html += `<option value="${item.id}">${item.nama_sub_unsur}</option>`;
            });
            $("#masterSubUnsurId").html(html);
        },
    });
});

// onchange radio button
$(document).on("change", "input[type=radio][name=status]", function () {
    var value = $(this).val();
    if (value == "1") {
        $("#wrapper-picKoordinator").hide();
        $("#picKoordinator").attr("required", false);
        $("#pengendali-teknis").show();
        $("#ketua-tim").show();
        $("#pengendaliTeknis").attr("required", true);
        $("#ketuaTim").attr("required", true);
    } else {
        $("#wrapper-picKoordinator").show();
        $("#picKoordinator").attr("required", true);
        $("#pengendali-teknis").hide();
        $("#ketua-tim").hide();
        $("#pengendaliTeknis").attr("required", false);
        $("#ketuaTim").attr("required", false);
    }
});
$(document).on("change", "input[type=radio][name=editStatus]", function () {
    var value = $(this).val();
    if (value == "1") {
        $("#edit-picKoordinator").hide();
        $("#editPicKoordinator").attr("required", false);
        $("#edit-pengendali-teknis").show();
        $("#edit-ketua-tim").show();
        $("#editPengendaliTeknis").attr("required", true);
        $("#editKetuaTim").attr("required", true);
    } else {
        $("#edit-picKoordinator").show();
        $("#editPicKoordinator").attr("required", true);
        $("#edit-pengendali-teknis").hide();
        $("#edit-ketua-tim").hide();
        $("#editPengendaliTeknis").attr("required", false);
        $("#editKetuaTim").attr("required", false);
    }
});

$(function () {
    let table;

    if ($("#master-hasil-kerja").length) {
        table = $("#master-hasil-kerja")
            .dataTable({
                dom: "Bfrtip",
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                pageLength: 25,
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

        $(".dataTables_filter input").attr(
            "placeholder",
            "Cari berdasarkan hasil kerja atau subunsur"
        );
        // add padding x 10px to .dataTables_filter input
        $(".dataTables_filter input").css("padding", "0 10px");
        $(".dt-buttons").appendTo("#download-button");
    }
    // restart numbering if data table is filter input is changed
    $("#master-hasil-kerja").on("search.dt", function () {
        table
            .column(0, { search: "applied", order: "applied" })
            .nodes()
            .each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
    });
});

$(".submit-btn").on("click", function () {
    // disable button after click
    if (
        $("#masterUnsurId").val() == "" ||
        $("#namaHasilKerja").val() == "" ||
        $("#hasilKerjaTim").val() == "" ||
        $("#status").val() == "" ||
        $("#anggotaTim").val() == ""
    ) {
        return;
    }
    if ("input[type=radio][name=status]" == "1") {
        if ($("#picKoordinator").val() == "") {
            return;
        }
    } else {
        if ($("#pengendaliTeknis").val() == "" || $("#ketuaTim").val() == "") {
            return;
        }
    }
    $(this).attr("disabled", true);
    $(this).closest("form").submit();
});
