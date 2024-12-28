@extends('layouts.app')

@php
$title = 'Farmers List';
$subTitle = 'Manage Farmers';
$script = '<script>
let table = new DataTable("#farmersTable");
</script>';
@endphp

@section('content')
    <div class="card basic-data-table">

        {{-- <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Farmers Directory</h5>
            <a href="{{ route('farmers.create') }}" class="btn btn-primary">Add New Farmer</a>
        </div> --}}

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <table class="table basic-table mb-0" id="farmersTable" data-page-length='10'>
                <thead>
                    <tr>
                        <th scope="col">
                            <div class="form-check style-check d-flex align-items-center">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">
                                    ID
                                </label>
                            </div>
                        </th>
                        <th scope="col">Name</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Location</th>
                        <th scope="col">Created From</th>
                        <th scope="col">Created Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($farmers as $farmer)
                    <tr>
                        <td>
                            <div class="form-check style-check d-flex align-items-center">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">
                                    {{ $loop->iteration }}
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('assets/images/user-list/user-placeholder.png') }}" alt="" class="flex-shrink-0 me-12 radius-8" width="40">
                                <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ $farmer->name }}</h6>
                            </div>
                        </td>
                        <td>{{ $farmer->phone_number }}</td>
                        <td>{{ $farmer->location }}</td>
                        <td>
                            <span class="bg-primary-light text-primary-600 px-24 py-4 rounded-pill fw-medium text-sm">
                                {{ ucfirst($farmer->created_from) }}
                            </span>
                        </td>
                        <td>{{ $farmer->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('farmers.show', $farmer->id) }}"
                                   class="w-32-px h-32-px bg-primary-100 text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                </a>

                                <a href="{{ route('farmers.edit', $farmer->id) }}"
                                   class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                </a>

                                <form action="{{ route('farmers.delete', $farmer->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center border-0"
                                            onclick="return confirm('Are you sure you want to delete this farmer?')">
                                        <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
