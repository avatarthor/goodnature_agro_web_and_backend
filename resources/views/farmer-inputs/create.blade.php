@extends('layouts.app')

@php
$title = 'Distribute Input';
$subTitle = 'Distribute Input';
@endphp

@section('content')
    <div class="card h-100 p-0 radius-12">
        <div class="card-body p-24">
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-xl-8 col-lg-10">
                    <div class="card border">
                        <div class="card-body">
                            <h6 class="text-md text-primary-light mb-16">Enter Input Distribution Details</h6>
                            <br>
                            <form method="post" action="{{ route('farmer-inputs.store') }}">
                                @csrf
                                <div class="mb-20">
                                    <label for="farmer_id" class="form-label fw-semibold text-primary-light text-sm mb-8">Select Farmer <span class="text-danger-600">*</span></label>
                                    <select name="farmer_id" class="form-control radius-8" id="farmer_id">
                                        <option value="">Select a farmer</option>
                                        @foreach($farmers as $farmer)
                                            <option value="{{ $farmer->id }}" {{ old('farmer_id') == $farmer->id ? 'selected' : '' }}>
                                                {{ $farmer->name }} - {{ $farmer->location }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">@error('farmer_id') {{$message}} @enderror</span>
                                </div>

                                <div class="mb-20">
                                    <label for="input_type_id" class="form-label fw-semibold text-primary-light text-sm mb-8">Select Input Type <span class="text-danger-600">*</span></label>
                                    <select name="input_type_id" class="form-control radius-8" id="input_type_id">
                                        <option value="">Select an input type</option>
                                        @foreach($inputTypes as $type)
                                            <option value="{{ $type->id }}" {{ old('input_type_id') == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">@error('input_type_id') {{$message}} @enderror</span>
                                </div>

                                <div class="mb-20">
                                    <label for="quantity" class="form-label fw-semibold text-primary-light text-sm mb-8">Quantity <span class="text-danger-600">*</span></label>
                                    <input name="quantity" type="number" class="form-control radius-8" id="quantity" placeholder="Enter quantity" value="{{ old('quantity') }}">
                                    <span class="text-danger">@error('quantity') {{$message}} @enderror</span>
                                </div>

                                <div class="mb-20">
                                    <label for="distributed_date" class="form-label fw-semibold text-primary-light text-sm mb-8">Distribution Date <span class="text-danger-600">*</span></label>
                                    <input name="distributed_date" type="date" class="form-control radius-8" id="distributed_date" value="{{ old('distributed_date') }}">
                                    <span class="text-danger">@error('distributed_date') {{$message}} @enderror</span>
                                </div>

                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <a href="{{ route('farmer-inputs.index') }}" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                        Cancel
                                    </a>

                                    <button type="submit" class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                        Distribute
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
