
function run_waitMe(effect,selector,text){ //effect  win8, win8_linear,bounce, orbit, ios,stretch,roundBounce rotateplane
    $('#'+selector).waitMe({

        effect: effect,
        text: text,
        bg: 'rgba(255,255,255,0.7)',
        color: '#000',
        maxSize: '',
        waitTime: -1,
        source: '',
        textPos: 'vertical',
        fontSize: '',
        onClose: function() {}
  });
}

 $(document).on('click', '.sidebar-toggle', function() {
               var url = '/sideBarChange';
                $.get(url, function(data){
                }); 
        });


 function formatNumber(num) {
            return num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
        }

 function swal_info_alert(title,body,type){ //type: success error
            swal({ title: title,
                  text: body,
                  type: type,
                   timer: 5500,
                  confirmButtonColor: '#4fa7f3'
              });
        }

    function reDeclerDataTable() {
        $('.data-table').DataTable( {
        responsive: true,   
        ordering: false ,
        dom: 'Bfrtip',
        buttons: [{
            text: 'copy',
            extend: "copy",
            className: 'btn bg-navy margin',
            exportOptions: {
                columns: "thead th:not(.noExport)"
            }
        }, {
            text: 'csv',
            extend: "csv",
            className: 'btn bg-navy margin',
            exportOptions: {
                columns: "thead th:not(.noExport)"
            }
        }, {
            text: 'excel',
            extend: "excel",
            className: 'btn bg-navy margin',
            exportOptions: {
                columns: "thead th:not(.noExport)"
            }
        }, {
            text: 'pdf',
            extend: "pdf",
            className: 'btn bg-navy margin',
            exportOptions: {
                columns: "thead th:not(.noExport)"
            }
        }, {
            text: 'print',
            extend: "print",
            className: 'btn bg-navy margin',
            exportOptions: {
                columns: "thead th:not(.noExport)"
            }
        }],
    });
}

$(document).on('click', '.deletePanel', function () {
    var id = $(this).data("id");
    var address = $(this).data("address");
    var token = $('meta[name="csrf-token"]').attr('content');
    var force = $(this).data("force");
 
    swal({
        title: 'Are you sure you want to Delete this?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
          confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Delete it !!",
            cancelButtonText: "No, cancel it !!",
    }).then(function () {

        $.ajax(
            {
                url: "/management/" + address + "/" + id,
                type: 'DELETE',
                dataType: "JSON",
                data: {
                    "id": id,
                    "_method": 'DELETE',
                    "_token": token,
                
                },
                success: function () {
                  $('.close_panel_'+id).click();
                },
                error: function (xhr, ajaxOptions, thrownError) {

                    alert(xhr.responseText);
                }
            });

    }, function (dismiss) {

        if (dismiss === 'cancel') {
            swal(
                'Cancelled',
                'Your file is safe :)',
                'error'
            )
        }
    })
});


 function print_staf_general(body){
     var w = window.open();
     w.document.write(body);
     w.window.print();
     w.document.close();
     return false;
 }

$(document).ready(function () {
    var t = $('.data-table').DataTable({
        responsive: true,
         ordering: false ,
        dom: 'Bfrtip',
        buttons: [{
            text: 'copy',
            extend: "copy",
            className: 'btn bg-navy margin',
            exportOptions: {
                columns: "thead th:not(.noExport)"
            }
        }, {
            text: 'csv',
            extend: "csv",
            className: 'btn bg-navy margin',
            exportOptions: {
                columns: "thead th:not(.noExport)"
            }
        }, {
            text: 'excel',
            extend: "excel",
            className: 'btn bg-navy margin',
            exportOptions: {
                columns: "thead th:not(.noExport)"
            }
        }, {
            text: 'pdf',
            extend: "pdf",
            className: 'btn bg-navy margin',
            exportOptions: {
                columns: "thead th:not(.noExport)"
            }
        }, {
            text: 'print',
            extend: "print",
            className: 'btn bg-navy margin',
            exportOptions: {
                columns: "thead th:not(.noExport)"
            }
        }],
    });


});

$(document).ajaxStart(function () {
    Pace.restart()
})

$(document).ready(function () {
    $('.sidebar-menu').tree()
})


$('.prevent-resubmit-form').on('submit', function () {
    $('.prevent-resubmit-button').prop("disabled", true);
    $('.prevent-resubmit-button').html('<i class="icon-append fa fa-spinner fa-spin fa-fw"></i> Sending..');
});

$('.alert_span').delay(5000).slideUp();


function reinitializeselect(){
    $('.select2').select2();

}

///sory do not clean this Evans's Function

 function findDataToSelect(item,name,searchable,title,table){
     $.ajax({
         type: "GET",
         url: `/get_selected_single/${item}/${name}/${searchable}/${title}/${table}`,
         success: function (data) {
             $(`#${name}`).html(data);
         }
     });
 }



function reinitializeDatePicker(){
    $(function () {
        //Date picker
        $('.datepicker').datepicker({
            autoclose: true,
            format: 'yyyy/mm/dd'
        })
    });
}

function show_alert_dev(type = 'danger', msg) { // Development timer

    $('#alert_span').html('<div class="alert alert-' + type + ' alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong><i class="icon fa fa-check"></i>Error!</strong>Oppps something went wrong please contact the teachnical team</div>');
    $('#alert_span').show('slow');
    setTimeout(function () {
        $('.alert_span').slideUp();
    }, duration);

}

function show_success_text(divname, message) {
    var content = $('#' + divname).html();
    $('#' + divname).html("<div class=\"col-md-12\"><div class=\"order-confirmation-page\"><div class=\"breathing-icon\"><i class=\"fa fa-check\"></i></div><h2 class=\"margin-top-30\">Thank You!</h2><p>" + message + "! </p></div></div></div>");
    setTimeout(function () {
        $('#' + divname).html(content);
    }, 4000);
}


function close_modal(modal_id) {
    $('#' + modal_id).modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
    // $('#'+modal_id).remove();
};

function show_alert(type, msg, duration = 5000) { // Development timer
                                                  // console.log(duration);
    if (type == 'success') {
        title = 'Success';
    }
    if (type == 'warning') {
        title = 'Warning';
    }
    if (type == 'danger') {
        title = 'Error';
    }
    if (type == 'warning') {
        title = 'Warning';
    }
    if (type == 'default') {
        title = 'Info';
    }

    $('#alert_span').html('<div class="alert alert-' + type + ' alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong><i class="icon fa fa-check"></i>Success!</strong> ' + msg + '.</div>');
    $('#alert_span').show('slow');

    setTimeout(function () {
        $('.alert_span').slideUp();
    }, duration);
}


$(document).on('click', '.deleteTr', function () {
    var id = $(this).data("id");
    var address = $(this).data("address");
    var token = $('meta[name="csrf-token"]').attr('content');
    var force = $(this).data("force");
    var $tr = $(this).closest("tr");
    swal({
        title: 'Are you sure you want to Delete this?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
          confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Delete it !!",
            cancelButtonText: "No, cancel it !!",
    }).then(function () {

        $.ajax(
            {
                url: "/management/" + address + "/" + id,
                type: 'DELETE',
                dataType: "JSON",
                data: {
                    "id": id,
                    "_method": 'DELETE',
                    "_token": token,
                    "_force": force,
                },
                success: function () {
                    $tr.fadeOut(500, function () {
                        $tr.remove();
                        swal(
                            'Deleted!',
                            name + ' has been deleted successful',
                            'success'
                        )
                    });
                    $('.tooltip').hide();
                },
                error: function (xhr, ajaxOptions, thrownError) {

                    alert(xhr.responseText);
                }
            });

    }, function (dismiss) {

        if (dismiss === 'cancel') {
            swal(
                'Cancelled',
                'Your file is safe :)',
                'error'
            )
        }
    })
});


$(document).on('click', '.deletePanel', function () {
    var id = $(this).data("id");
    var address = $(this).data("address");
    var token = $('meta[name="csrf-token"]').attr('content');
    var force = $(this).data("force");
 
    swal({
        title: 'Are you sure you want to Delete this?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
          confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Delete it !!",
            cancelButtonText: "No, cancel it !!",
    }).then(function () {

        $.ajax(
            {
                url: "/management/" + address + "/" + id,
                type: 'DELETE',
                dataType: "JSON",
                data: {
                    "id": id,
                    "_method": 'DELETE',
                    "_token": token,
                
                },
                success: function () {
                  $('.close_panel_'+id).click();
                },
                error: function (xhr, ajaxOptions, thrownError) {

                    alert(xhr.responseText);
                }
            });

    }, function (dismiss) {

        if (dismiss === 'cancel') {
            swal(
                'Cancelled',
                'Your file is safe :)',
                'error'
            )
        }
    })
});


$(document).on('click', '.deleteLi', function () {
    var id = $(this).data("id");
    var address = $(this).data("address");
    var token = $('meta[name="csrf-token"]').attr('content');
    var force = $(this).data("force");
    var $li = $(this).closest("li");
    swal({
        title: 'Are you sure you want to Delate this?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
          confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Delete it !!",
            cancelButtonText: "No, cancel it !!",
    }).then(function () {

        $.ajax(
            {
                url: "/management/" + address + "/" + id,
                type: 'DELETE',
                dataType: "JSON",
                data: {
                    "id": id,
                    "_method": 'DELETE',
                    "_token": token,
                    "_force": force,
                },
                success: function () {
                    $li.fadeOut(500, function () {
                        $li.remove();
                        swal(
                            'Deleted!',
                            name + ' has been deleted successful',
                            'success'
                        )
                    });
                    $('.tooltip').hide();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.responseText);
                }
            });

    }, function (dismiss) {

        if (dismiss === 'cancel') {
            swal(
                'Cancelled',
                'Your imaginary file is safe :)',
                'error'
            )
        }
    })
});

$(document).on('click', '.deleteThis', function () {
    var id = $(this).data("id");
    var table = $(this).data("table");
    var $tr = $(this).closest("tr");
    swal({
        title: 'Are you sure you want to Delete this?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
       confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Delete it !!",
            cancelButtonText: "No, cancel it !!",
    }).then(function () {
        $.ajax({
            type: "GET",
            url: "/management/delete_any/" + table + "/" + id,
            success: function (data) {
                $tr.fadeOut(500, function () {
                    $tr.remove();
                    swal(
                        'Deleted!',
                        'Deletion was made successfully ',
                        'success'
                    )
                });
                $('.tooltip').hide();
            },
        });

    }, function (dismiss) {
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
            swal(
                'Cancelled',
                'Your imaginary file is safe :)',
                'error'
            )
        }
    })
});

function snackbartext(type, text) {
    $('#text_content').html(text);
    if (type == 'success') {
        color = '#3CB371';
    }
    if (type == 'warning') {
        color = '#B5C307';
    }
    if (type == 'danger') {
        color = '#DF0B1E';
    }
    if (type == 'info') {
        color = 'Info';
    }
    $('#snackbar').css('background-color', color);
    $('#snackbar').attr('class', 'show');
    setTimeout(function () {
        $('#snackbar').removeAttr('class');
    }, 3000);
}

$(document).ready(function () {
    $('.summernote_editor').summernote();
    lang: 'en-US' // default: 'en-US'
});

function initializeSummernote() {
        $('.summernote_editor').summernote();
        lang: 'en-US' // default: 'en-US'
}

function destroySummernote() {
        $('.summernote_editor').summernote('destroy');
}

