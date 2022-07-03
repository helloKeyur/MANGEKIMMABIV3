@extends('v3.backend.layouts.app')

@section('title') {{ $vars['title'] }} | {{\App\Models\SysConfig::set()['system_title']}} @endsection

@section('css')
<style type="text/css">
    .overflow-visible{
        overflow: visible !important;
    }
    td.p-0 img.img-thumbnail{
      width: 140px;
    }
</style>
@endsection

@section('content')

<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-8">
      <div class="page-header-title">
        <i class="ik ik-book bg-blue"></i>
        <div class="d-inline">
          <h5>{{ $vars['title'] }}</h5>
          <span>{{ $vars['sub_title'] }}</span>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <nav class="breadcrumb-container" aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{ route('management.dashboard') }}"><i class="ik ik-home"></i></a>
          </li>
          <li class="breadcrumb-item">
            <a href="#">Blog</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">{{ $vars['title'] }}</li>
        </ol>
      </nav>
    </div>
  </div>
</div>

<div class="row justify-content-center">
  <div class="offset-1 col-md-10 col-sm-12 col-xl-10">
    <div class="widget overflow-visible">
      <div class="progress progress-sm progress-hi-3 hidden">
        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
        </div>
      </div>
      <div class="widget-body">
        <div class="loader br-4">
            <i class="ik ik-refresh-cw loading"></i>
        </div>
        <div class="overlay hidden">
          <i class="ik ik-refresh-ccw loading"></i>
          <span class="overlay-text">New Post Creating...</span>
        </div>
        <div class="d-flex justify-content-between align-items-center">
          <div class="state">
            <h5 class="text-secondary">Please fill all required fields correctly.</h5>
          </div>
        </div>

        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data" id="createPostFormId">
          @csrf
          <div class="form-group">
            <label for="name_post">Blog Title</label><small class="text-danger">*</small>
            <input type="text" name="name" 
                class="form-control" id="name_post"
                placeholder="Name" autocomplete="off"
                required >
            <small class="text-danger err" id="name-err"></small>
          </div>

          <div class="form-group">
            <label for="Blog_Categories">Blog Categories</label><small class="text-danger">*</small>
            <select class="form-control select2" id="Blog_Categories" name="categories[]" multiple required>
                @foreach($vars['categories'] as  $category)
                @if(\Auth::user()->userHasRole('admin'))
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @else
                    @if(in_array($category->id, \Auth::user()->allPermissions()->pluck('id')->toArray()))
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endif
                @endif
                @endforeach
            </select>
            <small class="text-danger err" id="categories-err"></small>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <label for="is_video_segment">Is Video Segment</label><small class="text-danger">*</small>
              <div class="input-group mb-0">
                <select class="form-control" name="is_video_segment" id="is_video_segment" required>
                    @foreach(\App\Models\Post::is_video_segment() as $type)
                      <option value="{{ $type }}" @if($type == 'No') selected @endif>{{ $type }}</option>
                    @endforeach
                </select>
              </div>
              <small class="text-danger err" id="is_video_segment-err"></small>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="is_active">Publish Date & Time </label>
                    <input type="datetime-local" name="published_at" class="form-control" required >
                    <input type="hidden" class="post_status" name="status">
                </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <button type="button" class="btn btn-outline-dark" onclick="addImageOrVideoBox('imageGroup','img')">Add Image</button>
                    <div class="imageGroup mt-2" id="imageGroup">
                        
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group text-right">
                    <button type="button" class="btn btn-outline-dark" onclick="addImageOrVideoBox('videoGroup','video')">Add Video</button>
                    <div class="videoGroup mt-2" id="videoGroup">
                    </div>
                </div>
            </div>
          </div>

          <div class="form-group">
            <label for="content">Lessons content</label> <small class="text-muted">(Optional)</small>
            <textarea class="form-control editor" rows="10" name="content" id="content"></textarea>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <button type="submit" class="btn btn-primary submit_form" data-status="Draft"><i class="ik save ik-save"></i>Save as Draft</button>
                <a href="{{ $vars['gotoback'] }}" class="btn btn-light"><i class="ik arrow-left ik-arrow-left"></i> Go Back</a>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group text-right">
                <button type="submit" class="btn btn-success submit_form" data-status="Published"><i class="ik save ik-save"></i>Publish Now</button>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <button type="submit" class="btn btn-dark submit_form" data-status="date_time"><i class="ik save ik-save"></i>Publish By Date & Time</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@section('js')

<script type="text/javascript">
$("select.select2").select2({multiple:!0,allowClear:!0});
$(document).ready(function() {

  $("div.loader").addClass('hidden');

    $(".submit_form").click(function() {
        var button = $(this).data('status');
        $('.post_status').val(button);
    });
  //CRETE POST
  $("#createPostFormId").submit(function(event){
    event.preventDefault();
    createForm("#createPostFormId");
  });
  $('.editor').summernote({
    toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']]
    ],
    height: 300,
    tabsize: 2
  });
});

function addImageOrVideoBox(positionId,imgOrVideo){
    var placeHolder = (imgOrVideo == "img") ? "Image URL" : "Video URL"; 
    var name = (imgOrVideo == "img") ? "image[]" : "video[]"; 
    var box = `<div class="input-group input-group-button imgOrVideoBoxParent">
                    <input type="text" class="form-control" placeholder="`+placeHolder+`" name="`+name+`">
                    <div class="input-group-append">
                        <button class="btn btn-danger" type="button" onclick="removeImageOrVideoBox(this);">
                            <i class="ik ik-trash m-0"></i>
                        </button>
                    </div>
                </div>`;
    $("#"+positionId).append(box);
}

function removeImageOrVideoBox(e){
    var box = $(e).closest("div.imgOrVideoBoxParent");
    box.remove();
}
</script>
@endsection