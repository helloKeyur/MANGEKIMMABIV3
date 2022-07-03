@foreach($vars['users'] as $index => $user)

<tr>
    <td>{{$index+1}}</td>
    <td>@if(isset($user->name)) {{ucfirst($user->name)}} @endif</td>
    <td>@if(isset($user->username)) {{ucfirst($user->username)   }} @endif</td>
    <td>@if(isset($user->phone)) {{ucfirst($user->phone)   }} @endif</td>
    <td class="text-center"> 
        @if($user->is_verified == "true")  
        <span class='success-dot' title='VERIFIED'></span>
        @else 
        <i class='ik ik-alert-circle text-danger alert-status' title='NOT VERIFIED'></i>  
        @endif
    </td>
    <td class="text-center">
        @if($user->is_subscribed == "true") 
        {{ date('M d,Y h.i A',strtotime($user->end_of_subscription_date))  }} 
        @else 
        <small class="badge badge-danger">NOT SUBSCRIBED </small>
        @endif
    </td>
    <td> {{ $user->email  }}</td>
    <td>
        <div class='table-actions text-center'>
        <a 
        href="{{ route('userProfile.view_user_route', encrypt($user->id)) }}"
        {{-- href="/management/view_user_route/{{ encrypt($user->id) }}"  --}}
        data-id="{{ $user->id }}" class='show-user' target="_blank">
            <i class='ik ik-eye text-primary'></i>
        </a>
        </div>
        {{-- <a href="/management/view_user_route/{{ encrypt($user->id) }}"  data-id="{{ $user->id }}"  title="View User" >
        <button class="btn btn-success">  
        <i class="fa fa-eye" ></i> 
        </button>
        </a> --}}
    </td>
</tr>
@endforeach