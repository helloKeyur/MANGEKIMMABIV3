@extends('v3.backend.layouts.app')

@section('title') Emojis | {{\App\Models\SysConfig::set()['system_title']}} @endsection

@section('css')
<style type="text/css">
    .overflow-visible{
        overflow: visible !important;
    }
    td.p-0 img.img-thumbnail{
      width: 140px;
    }
    .icon > img{
        border-radius: 4px;
    }
</style>
@endsection

@section('content')

<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-8">
      <div class="page-header-title">
        <i class="ik ik-gitlab bg-blue"></i>
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
            <a href="{{ route('admins.index') }}">Emojis</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">List of Emojis</li>
        </ol>
      </nav>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12 col-md-12 mt-4">
      <div class="card">

        <!--Tab content-->
        {{-- <div class="loader br-4">
          <i class="ik ik-refresh-cw loading"></i>
          <span class="loader-text">Data Fetching....</span>
        </div> --}}
        <div class="tabs_contant">
            <div class="card-header">
                <div class="col-md-3">
                    <a href="#" class="btn btn-sm btn-dark float-left" data-toggle="modal" data-target="#createFormModelId">
                        <i class="ik plus-square ik-plus-square"></i> 
                        Create New Emojis
                    </a>
                </div>
                <div class="col-md-9 text-right">
                    <h5 class="mb-0">List of Emojis</h5>
                </div>
            </div>
        </div>
        <!--End Tab Content-->
      </div>

      <div class="row clearfix">
        @foreach($vars['emojis'] as  $row)
        <div class="col-lg-2 col-md-4 col-6">
            <div class="widget social-widget">
                <div class="loader br-4">
                    <i class="ik ik-refresh-cw loading"></i>
                </div>
                <div class="widget-body">
                    <div class="icon">
                        <img src="{{ url('/').$row->img_url }}" width="60" height="60">
                    </div>
                    <div class="content text-center">
                        <small class="glyphicon-class">{{ $row->name }}</small>
                        </br>
                        @if(\Auth::user()->userHasRole('admin')) 
                            <a href="#" onclick="editEmoji(`{{ $row->id }}`)"><i class="ik ik-edit-2 text-dark"></i></a>
                            <a data-href="{{ route('emojis.destroy',$row->id) }}" class="delete"><i class="ik ik-trash-2 text-danger"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    </div>
  </div>
  
</div>

<div class="row">
    <div class="col-md-12">
        <form id="deleteForm" method="post">
            @csrf
            @method('DELETE')
            <input type="submit" name="submit" class="hidden">
        </form>
    </div>
</div>

<div class="showModel">
 
</div>

<div class="createOrEditModel">
  @include('v3.backend.emojis._create');
  @include('v3.backend.emojis._edit');
</div>

@endsection

@section('js')

<script type="text/javascript">
  
$(document).ready(function() {
  
  var dataTable = $("table.dataTable").DataTable(commonDataTableProps({title:"List Of Staff"}));
  dataTable.buttons().container().appendTo("#dataTableButtons");
  $("div.loader").addClass('hidden');

  //CRETE USER
  $("#createEmojiFormId").submit(function(event){
    event.preventDefault();
    createForm("#createEmojiFormId");
  });

  //UPDATE USER
  $("#editEmojiFormId").submit(function(event){
    event.preventDefault();
    editForm("#editEmojiFormId");
  });

});

function editEmoji(id){
  // url = "/management/emojis/"+id;
  updateFormUrl = "{{ route('emojis.update',':id') }}"; //"/management/admins/"+id;
  updateFormUrl = updateFormUrl.replace(':id', id);

  editFormUrl = "{{ route('emojis.edit',':id') }}"; //"/management/admins/"+id;
  editFormUrl = editFormUrl.replace(':id', id);

  $.ajax({
    type: "GET",
    url: editFormUrl,//'/management/emojis/'+ id +'/edit',
    success: function (data) {
      console.log(data.emoji.img_url);
        $("#editEmojiFormId input[name=name]").val(data.emoji.name);
        $("#editEmojiFormId #editEmojiImgId").attr('src',"{{ url('/') }}"+data.emoji.img_url);
        if(data.emoji.img_url != ""){
            $("#editEmojiFileId").prop("required",true);
        }
        $("#editEmojiFormId ").attr("action", updateFormUrl);
        $('#editFormModelId').modal('show');
    },
  });
}
</script>
@endsection