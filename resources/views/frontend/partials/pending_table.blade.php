@if(count($response) > 0)
@foreach($response as $transaction)

	 @if(isset($transaction->channel) && $transaction->channel == 'Vodacom')
		 <tr>
		    <td>M-Pesa USSD to {{ $transaction->phone  }}</td>
		    <td><button class="btn btn-primary btn-sm voda_payment_status" data-id="{{ $transaction->order_id }}">Angalia Muamala</button>
		    	 <a href="javascript:void(0)" class="btn btn-danger btn-sm deletePay"
                                   data-address="payments" data-id="{{ $transaction->id }}" type="button" data-toggle="tooltip"
                                   title="Futa Muamala" data-original-title="View">
                                   <i class="fa fa-trash"  style="color:white"></i>
                                </a></td>
	     </tr>
	  @else
		  <tr>
		      <td>{{ $transaction->payment_token  }}</td>
			  <td><button class="btn btn-primary btn-sm check_payment_status" data-id="{{ $transaction->order_id }}" data-link="{{ $transaction->payment_gateway_url }}"> Angalia Muamala</button>
   <a href="javascript:void(0)" class="btn btn-danger btn-sm deletePay"
                                   data-address="payments" data-id="{{ $transaction->id }}" type="button" data-toggle="tooltip"
                                   title="Futa Muamala" data-original-title="Futa">
                                   <i class="fa fa-trash"  style="color:white"></i>
                                </a>
			   	</td>
	      </tr>
      @endif

@endforeach
@else


<tr>
	 <td colspan="2" style="color: red;" ><strong>No Any Pending Payment </strong></td>>
</tr>


@endif
