@extends('layouts.app')

@php
$title = 'Input Distribution List';
$subTitle = 'Input Distribution List';

$script = '<script>
let table = new DataTable("#farmerInputsTable");
</script>';
@endphp

@section('content')
    <div class="card">

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <table class="table basic-table mb-0" id="farmerInputsTable" data-page-length='10'>
                <thead>
                    <tr>
                        <th scope="col">S.L</th>
                        <th scope="col">Farmer Name</th>
                        <th scope="col">Farmer Location</th>
                        <th scope="col">Input Type</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Distribution Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inputs as $index => $input)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ $input->farmer->name }}</h6>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ $input->farmer->location }}</h6>
                            </div>
                        </td>
                        <td>{{ $input->inputType->name }}</td>
                        <td>{{ $input->quantity }}</td>
                        <td>{{ \Carbon\Carbon::parse($input->distributed_date)->format('d M Y') }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('farmer-inputs.edit', $input->id) }}"
                                   class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                </a>

                                <a href="javascript:void(0)"
                                   onclick="deleteInput({{ $input->id }})"
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
        function deleteInput(id) {
            if(confirm('Are you sure you want to delete this input distribution?')) {
                window.location.href = "{{ url('farmer-inputs/delete') }}/" + id;
            }
        }
    </script>
    @endpush
@endsection
