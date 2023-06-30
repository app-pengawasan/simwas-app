let volume = document.getElementById("volume");
let harga = document.getElementById("harga_satuan");
let pagu = document.getElementById("pagu");

let harga_number = Number(harga.value.replace(/[^,\d]/g, ""));
let volume_number = Number(volume.value);
let pagu_number = harga_number * volume_number;

harga.value = formatRupiah(harga_number.toString(), "Rp. ");
pagu.value = formatRupiah(pagu_number.toString(), "Rp. ");

$("#btn-back").on("click", function (e) {
    e.preventDefault();
    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Data pagu anggaran belum tersimpan.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--primary)",
        cancelButtonColor: "var(--danger)",
        confirmButtonText: "Yakin",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "/admin/pagu-anggaran";
        }
    });
});

harga.onload = function (e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    harga.value = formatRupiah(this.value, "Rp. ");

    let harga_number = Number(harga.value.replace(/[^,\d]/g, ""));
    let volume_number = Number(volume.value);
    let pagu_number = harga_number * volume_number;

    return (pagu.value = formatRupiah(pagu_number.toString(), "Rp. "));
};

volume.addEventListener("keyup", function (e) {
    this.value = Number(this.value.replace(/\D/g, ""));

    let harga_number = Number(harga.value.replace(/\D/g, ""));
    let volume_number = Number(volume.value);
    let pagu_number = harga_number * volume_number;

    return (pagu.value = formatRupiah(pagu_number.toString(), "Rp. "));
});

harga.addEventListener("keyup", function (e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    harga.value = formatRupiah(this.value, "Rp. ");

    let harga_number = Number(harga.value.replace(/[^,\d]/g, ""));
    let volume_number = Number(volume.value);
    let pagu_number = harga_number * volume_number;

    return (pagu.value = formatRupiah(pagu_number.toString(), "Rp. "));
});
