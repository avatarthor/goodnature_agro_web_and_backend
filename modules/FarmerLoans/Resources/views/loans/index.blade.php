@extends('layouts.app')

@php
$title = 'Loan List';
$subTitle = 'Loan List';

$script = '<script>
let table = new DataTable("#farmersLoansTable");
</script>';
@endphp

@section('content')
    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
        </div>
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
            <table class="table basic-table mb-0" id="farmersLoansTable" data-page-length='10'>
                <thead>
                    <tr>
                        <th scope="col">S.L</th>
                        <th scope="col">Farmer Name</th>
                        <th scope="col">Issue Date</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Interest Rate</th>
                        <th scope="col">Duration</th>
                        <th scope="col">Status</th>
                        <th scope="col">Payment</th>

                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loans as $index => $loan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ $loan->farmer->name }}</h6>
                            </div>
                        </td>
                        <td>{{ $loan->created_at->format('d M Y') }}</td>
                        <td>K{{ number_format($loan->loan_amount, 2) }}</td>
                        <td>{{ $loan->interest_rate }}%</td>
                        <td>{{ $loan->repayment_duration }} Months</td>
                        <td>
                            @if($loan->status == 'approved')
                                <span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Approved</span>
                            @elseif($loan->status == 'pending')
                                <span class="bg-warning-focus text-warning-main px-24 py-4 rounded-pill fw-medium text-sm">Pending</span>
                            @else
                                <span class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">Rejected</span>
                            @endif
                        </td>

                        <td>
                            @if($loan->repaid == 1)
                                <span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Paid</span>
                            @else
                                <span class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">Not Paid</span>
                            @endif
                        </td>

                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($loan->status == 'pending')
                                    <select class="form-select form-select-sm w-auto bg-base border text-secondary-light"
                                            onchange="changeLoanStatus({{ $loan->id }}, this.value)">
                                        <option value="">Change Status</option>
                                        <option value="approved">Approve</option>
                                        <option value="rejected">Reject</option>
                                    </select>
                                @endif

                                @if($loan->status == 'approved' && !$loan->repaid)
                                    <button onclick="markAsPaid({{ $loan->id }})"
                                            class="btn btn-sm btn-warning">
                                        Mark as Paid
                                    </button>
                                @endif

                                <a href="{{ route('farmer-loans.edit', $loan->id) }}"
                                   class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                </a>

                                <a href="javascript:void(0)"
                                   onclick="deleteLoan({{ $loan->id }})"
                                   class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script>
        function deleteLoan(id) {
            if(confirm('Are you sure you want to delete this loan?')) {
                window.location.href = "{{ url('farmer-loans/delete') }}/" + id;
            }
        }

        function changeLoanStatus(id, status) {
            if(status && confirm('Are you sure you want to ' + status + ' this loan?')) {
                window.location.href = "{{ url('farmer-loans/status') }}/" + id + "?status=" + status;
            }
        }

        function markAsPaid(id) {
            if(confirm('Are you sure you want to mark this loan as paid?')) {
                window.location.href = "{{ url('farmer-loans/paid') }}/" + id;
            }
        }
    </script>
    @endpush
@endsection
