@extends('main')


@section('css')
    <link rel="stylesheet" href="{{ url('/') }}/assets/bower_components/select2/dist/css/select2.min.css">
    <style type="text/css">
    
    </style>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           System Configuration
        </h1>
    </section>


    @php 
      $SysConfig =   \App\Models\SysConfig::set();

    @endphp

    <!-- Main content -->
    <section class="content">


        <div class="row">

            <div class="box box-primary">
              <div class="box-header with-border">
                <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                  <br>
                  <h3 class="box-title">Add Food</h3>
                  <div class="pull-right">

                  </div>
              </div>
              <form class="prevent-resubmit-form" id="create_config_form" enctype="multipart/form-data">
             @csrf
               <div class="box-body ">
            <div class="col-md-3">
                <label>App State</label>
                <select class="form-control select2" name="app_status" style="width: 100%;" required>
                  <option></option>
                   @foreach(\App\Models\SysConfig::app_state() as $cat)
                      <option value="{{ $cat }}" @if($cat == $SysConfig['app_status']) selected @endif>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
             <div class="col-md-3">
                 <label>App Version</label>
                  <input class="form-control" type="text" value="{{ $SysConfig['app_version'] }}" name="app_version" >
             </div>
         </div>

               <div class="box-footer">
                          <div class="pull-right">
                            <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-send"></i> Save </button>
                          </div>
                        </div>

                </form>
            </div>
        </div>
        <!-- /.row -->
    </section>
   @endsection
@section('js')
    <script src="{{ url('/') }}/assets/bower_components/select2/dist/js/select2.full.min.js"></script>

    <!-- InputMask -->
<script src="{{ url('/') }}/assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="{{ url('/') }}/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="{{ url('/') }}/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
 
    <script type="text/javascript">

  $(document).on('submit', '#create_config_form', function(e){
       e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formdata = new FormData(this);

            $.ajax({
                type: "POST",
                url: '/management/sys_configs',
                processData: false,
                contentType: false,
                data: formdata,
              success: function (data) {
                    $('.prevent-resubmit-button').prop("disabled", false);
                    $('.prevent-resubmit-button').html('Submit');
                   
                      swal({
                title: ' System Configuration Saved Succesfully',
                type: 'success',
                confirmButtonText: 'Ok',
                confirmButtonClass: 'btn btn-success',
                buttonsStyling: false
            })
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
