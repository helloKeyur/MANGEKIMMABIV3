<div class="scroll-widget ps ps--active-x">
    <div class="latest-update-box ml-4">
        <div class="row pt-20 pb-30">
            <div class="col-auto text-right update-meta pr-0" style="margin-left:-20px;">
                <button class="btn btn-primary">{{   date('d M. Y',strtotime($date)) }} </button>
            </div>
        </div>
        @foreach($row as $food)
            @php
            $icon ="ik-briefcase bg-red";
            
            if($food->category == "Snacks"){
                $icon ="ik-shopping-bag bg-green";
            }else if($food->category == "Lunch"){
                $icon ="ik-cloud bg-primary";
            }else if($food->category == "Dinner"){
                $icon ="ik-disc bg-warning";
            }
            @endphp
            
            <div class="row pb-30" data-target="{{$food->id }}" id="food_list_{{$food->id }}">
                <div class="col-auto text-right update-meta pr-0">
                    <i class="ik {{ $icon }} fw-600 update-icon"></i>
                </div>
                <div class="col pl-5">
                    <div class="sl-item">
                        <div class="sl-right">
                            <div class="mt-20 row">
                                <div class="col-md-3 col-xs-12">
                                    @if(!filter_var($food->img_url, FILTER_VALIDATE_URL))
                                        <img src="{{ url('/'.App\Models\SysConfig::set()['logo']) }}" alt="user" class="img-fluid rounded">
                                    @else
                                        <img src="{{ $food->img_url }}" alt="user" class="img-fluid rounded">
                                    @endif
                                </div>
                                <div class="col-md-9 col-xs-12">
                                    <p> {{ $food->category }} </p> 
                                    <p> {{ $food->title }} </p> 
                                    <a href="javascript:void(0)" class="link mr-10 text-warning viewTr" data-id="{{ $food->id}}" type="button" data-toggle="tooltip"
                                           title="View Post" data-original-title="View" data-date="{{ date('d M. Y',strtotime($date)) }} " data-category="{{ $food->category }}">Show</a> 
                                    @if(\Auth::user()->userHasRole('admin')) 
                                        <a href="javascript:void(0)" class="link mr-10 text-primary editTr" data-id="{{ $food->id}}">Edit</a> 
                                        <a href="javascript:void(0)" class="link mr-10 text-danger deleteFood" type="button" data-address="food" data-id="{{$food->id}}">Delete</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                </div>
            </div>
            {{-- <div class="row pb-30">
                <div class="col-auto text-right update-meta pr-0">
                    <i class="ik ik-shopping-bag fw-600 bg-green update-icon"></i>
                </div>
                <div class="col pl-5">
                    <div class="sl-item">
                        <div class="sl-right">
                            <div class="mt-20 row">
                                <div class="col-md-3 col-xs-12">
                                    <img src="https://mangekimambigossip.files.wordpress.com/2022/05/951476b7-993f-4664-80b3-6fa6d9b93289.jpg" alt="user" class="img-fluid rounded">
                                </div>
                                <div class="col-md-9 col-xs-12">
                                    <p> Breakfast </p> 
                                    <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. </p> 
                                    <a href="javascript:void(0)" class="link mr-10 text-warning">Show</a> 
                                    <a href="javascript:void(0)" class="link mr-10 text-primary">Edit</a> 
                                    <a href="javascript:void(0)" class="link mr-10 text-danger">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                </div>
            </div>
            <div class="row pb-30">
                <div class="col-auto text-right update-meta pr-0">
                    <i class="ik ik-cloud bg-primary update-icon"></i>
                </div>
                <div class="col pl-5">
                    <div class="sl-item">
                        <div class="sl-right">
                            <div class="mt-20 row">
                                <div class="col-md-3 col-xs-12">
                                    <img src="https://mangekimambigossip.files.wordpress.com/2022/05/951476b7-993f-4664-80b3-6fa6d9b93289.jpg" alt="user" class="img-fluid rounded">
                                </div>
                                <div class="col-md-9 col-xs-12">
                                    <p> Breakfast </p> 
                                    <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. </p> 
                                    <a href="javascript:void(0)" class="link mr-10 text-warning">Show</a> 
                                    <a href="javascript:void(0)" class="link mr-10 text-primary">Edit</a> 
                                    <a href="javascript:void(0)" class="link mr-10 text-danger">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                </div>
            </div>
            <div class="row">
                <div class="col-auto text-right update-meta pr-0">
                    <i class="ik ik-disc bg-warning update-icon"></i>
                </div>
                <div class="col pl-5">
                    <div class="sl-item">
                        <div class="sl-right">
                            <div class="mt-20 row">
                                <div class="col-md-3 col-xs-12">
                                    <img src="https://mangekimambigossip.files.wordpress.com/2022/05/951476b7-993f-4664-80b3-6fa6d9b93289.jpg" alt="user" class="img-fluid rounded">
                                </div>
                                <div class="col-md-9 col-xs-12">
                                    <p> Breakfast </p> 
                                    <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. </p> 
                                    <a href="javascript:void(0)" class="link mr-10 text-warning">Show</a> 
                                    <a href="javascript:void(0)" class="link mr-10 text-primary">Edit</a> 
                                    <a href="javascript:void(0)" class="link mr-10 text-danger">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                </div>
            </div> --}}
        @endforeach
    </div>
</div>