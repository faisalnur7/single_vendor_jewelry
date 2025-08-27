@extends('layouts.admin_master')

@section('title', 'Subscriber List')
@section('page_title', 'Subscriber List')

@section('contents')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-gradient-dark text-white rounded-top d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Subscriber List</h3>
        </div>

        <div class="card-body px-0 pb-4 pt-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Email</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subscribers as $subscriber)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $subscriber->email }}</td>
                                <td>
                                    <form action="{{ route('subscriber.delete', $subscriber->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this policy?')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No Privacy Policies found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $subscribers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
