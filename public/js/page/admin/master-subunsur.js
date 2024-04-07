// function when edit-button class clicked
$(document).on("click", ".edit-button", function () {
    var id = $(this).data("id");
    var nama = $(this).data("nama");
    var idUnsur = $(this).data("id-unsur");
    $('input[name="editId"]').val(id);
    $('input[name="editNamaSubUnsur"]').val(nama);
    $("#editMasterUnsurId").val(idUnsur);
    $("#edit-form").attr("action", "/admin/master-subunsur/" + id);
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


let table = $("#master-subunsur")
    .dataTable({
        dom: "Bfrtip",
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        // filter: false,
        buttons: [
            {
                extend: "excel",
                className: "btn-success",
                text: '<i class="fas fa-file-excel"></i> Excel',
                filename: "Master Subunsur",
            },
            {
                extend: "pdf",
                className: "btn-danger",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                filename: "Master Subunsur",
            },
        ],
    })
    .api();
