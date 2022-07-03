<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
       <title>Mange | Log in</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Habari za Jamii, michezo na udaku" />
        <link rel="stylesheet" href="{{ url('/') }}/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ url('/') }}/assets/bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ url('/') }}/assets/bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ url('/') }}/assets/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="{{ url('/') }}/assets/plugins/loading/waitMe.css">
        <link href="{{ url('/') }}/assets/plugins/sweet-alert/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
        {{-- <link rel="stylesheet" href="{{ url('/') }}/assets/plugins/country_code/css/prism.css">
        <link rel="stylesheet" href="{{ url('/') }}/assets/plugins/country_code/build/css/intlTelInput.css?1638200991544">
        <link rel="stylesheet" href="{{ url('/') }}/assets/plugins/country_code/build/css/demo.css?1638200991544">
     
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-N472J4QKC4"></script> --}}
        <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-N472J4QKC4');
    </script>

        <style type="text/css">
            #login {
  width: 100%;
  max-width: 800px;
  margin: 45px auto;
  display: flex;
  justify-content: space-around;
}

#login .column {
  width: 45%;
}

._phone {
  max-width: 100%;
}

._box {
  background-color: white;
  border: 1px solid #e6e6e6;
}



.column ._appstores {
  margin-top: 20px;
}

._appstores ._appstore {
  height: 40px;
}

#login ._box {
  padding: 30px 0;
  text-align: center;
}

#login ._box:first-child {
  margin-bottom: 10px;
  padding-left: 40px;
  padding-right: 40px;
}

.column  {
  height: 70px;
}

._form input {
  display: block;
  width: 100%;
  box-sizing: border-box;
  padding: 7px;
  font-size: 14px;
  border: 0;
  border: 1px solid #e6e6e6;
  border-radius: 5px;
  background: #fafafa;
}

._form input:focus {
  outline: none;
  border: 1px solid #a9a9a9;
}

._form input:first-child {
  margin-bottom: 5px;
}

._form input[type="submit"] {
  background-color: #3f99ed;
  border: 0;
  padding: 5px;
  margin-top: 15px;
  margin-bottom: 20px;
  color: white;
  font-weight: 600;
}




#login .divider {
  display: block;
  text-transform: uppercase;
  font-weight: 600;
  color: #999;
  margin-bottom: 20px;
  position: relative;
  width: 100%;
}

#login ._link {
  display: block;
  text-decoration: none;
  color: #003569;
}

#login ._link--small {
  margin-top: 30px;
}

._box a {
  text-decoration: none;
  color: var(--fd-blue);
}

._form_div2{
 padding: 0px 45px 0px 45px; !important;
}

#login .divider:before {
  content: "";
  height: 1px;
  background-color: rgba(153, 153, 153, 0.5);
  width: 40%;
  position: absolute;
  left: 0;
  top: 10px;
}

#login .divider:after {
  content: "";
  height: 1px;
  background-color: rgba(153, 153, 153, 0.5);
  width: 40%;
  position: absolute;
  right: 0;
  top: 10px;
}

@media screen and (max-width: 1000px) {
  .div_phone {
    visibility: hidden;

  }


}


</style>
    </head>
    <body id="body_id">
        @if(Session::has('error'))
    <div class="alert-container">
        <div class="alert alert-{{Session::get('flash_type','danger')}} alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa {{{Session::get('flash_icon','fa-ban')}}}"></i> {{{Session::get('flash_type','Alert')}}}!</h4>
            {{ Session::get('error') }}.
        </div>
    </div>
    @if ($errors->has('email'))
        <span class="invalid-feedback text-red" role="alert"> </span>
        <div class="alert-container">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-close"></i> <strong>{{ $errors->first('email') }}</strong></h4>
            </div>
        </div>
    @endif
   @if($errors->has('password_confirmation'))
    <span class="invalid-feedback text-red" role="alert"> </span>
    <div class="alert-container">
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-close"></i> <strong>{{ $errors->first('password_confirmation') }}</strong></h4>
        </div>
    </div>
    @endif
    @if($errors->has('password'))
        <span class="invalid-feedback text-red" role="alert"> </span>
        <div class="alert-container">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-close"></i> <strong>{{ $errors->first('password') }}</strong></h4>
            </div>
        </div>
    @endif
    @if($errors->has('name'))
        <span class="invalid-feedback text-red" role="alert"> </span>
        <div class="alert-container">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-close"></i> <strong>{{ $errors->first('name') }}</strong></h4>
            </div>
        </div>
    @endif
    @if($errors->has('phone'))
        <span class="invalid-feedback text-red" role="alert"> </span>
        <div class="alert-container">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-close"></i> <strong>{{ $errors->first('name') }}</strong></h4>
            </div>
        </div>
    @endif
@endif
        <main id="login">
            <div class="row">
                 <div class="col-md-0 col-lg-6 col-sm-2 col-xs-0 hidden-xs hidden-sm hidden-md div_phone">
                    
                        <img src="/images/phoneImage.png" class="_phone hidden-xs hidden-sm hidden-md" />
                    
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                
                <div class="_box log_in_div">
                    <img src="/logo.png"  style="width:150px; height: 70;" />

                     <form method="POST" action="{{ route('login') }}" class="_form prevent-resubmit-form">
                         @csrf

                         @if ($errors->has('email'))
                            <span class="invalid-feedback text-red" role="alert">
                                      <strong>{{ $errors->first('email') }}</strong>
                                  </span>
                        @endif
                        <div class="form-group">
                        <input type="text" name="email" placeholder="Username  / Barua Pepe" required />
                       </div>
                        <div class="form-group">
                          <input type="password" name="password" placeholder="Neno La siri / Password" required />
                        </div>
                        @if ($errors->has('password'))
                        <span class="invalid-feedback text-red" role="alert">
                              <strong>{{ $errors->first('password') }}</strong>
                          </span>
                        @endif
                        
                        <button type="submit" class="btn btn-primary btn-block btn-flat prevent-resubmit-button" id="submit_login" style="background-color: #050505 !important;">Ingia</button>
                    </form>
                    <span class="divider">or</span>
                   <span style="cursor:pointer; color:#4B00A5; font-weight: bold;" class="go_reset_password">Nimesahau Neno La Siri</span><br><br>
                    {{-- <a href="#" class="_link">
                        <i class="fa fa-money"></i>
                        Log in with Facebook
                    </a>
                    <a href="#" class="_link _link--small">Forgot password</a> --}}
                     <span>Sina account?</span> <span style="cursor:pointer; color:#4B00A5; font-weight: bold;" class="go_sign_up">Jisajili</span>
                </div>



                <div class="_box sign_up_div" style="display:none">
                    <img src="/logo.png"  style="width:150px; height: 70;" />
                    <p style="font-size: 24px; font-family:'Times New Roman', Times, serif;"><b>Tafadhari jisajili hapa, Kisha ingia Mange Kimambi APP</b></p>
                  <form method="POST" action="{{ route('register') }}" class="_form prevent-resubmit-form">
                       @csrf

                        
                        {{-- <div class="form-group _form_div2">
                         <input type="text" name="name"  value="{{ old('name') }}" placeholder="Jina Kamili/Name" >
                       </div>
                         <div class="form-group _form_div2" id="check_mail_here_div"  style="">
                            <p style="color:red; font-size: 9px;" id="append_text_here_mail_error"></p>
                            <input type="email" value="{{ old('email') }}" name="email" id="email_change_blur" placeholder="Barua Pepe/Email" >
                        </div> --}}

                        <div class="form-group _form_div2" id="check_user_name_div">
                            <p style="color:red; font-size: 9px;" id="append_text_here_error"></p>
                            <input type="text" value="{{ old('username') }}" id="username_change_blur" name="username"  placeholder="Jina La Kutumia/ User Name" required>
                        </div>

                        {{-- <div class="form-group _form_div2" >
                            <p style="color:red; font-size: 9px;" id="phone_number_exist_error"></p>
                            <input type="tel" id="phone" value="{{ old('phone') }}" name="phone"  placeholder="Number Ya Simu/ Phone" required>
                        </div> --}}

                        <div class="form-group _form_div2">
                            <input type="text" id="passowrd_entry_here" class="password_change_tot" placeholder="Neno La Siri/Password" name="password" required>
                        </div>

                        {{-- <div class="form-group _form_div2" id="password_did_not_match_here_error_div">
                            <p style="color:red; font-size: 9px;" id="password_did_not_match_here_error"></p>
                            <input id="password-confirm" placeholder="Thibitisha neno la Siri/Confirm Password" type="password" class=" password_change_tot" name="password_confirmation" required autocomplete="new-password">
                        </div> --}}
                        <div class="form-group _form_div2">
                            <button id="sign_up_button_link_check_here" type="submit" class="btn btn-primary btn-block btn-flat prevent-resubmit-button" style="background-color: #050505 !important;">Endelea</button>
                         </div>
                    </form>
                    <span class="divider">or</span>
                    {{-- <a href="#" class="_link">
                        <i class="fa fa-money"></i>
                        Log in with Facebook
                    </a>
                    <a href="#" class="_link _link--small">Forgot password</a> --}}
                     <span>Nina Account ?</span> <span style="cursor:pointer; color:#4B00A5; font-weight: bold;" class="go_sign_in">Login</span>
                </div>

                <div id="reset_password_load_view" class="_box reset_password_div_up_div" style="display:none">
                    <p style="font-size: 11px; color:blue;">Ingiza Barua Pepe / Email Utumiwe neno la siri</p>
                    <form method="POST" class="_form" id="forms_email_reset_password">
                        @csrf
                        <div class="form-group _form_div2">
                            <p style="color:red; font-size: 9px;" id="append_text_here_reset_password_error"></p>
                            <input type="email" name="email" id="email_reset_password" placeholder="Barua Pepe / Email" required>
                        </div>
                        <div class="form-group _form_div2">
                            <button id="reset_password_clicked_up_button_link_check_here" type="submit" class="btn btn-primary btn-block btn-flat prevent-resubmit-button" style="background-color: #050505 !important;">Reset Password</button>
                         </div>
                     </form>
                          <span class="divider">or</span>
                           <span> Rudi Nyuma</span> <span style="cursor:pointer; color:#4B00A5; font-weight: bold;" class="go_sign_in">Login</span>
                           <br> <br>
                           <span>Sina Account</span> <span style="cursor:pointer; color:#4B00A5; font-weight: bold;" class="go_sign_up">Jisajili</span> 


                    </div>
                </div>
                   <div id="enter_new_password_load_view" class="_box enter_new_password_div_up_div" style="display:none">
                    <div class="_form">
                        <div class="form-group _form_div2">
                            <p style="color:red; font-size: 9px;" id="append_text_here_new_password_error"></p>
                            <input class="password_change_tot_new" type="password" name="password" id="new_password_form_reset_password" placeholder="enter new Password" required>
                        </div>
                        <div class="form-group _form_div2">
                            <p style="color:red; font-size: 9px;"></p>
                            <input class="password_change_tot_new" type="password" name="confirm_password" id="confirm_password_form_reset_password"  placeholder="Confirm new Password" required>
                        </div>
                        <input type="hidden" name="ooobCode" id="append_ooob_code_here_Selector">
                        <div class="form-group _form_div2">
                            <button id="save_new_password_clicked_here" type="button" class="btn btn-primary btn-block btn-flat prevent-resubmit-button" style="background-color: #050505 !important;">Save New Password</button>
                         </div>

                          <span class="divider">or</span>
                           <span> Back to</span> <span style="cursor:pointer; color:#4B00A5; font-weight: bold;" class="go_sign_in">Login</span>
                           <br> <br>
                           <span>Don't have an account?</span> <span style="cursor:pointer; color:#4B00A5; font-weight: bold;" class="go_sign_up">Sign up</span> 
                    </div>
                </div>
                <br>
                <div class="_box ">
                    <span style="padding-bottom: 20px;"><b>Download App Yetu.</b></span>
                   
                    <div class="_appstores">
                         <a href="https://apps.apple.com/tz/app/mange-kimambi/id1590902812" target="blank">
                          <img src="/images/ios.png" class="_appstore" alt="Apple appstore logo" title="MangeKimambi Apple Appstore logo" />
                        </a>
                        <a href="https://play.google.com/store/apps/details?id=com.mange.kimambi.app.tz" target="blank">
                           <img src="/images/android.png" class="_appstore" alt="Android appstore logo" title="MangeKimambi Android Playstore" />
                        </a>
                    </div>
                </div>
           
                </div>
                
            </div>

           
            
        </main>

    </body>
     <script src="{{ url('/') }}/assets/bower_components/jquery/dist/jquery.min.js"></script>
     <script src="{{ url('/') }}/assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
     <script src="{{ url('/') }}/assets/plugins/loading/waitMe.js"></script>
     <script src="{{ url('/') }}/assets/plugins/sweet-alert/sweetalert2.min.js"></script>
    {{--  <script src="{{ url('/') }}/assets/plugins/country_code/js/prism.js"></script>
    <script src="{{ url('/') }}/assets/plugins/country_code/build/js/intlTelInput.js?1638200991544"></script>
    <script src="{{ url('/') }}/assets/plugins/country_code/new/js/defaultCountryIp.js?1638200991544"></script> --}}

  
    <script type="text/javascript">

//         var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
//         var input = document.querySelector("#phone");

//  input.addEventListener('blur', function() {
//   if (input.value.trim()) {
//     if (iti.isValidNumber()) {
//        console.log('invallid')
//     } else {
   
//       var errorCode = iti.getValidationError();
//        swal("Error",errorMap[errorCode],"error");
       

//     }
//   }
// });

   $('.prevent-resubmit-form').on('submit', function () {
    $('.prevent-resubmit-button').prop("disabled", true);
    $('.prevent-resubmit-button').html('<i class="icon-append fa fa-spinner fa-spin fa-fw"></i> Sending..');
  });

   jQuery(document).ready(function ($) {
        $(".form-control").each(function () {
            var required = $(this).attr('required');
            if (typeof required !== typeof undefined && required !== false) {
                var label = $(this).parent().find('label');
                var name = label.html();
                label.html(name + "<i style=\"color:red; font-size:16px;\">*</i>");
            }
        });
    });


   $(document).on('submit', '#forms_email_reset_password', function(e){
       e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formdata = new FormData(this);

            $.ajax({
                type: "POST",
                url: '/email_reset_password',
                processData: false,
                contentType: false,
                data: formdata,
                 beforeSend: function(){ run_waitMe('ios','forms_email_reset_password',''); },
                    complete: function(){ $('#forms_email_reset_password').waitMe("hide"); },
              success: function (data) {
                    document.getElementById("forms_email_reset_password").reset();

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
                    }
                 },
                error: function (xhr, ajaxOptions, thrownError){
                   $('.prevent-resubmit-button').prop("disabled", false);
                   $('.prevent-resubmit-button').html('Submit');
                    close_modal('guardian_create_model');
                     show_alert('danger', xhr.responseText);
            }
            });
          });

 @if($errors->has('email') || $errors->has('username') || $errors->has('password_confirmation') || $errors->has('password') || $errors->has('name') || $errors->has('phone'))
 $(document).ready(function(){
    swal( "Error",
          "{!!    $errors->first('name') !!}\n{!!    $errors->first('username') !!}\n{!!    $errors->first('password_confirmation') !!}\n{!!    $errors->first('password') !!}\n{!!    $errors->first('phone') !!}\n{!!    $errors->first('email') !!}\n",
           "error"
      );
    // $('.go_sign_up').click();
  });
 @endif

  @if(Session::has('error'))
   $(document).ready(function(){
    swal( "Error",
          "{!!    Session::get('error') !!}",
           "error"
      )
    // $('.go_sign_up').click();
  });

  @endif

           
    //       var input = document.querySelector("#phone");
    // window.intlTelInput(input, {
    //   allowDropdown: true,
    //   autoHideDialCode: false,
    //   autoPlaceholder: "on",
    //   dropdownContainer: document.body,
    //   formatOnDisplay: true,
    //   geoIpLookup: function(callback) {
    //     $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
    //       var countryCode = (resp && resp.country) ? resp.country : "";
    //       callback(countryCode);
    //     });
    //   },
    //   initialCountry: "auto",
    //   localizedCountries: { 'de': 'Deutschland' },
    //   nationalMode: false,
    //   placeholderNumberType: "MOBILE",
    //   preferredCountries: ['tz','cn', 'jp' ,'us'],
    //   separateDialCode: false,
    //   utilsScript: "build/js/utils.js",
    // });



        // $("#phone").intlTelInput();

         
        function run_waitMe(effect,selector,text){ //effect  win8, win8_linear,bounce, orbit, ios,stretch,roundBounce rotateplane
    $('#'+selector).waitMe({
        effect: effect,
        text: text,
        bg: 'rgba(255,255,255,0.7)',
        color: '#000',
        maxSize: '',
        waitTime: -1,
        source: '',
        textPos: 'vertical',
        fontSize: '',
        onClose: function() {}
  });
}

 @if(Session::has('message'))
  $(document).ready(function() {
    swal( "Error",
          "{!! Session::get('message') !!}",
           "error"
      )
  });
@endif



$(document).on("click","#save_new_password_clicked_here",function(){
   var pass = $("#confirm_password_form_reset_password").val();
   var oob = $("#append_ooob_code_here_Selector").val();


        var formdata = new FormData();
        formdata.append("_token","{{ csrf_token() }}");
        formdata.append("pass",pass);
        formdata.append("oob",oob);

         $.ajax({
                    type: "POST",
                    url: '/save_new_password',
                    processData: false,
                    contentType: false,
                    data: formdata,
                    beforeSend: function(){ run_waitMe('ios','enter_new_password_load_view',''); },
                    complete: function(){ $('#enter_new_password_load_view').waitMe("hide");},
                    success: function (data) {
                            $( ".log_in_div" ).show();
                            $( ".enter_new_password_div_up_div" ).hide();
                    },
                    error: function (xhr, ajaxOptions, thrownError){

                    }
            });
})


$(document).on("keyup",".password_change_tot_new", function(){
           var cpass =  $("#new_password_form_reset_password").val();
           var pass = $("#confirm_password_form_reset_password").val();

            if(cpass != pass){
                $("#save_new_password_clicked_here").attr("disabled","true");
                $("#append_text_here_new_password_error").html("Password don't match");

                }else{
                $("#save_new_password_clicked_here").removeAttr("disabled");
                $("#append_text_here_new_password_error").html("")

                }
        })

// $(document).on("click","#reset_password_clicked_up_button_link_check_here",function(){
//       var value = $("#email_reset_password").val();
//        if(!validateEmail(value)){
//                             $("#append_text_here_reset_password_error").html("Invalid Email"); 
//                             return false;
//         }

//         $.ajax({
//         type: "GET",
//         url: '/reset_password_email/'+value,
//         beforeSend: function(){ run_waitMe('ios','reset_password_load_view',''); },
//         complete: function(){ $('#reset_password_load_view').waitMe("hide");},
//         success: function (data) { 
//                             // $("#append_ooob_code_here_Selector").val(data);
//                             swal( "Success",
//                                   "Password reset link as been sent to you email",
//                                   "success"
//                                 )
//                             $( ".sign_up_div" ).hide();
//                             $( ".log_in_div" ).show();
//                             // $( ".enter_new_password_div_up_div" ).show();
//                             $( ".reset_password_div_up_div" ).hide();
//                  },
//             });
// })


$('#submit_login').click(function(){

    run_waitMe('ios','body_id','');
 });


$('.go_sign_in').click(function(){
    $( ".sign_up_div" ).hide();
    $( ".log_in_div" ).show();
     $( ".reset_password_div_up_div" ).hide();
 });


$('.go_sign_up').click(function(){
    $( ".log_in_div" ).hide();
    $( ".sign_up_div" ).show();
     $( ".reset_password_div_up_div" ).hide();
 });

$('.go_reset_password').click(function(){
    $( ".log_in_div" ).hide();
    $( ".sign_up_div" ).hide();
    $( ".reset_password_div_up_div" ).show();
 });




 $(document).on("keyup",".password_change_tot", function(){
           // var cpass =  $("#password-confirm").val();
           // var pass = $("#passowrd_entry_here").val();
           // var username = $("#append_text_here_error").html();
           // var email = $("#append_text_here_mail_error").html();
           // var phone =   $("#phone_number_exist_error").html();

            // if(cpass != pass){
            //     $("#sign_up_button_link_check_here").attr("disabled","true");
            //     $("#password_did_not_match_here_error_div").addClass("has-error");
            //     $("#password_did_not_match_here_error_div").removeClass("has-feedback");
            //     $("#password_did_not_match_here_error").html("Password don't match");

            //     }else{
            //     $("#password_did_not_match_here_error_div").addClass("has-feedback")
            //     $("#password_did_not_match_here_error_div").removeClass("has-error");
            //     // if(username.length == 0 && email.length == 0 && phone.length == 0 ){
            //     if(username.length == 0){     
            //     $("#sign_up_button_link_check_here").removeAttr("disabled");
            //     }
            //     $("#password_did_not_match_here_error").html("")

            //     }
        })





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
        var username = $("#append_text_here_error").html();
        var password =  $("#password_did_not_match_here_error").html();
        var phone =   $("#phone_number_exist_error").html();
        var name = $(this).val();

        $("#sign_up_button_link_check_here").attr("disabled","true");
        if(!validateEmail(name)){
                           $("#sign_up_button_link_check_here").attr("disabled","true");
                            $("#check_mail_here_div").addClass("has-error");
                            $("#check_mail_here_div").removeClass("has-feedback");
                            $("#append_text_here_mail_error").html("Invalid Email"); 
                            return false;
                        }
        $.ajax({
        type: "GET",
        url: '/verify_email/'+name,
        success: function (data) { 
                     console.log(data);
                      if(data){
                            $("#sign_up_button_link_check_here").attr("disabled","true");
                            $("#check_mail_here_div").addClass("has-error");
                            $("#check_mail_here_div").removeClass("has-feedback");
                            $("#append_text_here_mail_error").html("Email Exists Please Change");

                            }else{
                            $("#check_mail_here_div").addClass("has-feedback")
                            $("#check_mail_here_div").removeClass("has-error");
                            if(username.length == 0 && phone.length == 0 && password.length == 0){
                               $("#sign_up_button_link_check_here").removeAttr("disabled"); 
                            }
                            $("#append_text_here_mail_error").html("")

                      } 
                 },
            });
        
    })


    // $(document).on("change","#phone", function(){
    //     var username = $("#append_text_here_error").html();
    //     var email = $("#append_text_here_mail_error").html();
    //       var password =  $("#password_did_not_match_here_error").html();
    //     var name = $(this).val();

    //     $("#sign_up_button_link_check_here").attr("disabled","true");
    //     $.ajax({
    //     type: "GET",
    //     url: '/verify_phone/'+name,
    //     success: function (data) { 
                    
    //                   if(data){
    //                         $("#sign_up_button_link_check_here").attr("disabled","true");
    //                         $("#phone_number_exist_error").html("Phone Number Exists Please Change");

    //                         }else{
    //                         $("#check_mail_here_div").addClass("has-feedback")
    //                         $("#check_mail_here_div").removeClass("has-error");
    //                         if(email.length == 0 && username.length == 0 && password.length == 0){
    //                            $("#sign_up_button_link_check_here").removeAttr("disabled"); 
    //                         }
    //                         $("#phone_number_exist_error").html("")

    //                   } 
    //              },
    //         });
        
    // })


    

    


    $(document).on("change keyup","#username_change_blur", function(){
        // var email = $("#append_text_here_mail_error").html();
        //  var phone =   $("#phone_number_exist_error").html();
          // var password =  $("#password_did_not_match_here_error").html();
        var name = $(this).val();

        name =  name.replace(/[^a-zA-Z_0-9]/g, "");
        name = name.replace(/(?:[\u2700-\u27bf]|(?:\ud83c[\udde6-\uddff]){2}|[\ud800-\udbff][\udc00-\udfff]|[\u0023-\u0039]\ufe0f?\u20e3|\u3299|\u3297|\u303d|\u3030|\u24c2|\ud83c[\udd70-\udd71]|\ud83c[\udd7e-\udd7f]|\ud83c\udd8e|\ud83c[\udd91-\udd9a]|\ud83c[\udde6-\uddff]|\ud83c[\ude01-\ude02]|\ud83c\ude1a|\ud83c\ude2f|\ud83c[\ude32-\ude3a]|\ud83c[\ude50-\ude51]|\u203c|\u2049|[\u25aa-\u25ab]|\u25b6|\u25c0|[\u25fb-\u25fe]|\u00a9|\u00ae|\u2122|\u2139|\ud83c\udc04|[\u2600-\u26FF]|\u2b05|\u2b06|\u2b07|\u2b1b|\u2b1c|\u2b50|\u2b55|\u231a|\u231b|\u2328|\u23cf|[\u23e9-\u23f3]|[\u23f8-\u23fa]|\ud83c\udccf|\u2934|\u2935|[\u2190-\u21ff])/g, '');
        $(this).val(name.toLowerCase());
        name = name.toLowerCase()


        $("#sign_up_button_link_check_here").attr("disabled","true");
        $.ajax({
        type: "GET",
        url: '/verify_username/'+name,
        success: function (data) { 
                            // console.log(data);
                            if(data){
                            $("#sign_up_button_link_check_here").attr("disabled","true");
                            $("#check_user_name_div").addClass("has-error");
                            $("#check_user_name_div").removeClass("has-feedback");
                            $("#append_text_here_error").html("User Name Exists Please Change");
                            }else{
                            $("#check_user_name_div").addClass("has-feedback")
                            $("#check_user_name_div").removeClass("has-error");
                            // if(email.length == 0 && phone.length == 0 && password.length == 0){
                            $("#sign_up_button_link_check_here").removeAttr("disabled");
                            $("#append_text_here_error").html("")
                            } 
                 },
            });
        
    })

        
        
    </script>
</html>



