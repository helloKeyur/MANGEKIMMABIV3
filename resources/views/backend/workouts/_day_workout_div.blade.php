<ul class="timeline timeline-inverse"  id="day_workout_div">
               
                  <li class="time-label">

                              <span class="bg-blue">
                                 {{   date('d M. Y',strtotime($date)) }} 
                              </span>
                        </li>
               
                  @foreach($row as $workout)
            @php
             $icon ="fa fa-flag-checkered bg-yellow";
                  @endphp



                 <li data-target="{{$workout->id }}" id="workout_list_{{$workout->id }}">
                    <i class="{{ $icon }}"></i>

                    <div class="timeline-item" id="open_inside_div_here'{{$workout->id }}">
                      <span class="time"> <a href="javascript:void(0)" class="btn btn-success btn-sm viewTr" data-id="{{ $workout->id}}" type="button" data-toggle="tooltip"
                                           title="View Post" data-original-title="View" data-date="{{ date('d M. Y',strtotime($date)) }} " data-category="{{ $workout->circuit }}">
                                           <i class="fa fa-eye" style="color:white"></i>
                                    </a>

                                    @if(\Auth::user()->userHasRole('admin')) 

                                        <a href="javascript:void(0)" class="btn btn-primary btn-sm editTr" data-id="{{ $workout->id}}" type="button" data-toggle="tooltip"
                                           title="Edit Post" data-original-title="Edit">
                                           <i class="fa fa-pencil" style="color:white"></i>
                                         </a>
                                   
                                        <a href="javascript:void(0)" class="btn btn-danger btn-sm deleteworkout"
                                           data-address="workout" data-id="{{$workout->id}}" type="button" data-toggle="tooltip"
                                           title="Delete Class" data-original-title="View">
                                           <i class="fa fa-trash"  style="color:white"></i>
                                        </a>
                                        @endif
                                         </span>

                      <h3 class="timeline-header"><a href="#">{{ $workout->circuit }}</a></h3>

                      <div class="timeline-body">
                       @if($workout->img_url)
                      <img width="150" height="110" style="cursor: pointer; " onError="this.style.display = \'none\';" src="{{ $workout->img_url }}"   alt="Picture" class="click_to_view_stafff">
                      @endif
                      @if($workout->video_url)
                       <iframe src="{{ $workout->video_url }}" width="150px" height="110px" frameborder="0"  allowfullscreen></iframe>
                      @endif

                      <p>{{ $workout->name }}</p>
                      <div class="timeline-item" style="display:none;" id="open_inside_div_here{{$workout->id }}"><span class="time"><i class="fa fa-clock-o"></i></span><h3 class="timeline-header">{{ $workout->name }}</h3><div class="timeline-body">{!! $workout->description !!}'</div></div>

                      </div>
                    </div>
                  </li>

          @endforeach

                      </ul>

