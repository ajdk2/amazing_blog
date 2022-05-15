<x-admin-layout :breadcrumbs="$breadcrumbs" title="Users">
    <x-slot name="cta">
        <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i>
            Add New User
        </a>
    </x-slot>

    <x-slot name="script">
        <script>
            $(function() {
                $('.btn-delete').on('click', function(e) {
                    if (!confirm("Are you sure you want to delete this post?")) {
                        e.preventDefault();
                    }
                });
            })
        </script>
    </x-slot>

    <div class="row">
        <div class="col-12 x_col-xl-3 x_col-md-6">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Full name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Date Added</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($users)
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>{{ $user->is_enabled ? 'Enabled' : 'Disabled' }}</td>
                                    <td>
                                        <a href="{{ route('admin.user.edit', $user->id) }}"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <a href="{{ route('admin.user.delete', $user->id) }}"
                                            class="ms-1 btn btn-outline-danger btn-sm btn-delete">
                                            <i class="bi bi-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            {{ $users->links() }}
        </div>
    </div>
</x-admin-layout>
