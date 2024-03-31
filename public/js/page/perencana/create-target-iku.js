$(document).ready(function () {
    // $(function () {
    //     $("select").selectpicker();
    // });
    // $("select").selectpicker();
    // $(".satuan").select2({
    //     placeholder: "Select a state",
    //     allowClear: true,
    // });
    calculateTotal();
    localStorage.setItem("mini-sidebar", "true");
    // Add Objek

    $("#add-objek").on("click", function () {
        console.log("add objek");

        var jumlahObjek = $("#jumlah-objek").val();
        // if jumlah objek is empty set to 1
        if (jumlahObjek === "") {
            jumlahObjek = 1;
        }
        var table = $("table tbody");
        for (var i = 1; i <= jumlahObjek; i++) {
            $("#satuan-row" + i).select2("destroy");
        }

        // add row to table
        for (var i = 0; i < jumlahObjek; i++) {
            console.log(i);
            row = parseInt(jumlahObjek) + 1;
            var html = "";
            html += "<tr id='row-" + row + "'>";
            html += '<td class="text-center align-middle">' + row + "</td>";
            html += "<td class='text-left'>";
            // destroy select2

            selectOption = $(
                "table tbody tr:first-child td:nth-child(2)"
            ).html();

            html += selectOption;
            html = html.replace(/-row1/g, "-row" + row);

            html += "</td>";

            html +=
                '<td><input type="number" name="nilai-y-row' +
                row +
                '" id="nilai-y-row' +
                row +
                '" class="form-control nilai-y"></td>';
            html +=
                '<td><input type="number" name="triwulan1-row' +
                row +
                '" id="triwulan1-row' +
                row +
                '" class="form-control triwulan1"></td>';
            html +=
                '<td><input type="number" name="triwulan2-row' +
                row +
                '" id="triwulan2-row' +
                row +
                '" class="form-control triwulan2"></td>';
            html +=
                '<td><input type="number" name="triwulan3-row' +
                row +
                '" id="triwulan3-row' +
                row +
                '" class="form-control triwulan3"></td>';
            html +=
                '<td><input type="number" name="triwulan4-row' +
                row +
                '" id="triwulan4-row' +
                row +
                '" class="form-control triwulan4"></td>';
            html +=
                '<td><input disabled type="number" name="target-triwulan1-row' +
                row +
                '" id="target-triwulan1-row' +
                row +
                '" class="form-control target-triwulan1"></td>';
            html +=
                '<td><input disabled type="number" name="target-triwulan2-row' +
                row +
                '" id="target-triwulan2-row' +
                row +
                '" class="form-control target-triwulan2"></td>';
            html +=
                '<td><input disabled type="number" name="target-triwulan3-row' +
                row +
                '" id="target-triwulan3-row' +
                row +
                '" class="form-control target-triwulan3"></td>';
            html +=
                '<td><input disabled type="number" name="target-triwulan4-row' +
                row +
                '" id="target-triwulan4-row' +
                row +
                '" class="form-control target-triwulan4"></td>';

            html += "</tr>";
        }

        table.append(html);
        for (var i = 1; i <= jumlahObjek + 1; i++) {
            $("#satuan-row" + i).select2({
                theme: "bootstrap4",
            });
        }
        jumlahObjek = parseInt(jumlahObjek) + 1;
        $("#jumlah-objek").val(jumlahObjek);
    });

    // change Jumlah Objek
    $("#jumlah-objek").on("change", function () {
        var jumlahObjek = $(this).val();

        if (jumlahObjek > 50) {
            // sweet alert
            Swal.fire({
                title: "Jumlah objek tidak boleh lebih dari 50",
                icon: "error",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "OK",
            });

            $(this).val(50);
            jumlahObjek = 50;
        }
        if (jumlahObjek < 1) {
            Swal.fire({
                title: "Jumlah objek tidak boleh kurang dari 1",
                icon: "error",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "OK",
            });
            $(this).val(1);
            jumlahObjek = 1;
        }

        if (jumlahObjek == 0) {
            jumlahObjek = 1;
        }
        for (var i = 1; i <= jumlahObjek; i++) {
            $("#satuan-row" + i).select2("destroy");
        }
        var table = $("table tbody");
        var html = "";
        for (var i = 0; i < jumlahObjek; i++) {
            row = i + 1;
            html += "<tr>";
            html += '<td class="text-center align-middle">' + (i + 1) + "</td>";
            html += "<td class='text-left'>";
            // copy select option from first row
            selectOption = $(
                "table tbody tr:first-child td:nth-child(2)"
            ).html();
            selectOption = selectOption.replace(/-row1/g, "-row" + row);
            html += selectOption;
            // html = html.replace(/-row1/g, "-row" + row);

            html += "</td>";
            html +=
                '<td><input type="number" name="nilai-y-row' +
                row +
                '" id="nilai-y-row' +
                row +
                '" class="form-control nilai-y"></td>';
            html +=
                '<td><input type="number" name="triwulan1-row' +
                row +
                '" id="triwulan1-row' +
                row +
                '" class="form-control triwulan1"></td>';
            html +=
                '<td><input type="number" name="triwulan2-row' +
                row +
                '" id="triwulan2-row' +
                row +
                '" class="form-control triwulan2"></td>';
            html +=
                '<td><input type="number" name="triwulan3-row' +
                row +
                '" id="triwulan3-row' +
                row +
                '" class="form-control triwulan3"></td>';
            html +=
                '<td><input type="number" name="triwulan4-row' +
                row +
                '" id="triwulan4-row' +
                row +
                '" class="form-control triwulan4"></td>';
            html +=
                '<td><input disabled type="number" name="target-triwulan1-row' +
                row +
                '" id="target-triwulan1-row' +
                row +
                '" class="form-control target-triwulan1"></td>';
            html +=
                '<td><input disabled type="number" name="target-triwulan2-row' +
                row +
                '" id="target-triwulan2-row' +
                row +
                '" class="form-control target-triwulan2"></td>';
            html +=
                '<td><input disabled type="number" name="target-triwulan3-row' +
                row +
                '" id="target-triwulan3-row' +
                row +
                '" class="form-control target-triwulan3"></td>';
            html +=
                '<td><input disabled type="number" name="target-triwulan4-row' +
                row +
                '" id="target-triwulan4-row' +
                row +
                '" class="form-control target-triwulan4"></td>';
            html += "</tr>";
        }
        table.html(html);
        for (var i = 1; i <= jumlahObjek; i++) {
            $("#satuan-row" + i).select2({
                theme: "bootstrap4",
            });
        }

        $("#total-triwulan1").val(0);
        $("#total-triwulan2").val(0);
        $("#total-triwulan3").val(0);
        $("#total-triwulan4").val(0);
        $("#nilai-y").val(0);

        $("#target-total-triwulan1").val(0);
        $("#target-total-triwulan2").val(0);
        $("#target-total-triwulan3").val(0);
        $("#target-total-triwulan4").val(0);
        $("#presentase-target-triwulan1").val(0);
        $("#presentase-target-triwulan2").val(0);
        $("#presentase-target-triwulan3").val(0);
        $("#presentase-target-triwulan4").val(0);
    });

    // create function to calculate total
    function calculateTotal() {
        // get id of changed input
        var id = $(this).attr("id");
        // if not ''
        // disable other input
        // if (id.includes("triwulan1")) {
        //     row = id.replace("triwulan1-row", "");
        //     // if val is empty set to enable
        //     value = parseInt($(this).val()) || 0;
        //     if (value === 0) {
        //         $("#triwulan2-row" + row).removeAttr("disabled");
        //         $("#triwulan3-row" + row).removeAttr("disabled");
        //         $("#triwulan4-row" + row).removeAttr("disabled");
        //     } else {
        //         $("#triwulan2-row" + row).attr("disabled", "disabled");
        //         $("#triwulan3-row" + row).attr("disabled", "disabled");
        //         $("#triwulan4-row" + row).attr("disabled", "disabled");
        //     }
        // }
        // if (id.includes("triwulan2")) {
        //     row = id.replace("triwulan2-row", "");
        //     value = parseInt($(this).val()) || 0;
        //     if (value === 0) {
        //         $("#triwulan1-row" + row).removeAttr("disabled");
        //         $("#triwulan3-row" + row).removeAttr("disabled");
        //         $("#triwulan4-row" + row).removeAttr("disabled");
        //     } else {
        //         $("#triwulan1-row" + row).attr("disabled", "disabled");
        //         $("#triwulan3-row" + row).attr("disabled", "disabled");
        //         $("#triwulan4-row" + row).attr("disabled", "disabled");
        //     }
        // }
        // if (id.includes("triwulan3")) {
        //     row = id.replace("triwulan3-row", "");
        //     value = parseInt($(this).val()) || 0;
        //     if (value === 0) {
        //         $("#triwulan1-row" + row).removeAttr("disabled");
        //         $("#triwulan2-row" + row).removeAttr("disabled");
        //         $("#triwulan4-row" + row).removeAttr("disabled");
        //     } else {
        //         $("#triwulan1-row" + row).attr("disabled", "disabled");
        //         $("#triwulan2-row" + row).attr("disabled", "disabled");
        //         $("#triwulan4-row" + row).attr("disabled", "disabled");
        //     }
        // }
        // if (id.includes("triwulan4")) {
        //     row = id.replace("triwulan4-row", "");
        //     value = parseInt($(this).val()) || 0;
        //     if (value === 0) {
        //         $("#triwulan1-row" + row).removeAttr("disabled");
        //         $("#triwulan2-row" + row).removeAttr("disabled");
        //         $("#triwulan3-row" + row).removeAttr("disabled");
        //     } else {
        //         $("#triwulan1-row" + row).attr("disabled", "disabled");
        //         $("#triwulan2-row" + row).attr("disabled", "disabled");
        //         $("#triwulan3-row" + row).attr("disabled", "disabled");
        //     }
        // }

        var jumlahObjek = $("#jumlah-objek").val() || 1;
        var accumulatedTriwulan = 0;
        console.log("jumlahObjek", jumlahObjek);
        for (i = 1; i <= jumlahObjek; i++) {
            for (j = 1; j <= 4; j++) {
                var triwulan = $("#triwulan" + j + "-row" + i).val();
                accumulatedTriwulan += triwulan ? parseInt(triwulan) : 0;
                $("#target-triwulan" + j + "-row" + i).val(accumulatedTriwulan);
                console.log(
                    "triwulan",
                    j,
                    "-row" + i + " = ",
                    accumulatedTriwulan
                );
            }
            accumulatedTriwulan = 0;
        }

        var totalTargetTriwulan1 = 0;
        var totalTargetTriwulan2 = 0;
        var totalTargetTriwulan3 = 0;
        var totalTargetTriwulan4 = 0;

        var totalTriwulan1 = 0;
        var totalTriwulan2 = 0;
        var totalTriwulan3 = 0;
        var totalTriwulan4 = 0;
        var totalNilaiY = 0;

        $("table tbody tr").each(function () {
            var triwulan1 = $(this).find(".triwulan1").val();
            triwulan1 = triwulan1 ? parseInt(triwulan1) : 0; // Handle empty input values
            var triwulan2 = $(this).find(".triwulan2").val();
            triwulan2 = triwulan2 ? parseInt(triwulan2) : 0; // Handle empty input values
            var triwulan3 = $(this).find(".triwulan3").val();
            triwulan3 = triwulan3 ? parseInt(triwulan3) : 0; // Handle empty input values
            var triwulan4 = $(this).find(".triwulan4").val();
            triwulan4 = triwulan4 ? parseInt(triwulan4) : 0; // Handle empty input values
            var nilaiY = $(this).find(".nilai-y").val();
            nilaiY = nilaiY ? parseInt(nilaiY) : 0; // Handle empty input values

            var targetTriwulan1 = $(this).find(".target-triwulan1").val();
            targetTriwulan1 = targetTriwulan1 ? parseInt(targetTriwulan1) : 0; // Handle empty input values
            var targetTriwulan2 = $(this).find(".target-triwulan2").val();
            targetTriwulan2 = targetTriwulan2 ? parseInt(targetTriwulan2) : 0; // Handle empty input values
            var targetTriwulan3 = $(this).find(".target-triwulan3").val();
            targetTriwulan3 = targetTriwulan3 ? parseInt(targetTriwulan3) : 0; // Handle empty input values
            var targetTriwulan4 = $(this).find(".target-triwulan4").val();
            targetTriwulan4 = targetTriwulan4 ? parseInt(targetTriwulan4) : 0; // Handle empty input values

            totalTriwulan1 += triwulan1;
            totalTriwulan2 += triwulan2;
            totalTriwulan3 += triwulan3;
            totalTriwulan4 += triwulan4;
            totalNilaiY += nilaiY;

            totalTargetTriwulan1 += targetTriwulan1;
            totalTargetTriwulan2 += targetTriwulan2;
            totalTargetTriwulan3 += targetTriwulan3;
            totalTargetTriwulan4 += targetTriwulan4;
        });

        $("#target-total-triwulan1").val(totalTargetTriwulan1);
        $("#target-total-triwulan2").val(totalTargetTriwulan2);
        $("#target-total-triwulan3").val(totalTargetTriwulan3);
        $("#target-total-triwulan4").val(totalTargetTriwulan4);

        $("#total-triwulan1").val(totalTriwulan1);
        $("#total-triwulan2").val(totalTriwulan2);
        $("#total-triwulan3").val(totalTriwulan3);
        $("#total-triwulan4").val(totalTriwulan4);
        $("#total-y").val(totalNilaiY);

        $("#presentase-target-triwulan1").val(
            ((totalTargetTriwulan1 / totalNilaiY) * 100).toFixed(2)
        );
        $("#presentase-target-triwulan2").val(
            ((totalTargetTriwulan2 / totalNilaiY) * 100).toFixed(2)
        );
        $("#presentase-target-triwulan3").val(
            ((totalTargetTriwulan3 / totalNilaiY) * 100).toFixed(2)
        );
        $("#presentase-target-triwulan4").val(
            ((totalTargetTriwulan4 / totalNilaiY) * 100).toFixed(2)
        );
    }

    // change total every change in triwulan
    $("table tbody").on("change", "input", function () {
        calculateTotal();
    });
});
