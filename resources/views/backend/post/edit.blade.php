@extends('main')
@section('css')
     <link rel="stylesheet" href="{{ url('/') }}/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
 <style type="text/css">
     <style type="text/css">
   .document-editor__toolbar{
    padding: 10%
    width:95%;
    margin: auto;
   }


   .content {
   
    padding-top: 15px;
    padding-right: 15px;
    padding-bottom: 0px;
    padding-left: 0px;
    margin-right: auto;
    margin-left: auto;
    padding-left: 15px;
    padding-right: 15px;
}
 </style>
 </style>
@endsection
@section('content')
    <section class="content-header">
      <h1>
        {{{ $vars['title'] }}}
        <small>{{{ $vars['sub_title'] }}}</small>
      </h1>
     {{--  <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="/users">Staffs</a></li>
        <li class="active">Staff</li>
      </ol> --}}
    </section>

 <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Compose New Post</h3>
            </div>
            <!-- /.box-header -->
         <form  class="prevent-resubmit-form" id="create_post_form" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
    <div class="box-body">
         <div class="row">
                
             
              <div class="form-group col-md-4">
                <label>Blog Title</label>
                <input class="form-control" id="name_post" type="text" value="{{ $vars['post']->name }}" name="name" required >
              </div>

              <div class="form-group col-md-4">
                <label>Blog Categories</label>    {{-- <button type="button" class="btn btn-info btn-xs Add_Categories" title="Add Categories" data-original-title="Add Categories"><i style="margin-top: 5px;" class="fa fa-plus" style="padding: 0px;"></i></button> --}}
                <select class="form-control select2" id="Blog_Categories" name="categories[]" multiple required style="width:100%;">
                 @foreach($vars['categories'] as  $category)
                     @if(\Auth::user()->userHasRole('admin'))
                        <option value="{{ $category->id }}" {{ in_array($category->id, $vars['post']->categories->pluck('id')->toArray())? 'selected' : '' }}>{{ $category->name }}</option>
                    @elseif(in_array($category->id, \Auth::user()->allPermissions()->pluck('id')->toArray()))
                           <option value="{{ $category->id }}" {{ in_array($category->id, $vars['post']->categories->pluck('id')->toArray())? 'selected' : '' }}>{{ $category->name }}</option>
                    @endif
                  @endforeach
                 </select>
              </div>


              <div class="form-group col-md-4">
                <label>Publish Date & Time</label>
                 <input type="datetime-local" name="published_at" value="{{ date("Y-m-d\TH:i", strtotime($vars['post']->published_at ))}}" class="form-control" required >
              </div>
              <div class="col-md-12">
<div class="row">

              <div class="form-group col-md-6" >
                <div id="image_div">
                  <label>Image </label>
                   <br>
                  <a href="javascript:;" type="button" class="btn btn-white btn-info btn-bold" id="Add_Image">Add Image</a>

                     @foreach($vars['post']->media()->where('type','Image')->get() as  $image)
                   <div class="image_div_css">
                        <br> 
                       <img alt="..." class="margin image_list" width="150px" height="100px" src="{{ $image->file_path }}" onerror="this.src='http://placehold.it/150x100';"> <input type="radio" class="radio_is_featured" name="is_featured" value="{{ $image->id }}" @if($image->is_featured == "Yes") checked = 'true' @endif>
                        <div class="input-group input-group-sm ">
                            <input type="text" class="form-control" name="image[]" value="{{ $image->file_path }}" required>
                                <span class="input-group-btn">
                                  <button type="button" class="btn btn-danger btn-flat deleteimage"><i class="ace-icon fa fa-trash-o  bigger-110 icon-only"></i></button>
                                </span>
                          </div>
                          <br>
                  </div>
                      @endforeach  
                </div>
              </div>



               <div class="form-group col-md-6">
                <div id="video_div">
                   <label>Video </label>
                    <br>
                   <a href="javascript:;" type="button" class="btn btn-white btn-info btn-bold" id="Add_Video">Add Video</a>

                    @foreach($vars['post']->media()->where('type','Video')->get() as  $video)
                    <div class="video_div_css">
                        <br>
                        <iframe src="{{ $video->file_path }}" width="150" height="100" frameborder="0" allowfullscreen></iframe>
                            <input type="radio" class="radio_is_featured"  name="is_featured"  value="{{ $video->id }}" @if($video->is_featured == "Yes") checked = 'true' @endif>
                     <div class="input-group input-group-sm ">
                <input type="text" class="form-control" name="video[]" value="{{ $video->file_path }}" required>
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-danger btn-flat deletevideo"><i class="ace-icon fa fa-trash-o  bigger-110 icon-only"></i></button>
                    </span>
              </div><br>
               </div>
                      @endforeach 
                  </div>
              </div>

</div>
</div>
              <div class="form-group col-md-12">
              <div class="document-editor__toolbar" style="padding:0px 15px 0px 15px;"></div>
            </div>

            <div class="row row-editor" style="padding:0px 15px 0px 15px;">
              <div class="editor">
                {!! $vars['post']->content !!}
              </div>
            </div>



              {{-- <div class="form-group col-md-12">
                    <textarea id="compose-textarea" name="content" class="form-control" style="height: 300px" required > </textarea>
              </div> --}}
              <input type="hidden" class="post_status" name="status" value="{{ $vars['post']->status }}">
              


              </div>


        <div class="box-footer">
            <button type="submit" class="btn btn-primary prevent-resubmit-button">Update</button>
        </div>
    </div>

</form>
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
        </div>
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

                   
{{-- 
                 <div class="form-group">
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


   


 </section>
@endsection


@section('js')
<script src="{{ url('/') }}/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script type="text/javascript">

DecoupledDocumentEditor
.create( document.querySelector( '.editor' ), {
        
        toolbar: {
          items: [
            'heading',
            '|',
            'fontSize',
            'fontFamily',
            '|',
            'undo',
            'redo',
            '|',
            'bold',
            'italic',
            'underline',
            'strikethrough',
            'fontColor',
            'fontBackgroundColor',
            '|',
            'alignment',
            'indent',
            'outdent',
            '|',
            'numberedList',
            'bulletedList',
            'todoList',
            '|',
            'superscript',
            'subscript',
            'horizontalLine',
            '|',
            'link',
            'blockQuote',
            'insertTable',
            'imageUpload',
            'mediaEmbed',
            'pageBreak',
            
            '|',
            'highlight',
            'codeBlock',
            'code'
          ]
        },
        language: 'en-gb',
        image: {
          toolbar: [
            'imageTextAlternative',
            'imageStyle:full',
            'imageStyle:side'
          ]
        },
        table: {
          contentToolbar: [
            'tableColumn',
            'tableRow',
            'mergeTableCells'
          ]
        },
        licenseKey: '',
        
      } )
      .then( editor => {
        window.editor = editor;
        // Set a custom container for the toolbar.
        document.querySelector( '.document-editor__toolbar' ).appendChild( editor.ui.view.toolbar.element );
        document.querySelector( '.ck-toolbar' ).classList.add( 'ck-reset_all' );
      } )
      .catch( error => {
        console.error( 'Oops, something gone wrong!' );
        console.error( 'Please, report the following error in the https://github.com/ckeditor/ckeditor5 with the build id and the error stack trace:' );
        console.warn( 'Build id: sbirtrsnncsv-dp4wx5cssd8h' );
        console.error( error );
      } );




    
 $('#Add_Image').click(function() { 

      $('#image_div').append(`<div class="input-group input-group-sm image_div_css">
                <input type="text" class="form-control" name="image[]" required>
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-danger btn-flat deleteimage"><i class="ace-icon fa fa-trash-o  bigger-110 icon-only"></i></button>
                    </span>
              </div><br>`); 
 });


 $('#Add_Video').click(function() { 

      $('#video_div').append(`<div class="input-group input-group-sm video_div_css">
                <input type="text" class="form-control" name="video[]" required>
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-danger btn-flat deletevideo"><i class="ace-icon fa fa-trash-o  bigger-110 icon-only"></i></button>
                    </span>
              </div><br>`); 
 });


  $(document).on('click', '.radio_is_featured', function () {
      var media = $(this).val();


      $.ajax({
        type: "GET",
        url: '/management/media_is_featured/{{ $vars['post']->id }}/'+ media,
        success: function (data) {
            // swal("Done!","Media set is Featured","success");
             snackbartext('success','Media is Featured Succcesfully');
        },
      });
       
});



 $(document).on('click', '.deleteimage', function () {
      var div = $(this).closest('div.image_div_css');
         div.remove();
});


  $(document).on('click', '.deletevideo', function () {
      var div = $(this).closest('div.video_div_css');
         div.remove();
});


     $(function () {
    //Add text editor
    $("#compose-textarea").wysihtml5();
  });


 $(".submit_form").click(function() {
      var button = $(this).data('status');
      $('.post_status').val(button);
  });


$(".Add_Categories").click(function() {
     $('#AddCategoriesModal').modal('show');
  }); 





$("#name_category").blur(function() {
     var data = $(this).val();
      $('#slug_category').val(convertToSlug(data));
  }); 





$("#name_post").blur(function() {
     var data = $(this).val();
      $('#slug_post').val(convertToSlug(data));
  });



function convertToSlug(Text)
{
    return Text
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')
        ;
}



      $(document).on('submit', '#create_post_form', function(e){
       e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formdata = new FormData(this);
        formdata.append('content', editor.getData());

            $.ajax({
                type: "POST",
                url: '/management/post/{{  encrypt($vars['post']->id) }}',
                processData: false,
                contentType: false,
                data: formdata,
               beforeSend: function(){ ColoredLoader('create_post_form',"Saving..."); },
              complete: function(){ $('#create_post_form').preloader('remove');},
              success: function (data) {

                    snackbartext('success','Post Saved Succcesfully');
                    window.location.reload();
                   
                 },
                error: function (xhr, ajaxOptions, thrownError){
                   $('.prevent-resubmit-button').prop("disabled", false);
                   $('.prevent-resubmit-button').html('Submit');
                    close_modal('guardian_create_model');
                     show_alert('danger', xhr.responseText);
            }
            });
          });
      




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
                $("#Blog_Categories").append('<option value="'+data.id+'">'+data.name+'</option>');
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



  
</script>


@endsection

