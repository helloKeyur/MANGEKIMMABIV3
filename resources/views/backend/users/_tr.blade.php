
@foreach($vars['users'] as $index => $user)

<tr>
    <td>{{$index+1}}</td>
        <td>@if(isset($user->name)) {{ucfirst($user->name)}} @endif</td>
        <td>@if(isset($user->username)) {{ucfirst($user->username)   }} @endif</td>
        <td>@if(isset($user->phone)) {{ucfirst($user->phone)   }} @endif</td>
        <td> @if($user->is_verified == "true") <i class="fa fa-check-circle-o" style="color: #009bf5;"></i> VERIFIED @else NOT VERIFIED  @endif</td>
        <td>@if($user->is_subscribed == "true") {{ $user->end_of_subscription_date  }} @else NOT SUBSCRIBED @endif</td>
        <td> {{ $user->email  }}</td>
    <td><a href="/management/view_user_route/{{ $user->id }}"  data-id="{{ $user->id }}"  title="View User" >
     <button class="btn btn-success">  
    <i class="fa fa-eye" ></i> </button></a>
  </td>
</tr>
@endforeach