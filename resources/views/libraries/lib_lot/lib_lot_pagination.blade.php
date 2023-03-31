<x-app-layout>
    <x-slot name='page_title'>
        <title>Lots</title>
    </x-slot>

    <x-slot name='my_css'>

    </x-slot>

    <x-slot name="page_breadcrumb">
        <div class="pagetitle">
            <h1> Lots </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="url('')">Home</a></li>
                    <li class="breadcrumb-item active">Lots</li>
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
                                                        <input type="text" class="form-control" name="search_quantity" id="search_quantity" />
                                                    </div>
                                                </div>
                                            </div>
                                            --}}
                        <div class='row'>

                            <div class="col-md-3">
                                <label>Section</label>
                                <select class="form-control" name="search_section_id" id="search_section_id">
                                    <option value="">---All---</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->description }}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="col-md-3">
                                <label>Block</label>
                                <select class="form-control" name="search_block_id" id="search_block_id">
                                    <option value="">---All---</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>Block</label>
                                <select class="form-control" name="search_lot_id" id="search_lot_id">
                                    <option value="">---All---</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Owner</label><input type="text" class="form-control" name="search_owner"
                                    id="search_owner" />
                            </div>
                            <div class="col-md-3">
                                <label>Delingquent</label>
                                <select class="form-control" name="search_delinquent" id="search_delinquent">
                                    <option value="">---Both---</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Status</label>
                                <select class="form-control" name="search_sold" id="search_sold">
                                    <option value="">---Both---</option>
                                    <option value="sold">Sold</option>
                                    <option value="unsold">Unsold</option>
                                </select>
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
                        <button type="button" onclick="add_lib_lot()" class="btn btn-success"><i
                                class="bi bi-plus-circle"></i> New Lots</button>
                    @endif
                    <button id="btn_filter" class="btn btn-info"><i class="bi bi-funnel"></i> Filter Search
                    </button>
                    <!--<button id="btn_filter_advanced" class="btn btn-primary"><i class="fa fa-search"></i> Show
                                            Advanced
                                            Filter
                                        </button>-->
                </div>
            </div>
            <br>
            <div id="table_data_lib_lot">

            </div>
        </div>

    </div>


    <div class="modal fade" id="modal_lib_lot" tabindex="-1" data-bs-backdrop="static" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_lib_lot_head"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="section_id" id="label_section_id" class="form-label">Section</label>
                        <select onchange="color_empty_number('sel_section')" class="form-control" id="sel_section"
                            name="sel_section">
                            <option value="">---Select---</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="block_id" id="label_block_id" class="form-label">Block Number</label>
                        <select onchange="color_empty_number('sel_block')" class="form-control" id="sel_block"
                            name="sel_block">
                            <option value="">---Select Section First</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="lot_number_start" id="label_lot_number_start" class="form-label">Lot
                                    Number
                                    Range
                                    From</label>
                                <input onkeyup="color_empty_number('lot_number_start')" type="number"
                                    class="form-control" id="lot_number_start" name="lot_number_start">
                            </div>
                            <div class="col-md-6">
                                <label for="lot_number_end" id="label_lot_number_end" class="form-label">Lot Number
                                    Range
                                    To</label>
                                <input onkeyup="color_empty_number('lot_number_end')" type="number"
                                    class="form-control" id="lot_number_end" name="lot_number_end">
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class='bi bi-x'></i>Close</button>
                    <button type="button" class="btn btn-success" id="btn_save_lib_lot"></button>
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
                column_name = 'lib_sections.id',
                show_advance = 0;
            var max_sub_category = 0;
            var current_page = 0;

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

            $('#sel_section').on('change', function() {
                var section_id = $(this).val();
                show_loading('Retrieving Blocks!');
                $.post(baseUrl + '/get_blocks_by_section/' + section_id, {
                    '_token': _token
                }, function(data) {
                    $('#sel_block').html(data);
                    hide_loading();
                })
            })

            $('#search_section_id').on('change', function() {
                var section_id = $(this).val();
                show_loading('Retrieving Blocks!');
                $.post(baseUrl + '/get_blocks_by_section/' + section_id, {
                    '_token': _token
                }, function(data) {

                    $('#search_block_id').html(data);
                    hide_loading();
                    fetch_data(page, sort_type, column_name);

                })
            })

            $('#search_block_id').on('change', function() {
                var sel_block = $(this).val();
                show_loading('Retrieving Lots!');
                $.post(baseUrl + '/client/get_lots', {
                    '_token': _token,
                    'sel_block': sel_block,
                }, function(data) {
                    $('#search_lot_id').html(data);
                    hide_loading();
                    fetch_data(page, sort_type, column_name);
                })
            })


            function fetch_data(page, sort_type, sort_by) {
                show_loading('Populating Table');
                var filter = $('#form_filter').serialize();
                $.ajax({
                    url: "/lib-lot/get_ajax_data_lib_lot?sortby=" + sort_by + "&page=" + page + "&sorttype=" +
                        sort_type + "&" + filter,
                    success: function(data) {
                        $('#table_data_lib_lot').html(data);
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

            $('#btn_filter_advanced').on('click', function() {
                if (show_advance == 0) {
                    $(this).html("<i class='fa fa-filter'></i>Hide Advanced Filter");
                    $('#advance_filter').toggle(500);
                    show_advance = 1;
                } else {
                    $(this).html("<i class='fa fa-filter'></i>Show Advanced Filter");
                    $('#advance_filter').toggle(500);
                    show_advance = 0;
                }
            })




            $('#btn_save_lib_lot').on('click', function() {
                var error_count = 0;
                error_count += check_empty('sel_section');
                error_count += check_empty('sel_block');
                error_count += check_empty('lot_number_start');
                error_count += check_empty('lot_number_end');



                if (error_count > 0) {
                    swal_error('There is an empty required field.');
                } else {
                    var sel_section = $.trim($('#sel_section').val());
                    var sel_block = $.trim($('#sel_block').val());
                    var lot_number_start = $.trim($('#lot_number_start').val());
                    var lot_number_end = $.trim($('#lot_number_end').val());
                    if (lot_number_end < lot_number_start) {
                        swal_error('Please check Lot Range.');
                        return false;
                    }
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
                            show_loading('Saving Lot!');
                            $.post(baseUrl + '/lib-lot/save_lib_lot', {
                                '_token': _token,
                                'sel_block': sel_block,
                                'lot_number_start': lot_number_start,
                                'lot_number_end': lot_number_end,
                            }, function(data) {
                                hide_loading();
                                $('#modal_lib_lot').modal('hide');
                                fetch_data(page, sort_type, column_name);
                            })
                        }
                    })


                }
            })


            function add_lib_lot() {
                transaction = 'add';
                $('#modal_lib_lot_head').html('<i class="bi bi-plus-circle"></i> New Lots');
                $('#btn_save_lib_lot').html('<i class="bi bi-save"></i> Save Lots');
                $('#modal_lib_lot').modal('show');
            }

            function edit_lib_lot(id, block_id, lot_number, lot_description) {
                $('#modal_lib_lot_head').html('<i class="bi bi-pencil-circle"></i> Update Lots');
                $('#btn_save_lib_lot').html('<i class="bi bi-save"></i> Save Changes');
                transaction = 'edit';
                selected_id = id;
                $('#block_id').val(block_id);
                $('#lot_number').val(lot_number);
                $('#lot_description').val(lot_description);

                $('#modal_lib_lot').modal('show');
            }
            //STOPEDD HERE
            function delete_lib_lot(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be reverted.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        show_loading();
                        $.post(baseUrl + '/lib-lot/delete_lib_lot', {
                            '_token': _token,
                            'id': id
                        }, function(data) {
                            if (data == 'ok') {
                                notify_success('', 'LibLot removed Successfully.');
                                fetch_data(page, sort_type, column_name);
                            } else {
                                swal_error(data);
                            }
                            hide_loading();
                        })
                    }
                })
            }
        </script>
    </x-slot>

</x-app-layout>
