<!-- jQuery 3 -->
<script src="{{ url('/') }}/assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ url('/') }}/assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="{{ url('/') }}/assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
{{-- <script src="{{ url('/') }}/assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ url('/') }}/assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> --}}
<!-- SlimScroll -->

<script src="{{ url('/') }}/assets/bower_components/PACE/pace.min.js"></script>

<!-- FastClick -->
<script src="{{ url('/') }}/assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{ url('/') }}/assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ url('/') }}/assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="{{ url('/') }}/assets/plugins/sweet-alert/sweetalert2.min.js"></script>
<script src="{{ url('/') }}/assets/plugins/DataTables/datatables.min.js"></script>
<script src="{{ url('/') }}/assets/plugins/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<script src="{{ url('/') }}/assets/plugins/loading/waitMe.js"></script>
<script src="{{ url('/') }}/assets/dist/js/demo.js"></script>
<script src="{{ url('/') }}/assets/bower_components/select2/dist/js/select2.full.min.js"></script>

<script src="{{ url('/') }}/custom/axios.js" ></script>
<script src="{{ url('/') }}/assets/plugins/ckeditor5/build/ckeditor.js"></script>

<script src="{{ url('/') }}/assets/plugins/ElegantLoader/src/js/jquery.preloader.min.js"></script>
<script src="{{ url('/') }}/assets/plugins/summernote/summernote.min.js"></script>
<script src="{{ url('/') }}/assets/plugins/tooltipster/dist/js/tooltipster.bundle.min.js"></script>

<script type="text/javascript" src="{{ url('/') }}/assets/plugins/datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="{{ url('/') }}/assets/plugins/datetimepicker/js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>


<script src="{{ url('/') }}/custom/js/custom.js"></script>


<script type="text/javascript">

function rooltipinitiate(tootip){
    $('.'+tootip).tooltipster({
        delay: 100,
        maxWidth: 500,
        speed: 300,
        interactive: true,
        animation: 'grow',
        trigger: 'hover'
      });
}



// Making number user friend;

$.fn.digits = function(){
     return this.each(function(){
         $(this).text( $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") );
     })
 };



// $('input').attr('autocomplete','off');
$('.datepicker').attr('autocomplete','off');

 






 function reinitializeDatepicker(){
     $('.datepicker').datepicker({
         autoclose: true,
         format: 'yyyy/mm/dd'
     })
 }


    $('.select2').select2();
    $(function () {
        //Date picker
        $('.datepicker').datepicker({
            autoclose: true,
            format: 'yyyy/mm/dd'
        })
    });



    $('#office_change').on('click', function () {
        var role_id =$("#belong_roles_list option:selected").val();
        var office_id =$("#belong_office_list option:selected").val();
        window.location = '/office_change/' + office_id + '/' + role_id;
    });


    

  function sendNoticationCustom(id){
                  $.ajax({
                          type: "GET",
                          url: '/management/send_custom_notifications/'+id,
                              beforeSend: function(){ ColoredLoader('post_tr'+id,"Sending Notication..."); },
                          complete: function(){ $('#post_tr'+id).preloader('remove');},
                          success: function (data) {
                            if(data.error){
                                swal("Error",data.error,"error");
                                return false;
                              }else{
                                swal("Done!",data,"success");

                                $('.sentnotification_'+id).remove();
                              }
                          },
                      });
        }




    function changeOffice() {
        $('#CurrentOffice').modal('show');
    }

    


    function ColoredLoader(idSelector, passedText = "Loading..") {

        var someBlock = $('#' + idSelector);
        someBlock.preloader({
            text: passedText,
        });

}



  function ColoredLoader2(idSelector, passedText = "Loading..") {

        var someBlock = $(idSelector);
        someBlock.preloader({
            text: passedText,
        });

}


  function send_pantient(pantient_id){
                $.ajax({
                  type: "GET",
                  url: '/send_patient/'+pantient_id,
                  success: function (data) {
                    $(".shared_modal_div_append").replaceWith(data);
                    $(".patient_id_input").val(pantient_id);
                    $('#shared_modal').modal('show');
                    $('.select2').select2();
                    alert
                  },
                      });
        }

    function reinitializeItemSearch(){
        $(".item_search_ajax").select2({
            ajax: {
                url: "/search_item",
                type: "GET",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        name: params.term // search term
                    };
                },
                processResults: function (users) {
                    return {
                        results: $.map(users, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true

            },
            minimumInputLength: 3,
        });
    }


     // searching patientsww
  $(".ajax_users_all_search").select2({
      ajax: { 
       url: "/management/ajax_users_all_services",
       type: "GET",
       dataType: 'json',
       delay: 250,
       data: function (params) {
      
        return {
          name: params.term // search term
        };
       },
        processResults: function (users) {
          return {
            results:  $.map(users, function (item) {
                  return {
                      text: "("+ item.username+")",
                      id: item.id_yangu
                  }
              })
          };
        },
       cache: true
      },
      minimumInputLength: 1,
    });

  $(document).on("change",".ajax_users_all_search",function(){
    var id = $(this).val();
    window.location = "/management/view_user_route/"+id;
  })


    $(".item_search_ajax").select2({
        ajax: {
            url: "/search_item",
            type: "GET",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    name: params.term // search term
                };
            },
            processResults: function (users) {
                return {
                    results: $.map(users, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true

        },
        minimumInputLength: 3,
    });

   $(".stock_item_item_search_ajax").select2({
       ajax: {
           url: "/ajax-search-stock",
           type: "GET",
           dataType: 'json',
           delay: 250,
           data: function (params) {
               return {
                   name: params.term // search term
               };
           },
           processResults: function (users) {
               return {
                   results: $.map(users, function (item) {
                       console.log(item);
                       return {
                           text: item.item.name+" ("+item.quantity+")",
                           id: item.id,
                       }
                   })
               };
           },
           cache: true

       },
       minimumInputLength: 3,
   });


    $(".select_supplier_two").select2({
        ajax: {
            url: "/search_supplier",
            type: "GET",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    name: params.term // search term
                };
            },
            processResults: function (users) {
                return {
                    results: $.map(users, function (supplier) {
                        return {
                            text: supplier.name+' :: ('+supplier.person+')',
                            id: supplier.id
                        }
                    })
                };
            },
            cache: true

        },
        minimumInputLength: 3,
    });


    $(".patients_search").select2({
        ajax: {
            url: "/ajax-search-patients",
            type: "GET",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    name: params.term // search term
                };
            },
            processResults: function (users) {
                return {
                    results: $.map(users, function (item) {
                        return {
                            text: item.endorsement_number,
                            id: item.id
                        }
                    })
                };
            },
            cache: true

        },
        minimumInputLength: 3,
    });

    function diagnosisSearchInitialize(){
        $(".diagnoses_select")
            .select2({
                ajax: {
                    url: "/ajax-get-icd-codes",
                    type: "GET",
                    dataType: "json",
                    delay: 250,
                    data: function (params) {
                        return {
                            name: params.term, // search term
                        };
                    },
                    processResults: function (icd_codes) {
                        return {
                            results: $.map(icd_codes, function (icd) {
                                return {
                                    text: icd.name + "  ["+ icd.code+"]",
                                    id: icd.id,
                                };
                            }),
                        };
                    },
                    cache: true,
                },
                minimumInputLength: 2,
            });
    }


   $(".diagnoses_select")
  .select2({
    ajax: {
      url: "/ajax-get-icd-codes",
      type: "GET",
      dataType: "json",
      delay: 250,
      data: function (params) {
        return {
          name: params.term, // search term
        };
      },
      processResults: function (icd_codes) {
        return {
          results: $.map(icd_codes, function (icd) {
            return {
              text: icd.name + "  ["+ icd.code+"]",
              id: icd.id,
            };
          }),
        };
      },
      cache: true,
    },
    minimumInputLength: 2,
  });



    function reinitializeLabSerch(){
        $(".examinations_labtest_select")
            .select2({
                ajax: {
                    url: "/ajax-examinations-labtest",
                    type: "GET",
                    dataType: "json",
                    delay: 250,
                    data: function (params) {
                        return {
                            name: params.term, // search term
                        };
                    },
                    processResults: function (service) {
                        return {
                            results: $.map(service, function (icd) {
                                return {
                                    text: icd.name,
                                    id: icd.id,
                                };
                            }),
                        };
                    },
                    cache: true,
                },
                minimumInputLength: 3,
            });
    }

   $(".examinations_labtest_select")
  .select2({
    ajax: {
      url: "/ajax-examinations-labtest",
      type: "GET",
      dataType: "json",
      delay: 250,
      data: function (params) {
        return {
          name: params.term, // search term
        };
      },
      processResults: function (service) {
        return {
          results: $.map(service, function (icd) {
            return {
              text: icd.name,
              id: icd.id,
            };
          }),
        };
      },
      cache: true,
    },
    minimumInputLength: 3,
  });


   $(".dressing_select")
  .select2({
    ajax: {
      url: "/ajax-dressing-select",
      type: "GET",
      dataType: "json",
      delay: 250,
      data: function (params) {
        return {
          name: params.term, // search term
        };
      },
      processResults: function (service) {
        return {
          results: $.map(service, function (icd) {
            return {
              text: icd.name,
              id: icd.id,
            };
          }),
        };
      },
      cache: true,
    },
    minimumInputLength: 3,
  });


   $(".medical_search")
  .select2({
    ajax: {
      url: "/ajax-medical",
      type: "GET",
      dataType: "json",
      delay: 250,
      data: function (params) {
        return {
          name: params.term, // search term
        };
      },
      processResults: function (service) {
        return {
          results: $.map(service, function (dawa) {
            return {
              text: dawa.name,
              id: dawa.id,
            };
          }),
        };
      },
      cache: true,
    },
    minimumInputLength: 3,
  });



   $(".surgery_search")
  .select2({
    ajax: {
      url: "/ajax-surgery_search",
      type: "GET",
      dataType: "json",
      delay: 250,
      data: function (params) {
        return {
          name: params.term, // search term
        };
      },
      processResults: function (service) {
        return {
          results: $.map(service, function (dawa) {
            return {
              text: dawa.name,
              id: dawa.id,
            };
          }),
        };
      },
      cache: true,
    },
    minimumInputLength: 3,
  });


 $(".medical_item_search")
  .select2({
    ajax: {
      url: "/ajax-medical-items",
      type: "GET",
      dataType: "json",
      delay: 250,
      data: function (params) {
        return {
          name: params.term, // search term
        };
      },
      processResults: function (service) {
        return {
          results: $.map(service, function (icd) {
            return {
              text: icd.name,
              id: icd.id,
            };
          }),
        };
      },
      cache: true,
    },
    minimumInputLength: 3,
  });





    $(".user_search").select2({
        ajax: {
            url: "/ajax-search-users",
            type: "GET",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    name: params.term // search term
                };
            },
            processResults: function (users) {
                return {
                    results: $.map(users, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true

        },
        minimumInputLength: 3,
    });




    function ReuserSearch(){
        $(".user_search").select2({
        ajax: {
         url: "/ajax-search-users",
         type: "GET",
         dataType: 'json',
         delay: 250,
         data: function (params) {
          return {
            name: params.term // search term
          };
         },
          processResults: function (users) {
            return {
              results:  $.map(users, function (item) {
                    return {
                        text: item.name,
                        id: item.id,
                    }
                })
            };
          },
         cache: true
        },
        minimumInputLength: 3,
      });

    }

    // Going to that patient profile
    $('#patients_search').on('change', function () {
        var id = $(this).val(); // get selected value

        if (id != '') { // require a URL
                window.location = '/underwritings/' + id; // redirect
        }

    });

    function initializeRequired(){
        $(".form-control").each(function () {
            var required = $(this).attr('required');
            if (typeof required !== typeof undefined && required !== false) {
                var label = $(this).parent().find('label');
                var name = label.html();
                label.html(name + "<i style=\"color:red; font-size:16px;\">*</i>");
            }
        });
    }

    jQuery(document).ready(function ($) {
        $(".form-control").each(function () {
            var required = $(this).attr('required');
            if (typeof required !== typeof undefined && required !== false) {
                var label = $(this).parent().find('label');
                var name = label.html();
                label.html(name + "<i style=\"color:red; font-size:16px;\">*</i>");
            }
        });
    });


    //submit  form
    $(document).on('submit', '#report_form_unique_for_investigation', function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formdata = new FormData(this);
        $.ajax({
            type: "POST",
            url: '/submit_investigation_report',
            processData: false,
            contentType: false,
            data: formdata,
            beforeSend: function () {
                ColoredLoader('report_form_unique_for_investigation', "Saving...");
            },
            complete: function () {
                $('#report_form_unique_for_investigation').preloader('remove');
            },
            success: function (data) {
                // console.log(data);
                $('#edit-provide-service-report-modal').modal('hide');
                document.getElementById("report_form_unique_for_investigation").reset();
                $('.prevent-resubmit-button').prop("disabled", false);
                $('.prevent-resubmit-button').html('Submit');

                if(data.error){
                    swal_info_alert('Fail',data.error,'error');
                    return false;
                }
                    snackbartext('success','Service Report Saved  Successfully');
                    if(data){
                        $('#' + data + 'investigation_status').attr('class', 'btn btn-info');
                        $('#' + data + 'investigation_status').html('On-Going');
                        $('#' + data + 'cancel_button').remove();
                        $('#' + data + 'fill_service_report_btn').html("<i class=\"fa fa-file-pdf-o\"></i>&nbsp;Filled");
                        $('#' + data + 'fill_service_report_btn').attr('class', 'btn btn-xs btn-primary');
                        $('#' + data + 'add_usage_service_btn').toggle('slow');
                        $('#' + data + 'view_result_usage_service_btn').toggle('slow');
                        $('#' + data + 'release_toggle_div').toggle('slow');
                }


            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.prevent-resubmit-button').prop("disabled", false);
                $('.prevent-resubmit-button').html('Submit');
                show_alert_dev();
            }
        });
    });

    function viewInvestigationResultWidgets(id) {
        $.ajax({
            type: "GET",
            url: '/get_investigation_report_widgets/' + id,
            success: function (data) {
                // console.log(data[0]);
                $("#service_investigation_report_content").html(data[0]);
                $("#report_payment_name_span").html(data[1]);
                $('.toggle-bootstrap-custom').bootstrapToggle();
                initializeSummernote();
                $('#edit-provide-service-report-modal').modal('show');
            },
        })
    }

    function viewInvestigationReportView(id) {
        $.ajax({
            type: "GET",
            url: '/get_result_report/' + id,
            success: function (data) {
                $("#report_result_partial_append_body").html(data);
                $('#reprot-result-service-report-modal').modal('show');
            },
        })
    }


    function generalModel(modal_name) {
        $(`
<div class="modal fade" id="general-modal">
  <div class="modal-dialog modal-lg">
    <div class="box box-primary">
      <div class="box-header with-border">
        <button type="button" id="close_model" class="close close_general_modal" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
         <br>
        <h3 class="box-title" style="text-transform:capitalize;">${modal_name.replace(/_/g, ' ')}</h3>
      </div>

 <div class="modal-body">
     <section class="content">

 <div class="row">
         <div class="col-md-4">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Add ${modal_name.replace(/_/g, ' ')}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
        <form id="submit_general_modal_form">
        <div class="box-body">
        <div class="form-group">
        <label for="name">Name<span class="red">*</span></label>
        <input type="text" name="general_modal_name" placeholder="Name" class="form-control" id="" required>
        <input type="hidden" name="general_modal_modal" value="${modal_name}">
        </div>


        <div class="form-group">
        <label for="exampleInputPassword1">Description</label>
        <textarea name="general_modal_description" id="general_modal_description" class="form-control autogrow" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;"></textarea>
        </div>
        </div>
            <!-- /.box-body -->
        <div class="box-footer">
        <button type="reset" class="btn btn-default">Reset</button>
        <button type="submit" class="btn btn-success general_modal_form pull-right" id='general_modal_form'>Submit</button>
        </div>
        </form>
        </div>
            <!-- /.box -->
        </div>

        <div class="col-md-8">
        <div class="box box-primary">
        <div class="box-header">
        <h3 class="box-title"> ${modal_name.replace(/_/g, ' ')} List</h3>
        </div>
            <!-- /.box-header -->
        <div class="box-body">
        <table class="data-table table table-striped ">
        <thead>
        <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Actions</th>
        </tr>
        </thead>
        <tbody id="added_td">

        </tbody>
        </table>
        </div>
        </div>
        </div>
            <!-- /.box-body -->
        </div>
            <!-- /.row -->

        </section>
        </div>
            <!-- /.modal-content -->
        </div>
            <!-- /.modal-dialog -->
        </div>
        </div>
            <!-- /.modal -->`
    ).modal('show');
    var _token = $('meta[name="csrf-token"]').attr('content');
    $.get('/'+modal_name, function(data){
      $.each(data, function(index,item){
                 $('#added_td').append(
        ` <tr class="td_${item.id}">
        <td id="name_${item.id}">${item.name}</td>
        <td id="description_${item.id}">${item.description}</td>
        <td>
            <a href="javascript:void(0)" class="btn btn-primary btn-sm edit_general_modal"  id='${item.id}' name='${item.name}' description='${item.description}'  type="button" data-toggle="tooltip" title="Edit Data" data-original-title="Edit"><i class="fa fa-pencil" style="color:white"></i></a>

     <a href="javascript:void(0)" class="btn btn-danger btn-sm deleteThis" data-table="${modal_name}" data-id="${item.id}" type="button" data-toggle="tooltip" title="Delete Data" data-original-title="View"><i class="fa fa-trash" style="color:white"></i></a>
        </td>
        </tr> `);
        }

    );
    reUseDatatable();
    })
    ;

    }
 // <a href="javascript:;" id='${item.id}' name='${item.name}' description='${item.description}' class="edit_general_modal blue"><i class="fa fa-pencil"></i></a>  &nbsp; | &nbsp;
        // <a href="javascript:void(0)" class="btn btn-danger btn-sm deleteThis" data-table="${modal_name}" data-id="${item.id}" type="button" data-toggle="tooltip" title="Delete Data" data-original-title="View"><i class="fa fa-trash" style="color:red"></i></a>

    $(document).on('submit', '#submit_general_modal_form', function (e) {
        e.preventDefault();
        var name = $('input[name="general_modal_name"]').val();
        var description = $('#general_modal_description').val();
        var modal = $('input[name="general_modal_modal"]').val();
        var _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: "POST",
            url: '/' + modal,
            data: {_token: _token, description: description, name: name},
            success: function (data) {
                $('#added_td').prepend(`<tr class="td_${data.id}">
                                      <td id="name_${data.id}">${data.name}</td>
                                      <td id="description_${data.id}">${data.description}</td>
                                     <td>
                                       <a href="javascript:void(0)" class="btn btn-primary btn-sm edit_general_modal"  id='${data.id}' name='${data.name}' description='${data.description}'  type="button" data-toggle="tooltip" title="Edit Data" data-original-title="Edit"><i class="fa fa-pencil" style="color:white"></i></a>

     <a href="javascript:void(0)" class="btn btn-danger btn-sm deleteThis" data-table="${modal}" data-id="${data.id}" type="button" data-toggle="tooltip" title="Delete Data" data-original-title="View"><i class="fa fa-trash" style="color:white"></i></a>




                                     </td>
                                    </tr> `);
                $('input[name=general_modal_name]').val('');
                $('#general_modal_description').val('');
                // reUseDatatable();
            },

            error: function (xhr, ajaxOptions, thrownError) {
                //On error, we alert user
                // var err = eval("(" + xhr.responseText + ")");
                // show_alert('danger', xhr.responseText);
                console.log(xhr.responseText);
            }
        });
    });

    $(document).on('click', '.edit_general_modal', function () {
        var tr = $(this).closest('tr'),
            id = $(this).attr('id');
        name = $(this).attr('name');
        description = $(this).attr('description');
        $('input[name=general_modal_name]').val(name);
        $('#general_modal_description').val(description);
        $("#general_modal_form").html('Update');
        $("form#submit_general_modal_form").prop('id', 'update_general_modal_form');
        $('#general_modal_description').append(`<input type="hidden" name="general_modal_id" value="${id}">`);
    });


    $(document).on('click', '.close_general_modal', function () {
            location.reload();
        });

    $(document).on('submit', '#update_general_modal_form', function (e) {
        e.preventDefault();
        var name = $('input[name="general_modal_name"]').val();
        var description = $('#general_modal_description').val();
        var modal = $('input[name="general_modal_modal"]').val();
        var _token = $('meta[name="csrf-token"]').attr('content');
        var id = $('input[name="general_modal_id"]').val();
        // console.log(id);
        $.ajax({
            type: "PATCH",
            url: '/' + modal + '/' + id,
            data: {_token: _token, description: description, name: name},
            success: function (data) {
                $(".td_" + id).replaceWith(`<tr class="td_${data.id}">
                                      <td id="name_${data.id}">${data.name}</td>
                                      <td id="description_${data.id}">${data.description}</td>
                                     <td>

                                       <a href="javascript:void(0)" class="btn btn-primary btn-sm edit_general_modal"  id='${data.id}' name='${data.name}' description='${data.description}'  type="button" data-toggle="tooltip" title="Edit Data" data-original-title="Edit"><i class="fa fa-pencil" style="color:white"></i></a>

     <a href="javascript:void(0)" class="btn btn-danger btn-sm deleteThis" data-table="${modal}" data-id="${data.id}" type="button" data-toggle="tooltip" title="Delete Data" data-original-title="View"><i class="fa fa-trash" style="color:white"></i></a>
     </td>
                                    </tr> `);

                show_alert('success', 'The ' + name + ' has been Updated successful');
                $('input[name=general_modal_name]').val('');
                $('#general_modal_description').val('');
                $('input[name=general_modal_id]').remove();
                $("#general_modal_form").html('Submit');
                $("form#update_general_modal_form").prop('id', 'submit_general_modal_form');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                //On error, we alert user
                // var err = eval("(" + xhr.responseText + ")");
                //console.log(xhr.responseText);
                // show_alert('danger', xhr.responseText);
                console.log(xhr.responseText);
            }
        });
    });
    $(document).on('click', '#close_model', function () {
        $('#general-modal').modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        $('#general-modal').remove();
    });



     $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });


         function reinitializeLDatetimepicker(){
             $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });
         }
</script>

