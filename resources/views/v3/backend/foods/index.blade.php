@extends('v3.backend.layouts.app')

@section('title') Food | {{\App\Models\SysConfig::set()['system_title']}} @endsection

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
           <i class="ik ik-disc bg-blue"></i>
           <div class="d-inline">
              <h5>{{ $vars['title'] }}</h5>
              <span>Here you can view and edit Foods.</span>
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
             <a href="#">Foods</a>
         </li>
         <li class="breadcrumb-item active" aria-current="page">Menu</li>
     </ol>
 </nav>
</div>
</div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-4">
        <div class="card new-cust-card">
            <div class="card-header m-auto">
                <button class="btn btn-dark" data-toggle="modal" data-target="#AddfoodsModal"><i class="ik ik-plus-square"></i>Add New Food</button>
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
            <div class="card-block" id='day_food_div' style="min-height: 450px;">
                
            </div>
        </div>
    </div>
</div>

<div class="createOrEditModel">

    {{-- START::CREATE FOOD MODAL --}}
    <div class="modal fade full-window-modal" id="AddfoodsModal" tabindex="-1" role="dialog" aria-labelledby="AddfoodsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="loader br-4">
                <i class="ik ik-refresh-cw loading"></i>
            </div>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddfoodsModalLabel">Add New Food</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    
                </div>
                <div class="modal-body">
                    <form class="prevent-resubmit-form" id="create_food_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-4">
                            <label>Food Category</label>
                            <select class="form-control select2" name="category" style="width: 100%;" required>
                                <option></option>
                                @foreach(\App\Models\Food::category() as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                            </div>

                            <div class="form-group col-md-4">
                            <label>Food Title</label>
                            <input class="form-control" type="text"  name="name">
                            </div>

                            <div class="form-group col-md-4">
                            <label>Date</label>
                            <input class="form-control datetimepicker-input"
                             data-toggle="datetimepicker" data-target="#pick_date"
                             type="text" id="pick_date" name="date" required autocomplete="false" >
                            </div>

                            <div class="form-group col-md-4">
                            <label>Food Image link</label><br>
                            <input class="form-control" type="text"  name="img_url" required>
                            {{-- <input type="file" class="form-control" name="img" required> --}}
                            </div>

                            <div class="form-group col-md-4">
                            <label>Takes time (in minute)</label>  
                            <input class="form-control" type="number" name="takes_time">
                            </div>

                            <div class="form-group col-md-4">
                            <label>Serves (person)</label>  
                            <input class="form-control" type="number" name="person">
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
    {{-- END::CREATE FOOD MODAL --}}

    {{-- START::EDIT FOOD MODAL --}}
    <div class="modal fade full-window-modal" id="Edit_food_class_modal" tabindex="-1" role="dialog" aria-labelledby="Edit_food_class_modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="loader br-4">
                <i class="ik ik-refresh-cw loading"></i>
            </div>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Edit_food_class_modalLabel">Edit Food</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="edit_foods_modal">
                </div>
            </div>
        </div>
    </div>
    {{-- END::EDIT FOOD MODAL --}}

    {{-- START::VIEW FOOD MODAL --}}
    <div class="modal fade full-window-modal" id="viewClassModal" tabindex="-1" role="dialog" aria-labelledby="viewClassModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="loader br-4">
                <i class="ik ik-refresh-cw loading"></i>
            </div>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewClassModalLabel">Edit Food</h5>
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
    {{-- END::VIEW FOOD MODAL --}}
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
    get_foods_dates(currentDate);
});

//SHOW FOOD MODAL HANDLER
$(document).on('click', '.viewTr', function () {
    var id = $(this).data("id");
    var date = $(this).data("date");
    var category = $(this).data("category");

    showUrl = "{{ route('food.show',':id') }}";
    showUrl = showUrl.replace(':id', id);

    $.ajax({
        type: "GET",
        url: showUrl,//'/management/food/' + id,
        success: function (data) {
            $('#rendered_view_item').html(data);
            $('#viewClassModalLabel').html(date+' '+category);
            $('#viewClassModal').modal('show');
        },
    });
});

// GET FOOD ON CHOOSE DATE AJAX HANDLER
function get_foods_dates(date) {

    getDataUrl = "{{ route('food.foods_dates',':date') }}";
    getDataUrl = getDataUrl.replace(':date', date);

    $.ajax({
        type: "GET",
        url: getDataUrl, //'/management/foods_dates/'+date,
        beforeSend: function(){ 
            // ColoredLoader('day_food_div',"Loading..."); 
            $("div.loader").removeClass('hidden');
        },
        complete: function(){ 
            // $('#day_food_div').preloader('remove');
            $("div.loader").addClass('hidden');
        },
        success: function (data) {
            $("#day_food_div").html(data);
        }
    });
}

//STORE FOOD HANDLER
$(document).on('submit', '#create_food_form', function(e){
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
        url: "{{ route('food.store') }}",//'/management/food',
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
            $("#foods_table").append(data);
            showToast('Success','food Saved Succcesfully','success');
            document.getElementById("create_food_form").reset();
            get_foods_dates(moment(pick_date).format('DD-MM-YYYY'));
            $("#AddfoodsModal").modal('hide');
        },
        error: function (xhr, ajaxOptions, thrownError){
            $('.prevent-resubmit-button').prop("disabled", false);
            $('.prevent-resubmit-button').html('Submit');
            showToast('Error', xhr.responseText,'danger');
        }
    });
});

//EDIT FOOD FORM HANDLER
$(document).on('click', '.editTr', function(){
    var id = $(this).data("id");

    editFormUrl = "{{ route('food.edit',':id') }}"; 
    editFormUrl = editFormUrl.replace(':id', id);
    
    $.ajax({
        type: "GET",
        url: editFormUrl, //'/management/food/'+ id +'/edit',
        success: function (data) {
            $("#edit_foods_modal").html(data);
            // $('#pick_date_edit').datepicker({ dateFormat: 'yyyy-mm-dd' });
            var defaultDateStr = $("#pick_date_edit").data("date-value");
            $(document).find('#pick_date_edit').datetimepicker({
                format: 'L',
                defaultDate : defaultDateStr
            });
            editorInit();
            $('#Edit_food_class_modal').modal('show');
        },
    });
});

// UPDATE FOOD HANDLER
$(document).on('submit', '#edit_food_form', function(e){
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
    var url =  $('#edit_food_form').attr('action');
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
            showToast('Success','Food update Succcesfully','success');
            get_foods_dates(moment(pick_date_edit).format('DD-MM-YYYY'));
            document.getElementById("edit_food_form").reset();
            $("#Edit_food_class_modal").modal('hide');
        },
        error: function (xhr, ajaxOptions, thrownError){
            $('.prevent-resubmit-button').prop("disabled", false);
            $('.prevent-resubmit-button').html('Submit');
            showToast('Error', xhr.responseText,'danger');
        }
    });
});

// DELETE FOOD HANDLER
$(document).on('click', '.deleteFood', function () {
    var id = $(this).data("id");
    var address = $(this).data("address");
    var token = $('meta[name="csrf-token"]').attr('content');
    var force = $(this).data("force");
    var $tr = $(this).closest("#food_list_"+id);
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
            
            var destroyFormUrl = "{{ route('food.destroy',':id') }}";
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
                            'Food has been deleted successful',
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