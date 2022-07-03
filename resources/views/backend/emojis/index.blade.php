@extends('main')
@section('css')
 <style>
    /* FROM HTTP://WWW.GETBOOTSTRAP.COM
     * Glyphicons
     *
     * Special styles for displaying the icons and their classes in the docs.
     */

    .bs-glyphicons {
      padding-left: 0;
      padding-bottom: 1px;
      margin-bottom: 20px;
      list-style: none;
      overflow: hidden;
    }

    .bs-glyphicons li {
      float: left;
      width: 25%;
      height: 115px;
      padding: 10px;
      margin: 0 -1px -1px 0;
      font-size: 12px;
      line-height: 1.4;
      text-align: center;
      border: 1px solid #ddd;
    }

    .bs-glyphicons .glyphicon {
      margin-top: 5px;
      margin-bottom: 10px;
      font-size: 24px;
    }

    .bs-glyphicons .glyphicon-class {
      display: block;
      text-align: center;
      word-wrap: break-word; /* Help out IE10+ with class names */
    }

    .bs-glyphicons li:hover {
      background-color: rgba(86, 61, 124, .1);
    }

    @media (min-width: 768px) {
      .bs-glyphicons li {
        width: 12.5%;
      }
    }
  </style>

@endsection
@section('content')
	<section class="content-header">
      <h1>
        {{{ $vars['title'] }}}
        <small>{{{ $vars['sub_title'] }}}</small>
     <button type="button" class="btn btn-primary pull-right Add_Emojis"><i class="fa fa-plus"></i> Add Emojis</button>
      </h1>
    </section>

    <section class="content">

 <div class="row" >
  <div class="box box-primary" id="glyphicons">
   <ul class="bs-glyphicons">
  @foreach($vars['emojis'] as  $row)
    <li id="emoji_list_{{ $row->id }}">
      @if(\Auth::user()->userHasRole('admin')) 
    <div class="pull-right"> <i class="fa fa-pencil editTr" data-id="{{ $row->id}}"  style="color:blue; cursor: pointer;"></i> 
          &nbsp; &nbsp;
           <i class="fa fa-trash-o deleteEmoji" data-address="emojis" data-id="{{$row->id}}" style="color:red;cursor: pointer;"></i>
     </div>
     <br>
     @endif
                    <img src="{{ $row->img_url }}" width="60" height="60">
                    <span class="glyphicon-class">{{ $row->name }}</span>
                  </li>
  @endforeach
                 
  </ul>
     </div>
</div>




       <div class="modal fade" id="AddEmojisModal">
      <div class="modal-dialog modal-lg">
        <div class="box box-primary">
              <div class="box-header with-border">
                <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                  <br>
                  <h3 class="box-title">Add Emojis</h3>
                  <div class="pull-right">

                  </div>
              </div>
             <form class="prevent-resubmit-form" id="create_emoji_form" enctype="multipart/form-data">
             @csrf
               <div class="box-body ">
                 <div class="row">
              <div class="form-group col-md-6">
                  <label> Name</label>
                  <input class="form-control" type="text" name="name">
                </div>

                  <div class="form-group col-md-6">
                <label>Emoji Image</label><br>
                  <input type="file" class="form-control" name="img" required>
              </div>
            </div>
              </div>
                        <div class="box-footer">
                          <div class="pull-right">
                            <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-send"></i> Save Emoji</button>
                          </div>
                        </div>
                </form>
        </div>
      </div>
    </div>


    <div class="modal fade" id="Edit_emiji_class_modal">
    <div class="modal-dialog">
    <div class="box box-primary" id="edit_emijis_modal">

    </div>
          <!-- /.box -->
    </div>
</div>
    </section>

 

@endsection


@section('js')

<script type="text/javascript">
  
$(".Add_Emojis").click(function() {
     $('#AddEmojisModal').modal('show');
  });


$(document).on('submit', '#create_emoji_form', function(e){
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
                url: '/management/emojis',
                processData: false,
                contentType: false,
                data: formdata,
               beforeSend: function(){ ColoredLoader('create_emoji_form',"Saving..."); },
              complete: function(){ $('#create_emoji_form').preloader('remove');},
              success: function (data) {
                  $(".bs-glyphicons").append(data);
                   document.getElementById("create_emoji_form").reset();
                    snackbartext('success','Emoji Saved Succcesfully');
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


$(document).on('submit', '#edit_emoji_form', function(e){
       e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

      var url =  $('#edit_emoji_form').attr('action');

        var id = $('#id_edit').val();
        var formdata = new FormData(this);
        formdata.append('status','');
            $.ajax({
                type: "POST",
                url: url,
                processData: false,
                contentType: false,
                data: formdata,
               beforeSend: function(){ ColoredLoader('edit_emoji_form',"Saving..."); },
              complete: function(){ $('#edit_emoji_form').preloader('remove');},
              success: function (data) {
                  document.getElementById("edit_emoji_form").reset();
                  // $("#foods_table").append(data);
                   $("li#emoji_list_"+id).replaceWith(data);
                    snackbartext('success','Emoji Saved Succcesfully');
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


  $(document).on('click', '.editTr', function(){
     var id = $(this).data("id");
    $.ajax({
        type: "GET",
        url: '/management/emojis/'+ id +'/edit',
        success: function (data) {
            $("#edit_emijis_modal").replaceWith(data);
            $('#Edit_emiji_class_modal').modal('show');
        },
            });
        });




  $(document).on('click', '.deleteEmoji', function () {
    var id = $(this).data("id");
    var address = $(this).data("address");
    var token = $('meta[name="csrf-token"]').attr('content');
    var force = $(this).data("force");
    var $tr = $(this).closest("li#emoji_list_"+id);
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
                            'Emoji has been deleted successful',
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
