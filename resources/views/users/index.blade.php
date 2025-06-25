@extends('dashboard.layout')

@section('title', __('dashboard.user_list'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('dashboard.users')</h1>
        <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary">@lang('dashboard.add_user')</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>@lang('dashboard.user_name')</th>
                            <th>@lang('dashboard.user_email')</th>
                            <th>@lang('dashboard.user_role')</th>
                            <th>@lang('dashboard.status')</th>
                            <th>@lang('dashboard.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><span class="badge bg-secondary">{{ $user->role }}</span></td>
                                <td>
                                    @if($user->is_active)
                                        <span class="badge bg-success">@lang('dashboard.active')</span>
                                    @else
                                        <span class="badge bg-danger">@lang('dashboard.inactive')</span>
                                    @endif
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="{{ route('dashboard.users.show', $user->id) }}" class="btn btn-info btn-sm" title="@lang('dashboard.show')"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('dashboard.users.edit', $user->id) }}" class="btn btn-primary btn-sm" title="@lang('dashboard.edit')"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('@lang('dashboard.confirm_delete')');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="@lang('dashboard.delete')"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 