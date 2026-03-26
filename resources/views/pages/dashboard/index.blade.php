// resources/views/pages/pos/index.blade.php
@extends('layouts.app')

@section('title', 'Point of Sale')

@section('content')
<div class="row">
    {{-- Product Grid Section --}}
    <div class="col-lg-8 col-md-7">
        <div class="card">
            <div class="card-header">
                <h4>Choose Product</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($products as $product)
                    <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4 class="card-title">{{ $product['name'] }}</h4>
                            </div>
                            <div class="card-body">
                                <img src="{{ $product['image'] }}" alt="product-image" class="img-fluid mb-3">
                                <p>{{ $product['description'] }}</p>

                                <div class="form-group">
                                    <label for="unit">Unit</label>
                                    <select class="form-control">
                                        <option>Meter</option>
                                        <option>Roll</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="color">Color</label>
                                    <select class="form-control">
                                        <option>Red</option>
                                        <option>Blue</option>
                                        <option>Green</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <button class="btn btn-primary btn-block">
                                    <i class="fas fa-plus"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Cart Section --}}
    <div class="col-lg-4 col-md-5">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-shopping-cart"></i> Shopping Cart</h4>
            </div>
            <div class="card-body">
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">Kain Sutra</h6>
                            <small class="text-muted">1 Meter, Red</small>
                        </div>
                        <span class="text-muted">Rp. 75.000</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">Benang Wol</h6>
                            <small class="text-muted">2 Pcs, Blue</small>
                        </div>
                        <span class="text-muted">Rp. 30.000</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between bg-light">
                        <div class="text-success">
                            <h6 class="my-0">Promo Code</h6>
                            <small>HEMAT10</small>
                        </div>
                        <span class="text-success">-Rp. 10.500</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Total (IDR)</strong>
                        <strong>Rp. 94.500</strong>
                    </li>
                </ul>
            </div>
            <div class="card-footer">
                <button class="btn btn-success btn-block">
                    <i class="fas fa-credit-card"></i> Process Payment
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
    <!-- CSS Libraries specific to this page -->
@endpush

@push('script')
    <!-- JS Libraries specific to this page -->
@endpush
