  <tr>
                   <td>{{ucfirst($row->name)}}</td>
                    <td>{{ucfirst($row->gender)   }}</td>
                  {{--   <td>{{$row->email   }}</td> --}}
                    <td>{{$row->phone }}</td>
                    <td>
                      @foreach($row->roles as $role)
                                @if($role->name == 'admin')
                                 <span class="label label-sm label-warning">{{$role->display_name}}</span>
                                 @else
                                  <span class="label label-sm label-success arrowed arrowed-right">{{$role->display_name}}</span>
                               @endif
                         @endforeach
                    </td>
                  <td>

                     @if(\Auth::user()->userHasRole('admin')) 
                  <a href="{{ url('/management/admins/'.encrypt($row->id)) }}" class="btn-default " type="button" data-toggle="tooltip" title="View User" data-original-title="View"><i class="fa fa-eye" style="color:#00a65a"></i></a> &nbsp; | &nbsp;
            

                  <a href="javascript:void(0)" class="btn-default edit_user" data-id="{{encrypt($row->id)}}"  type="button" data-toggle="tooltip" title="Edit User" data-original-title="Edit"><i class="fa fa-pencil" style="color:#3c8dbc"></i></a> &nbsp; | &nbsp;


                  <a href="#" class="btn-default deleteTr" data-address="admins" data-id="{{$row->id}}" type="button" data-toggle="tooltip" title="Delete User" data-original-title="View"><i class="fa fa-trash" style="color:red"></i></a>

                  @endif


                </td>
              </tr>