<x-app-layout>
    <x-slot name='page_title'>
        <title>Users</title>
    </x-slot>

    <x-slot name='my_css'>

    </x-slot>

    <x-slot name="page_breadcrumb">
        <div class="pagetitle">
            <h1> Users </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="url('')">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
    </x-slot>


    <div class="card">
        <div class="card-header">
            <form id="form_filter" name="form_filter" method="POST" action="">
                <div class="row">
                    <div class="col-md-12" id="div_filters">
                        {{-- for Advance Filter --}}
                        {{--
                        <div id="advance_filter" style="display: none">
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label>Category</label>
                                    <input type="text" class="form-control" name="search_quantity"
                                        id="search_quantity" />
                                </div>
                            </div>
                        </div>
                        --}}
                        <div class='row'>

                            <div class="col-md-3">
                                <label>Name</label><input type="text" class="form-control" name="search_name"
                                    id="search_name" />
                            </div>

                            <div class="col-md-3">
                                <label>Email</label><input type="text" class="form-control" name="search_email"
                                    id="search_email" />
                            </div>


                        </div>
                    </div>
                    <input type="submit" style="display:none" />
                </div>
            </form>
        </div>

        <div class="card-body" style="overflow-x: auto">
            <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
            <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="created_at" />
            <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />

            <div class="row mt-2">
                <div class="col-md-12">
                    @if (Auth::user())
                    @endif
                    <button id="btn_filter" class="btn btn-info"><i class="bi bi-funnel"></i> Filter Search
                    </button>
                    <button onclick="new_user()" class="btn btn-success"><i class="bi bi-plus"></i> New User </button>
                    <!--<button id="btn_filter_advanced" class="btn btn-primary"><i class="fa fa-search"></i> Show
                                            Advanced
                                            Filter
                                        </button>-->
                </div>
            </div>
            <br>
            <div id="table_data_user">

            </div>
        </div>

    </div>


    <div class="modal fade" id="modal_user" tabindex="-1" data-bs-backdrop="static" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_user_head">New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="name" id="label_name" class="form-label">Name</label><input
                            onkeyup="color_empty('name')" type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="mb-2">
                        <label for="email" id="label_email" class="form-label">Email</label><input
                            onkeyup="color_empty('email')" type="text" class="form-control" id="email" name="email">
                    </div>

                    <div class="mb-2">
                        <label for="password" id="label_password" class="form-label">Password</label><input
                            onkeyup="color_empty('password')" type="password" class="form-control" id="password"
                            name="password">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class='bi bi-x'></i>Close</button>
                    <button type="button" class="btn btn-success" id="btn_save_user">Save New Account</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal_permissions" tabindex="-1" data-bs-backdrop="static" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_permissions_head">Users Permissions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-stripped table-hover table-bordered">
                        <tr>
                            <th></th>
                            <th>Permission</th>
                        </tr>

                        @foreach ($permissions as $permission)
                        <tr>
                            <td style="text-align: center"><input type="checkbox" value='{{ $permission->name }}'
                                    id="check_permission_{{ $permission->id }}"
                                    class="form-check-input check_permission"></td>
                            <td>
                                <label class="form-check-label" for="check_permission_{{ $permission->id }}">{{
                                    $permission->name }}</label>
                            </td>
                        </tr>
                        @endforeach

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class='bi bi-x'></i>Close</button>
                    <button type="button" class="btn btn-success" id="btn_save_permissions">Save
                        Permissions</button>
                </div>
            </div>
        </div>
    </div>


    <x-slot name="my_js">
        <script>
            var baseUrl = "{{ url('/') }}";
            var _token = "{{ csrf_token() }}";
            var transaction = 'add';
            var selected_id;
            var page = 1,
                sort_type = 'desc',
                column_name = 'created_at',
                show_advance = 0;
            var max_sub_category = 0;
            var current_page = 0;

            function edit_permission(user_id, permissions) {
                //check all permission checkbox
                $(".check_permission").attr("checked", false);
                selected_id = user_id;
                var sp = permissions.split("||");
                for (var i = 0; i < sp.length; i++) {
                    $('#check_permission_' + sp[i]).attr("checked", true);
                }
                $('#modal_permissions').modal('show');
            }

            function edit_account(user_id, user_name, user_email){
                transaction='edit';
                selected_id=user_id;
                $('#modal_user').modal('show');
                $('#name').val(user_name);
                $('#email').val(user_email);
            }

            $('#btn_save_user').on('click', function() {
                var error_count = 0;
                error_count += check_empty('name');
                error_count += check_empty('email');
                error_count += check_empty('password');

                if (error_count > 0) {
                    swal_error('Found empty field');
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
                            var name = $('#name').val();
                            var email = $('#email').val();
                            var password = $('#password').val();

                            show_loading('Saving New User');
                            $.post(baseUrl + '/user/save_user', {
                                '_token': _token,
                                'name': name,
                                'email': email,
                                'password': password,
                                'transaction': transaction,
                                'selected_id': selected_id,
                            }, function(data) {
                                if (data == "ok") {
                                    window.location.reload();
                                } else {
                                    swal_error(data);
                                }
                                hide_loading();
                            })
                        }
                    })
                }

            })


            function new_user() {
                $('#modal_user').modal('show');
            }

            $('#btn_save_permissions').on('click', function() {
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
                        var selected_permissions = $('.check_permission:checkbox:checked').map(function() {
                            return this.value;
                        }).get();
                        show_loading('Saving Users Permission', 'Please wait...');
                        $.post(baseUrl + '/user/save_permissions', {
                            '_token': _token,
                            'selected_permissions': selected_permissions,
                            'user_id': selected_id
                        }, function(data) {
                            if (data == 'ok') {
                                notify_success('Success!', 'Permissions updated successfully!');
                                fetch_data(page, sort_type, column_name);
                            } else {
                                swal_error(data);
                            }
                            $('#modal_permissions').modal('hide');
                            hide_loading();
                        })
                    }
                })
            })

            $(document).ready(function() {
                fetch_data(page, sort_type, column_name);

                $(document).on('click', '.sorting', function() {
                    column_name = $(this).data('column_name');
                    var reverse_order = '';
                    if (sort_type == 'asc') {
                        $(this).data('sorting_type', 'desc');
                        reverse_order = 'desc';
                    } else if (sort_type == 'desc') {
                        $(this).data('sorting_type', 'asc');
                        reverse_order = 'asc';
                    }
                    clear_icon();
                    sort_type = reverse_order;
                    fetch_data(page, reverse_order, column_name);
                });

                $(document).on('click', '.pagination a', function(event) {
                    event.preventDefault();
                    page = $(this).attr('href').split('page=')[1];
                    $('li').removeClass('active');
                    $(this).parent().addClass('active');
                    fetch_data(page, sort_type, column_name);
                });

            });


            function fetch_data(page, sort_type, sort_by) {
                show_loading('Populating Table');
                var filter = $('#form_filter').serialize();
                $.ajax({
                    url: baseUrl + "/user/get_ajax_data_user?sortby=" + sort_by + "&page=" + page + "&sorttype=" + sort_type +
                        "&" + filter,
                    success: function(data) {
                        $('#table_data_user').html(data);
                        clear_icon();
                        if (sort_type == "desc") {
                            $('#' + sort_by + '_icon').html('<span class="bi bi-sort-alpha-down"></span>');
                        } else {
                            $('#' + sort_by + '_icon').html('<span class="bi bi-sort-alpha-up"></span>');
                        }
                        hide_loading();
                    }
                });
            }

            function clear_icon() {
                $('#id_icon').html('');
                $('#post_title_icon').html('');
            }

            function show_hiddens(id) {
                $('#div_actions_' + id).show();
            }

            function hide_hiddens(id) {
                $('#div_actions_' + id).hide();
            }

            $('#btn_filter').on('click', function() {
                fetch_data(page, sort_type, column_name);
            })

            $('#form_filter').on('submit', function() {
                fetch_data(page, sort_type, column_name);
                return false;
            })
        </script>
    </x-slot>

</x-app-layout>