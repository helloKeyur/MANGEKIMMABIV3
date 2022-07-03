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

        <form action="{{ route('post.update',encrypt($vars['post']->id)) }}" method="POST" enctype="multipart/form-data" id="editPostFormId">
          @csrf
          @method("PUT")
          <div class="form-group">
            <label for="name_post">Blog Title</label><small class="text-danger">*</small>
            <input type="text" name="name" 
                value="{{ $vars['post']->name }}"
                class="form-control" id="name_post"
                placeholder="Name" autocomplete="off"
                required >
            <small class="text-danger err" id="name-err"></small>
          </div>

          <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Blog_Categories">Blog Categories</label><small class="text-danger">*</small>
                    <select class="form-control select2" id="Blog_Categories" name="categories[]" multiple required>
                        @foreach($vars['categories'] as  $category)
                            @if(\Auth::user()->userHasRole('admin'))
                                <option value="{{ $category->id }}" {{ in_array($category->id, $vars['post']->categories->pluck('id')->toArray())? 'selected' : '' }}>{{ $category->name }}</option>
                            @elseif(in_array($category->id, \Auth::user()->allPermissions()->pluck('id')->toArray()))
                                <option value="{{ $category->id }}" {{ in_array($category->id, $vars['post']->categories->pluck('id')->toArray())? 'selected' : '' }}>{{ $category->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <small class="text-danger err" id="categories-err"></small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="is_active">Publish Date & Time </label>
                    <input type="datetime-local" name="published_at" value="{{ date("Y-m-d\TH:i", strtotime($vars['post']->published_at ))}}" class="form-control" required >
                </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <button type="button" class="btn btn-outline-dark" onclick="addImageOrVideoBox('imageGroup','img')">Add Image</button>
                    <div class="imageGroup mt-2" id="imageGroup">
                        @foreach($vars['post']->media()->where('type','Image')->get() as  $image)
                            <img alt="..." class="margin image_list mb-2 img-thumbnail" width="150px" height="100px" src="{{ $image->file_path }}" onerror="this.src='http://placehold.it/150x100';">
                            <div class="radio radio-inline ml-3">
                                <label>
                                    <input type="radio" class="radio_is_featured" name="is_featured" value="{{ $image->id }}" @if($image->is_featured == "Yes") checked = 'true' @endif>
                                    Mark As Fetured
                                </label>
                            </div>
                            <div class="input-group input-group-button imgOrVideoBoxParent">
                                <input type="text" class="form-control" 
                                placeholder="Image URL" name="image[]"
                                value="{{ $image->file_path }}">
                                <div class="input-group-append">
                                    <button class="btn btn-danger" type="button" onclick="removeImageOrVideoBox(this);">
                                        <i class="ik ik-trash m-0"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group text-right">
                    <button type="button" class="btn btn-outline-dark" onclick="addImageOrVideoBox('videoGroup','video')">Add Video</button>
                    <div class="videoGroup mt-2" id="videoGroup">
                        @foreach($vars['post']->media()->where('type','Video')->get() as  $video)
                            <iframe src="{{ $video->file_path }}" width="150" height="100" frameborder="0" allowfullscreen></iframe>
                            <div class="radio radio-inline ml-3">
                                <label>
                                    <input type="radio" class="radio_is_featured" name="is_featured" value="{{ $video->id }}" @if($video->is_featured == "Yes") checked = 'true' @endif>
                                    Mark As Fetured
                                </label>
                            </div>
                            <div class="input-group input-group-button imgOrVideoBoxParent">
                                <input type="text" class="form-control" 
                                placeholder="Video URL" name="video[]"
                                value="{{ $video->file_path }}">
                                <div class="input-group-append">
                                    <button class="btn btn-danger" type="button" onclick="removeImageOrVideoBox(this);">
                                        <i class="ik ik-trash m-0"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
          </div>

          <div class="form-group">
            <input type="hidden" class="post_status" name="status" value="{{ $vars['post']->status }}">
            <label for="content">Lessons content</label> <small class="text-muted">(Optional)</small>
            <textarea class="form-control editor" rows="10" name="content" id="content">{!! $vars['post']->content !!}</textarea>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <button type="submit" class="btn btn-primary submit_form" data-status="Draft"><i class="ik save ik-save"></i>Update</button>
                <a href="{{ $vars['gotoback'] }}" class="btn btn-light"><i class="ik arrow-left ik-arrow-left"></i> Go Back</a>
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

    //EDIT POST
    $("#editPostFormId").submit(function(event){
        event.preventDefault();
        editForm("#editPostFormId");
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

$(document).on('click', '.radio_is_featured', function () {
    var media = $(this).val();
    var url = "{{ route('post.media_is_featured',[$vars['post']->id,':media']) }}";
    url = url.replace(":media",media);
    $.ajax({
    type: "GET",
    url: url,//'/management/media_is_featured/{{ $vars['post']->id }}/'+ media,
    success: function (data) {
        // swal("Done!","Media set is Featured","success");
        showToast('Success','Media is Featured Succcesfully','success');
    },
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