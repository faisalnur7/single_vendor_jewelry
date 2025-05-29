@extends('layouts.admin_master')

@section('title', 'User List')
@section('page_title', 'User List')

@section('contents')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-gradient-dark text-white rounded-top d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">User List</h3>
                {{-- <a href="{{ route('category.create') }}" class="btn btn-primary btn-sm ml-auto">
                    <i class="fas fa-plus"></i> Add User
                </a> --}}
            </div>

            <div class="card-body px-0 pb-4 pt-0">
                @if (session('success'))
                    <div class="alert alert-success mb-3">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No categories found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="mt-3">
                        {{ $users->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
