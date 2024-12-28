@extends('layouts.app')

@php
$title = 'Edit Farmer Loan';
$subTitle = 'Edit Farmer Loan';
@endphp

@section('content')
    <div class="card h-100 p-0 radius-12">
        <div class="card-body p-24">
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-xl-8 col-lg-10">
                    <div class="card border">
                        <div class="card-body">
                            <h6 class="text-md text-primary-light mb-16">Edit Loan Details</h6>
                            <br>
                            <form method="post" action="{{ route('farmer-loans.update', $loan->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-20">
                                    <label for="farmer_id" class="form-label fw-semibold text-primary-light text-sm mb-8">Select Farmer <span class="text-danger-600">*</span></label>
                                    <select name="farmer_id" class="form-control radius-8" id="farmer_id">
                                        <option value="">Select a farmer</option>
                                        @foreach($farmers as $farmer)
                                            <option value="{{ $farmer->id }}" {{ old('farmer_id', $loan->farmer_id) == $farmer->id ? 'selected' : '' }}>
                                                {{ $farmer->name }} - {{ $farmer->location }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">@error('farmer_id') {{$message}} @enderror</span>
                                </div>

                                <div class="mb-20">
                                    <label for="loan_amount" class="form-label fw-semibold text-primary-light text-sm mb-8">Loan Amount <span class="text-danger-600">*</span></label>
                                    <input name="loan_amount" type="number" step="0.01" class="form-control radius-8" id="loan_amount" placeholder="Enter loan amount" value="{{ old('loan_amount', $loan->loan_amount) }}">
                                    <span class="text-danger">@error('loan_amount') {{$message}} @enderror</span>
                                </div>

                                <div class="mb-20">
                                    <label for="interest_rate" class="form-label fw-semibold text-primary-light text-sm mb-8">Interest Rate (%) <span class="text-danger-600">*</span></label>
                                    <input name="interest_rate" type="number" step="0.01" class="form-control radius-8" id="interest_rate" placeholder="Enter interest rate" value="{{ old('interest_rate', $loan->interest_rate) }}">
                                    <span class="text-danger">@error('interest_rate') {{$message}} @enderror</span>
                                </div>

                                <div class="mb-20">
                                    <label for="repayment_duration" class="form-label fw-semibold text-primary-light text-sm mb-8">Repayment Duration (months) <span class="text-danger-600">*</span></label>
                                    <input name="repayment_duration" type="number" class="form-control radius-8" id="repayment_duration" placeholder="Enter repayment duration in months" value="{{ old('repayment_duration', $loan->repayment_duration) }}">
                                    <span class="text-danger">@error('repayment_duration') {{$message}} @enderror</span>
                                </div>

                                {{-- <div class="mb-20">
                                    <label for="status" class="form-label fw-semibold text-primary-light text-sm mb-8">Loan Status <span class="text-danger-600">*</span></label>
                                    <select name="status" class="form-control radius-8" id="status">
                                        <option value="pending" {{ old('status', $loan->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ old('status', $loan->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ old('status', $loan->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                    <span class="text-danger">@error('status') {{$message}} @enderror</span>
                                </div> --}}

                                {{-- <div class="mb-20">
                                    <label for="repaid" class="form-label fw-semibold text-primary-light text-sm mb-8">Payment Status</label>
                                    <select name="repaid" class="form-control radius-8" id="repaid">
                                        <option value="0" {{ old('repaid', $loan->repaid) == 0 ? 'selected' : '' }}>Not Paid</option>
                                        <option value="1" {{ old('repaid', $loan->repaid) == 1 ? 'selected' : '' }}>Paid</option>
                                    </select>
                                    <span class="text-danger">@error('repaid') {{$message}} @enderror</span>
                                </div> --}}

                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <a href="{{ route('farmer-loans.index') }}" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                        Cancel
                                    </a>

                                    <button type="submit" class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                        Update Loan
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
