<li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>

                  <span class="text">{{ ucwords($row->name) }}</span>
                  <small class="label label-primary"><i class="fa fa-clock-o"></i>{{ $row->created_at->diffForHumans() }}</small>
                  <div class="tools">
                    <a href="javascript:void(0)" class="btn-default deleteLi" data-address="workstations" data-id="{{$row->id}}" type="button" data-toggle="tooltip" title="Remove Work Station" data-original-title="View"><i class="fa fa-trash-o"  style="color:red"></i></a>
                  </div>
  </li>