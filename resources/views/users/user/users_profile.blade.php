<x-app-layout>
    <x-slot name="page_title">
        <title>Testing</title>
    </x-slot>

    <x-slot name="my_css">
        <style>

        </style>
    </x-slot>

    <x-slot name="page_breadcrumb">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard1</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">

                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                            <img src="{{ $user->profile_picture ? url('storage/profile_pictures/' . $user->profile_picture) : url('/images/default_image.png') }}"
                                alt="Profile" class="rounded-circle">
                            <h2>{{ $user->name }}</h2>
                            <h3>{{ $user->email }}</h3>
                            <div class="social-links mt-2">
                                <button onclick="update_image()" class="btn btn-primary"><i
                                        class="bi bi-upload"></i></button>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-xl-8">

                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                        data-bs-target="#profile-change-password" aria-selected="false" tabindex="-1"
                                        role="tab">Change Password</button>
                                </li>

                            </ul>
                            <div class="tab-content pt-2">
                                <div class="tab-pane fade show active pt-3" id="profile-change-password"
                                    role="tabpanel">
                                    <!-- Change Password Form -->
                                    <form>

                                        <div class="row mb-3">
                                            <label for="currentPassword"
                                                class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="password" type="password" class="form-control"
                                                    id="currentPassword">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New
                                                Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="newpassword" type="password" class="form-control"
                                                    id="newPassword">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter
                                                New Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="renewpassword" type="password" class="form-control"
                                                    id="renewPassword">
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="button" id="save_new_password" class="btn btn-primary">Change
                                                Password</button>
                                        </div>
                                    </form><!-- End Change Password Form -->

                                </div>

                            </div><!-- End Bordered Tabs -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </x-slot>

    <div class="row">

    </div>

    <div class="modal" tabindex="-1" id="modal_profile_image">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Profile Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" name="form_file_upload" id="form_file_upload">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label id="file_upload_label">Profile Picture (Max 1MB)</label>
                                    <div class="input-group">
                                        <input type="file" accept="image/*,application/pdf" class="form-control"
                                            id="file_attachment" name="file_attachment">
                                        <span id="file_add_on" style="display: none" class="input-group-addon"
                                            title="Encode to all other the same equipment in this batch.">
                                            <input type="checkbox" name="check_file_all" id="check_file_all"
                                                aria-label="Encode to all other the same equipment in this batch.">
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn_save_file_upload">Upload Image</button>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="my_js">
        <script>
            var baseUrl = "{{ url('/') }}";
            var _token = "{{ csrf_token() }}";


            $('#save_new_password').on('click', function() {

                var current_password = $('#currentPassword').val();
                var newPassword = $('#newPassword').val();
                var renewPassword = $('#renewPassword').val();

                if (current_password == '' || newPassword == '' || renewPassword == '') {
                    swal_error('There is an empty field!');
                } else if (newPassword != renewPassword) {
                    swal_error('New passwords did not match!');
                } else {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#save_new_password').prop('disabled', true);
                            $.post(baseUrl + '/change_password', {
                                '_token': _token,
                                'current_password': current_password,
                                'newPassword': newPassword,
                                'user_id': {{ $user->id }}
                            }, function(data) {
                                if (data == 'ok') {
                                    notify_success('Success', 'Password updated successfully!');
                                    $('#modal_edit_equipment').modal('hide');
                                } else {
                                    swal_error(data);
                                }
                                $('#save_new_password').prop('disabled', false);
                            })
                        }
                    })
                }



            })


            function update_image() {
                $('#modal_profile_image').modal('show');
            }

            $('#btn_save_file_upload').on('click', function() {
                error_count = 0;
                error_count += check_empty('file_attachment');
                if (error_count >= 1) {
                    swal_error("Please select IMAGE or PDF file.");
                } else {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#div_file_loading').show();
                            $('#btn_save_file_upload').prop('disabled', true);
                            var form_data = new FormData(document.getElementById("form_file_upload"));
                            form_data.append('_token', _token);
                            form_data.append('user_id', {{ $user->id }});
                            $.ajax({
                                type: 'POST',
                                url: baseUrl + '/profile/save_file_attachment',
                                data: form_data,
                                contentType: false,
                                processData: false,
                                success: (response) => {
                                    notify_success('Completed!',
                                        'Profile Image Uploaded Successfully!');
                                    $('#modal_file_upload').modal('hide');
                                    $('#btn_save_file_upload').prop('disabled', false);
                                    window.location.reload();
                                },
                                error: function(xhr, status, error) {
                                    swal_error(xhr.responseText);
                                    $('#btn_save_file_upload').prop('disabled', false);
                                    $('#modal_file_upload').modal('hide');
                                }


                            });


                        }
                    })
                }
            })
        </script>
    </x-slot>

</x-app-layout>
