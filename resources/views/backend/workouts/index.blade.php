@extends('main')
@section('css')
 <link rel="stylesheet" href="{{ url('/') }}/assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="{{ url('/') }}/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
@endsection
@section('content')
	<section class="content-header">
      <h1>
        {{{ $vars['title'] }}}
        <small>{{{ $vars['sub_title'] }}}</small>
     <button type="button" class="btn btn-primary pull-right Add_workouts"><i class="fa fa-plus"></i> Add Workouts</button>
      </h1>
    </section>

    <section class="content">

      <div class="row">
         <div class="col-md-3">
           <div class="box box-primary">
            <div class="box-header">
              Date:
            </div>
              <div class="box-body">
             <div id="datepicker"></div>

             {{-- <input type="text" class="form-control pull-right" id="datepicker"> --}}
             </div>
         </div>
         </div>

         <div class="col-md-9">
            <div class="box box-primary">
            
                 <div class="box-header">
                   
                </div>
                 <div class="box-body" id="timeline">
                <ul class="timeline timeline-inverse"  id="day_workout_div">
                  
                </ul>
              </div>
             
            
         </div>
         </div>
        
      </div>

 

  





       <div class="modal fade" id="AddworkoutsModal">
      <div class="modal-dialog modal-lg">
        <div class="box box-primary">
              <div class="box-header with-border">
                <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                  <br>
                  <h3 class="box-title">Add Workout</h3>
                  <div class="pull-right">

                  </div>
              </div>
             <form class="prevent-resubmit-form" id="create_workout_form" enctype="multipart/form-data">
             @csrf
               <div class="box-body ">
                <div class="row">

                <div class="form-group col-md-4">
                <label>Workout Category</label>
                <select class="form-control select2" name="circuit" style="width: 100%;" required>
                  <option></option>
                   @foreach(\App\Models\workout::category() as $cat)
                      <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
              </div>

                  <div class="form-group col-md-4">
                  <label>Workout Title</label>
                  <input class="form-control" type="text"  name="name">
                </div>


                   <div class="form-group col-md-4">
                  <label>Date</label>
                  <input class="form-control datepicker" type="text" id="pick_date" name="date" required autocomplete="false" >
                </div>
                </div>


                <div class="form-group col-md-4">
                <label>Workout Image link</label><br>
                <input class="form-control" type="text"  name="img_url">
                  {{-- <input type="file" class="form-control" name="img" required> --}}
              </div>

              <div class="form-group col-md-4">
                <label>Workout Video link</label><br>
                <input class="form-control" type="text"  name="video_url">
                  {{-- <input type="file" class="form-control" name="img" required> --}}
              </div>

               

                 <div class="form-group col-md-4">
                  <label>Exercise Time</label>  
                  {{-- <input class="form-control" type="number" name="exercise_time"> --}}
                  <input type="time" class="form-control"  name="exercise_time"/>
                </div>

{{-- 
                <div class="form-group col-md-4">
                  <label>Serves (person)</label>  
                  <input class="form-control" type="number" name="person">
                </div>
 --}}

                 <div class="form-group col-md-12">
                  <label>Description</label>
                  <textarea id="compose-textarea" name="description" class="form-control" style="height: 200px"> </textarea>
                </div>
              </div>
                        <div class="box-footer">
                          <div class="pull-right">
                            <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-send"></i> Save </button>
                          </div>
                        </div>
                </form>
        </div>
      </div>
    </div>


    <div class="modal fade" id="Edit_workout_class_modal">
    <div class="modal-dialog modal-lg">
    <div class="box box-primary" id="edit_workouts_modal">

    </div>
          <!-- /.box -->
    </div>
</div>



   <div class="modal fade" id="viewClassModal">
        <div class="modal-dialog modal-lg">
            <div class="box box-primary">
                <div class="box-header">
                    <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <br>
                    <h3 class="box-title" id="head_tittle">View Item</h3>
                </div>

                <div class="box-footer" id="rendered_view_item">
                </div>

            </div>
        </div>
    </div>
 

    </section>

 

@endsection


@section('js')
<script src="{{ url('/') }}/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script type="text/javascript">
 $(function () {
    //Add text editor
    $("#compose-textarea").wysihtml5();

  });
 $(document).on('click', '.viewTr', function () {
            var id = $(this).data("id");
            var date = $(this).data("date");
            var category = $(this).data("category");
            $.ajax({
                type: "GET",
                url: '/management/workouts/' + id,
                success: function (data) {
                    $('#rendered_view_item').replaceWith(data);
                    $('#head_tittle').html(date+' '+category);
                    $('#viewClassModal').modal('show');
                },
            });
        });

$(document).ready(function(){
 $('#pick_date').datepicker({ dateFormat: 'yyyy-mm-dd' });

$('.datepicker').on('click', function(e) {
   e.preventDefault();
   $(this).attr("autocomplete", "off");  
});

$("#datepicker").datepicker({
    dateFormat: 'dd/mm/yy'
}).on("changeDate", function (e) {
  currentDate = $( "#datepicker" ).datepicker( "getDate" );
   get_workouts_dates(convert(currentDate));
});
});


function convert(str) {
  var date = new Date(str),
    mnth = ("0" + (date.getMonth() + 1)).slice(-2),
    day = ("0" + date.getDate()).slice(-2);
  return [day, mnth, date.getFullYear()].join("-");
}


function get_workouts_dates(date) {
  $.ajax({
        type: "GET",
        url: '/management/workouts_dates/'+date,
        beforeSend: function(){ ColoredLoader('day_workout_div',"Loading..."); },
        complete: function(){ $('#day_workout_div').preloader('remove');},
        success: function (data) {
          $("#day_workout_div").replaceWith(data);
        }
         });
}


 // currentDate = $( "#datepicker" ).datepicker( "getDate" );


  
$(".Add_workouts").click(function() {
     $('#AddworkoutsModal').modal('show');
  });


$(document).on('submit', '#create_workout_form', function(e){
       e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var textarea = $('#compose-textarea').val();

        if(textarea == ''){
           swal('Error!','Description can not be null','error');
                        return false; 
        }

        var pick_date = $('#pick_date').val();
        var formdata = new FormData(this);
            $.ajax({
                type: "POST",
                url: '/management/workouts',
                processData: false,
                contentType: false,
                data: formdata,
               beforeSend: function(){ ColoredLoader('create_workout_form',"Saving..."); },
              complete: function(){ $('#create_workout_form').preloader('remove');},
              success: function (data) {
                $('.select2').val('').trigger("change");
                  $("#workouts_table").append(data);
                   document.getElementById("create_workout_form").reset();
                    snackbartext('success','Workout Saved Succcesfully');
                   $('.close').click();
                   get_workouts_dates(convert(pick_date));
                 },
                error: function (xhr, ajaxOptions, thrownError){
                   $('.prevent-resubmit-button').prop("disabled", false);
                   $('.prevent-resubmit-button').html('Submit');
                    close_modal('guardian_create_model');
                     show_alert('danger', xhr.responseText);
            }
            });
          });




$(document).on('submit', '#edit_workout_form', function(e){
       e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


         var textarea = $('#edit-textarea').val();

        if(textarea == ''){
           swal('Error!','Description can not be null','error');
                        return false; 
        }

      var url =  $('#edit_workout_form').attr('action');

        var pick_date_edit = $('#pick_date_edit').val();
        var formdata = new FormData(this);
            $.ajax({
                type: "POST",
                url: url,
                processData: false,
                contentType: false,
                data: formdata,
               beforeSend: function(){ ColoredLoader('edit_workout_form',"Saving..."); },
              complete: function(){ $('#edit_workout_form').preloader('remove');},
              success: function (data) {
                $('.select2').val('').trigger("change");
                  $("#workouts_table").append(data);
                   document.getElementById("edit_workout_form").reset();
                    snackbartext('success','Workout Saved Succcesfully');
                   $('.close').click();
                   // window.location.reload();
                   get_workouts_dates(convert(pick_date_edit));
                 },
                error: function (xhr, ajaxOptions, thrownError){
                   $('.prevent-resubmit-button').prop("disabled", false);
                   $('.prevent-resubmit-button').html('Submit');
                    close_modal('guardian_create_model');
                     show_alert('danger', xhr.responseText);
            }
            });
          });


  $(document).on('click', '.editTr', function(){
     var id = $(this).data("id");
    $.ajax({
        type: "GET",
        url: '/management/workouts/'+ id +'/edit',
        success: function (data) {
            $("#edit_workouts_modal").replaceWith(data);

            var content = $('#edit-textarea');
var contentPar = content.parent()
contentPar.find('.wysihtml5-toolbar').remove()
contentPar.find('iframe').remove()
contentPar.find('input[name*="wysihtml5"]').remove()
content.show()
 $("#edit_workouts_modal").replaceWith(data);
// $('#edit-textarea').val('');
$("#edit-textarea").wysihtml5();


            // $("#edit-textarea").wysihtml5();
            $('#pick_date_edit').datepicker({ dateFormat: 'yyyy-mm-dd' });
            $('#Edit_workout_class_modal').modal('show');
        },
            });
        });


  $(document).on('click', '.deleteworkout', function () {
    var id = $(this).data("id");
    var address = $(this).data("address");
    var token = $('meta[name="csrf-token"]').attr('content');
    var force = $(this).data("force");
    var $tr = $(this).closest("li#workout_list_"+id);
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
</script>

@endsection
