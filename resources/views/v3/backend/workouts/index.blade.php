@extends('v3.backend.layouts.app')

@section('title') Workouts | {{\App\Models\SysConfig::set()['system_title']}} @endsection

@section('css')

<style type="text/css">
    .latest-update-card .card-block .latest-update-box:after{
        top: 25px !important;
    }
    .latest-update-card .card-block .latest-update-box .update-meta .update-icon.bg-primary{
        box-shadow: 0 0 0 4px #007bff61;
    }
    .latest-update-card .card-block .latest-update-box .update-meta .update-icon.bg-warning{
        box-shadow: 0 0 0 4px #fb634075;
    }
</style>
@endsection

@section('content')

<div class="page-header">
  <div class="row align-items-end">
     <div class="col-lg-8">
        <div class="page-header-title">
           <i class="ik ik-watch bg-blue"></i>
           <div class="d-inline">
              <h5>{{ $vars['title'] }}</h5>
              <span>Here you can view and edit Workouts.</span>
          </div>
      </div>
  </div>
  <div class="col-lg-4">
    <nav class="breadcrumb-container" aria-label="breadcrumb">
       <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="#"><i class="ik ik-home"></i></a>
         </li>
         <li class="breadcrumb-item">
             <a href="#">Workouts</a>
         </li>
         <li class="breadcrumb-item active" aria-current="page">List of Workouts</li>
     </ol>
 </nav>
</div>
</div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-4">
        <div class="card new-cust-card">
            <div class="card-header m-auto">
                <button class="btn btn-dark" data-toggle="modal" data-target="#AddworkoutsModal"><i class="ik ik-plus-square"></i>Add New Workouts</button>
            </div>
            <div class="card-body">
                <div id="datepickerwidget"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-md-8">
        <div class="card latest-update-card">
            <div class="loader br-4">
                <i class="ik ik-refresh-cw loading"></i>
            </div>
            <div class="card-block" id='day_workout_div' style="min-height: 450px;">
                
            </div>
        </div>
    </div>
</div>

<div class="createOrEditModel">

    {{-- START::CREATE Workout MODAL --}}
    <div class="modal fade full-window-modal" id="AddworkoutsModal" tabindex="-1" role="dialog" aria-labelledby="AddworkoutsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="loader br-4">
                <i class="ik ik-refresh-cw loading"></i>
            </div>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddworkoutsModalLabel">Add New Workouts</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    
                </div>
                <div class="modal-body">
                    <form class="prevent-resubmit-form" id="create_workout_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-4">
                            <label>Workout Category</label>
                            <select class="form-control select2" name="circuit" required>
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
                            <input class="form-control datetimepicker-input"
                             data-toggle="datetimepicker" data-target="#pick_date"
                             type="text" id="pick_date" name="date" required autocomplete="false" >
                            </div>

                            <div class="form-group col-md-4">
                            <label>Workout Image link</label><br>
                            <input class="form-control" type="text"  name="img_url">
                            {{-- <input type="file" class="form-control" name="img" required> --}}
                            </div>

                            <div class="form-group col-md-4">
                                <label>Workout Video link</label><br>
                                <input class="form-control" type="text"  name="video_url">
                            </div>

                            <div class="form-group col-md-4">
                                <label>Exercise Time</label>  
                                <input type="time" class="form-control"  name="exercise_time"/>
                            </div>

                            <div class="form-group col-md-12">
                                <label>Description</label>
                                <textarea id="compose-textarea" name="description" class="form-control editor" style="height: 200px"  > </textarea>
                            </div>

                            <div class="form-group col-md-12 text-right">
                                <button type="submit" class="btn btn-primary"><i class="ik ik-save"></i> Submit </button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ik ik-x"></i> Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- END::CREATE Workout MODAL --}}

    {{-- START::EDIT Workout MODAL --}}
    <div class="modal fade full-window-modal" id="Edit_workout_class_modal" tabindex="-1" role="dialog" aria-labelledby="Edit_workout_class_modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="loader br-4">
                <i class="ik ik-refresh-cw loading"></i>
            </div>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Edit_workout_class_modalLabel">Edit Workout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="edit_workouts_modal">
                </div>
            </div>
        </div>
    </div>
    {{-- END::EDIT Workout MODAL --}}

    {{-- START::VIEW Workout MODAL --}}
    <div class="modal fade full-window-modal" id="viewClassModal" tabindex="-1" role="dialog" aria-labelledby="viewClassModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="loader br-4">
                <i class="ik ik-refresh-cw loading"></i>
            </div>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewClassModalLabel">Edit Workout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="rendered_view_item">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ik ik-x"></i> Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END::VIEW Workout MODAL --}}
</div>

@endsection

@section('js')
<script type="text/javascript">
$(document).ready(function(e){
    editorInit();
})

function editorInit(){
    $(document).find('.editor').summernote({
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ],
        height: 200,
        tabsize: 2
    });
}

$(document).find('.datetimepicker-input').datetimepicker({
    format: 'L'
});

$("#datepickerwidget").on('change.datetimepicker',function(data){
    currentDate = moment(data.date).format('DD-MM-YYYY');
    get_workouts_dates(currentDate);
});

//SHOW WORKOUT MODAL HANDLER
$(document).on('click', '.viewTr', function () {
    var id = $(this).data("id");
    var date = $(this).data("date");
    var category = $(this).data("category");

    showUrl = "{{ route('workouts.show',':id') }}";
    showUrl = showUrl.replace(':id', id);

    $.ajax({
        type: "GET",
        url: showUrl, //'/management/workouts/' + id,
        success: function (data) {
            $('#rendered_view_item').html(data);
            $('#viewClassModalLabel').html(date+' '+category);
            $('#viewClassModal').modal('show');
        },
    });
});

// GET WORKOUT ON CHOOSE DATE AJAX HANDLER
function get_workouts_dates(date) {
    getDataUrl = "{{ route('workouts.Workouts_dates',':date') }}"; 
    getDataUrl = getDataUrl.replace(':date', date);

    $.ajax({
        type: "GET",
        url: getDataUrl, //'/management/workouts_dates/'+date,
        beforeSend: function(){ 
            // ColoredLoader('day_workout_div',"Loading..."); 
            $("div.loader").removeClass('hidden');
        },
        complete: function(){ 
            // $('#day_workout_div').preloader('remove');
            $("div.loader").addClass('hidden');
        },
        success: function (data) {
            $("#day_workout_div").html(data);
        }
    });
}

//STORE WORKOUT HANDLER
$(document).on('submit', '#create_workout_form', function(e){
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var textarea = $('#compose-textarea').val();
    if(textarea == ''){
        showToast('Error!','Description can not be null','error');
        return false; 
    }
    var pick_date = $('#pick_date').val();
    var formdata = new FormData(this);
    $.ajax({
        type: "POST",
        url: "{{ route('workouts.store') }}", //'/management/workouts',
        processData: false,
        contentType: false,
        data: formdata,
        beforeSend: function(){ 
            $("div.loader").removeClass('hidden');
        },
        complete: function(){ 
            $("div.loader").addClass('hidden');
        },
        success: function (data) {
            showToast('Success','Workout Saved Succcesfully','success');
            document.getElementById("create_workout_form").reset();
            get_workouts_dates(moment(pick_date).format('DD-MM-YYYY'));
            $("#AddworkoutsModal").modal('hide');
        },
        error: function (xhr, ajaxOptions, thrownError){
            $('.prevent-resubmit-button').prop("disabled", false);
            $('.prevent-resubmit-button').html('Submit');
            showToast('Error', xhr.responseText,'danger');
        }
    });
});

//EDIT WORKOUT FORM HANDLER
$(document).on('click', '.editTr', function(){
    var id = $(this).data("id");
    
    editFormUrl = "{{ route('workouts.edit',':id') }}"; 
    editFormUrl = editFormUrl.replace(':id', id);
    
    $.ajax({
        type: "GET",
        url: editFormUrl, //'/management/workouts/'+ id +'/edit',
        success: function (data) {
            $("#edit_workouts_modal").html(data);
            // $('#pick_date_edit').datepicker({ dateFormat: 'yyyy-mm-dd' });
            var defaultDateStr = $("#pick_date_edit").data("date-value");
            $(document).find('#pick_date_edit').datetimepicker({
                format: 'L',
                defaultDate : defaultDateStr
            });
            editorInit();
            $('#Edit_workout_class_modal').modal('show');
        },
    });
});

// UPDATE WORKOUT HANDLER
$(document).on('submit', '#edit_workout_form', function(e){
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var textarea = $('#edit-textarea').val();
    if(textarea == ''){
        showToast('Error!','Description can not be null','error');
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
        beforeSend: function(){ 
            $("div.loader").removeClass('hidden');
         },
        complete: function(){ 
            $("div.loader").addClass('hidden');
        },
        success: function (data) {
            showToast('Success','Workout update Succcesfully','success');
            get_workouts_dates(moment(pick_date_edit).format('DD-MM-YYYY'));
            document.getElementById("edit_workout_form").reset();
            $("#Edit_workout_class_modal").modal('hide');
        },
        error: function (xhr, ajaxOptions, thrownError){
            $('.prevent-resubmit-button').prop("disabled", false);
            $('.prevent-resubmit-button').html('Submit');
            showToast('Error', xhr.responseText,'danger');
        }
    });
});

// DELETE WORKOUT HANDLER
$(document).on('click', '.deleteworkout', function () {
    var id = $(this).data("id");
    var address = $(this).data("address");
    var token = $('meta[name="csrf-token"]').attr('content');
    var force = $(this).data("force");
    var $tr = $(this).closest("#workout_list_"+id);
    swalWithBootstrapButtons.fire({
        title: 'Are you sure you want to Delete this?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Delete it !!",
        cancelButtonText: "No, cancel it !!",
    }).then(function (result) {
        if(result.value == true){
            var destroyFormUrl = "{{ route('workouts.destroy',':id') }}";
            destroyFormUrl = destroyFormUrl.replace(':id', id);

            $.ajax(
            {
                url: destroyFormUrl, //"/management/" + address + "/" + id,
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
                        showToast(
                            'Deleted!',
                            'Workout has been deleted successful',
                            'success'
                            )
                    });
                    $('.tooltip').hide();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.responseText);
                }
            });
        }
    }, function (dismiss) {
        if (dismiss === 'cancel') {
            showToast(
                'Cancelled',
                'Your file is safe :)',
                'error'
                )
        }
    })
});
</script>
@endsection