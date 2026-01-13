@extends('layouts.main.app')

@section('head')
    @include('layouts.main.headersection',['title'=> 'Add Products','buttons'=>[
        [
            'name'=>'<i class="fas fa-plus"></i> &nbspAdd Products',
            'url'=>'#',
            'components'=>'data-toggle="modal" data-target="#add-product" id="add-products"',
            'is_button'=>true
        ]
    ]])
@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-12">
        <div class="armi">
            <div class="col">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="armi">
                            <div class="col">
                                <span class="h2 font-weight-bold mb-0 total-transfers" id="total-device">
                                   {{ $totalProducts }}
                                </span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                    <i class="fi fi-rs-layers mt-2"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-sm">
                        </p><h5 class="card-title text-muted mb-0">{{ __('Total Products') }}</h5>
                        <p></p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="armi">
                            <div class="col">
                                <span class="h2 font-weight-bold mb-0 total-transfers" id="total-active">
                                    {{ $inStockProducts }}
                                </span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                    <i class="fi fi-rs-check-circle mt-2"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-sm">
                        </p><h5 class="card-title text-muted mb-0">{{ __('In Stock Products') }}</h5>
                        <p></p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="armi">
                            <div class="col">
                                <span class="h2 font-weight-bold mb-0 completed-transfers" id="total-inactive">
                                  {{ $outOfStockProducts }}
                                </span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                    <i class="fi fi-rs-close-circle mt-2"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-sm">
                        </p><h5 class="card-title text-muted mb-0">{{ __('Out of Stock Products') }}</h5>
                        <p></p>
                    </div>
                </div>
            </div>
        </div>

        @if($totalProducts == 0)
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <center>
                                <img src="{{ asset('assets/img/404.jpg') }}" height="500">
                                <h3 class="text-center">{{ __('Oops! You have not added any products.') }}</h3>
                                <a href="#" data-toggle="modal" data-target="#add-product" id="add-products" class="btn btn-neutral"><i class="fas fa-plus"></i> {{ __('Create a reply') }}</a>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        @else
        <div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 table-responsive">
                <table class="table col-12">
                    <thead>
                        <tr>
                            <th class="col-3">{{ __('Product Name') }}</th>
                            <th class="col-2">{{ __('Price') }}</th>
                            <th class="col-2">{{ __('Quantity') }}</th>
                            <th class="col-1">{{ __('Status') }}</th>
                            <th class="col-2 text-right">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="tbody">
                    @foreach($inventoryItems as $inventoryItem)
                    @if ($inventoryItem->products)
    @foreach($inventoryItem->products as $item)
        <tr>
            <td>
                {{ $item->name }}
            </td>
            <td>{{ $item->price }}</td>
            <td>{{ $item->quantity }}</td>
            <td>
                <span class="badge {{ $item->status == 1 ? 'badge-success' : 'badge-danger' }}">{{ $item->status == 1 ? 'In Stock' : 'Out of Stock' }}</span>
            </td>
            <td>
                <div class="btn-group mb-2 float-right">
                    <button class="btn btn-neutral btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ __('Action') }}
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item has-icon" href="{{ route('user.inventory.edit', ['inventory' => $inventoryItem->id, 'product' => $item->id]) }}"><i class="fas fa-pen"></i>{{ __('Update Product') }}</a>
                        <a class="dropdown-item has-icon delete-confirm" href="javascript:void(0)" data-action="{{ route('user.inventory.destroy', ['inventory' => $inventoryItem->id, 'product' => $item->id]) }}"><i class="fas fa-trash"></i>{{ __('Delete Product') }}</a>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
    @endif
@endforeach


                    </tbody>
                </table>
              
            </div>
        </div>
    </div>
</div>

        @endif
    </div>
</div>

<div class="modal fade" id="add-product" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" action="{{ route('user.inventory.store') }}" class="ajaxform_instant_reload">

				@csrf
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">{{ __('Add Product') }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>{{ __('Product Name') }}</label>
						<input type="text" name="name" class="form-control" maxlength="255" required>
					</div>
					<div class="form-group">
						<label>{{ __('Product Price') }}</label>
						<input type="text" name="price" class="form-control" maxlength="255" required>
					</div>
					<div class="form-group">
						<label>{{ __('Product Quantity') }}</label>
						<input type="number" name="quantity" class="form-control" min="0" required>
					</div>
					<div class="form-group">
						<label>{{ __('Product Status') }}</label>
						<select class="form-control" name="status" required>
							<option value="1">{{ __('Active') }}</option>
							<option value="0">{{ __('Inactive') }}</option>
						</select>
					</div>
					<div class="form-group">
						<label>{{ __('Select Device') }}</label>
						<select class="form-control" name="cloudapi">
							@foreach($cloudapis as $cloudapi)
							<option value="{{ $cloudapi->id }}">{{ $cloudapi->name . ' - '. $cloudapi->phone }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-neutral submit-btn float-right">{{ __('Add Product') }}</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection