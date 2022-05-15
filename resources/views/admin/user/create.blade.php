<x-admin-layout :breadcrumbs="$breadcrumbs" title="Add New User">
    <x-slot name="script">
        <script>
            $(function() {
                var myModal = new bootstrap.Modal(document.getElementById('saving_modal'), {
                    backdrop: 'static'
                })

                $('form').on('submit', function() {
                    myModal.show()
                })
            })
        </script>
    </x-slot>

    <!-- Vertically centered modal -->
    <div class="modal fade" id="saving_modal" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="align-items-center d-flex justify-content-center m-4">
                    <label class="d-inline-block me-2">Saving...</label>
                    <div class="spinner-border spinner-border-sm" role="status">
                        <label class="visually-hidden">Loading...</label>
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

            <form id="post_form" action="{{ route('admin.user.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-12 col-sm-3">
                        <label for="first_name">First name</label>
                    </div>
                    <div class="col-12 col-sm-9">
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') ?? '' }}"
                            class="form-control">
                    </div>
                </div>

                <div class="row mt-3 pt-3 border-top">
                    <div class="col-12 col-sm-3">
                        <label for="last_name">Last name</label>
                    </div>
                    <div class="col-12 col-sm-9">
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') ?? '' }}"
                            class="form-control">
                    </div>
                </div>

                <div class="row mt-3 pt-3 border-top">
                    <div class="col-12 col-sm-3">
                        <label for="email">Email</label>
                    </div>
                    <div class="col-12 col-sm-9">
                        <input type="email" name="email" id="email" value="{{ old('email') ?? '' }}"
                            class="form-control">
                    </div>
                </div>

                <div class="row mt-3 pt-3 border-top">
                    <div class="col-12 col-sm-3">
                        <label for="password">Password</label>
                    </div>
                    <div class="col-12 col-sm-9">
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                </div>

                <div class="row mt-3 pt-3 border-top">
                    <div class="col-12 col-sm-3">
                        <label for="password_confirmation">Confirm Password</label>
                    </div>
                    <div class="col-12 col-sm-9">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control">
                    </div>
                </div>

                <div class="row mt-3 pt-3 border-top">
                    <div class="col-12 col-sm-3">
                        <label for="status">Status</label>
                    </div>
                    <div class="col-12 col-sm-9">
                        <select name="status" id="status" class="form-select" aria-label="Default select example">
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
                            <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary ms-2">Save</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</x-admin-layout>
