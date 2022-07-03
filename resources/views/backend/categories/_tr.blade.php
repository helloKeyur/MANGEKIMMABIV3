<div class="col-md-3 connectedSortable">
          <!-- DIRECT CHAT PRIMARY -->
          <div class="box box-primary direct-chat direct-chat-primary">    {{-- collapsed-box --}}
            <div class="box-header with-border">
              <h3 class="box-title">{{  $row->name }}</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>

                 @if(\Auth::user()->userHasRole('admin')) 
                <button type="button" class="btn btn-box-tool edit_categories" data-id="{{$row->id}}" data-toggle="tooltip" title="Edit Category" data-widget="chat-pane-toggle">
                  <i class="fa fa-pencil-square-o"></i></button>
                  
                   {{-- <button type="button" class="btn btn-box-tool  deletePanel" data-toggle="tooltip" title="Delete Category" data-address="categories" data-id="{{$row->id}}"><i class="fa fa-trash" style="color:red;"></i></button> --}}
              
                   @endif
                <button type="button" class="hidden btn btn-box-tool close_panel_{{ $row->id }}" data-widget="remove"></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding categories_divs">
              <div class="text-center">
                 <input type="checkbox" name="state" @if($row->state == "online") checked @endif  data-toggle="toggle" data-on="online"  data-off="offline" data-onstyle="success" class="category_state" value="online" data-offstyle="danger"  data-width="90" data-size="mini"  data-id="{{$row->id}}">
                
              </div>
              <ul class="nav nav-pills nav-stacked" data-id="{{$row->id}}">
                {{-- <li><a href="#"><i class="fa fa-circle-o text-red"></i> Slug  <code style="font-size: 10px;"  class="pull-right">{{  $row->slug }}</code> </a></li> --}}
                {{-- <li><a href="#"><i class="fa fa-sticky-note-o text-yellow"></i> Post Associated  <span class="badge bg-light-blue pull-right">3</span></a></li> --}}
                <li><a href="#"><i class="fa fa-user text-light-blue"></i> Created By <span style="font-size: 12px;" class="pull-right">@if($row->enteredBy){{ $row->enteredBy->name }}@endif</span></a></li>
                <li><a href="#"><i class="fa fa-calendar text-green"></i> Created At <em style="font-size: 12px;" class="pull-right">{{  $row->created_at }}</em></a></li>

                {{-- <li><a href="#"><i class="fa fa-file-word-o  text-green"></i> Description</a></li> --}}
              </ul>
            </div>
            <!-- /.box-body -->
          {{--   <div class="box-footer">
               <em>{{  $row->description }}</em>
            </div> --}}
            <!-- /.box-footer-->
          </div>
          <!--/.direct-chat -->
        </div>