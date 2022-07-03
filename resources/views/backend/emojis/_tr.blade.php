<li id="emoji_list_{{ $row->id }}">
    @if(\Auth::user()->userHasRole('admin')) 
    <div class="pull-right"> <i class="fa fa-pencil editTr" data-id="{{ $row->id}}"  style="color:blue; cursor: pointer;"></i> 
          &nbsp; &nbsp;
           <i class="fa fa-trash-o deleteEmoji" data-address="emojis" data-id="{{$row->id}}" style="color:red;cursor: pointer;"></i>
     </div>
     <br>
     @endif
                    <img src="{{ $row->img_url }}" width="60" height="60">
                    <span class="glyphicon-class">{{ $row->name }}</span>
                  </li>