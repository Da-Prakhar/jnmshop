@extends("admin.layouts.master")
@section('title',"Edit Order : $inv_cus->order_prefix$order->order_id | ")
@section("body")
	
<div class="box box-danger">
	<div class="box-header with-border">

		<div class="box-title">
			<a title="Go Back" href="{{ url('admin/order') }}" class="btn btn-md btn-default"><i class="fa fa-reply"
					aria-hidden="true"></i>
			</a> {{ __("Edit Order #") }}{{ $inv_cus->order_prefix.$order->order_id }}
		</div>

		
	</div>

	<div class="box-body">

		<!-- Checking Mnaual payment -->

		@if($order->manual_payment == '1')
			<div class="callout callout-success">
				<i class="fa fa-info-circle"></i> {{__("This order is placed using")}} {{ ucfirst($order->payment_method) }} {{__("method and purchase proof you can view")}} <a href="{{ url('images/purchase_proof/'.$order->purchase_proof) }}"
					data-lightbox="image-1" data-title="{{__("Purchase proof for")}} {{ $order->order_id }}">{{ __("here") }}</a> {{__("and")}} {{__("after verify you can
					change the order status")}}.
			</div>
		@endif

		<!-- Printing order cancel logs-->

		@if(count($order->cancellog))

			<div class="callout callout-danger">

				@foreach($order->cancellog as $orderlog)
					<p class="font-weight500 font-familycalibri">
						<i class="fa fa-info-circle"></i>
						<b>{{ date('d-m-Y | h:i A',strtotime($orderlog->updated_at)) }} • {{__("For Order")}}
							#{{ $inv_cus->order_prefix.$order->order_id }} • {{ __("Item") }} {{ $orderlog->singleOrder->variant->products->name }} ({{ variantname($orderlog->singleOrder->variant) }}) {{__("has been cancelled")}}
							{{ $order->payment_method == 'COD' ? "." : ""  }}</b>

						@if($orderlog->method_choosen == 'orignal')

						<b> {{__("and Amount")}} <i class="{{ $order->paid_in }}"></i>{{ $orderlog->amount }}
							{{__("is refunded to its orignal source with TXN ID")}} [{{ $orderlog->transaction_id }}].</b>


						@elseif($orderlog->method_choosen == 'bank')

							@if($orderlog->is_refunded == 'completed')
							<b> {{__("and Amount")}} <i class="{{ $order->paid_in }}"></i>{{ $orderlog->amount }}
								{{__("is refunded to")}} <b>{{ $orderlog->user->name }}'s</b> {{__("bank ac")}} @if(isset($orderlog->bank->acno))
								XXXX{{ substr($orderlog->bank->acno, -4) }} @endif {{__("with TXN/REF No")}} {{ $orderlog->transaction_id }}
								@if($orderlog->txn_fee !='')<br> {{__("(TXN FEE APPLIED)")}} <i class="{{ $order->paid_in }}"></i>
								{{ $orderlog->txn_fee }} @endif.</b>
							@else
							<b>{{__("Amount")}} <i class="{{ $order->paid_in }}"></i>{{ $orderlog->amount }}
								{{__("is pending to")}} <b>{{ $orderlog->user->name }}'s</b> {{__("bank ac")}} @if(isset($orderlog->bank->acno))
								{{__("XXXX") }}{{ substr($orderlog->bank->acno, -4) }} @endif {{__("with TXN/REF. No:")}} {{ $orderlog->transaction_id }}.</b>
							@endif

						@endif
					</p>
				@endforeach

			</div>

		@endif

		<!-- Printing refud logs if any -->

		@if($order->refundlogs()->count() > 0)

		@foreach($order->refundlogs->sortByDesc('id') as $rlogs)

			@php
				
				$orivar2 = App\AddSubVariant::withTrashed()->find($rlogs->getorder->variant_id);
		
			@endphp

		@if($orivar2)

			<div class="callout callout-danger">
				<p><i class="fa fa-info-circle"></i> {{ date('d-m-Y | h:i A',strtotime($rlogs->updated_at)) }} • Item
					<b>{{ $orivar2->products->name }} ({{ variantname($orivar2) }}) </b> has been @if($rlogs->getorder->status == 'return_request')
						{{__("requested for return")}}
					@else
					@if($rlogs->getorder->status == 'ret_ref')
						{{__("Returned and refunded")}}
					@else
						{{ ucfirst($rlogs->getorder->status) }}
					@endif
					@endif

					@if($rlogs->method_choosen == 'orignal')

					{{__("and Amount")}} <i class="{{ $rlogs->getorder->order->paid_in }}"></i>{{ $rlogs->amount }} {{__("is")}} {{ $rlogs->status }} {{__("to its orignal source with TXN ID:")}} <b>{{ $rlogs->txn_id }}</b>.


					@elseif($rlogs->method_choosen == 'bank')
					@if($rlogs->status == 'refunded')
						and Amount <i class="{{ $rlogs->getorder->order->paid_in }}"></i>{{ $rlogs->amount }}
						is {{ $rlogs->status }} to <b>{{ $rlogs->user->name }}'s</b> bank ac @if(isset($rlogs->bank->acno))
						XXXX{{ substr($rlogs->bank->acno, -4) }} @endif with TXN ID: <b>{{ $rlogs->txn_id }} @if($rlogs->txn_fee
							!='') <br> (TXN FEE APPLIED) <b><i
									class="{{ $rlogs->getorder->order->paid_in }}"></i>{{ $rlogs->txn_fee }}</b> @endif</b>.
					@else
						and Amount <i class="{{ $order->paid_in }}"></i>{{ $rlogs->amount }}
						is pending to <b>{{ $rlogs->user->name }}'s</b> bank ac @if(isset($rlogs->bank->acno))
						XXXX{{ substr($rlogs->bank->acno, -4) }} @endif with TXN ID/REF NO: <b>{{ $rlogs->txn_id }}</b>
					@if($rlogs->txn_fee !='') <br> (TXN FEE APPLIED) <b><i
							class="{{ $rlogs->getorder->order->paid_in }}"></i>{{ $rlogs->txn_fee }}</b> @endif.
					@endif
					@endif
				</p>
			</div>

		@endif

		@endforeach
		@endif
		
		<!-- Main order view -->

		<div class="box box-info">
			<div class="box-header">
				<div class="box-title">
					{{__("Order ID:")}} {{ $order->order_id }}
				</div>
			</div>

			<div class="box-body">
				<div class="row">

					<div class="col-md-12">
						<div class="well">
							<div class="row">
								<div class="col-md-3">
									<p>
										<b>{{__("Order Placed on")}}</b>
										
									</p>

									<p>
										{{ date('d/m/Y - h:i a', strtotime($order->created_at)) }}
									</p>
								</div>

								<div class="col-md-3">
									<p>
										<b>{{__("Order ID")}}</b>
										
									</p>

									<p>
										# {{ $inv_cus->order_prefix.$order->order_id }}
									</p>
								</div>

								

								<div class="col-md-3">
									<p>
										<b>{{__("Total qty.")}}</b>
									</p>

									<p>
										{{ $order->qty_total }}
									</p>
								</div>

								

								<div class="col-md-2">
									<p>
										<b>{{__("Order Total")}}</b>
										
									</p>

									<p>
										<i class="{{ $order->paid_in }}"></i>{{ round($order->order_total,2) }}
									</p>
								</div>

							</div>
						</div>

						<div class="well">
							<div class="row">
								<div class="col-md-4">
									<p>
										<b>{{__("Payment method")}}</b>
										
									</p>

									<p>
										{{ ucfirst($order->payment_method) }}
									</p>
								</div>

								<div class="col-md-4">
									<p>
										<b>{{__("Transcation ID")}}</b>
										
									</p>

									<p>
										{{ $order->transaction_id }}
									</p>
								</div>

								

								<div class="col-md-4">
									<p>
										<b>{{__("Payment Received")}}</b>
									</p>

									@if($order->payment_method != 'COD' && $order->payment_method != 'BankTransfer')
									<p>{{ ucfirst($order->payment_receive) }}</p>
									@else
									<select class="form-control" name="pay_confirm" id="pay_confirm">
										<option {{ $order->payment_receive == 'yes' ? "selected" : "" }} value="yes">Yes</option>
										<option {{ $order->payment_receive == 'no' ? "selected" : "" }} value="no">No</option>
									</select>
									@endif
								</div>

							</div>
						</div>
					</div>
					
					<div class="col-md-6">
						<h4>{{ __("Delivery Address") }}</h4>
						<div class="well">
							@if($order->shippingaddress)
									<p><b>{{ $order->shippingaddress->name }}</b></p>
									<p><i class="fa fa-envelope-o" aria-hidden="true"></i>
										<a href="mailto:{{ $order->shippingaddress->email }}">
											{{ $order->shippingaddress->email }}
										</a>
									</p>
								@if($order->shippingaddress->phone != '')
									<p><i class="fa fa-phone"></i>
										<a href="tel:{{ $order->shippingaddress->phone }}">{{ $order->shippingaddress->phone }}</a>
									</p>
								@endif
								@if(isset($order->shippingaddress->getCountry))
									<p><i class="fa fa-map-marker" aria-hidden="true"></i> 
										{{$order->shippingaddress->getcity->name ?? ''}}, 
										{{ $order->shippingaddress->getstate->name ?? '' }}, 
										{{ $order->shippingaddress->getCountry->nicename ?? '' }},
										{{ $order->shippingaddress->pin_code }}
									</p>
								@endif
							@endif
						</div>
					</div>
					<div class="col-md-6">
						<h4>{{ __("Billing Address") }}</h4>
						<div class="well">
							
							
								<p><b>{{ $order->billing_address['firstname'] }}</b></p>
								<p><i class="fa fa-envelope-o" aria-hidden="true"></i> 
									<a href="mailto:{{ $order->billing_address['email'] }}">
										{{ $order->billing_address['email'] }}
									</a>
								</p>
								@if($order->billing_address['mobile'] != '')
									<p><i class="fa fa-phone"></i>
										<a href="tel:{{ $order->billing_address['mobile'] }}">
											{{ $order->billing_address['mobile'] }}
										</a>
									</p>
								@endif

								@php


									$c = App\Allcountry::where('id',$order->billing_address['country_id'])->first();
									$s = App\Allstate::where('id',$order->billing_address['state'])->first()->name;
									$ci = App\Allcity::where('id',$order->billing_address['city'])->first() ? App\Allcity::where('id',$order->billing_address['city'])->first()->name : '';

								@endphp

								@if($c)
									<p><i class="fa fa-map-marker" aria-hidden="true"></i> 
										{{ $ci ?? ''}}, 
										{{ $s ?? '' }}, 
										{{ $c->nicename ?? '' }},
										@if(isset($order->billing_address['pincode']))
											{{ $order->billing_address['pincode'] }}
										@endif
									</p>
								@endif
							
						</div>
					</div>

					<div class="col-md-12">
						@foreach($order->invoices as $invoice)
							@if($invoice->local_pick != '' && $invoice->status != 'return_request' && $invoice->status != 'refunded' && $invoice->status !='ret_ref' && $invoice->status !='Refund Pending')
								<div class="alert alert-success">
									@if(isset($invoice->variant))
										@php
											$orivar = $invoice->variant;
										@endphp
									<i class="fa fa-info-circle"></i> For Item <b>{{ $invoice->variant->products->name }} <small>
											({{ variantname($orivar) }})
						
										</small></b> @endif @if($invoice->simple_products) {{ $invoice->simple_products->product_name }} @endif Customer has choosen Local Pickup. @if($invoice->status != 'delivered')
									Estd Delivery date: <span id="estddate{{ $invoice->id }}">
										{{ $invoice->loc_deliv_date == '' ? "Yet to update" : date('d-m-Y',strtotime($invoice->loc_deliv_date)) }}
						
										@else
										Item Delivered On: <span id="estddate{{ $invoice->id }}">
											{{ $invoice->loc_deliv_date == '' ? "Yet to update" : date('d-m-Y',strtotime($invoice->loc_deliv_date)) }}
											@endif
										</span>
								</div>
							@endif

							@if($invoice->local_pick !='' && $invoice->status != 'delivered' && $invoice->status != 'return_request' && $invoice->status != 'refunded' && $invoice->status !='ret_ref' && $invoice->status != 'Refund Pending')
								<div class="container">
									<div class="row border-box">
										<p>Update Local Pickup Delivery dates: </p>
										<div class="col-md-4">
											@if($invoice->variant)
											@php
												$orivar = $invoice->variant;
											@endphp
											<h4>{{ $invoice->variant->products->name }} <small>({{ variantname($orivar) }})</small>
											</h4>
											@endif

											@if($invoice->simple_product)
												{{ $invoice->simple_product->product_name }}
											@endif
										</div>
										<form method="POST" action="{{ route('update.local.delivery',$invoice->id) }}">
											@csrf
											<div class="col-md-4">
												<div class='input-group date lcpdate'>
													<input required="" name="del_date" type='text' id="datetimepicker2"
														value="{{ $invoice->loc_deliv_date }}" class="form-control" />
													<span class="input-group-addon">
														<span class="glyphicon glyphicon-calendar"></span>
													</span>
												</div>
											</div>
											<div class="col-md-4">
												<button type="submit" class="btn btn-md btn-primary">
													<i class="fa fa-save"></i> Save
												</button>
											</div>
										</form>
									</div>
								</div>
								<br>
							@endif

						@endforeach
					</div>

					<!-- Order Summary -->

					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Invoice No</th>
								<th>Item Name</th>
								<th>Qty</th>
								<th>Status</th>
								<th>Pricing & Tax</th>
								<th>Total</th>
								<th>
									Action
								</th>
						</thead>

						<tbody>
							@foreach($order->invoices as $invoice)
							<tr>
								
								<td>
									<i>{{ $inv_cus->prefix }}{{ $invoice->inv_no }}{{ $inv_cus->postfix }}</i>
								</td>

								<td>
									<div class="row">
										<div class="col-md-2">
											@if(isset($invoice->variant))
												@if($invoice->variant->variantimages)
													<img class="order-img"
													src="{{url('variantimages/'.$invoice->variant->variantimages['main_image'])}}" alt="">
												@else
													<img class="order-img"
													src="{{ Avatar::create($invoice->variant->products->name)->toBase64() }}" alt="">
												@endif
											@endif
		
											@if(isset($invoice->simple_product))
												<img class="order-img" src="{{url('images/simple_products/'.$invoice->simple_product['thumbnail'])}}" alt="">
											@endif
										</div>
		
										<div class="col-md-10">
											@if(isset($invoice->variant))
											
											<a class="text-justify mleft22" target="_blank" 
												href="{{ App\Helpers\ProductUrl::getUrl($invoice->variant->id) }}"><b>{{substr($invoice->variant->products->name, 0, 25)}}{{strlen($invoice->variant->products->name)>25 ? '...' : ""}}</b>
		
												<small>
												
													({{ variantname($invoice->variant) }})
		
												</small>
											</a>
											@endif
		
											@if($invoice->simple_product)
											<a class="text-justify mleft22" href="{{ route('show.product',['id' => $invoice->simple_product->id, 'slug' => $invoice->simple_product->slug]) }}" target="_blank">
												<b>{{ $invoice->simple_product->product_name }}</b>
											</a>
											@endif
											<br>
											@if($invoice->variant)
											<small class="mleft22"><b>Sold By:</b> {{$invoice->variant->products->store->name}}</small>
											@endif
		
											@if($invoice->simple_product)
												<small class="mleft22"><b>Sold By:</b> {{$invoice->simple_product->store->name}}</small>
											@endif
											<br>
											<small class="mleft22"><b>Price:</b>
												<i class="{{ $invoice->order->paid_in }}"></i>
		
												{{ round(($invoice->price),2) }}
		
											</small>
											<br>
											<small class="mleft22"><b>Tax:</b> <i class="{{ $invoice->order->paid_in }}"></i>{{ round($invoice->tax_amount,2) }}</small>
		
										</div>
									</div>
								</td>

								<td>
									{{ $invoice->qty }}
								</td>

								<td>	
									<div id="singleorderstatus{{ $invoice->id }}">
										@if($invoice->status == 'delivered')
										<span class="label label-success">{{ ucfirst($invoice->status) }}</span>
										@elseif($invoice->status == 'processed')
										<span class="label label-info">{{ ucfirst($invoice->status) }}</span>
										@elseif($invoice->status == 'shipped')
										<span class="label label-primary">{{ ucfirst($invoice->status) }}</span>
										@elseif($invoice->status == 'return_request')
										<span class="label label-warning">Return Requested</span>
										@elseif($invoice->status == 'returned')
										<span class="label label-success">Returned</span>
										@elseif($invoice->status == 'cancel_request')
										<span class="label label-warning">Cancelation Request</span>
										@elseif($invoice->status == 'canceled')
										<span class="label label-danger">Canceled</span>
										@elseif($invoice->status == 'refunded')
										<span class="label label-danger">Refunded</span>
										@elseif($invoice->status == 'ret_ref')
										<span class="label label-success">Return & Refunded</span>
										@else
										<span class="label label-default">{{ ucfirst($invoice->status) }}</span>
										@endif

									</div>

									<br>

										@if($invoice->status == 'Refund Pending' || $invoice->status == 'canceled' || $invoice->status == 'refunded' || $invoice->status == 'returned' || $invoice->status == 'refunded' || $invoice->status == 'ret_ref' || $invoice->status == 'return_request')
										<select disabled="" class="form-control select2">
											<option {{ $invoice->status =="pending" ? "selected" : "" }} value="pending">Pending
											</option>
											<option {{ $invoice->status =="processed" ? "selected" : "" }} value="processed">Processed
											</option>
											<option {{ $invoice->status =="delivered" ? "selected" : "" }} value="delivered">Delivered
											</option>

											<option {{ $invoice->status =="return_request" ? "selected" : "" }} value="return_request">
												Return Requested</option>
											<option {{ $invoice->status =="returned" ? "selected" : "" }} value="returned">Returned
											</option>
											<option {{ $invoice->status =="cancel_request" ? "selected" : "" }} value="cancel_request">
												Canceled Request</option>

											<option {{ $invoice->status =="canceled" ? "selected" : "" }} value="canceled">Canceled
											</option>

											<option {{ $invoice->status =="refunded" ? "selected" : "" }} value="refunded">Refunded
											</option>

											<option {{ $invoice->status =="Refund Pending" ? "selected" : "" }} value="refunded">Refund pending
											</option>

											<option {{ $invoice->status =="ret_ref" ? "selected" : "" }} value="refunded">Return &
												Refunded</option>

										</select>
										@else
										<select data-placeholder="{{ __("Change order status") }}" name="status" id="status{{ $invoice->id }}" onchange="changeStatus('{{ $invoice->id }}')" class="select2 form-control">
											<option value="">{{ __("Change order status") }}</option>
											<option {{ $invoice->status =="pending" ? "selected" : "" }} value="pending"> {{ __("Pending") }}
											</option>
											<option {{ $invoice->status =="processed" ? "selected" : "" }} value="processed"> {{__("Processed")}}
											</option>
											<option {{ $invoice->status =="delivered" ? "selected" : "" }} value="delivered"> {{__("Delivered")}}
											</option>

										</select>
										@endif
								</td>

								<td>
									<b>Total Price:</b> <i class="{{ $invoice->order->paid_in }}"></i>

									{{ round(($invoice->price*$invoice->qty),2) }}

									<p></p>
									<b>Total Tax:</b> <i
										class="{{ $invoice->order->paid_in }}"></i>{{ round(($invoice->tax_amount),2) }}
									<p></p>
									<b>Shipping Charges:</b> <i
										class="{{ $invoice->order->paid_in }}"></i>{{ round($invoice->shipping,2) }}
									<p></p>


									<small class="help-block">(Price & TAX Multiplied with Quantity)</small>
									<p></p>
								</td>

								<td>
									<i class="{{ $invoice->order->paid_in }}"></i>
			
									{{ round($invoice->qty*($invoice->price+$invoice->tax_amount)+$invoice->shipping,2) }}
			
									<br>
									<small>
										{{__("(Incl. of TAX & Shipping)")}}
									</small>
								</td>

								<td>
									<ul class="nav table-nav">
										<li class="dropdown">
											<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
												{{ __("Action") }} <span class="caret"></span>
											</a>
											<ul class="dropdown-menu dropdown-menu-right">
												
												@if(!in_array($invoice->status,['canceled','delivered','Refund Pending','ret_ref','refunded','return_request']))
												<li role="presentation">
													<a href="{{ route("update.invoice",$invoice->id) }}">
														<i class="fa fa-truck"></i> {{$invoice->status != 'shipped' ? __("Ship") : __("Edit Shipping") }}
													</a>
												</li>
												@endif
												

												@if($invoice->variant && $invoice->status != 'canceled' && $invoice->status != 'canceled' && $invoice->status != 'returned' && $invoice->status !=
												'return_request' && $invoice->status !='Refund Pending' && $invoice->status != 'delivered' && $invoice->status !='ret_ref' && $invoice->status !='refunded' &&$invoice->variant->products->cancel_avl != 0)
													<li class="divider"></li>
													<li role="presentation">

														<a id="canbtn{{ $invoice->id }}" data-toggle="modal"
															data-target="#singleordercancel{{ $invoice->id }}"  title="Cancel this order?">
															<i class="fa fa-ban"></i> {{__("Cancel")}}
														</a>

													</li>


												@endif

											</ul>
										</li>
										</ul>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>

					
					
				</div>
			</div>
		</div>

		<div class="box-body">
			<h4>
				{{__("Order Activity Logs")}}
			</h4>

		    @if(count($order->orderlogs) < 1) <span id="ifnologs">No activity logs for this order <br></span>

			@endif

			<small><b>#{{ $inv_cus->order_prefix }}{{ $order->order_id }}</b><br></small>

			<span id="logs">


				@foreach($order->orderlogs->sortByDesc('id') as $logs)

					@if(isset($logs->variant))

					@php
						$findinvoice = App\InvoiceDownload::find($logs->inv_id)->first();
						$orivar = App\AddSubVariant::withTrashed()->withTrashed()->find($logs->variant_id);

						if($order->payment_method !='COD'){

							if(isset($cancellog)){
								$findinvoice2 = App\InvoiceDownload::where('id','=',$cancellog->inv_id)->first();
								$orivar2 = App\AddSubVariant::withTrashed()->withTrashed()->findorfail($findinvoice2->variant_id);
							}

						}
					@endphp



					<small>{{ date('d-m-Y | h:i:a',strtotime($logs->updated_at)) }} • For Order
						<b>{{ $orivar->products->name }} ({{variantname($orivar)}}) </b>
						: @if($logs->user->role_id == 'a')
						<span class="text-red"><b>{{ $logs->user->name }}</b> (Admin)</span> changed status to
						<b>{{ $logs->log }}</b>
						@elseif($logs->user->role_id == 'v')
						<span class="text-blue"><b>{{ $logs->user->name }}</b> (Vendor)</span> changed status to
						<b>{{ $logs->log }}</b>
						@else
						<span class="text-green"><b>{{ $logs->user->name }}</b> (Customer)</span> changed status to
						<b>{{ $logs->log }}</b>
						@endif

					</small>
					@endif

					@if(isset($logs->simple_product))
						<small>{{ date('d-m-Y | h:i:a',strtotime($logs->updated_at)) }} • For Order Item <b>{{ $logs->simple_product->product_name }}</b> @if($logs->user->role_id == 'a')
							<span class="text-red"><b>{{ $logs->user->name }}</b> (Admin)</span> changed status to
							<b>{{ $logs->log }}</b>
							@elseif($logs->user->role_id == 'v')
							<span class="text-blue"><b>{{ $logs->user->name }}</b> (Vendor)</span> changed status to
							<b>{{ $logs->log }}</b>
							@else
							<span class="text-green"><b>{{ $logs->user->name }}</b> (Customer)</span> changed status to
							<b>{{ $logs->log }}</b>
							@endif </small>
					@endif

				<p></p>
				@endforeach
			</span>
		</div>

	</div>

</div>

@foreach($order->invoices as $o)

	@if($o->variant && $o->status != 'canceled' && $o->status != 'returned' && $o->status !=
							'return_request' && $o->status != 'delivered' && $o->status !='ret_ref' &&
							$o->status !='refunded' && $o->variant->products->cancel_avl != 0)
							
		<div data-backdrop="static" data-keyboard="false" class="modal fade" id="singleordercancel{{ $o->id }}" tabindex="-1"
			role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Cancel Item: {{$o->variant->products->name}}
							({{ variantname($o->variant) }})</h4>
					</div>

					<div class="modal-body">
						@php
							$secureid = Crypt::encrypt($o->id);
						@endphp
						@if($o->variant->products && $o->status != 'returned' && $o->status != 'return_request' && $o->status != 'delivered' &&
						$o->status !='ret_ref' && $o->status !='refunded' && $o->variant->products->cancel_avl != 0)
						<form action="{{ route('cancel.item',$secureid) }}" method="POST">
							@csrf
							<div class="form-group">
								<label for="">Choose Reason <span class="required">*</span></label>
								<select class="form-control" required="" name="comment" id="">
									<option value="">Please Choose Reason</option>
									<option value="Requested by User">Requested by User</option>
									<option value="Order Placed Mistakely">Order Placed Mistakely</option>
									<option value="Shipping cost is too much">Shipping cost is too much</option>
									<option value="Wrong Product Ordered">Wrong Product Ordered</option>
									<option value="Product is not match to my expectations">Product is not match to my
										expectations</option>
									<option value="Other">My Reason is not listed here</option>
								</select>
							</div>
							@if($order->payment_method !='COD' && $order->payment_method !=' BankTransfer')
							<div class="form-group">

								<label for="">Choose Refund Method:</label>
								<label><input onclick="hideBank('{{ $o->id }}')" id="source_check_o{{ $o->id }}" required
										type="radio" value="orignal" name="source" />Orignal Source
									[{{ $o->order->payment_method }}] </label>&nbsp;&nbsp;
								@if($order->user->banks->count()>0)
								<label><input onclick="showBank('{{ $o->id }}')" id="source_check_b{{ $o->id }}" required
										type="radio" value="bank" name="source" />In Bank</label>
								@else
								<label><input disabled="disabled" type="radio" /> In Bank <i class="fa fa-question-circle"
										data-toggle="tooltip" data-placement="right"
										title="Add a bank account in My Bank Account" aria-hidden="true"></i></label>
								@endif

								<select name="bank_id" id="bank_id_single{{ $o->id }}" class="form-control display-none">
									@foreach($order->user->banks as $bank)
									<option value="{{ $bank->id }}">{{ $bank->bankname }} ({{ $bank->acno }})</option>
									@endforeach
								</select>

							</div>


							@else

							@if($order->user->banks->count()>0)
							<label><input onclick="showBank('{{ $o->id }}')" id="source_check_b{{ $o->id }}" required
									type="radio" value="bank" name="source" />In Bank</label>
							@else
							<label><input disabled="disabled" type="radio" /> In Bank <i class="fa fa-question-circle"
									data-toggle="tooltip" data-placement="right" title="Add a bank account in My Bank Account"
									aria-hidden="true"></i></label>
							@endif

							<select name="bank_id" id="bank_id_single{{ $o->id }}" class="display-none form-control">
								@foreach($order->user->banks as $bank)
								<option value="{{ $bank->id }}">{{ $bank->bankname }} ({{ $bank->acno }})</option>
								@endforeach
							</select>


							@endif

							<div class="alert alert-info">
								<h5><i class="fa fa-info-circle"></i> Important !</h5>

								<ol class="ol">
									<li>IF Original source is choosen than amount will be reflected to User's orignal source in
										1-2 days(approx).
									</li>

									<li>
										IF Bank Method is choosen than make sure User added a bank account else refund will not
										procced. IF already added than it will take 14 days to reflect amount in users bank
										account (Working Days*).
									</li>

									<li>Amount will be paid in original currency which used at time of placed order.</li>

								</ol>
							</div>
							<button type="submit" class="btn btn-md btn-primary">
								Procced...
							</button>
							<p class="help-block">This action cannot be undone !</p>
							<p class="help-block">It will take time please do not close or refresh window !</p>
						</form>

						@endif

					</div>


				</div>
			</div>
		</div>
	@endif

@endforeach

@endsection
@section('custom-script')
<script>
	var url 	 = @json(url('/update/orderstatus'));
	var userrole = @json(auth()->user()->role_id);
	var username = @json(auth()->user()->name);
	var orderid  = @json($order->id);
</script>
<script src="{{ url('js/editorder.js') }}"></script>
<script src="{{ url('js/order.js') }}"></script>
@endsection