var stepper1Node = document.querySelector("#stepper1");
var stepper1 = new Stepper(document.querySelector("#stepper1"));

stepper1Node.addEventListener("show.bs-stepper", function (event) {
    console.warn("show.bs-stepper", event);
});
stepper1Node.addEventListener("shown.bs-stepper", function (event) {
    console.warn("shown.bs-stepper", event);
});

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
