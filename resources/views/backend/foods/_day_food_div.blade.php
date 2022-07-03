<ul class="timeline timeline-inverse"  id="day_food_div">
               
                  <li class="time-label">

                              <span class="bg-blue">
                                 {{   date('d M. Y',strtotime($date)) }} 
                              </span>
                        </li>
               
                  @foreach($row as $food)
            @php
             $icon ="fa fa-coffee bg-yellow";

                       if($food->category == "Snacks"){
                        $icon ="fa fa-cutlery bg-green";
                      }else if($food->category == "Lunch"){
                        $icon ="fa fa fa-cutlery bg-aqua";
                       }else if($food->category == "Dinner"){
                        $icon ="fa fa-glass bg-red";
                       }
                  @endphp



                 <li data-target="{{$food->id }}" id="food_list_{{$food->id }}">
                    <i class="{{ $icon }}"></i>

                    <div class="timeline-item" id="open_inside_div_here'{{$food->id }}">
                      <span class="time"> <a href="javascript:void(0)" class="btn btn-success btn-sm viewTr" data-id="{{ $food->id}}" type="button" data-toggle="tooltip"
                                           title="View Post" data-original-title="View" data-date="{{ date('d M. Y',strtotime($date)) }} " data-category="{{ $food->category }}">
                                           <i class="fa fa-eye" style="color:white"></i>
                                    </a>

                                    @if(\Auth::user()->userHasRole('admin')) 

                                        <a href="javascript:void(0)" class="btn btn-primary btn-sm editTr" data-id="{{ $food->id}}" type="button" data-toggle="tooltip"
                                           title="Edit Post" data-original-title="Edit">
                                           <i class="fa fa-pencil" style="color:white"></i>
                                         </a>
                                   
                                        <a href="javascript:void(0)" class="btn btn-danger btn-sm deleteFood"
                                           data-address="food" data-id="{{$food->id}}" type="button" data-toggle="tooltip"
                                           title="Delete Class" data-original-title="View">
                                           <i class="fa fa-trash"  style="color:white"></i>
                                        </a>
                                        @endif
                                         </span>

                      <h3 class="timeline-header"><a href="#">{{ $food->category }}</a></h3>

                      <div class="timeline-body">

                      <img width="150" height="110" style="cursor: pointer; " onError="this.style.display = \'none\';" src="{{ $food->img_url }}"   alt="Picture" class="click_to_view_stafff">
                      <p>{{ $food->name }}</p>
                      <div class="timeline-item" style="display:none;" id="open_inside_div_here{{$food->id }}"><span class="time"><i class="fa fa-clock-o"></i></span><h3 class="timeline-header">'.$food->title.'</h3><div class="timeline-body">{!! $food->description !!}'</div></div>

                      </div>
                    </div>
                  </li>

          @endforeach

                      </ul>

