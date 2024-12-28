@extends('layouts.app')

@php
$title = 'Module Management';
$subTitle = 'Manage System Modules';
@endphp

@section('content')
    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModuleModal">
                Upload New Module
            </button>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table basic-table">
                    <thead>
                        <tr>
                            <th>Module Name</th>
                            <th>Description</th>
                            <th>Version</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($modules as $module)
                            <tr>
                                <td>{{ ucfirst($module['name']) }}</td>
                                <td>{{ $module['description'] }}</td>
                                <td>{{ $module['version'] }}</td>
                                <td>
                                    @if($module['active'])
                                        <span class="bg-success-focus text-success-main px-16 py-4 rounded-pill fw-medium text-sm">
                                            Active
                                        </span>
                                    @else
                                        <span class="bg-danger-focus text-danger-main px-16 py-4 rounded-pill fw-medium text-sm">
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <form action="{{ route('modules.toggle', $module['name']) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm {{ $module['active'] ? 'btn-warning' : 'btn-success' }}">
                                                {{ $module['active'] ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>

                                        <form action="{{ route('modules.destroy', $module['name']) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this module? This action cannot be undone.')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No modules installed</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Upload Module Modal -->
    <div class="modal fade" id="uploadModuleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload New Module</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('modules.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="module_zip" class="form-label">Module Package (ZIP)</label>
                            <input type="file" class="form-control" id="module_zip" name="module_zip" accept=".zip" required>
                            <small class="text-muted">Upload a ZIP file containing the module</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Upload & Install</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
