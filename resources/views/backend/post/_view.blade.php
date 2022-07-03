<div id="rendered_view_item">

 <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                 <img src="@if($row->enteredBy) {{ $row->enteredBy->img_url }} @endif" onerror="this.src='{{ url('/') }}/assets/dist/img/user.png';"
                     width="5" height="5" class="img-circle" alt="User Image">
                <span class="username"><a href="#">@if($row->enteredBy) {{ $row->enteredBy->name }}. @endif</a></span>
                <span class="description">Published at - {{ $row->created_at->toDayDateTimeString() }}</span>
              </div>
              <!-- /.user-block -->
             {{--  <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Mark as read">
                  <i class="fa fa-circle-o"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div> --}}
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">

                    @foreach($row->media()->get() as $key => $image)
                     <li data-target="#carousel-example-generic" data-slide-to="{{ $key }}" @if($key==0) class="active" @endif></li>
                     @endforeach
                 
                </ol>
                <div class="carousel-inner">

                      @foreach($row->media()->get() as $key => $image)
                      <div class="item  @if($key==0) active @endif" style="height:100%">

                        @if($image->type == "Image")
                             <img alt="..." width="640px" height="360px" src="{{ $image->file_path }}" onerror="this.src='http://placehold.it/150x100';">
                        @else
                         {{-- <iframe src="{{ $image->file_path }}" width="640" height="360" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe> --}}

                             <iframe src="{{ $image->file_path }}" width="640" height="360" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                        @endif
                   

                  {{--   <div class="carousel-caption">
                      First Slide
                    </div> --}}
                  </div>
                     @endforeach
                  
                
                </div>
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                  <span class="fa fa-angle-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                  <span class="fa fa-angle-right"></span>
                </a>
              </div>
             


              {!! $row->content !!}
              <button type="button" class="btn btn-default btn-xs"><i class="fa fa-eye"></i> clicks <b style="color:#001f3f">{{ $row->post_viewers->count()  }}</b></button>
              <button type="button" class="btn btn-default btn-xs"><i class="fa fa-mouse-pointer"></i> Views <b style="color:#001f3f">{{ $row->post_viewers->groupBy('user_id')->count()  }}</b></button>
              <span class="pull-right text-muted">{{ $row->post_reactions->count() }} likes - {{  $row->post_comments->count() }} comments</span>
            </div>
            <!-- /.box-body -->
            <div class="box-footer box-comments">

                 @foreach($row->comments()->get() as $comment)
                      
              <div class="box-comment" id="comment_list_{{ $comment->id }}">
                <!-- User image -->
                <img class="img-circle img-sm"  @if($comment->user) src="{{ $comment->user->img_url}}" @else scr="{{ url('/') }}/assets/dist/img/user.png" @endif  onerror="this.src='{{ url('/') }}/assets/dist/img/user.png';" alt="User Image">

                <div class="comment-text">
                      <span class="username">
                         @if($comment->user)
                       <p style="font-size:12px;"> {{ $comment->user->name }}   @endif &nbsp;
                       @if($comment->user && $comment->user->is_verified == "true")
                            <i class="fa fa-check-circle-o" style="color: #009bf5;"></i>
                        @endif
                       </p>
                        
                        <span class="text-muted pull-right">
                          <i class="fa fa-trash deleteComment" data-address="comments" data-id="{{$comment->id}}" style="color:red; cursor: pointer;"></i>  &nbsp; &nbsp; &nbsp;
                            {{ $comment->created_at->diffForHumans() }}
                    </span>
                </span>
                      
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
                <!-- /.comment-text -->

                @if($comment->comments->count())
                  @foreach($comment->comments()->get() as $comment_chlid)
                      
              <div class="box-comment" style="margin-left:80px;" id="comment_list_{{ $comment_chlid->id }}">
                <!-- User image -->
                <img class="img-circle img-sm"  @if($comment_chlid->user) src="{{ $comment_chlid->user->img_url}}" @else scr="{{ url('/') }}/assets/dist/img/user.png" @endif  onerror="this.src='{{ url('/') }}/assets/dist/img/user.png';" alt="User Image">

                <div class="comment-text">
                      <span class="username">
                         @if($comment_chlid->user)
                       <p style="font-size:12px;"> {{ $comment_chlid->user->name }}   @endif &nbsp;
                       @if($comment_chlid->user && $comment_chlid->user->is_verified == "true")
                            <i class="fa fa-check-circle-o" style="color: #009bf5;"></i>
                        @endif
                       </p>
                        
                        <span class="text-muted pull-right">
                           <i class="fa fa-trash deleteComment" data-address="comments" data-id="{{$comment_chlid->id}}" style="color:red; cursor: pointer;"></i>  &nbsp; &nbsp; &nbsp;
                            {{ $comment_chlid->created_at->diffForHumans() }}
                    </span>
                </span>
                      
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
               @endforeach
            @endif
             
              </div>
              <!-- /.box-comment -->
             @endforeach

            
              <!-- /.box-comment -->
            </div>
            <!-- /.box-footer -->
            <div class="box-footer">
            
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->







</div>
                 
