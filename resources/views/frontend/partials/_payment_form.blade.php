

<div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-mobile-phone"></i> SIMU </a></li>
              <li><a href="#tab_2" data-toggle="tab"> <i class="fa fa-credit-card"></i> CARDS</a></li>
              <li><a href="#tab_3" data-toggle="tab"> <i class="fa fa-paypal"></i>  <i class="fa fa-credit-card"></i>  PAYPAL & CARDS</a></li>
             {{--  <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li> --}}
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                 <div class="col-md-12 pull-center" >
                <img src="/images/mobile_payments.png" style="width:100% ;">
            </div>
                 <form method="POST"  class="prevent-resubmit-form" id="mobile_payments_form" enctype="multipart/form-data">
                             <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">  Chagua Kifurushi::</label>
                                        <select class="select2" name="amount" id="subscription_package" style="width:100%;" required>
                                            <option value="1000" selected>Mwezi - 1,000 Tsh</option>
                                            <option value="3000">Miezi 3 - 3,000 Tsh</option>
                                            <option value="5000">Miezi 6 - 5,000 Tsh</option>
                                            <option value="10000">Miezi 12 - 10,000 Tsh</option>
                                        </select>
                                    </div>
                            <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Jina:</label>
                            <input type="text" name="buyer_name" class="form-control" value="{{ Auth::user()->name }}" placeholder="Full Name.."  required >
                        </div>

                      <input type="hidden" name="buyer_email" @if(isset(Auth::user()->email) && filter_var(Auth::user()->email, FILTER_VALIDATE_EMAIL)) value="{{ Auth::user()->email }}" @else value="{{Str::slug(Auth::user()->username)}}@gmail.com" @endif>
                            {{-- <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Email:</label>
                            <input type="email" name="buyer_email" class="form-control" @if(isset(Auth::user()->email)) value=" {{ Auth::user()->email }}" @endif id="emailmobile" placeholder="Email.."  required >
                        </div>  --}}
                           <div class="form-group col-md-6">
                            <label for="exampleInputEmail1" >Phone:  &nbsp; &nbsp; <i style="color: red; font-size:10px;">Format(0777XXXXXXX)</i></label>
                            <input type="text" name="buyer_phone" class="form-control input-custom "  pattern="[0-9]{4}[0-9]{6}"
                              required >
                        </div>


                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-primary btn-block"> Lipa</button>
                                    </div>

                       </form>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <div class="col-md-12 pull-center" >
                 <img src="/images/paymentcards.png" class="pull-center" style="width:70%;">
             </div>
                <form method="POST"  class="prevent-resubmit-form" id="card_payments_form" enctype="multipart/form-data">
                             <div class="form-group col-md-12">
                                <label for=""> Chagua Kifurushi:</label>
                                        <select class="select2" name="amount" id="subscription_package" style="width:100%;" required>
                                            <option value="1000" selected>Mwezi - 1,000 Tsh</option>
                                            <option value="3000">Miezi 3 - 3,000 Tsh</option>
                                            <option value="5000">Miezi 6 - 5,000 Tsh</option>
                                            <option value="10000">Miezi 12 - 10,000 Tsh</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1">First Name:</label>
                                        <input type="text" name="firstname" class="form-control"  id="firstname"  required >
                                    </div>

                                     <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1">Last Name:</label>
                                        <input type="text" name="lastname" class="form-control"  id="lastname"  required >
                                    </div>
                                     <input type="hidden" name="buyer_email" @if(isset(Auth::user()->email) && filter_var(Auth::user()->email, FILTER_VALIDATE_EMAIL)) value="{{ Auth::user()->email }}" @else value="{{Str::slug(Auth::user()->username)}}@gmail.com" @endif>
                                  {{--    <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Email:</label>
                            <input type="email" name="buyer_email" class="form-control" @if(isset(Auth::user()->email)) value=" {{ Auth::user()->email }}" @endif  id="email" placeholder="Email.."  required >
                        </div>  --}}
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1" >Phone:  &nbsp; <i style="color: red; font-size:10px;">Format(0777XXXXXXX)</i></label>
                                        <input type="text" name="buyer_phone" class="form-control input-custom "  pattern="[0-9]{4}[0-9]{6}"
                                          required >
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-primary btn-block"> Lipa</button>
                                    </div>

                       </form>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                 <div class="col-md-12 pull-center" >
                 <img src="/images/paypal.png" class="pull-center" style=" margin: auto;">
             </div>

              <form action="/process_paypal" id="paypal_payments_form"   method="POST"> 
                 @csrf
                    <div class="form-group col-md-12">
                        <label for=""> Chagua Kifurushi:</label>
                        <select class="select2" name="amount"  style="width:100%;" required>
                            <option value="2.00" selected>Mwezi - $2 USD</option>
                            <option value="3.00">Miezi 3 - $3 USD</option>
                            <option value="5.00">Miezi 6 - $5 USD</option>
                            <option value="10.00">Miezi 12 - $10 USD</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <button type="submit" id="payPal_button" class="btn btn-primary btn-block"> Pay</button>
                    </div>
              </form>
               
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->