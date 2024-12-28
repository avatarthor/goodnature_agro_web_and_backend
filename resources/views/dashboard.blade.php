@extends('layouts.app')

@php
$title = 'Good Nature Agro Farmer Management System';
$subTitle = 'Admin Dashboard';
@endphp

@section('content')
    <div class="row gy-4">
        <div class="row gy-4">
        <!-- Total Farmers Widget -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-3">
                <div class="card-body p-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                        <div class="d-flex align-items-center">
                            <div class="w-64-px h-64-px radius-16 bg-base-50 d-flex justify-content-center align-items-center me-20">
                                <span class="mb-0 w-40-px h-40-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center radius-8 h6 mb-0">
                                    <iconify-icon icon="flowbite:users-group-solid" class="icon"></iconify-icon>
                                </span>
                            </div>
                            <div>
                                <span class="mb-2 fw-medium text-secondary-light text-md">Total Farmers</span>
                                <h6 class="fw-semibold my-1">{{ number_format($totalFarmers) }}</h6>
                                <p class="text-sm mb-0">
                                    @if($weeklyNewFarmers > 0)
                                        Increase by
                                        <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">+{{ $weeklyNewFarmers }}</span> this week
                                    @else
                                        No new farmers this week
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($isLoanModuleActive ?? false)
        <!-- Total Loans Widget -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-2">
                <div class="card-body p-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                        <div class="d-flex align-items-center">
                            <div class="w-64-px h-64-px radius-16 bg-base-50 d-flex justify-content-center align-items-center me-20">
                                <span class="mb-0 w-40-px h-40-px bg-purple flex-shrink-0 text-white d-flex justify-content-center align-items-center radius-8 h6 mb-0">
                                    <iconify-icon icon="solar:wallet-bold" class="text-white text-2xl mb-0"></iconify-icon>
                                </span>
                            </div>
                            <div>
                                <span class="mb-2 fw-medium text-secondary-light text-md">Total Number of Loans</span>
                                <h6 class="fw-semibold my-1">{{ number_format($totalLoans) }}</h6>
                                <p class="text-sm mb-0">
                                    @if($weeklyNewLoans > 0)
                                        Increase by
                                        <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">+{{ $weeklyNewLoans }}</span> this week
                                    @else
                                        No new loans this week
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Loan Amount Widget -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-4">
                <div class="card-body p-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                        <div class="d-flex align-items-center">
                            <div class="w-64-px h-64-px radius-16 bg-base-50 d-flex justify-content-center align-items-center me-20">
                                <span class="mb-0 w-40-px h-40-px bg-success-main flex-shrink-0 text-white d-flex justify-content-center align-items-center radius-8 h6 mb-0">
                                    <iconify-icon icon="streamline:bag-dollar-solid" class="icon"></iconify-icon>
                                </span>
                            </div>
                            <div>
                                <span class="mb-2 fw-medium text-secondary-light text-md">Total Loan Amount Disbursed</span>
                                <h6 class="fw-semibold my-1">K{{ number_format($totalLoanAmount, 2) }}</h6>
                                <p class="text-sm mb-0">
                                    @if($weeklyNewLoanAmount > 0)
                                        Increase by
                                        <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">K{{ number_format($weeklyNewLoanAmount, 2) }}</span>
                                    @else
                                        No new disbursements
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Total Inputs Widget -->
        {{-- <div class="col-xxl-3 col-sm-6">
            <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-5">
                <div class="card-body p-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                        <div class="d-flex align-items-center">
                            <div class="w-64-px h-64-px radius-16 bg-base-50 d-flex justify-content-center align-items-center me-20">
                                <span class="mb-0 w-40-px h-40-px bg-yellow flex-shrink-0 text-white d-flex justify-content-center align-items-center radius-8 h6 mb-0">
                                    <iconify-icon icon="fa6-solid:file-invoice-dollar" class="text-white text-2xl mb-0"></iconify-icon>
                                </span>
                            </div>
                            <div>
                                <span class="mb-2 fw-medium text-secondary-light text-md">Total Inputs Distributed</span>
                                <h6 class="fw-semibold my-1">{{ number_format($totalInputs) }}</h6>
                                <p class="text-sm mb-0">
                                    @if($weeklyNewInputs > 0)
                                        Increase by
                                        <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">+{{ number_format($weeklyNewInputs) }}</span>
                                    @else
                                        No new distributions
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        </div>
        {{-- make a row so this block start on another line --}}


        @if($isLoanModuleActive ?? false)
        <!-- Loan Status Chart -->
        <div class="col-xxl-3">
            <div class="card h-100 radius-8 border-0">
                <div class="card-body p-24">
                    <h6 class="mb-2 fw-bold text-lg">Farmer Loans Status</h6>
                    <div class="position-relative">
                        <div id="statisticsDonutChart" class="mt-36 flex-grow-1 apexcharts-tooltip-z-none title-style circle-none"></div>
                    </div>
                    <ul class="d-flex flex-wrap flex-column mt-64 gap-3">
                        <li class="d-flex align-items-center gap-2">
                            <span class="w-16-px h-16-px radius-2 bg-warning-600"></span>
                            <span class="text-secondary-light text-lg fw-normal">Pending:
                                <span class="text-primary-light fw-bold text-lg">{{ $loanStats['pending'] ?? 0 }}</span>
                            </span>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <span class="w-16-px h-16-px radius-2 bg-success-600"></span>
                            <span class="text-secondary-light text-lg fw-normal">Approved:
                                <span class="text-primary-light fw-bold text-lg">{{ $loanStats['approved'] ?? 0 }}</span>
                            </span>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <span class="w-16-px h-16-px radius-2 bg-danger-600"></span>
                            <span class="text-secondary-light text-lg fw-normal">Rejected:
                                <span class="text-primary-light fw-bold text-lg">{{ $loanStats['rejected'] ?? 0 }}</span>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endif


        <!-- Latest Inputs Table -->
        {{-- <div class="col-xxl-6">
            <div class="card h-100">
                <div class="card-body p-24">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between mb-20">
                        <h6 class="mb-2 fw-bold text-lg mb-0">Latest Farmer Inputs</h6>
                        <a href="{{ route('farmer-inputs.index') }}" class="text-primary-600 hover-text-primary d-flex align-items-center gap-1">
                            View All
                            <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
                        </a>
                    </div>
                    <div class="table-responsive scroll-sm">
                        <table class="table bordered-table sm-table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Farmer</th>
                                    <th scope="col">Input Type</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($latestInputs as $input)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h6 class="text-md mb-0 fw-normal">{{ $input->farmer->name }}</h6>
                                                <span class="text-sm text-secondary-light fw-normal">{{ $input->farmer->location }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="text-md mb-0 fw-normal">{{ $input->inputType->name }}</h6>
                                    </td>
                                    <td>{{ number_format($input->quantity) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($input->distributed_date)->format('d M Y') }}</td>
                                </tr>
                                @endforeach

                                @if($latestInputs->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center">No inputs distributed yet</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> --}}

    </div>
@endsection

@push('scripts')
    <script>
        // Loan Status Donut Chart
        var options = {
            series: [
                {{ $loanStats['approved'] ?? 0 }},
                {{ $loanStats['pending'] ?? 0 }},
                {{ $loanStats['rejected'] ?? 0 }}
            ],
            colors: ['#15803D', '#CA8A04', '#B91C1C'],
            labels: ['Approved', 'Pending', 'Rejected'],
            legend: {
                show: false
            },
            chart: {
                type: 'donut',
                height: 230,
                sparkline: {
                    enabled: true
                },
                margin: {
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: 0
                },
                padding: {
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: 0
                }
            },
            stroke: {
                width: 0
            },
            dataLabels: {
                enabled: false
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#statisticsDonutChart"), options);
        chart.render();
    </script>
@endpush
