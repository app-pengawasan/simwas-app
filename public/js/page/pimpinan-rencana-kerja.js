let table = $("#tim-kerja");

$(function () {
    table
        .DataTable({
            dom: "Bfrtip",
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            buttons: [
                {
                    extend: "excel",
                    className: "btn-success",
                    exportOptions: {
                        columns: [0, 1],
                    },
                },
                {
                    extend: "pdf",
                    className: "btn-danger",
                    exportOptions: {
                        columns: [0, 1],
                    },
                },
            ],
        })
        .buttons()
        .container()
        .appendTo("#master-iku_wrapper .col-md-6:eq(0)");
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
        confirmButtonColor: "#394eea",
        cancelButtonColor: "#fc544b",
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/pegawai/rencana-kinerja/${dataId}`,
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
                        text: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000,
                    });
                    setTimeout(location.reload(), 1000);
                },
                error: function (e) {
                    console.log(e);
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
        confirmButtonColor: "#394eea",
        cancelButtonColor: "#fc544b",
        confirmButtonText: "Kirim",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/pegawai/rencana-kinerja/send/${id_timkerja}`,
                type: "PUT",
                cache: false,
                data: {
                    _token: token,
                    id_timkerja: id_timkerja,
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
                    setTimeout(location.reload(), 1000);
                },
                error: function (e) {
                    console.log(e);
                },
            });
        }
    });
});

$("#btn-pimpinan-submit-rk").on("click", function (e) {
    e.preventDefault();
    let id_timkerja = $("#id_timkerja").val();
    let token = $("meta[name='csrf-token']").attr("content");

    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Rencana Kerja yang telah disetujui tidak dapat diubah kembali!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#394eea",
        cancelButtonColor: "#fc544b",
        confirmButtonText: "Kirim",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/pimpinan/rencana-kinerja/accept/${id_timkerja}`,
                type: "PUT",
                cache: false,
                data: {
                    _token: token,
                    id_timkerja: id_timkerja,
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
                    setTimeout(
                        window.location.href("pimpinan/rencana-kinerja"),
                        1000
                    );
                },
                error: function (e) {
                    console.log(e);
                },
            });
        }
    });
});
$("#btn-pimpinan-send-back").on("click", function (e) {
    e.preventDefault();
    let id_timkerja = $("#id_timkerja").val();
    let token = $("meta[name='csrf-token']").attr("content");

    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Rencana Kerja akan dikembalikan untuk direvisi!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#394eea",
        cancelButtonColor: "#fc544b",
        confirmButtonText: "Kirim",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/pimpinan/rencana-kinerja/return/${id_timkerja}`,
                type: "PUT",
                cache: false,
                data: {
                    _token: token,
                    id_timkerja: id_timkerja,
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
                    setTimeout(
                        window.location.href("pimpinan/rencana-kinerja"),
                        1000
                    );
                },
                error: function (e) {
                    console.log(e);
                },
            });
        }
    });
});

/* Fungsi formatRupiah */
function formatRupiah(angka, prefix) {
    let number_string = angka.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
}

// Taruh dipaling bawah, Soalnya nanti ngaruh ke function yang laen
let rupiah = document.getElementsByClassName("rupiah");
for (i = 0; i <= rupiah.length; i++) {
    let tmp = rupiah[i].outerHTML.toString();
    rupiah[i].innerText = formatRupiah(tmp, "Rp. ");
}
