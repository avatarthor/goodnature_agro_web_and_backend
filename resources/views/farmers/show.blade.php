@extends('layouts.app')

@php
$title = 'Farmer Details';
$subTitle = 'Farmer Details';
@endphp

@section('content')
    <div class="row gy-4">
        <!-- Farmer Profile Card -->
        <div class="col-lg-4">
            <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
                <img src="{{ asset('assets/images/user-grid/user-grid-bg1.png') }}" alt="" class="w-100 object-fit-cover">
                <div class="pb-24 ms-16 mb-24 me-16 mt--100">
                    <div class="text-center border border-top-0 border-start-0 border-end-0">
                        <div class="border br-white border-width-2-px w-200-px h-200-px rounded-circle object-fit-cover
                             d-flex align-items-center justify-content-center mx-auto bg-light">
                            <iconify-icon icon="ph:user-bold" width="100" height="100"></iconify-icon>
                        </div>
                        <h6 class="mb-0 mt-16">{{ $farmer->name }}</h6>
                        <span class="text-secondary-light mb-16">{{ $farmer->location }}</span>
                    </div>
                    <div class="mt-24">
                        <h6 class="text-xl mb-16">Farmer Information</h6>
                        <ul>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light">Full Name</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $farmer->name }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light">Phone Number</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $farmer->phone_number }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light">Location</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $farmer->location }}</span>
                            </li>
                            @if($isLoanModuleActive ?? false)
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light">Total Loans</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $farmer->farmerLoans->count() }}</span>
                            </li>
                            @endif
                            @if($isInputModuleActive ?? false)
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light">Total Inputs</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $farmer->farmerInputs->count() }}</span>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs Container - Only show if at least one module is active -->
        @if(($isLoanModuleActive ?? false) || ($isInputModuleActive ?? false))
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-body p-24">
                    <ul class="nav border-gradient-tab nav-pills mb-20 d-inline-flex" id="pills-tab" role="tablist">
                        @if($isLoanModuleActive ?? false)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center px-24 active" id="pills-loans-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-loans" type="button" role="tab"
                                    aria-controls="pills-loans" aria-selected="true">
                                Loan History
                            </button>
                        </li>
                        @endif
                        @if($isInputModuleActive ?? false)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center px-24 {{ !($isLoanModuleActive ?? false) ? 'active' : '' }}"
                                    id="pills-inputs-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-inputs" type="button" role="tab"
                                    aria-controls="pills-inputs" aria-selected="{{ !($isLoanModuleActive ?? false) }}">
                                Input Distribution History
                            </button>
                        </li>
                        @endif
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <!-- Loans Tab -->
                        @if($isLoanModuleActive ?? false)
                        <div class="tab-pane fade show active" id="pills-loans" role="tabpanel" aria-labelledby="pills-loans-tab">
                            <div class="table-responsive">
                                <table class="table basic-table">
                                    <thead>
                                        <tr>
                                            <th>Amount</th>
                                            <th>Interest Rate</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                            <th>Payment</th>
                                            <th>Issue Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($farmer->farmerLoans as $loan)
                                            <tr>
                                                <td>K{{ number_format($loan->loan_amount, 2) }}</td>
                                                <td>{{ $loan->interest_rate }}%</td>
                                                <td>{{ $loan->repayment_duration }} Months</td>
                                                <td>
                                                    @if($loan->status == 'approved')
                                                        <span class="bg-success-focus text-success-main px-16 py-4 rounded-pill fw-medium text-sm">
                                                            Approved
                                                        </span>
                                                    @elseif($loan->status == 'pending')
                                                        <span class="bg-warning-focus text-warning-main px-16 py-4 rounded-pill fw-medium text-sm">
                                                            Pending
                                                        </span>
                                                    @else
                                                        <span class="bg-danger-focus text-danger-main px-16 py-4 rounded-pill fw-medium text-sm">
                                                            Rejected
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($loan->repaid)
                                                        <span class="bg-success-focus text-success-main px-16 py-4 rounded-pill fw-medium text-sm">
                                                            Paid
                                                        </span>
                                                    @else
                                                        <span class="bg-danger-focus text-danger-main px-16 py-4 rounded-pill fw-medium text-sm">
                                                            Not Paid
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>{{ $loan->created_at->format('d M Y') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No loans found for this farmer</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif

                        <!-- Inputs Tab -->
                        @if($isInputModuleActive ?? false)
                        <div class="tab-pane fade {{ !($isLoanModuleActive ?? false) ? 'show active' : '' }}"
                             id="pills-inputs" role="tabpanel" aria-labelledby="pills-inputs-tab">
                            <div class="table-responsive">
                                <table class="table basic-table">
                                    <thead>
                                        <tr>
                                            <th>Input Type</th>
                                            <th>Quantity</th>
                                            <th>Distribution Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($farmer->farmerInputs as $input)
                                            <tr>
                                                <td>{{ $input->inputType->name }}</td>
                                                <td>{{ number_format($input->quantity) }}</td>
                                                <td>{{ \Carbon\Carbon::parse($input->distributed_date)->format('d M Y') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">No inputs distributed to this farmer</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
