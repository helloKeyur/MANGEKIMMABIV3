@extends('v3.backend.layouts.app')

@php
use App\Models\User;
@endphp

@section('title') Categories @endsection

@section('css')
<style type="text/css">
    .switchery-small{
        width: 40px !important;
    }
    .cursor-move{
        cursor: move;
    }
</style>
@endsection

@section('content')

<div class="page-header mb-0">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-layers bg-blue"></i>
                <div class="d-inline">
                    <h5>{{ $vars['title'] }}</h5>
                    <span>Here you can manage {{ strtolower($vars['title']) }}.</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <nav class="breadcrumb-container" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="../../index.html"><i class="ik ik-home"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row align-items-end">
    <div class="col-lg-12 col-md-12 mt-4">
        <div class="card">
            <div class="tabs_contant">
                <div class="card-header">
                    <div class="col-md-6">
                        @if(\Auth::user()->userHasRole('admin')) 
                        <a href="#" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#AddCategoriesModal">
                            <i class="ik ik-plus-square"></i> 
                            Create New Category
                        </a>
                        <a href="#" class="btn btn-sm btn-success ml-2 Save_Arrangement">
                            <i class="ik save ik-save"></i> 
                            Save Arrangement
                        </a>
                        @endif
                    </div>
                    <div class="col-md-6 text-right">
                        <h5 class="mb-0">List of Categories</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row clearfix" id="categories_table">

    @foreach($vars['categories'] as  $row)
    <div class="col-lg-3 col-md-6 col-sm-12 connectedSortable">
        <div class="widget">
            <div class="widget-header cursor-move">
                <h3 class="widget-title">{{  $row->name }}</h3>
                <div class="widget-tools pull-right">
                    <button type="button" class="btn btn-widget-tool minimize-widget ik ik-minus"></button>
                    @if(\Auth::user()->userHasRole('admin')) 
                        <button type="button" class="btn btn-widget-tool ik ik-edit-2 edit_categories"
                        data-id="{{$row->id}}" data-toggle="tooltip" title="Edit Category" data-widget="chat-pane-toggle"
                        ></button>
                    @endif
                    <button type="button" class="btn btn-widget-tool ik ik-x hidden close_panel_{{ $row->id }}"></button>
                </div>
            </div>
            <div class="widget-body p-0 categories_divs" style="">
                <div class="list-group" data-id="{{$row->id}}">
                    <a class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="row">
                            <div class="col-md-12 my-auto text-center">
                                <label class="text-danger font-weight-bold">Offline</label>
                                <input type="checkbox" class="js-switch category_state"
                                name="state" @if($row->state == "online") checked @endif  data-id="{{$row->id}}"
                                 />
                                <label class="text-success font-weight-bold">Online</label>
                            </div>
                        </div>
                    </a>
                    <a class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="row">
                        <div class="col-md-3 text-right my-auto">
                            <b data-toggle="tooltip" data-title="Created By"><i class="ik ik-user"></i></b>
                        </div>
                        <div class="col-md-9 text-left">
                            @if($row->enteredBy){{ $row->enteredBy->name }}@endif
                        </div>
                        </div>
                    </a>
                    <a class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="row">
                        <div class="col-md-3 text-right my-auto">
                            <b data-toggle="tooltip" data-title="Created At"><i class="ik ik-calendar"></i> </b>
                        </div>
                        <div class="col-md-9 text-left">
                            {{  $row->created_at }}
                        </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="extraModals">

    {{-- START::CREATE CATEGORY MODAL --}}
    <div class="modal fade" id="AddCategoriesModal" tabindex="-1" role="dialog" aria-labelledby="AddCategoriesModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddCategoriesModalLabel">Add Categories</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="loader br-4 hidden">
                        <i class="ik ik-refresh-cw loading"></i>
                    </div>
                    <form class="prevent-resubmit-form" id="create_category_form" enctype="multipart/form-data">
                        @csrf
                        <div class="box-body">

                            <div class="form-group">
                            <label>Category Name</label>
                            <input class="form-control" type="text" id="name_category" name="name" required >
                            </div>

                            {{-- <div class="form-group">
                            <label for="">Description</label>
                            <textarea  rows="3" name="description" class="form-control"  placeholder="Decsription.." ></textarea>
                            </div> --}}

                        </div>
                        <div class="box-footer">
                            <div class="pull-right">
                            <button type="submit" class="btn btn-primary"><i class="ik ik-save"></i> Save Category</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- END::CREATE CATEGORY MODAL --}}

    {{-- START::EDIT CATEGORY MODAL --}}
    <div class="modal fade" id="Edit_category_class_modal" tabindex="-1" role="dialog" aria-labelledby="Edit_category_class_modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Edit_category_class_modalLabel">Edit Categories</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="edit_categories_modal">

                </div>
            </div>
        </div>
    </div>
    {{-- END::EDIT CATEGORY MODAL --}}
</div>

@endsection

@section('js')
<script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
<script src="{{ url('/') }}/assets/bower_components/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript">
$(document).ready(function(e){
    setSwitches();
})

function setSwitches(){
    var elem = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    elem.forEach(function(html) {
        var switchery = new Switchery(html, {
            // color: '#4099ff', //PRIMARY
            color: '#2ed8b6', // SUCCESS
            secondaryColor: '#FF5370', //DANGER
            jackColor: '#fff',
            size: 'small'
        });
    });
}

$.widget.bridge('uibutton', $.ui.button);
$(function () {
    'use strict';
    $('.connectedSortable').sortable({
        placeholder         : 'sort-highlight',
        connectWith         : '.connectedSortable',
        handle              : '.widget-header, .nav-tabs',
        forcePlaceholderSize: true,
        zIndex              : 999999
    });
    $('.connectedSortable .box-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move');
});

$(document).on('change',".category_state",function() {
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
        url: '{{ route("categories.category_state") }}',//'/management/category_state',
        processData: false,
        contentType: false,
        data: formdata,
        beforeSend: function(){ 
                // run_waitMe('win8_linear','category_state-div','Saving...'); 
        },
        complete: function(){ 
            // $('#category_state-div').waitMe("hide");
        },
        success: function (data) {
            if(data.error){
                showToast('Error!',
                    data.error,
                    'error'
                    );
            }else{
                showToast('Success!',
                    'Category state is changed.',
                    'success'
                    );
            }
        },

        error: function (xhr, ajaxOptions, thrownError){
            console.log(xhr.responseText);
        }
    });
});

$(".Save_Arrangement").click(function() {
    var status = 0;
    var len = $(".categories_divs > div.list-group").length;
    $(".categories_divs > div.list-group").each(function(index){
        var id = $(this).data("id");
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
            url: "{{ route('categories.category_arrangement') }}",//'/management/category_arrangement',
            processData: false,
            contentType: false,
            data: formdata,
            beforeSend: function(){
                //  run_waitMe('win8_linear','categories_table','Saving...'); 
            },
            complete: function(){ 
                // $('#categories_table').waitMe("hide");
            },
            success: function (data) {
                if(data.error){
                    status += 0;
                }else{
                    status += 1;
                }
                // console.log(status);
            },

            error: function (xhr, ajaxOptions, thrownError){
                console.log(xhr.responseText);
            }
        });
    });

        showToast('Success!',
            'Arrangements are saved successfully!',
            'success'
            );

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
    $.ajax({
        type: "POST",
        url: "{{ route('categories.store') }}",//'/management/categories',
        processData: false,
        contentType: false,
        data: formdata,
        beforeSend: function(){ 
            $(".progress,.overlay, .loader").toggleClass('hidden');
        },
        complete: function(){ 
            $(".progress,.overlay, .loader").toggleClass('hidden');
        },
        success: function (data) {
            $("#categories_table").append(data);
            showToast('Success','Category Saved Succcesfully','success');
            $('.close').click();
            // setSwitches();
        },
        error: function (xhr, ajaxOptions, thrownError){
            $('.prevent-resubmit-button').prop("disabled", false);
            $('.prevent-resubmit-button').html('Submit');
            close_modal('guardian_create_model');
            showToast('Error', xhr.responseText,'danger');
        }
    });
});

$(document).on('click', '.edit_categories', function(){
    var id = $(this).data("id");

    editFormUrl = "{{ route('categories.edit',':id') }}"; //"/management/admins/"+id;
    editFormUrl = editFormUrl.replace(':id', id);


    $.ajax({
        type: "GET",
        url: editFormUrl,//'/management/categories/'+ id +'/edit',
        success: function (data) {
            $("#edit_categories_modal").html(data);
            $('#Edit_category_class_modal').modal('show');
        },
    });
});
</script>
@endsection