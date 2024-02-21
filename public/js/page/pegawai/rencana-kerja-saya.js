let table = $("#tim-kerja");

table
    .DataTable({
        dom: "Bfrtip",
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        buttons: [
            {
                extend: "excel",
                className: "btn-success unduh",
                text: '<i class="fas fa-file-excel"></i> Excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6],
                },
            },
            {
                extend: "pdf",
                className: "btn-danger unduh",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6],
                },
            },
            {
                text: 'Jam Kerja',
                className: 'btn btn-primary disabled jam-kerja toggle',
            },
            {
                text: 'Hari Kerja',
                className: 'btn btn-primary hari-kerja toggle',
            }
        ],
    })

$('#tim-kerja_wrapper .dt-buttons').removeClass('btn-group').addClass('mb-4');

$('.unduh').wrapAll('<div class="btn-group"></div>');
$('.toggle').wrapAll('<div class="btn-group" style="float: right"></div>');

$('.hari-kerja').on('click', function() {
    $(this).addClass('disabled');
    $(".jam-kerja").removeClass('disabled');
    $(".convert").each(function() {
        $(this).text( (Number($(this).text()) / 7.5).toFixed(2) );
    });
    $('#title').text('Rencana Hari Kerja');
});

$('.jam-kerja').on('click', function() {
    $(this).addClass('disabled');
    $(".hari-kerja").removeClass('disabled');
    $(".convert").each(function() {
        $(this).text($(this).attr('value'));
    });
    $('#title').text('Rencana Jam Kerja');
});

$(".disable-btn").on("click", function (e) {
    e.preventDefault();
    let dataId = $(this).attr("data-id");
    let token = $("meta[name='csrf-token']").attr("content");

    Swal.fire({
        title: "Apakah Anda Yakin Menonaktfikan Tugas?",
        text: "Data tidak dapat dipulihkan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--primary)",
        cancelButtonColor: "var(--danger)",
        confirmButtonText: "Nonaktifkan",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/ketua-tim/rencana-kinerja/disable/${dataId}`,
                type: "PUT",
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
                    setTimeout(location.reload(), 3000);
                },
                error: function (e) {
                    console.log(e);
                },
            });
        }
    });
});
