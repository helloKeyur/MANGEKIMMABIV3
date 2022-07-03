@extends('v3.backend.layouts.app')

@section('title') List of posts | {{\App\Models\SysConfig::set()['system_title']}} @endsection

@section('css')
<style type="text/css">
    .overflow-visible{
        overflow: visible !important;
    }
    td.p-0 img.img-thumbnail{
      width: 140px;
    }
    .br5{
        border-top-right-radius: 5px !important;
        border-bottom-right-radius: 5px !important;
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
          <h5>Blogs</h5>
          <span>List of Post from {{explode('~', $vars['time'])[0]}} to {{explode('~', $vars['time'])[1]}}</span>
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
          <li class="breadcrumb-item active" aria-current="page">List of post</li>
        </ol>
      </nav>
    </div>
  </div>
  
  <div class="row">
    <div class="col-lg-12 col-md-12 mt-4">

        <div class="card">

        <!--Tab content-->
        <div class="loader br-4">
          <i class="ik ik-refresh-cw loading"></i>
          <span class="loader-text">Data Fetching....</span>
        </div>
        <div class="tabs_contant">
          <div class="card-header">
            <div class="col-md-3">
                <a href="{{ route('post.create') }}" class="btn btn-sm btn-dark float-left">
                    <i class="ik plus-square ik-plus-square"></i> 
                    Create New Post
                </a>
            </div>
            <div class="col-md-9 text-right">
                <h5 class="mb-0">List of Posts</h5>
            </div>
          </div>
          <div class="card-header">
            <div class="col-md-6">
                <div class="input-group mb-0">
                    <span class="input-group-prepend">
                        <label for="dates" class="input-group-text"><i class="ik ik-search"></i></label>
                    </span>
                    <input type="text" name="dates" class="form-control br5" id="dates" placeholder="dates" autocomplete="off">
                    <input type="hidden" class="time_range" name="time_range" id="time_range" value="all">
                    <small class="text-danger err" id="dates-err"></small>
                </div>
            </div>
            <div class="col-md-6 text-right" id="dataTableButtons">
            </div>
        </div>
        <div class="card-body table-responsive">
                <table class="table table-striped dataTable" id="user_table">
                    <thead>
                        <tr>
                            <th>Blog</th>
                            <th>Status</th>
                            <th>Publish DateTime </th>
                            <th>Created By</th>
                        {{--<th>Clicks</th>
                            <th>Comments</th>
                            <th>Reactions</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                <tbody>
                    @foreach($vars['posts'] as $key => $row)
                    <tr id="post_tr{{ $row->id }}">
                        <td>{{ $row->name }} </td>
                        <td>
                            @if($row->status == "Draft")
                                <span class="badge badge-warning">{{ $row->status }}</span>
                            @elseif($row->status == "Published")
                                <span class="badge badge-success">{{ $row->status }}</span>
                            @else
                                <span class="badge badge-danger">{{ $row->status }}</span>
                            @endif
                        </td>
                        <td>{{ $row->published_at }}</td>
                        <td>@if($row->enteredBy){{ $row->enteredBy->name }}@endif</td>
                    {{--<td>{{ $row->post_viewers->count() }}</td>
                        <td>{{ $row->post_comments->count() }}</td>
                        <td>{{ $row->post_reactions->count() }}</td> --}}
                        <td>
                            
                            <div class="table-actions text-center">
                                @if(\Auth::user()->userHasRole('admin') || \Auth::user()->userHasRole('author'))
                                  @if(!$row->notification_id)
                              
                                      <a href="javascript:sendNoticationCustom({{ $row->id }})" class="sentnotification_{{ $row->id }}"  data-toggle="tooltip" title="Notfication Sent" data-original-title="Notfication Sent" title="Notfication Sent">
                                          <i class="ik ik-bell text-warning" style="color:white"></i>
                                      </a>
                                  @endif
                                @endif
                                
                                <a 
                                data-href="{{ route('post.show',encrypt($row->id)) }}" class="show-post">
                                  <i class="ik ik-eye text-primary"></i>
                                </a>
                                
                                @if(\Auth::user()->userHasRole('admin') || $row->author_id == \Auth::user()->id ) 
                                    <a class="edit_user" 
                                    href="{{ route('post.edit',encrypt($row->id)) }}"
                                    target="_blank"><i class="ik ik-edit-2 text-dark"></i></a>
                                    <a data-href="{{ route('post.show',$row->id) }}" class="delete"><i class="ik ik-trash-2 text-danger"></i></a>
                                @endif

                                
                            </div>
                            
                            </td>
                    </tr>
                  
                    @endforeach
                </tbody>
              </table>
          </div>
        </div>
        <!--End Tab Content-->
      </div>
    </div>
  </div>
  
</div>

<div class="showModel">

</div>

@endsection

@section('js')
<script type="text/javascript">

function cb(start, end) {
    // $('input[name="dates"]').val(start.format('MM/DD/YYYY') + ' - ' + end.format('MM/DD/YYYY'));
    $('#time_range').val(start.format('YYYY-MM-DD') + '~' + end.format('YYYY-MM-DD'));
    $('input[name="dates"]').val(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
    // var url = "/management/post_list/"+start.format('YYYY-MM-DD') + '~' + end.format('YYYY-MM-DD');
    var time = start.format('YYYY-MM-DD') + '~' + end.format('YYYY-MM-DD');
    var url = "{{ route('post.post_list',':time') }}";// '/management/complete_payments/'+start.format('YYYY-MM-DD') + '~' + end.format('YYYY-MM-DD');
    url = url.replace(":time",time);
    window.location = url;
}

$(document).ready(function() {
  var dataTable = $("table.dataTable").DataTable(commonDataTablePropsWithAllCols({title:"List Of Posts"}));
  dataTable.buttons().container().appendTo("#dataTableButtons");
  $("div.loader").addClass('hidden');
  
  var start = moment().subtract(29, 'days');
  var end = moment();

  setDateRangePicker('dates',{
    startDt:"{{ date('M d, Y', strtotime(explode('~', $vars['time'])[0]))  }}",
    endDt:"{{ date('M d, Y', strtotime(explode('~', $vars['time'])[1]))  }}"
  },
  cb);
  
  //show post
  $(document).on('click','a.show-post',function(){
    var showUrl = $(this).data('href');
    showDetails(showUrl);
  });
});

$(document).on('click', '.deleteComment', function () {
    var id = $(this).data("id");
    var address = $(this).data("address");
    var token = $('meta[name="csrf-token"]').attr('content');
    var force = $(this).data("force");
    var $tr = $(this).closest("div#comment_list_"+id);

    swalWithBootstrapButtons.fire({
      title: 'Are you sure you want to Delete this?',
      text: "You won't be able to revert this!",
      showCancelButton: true,
      cancelButtonText: "No, cancel it !!",
      confirmButtonText: "Yes, Delete it !!",
      reverseButtons: true,
      showCloseButton : true,
      allowOutsideClick:false,
    }).then((result)=>{
      var action = (result.value) ? 'trash' : 'delete';
      console.log(result);
      if(result.value == true){
        destroyFormUrl = "{{ route('post.delete_comment',':id') }}";
        destroyFormUrl = destroyFormUrl.replace(':id', id);

        $.ajax({
                url: destroyFormUrl,//"/management/" + address + "/" + id,
                type: 'DELETE',
                dataType: "JSON",
                data: {
                    "id": id,
                    "_method": 'DELETE',
                    "_token": token,
                    "_force": force,
                },
                success: function (data) {
                    $tr.fadeOut(500, function () {
                        $tr.remove();
                        showToast('Deleted!','Emoji has been deleted successful','success');
                    });
                    $('.tooltip').hide();
                },
                error: function (xhr, ajaxOptions, thrownError) {

                    alert(xhr.responseText);
                }
            });
        }
        
      })
});
</script>
@endsection