@extends('main')
@section('css')
<style type="text/css">
.cursor-move{
    cursor: move;
}
</style>
@endsection
@section('content')
	<section class="content-header">
      <h1>
        {{{ $vars['title'] }}}
        <small>{{{ $vars['sub_title'] }}}</small>
         @if(\Auth::user()->userHasRole('admin')) 
         <button type="button" class="btn btn-primary pull-right Add_Categories"><i class="fa fa-plus"></i> Add Category</button>
 
         <button type="button" class="btn btn-warning pull-right Save_Arrangement"><i class="fa fa-save"></i> Save Arrangement</button>
         @endif
      </h1>
     
    </section>

    <section class="content">

 <div class="row" id="categories_table">

  @foreach($vars['categories'] as  $row)
  <div class="col-md-3 connectedSortable">
          <!-- DIRECT CHAT PRIMARY -->
          <div class="box box-primary direct-chat direct-chat-primary">    {{-- collapsed-box --}}
            <div class="box-header with-border">
              <h3 class="box-title">{{  $row->name }}</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>

                 @if(\Auth::user()->userHasRole('admin')) 
                <button type="button" class="btn btn-box-tool edit_categories" data-id="{{$row->id}}" data-toggle="tooltip" title="Edit Category" data-widget="chat-pane-toggle">
                  <i class="fa fa-pencil-square-o"></i></button>
                  
                   {{-- <button type="button" class="btn btn-box-tool  deletePanel" data-toggle="tooltip" title="Delete Category" data-address="categories" data-id="{{$row->id}}"><i class="fa fa-trash" style="color:red;"></i></button> --}}
              
                   @endif
                <button type="button" class="hidden btn btn-box-tool close_panel_{{ $row->id }}" data-widget="remove"></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding categories_divs">
              <div class="text-center">
                 <input type="checkbox" name="state" @if($row->state == "online") checked @endif  data-toggle="toggle" data-on="online"  data-off="offline" data-onstyle="success" class="category_state" value=" data-on?'online':'offline'" data-offstyle="danger"  data-width="90" data-size="mini"  data-id="{{$row->id}}">
                
              </div>
              <ul class="nav nav-pills nav-stacked" data-id="{{$row->id}}">
                {{-- <li><a href="#"><i class="fa fa-circle-o text-red"></i> Slug  <code style="font-size: 10px;"  class="pull-right">{{  $row->slug }}</code> </a></li> --}}
                {{-- <li><a href="#"><i class="fa fa-sticky-note-o text-yellow"></i> Post Associated  <span class="badge bg-light-blue pull-right">3</span></a></li> --}}
                <li><a href="#"><i class="fa fa-user text-light-blue"></i> Created By <span style="font-size: 12px;" class="pull-right">@if($row->enteredBy){{ $row->enteredBy->name }}@endif</span></a></li>
                <li><a href="#"><i class="fa fa-calendar text-green"></i> Created At <em style="font-size: 12px;" class="pull-right">{{  $row->created_at }}</em></a></li>

                {{-- <li><a href="#"><i class="fa fa-file-word-o  text-green"></i> Description</a></li> --}}
              </ul>
            </div>
            <!-- /.box-body -->
          {{--   <div class="box-footer">
               <em>{{  $row->description }}</em>
            </div> --}}
            <!-- /.box-footer-->
          </div>
          <!--/.direct-chat -->
        </div>
    @endforeach
     
</div>



          <div class="modal fade" id="AddCategoriesModal">
      <div class="modal-dialog modal-lg">
        <div class="box box-primary">
              <div class="box-header with-border">
                <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                  <br>
                  <h3 class="box-title">Add Categories</h3>
                  <div class="pull-right">

                  </div>
              </div>
             <form class="prevent-resubmit-form" id="create_category_form" enctype="multipart/form-data">
             @csrf
               <div class="box-body ">

              <div class="form-group">
                  <label>Category Name</label>
                  <input class="form-control" type="text" id="name_category" name="name" required >
                </div>

              {{--    <div class="form-group">
                        <label for="">Description</label>
                        <textarea  rows="3" name="description" class="form-control"  placeholder="Decsription.." ></textarea>
                    </div> --}}

              </div>
                        <div class="box-footer">
                          <div class="pull-right">
                            <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-send"></i> Save Category</button>
                          </div>
                        </div>
                </form>
        </div>
      </div>
    </div>


    


    <div class="modal fade" id="Edit_category_class_modal">
    <div class="modal-dialog">
    <div class="box box-primary" id="edit_categories_modal">

    </div>
          <!-- /.box -->
    </div>
</div>
    </section>

  

@endsection


@section('js')
<script src="{{ url('/') }}/assets/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->


<script type="text/javascript">

  $.widget.bridge('uibutton', $.ui.button);


  

  $(function () {

  'use strict';

  // Make the dashboard widgets sortable Using jquery UI
  $('.connectedSortable').sortable({
    placeholder         : 'sort-highlight',
    connectWith         : '.connectedSortable',
    handle              : '.box-header, .nav-tabs',
    forcePlaceholderSize: true,
    zIndex              : 999999
  });
  $('.connectedSortable .box-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move');
});

   $(".category_state").change(function() {
      var  category_state = "";
       var id = $(this).data("id");
          if($(this).prop("checked") == true){
                category_state = "online";
            }
            else if($(this).prop("checked") == false){
                category_state = "offline";
            }
            console.log([category_state,id]);
             $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

              var formdata = new FormData();
          formdata.append('category_state', category_state);
          formdata.append('id',id);

            $.ajax({
                  type: "POST",
                  url: '/management/category_state',
                  processData: false,
                  contentType: false,
                   data: formdata,
                   beforeSend: function(){ run_waitMe('win8_linear','category_state-div','Saving...'); },
                   complete: function(){ $('#category_state-div').waitMe("hide");},
                   success: function (data) {
                   if(data.error){
                      swal('Error!',
                             data.error,
                            'success'
                        );
                }
                   },

                  error: function (xhr, ajaxOptions, thrownError){
                  console.log(xhr.responseText);
              }
              });
  });



  $(".Add_Categories").click(function() {
     $('#AddCategoriesModal').modal('show');
  }); 

$(".Save_Arrangement").click(function() {
     $(".categories_divs > ul").each(function(index){
     var id = $(this).data("id");
     // console.log(index);
    

      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });

              var formdata = new FormData();
          formdata.append('arrangement', index+1);
          formdata.append('id',id);

            $.ajax({
                  type: "POST",
                  url: '/management/category_arrangement',
                  processData: false,
                  contentType: false,
                   data: formdata,
                   beforeSend: function(){ run_waitMe('win8_linear','categories_table','Saving...'); },
                   complete: function(){ $('#categories_table').waitMe("hide");},
                   success: function (data) {
                   if(data.error){

                      swal('Error!',
                             data.error,
                            'success'
                        );


                //       $('#error_sms').html(data.error);
                // $('#_error_modal').modal('show');
                }
                   },

                  error: function (xhr, ajaxOptions, thrownError){
                  console.log(xhr.responseText);
              }
              });
  });
  }); 




function convertToSlug(Text)
{
    return Text
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')
        ;
}



      $(document).on('submit', '#create_category_form', function(e){
       e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formdata = new FormData(this);
        // formdata.append('status','');
            $.ajax({
                type: "POST",
                url: '/management/categories',
                processData: false,
                contentType: false,
                data: formdata,
               beforeSend: function(){ ColoredLoader('create_category_form',"Saving..."); },
              complete: function(){ $('#create_category_form').preloader('remove');},
              success: function (data) {
                $("#categories_table").append(data);
                    snackbartext('success','Category Saved Succcesfully');
                   $('.close').click();
                 },
                error: function (xhr, ajaxOptions, thrownError){
                   $('.prevent-resubmit-button').prop("disabled", false);
                   $('.prevent-resubmit-button').html('Submit');
                    close_modal('guardian_create_model');
                     show_alert('danger', xhr.responseText);
            }
            });
          });

      
  $(document).on('click', '.edit_categories', function(){
     var id = $(this).data("id");
    $.ajax({
        type: "GET",
        url: '/management/categories/'+ id +'/edit',
        success: function (data) {
            $("#edit_categories_modal").replaceWith(data);
            $('#Edit_category_class_modal').modal('show');
        },
            });
        });
</script>



@endsection
