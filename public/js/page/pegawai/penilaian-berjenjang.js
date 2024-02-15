let today = new Date();
$('#filterBulan').val(("0" + (today.getMonth() + 1)).slice(-2));

let table = $("#table-daftar-nilai")
    .dataTable({
        dom: "Bfrtip",
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        buttons: [
            {
                extend: "excel",
                className: "btn-success",
                text: '<i class="fas fa-file-excel"></i> Excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
                },
                messageTop: function () {
                    return 'Bulan: ' + $(":selected", '#filterBulan').text() + ' - ' +
                            'Unit Kerja: ' + $(":selected", '#filterUnitKerja').text();
                },
            },
            {
                extend: "pdf",
                className: "btn-danger",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
                },
                messageTop: function () {
                    return 'Bulan: ' + $(":selected", '#filterBulan').text() + '; ' +
                            'Unit Kerja: ' + $(":selected", '#filterUnitKerja').text();
                },
            },
        ],
    }).api();

$('#filterBulan').on("change", function () {
    table.draw();
});

$('#filterUnitKerja').on("change", function () {
    table.draw();
});

let allowFilter = ['table-daftar-nilai'];

$.fn.dataTableExt.afnFiltering.push(
    function (setting, data, index) {
        // check if current table is part of the allow list
        if ( $.inArray( setting.nTable.getAttribute('id'), allowFilter ) == -1 ) {
            // if not table should be ignored
            return true;
        }
        var selectedBulan = $('select#filterBulan option:selected').val();
        var selectedUnit = $('select#filterUnitKerja option:selected').val();
        if (data[7] == selectedBulan && (data[8] == selectedUnit || selectedUnit == 'all')) return true;
        else return false;
    }
);

table.draw();

$("#table-nilai")
    .dataTable({
        dom: "Bfrtip",
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        buttons: [
            {
                extend: "excel",
                className: "btn-success",
                text: '<i class="fas fa-file-excel"></i> Excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 9, 5, 6, 7],
                },
                messageTop: function () {
                    return $('.section-header').text();
                },
            },
            {
                extend: "pdf",
                className: "btn-danger",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                exportOptions: {
                    columns: [0, 1, 2, 3, 9, 5, 6, 7],
                },
                messageTop: function () {
                    return $('.section-header').text();
                },
            },
        ],
    });

$(".nilai-btn").on("click", function () {
    document.forms['myform'].reset();
    let dataId = $(this).attr("data-id");
    $('#id').val(dataId);
});

$(".edit-btn").on("click", function (e) {
    e.preventDefault();

    let dataId = $(this).attr("data-id");
    $('#edit-id').val(dataId);
    $('#error-edit-nilai').text('');

    $.ajax({
        url: `/pegawai/nilai-berjenjang/nilai/${dataId}`,
        type: "GET",
        cache: false,
        success: function (response) {
            document.forms['myeditform'].reset();
            $("#edit-id").val(response.data[0].id);
            $("#edit-nilai").val(response.data[0].nilai);
            $("#edit-catatan").val(response.data[0].catatan_penilai);
        },
    });
});

$('.submit-btn').on("click", function (e) {
    e.preventDefault();
    $('#error-nilai').text('');

    let dataId = $('#id').val();
    let token = $("meta[name='csrf-token']").attr("content");
    let nilai = $("#nilai").val();
    let catatan = $("#catatan").val();
    $.ajax({
        url: `/pegawai/nilai-berjenjang/${dataId}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            nilai: nilai,
            catatan: catatan
        },
        success: function (response) {
            location.reload();
        },
        error: function (error) {
            $('form').removeClass('was-validated');
            $('.form-group').addClass('was-validated');

            let errorResponses = error.responseJSON;
            let errors = Object.entries(errorResponses.errors);

            errors.forEach(([key, value]) => {
                console.log(errors);
                let errorMessage = document.getElementById(`error-${key}`);
                errorMessage.innerText = `${value}`;
            });
        },
    });
});

$('.submit-edit-btn').on("click", function (e) {
    e.preventDefault();

    let dataId = $('#edit-id').val();
    let token = $("meta[name='csrf-token']").attr("content");
    let nilai = $("#edit-nilai").val();
    let catatan = $("#edit-catatan").val();
    $.ajax({
        url: `/pegawai/nilai-berjenjang/${dataId}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            nilai: nilai,
            catatan: catatan
        },
        success: function (response) {
            location.reload();
        },
        error: function (error) {
            $('form').removeClass('was-validated');
            $('.form-group').addClass('was-validated');

            let errorResponses = error.responseJSON;
            let errors = Object.entries(errorResponses.errors);

            errors.forEach(([key, value]) => {
                console.log(errors);
                let errorMessage = document.getElementById(`error-edit-${key}`);
                errorMessage.innerText = `${value}`;
            });
        },
    });
});

var calendarEl = $("#calendar")[0];
var calendar = new FullCalendar.Calendar(calendarEl, {
    locale: 'id',
    initialView: 'dayGridMonth',
    nowIndicator: true,
    slotDuration: '01:00:00',
    eventOverlap: false,
    selectOverlap: function(event) {
        return this.calendar.currentData.currentViewType == 'dayGridMonth';
    },
    events: events,
    headerToolbar: {
        start: 'prev,next today',
        center: 'title',
        end: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth' // user can switch between the two
    },
    allDayContent:  { 
        html: '<i class="fa-regular fa-clock"></i>' 
    },
    buttonText: {
        today:    'Hari ini',
        month:    'Bulan',
        week:     'Minggu',
        day:      'Hari',
        list:     'List'
    },
    views: {
        dayGridMonth: { // name of view
            eventTimeFormat: function(date) {
                let eDate = date.start.array;
                moment.locale('en');
                if (eDate[4] === 0) return moment(eDate).format('ha');
                else return moment(eDate).format('h.ma')
            },
            selectable: true,
            select: function(selectionInfo) {
                let startDate = moment(selectionInfo.start).format("YYYY-MM-DD");
                let endDate = moment(selectionInfo.end).format("YYYY-MM-DD");
                let selisih = Date.parse(endDate) - Date.parse(startDate);
                //jika hanya memilih sehari pindah ke view day, jika memilih berhari-hari pindah ke view week
                if (selisih == 86400000) calendar.changeView('timeGridDay', startDate); 
                else calendar.changeView('timeGridWeek', startDate);
            }
        },
        timeGrid: {
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit'
            }
        },
        list: {
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit'
            }
        }
    },
    eventDidMount: function(info) {
        moment.locale('id');
        let startdate = moment(info.event.start);
        let enddate = moment(info.event.end);
        // alert(JSON.stringify())
        $(info.el).popover({ 
            sanitize: false,
            title: '<button id="close" class="close ml-3">&times;</button>',
            trigger: 'click',
            placement: 'right',
            html: true,
            content: '<h3>' + info.event.title + '</h3>' + 
                     startdate.format('dddd, D MMMM YYYY • HH:mm - ') + enddate.format('HH:mm')
                     + '<br><br><h3>Aktivitas</h3>' + info.event.extendedProps.aktivitas,
        });
    },
    handleWindowResize: true
});

calendar.render();

if (events[0]['initialDate']) {
    calendar.gotoDate(events[0]['initialDate']);

    let date = new Date(events[0]['initialDate']);
    y = date.getFullYear();
    m = date.getMonth();

    calendar.setOption('validRange', {
        start: new Date(y, m, 1),
        end: new Date(y, m + 1, 0)
    });

    calendar.setOption('headerToolbar', {
        start: 'prev,next',
        center: 'title',
        end: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
    });
    // $('.fc-toolbar-chunk').css('padding-left', '6rem');
}

//tutup popover event saat klik di luar atau buka modal
$("html").on("mouseup", function (e) {
    var l = $(e.target);
    if (l[0].className.indexOf("popover") == -1) {
        $(".popover").each(function () {
            $(this).popover("hide");
        });
    }
});

//update ukuran kalender saat ukuran sidebar berubah
$('.nav-link').on("click", function () {
    setTimeout(() => {
        calendar.updateSize();
    }, 400);
});