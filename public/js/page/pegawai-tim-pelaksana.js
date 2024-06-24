// Tambah Objek Pengawasan
$("#btn-create-objek").on("click", function (e) {
    $("#error-kategori_objek").text("");
    $("#error-objek").text("");
});

$("#create-okategori").on("change", function (e) {
    e.preventDefault();
    let kategoriObjek = $("#create-okategori option:selected").val();
    $.ajax({
        url: `/objek-bykategori/${kategoriObjek}`,
        method: "GET",
        cache: false,
        success: function (response) {
            let objek = response.data;

            $("#create-objek").removeAttr("disabled");
            $("#create-objek").empty();

            objek.forEach((element) => {
                $("#create-objek").append(
                    `<option value="${element.id_objek}" >${element.nama}</option>`
                );
            });
        },
        error: function (e) {
            console.log(e);
        },
    });
});

$("#btn-submit-objek").on("click", function (e) {
    e.preventDefault();
    let token = $("meta[name='csrf-token']").attr("content");
    let id_rencanakerja = $("#id_rencanakerja").val();
    let kategori = $("#create-okategori option:selected").val();
    let id_objek = $("#create-objek option:selected").val();
    let nama = $("#create-objek option:selected").text();

    $("#error-kategori").text("");
    $("#error-objek").text("");

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
        url: `/objek-pengawasan`,
        type: "POST",
        cache: false,
        data: {
            _token: token,
            kategori_objek: kategori,
            id_rencanakerja: id_rencanakerja,
            objek: id_objek,
            nama: nama,
        },
        success: function (response) {
            location.reload();
        },
        error: function (error) {
            console.log(error);
            let errorResponses = error.responseJSON;
            let errors = Object.entries(errorResponses.errors);

            errors.forEach(([key, value]) => {
                let errorMessage = document.getElementById(`error-${key}`);
                errorMessage.innerText = `${value}`;
            });
            Swal.close();
        },
    });
});

// Delete Objek Pengawasan
$(".btn-delete-objek").on("click", function (e) {
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
                url: `/objek-pengawasan/${dataId}`,
                type: "DELETE",
                cache: false,
                data: {
                    _token: token,
                },
                success: function (response) {
                    location.reload();
                },
                error: function (e) {
                    console.log(e);
                },
            });
            console.log(dataId);
        }
    });
});

// Edit Objek
$(".btn-edit-objek").on("click", function (e) {
    let id = $(this).data("id");
    let kategori = $(this).data("kategori");
    let idobjek = $(this).data("idobjek");

    $("#id_opengawasan").val(id);
    $("#edit-okategori").val(kategori);

    console.log([id, kategori, idobjek]);
    $.ajax({
        url: `/objek-bykategori/${kategori}`,
        method: "GET",
        cache: false,
        success: function (response) {
            let objek = response.data;
            let objekDropdown = `<select id="edit-objek" class="form-control" name="create-objek">`;

            objek.forEach((element) => {
                objekDropdown += `
                    <option value="${element.id_objek}" >${element.nama}</option>
                `;
            });
            objekDropdown += `</select>`;

            $("#edit-objek").replaceWith(objekDropdown);
            $("#edit-objek").val(idobjek);
        },
        error: function (e) {
            console.log(e);
        },
    });
});

$("#edit-okategori").on("change", function (e) {
    e.preventDefault();
    let kategoriObjek = $("#edit-okategori option:selected").val();
    $.ajax({
        url: `/objek-bykategori/${kategoriObjek}`,
        method: "GET",
        cache: false,
        success: function (response) {
            let objek = response.data;

            $("#edit-objek").empty();

            objek.forEach((element) => {
                $("#edit-objek").append(
                    `<option value="${element.id_objek}" >${element.nama}</option>`
                );
            });
        },
        error: function (e) {
            console.log(e);
        },
    });
});

$("#btn-submit-edit-objek").on("click", function (e) {
    e.preventDefault();
    let token = $("meta[name='csrf-token']").attr("content");
    let id_opengawasan = $("#id_opengawasan").val();
    let kategori = $("#edit-okategori option:selected").val();
    let id_objek = $("#edit-objek option:selected").val();
    let nama = $("#edit-objek option:selected").text();

    $.ajax({
        url: `/objek-pengawasan/${id_opengawasan}}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            id_opengawasan: id_opengawasan,
            kategori_objek: kategori,
            objek: id_objek,
            nama: nama,
        },
        success: function (response) {
            location.reload();
        },
        error: function (error) {
            console.log(error);
            let errorResponses = error.responseJSON;
            let errors = Object.entries(errorResponses.errors);

            errors.forEach(([key, value]) => {
                let errorMessage = document.getElementById(`error-edit${key}`);
                errorMessage.innerText = `${value}`;
            });
        },
    });
});

// Tambah Anggaran
let volume = document.getElementById("volume");
let harga = document.getElementById("harga_satuan");
let total = document.getElementById("total");
let e_volume = document.getElementById("edit-volume");
let e_harga = document.getElementById("edit-harga_satuan");
let e_total = document.getElementById("edit-total");

//Formating Rupiah
volume.addEventListener("keyup", function (e) {
    this.value = Number(this.value.replace(/\D/g, ""));

    let harga_number = Number(harga.value.replace(/\D/g, ""));
    let volume_number = Number(volume.value);
    let total_number = harga_number * volume_number;

    return (total.value = formatRupiah(total_number.toString(), "Rp. "));
});

harga.addEventListener("keyup", function (e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    harga.value = formatRupiah(this.value, "Rp. ");

    let harga_number = Number(harga.value.replace(/\D/g, ""));
    let volume_number = Number(volume.value);
    let total_number = harga_number * volume_number;

    return (total.value = formatRupiah(total_number.toString(), "Rp. "));
});

harga.onload = function (e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    harga.value = formatRupiah(this.value, "Rp. ");

    let harga_number = Number(harga.value.replace(/\D/g, ""));
    let volume_number = Number(volume.value);
    let total_number = harga_number * volume_number;

    return (total.value = formatRupiah(total_number.toString(), "Rp. "));
};

e_volume.addEventListener("keyup", function (e) {
    this.value = Number(this.value.replace(/\D/g, ""));
    let harga_number = Number(e_harga.value.replace(/\D/g, ""));
    let volume_number = Number(e_volume.value);
    let total_number = harga_number * volume_number;

    return (e_total.value = formatRupiah(total_number.toString(), "Rp. "));
});

e_harga.addEventListener("keyup", function (e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    e_harga.value = formatRupiah(this.value, "Rp. ");

    let harga_number = Number(e_harga.value.replace(/\D/g, ""));
    let volume_number = Number(e_volume.value);
    let total_number = harga_number * volume_number;

    return (e_total.value = formatRupiah(total_number.toString(), "Rp. "));
});

/* Fungsi formatRupiah */
function formatRupiah(angka, prefix) {
    let number_string = angka.replace(/\D/g, "").toString(),
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

$("#btn-submit-anggaran").on("click", function (e) {
    e.preventDefault();
    let token = $("meta[name='csrf-token']").attr("content");
    let id_rencanakerja = $("#id_rencanakerja").val();
    let uraian = $("#uraian").val();
    let volume = $("#volume").val();
    let satuan = $("#satuan option:selected").val();
    let harga = $("#harga_satuan").val();
    let total = $("#total").val();

    $("#error-uraian").text("");
    $("#error-volume").text("");
    $("#error-satuan").text("");
    $("#error-harga").text("");
    $("#error-total").text("");

    // disable submit button
    $("#btn-submit-anggaran").prop("disabled", true);

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
        url: `/anggaran-rencana-kerja`,
        type: "POST",
        cache: false,
        data: {
            _token: token,
            id_rencanakerja: id_rencanakerja,
            uraian: uraian,
            volume: volume,
            satuan: satuan,
            harga: harga,
            total: total,
        },
        success: function (response) {
            location.reload();
        },
        error: function (error) {
            $("#btn-submit-anggaran").prop("disabled", false);
            Swal.fire({
                title: "Gagal!",
                text: "Silakan isi form dengan benar",
                icon: "error",
                confirmButtonColor: "var(--primary)",
            });

            let errorResponses = error.responseJSON;
            let errors = Object.entries(errorResponses.errors);

            errors.forEach(([key, value]) => {
                let errorMessage = document.getElementById(`error-${key}`);
                errorMessage.innerText = `${value}`;
            });
            Swal.close();
        },
    });
});

$(".btn-edit-anggaran").on("click", function (e) {
    let id = $(this).data("id");
    $("#error-edit-uraian").text("");
    $("#error-edit-volume").text("");
    $("#error-edit-satuan").text("");
    $("#error-edit-harga").text("");
    $("#error-edit-total").text("");
    $.ajax({
        url: `/anggaran-rencana-kerja/${id}`,
        method: "GET",
        cache: false,
        success: function (response) {
            console.log(response.data);
            $("#id_rkanggaran").val(response.data.id_rkanggaran);
            $("#edit-uraian").val(response.data.uraian);
            $("#edit-volume").val(response.data.volume);
            $("#edit-satuan").val(response.data.satuan);
            $("#edit-harga_satuan").val(
                formatRupiah(response.data.harga.toString(), "Rp. ")
            );
            $("#edit-total").val(
                formatRupiah(response.data.total.toString(), "Rp. ")
            );
        },
        error: function (e) {
            console.log(e);
        },
    });
});

$("#btn-submit-edit-anggaran").on("click", function (e) {
    e.preventDefault();
    let token = $("meta[name='csrf-token']").attr("content");
    let id_rkanggaran = $("#id_rkanggaran").val();
    let uraian = $("#edit-uraian").val();
    let volume = $("#edit-volume").val();
    let satuan = $("#edit-satuan option:selected").val();
    let harga = $("#edit-harga_satuan").val();
    let total = $("#edit-total").val();

    $("#error-edit-uraian").text("");
    $("#error-edit-volume").text("");
    $("#error-edit-satuan").text("");
    $("#error-edit-harga").text("");
    $("#error-edit-total").text("");

    $.ajax({
        url: `/anggaran-rencana-kerja/${id_rkanggaran}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            id_rkanggaran: id_rkanggaran,
            uraian: uraian,
            volume: volume,
            satuan: satuan,
            harga: harga,
            total: total,
        },
        success: function (response) {
            location.reload();
        },
        error: function (error) {
            let errorResponses = error.responseJSON;
            console.log(errorResponses);
            let errors = Object.entries(errorResponses.errors);

            errors.forEach(([key, value]) => {
                let errorMessage = document.getElementById(`error-edit-${key}`);
                console.log(errorMessage);
                errorMessage.innerText = `${value}`;
            });
        },
    });
});

//Delete Anggaran
$(".btn-delete-anggaran").on("click", function (e) {
    e.preventDefault();
    let dataId = $(this).attr("data-id");
    let token = $("meta[name='csrf-token']").attr("content");
    console.log("test");

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
                url: `/anggaran-rencana-kerja/${dataId}`,
                type: "DELETE",
                cache: false,
                data: {
                    _token: token,
                },
                success: function (response) {
                    location.reload();
                },
            });
        }
    });
});

// Tambah Pelaksana
$(".btn-create-pelaksana").on("click", function (e) {
    e.preventDefault();
    let isDisable = $(this).data("disable");
    let datahasilKerja = $(this).data("hasilkerja");
    let dataJabatan = $(this).data("jabatan");
    let jabatan = $("#pt-jabatan");
    let hasilkerja = $("#pt-hasil");

    $("#error-hasil_kerja").text("");
    $("#error-pelaksana").text("");

    jabatan.val(dataJabatan);
    hasilkerja.val(datahasilKerja);

    if (!isDisable && dataJabatan != 4) {
        hasilkerja.prop("disabled", false);
    }
});

$("#btn-submit-pelaksana").on("click", function (e) {
    e.preventDefault();
    let token = $("meta[name='csrf-token']").attr("content");
    let id_rencanakerja = $("#id_rencanakerja").val();
    let jabatan = $("#pt-jabatan").val();
    let pelaksana = $("#pelaksana").val();
    let jan = $("#create-januari").val();
    let feb = $("#create-februari").val();
    let mar = $("#create-maret").val();
    let apr = $("#create-april").val();
    let mei = $("#create-mei").val();
    let jun = $("#create-juni").val();
    let jul = $("#create-juli").val();
    let agu = $("#create-agustus").val();
    let sep = $("#create-september").val();
    let okt = $("#create-oktober").val();
    let nov = $("#create-november").val();
    let des = $("#create-desember").val();
    // if jan - des == null, set to 0
    jan = jan == "" ? 0 : jan;
    feb = feb == "" ? 0 : feb;
    mar = mar == "" ? 0 : mar;
    apr = apr == "" ? 0 : apr;
    mei = mei == "" ? 0 : mei;
    jun = jun == "" ? 0 : jun;
    jul = jul == "" ? 0 : jul;
    agu = agu == "" ? 0 : agu;
    sep = sep == "" ? 0 : sep;
    okt = okt == "" ? 0 : okt;
    nov = nov == "" ? 0 : nov;
    des = des == "" ? 0 : des;

    // replace , to .
    if (jan) {
        jan = jan.replace(/,/g, ".");
    }
    if (feb) {
        feb = feb.replace(/,/g, ".");
    }
    if (mar) {
        mar = mar.replace(/,/g, ".");
    }
    if (apr) {
        apr = apr.replace(/,/g, ".");
    }
    if (mei) {
        mei = mei.replace(/,/g, ".");
    }
    if (jun) {
        jun = jun.replace(/,/g, ".");
    }
    if (jul) {
        jul = jul.replace(/,/g, ".");
    }
    if (agu) {
        agu = agu.replace(/,/g, ".");
    }
    if (sep) {
        sep = sep.replace(/,/g, ".");
    }
    if (okt) {
        okt = okt.replace(/,/g, ".");
    }
    if (nov) {
        nov = nov.replace(/,/g, ".");
    }
    if (des) {
        des = des.replace(/,/g, ".");
    }


    // if jan - des < 0 or > 200, return error
    if (jan < 0 || jan > 200) {
        $("#error-januari").text("0 - 200 Jam Kerja");
        return;
    }
    if (feb < 0 || feb > 200) {
        $("#error-februari").text("0 - 200 Jam Kerja");
        return;
    }
    if (mar < 0 || mar > 200) {
        $("#error-maret").text("0 - 200 Jam Kerja");
        return;
    }
    if (apr < 0 || apr > 200) {
        $("#error-april").text("0 - 200 Jam Kerja");
        return;
    }
    if (mei < 0 || mei > 200) {
        $("#error-mei").text("0 - 200 Jam Kerja");
        return;
    }
    if (jun < 0 || jun > 200) {
        $("#error-juni").text("0 - 200 Jam Kerja");
        return;
    }
    if (jul < 0 || jul > 200) {
        $("#error-juli").text("0 - 200 Jam Kerja");
        return;
    }
    if (agu < 0 || agu > 200) {
        $("#error-agustus").text("0 - 200 Jam Kerja");
        return;
    }
    if (sep < 0 || sep > 200) {
        $("#error-september").text("0 - 200 Jam Kerja");
        return;
    }
    if (okt < 0 || okt > 200) {
        $("#error-oktober").text("0 - 200 Jam Kerja");
        return;
    }
    if (nov < 0 || nov > 200) {
        $("#error-november").text("0 - 200 Jam Kerja");
        return;
    }
    if (des < 0 || des > 200) {
        $("#error-desember").text("0 - 200 Jam Kerja");
        return;
    }

    $("#error-pelaksana").text("");

    if(pelaksana == null || pelaksana == ""){
        $("#error-pelaksana").text("Pilih Pelaksana");
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
        url: `/pelaksana-tugas`,
        type: "POST",
        cache: false,
        data: {
            _token: token,
            id_rencanakerja: id_rencanakerja,
            pt_jabatan: jabatan,
            pelaksana: pelaksana,
            jan: jan,
            feb: feb,
            mar: mar,
            apr: apr,
            mei: mei,
            jun: jun,
            jul: jul,
            agu: agu,
            sep: sep,
            okt: okt,
            nov: nov,
            des: des,
        },
        success: function (response) {
            location.reload();
        },
        error: function (error) {
            Swal.fire({
                title: "Gagal!",
                text: "Silakan isi form dengan benar",
                icon: "error",
                confirmButtonColor: "var(--primary)",
            });

        },
    });
});

// Delete Pelaksana
$(".btn-delete-pelaksana").on("click", function (e) {
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
                url: `/pelaksana-tugas/${dataId}`,
                type: "DELETE",
                cache: false,
                data: {
                    _token: token,
                },
                success: function (response) {
                    location.reload();
                },
            });
        }
    });
});

// Edit Pelaksana
$(".btn-edit-pelaksana").on("click", function (e) {
    e.preventDefault();
    let isDisable = $(this).data("disable");
    let id = $(this).data("id");
    let hasilkerja = $("#edit-pt-hasil");
    $("#error-edit-hasil_kerja").text("");
    $("#error-edit-pelaksana").text("");

    if (!isDisable) {
        hasilkerja.prop("disabled", false);
    }

    $.ajax({
        url: `/pelaksana-tugas/${id}`,
        method: "GET",
        cache: false,
        success: function (response) {
            $("#edit-pt-jabatan").val(response.data.pt_jabatan);
            $("#edit-pt-hasil").val(response.data.pt_hasil);
            $("#edit-pelaksana").select2("trigger", "select", {
                data: {
                    id: response.data.id_pegawai,
                    text: response.data.id_pegawai,
                },
            });
            $("#edit-id_pelaksana").val(response.data.id_pelaksana);
            $("#edit-januari").val(response.data.jan.replace(".", ","));
            $("#edit-februari").val(response.data.feb.replace(".", ","));
            $("#edit-maret").val(response.data.mar.replace(".", ","));
            $("#edit-april").val(response.data.apr.replace(".", ","));
            $("#edit-mei").val(response.data.mei.replace(".", ","));
            $("#edit-juni").val(response.data.jun.replace(".", ","));
            $("#edit-juli").val(response.data.jul.replace(".", ","));
            $("#edit-agustus").val(response.data.agu.replace(".", ","));
            $("#edit-september").val(response.data.sep.replace(".", ","));
            $("#edit-oktober").val(response.data.okt.replace(".", ","));
            $("#edit-november").val(response.data.nov.replace(".", ","));
            $("#edit-desember").val(response.data.des.replace(".", ","));
        },
        error: function (e) {
            console.log(e);
        },
    });
});

$("#btn-edit-pelaksana").on("click", function (e) {
    e.preventDefault();
    let token = $("meta[name='csrf-token']").attr("content");
    let id_pelaksana = $("#edit-id_pelaksana").val();
    let jabatan = $("#edit-pt-jabatan").val();
    let hasil_kerja = $("#edit-pt-hasil").val();
    let pelaksana = $("#edit-pelaksana").val();
    let jan = $("#edit-januari").val();
    let feb = $("#edit-februari").val();
    let mar = $("#edit-maret").val();
    let apr = $("#edit-april").val();
    let mei = $("#edit-mei").val();
    let jun = $("#edit-juni").val();
    let jul = $("#edit-juli").val();
    let agu = $("#edit-agustus").val();
    let sep = $("#edit-september").val();
    let okt = $("#edit-oktober").val();
    let nov = $("#edit-november").val();
    let des = $("#edit-desember").val();

    jan = jan == "" ? 0 : jan;
    feb = feb == "" ? 0 : feb;
    mar = mar == "" ? 0 : mar;
    apr = apr == "" ? 0 : apr;
    mei = mei == "" ? 0 : mei;
    jun = jun == "" ? 0 : jun;
    jul = jul == "" ? 0 : jul;
    agu = agu == "" ? 0 : agu;
    sep = sep == "" ? 0 : sep;
    okt = okt == "" ? 0 : okt;
    nov = nov == "" ? 0 : nov;
    des = des == "" ? 0 : des;

    // replace , to . if exist
    if (jan) {
        jan = jan.replace(/,/g, ".");
    }
    if (feb) {
        feb = feb.replace(/,/g, ".");
    }
    if (mar) {
        mar = mar.replace(/,/g, ".");
    }
    if (apr) {
        apr = apr.replace(/,/g, ".");
    }
    if (mei) {
        mei = mei.replace(/,/g, ".");
    }
    if (jun) {
        jun = jun.replace(/,/g, ".");
    }
    if (jul) {
        jul = jul.replace(/,/g, ".");
    }
    if (agu) {
        agu = agu.replace(/,/g, ".");
    }
    if (sep) {
        sep = sep.replace(/,/g, ".");
    }
    if (okt) {
        okt = okt.replace(/,/g, ".");
    }
    if (nov) {
        nov = nov.replace(/,/g, ".");
    }
    if (des) {
        des = des.replace(/,/g, ".");
    }


    // if jan - des < 0 or > 200, return error
    if (jan < 0 || jan > 200) {
        $("#error-edit-januari").text("0 - 200 Jam Kerja");
        return;
    }
    if (feb < 0 || feb > 200) {
        $("#error-edit-februari").text("0 - 200 Jam Kerja");
        return;
    }
    if (mar < 0 || mar > 200) {
        $("#error-edit-maret").text("0 - 200 Jam Kerja");
        return;
    }
    if (apr < 0 || apr > 200) {
        $("#error-edit-april").text("0 - 200 Jam Kerja");
        return;
    }
    if (mei < 0 || mei > 200) {
        $("#error-edit-mei").text("0 - 200 Jam Kerja");
        return;
    }
    if (jun < 0 || jun > 200) {
        $("#error-edit-juni").text("0 - 200 Jam Kerja");
        return;
    }
    if (jul < 0 || jul > 200) {
        $("#error-edit-juli").text("0 - 200 Jam Kerja");
        return;
    }
    if (agu < 0 || agu > 200) {
        $("#error-edit-agustus").text("0 - 200 Jam Kerja");
        return;
    }
    if (sep < 0 || sep > 200) {
        $("#error-edit-september").text("0 - 200 Jam Kerja");
        return;
    }
    if (okt < 0 || okt > 200) {
        $("#error-edit-oktober").text("0 - 200 Jam Kerja");
        return;
    }
    if (nov < 0 || nov > 200) {
        $("#error-edit-november").text("0 - 200 Jam Kerja");
        return;
    }
    if (des < 0 || des > 200) {
        $("#error-edit-desember").text("0 - 200 Jam Kerja");
        return;
    }

    $("#error-hasil_kerja").text("");
    $("#error-pelaksana").text("");

    $.ajax({
        url: `/pelaksana-tugas/${id_pelaksana}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            id_pelaksana: id_pelaksana,
            pt_jabatan: jabatan,
            hasil_kerja: hasil_kerja,
            pelaksana: pelaksana,
            jan: jan,
            feb: feb,
            mar: mar,
            apr: apr,
            mei: mei,
            jun: jun,
            jul: jul,
            agu: agu,
            sep: sep,
            okt: okt,
            nov: nov,
            des: des,
        },
        success: function (response) {
            location.reload();
        },
        error: function (error) {
            console.log(error);
            let errorResponses = error.responseJSON;
            let errors = Object.entries(errorResponses.errors);

            errors.forEach(([key, value]) => {
                let errorMessage = document.getElementById(`error-edit-${key}`);
                errorMessage.innerText = `${value}`;
            });
        },
    });
});

// Taruh dipaling bawah, Soalnya nanti ngaruh ke function yang laen
let rupiah = document.getElementsByClassName("rupiah");
for (i = 0; i <= rupiah.length - 1; i++) {
    console.log(rupiah[i]);
    let tmp = rupiah[i].innerText.toString();
    rupiah[i].innerText = formatRupiah(tmp, "Rp. ");
}

$(".jam-kerja").on("keyup", function (e) {
    // just allow number and ,0 or ,5
    this.value = this.value.replace(/[^0-9,]/g, "");
    this.value = this.value.replace(/,+/g, ",");
    // just allow 0 or 5 after comma
    this.value = this.value.replace(/,[^0,5]/g, "");



});

// after document ready change . to , in jam-kerja class
$(document).ready(function () {
    $(".total-jam").each(function () {
        let value = $(this).text();
        value = value.replace(/\./g, ",");
        $(this).text(value);
    });
});
