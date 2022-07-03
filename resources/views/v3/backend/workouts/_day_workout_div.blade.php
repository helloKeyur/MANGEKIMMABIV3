<div class="scroll-widget ps ps--active-x">
    <div class="latest-update-box ml-4">
        <div class="row pt-20 pb-30">
            <div class="col-auto text-right update-meta pr-0" style="margin-left:-20px;">
                <button class="btn btn-primary">{{   date('d M. Y',strtotime($date)) }} </button>
            </div>
        </div>
        @foreach($row as $workout)
            @php
            $icon ="ik-briefcase bg-red";
            @endphp
            
            <div class="row pb-30" data-target="{{$workout->id }}" id="workout_list_{{$workout->id }}">
                <div class="col-auto text-right update-meta pr-0">
                    <i class="ik {{ $icon }} fw-600 update-icon"></i>
                </div>
                <div class="col pl-5">
                    <div class="sl-item">
                        <div class="sl-right">
                            <div class="mt-20 row">
                                <div class="col-md-3 col-xs-12">
                                    @if($workout->video_url)
                                        @if(filter_var($workout->video_url, FILTER_VALIDATE_URL))
                                            <iframe src="{{ $workout->video_url }}" width="150px" height="110px" frameborder="0"  allowfullscreen></iframe>
                                        @endif
                                    @endif
                                    @if($workout->img_url)
                                        @if(!filter_var($workout->img_url, FILTER_VALIDATE_URL))
                                            <img src="{{ url('/'.App\Models\SysConfig::set()['logo']) }}" alt="user" class="img-fluid rounded">
                                        @else
                                            <img src="{{ $workout->img_url }}" alt="user" class="img-fluid rounded">
                                        @endif
                                    @endif
                                </div>
                                <div class="col-md-9 col-xs-12">
                                    <p> {{ $workout->circuit }} </p> 
                                    <p> {{ $workout->title }} </p> 
                                    <a href="javascript:void(0)" class="link mr-10 text-warning viewTr" data-id="{{ $workout->id}}" type="button" data-toggle="tooltip"
                                           title="View Post" data-original-title="View" data-date="{{ date('d M. Y',strtotime($date)) }} " data-category="{{ $workout->circuit }}">Show</a> 
                                    @if(\Auth::user()->userHasRole('admin')) 
                                        <a href="javascript:void(0)" class="link mr-10 text-primary editTr" data-id="{{ $workout->id}}">Edit</a> 
                                        <a href="javascript:void(0)" class="link mr-10 text-danger deleteworkout" type="button" data-address="workouts" data-id="{{$workout->id}}">Delete</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                </div>
            </div>
        @endforeach
    </div>
</div>