// function when edit-button class clicked
$(document).on("click", ".edit-button", function () {
    var id = $(this).data("id");
    $("#edit-form").attr("action", "/admin/master-hasil-kerja/" + id);
    $.ajax({
        url: "/admin/master-hasil-kerja/detail/" + id,
        method: "GET",
        success: function (data) {
            $("#editId").val(data.id);
            $("#editMasterUnsurId").select2("trigger", "select", {
                data: { id: data.masterUnsurId, text: data.nama_unsur },
            });
            $("#editMasterSubUnsurId").select2("trigger", "select", {
                data: {
                    id: data.master_subunsur_id,
                    text: data.master_subunsur_id,
                },
            });
            $("#editNamaHasilKerja").val(data.nama_hasil_kerja);
            $("#editHasilKerjaTim").val(data.hasil_kerja_tim);
            if (data.kategori_pelaksana == "gt") {
                $("#editStatus1").prop("checked", true);
            } else {
                $("#editStatus2").prop("checked", true);
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
            if (data.length != 0) {
                var html = "";
                data.forEach((item) => {
                    html += `<option value="${item.id}">${item.nama_sub_unsur}</option>`;
                });
                $("#masterSubUnsurId").html(html);
                $("#subunsur-alert").hide();
            } else {
                $("#subunsur-alert").show();
                // chane small text to "Tidak ada subunsur"
                html = `<small class="text-danger ">*Unsur ini tidak memiliki subunsur</small>`;
                $("#subunsur-alert").html(html);
            }
        },
    });
});
$(document).on("change", "#editMasterUnsurId", function () {
    var id = $(this).val();
    $.ajax({
        url: "/admin/master-subunsur/unsur/" + id,
        method: "GET",
        success: function (data) {
            $("#editMasterSubUnsurId").attr("disabled", false);
            if (data.length != 0) {
                var html = "";
                data.forEach((item) => {
                    html += `<option value="${item.id}">${item.nama_sub_unsur}</option>`;
                });
                $("#editMasterSubUnsurId").html(html);
                $("#subunsur-alert").hide();
            } else {
                $("#subunsur-alert").show();
                // chane small text to "Tidak ada subunsur"
                html = `<small class="text-danger ">*Unsur ini tidak memiliki subunsur</small>`;
                $("#subunsur-alert").html(html);
            }
        },
    });
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

        $(".dt-buttons").appendTo("#download-button");
        $(".dt-buttons").appendTo("#download-button");
        $(".dataTables_filter").appendTo("#filter-search-wrapper");
        $(".dataTables_filter").find("input").addClass("form-control");
        $(".dataTables_filter").css("width", "100%");
        $(".dataTables_filter label").css("width", "100%");
        $(".dataTables_filter input").css("height", "35px");
        $(".dataTables_filter label").css("font-weight", "bold");
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
    if (
        $("#masterUnsurId").val() == "" ||
        $("#masterSubUnsurId").val() == "" ||
        $("#namaHasilKerja").val() == "" ||
        $("#hasilKerjaTim").val() == "" ||
        $("#status").val() == ""
    ) {
        return;
    }
    $(this).attr("disabled", true);
    $(this).closest("form").submit();
});
