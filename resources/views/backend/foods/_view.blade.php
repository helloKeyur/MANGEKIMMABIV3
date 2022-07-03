<div id="rendered_view_item">
 <div class="box-body">
              <img class="img-responsive pad" src="{{ $row->img_url }}" alt="Photo" height="300px;">

              <p>{{ $row->name }} </p>
              {{-- <button type="button" class="btn btn-default btn-xs"><i class="fa fa-share"></i> Share</button>
              <button type="button" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i> Like</button> --}}
              <span class="pull-right text-muted">{{-- <strong style="color:blue"> {{ $row->category }}  </strong></span> --}}
           </div>
<div class="box-body">
             <div class="box-footer box-comments">
              <div class="box-comment">
                

                <div class="comment-text">
                      <span class="username">
                       @if($row->person) Personn Take  {{ $row->person }} @endif <strong style="color:blue"> @if($row->person) ::  Take Times  {{ $row->takes_time }} @endif </strong>
                        <span class="text-muted pull-right">added by @if($row->entered_by)  {{ $row->entered_by->name }} @endif at {{ $row->created_at }}</span>
                      </span><!-- /.username -->
                
                </div>


                                <!-- /.comment-text -->
              </div>
              <br><br>
               <div class="box-comment">
                    <div class="comment-text">
                     {!! $row->description !!} 
                 </div>

               </div>
              <!-- /.box-comment -->
               </div>
            </div>
</div>
                 
