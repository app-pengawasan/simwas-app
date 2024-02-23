document.forms['myform'].reset();

var clockpicker = $('.clockpicker').clockpicker();

$(".modal").on("scroll", function (e) {
    clockpicker.clockpicker('hide');
    $('.clockpicker').trigger('blur');
});

var calendarEl = $("#calendar")[0];
var calendar = new FullCalendar.Calendar(calendarEl, {
    locale: 'id',
    initialView: 'timeGridWeek',
    nowIndicator: true,
    slotDuration: '01:00:00',
    eventOverlap: false,
    selectOverlap: function(event) {
        return this.calendar.currentData.currentViewType == 'dayGridMonth';
    },
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
    events: events,
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
        let status; let tag;
        $.get(document.location.origin + '/document/realisasi/' + info.event.extendedProps.hasil_kerja)
            .done(function() { 
                tag = '<a href="' + this.url + '" target="_blank">';
                desc();
            }).fail(function() { 
                tag = '<a href ="' + info.event.extendedProps.hasil_kerja + '" target="_blank">';
                desc();
            }) 
        let desc = () => {
            if (info.event.extendedProps.status == 1) status = tag + '<span class="badge badge-success">Selesai</span></a>';
            else status = tag + '<span class="badge badge-primary">Belum Selesai</span></a>';
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
                        + '<table><tbody>'
                        + '<tr><td>Tim</td><td> : ' + info.event.extendedProps.tim + '</td></tr>'
                        + '<tr><td>Proyek</td><td> : ' + info.event.extendedProps.proyek + '</td></tr>'
                        + '<tr><td>Status Realisasi</td><td> : ' + status + '</td></tr>'
                        + '<tr><td>Catatan</td><td> : ' + (info.event.extendedProps.catatan || '-') + '</td></tr>'
                        + '</tbody></table>',
            });
        }
    },
    // selectable: true,
    // select: function(selectionInfo) {
    //     document.forms['myform'].reset();
    //     $('#error-id_pelaksana').text('');
    //     $('#error-start').text('');
    //     $('#error-end').text('');
    //     $('#error-aktivitas').text('');
        
    //     let start = moment(selectionInfo.start).format("HH:mm");
    //     let end = moment(selectionInfo.end).format("HH:mm");
    //     let startDate = moment(selectionInfo.start).format("YYYY-MM-DD");
    //     let endDate = moment(selectionInfo.end).format("YYYY-MM-DD");
    //     let selisih = Date.parse(endDate) - Date.parse(startDate);
    //     let view = selectionInfo.view.type;

    //     //tidak boleh memilih lebih dari sehari sekaligus
    //     if ((view != 'dayGridMonth' && startDate != endDate) || (view == 'dayGridMonth' && selisih != 86400000)) {
    //         calendar.unselect();
    //         return;
    //     }

    //     $('#modal-create-aktivitas').modal('toggle');
    //     if (start != '00:00') {
    //         $('#start').val(start);
    //         $('#end').val(end);
    //     }
    //     $('#tgl').val(startDate);
    //     $('#modal-create-aktivitas-label').html('Tambah Aktivitas: ' + moment(selectionInfo.start).format('LL'));
    // },
});
calendar.render();

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

// $(document).on({
//     mouseenter: function() {
//         let cellWidth = $('th.fc-col-header-cell').width();
//         let cellHeight = $(this).height();
//         let columnCount = $('th.fc-col-header-cell').children().length;

//         if (!$(this).html()) {
//             for (var i = 0; i < columnCount; i++) {
//                 $(this).append('<td class="temp-cell" style="border:0px; height:' + (cellHeight - 1) + 'px;width:' + (cellWidth + 3) + 'px"></td>');
//             }
//         }
//         $(this).children('td').each(function() {
//             $(this).on('mouseenter', function() {
//                 $(this).html('<div class="current-time h-100">+</div>');
//             }).on('mouseleave', function() {
//                 $(this).html('');
//             });
//         });

//     },

//     mouseleave: function() {
//         $(this).children('.temp-cell').remove();
//     }
// }, 'td.fc-timegrid-slot.fc-timegrid-slot-lane');

$(".fc-button-group").on("click", function (e) {
    $('.temp-cell').remove();
})

$("#modal-create-aktivitas .close, #modal-create-aktivitas .btn-danger") .on("click", function (e) {
    document.forms['myform'].reset();
});

$(".submit-btn").on("click", function (e) {
    e.preventDefault();

    $('#error-id_pelaksana').text('');
    $('#error-start').text('');
    $('#error-end').text('');
    $('#error-aktivitas').text('');

    let token = $("meta[name='csrf-token']").attr("content");
    let tgl = $("#tgl").val();
    let start = $("#start").val();
    let end = $("#end").val();
    let id_pelaksana = $("#id_pelaksana").val();
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
            id_pelaksana: id_pelaksana,
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
                errorMessage.innerText = value.join('\n');
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
            $("#edit-tugas").val(response.data[0].id_pelaksana);
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
    let id_pelaksana = $("#edit-tugas").val();
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
            id_pelaksana: id_pelaksana,
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