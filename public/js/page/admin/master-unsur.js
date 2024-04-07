// function when edit-button class clicked
$(document).on("click", ".edit-button", function () {
    var id = $(this).data("id");
    var nama = $(this).data("nama");
    // change id and namaUnsur input value
    $('input[name="idEdit"]').val(id);
    $('input[name="editNamaUnsur"]').val(nama);
    // change form with id = edit-form to action = /{id}
    $("#edit-form").attr("action", "/admin/master-unsur/" + id);
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
            console.log("#form-" + id);
        }
    });
});

let table = $("#master-unsur")
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
                filename: "Master Unsur",
            },
            {
                extend: "pdf",
                className: "btn-danger",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                filename: "Master Unsur",
            },
        ],
    })
    .api();
