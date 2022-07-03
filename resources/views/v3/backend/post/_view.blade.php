<div class="modal fade show-staff-modal edit-layout-modal pr-0" id="showModel" tabindex="-1" role="dialog" aria-labelledby="showModelLable" aria-hidden="true" data-show="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="showModelLable"><i class="ik ik-at-sign"></i>
            {{ $row->name }}
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-12 mb-4 pl-0 pr-0">
                <div class="owl-container">
                  <div class="owl-carousel basic">

                    @foreach($row->media()->get() as $key => $image)
                        @if($image->type == "Image")
                            <div class="card flex-row">
                                <div class="w-100 position-relative">
                                    <img class="card-img-left" src="{{ $image->file_path }}" alt="Card image cap">
                                </div>
                            </div>
                        @else
                            <iframe src="{{ $image->file_path }}" width="640" height="360" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                        @endif
                    @endforeach
                    
                  </div>
                  <div class="slider-nav text-center">
                    <a href="#" class="left-arrow owl-prev">
                      <i class="ik ik-chevron-left"></i>
                    </a>
                    <div class="slider-dot-container"></div>
                    <a href="#" class="right-arrow owl-next">
                      <i class="ik ik-chevron-right"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="card">
          <ul class="nav nav-pills custom-pills">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="pill" href="#overview">Overview</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#spec" >Comments & More...</a>
            </li>

          </ul>

          <div class="tab-content">
            <div class="tab-pane fade show active" id="overview">
              <!-- OVERVIEW -->
              <div class="card-body">

                <div class="list-group mb-3">
                    <a class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="row">
                        <div class="col-md-2 text-center">
                        <img src="@if($row->enteredBy) {{ $row->enteredBy->img_url }} @endif"
                        style="max-width:48px !important"
                        onerror="this.src='{{ url('/') }}/assets/dist/img/user.png';"
                        class="rounded-circle show-avatar" alt="@if($row->enteredBy) {{ $row->enteredBy->name }}. @endif's Avatar">
                        </div>
                        <div class="col-md-6 col-lg-6 my-auto">
                        <h5 class="mb-0">@if($row->enteredBy) {{ $row->enteredBy->name }}. @endif</h5>
                        <p class="mb-2" title="Username"><small>
                            {{-- <i class="ik ik-at-sign"></i> --}}
                            Published at - {{ $row->created_at->toDayDateTimeString() }}</small></p>
                        </div>
                        {{-- <div class="col-md-4 col-lg-4">
                        <small class="text-muted float-right">{{ $staff->created }}</small>
                        </div> --}}
                    </div>
                    </a>
                </div>

                <b class="h6 text-primary">Lesson Content</b><br/>
                <p class="mb-0">{!! $row->content !!}</p>
                

                <p class="text-right">
                    <span class="pull-right text-muted text-right">{{ $row->post_reactions->count() }} likes - {{  $row->post_comments->count() }} comments</span>
                </p>
                <button type="button" class="btn btn-default btn-xs"><i class="ik ik-corner-down-left"></i> clicks <b style="color:#001f3f">{{ $row->post_viewers->count()  }}</b></button>
                <button type="button" class="btn btn-default btn-xs"><i class="ik ik-eye"></i> Views <b style="color:#001f3f">{{ $row->post_viewers->groupBy('user_id')->count()  }}</b></button>
                
              </div>
              <!-- END OVERVIEW -->
            </div>
            <div class="tab-pane fade" id="spec">
              <!-- SPECFITION -->
              <div class="card-body">
                @forelse($row->comments()->get() as $comment)
                    <div class="chat-box box-comment" id="comment_list_{{ $comment->id }}">
                        <ul class="chat-list">
                            <li class="chat-item">
                            <div class="chat-img text-center mt-2">
                                <img 
                                style="max-width:38px !important"
                                onerror="this.src='{{ url('/') }}/v3/avatars/user/thumb/other.png';" alt="User Image"
                                @if($comment->user) src="{{ $comment->user->img_url}}" @else src="{{ url('/') }}/v3/avatars/user/thumb/other.png" @endif 
                                >
                            </div>
                            <div class="chat-content">
                                <h6 class="font-medium">
                                    @if($comment->user)
                                        <p class="float-left">
                                            {{ $comment->user->name }} 
                                        </p>
                                        @if($comment->user && $comment->user->is_verified == "true")
                                            <p class="float-right" title="comment from {{ $comment->user->name }} "> 
                                                <i class="ik ik-check-circle text-success"></i> 
                                            </p>
                                        @endif
                                    @endif
                                </h6>

                                <div class="box bg-light-info w-100">
                                    @if($comment->emojis->count() &&  $comment->content) 
                                    <img width="70" height="70" style="margin-left: 35px; width:70px;height: 70px; margin-top: 5px;"  onError="this.style.display = 'none';" src="{{ $comment->emojis->first()->img_url }}"   alt="Emoji" >
                                    <br><br>
                                    <p style="color:black;font-size: 10px; margin-left: -20px;"> {{ $comment->content }} </p>
                                    @elseif($comment->emojis->count())
                                    <img width="70" height="70" style="margin-left: 35px; width:70px;height: 70px; margin-top: 5px;"  onError="this.style.display = 'none';" src="{{ $comment->emojis->first()->img_url }}"   alt="Emoji" >
                                    <br>
                                    @elseif($comment->content)
                                    <p style="color:black;font-size: 10px;"> {{ $comment->content}} </p>
                                    @endif
                                </div>
                            </div>
                            <div class="chat-time">
                                {{-- {{ date("d M, Y / h:i A ",strtotime($review['created_at'])) }} --}}
                                {{ $comment->created_at->diffForHumans() }}
                                <a href="#" class="float-right mr-2 deleteComment" 
                                data-address="comments" data-id="{{$comment->id}}"
                                data-toggle="tooltip" title="Delete Comment">
                                    <i class="ik ik-trash text-danger"></i>
                                </a>
                            </div>
                            </li>
                            @if($comment->comments->count() > 0)
                            <div class="row">
                                <div class="offset-1 col-md-11">
                                    @foreach($comment->comments()->get() as $comment_chlid)
                                        <div class="chat-box box-comment" id="comment_list_{{ $comment_chlid->id }}">
                                            <ul class="chat-list">
                                                <li class="chat-item">
                                                <div class="chat-img text-center mt-2">
                                                    <img 
                                                    style="max-width:38px !important"
                                                    onerror="this.src='{{ url('/') }}/v3/avatars/user/thumb/other.png';" alt="User Image"
                                                    @if($comment_chlid->user) src="{{ $comment_chlid->user->img_url}}" @else src="{{ url('/') }}/v3/avatars/user/thumb/other.png" @endif 
                                                    >
                                                </div>
                                                <div class="chat-content">
                                                    <h6 class="font-medium">
                                                        @if($comment_chlid->user)
                                                            <p class="float-left">
                                                                {{ $comment_chlid->user->name }} 
                                                            </p>
                                                            @if($comment_chlid->user && $comment_chlid->user->is_verified == "true")
                                                                <p class="float-right" title="comment from {{ $comment_chlid->user->name }} "> 
                                                                    <i class="ik ik-check-circle text-success"></i> 
                                                                </p>
                                                            @endif
                                                        @endif
                                                    </h6>

                                                    <div class="box bg-light-info w-100">
                                                        @if($comment_chlid->emojis->count() &&  $comment_chlid->content) 
                                                        <img width="70" height="70" style="margin-left: 35px; width:70px;height: 70px; margin-top: 5px;"  onError="this.style.display = 'none';" src="{{ $comment_chlid->emojis->first()->img_url }}"   alt="Emoji" >
                                                        <br><br>
                                                        <p style="color:black;font-size: 10px; margin-left: -20px;"> {{ $comment_chlid->content }} </p>
                                                        @elseif($comment_chlid->emojis->count())
                                                        <img width="70" height="70" style="margin-left: 35px; width:70px;height: 70px; margin-top: 5px;"  onError="this.style.display = 'none';" src="{{ $comment_chlid->emojis->first()->img_url }}"   alt="Emoji" >
                                                        <br>
                                                        @elseif($comment_chlid->content)
                                                        <p style="color:black;font-size: 10px;"> {{ $comment_chlid->content}} </p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="chat-time">
                                                    {{-- {{ date("d M, Y / h:i A ",strtotime($review['created_at'])) }} --}}
                                                    {{ $comment_chlid->created_at->diffForHumans() }}
                                                    <a href="#" class="float-right mr-2 deleteComment" 
                                                    data-address="comments" data-id="{{$comment_chlid->id}}"
                                                    data-toggle="tooltip" title="Delete Comment">
                                                        <i class="ik ik-trash text-danger"></i>
                                                    </a>
                                                </div>
                                                </li>
                                            </ul>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </ul>
                        
                    </div>
                @empty 
                    -
                @endforelse
              </div>
              <!-- END SPECFITION -->
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
$(document).ready(function(){$().owlCarousel&&($(".owl-carousel.basic").length>0&&$(".owl-carousel.basic").owlCarousel({margin:30,stagePadding:15,autoplay:!0,autoplayTimeout:5e3,autoplayHoverPause:!0,dotsContainer:$(".owl-carousel.basic").parents(".owl-container").find(".slider-dot-container"),responsive:{0:{items:1},600:{items:2}}}).data("owl.carousel").onResize(),$(".owl-dot").click(function(){$($(this).parents(".owl-container").find(".owl-carousel")).owlCarousel().trigger("to.owl.carousel",[$(this).index(),300])}),$(".owl-prev").click(function(o){o.preventDefault(),$($(this).parents(".owl-container").find(".owl-carousel")).owlCarousel().trigger("prev.owl.carousel",[300])}),$(".owl-next").click(function(o){o.preventDefault(),$($(this).parents(".owl-container").find(".owl-carousel")).owlCarousel().trigger("next.owl.carousel",[300])}))});
</script>