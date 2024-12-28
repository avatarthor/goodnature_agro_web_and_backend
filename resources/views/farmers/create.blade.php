@extends('layouts.app')

@php
$title = 'Create Farmer';
$subTitle = 'Create Farmer';
@endphp

@section('content')

    <div class="card h-100 p-0 radius-12">
        <div class="card-body p-24">
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-xl-8 col-lg-10">
                    <div class="card border">
                        <div class="card-body">

                            <h6 class="text-md text-primary-light mb-16">Enter Farmer Details</h6>

                            <br>

                            <form method="post" action="{{route('farmers.store')}}">
                                @csrf
                                <div class="mb-20">
                                    <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">Name <span class="text-danger-600">*</span></label>
                                    <input name="name" type="text" class="form-control radius-8" id="name" placeholder="Enter Full Name">
                                    <span class="text-danger">@error('name') {{$message}} @enderror</span>
                                </div>

                                <div class="mb-20">
                                    <label for="phone_number" class="form-label fw-semibold text-primary-light text-sm mb-8">Phone Number<span class="text-danger-600">*</span></label>
                                    <input name="phone_number" type="number" class="form-control radius-8" id="phone_number" placeholder="Enter Phone Number">
                                    <span class="text-danger">@error('phone_number') {{$message}} @enderror</span>

                                </div>

                                <div class="mb-20">
                                    <label for="number" class="form-label fw-semibold text-primary-light text-sm mb-8">Location<span class="text-danger-600">*</span></label>
                                    <input name="location" type="text" class="form-control radius-8" id="location" placeholder="Enter Location">
                                    <span class="text-danger">@error('location') {{$message}} @enderror</span>

                                </div>

                                <div class="d-flex align-items-center justify-content-center gap-3">

                                    <a href="{{ route('farmers.index') }}" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                        Cancel
                                    </a>

                                    <button type="submit" class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                        Save
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
