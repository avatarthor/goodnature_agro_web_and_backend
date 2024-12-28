@extends('layouts.app')

@php
$title = 'Edit Input Type';
$subTitle = 'Edit Input Type';
@endphp

@section('content')
    <div class="card h-100 p-0 radius-12">
        <div class="card-body p-24">
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-xl-8 col-lg-10">
                    <div class="card border">
                        <div class="card-body">
                            <h6 class="text-md text-primary-light mb-16">Edit Input Type Details</h6>
                            <br>
                            <form method="post" action="{{ route('farmer-input-types.update', $inputType->id) }}">
                                @csrf
                                <div class="mb-20">
                                    <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">Name <span class="text-danger-600">*</span></label>
                                    <input name="name" type="text" class="form-control radius-8" id="name" placeholder="Enter input type name" value="{{ old('name', $inputType->name) }}">
                                    <span class="text-danger">@error('name') {{$message}} @enderror</span>
                                </div>

                                <div class="mb-20">
                                    <label for="description" class="form-label fw-semibold text-primary-light text-sm mb-8">Description <span class="text-danger-600">*</span></label>
                                    <textarea name="description" class="form-control radius-8" id="description" rows="3" placeholder="Enter input type description">{{ old('description', $inputType->description) }}</textarea>
                                    <span class="text-danger">@error('description') {{$message}} @enderror</span>
                                </div>

                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <a href="{{ route('farmer-input-types.index') }}" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                        Cancel
                                    </a>

                                    <button type="submit" class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                        Update
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
