<x-admin-layout :breadcrumbs="$breadcrumbs" title="Add New Post">

    <x-slot name="css">
        <style>
            .ck-editor__editable {
                min-height: 300px;
            }

        </style>
    </x-slot>

    <x-slot name="script">
        <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
        <script>
            $(function() {
                var editor = null;

                ClassicEditor
                    .create(document.querySelector('.ckeditor'), {
                        removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption',
                            'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'
                        ],
                    })
                    .then(newEditor => {
                        editor = newEditor;
                    })
                    .catch(error => {
                        console.error(error);
                    });

                var myModal = new bootstrap.Modal(document.getElementById('saving_modal'), {
                    backdrop: 'static'
                })

                $('form').on('submit', function() {
                    myModal.show()
                    $('#description').val(editor.getData())
                })
            })
        </script>
    </x-slot>

    <!-- Vertically centered modal -->
    <div class="modal fade" id="saving_modal" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="align-items-center d-flex justify-content-center m-4">
                    <span class="d-inline-block me-2">Saving...</span>
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body p-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="m-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="post_form" action="{{ url('admin/post') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-12 col-sm-3">
                        <label for="title">Title</label>
                    </div>
                    <div class="col-12 col-sm-9">
                        <input type="text" name="title" id="title" value="{{ old('title') ?? '' }}"
                            class="form-control">
                    </div>
                </div>

                <div class="row mt-3 pt-3 border-top">
                    <div class="col-12 col-sm-3">
                        <label for="short_description">Short Description</label>
                    </div>
                    <div class="col-12 col-sm-9">
                        <textarea rows="3" class="form-control" id="short_description"
                            name="short_description">{{ old('short_description') ?? '' }}</textarea>
                    </div>
                </div>

                <div class="row mt-3 pt-3 border-top">
                    <div class="col-12 col-sm-3">
                        <label for="description">Description</label>
                    </div>
                    <div class="col-12 col-sm-9">
                        <textarea class="ckeditor form-control" id="description" name="description">{!! old('description') !!}</textarea>
                    </div>
                </div>

                <div class="row mt-3 pt-3 border-top">
                    <div class="col-12 col-sm-3">
                        <label for="featured_image">Featured Image</label>
                    </div>
                    <div class="col-12 col-sm-9">
                        <input class="form-control" type="file" name="featured_image" id="featured_image">
                    </div>
                </div>

                <div class="row mt-3 pt-3 border-top">
                    <div class="col-12 col-sm-3">
                        <label for="status">Status</label>
                    </div>
                    <div class="col-12 col-sm-9">
                        <select class="form-select" aria-label="Default select example" name="status">
                            <option value="1">
                                Enabled</option>
                            <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>
                                Disabled</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-3 pt-3 border-top">
                    <div class="offset-3 col-9">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.post.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary ms-2">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
