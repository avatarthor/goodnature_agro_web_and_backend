@extends('layouts.app')

@php
$title = 'Input Types List';
$subTitle = 'Input Types List';

$script = '<script>
let table = new DataTable("#inputTypesTable");
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
            <table class="table basic-table mb-0" id="inputTypesTable" data-page-length='10'>
                <thead>
                    <tr>
                        <th scope="col">S.L</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Created Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inputTypes as $index => $type)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ $type->name }}</h6>
                            </div>
                        </td>
                        <td>{{ Str::limit($type->description, 50) }}</td>
                        <td>{{ $type->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('farmer-input-types.edit', $type->id) }}"
                                   class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                </a>

                                <a href="javascript:void(0)"
                                   onclick="deleteInputType({{ $type->id }})"
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
        function deleteInputType(id) {
            if(confirm('Are you sure you want to delete this input type?')) {
                window.location.href = "{{ url('farmer-input-types/delete') }}/" + id;
            }
        }
    </script>
    @endpush
@endsection
