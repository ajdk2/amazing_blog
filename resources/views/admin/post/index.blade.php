<x-admin-layout :breadcrumbs="$breadcrumbs" title="Posts">
    <x-slot name="cta">
        <a href="{{ route('admin.post.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i>
            Add New Post
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

    @if (session('status'))
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">Amazing Blog</strong>
                    <small class="text-muted">Just now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('status') }}
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-12 x_col-xl-3 x_col-md-6">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Author</th>
                            <th scope="col">Date Added</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($posts)
                            @foreach ($posts as $key => $post)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->author->first_name . ' ' . $post->author->last_name }}</td>
                                    <td>{{ $post->created_at }}</td>
                                    <td>{{ $post->is_enabled ? 'Enabled' : 'Disabled' }}</td>
                                    <td>
                                        <a href="{{ route('admin.post.edit', $post->id) }}"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <a href="{{ route('admin.post.delete', $post->id) }}"
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
            {{ $posts->withQueryString()->links() }}
        </div>
    </div>
</x-admin-layout>
