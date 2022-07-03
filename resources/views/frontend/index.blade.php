@extends('main_frontend')


@section('css')
    <link rel="stylesheet" href="{{ url('/') }}/assets/bower_components/select2/dist/css/select2.min.css">
    <style type="text/css">
    
    </style>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $vars['title'] }}
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">

                         <img src="{{ Auth::user()->img_url }}" onerror="this.src='{{ url('/') }}/assets/dist/img/user.png';"
                     width="5" height="5" class="profile-user-img img-responsive img-circle" alt="User Image">



                      {{--   <i data-toggle="modal" data-target="#uplaod_photo_modal"  data-toggle="tooltip"
                        title="Change Profile Picture"  style="margin-left: 58%; cursor: pointer; font-size: 16px; color: red;" class="fa fa-image"></i> --}}

                        <h3 class="profile-username text-center">@if(isset(Auth::user()->name)) {{ ucwords(Auth::user()->name) }} @endif  @if(isset(Auth::user()->username)) ({{ Auth::user()->username }}) @endif</h3>

                         <p class="text-muted text-center">@if(isset(Auth::user()->email)){{ ucwords(Auth::user()->email) }} @endif</p>


                          <p class="text-muted text-center"> @if(isset(Auth::user()->phone)){{ ucwords(Auth::user()->phone) }} @endif</p>

                          <p class="text-muted text-center" style="color:blue ;" id="p_kifurushi">  
  @if(Auth::user()->is_subscribed == "true" && Auth::user()->end_of_subscription_date > \Carbon\Carbon::now())
        Mwisho wa kifurushi {{  \Carbon\Carbon::parse(Auth::user()->end_of_subscription_date)->format('d/m/Y') }} <a class="btn btn-social-icon btn-flickr reload_payment" ><i class="fa fa-refresh"></i></a>
        @else
        Huna kifurushi     <a class="btn btn-social-icon btn-flickr reload_payment"><i class="fa fa-refresh"></i></a>
        @endif
</p>

                        <ul class="list-group list-group-unbordered">
                        
                            <li class="list-group-item subscription_details" style="cursor: pointer;">
                                <b>Maelezo Ya Kifurushi</b> <a class="pull-right"> <i class="fa fa-chevron-right"></i> </a>
                            </li>

                             <li class="list-group-item change_password" style="cursor: pointer;">
                                <b>Badilisha Password</b> <a class="pull-right"> <i class="fa fa-chevron-right"></i> </a>
                            </li>
                        
                          {{--   <li class="list-group-item contact_detail">
                                <b>Contact Us</b> <a class="pull-right" style="font-size: 13px;"> <i class="fa fa-chevron-right"></i>   </a>
                            </li> --}}
                            {{-- <li class="list-group-item">
                                <b>Phone Number</b> <a class="pull-right">{{ ucwords(Auth::user()->phone) }}</a>
                            </li> --}}

                        </ul>
                      {{--   <a href="javascript:void(0)" data-toggle="modal" data-target="#Edit_user_class_modal" class="btn btn-primary btn-block" ><i class="fa fa-pencil-square-o"></i> <b>Edit Profile</b></a> --}}
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>

            <div class="col-md-9">
                  <div class="box box-primary">
                    <div class="box-body box-profile">
                <p style="font-size: 24px; font-family:'Times New Roman', Times, serif;" class="subscription_details">
                   BOFYA HAPA KULIPIA KIFURUSHI </p>
<img src="/images/paybutton.png" class="subscription_details" alt="Malipo" width="250px;" title="MangeKimambi Android Playstore" />


                   <br><br>
<hr style="border-top: 3px dashed #3c8dbc">
                   {{--  <div class="row">
                        <div class="col-md-6">
                        <p style="font-size: 24px; font-family:'Times New Roman', Times, serif;">
                    bofya hapa kama unatumia android  </p>
                             <a href="https://play.google.com/store/apps/details?id=com.mange.kimambi.app.tz"  target="blank">
                           <img src="/images/android.png" class="_appstore" alt="Android appstore logo" width="250px;" title="MangeKimambi Android Playstore" />
                        </a>
                        </div>
                         <div class="col-md-6">
                             <p style="font-size: 24px; font-family:'Times New Roman', Times, serif;">
                    bofya hapa kama unatumia iphone  </p>
                             <a href="https://apps.apple.com/tz/app/mange-kimambi/id1590902812" target="blank">
                          <img src="/images/ios.png" class="_appstore" alt="Apple appstore logo"  width="250px;" title="MangeKimambi Apple Appstore logo" />
                        </a>
                        </div>
                    </div>
 --}}


            
            </div>
        </div>
            </div>
        
        </div>
        <!-- /.row -->
    </section>
    {{--    @include('students/_guardian/_edit_guardian') --}}


    <div class="modal fade" id="uplaod_photo_modal">
        <div class="modal-dialog modal-sm">
            <div class="box box-primary">

                <div class="box-header with-border">
                    <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                    <br>
                    <h3 class="box-title">Upload Profile</h3>
                </div>
    <form method="POST"  class="prevent-resubmit-form"  action="/profile/{{ Auth::user()->id }}" enctype="multipart/form-data">

                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <div class="box-body">
                        <div class="form-group">
                            <input type="file" name="profile_picture" id="file" class="form-control dropify" data-max-file-size-preview="1M"  required data-allowed-file-extensions="jpeg jpg git gif png" >
                        </div>
                        <input type="hidden" name="image" @if(isset(Auth::user()->image) && Auth::user()->image)  value="{{Auth::user()->image}}" @else value="" @endif >
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary prevent-resubmit-button">Update Profile</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>


    <div class="modal fade" id="Edit_user_class_modal">
        <div class="modal-dialog">
            <div class="box box-primary">

                <div class="box-header with-border">
                    <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                    <br>
                    <h3 class="box-title">Edit My Info</h3>
                </div>
                <form method="POST"  class="prevent-resubmit-form" action="/UserInfoupdate" enctype="multipart/form-data">

                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name:</label>
                            <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" placeholder="Full Name.."  required >
                        </div>

                        <input type="hidden" name="id" value="{{ Auth::user()->id }}">

                        {{-- <div class="form-group">
                            <label for="exampleInputEmail1">Username:</label>
                            <input type="text" name="username" class="form-control" @if(isset(Auth::user()->username)) value="{{ Auth::user()->username }}" @endif placeholder="Full Name.."  required >
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Email:</label>
                            <input type="email" name="email" class="form-control" @if(isset(Auth::user()->email)) value=" {{ Auth::user()->email }}" @endif disabled="true" id="email" placeholder="Email.."  required >
                        </div> --}}

                        <div class="form-group">
                            <label for="exampleInputEmail1">Phone:</label>
                            <input type="text" name="phone" class="form-control"
                             @if(isset(Auth::user()->phone)) value="{{ Auth::user()->phone }}" @endif id="phone" placeholder="Phone.."  required >
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary prevent-resubmit-button">Save</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>


      <div class="modal fade" id="subscriptionModel">
          <div class="modal-dialog modal-md">
            <div class="box box-primary" >

                <div class="box-header with-border">
                    <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                    <br>
                    <h3 class="box-title"> Maelezo ya Kifurushi</h3>
                </div>
            

            <div class="box-body">
                @if(Auth::user()->is_subscribed == "true" && Auth::user()->end_of_subscription_date > \Carbon\Carbon::now())
                <div class="row">
                     <div class="col-md-12">
                          <div class="info-box">
                            <span class="info-box-icon bg-green"><i class="fa fa-thumbs-up"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text"> {{  \Carbon\Carbon::parse(Auth::user()->end_of_subscription_date)->format('l jS F Y') }}</span>
                              <span class="info-box-number">Mwisho wa kifurushi</span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>


                          <div class="col-md-12">
                               <button type="button" class="btn btn-warning btn-lg malipo_button"> Ongeza kifurushi</button>
                               <button type="button" class="btn btn-success btn-lg pending_payments"> Miamala Iliyokwama</button>
                          </div>
                          <br>

                          {{-- <div class="col-md-6">
                          </div> --}}

                          <div style="display:none;" class="malipo_div">
                              @include('frontend.partials._payment_form')

                          </div>
                     </div>
                @else

                <div class="row">
                         <div class="col-md-12">
                              <div class="info-box">
                                <span class="info-box-icon bg-red"><i class="fa fa-hand-stop-o"></i></span>

                                <div class="info-box-content">
                                  {{-- <span class="info-box-text">Not Subscribed (Expired)</span> --}}
                                  <span class="info-box-number">Hauja Jiunga (Kifurushi kimekwisha)</span>
                                </div>
                                <!-- /.info-box-content -->
                              </div>
                              <!-- /.info-box -->
                            </div>
                        </div>

                        <h2 class="page-header">Lipia Kwa</h2>

                     <div class="row">
                        @include('frontend.partials._payment_form')
                    </div>
                @endif
            

            </div>

           <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
              </div>




            </div>
            <!-- /.box -->
        </div>
    </div>

 {{--     <div class="modal fade" id="ContactDetailModel">
          <div class="modal-dialog modal-md">
            <div class="box box-primary" >
                <div class="box-header with-border">
                    <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                    <br>
                    <h3 class="box-title"> Contact Us</h3>
                </div>
            
<form class="prevent-resubmit-form" method="POST" action="/contact_us_form/{{ Auth::user()->id }}" enctype="multipart/form-data">
            <div class="box-body">
              <dl>
                <dt>Je una habari yoyote? Tafadhali tujulishe</dt><br>

                <dd>Whatsapp</dd>
                <dt style="color: red;">+1 424-537-3057</dt><br>


                <dd>Kama hutaki ujulikane kabisa basituletee habari kupitia telegram</dd>
                <dt style="color: red;">@MangekimambiApp</dt><br>


                <dd>Pia tunapatikana kwa email</dd>
                <dt  style="color: red;">mangekimambiblog@gmail.com</dt>
              </dl>
              <br><br>

              <div class="form-group">
                <label for="exampleInputEmail1">Title:</label>
                <input type="text" name="name" class="form-control" placeholder="Full Name.."  required >
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Message:</label>
                <textarea name="massage" class="form-control"></textarea>
            </div>


            <div class="form-group">
                <input type="file" class="form-control" name="documents" multiple>

                <em style="color:red;">You can add multiple images/video</em>
            </div>
         </div>

           <div class="box-footer">
               <button type="submit" class="btn btn-primary prevent-resubmit-button">Submit</button>
              </div>
              </form>
          </div>
     </div>
 </div>
 --}}


  <div class="modal fade" id="PendingPaymentsModal">
          <div class="modal-dialog modal-md">
            <div class="box box-primary" >
                <div class="box-header with-border">
                      <h3 class="box-title">Maelezo ya kifurushi   <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button></h3>
                </div>
                  <div class="box-body">
                     @if(Auth::user()->is_subscribed == "false" || Auth::user()->end_of_subscription_date < \Carbon\Carbon::now())
                      <div class="row">
                         <div class="col-md-12">
                              <div class="info-box">
                                <span class="info-box-icon bg-red"><i class="fa fa-hand-stop-o"></i></span>

                                <div class="info-box-content">
                                  {{-- <span class="info-box-number">Hauja Jiunga (Kifurushi kimekwisha)</span> --}}
                                  <span class="info-box-number">Hauna kifurushi</span>
                                </div>
                                <!-- /.info-box-content -->
                              </div>
                              <!-- /.info-box -->
                            </div>
                        </div>
                      @endif
                         <div class="row">
                         <div class="col-md-12">

                           <h5>Miamala Ambayo hayajakamilika</h5>
                                        <table class="table table-bordered table-striped" id="title_get_unique_stock">

                                    <thead class="thead-dark">
                                    <tr>
                                      
                                        <th>Payment Token <br><em>(Kumbukumbu Namba)</em></th>
                                        <th >Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody class="added_tr">

                                    </tbody>
                                </table>
                            </div>
                         </div>
                        </div>
                      <div class="box-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close(Funga)</button>
              </div>
          </div>
     </div>
 </div>



    <div class="modal fade" id="changePasswordModel">
          <div class="modal-dialog modal-md">
            <div class="box box-primary" >
                <div class="box-header with-border">
                    <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                    <br>
                   
                </div>
                    <form method="POST" action="/update_password" id="update_password">
                  <div class="box-body">
                      <div class="row">
                         <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Password Mpya:</label>
                                    <input type="password" name="passwordIsNew" class="form-control"   required >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Rudia Password:</label>
                                     <input type="password" name="passwordIs_confirmation" class="form-control"   required >
                                </div>
                            </div>
                        </div>
                         @csrf
                        </div>
                      <div class="box-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary pull-right">Save changes</button>
                     </div>
                     </form>
              </div>
          </div>
     </div>

    

     <div class="modal fade" id="add_email_modal_for_users">
          <div class="modal-dialog modal-md">
            <div class="box box-primary" >
                <div class="box-header with-border">
                    <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                    <br>
                   Weka Barua pepe/Email yako ili ukipoteza neno la siri tuweze kukutumia jingine kupitia Barua pepe/Email yako
                </div>
                    <form method="POST" class="prevent-resubmit-form" action="/update_email" id="update_email">
                  <div class="box-body">
                      <div class="row">
                         <div class="col-md-12">
                                 <div class="form-group" id="check_mail_here_div">
                                    <label for="exampleInputEmail1">Email:</label>
                                     <p style="color:red; font-size: 9px;" id="append_text_here_mail_error"></p>
                                     <input type="email" value="{{Auth::user()->email}}" class="form-control" value="{{ old('email') }}" name="email" id="email_change_blur" placeholder="Barua Pepe/Email" required>
                                 </div>
                                 <input type="hidden" name="id" value="{{Auth::user()->id}}" >
                            </div>
                        </div>
                         @csrf
                        </div>
                      <div class="box-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Ntaweka siku Nyingine</button>
                <button type="submit" id="email_update_button" class="btn btn-primary pull-right prevent-resubmit-button">Save Barua pepe/Email</button>
                     </div>
                     </form>
              </div>
          </div>
     </div>

      <div class="modal fade" id="add_email_code_vefiry_modal_for_users">
          <div class="modal-dialog modal-md">
            <div class="box box-primary" >
                <div class="box-header with-border">
                    <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                    <br>
                  Weka verification code iliyotumwa kwenye email yako kuthibitisha email ni yako
                </div>
                    <form method="POST" class="prevent-resubmit-form" action="/verify_code" id="verify_code">
                  <div class="box-body">
                      <div class="row">
                         <div class="col-md-12">
                                 <div class="form-group" >
                                    <label for="exampleInputEmail1">Vefirication code/Number ya utambulisho:</label>
                                     <input type="text"  class="form-control" value="{{ old('verification') }}" name="verification"  placeholder="Verification Code" required>
                                 </div>
                                 <input type="hidden" name="id" value="{{Auth::user()->id}}" >
                            </div>
                        </div>
                         @csrf
                        </div>
                      <div class="box-footer">
                <button type="button" class="btn btn-warning send_email_again" data-dismiss="modal">Tuma Tena email </button>
                <button type="submit" class="btn btn-primary pull-right prevent-resubmit-button">Verify Code</button>
                     </div>
                     </form>
              </div>
          </div>
     </div>




 </div>

@endsection

{{-- @if(isset(Auth::user()->end_of_subscription_date) && Auth::user()->end_of_subscription_date != "" && Auth::user()->end_of_subscription_date)
                @php
                 $date = date("Y-m-d",Auth::user()->end_of_subscription_date/1000);
                $reliable = \Carbon\Carbon::parse($date)->endOfDay(); 
                @endphp
                @if(\Carbon\Carbon::now() < $reliable)
                @else
                  $('#subscriptionModel').modal('show');
                @endif
             @else 
                 $('#subscriptionModel').modal('show');
             @endif --}}

@section('js')
    <script src="{{ url('/') }}/assets/bower_components/select2/dist/js/select2.full.min.js"></script>

    <!-- InputMask -->
<script src="{{ url('/') }}/assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="{{ url('/') }}/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="{{ url('/') }}/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>


{{-- <script src="https://www.paypal.com/sdk/js?client-id={{env('PAYPAL_SANDBOX_CLIENT_ID')}}"></script> --}}





 
    <script type="text/javascript">

@if(\Session::has('error'))
     swal( 'Error', '{{ \Session::get('error') }}', 'error');
{{ \Session::forget('error') }}
    @endif

    @if(\Session::has('success'))
     swal('success', '{{ \Session::get('success') }}', 'success' );
{{ \Session::forget('success') }}
    @endif




$(document).on("click","#payPal_button",function(){

    console.log('Redirecting...!');
     run_waitMe('ios','paypal_payments_form','Redirecting...!');
});

$(document).ready(function(){
@if(!Auth::user()->email)
// $('#add_email_modal_for_users').modal('show');
@endif
})

$(document).ready(function(){
@if(Auth::user()->email && !Auth::user()->email_verified_at)
// $('#add_email_code_vefiry_modal_for_users').modal('show');
@endif
})

$(document).on("click",".pending_payments",function(){
     getpending_payment('{{Auth::user()->id}}');
});

$(document).on("click",".reload_payment",function(){
      $.ajax({
                  type: "get",
                  url: '/reload_payment_date',
                  processData: false,
                  contentType: false,
           
                   success: function (data) {
                        swal( "Success",
                             data,
                           "success"
                      );
                      $('#p_kifurushi').html(data);
                      
                  
                   },error: function (xhr, ajaxOptions, thrownError){
                  console.log(xhr.responseText);
              }
              });
});





    
      function validateEmail(emailAdress)
        {
          let regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
          if (emailAdress.match(regexEmail)) {
            return true; 
          } else {
            return false; 
          }
        }

     $(document).on("change","#email_change_blur", function(){
      
        var name = $(this).val();

        var old = "{{Auth::user()->email}}";

        if(old.length && name == old){
          // $("#append_text_here_mail_error").html("Please change email/Badilisha barua pepe tafadhali");
          return false;    
        }

        $("#email_update_button").attr("disabled","true");
        if(!validateEmail(name)){
                           $("#email_update_button").attr("disabled","true");
                            $("#check_mail_here_div").addClass("has-error");
                            $("#check_mail_here_div").removeClass("has-feedback");
                            $("#append_text_here_mail_error").html("Invalid Email / Barua Pepe sio sahihi"); 
                            return false;
                        }
        $.ajax({
        type: "GET",
        url: '/verify_email/'+name,
        success: function (data) { 
                      if(data){
                            $("#email_update_button").attr("disabled","true");
                            $("#check_mail_here_div").addClass("has-error");
                            $("#check_mail_here_div").removeClass("has-feedback");
                            $("#append_text_here_mail_error").html("Email Exists Please Change / Barua pepe inatumika na mtu mwingine tafadhali badilisha");

                            }else{
                            $("#check_mail_here_div").addClass("has-feedback")
                            $("#check_mail_here_div").removeClass("has-error");
                            $("#email_update_button").removeAttr("disabled"); 
                            $("#append_text_here_mail_error").html("")

                      } 
                 },
            });
        
    })

     @if(Session::has('message'))
  $(document).ready(function() {
    swal( "Info",
          "{!! Session::get('message') !!}",
           "info"
      )
  });
@endif


$(document).on('click', '.check_payment_status', function(){
         var id = $(this).data('id');
         var link = $(this).data('link');

          $.ajax({
                  type: "get",
                  url: '/payments/'+id,
                  processData: false,
                  contentType: false,
                   beforeSend: function(){ run_waitMe('ios','PendingPayments',''); },
                   complete: function(){ $('#PendingPayments').waitMe("hide");},
                   success: function (data) {
                      if(data.error){
                        swal(
                            'Error',
                            data.error,
                            'error'
                        );
                      }else if(data.push){
                         swal(
                            'Request in progress',
                             data.push,
                            'warning'
                        );
                      }else if(data.pending){
                        swal(
                            'Pending',
                            'Muamala huu bado haujalipiwa subiri tukuunganishe Kwenye Page Yamalipo',
                            'warning'
                        );
                         setTimeout(
                            function() {
                                window.location.href= link;
                            }, 600);
                        
                      
                      }else{
                        swal(
                            'Done',
                            data.done,
                            'success'
                        );

                           setTimeout(
                            function() {
                               window.location.reload();
                            }, 300);
                      }
                  
                   },error: function (xhr, ajaxOptions, thrownError){
                  console.log(xhr.responseText);
              }
        });

     });

 


$(document).on('click', '.malipo_button', function(){
    $(".malipo_div").toggle();
 });



$(document).on('click', '.voda_payment_status', function(){
         var id = $(this).data('id');

          $.ajax({
                  type: "get",
                   url: '/vodacom_web_verification/{{Auth::user()->id}}/'+id,
                  processData: false,
                  contentType: false,
                   beforeSend: function(){ run_waitMe('ios','PendingPayments',''); },
                   complete: function(){ $('#PendingPayments').waitMe("hide");},
                   success: function (data) {
                      if(data.error){
                        swal(
                            'Error',
                            data.error,
                            'error'
                        );
                     
                      
                      }else{
                        swal(
                            'Done',
                            data.done,
                            'success'
                        );

                           setTimeout(
                            function() {
                               window.location.reload();
                            }, 400);
                      }
                  
                   },error: function (xhr, ajaxOptions, thrownError){
                  console.log(xhr.responseText);
              }
        });

     });

     $(document).on('submit', '#update_password', function(e){
       e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formdata = new FormData(this);

            $.ajax({
                type: "POST",
                url: '/update_password',
                processData: false,
                contentType: false,
                data: formdata,
                 beforeSend: function(){ run_waitMe('ios','update_password',''); },
                    complete: function(){ $('#update_password').waitMe("hide"); },
              success: function (data) {
                    document.getElementById("update_password").reset();

                    if(data.error){
                        swal( "Error",
                        data.error,
                           "error"
                      );
                    }else{
                        swal( "Success",
                        data.done,
                           "success"
                      );

                          $('.close').click();
                    }
                 },
                error: function (xhr, ajaxOptions, thrownError){
                   $('.prevent-resubmit-button').prop("disabled", false);
                   $('.prevent-resubmit-button').html('Submit');
                     show_alert('danger', xhr.responseText);
            }
            });
          });




         function getpending_payment(id){
            var id = id;
                  $.ajax({
                  type: "get",
                  url: '/get_pending_payments/'+id,
                  processData: false,
                  contentType: false,
                   beforeSend: function(){ run_waitMe('ios','PendingPayments',''); },
                   complete: function(){ $('#PendingPayments').waitMe("hide");},
                   success: function (data) {
                    if(data){
                      $('.added_tr').empty();
                      $('#title_get_unique_stock').append(data);
                      $('#PendingPaymentsModal').modal('show');  
                         // $('#subscriptionModel').modal('show'); 
                      
                    }else{
                      $('#subscriptionModel').modal('show');
                        swal( "Success",
                        "Hauna miamala Iliyokwama",
                           "success"
                      );
                    }
                  
                   },error: function (xhr, ajaxOptions, thrownError){
                  console.log(xhr.responseText);
              }
              });

         }

      @if(Auth::user()->is_subscribed == "true" && Auth::user()->end_of_subscription_date > \Carbon\Carbon::now())


      @else
        getpending_payment('{{Auth::user()->id}}');
      @endif
    

         

     $(window).on('resize', function(){
            if ($(window).width() < 601) {
                $(function(){
                    $('.navbar_custom_made').css('display', '');
                });
            }
            else if($(window).width() > 600){
                $(function(){
                    $('.navbar_custom_made').css('display', 'none');
                });
            }
        });

        $(document).ready(function () {

            if ($(window).width() < 600) {
                $(function () {
                    $('.navbar_custom_made').css('display', '');
                });
            } else if ($(window).width() > 600) {
                $(function () {
                    $('.navbar_custom_made').css('display', 'none');
                });
            }
        });


        $('.subscription_details').click(function(){
             $('#subscriptionModel').modal('show');
                
            });


        $('.change_password').click(function(){
             $('#changePasswordModel').modal('show');
                
            });


          $('.contact_detail').click(function(){
             $('#ContactDetailModel').modal('show');
                
            });





$(document).on('submit', '#mobile_payments_form', function(e){
        e.preventDefault();
        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('[name="_token"]').val()
                    }
              });

         var formdata = new FormData(this);

        @if(isset(Auth::user()->id))
         formdata.append('buyer_userid', '{{Auth::user()->id}}');
        @endif

             $.ajax({
                  type: "POST",
                  url: '/mobile_payments',
                  processData: false,
                  contentType: false,
                   data: formdata,
                   beforeSend: function(){ run_waitMe('ios','mobile_payments_form','Sending....'); },
                   complete: function(){ $('#mobile_payments_form').waitMe("hide");},
                   success: function (data) {
                        $('.close').click();
                    if(data.error){
                      swal_info_alert('Fail',data.error,'error');
                    }else if(data.push){
                        swal(
                            'Request in progress',
                            data.push,
                            'success'
                        );
                    }else{
                       window.location.href= data.done;
                    }

                  
                   },error: function (xhr, ajaxOptions, thrownError){
                  console.log(xhr.responseText);
              }
              });
    });

$(document).on('submit', '#card_payments_form', function(e){
        e.preventDefault();
        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('[name="_token"]').val()
                    }
              });

         var formdata = new FormData(this);

        @if(isset(Auth::user()->id))
         formdata.append('buyer_userid', '{{Auth::user()->id}}');
        @endif

             $.ajax({
                  type: "POST",
                  url: '/card_payments',
                  processData: false,
                  contentType: false,
                   data: formdata,
                   beforeSend: function(){ run_waitMe('ios','card_payments_form','Sending....'); },
                   complete: function(){ $('#card_payments_form').waitMe("hide");},
                   success: function (data) {
                        $('.close').click();
                    if(data.error){
                      swal_info_alert('Fail',data.error,'error');
                    }else{
                       window.location.href= data.done;
                    }

                  
                   },error: function (xhr, ajaxOptions, thrownError){
                  console.log(xhr.responseText);
              }
              });
    });




$(document).on('click', '.deletePay', function () {
    var id = $(this).data("id");
    var address = $(this).data("address");
    var token = $('meta[name="csrf-token"]').attr('content');
    var force = $(this).data("force");
    var $tr = $(this).closest("tr");
    swal({
        title: 'Hakiki Kufuta muamala huu?',
        text: "Hauta rejeshwa tena",
        type: 'warning',
        showCancelButton: true,
          confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ndio ,Futa!!",
            cancelButtonText: "Hapana, Usifute !!",
    }).then(function () {

        $.ajax(
            {
                url: "/" + address + "/" + id,
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
                            name + ' has been deleted successful',
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
