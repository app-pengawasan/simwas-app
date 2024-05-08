var stepper1Node = document.querySelector("#stepper1");
var stepper1 = new Stepper(document.querySelector("#stepper1"));

// stepper1Node.addEventListener("show.bs-stepper", function (event) {
//     console.warn("show.bs-stepper", event);
// });
// stepper1Node.addEventListener("shown.bs-stepper", function (event) {
//     console.warn("shown.bs-stepper", event);
// });

// change input filename to file upload name
$('input[type="file"]').change(function (e) {
    var fileName = e.target.files[0].name;
    $(".custom-file-label").html(fileName);
});

// disable next button if there are empty input

// disabled on next button if there are empty input with id next-form
// listen all input and change button state
var form = document.querySelector("#test-l-1");
var nextForm = document.querySelector("#next-form");
var inputs = form.querySelectorAll("input, select");
inputs.forEach((input) => {
    input.addEventListener("change", function () {
        var disabled = false;
        inputs.forEach((input) => {
            if (input.value === "" || input.value === null) {
                disabled = true;
            }
        });
        if (!disabled) {
            nextForm.onclick = function () {
                stepper1.next();
            };
        }
    });
});

// onchange input select #jenisNaskahDinas
$("#jenisNaskahDinas").change(function () {
    var value = $(this).val();
    if (value === "1031") {
        $("#jenisNaskahDinasPenugasanWrapper").removeClass("d-none");
        $("#jenisNaskahDinasPenugasan").attr("required", "required");
        $("#kegiatanWrapper").removeClass("d-none");
        $("#kegiatan").attr("required", "required");
        $("#melaksanakanWrapper").removeClass("d-none");
        $("#melaksanakan").attr("required", "required");
        $("#jenisNaskahDinasKorespondensiWrapper").addClass("d-none");
        $("#jenisNaskahDinasKorespondensi").removeAttr("required");
        // disable jenisNaskahDinasKorespondensi
        $("#jenisNaskahDinasKorespondensi").val("");
        $("#perihalWrapper").addClass("d-none");
        $("#perihal").removeAttr("required");
        $("#perihal").val("");
        // hide file upload wrapper
        $("#file-upload-wrapper").addClass("d-none");
        // remove required in customFile
        $("#customFile").removeAttr("required");

        $("#surat-tugas-wrapper").removeClass("d-none");
        // add required in rencana_id, menimbang, mengingat, untuk
        $("#rencana_id").attr("required", "required");
        $("#menimbang").attr("required", "required");
        $("#mengingat").attr("required", "required");
        $("#untuk").attr("required", "required");
    } else if (value === "1032") {
        $("#jenisNaskahDinasPenugasanWrapper").addClass("d-none");
        $("#jenisNaskahDinasPenugasan").removeAttr("required");
        $("#jenisNaskahDinasPenugasan").val("");
        $("#kegiatanWrapper").addClass("d-none");
        $("#kegiatan").removeAttr("required");
        $("#kegiatan").val("");
        $("#melaksanakanWrapper").addClass("d-none");
        $("#melaksanakan").removeAttr("required");
        $("#melaksanakan").val("");
        $("#jenisNaskahDinasKorespondensiWrapper").removeClass("d-none");
        $("#jenisNaskahDinasKorespondensi").attr("required", "required");
        $("#perihalWrapper").removeClass("d-none");
        $("#perihal").attr("required", "required");
        $("#unsurTugasWrapper").addClass("d-none");
        $("#unsurTugas").removeAttr("required");
        $("#unsurTugas").val("");
        $("#kegiatanPengawasanWrapper").addClass("d-none");
        $("#kegiatanPengawasan").removeAttr("required");
        $("#kegiatanPengawasan").val("");
        $("#unsurTugasWrapper").addClass("d-none");
        $("#unsurTugas").removeAttr("required");
        $("#unsurTugas").val("");
        $("#kegiatanPengawasanWrapper").addClass("d-none");
        $("#kegiatanPengawasan").removeAttr("required");
        $("#kegiatanPengawasan").val("");
        $("#pendukungPengawasanWrapper").addClass("d-none");
        $("#pendukungPengawasan").removeAttr("required");
        $("#pendukungPengawasan").val("");
        $("#surat-tugas-wrapper").addClass("d-none");
        // remove required in rencana_id, menimbang, mengingat, untuk
        $("#rencana_id").removeAttr("required");
        // val empty
        $("#rencana_id").val("");
        $("#menimbang").removeAttr("required");
        $("#menimbang").val("");
        $("#mengingat").removeAttr("required");
        $("#mengingat").val("");
        $("#untuk").removeAttr("required");
        $("#untuk").val("");

        // show file upload wrapper
        $("#file-upload-wrapper").removeClass("d-none");
        // add required in customFile
        $("#customFile").attr("required", "required");
        // change
    }
});

$("#kegiatan").change(function () {
    var value = $(this).val();
    if (value === "1") {
        $("#unsurTugasWrapper").removeClass("d-none");
        $("#unsurTugas").attr("required", "required");
        $("#kegiatanPengawasanWrapper").removeClass("d-none");
        $("#kegiatanPengawasan").attr("required", "required");
    } else if (value === "2") {
        $("#unsurTugasWrapper").addClass("d-none");
        $("#unsurTugas").removeAttr("required");
        $("#unsurTugas").val("");
        $("#kegiatanPengawasanWrapper").addClass("d-none");
        $("#kegiatanPengawasan").removeAttr("required");
        $("#kegiatanPengawasan").val("");
        $("#pendukungPengawasanWrapper").removeClass("d-none");
        $("#pendukungPengawasan").attr("required", "required");
    } else {
        $("#unsurTugasWrapper").addClass("d-none");
        $("#unsurTugas").removeAttr("required");
        $("#unsurTugas").val("");
        $("#kegiatanPengawasanWrapper").addClass("d-none");
        $("#kegiatanPengawasan").removeAttr("required");
        $("#kegiatanPengawasan").val("");
        $("#pendukungPengawasanWrapper").addClass("d-none");
        $("#pendukungPengawasan").removeAttr("required");
        $("#pendukungPengawasan").val("");
    }
});

$("#rencana_id").change(function () {
    var selectedRencanaKerja = $(this).val();
    $.ajax({
        url: "/tugas",
        method: "GET",
        data: {
            rencana_id: selectedRencanaKerja,
        },
        success: function (response) {
            var timKerja = response.tim_kerja;
            var objekPengawasan = response.objek_pengawasan;

            var objek = [];
            var counter = 0;
            objekPengawasan.forEach((element) => {
                counter++;
                objek.push(counter + ". " + element.nama);
            });
            var objekJoined = objek.join("\n");

            var pelaksanaTugas = [];
            var dalnis = response.dalnis;
            var ketua = response.ketua;
            var pic = response.pic;
            var anggota = response.anggota;
            if (dalnis !== "") {
                pelaksanaTugas.push(dalnis);
            }
            if (ketua !== "") {
                pelaksanaTugas.push(ketua);
            }
            if (pic !== 0) {
                pelaksanaTugas.push(pic);
            }
            if (anggota !== 0) {
                pelaksanaTugas = pelaksanaTugas.concat(anggota);
            }
            // add pelaksana tugas to li in ul pelaksana-tugas
            $("#pelaksana-tugas").empty();
            pelaksanaTugas.forEach((element) => {
                $("#pelaksana-tugas").append(
                    "<li class='list-group-item'>" + element + "</li>"
                );
            });

            $("#tim_kerja").val(timKerja.nama);
            // add li

            // $("#unit_kerja").val(timKerja.unitkerja);
            // $("#unit_kerja").select2("destroy");
            // $("#unit_kerja").select2();
            // $("#unit_kerja1").val(timKerja.unitkerja);

            // $("#objek").val(objekJoined);
            // $("#objek1").val(objekJoined);

            // $("#pelaksana").val(pelaksanaTugas);
            // $("#pelaksana1").val(pelaksanaTugas);
        },
    });
});
