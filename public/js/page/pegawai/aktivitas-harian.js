document.forms['myform'].reset();

$('.clockpicker').clockpicker();

var calendarEl = $("#calendar")[0];
var calendar = new FullCalendar.Calendar(calendarEl, {
    locale: 'id',
    initialView: 'timeGridWeek',
    nowIndicator: true,
    slotDuration: '01:00:00',
    eventDidMount: function(info) {
        moment.locale('id');
        let startdate = moment(info.event.start);
        let enddate = moment(info.event.end);
        // alert(JSON.stringify())
        $(info.el).popover({ 
            sanitize: false,
            title: '<i role="button" class="fas fa-edit edit-btn" data-toggle="modal" data-target="#modal-edit-aktivitas" data-id="' + info.event.id + '"></i>' +
                   '<i role="button" class="fas fa-trash delete-btn" data-id="' + info.event.id + '"></i> <button id="close" class="close ml-3">&times;</button>',
            trigger: 'click',
            placement: 'right',
            // template: '<div class="popover bs-popover-top" role="tooltip" x-placement="top"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
            html: true,
            content: '<h3>' + info.event.title + '</h3>' + 
                     startdate.format('dddd, D MMMM YYYY • HH:mm - ') + enddate.format('HH:mm')
                     + '<br><br><h3>Aktivitas</h3>' + info.event.extendedProps.aktivitas,
        });
    },
    headerToolbar: {
        start: 'prev,next today',
        center: 'title',
        end: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek' // user can switch between the two
    },
    events: events,
    allDayContent:
    { 
        html: '<i class="fa-regular fa-clock"></i>' 
    },
    // eventClick: function(info) {
    //     alert('Event: ' + info.event.title);
    // },
    selectable: true,
    select: function(selectionInfo) {
        $('#title').val('');
        $('#start').val('');
        $('#end').val('');

        let start = moment(selectionInfo.startStr).format("HH:mm");
        let end = moment(selectionInfo.endStr).format("HH:mm");
        let tgl = moment(selectionInfo.startStr).format("YYYY-MM-DD");

        $('#modal-create-aktivitas').modal('toggle');
        if (start != '00:00') {
            $('#start').val(start);
            $('#end').val(end);
        }
        $('#tgl').val(tgl);
    },
    // dateClick: function(info) {
    //     alert('Clicked on: ' + info.dateStr);
    // },
    eventOverlap: false,
    // timeFormat: 'H(:mm)'
});
calendar.render();

//tutup popover saat klik di luar atau buka modal
$("html").on("mouseup", function (e) {
    var l = $(e.target);
    if (l[0].className.indexOf("popover") == -1) {
        $(".popover").each(function () {
            $(this).popover("hide");
        });
    }
});

$("#modal-create-aktivitas .close, #modal-create-aktivitas .btn-danger") .on("click", function (e) {
    document.forms['myform'].reset();
});

$(".submit-btn").on("click", function (e) {
    e.preventDefault();

    $('#error-id_rencanakerja').text('');
    $('#error-start').text('');
    $('#error-end').text('');
    $('#error-aktivitas').text('');

    let token = $("meta[name='csrf-token']").attr("content");
    let tgl = $("#tgl").val();
    let start = $("#start").val();
    let end = $("#end").val();
    let id_rencanakerja = $("#id_rencanakerja").val();
    let aktivitas = $("#aktivitas").val();

    $.ajax({
        url: `/pegawai/aktivitas-harian`,
        type: "POST",
        cache: false,
        data: {
            _token: token,
            tgl: tgl,
            start: start,
            end: end,
            id_rencanakerja: id_rencanakerja,
            aktivitas: aktivitas
        },
        success: function (response) {
            location.reload();
        },
        error: function (error) {
            let errorResponses = error.responseJSON;
            let errors = Object.entries(errorResponses.errors);

            errors.forEach(([key, value]) => {
                let errorMessage = document.getElementById(`error-${key}`);
                errorMessage.innerText = `${value}`;
            });
        },
    });
});

$(document).on("click", ".popover .edit-btn" , function(e){
    e.preventDefault();
    let dataId = $(this).attr("data-id");

    $('#error-edit-start').text('');
    $('#error-edit-end').text('');
    $('#error-edit-aktivitas').text('');
    $('#error-edit-tgl').text('');

    $.ajax({
        url: `/pegawai/aktivitas-harian/${dataId}`,
        type: "GET",
        cache: false,
        success: function (response) {
            document.forms['myeditform'].reset();
            $("#edit-tugas").val(response.data[0].id_rencanakerja);
            $("#edit-start").val(moment(response.data[0].start).format("HH:mm"));
            $("#edit-end").val(moment(response.data[0].end).format("HH:mm"));
            $("#edit-aktivitas").val(response.data[0].aktivitas);
            $("#edit-tgl").val(moment(response.data[0].start).format("YYYY-MM-DD"));
            $("#id").val(response.data[0].id);
        },
    });
});

$("#btn-edit-submit").on("click", function (e) {
    e.preventDefault();

    $('#error-edit-start').text('');
    $('#error-edit-end').text('');
    $('#error-edit-aktivitas').text('');
    $('#error-edit-tgl').text('');
    
    let token = $("meta[name='csrf-token']").attr("content");
    let tgl = $("#edit-tgl").val();
    let start = $("#edit-start").val();
    let end = $("#edit-end").val();
    let id_rencanakerja = $("#edit-tugas").val();
    let aktivitas = $("#edit-aktivitas").val();
    let dataId = $("#id").val();

    $.ajax({
        url: `/pegawai/aktivitas-harian/${dataId}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            tgl: tgl,
            start: start,
            end: end,
            id_rencanakerja: id_rencanakerja,
            aktivitas: aktivitas,
        },
        success: function (response) {
            location.reload();
        },
        error: function (error) {
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

$(document).on("click", ".popover .delete-btn" , function(e){
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
                url: `/pegawai/aktivitas-harian/${dataId}`,
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