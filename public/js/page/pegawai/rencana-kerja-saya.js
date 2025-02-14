let table = $("#tim-kerja").DataTable({
    dom: "Bfrtip",
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    pageLength: 25,
    buttons: [
        {
            extend: "excel",
            className: "btn-success unduh",
            text: '<i class="fas fa-file-excel"></i> Excel',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5],
            },
        },
        {
            extend: "pdf",
            className: "btn-danger unduh",
            text: '<i class="fas fa-file-pdf"></i> PDF',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5],
            },
        },
        {
            text: "Jam Kerja",
            className: "btn btn-primary disabled jam-kerja toggle",
        },
        {
            text: "Hari Kerja",
            className: "btn btn-primary hari-kerja toggle",
        },
    ],
});

$('#tim-kerja_wrapper .dt-buttons').removeClass('btn-group').addClass('mb-4');

$('.unduh').wrapAll('<div class="btn-group"></div>');
$('.toggle').wrapAll('<div class="btn-group" style="float: right"></div>');

$('.hari-kerja').on('click', function() {
    $(this).addClass('disabled');
    $(this).attr('disabled', true);
    $(".jam-kerja").removeClass('disabled');
    $(".jam-kerja").attr('disabled', false);
    table.cells('.convert').every(function () {
        if (this.data() != '0') this.data(($(this.node()).attr('value') / 7.5).toFixed(2))
    });
    $('#title').text('Rencana Hari Kerja');
});

$('.jam-kerja').on('click', function() {
    $(this).addClass('disabled');
    $(this).attr('disabled', true);
    $(".hari-kerja").removeClass('disabled');
    $(".hari-kerja").attr('disabled', false);
    table.cells('.convert').every(function () {
        if (this.data() != '0') this.data($(this.node()).attr('value'))
    });
    $('#title').text('Rencana Jam Kerja');
});

let today = new Date();
$('#filterTahun').val(today.getFullYear());

$('#filterTahun').on("change", function () {
    table.draw();
});

$.fn.dataTableExt.afnFiltering.push(
    function (setting, data, index) {
        var selectedTahun = $('select#filterTahun option:selected').val();
        if (data[7] == selectedTahun) return true;
        else return false;
    }
);

table.draw();

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
                },
            });
        }
    });
});
