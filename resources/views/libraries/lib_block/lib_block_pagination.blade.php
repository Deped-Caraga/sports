
    
                    <x-app-layout>
                        <x-slot name='page_title'>
                            <title>Blocks</title>
                        </x-slot>

                        <x-slot name='my_css'>
                            
                        </x-slot>

                        <x-slot name="page_breadcrumb">
                            <div class="pagetitle">
                                <h1> Blocks </h1>
                                <nav>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="url('')">Home</a></li>
                                        <li class="breadcrumb-item active">Blocks</li>
                                    </ol>
                                </nav>
                            </div><!-- End Page Title -->
                        </x-slot>


                        <div class="card">
                            <div class="card-header">
                                <form id="form_filter" name="form_filter" method="POST" action="">
                                    <div class="row">
                                        <div class="col-md-12" id="div_filters">
                                            {{-- for Advance Filter--}}
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
                                <label>Section Id</label><input type="text" class="form-control" name="search_section_id" id="search_section_id" /></div>
                            
                            <div class="col-md-3">
                                <label>Block Number</label><input type="text" class="form-control" name="search_block_number" id="search_block_number" /></div>
                            
                            <div class="col-md-3">
                                <label>Block Description</label><input type="text" class="form-control" name="search_block_description" id="search_block_description" /></div>
                            
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
                                        @if(Auth::user())
                                        <button type="button" onclick="add_lib_block()" class="btn btn-success"><i class="bi bi-plus-circle"></i> New Block</button>
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
                                <div id="table_data_lib_block">

                                </div>
                            </div>

                        </div>


                        <div class="modal fade" id="modal_lib_block" tabindex="-1" data-bs-backdrop="static" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modal_lib_block_head"></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-2">
                            <label for="section_id" id="label_section_id" class="form-label">Section Id</label><input onkeyup="color_empty_number('section_id')"  type="number" class="form-control" id="section_id" name="section_id"></div><div class="mb-2">
                            <label for="block_number" id="label_block_number" class="form-label">Block Number</label><input onkeyup="color_empty('block_number')" type="text" class="form-control" id="block_number" name="block_number"></div><div class="mb-2">
                            <label for="block_description" id="label_block_description" class="form-label">Block Description</label><input onkeyup="color_empty('block_description')" type="text" class="form-control" id="block_description" name="block_description"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class='bi bi-x'></i>Close</button>
                                        <button type="button" class="btn btn-success" id="btn_save_lib_block"></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <x-slot name="my_js">
                            <script>
                                var baseUrl = "{{url('/')}}";
                                var _token = "{{ csrf_token() }}";
                                var transaction='add';
                                var selected_id;
                                var page=1, sort_type='desc', column_name='created_at', show_advance=0;
                                var max_sub_category=0;
                                var current_page=0;

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
                                        url: "/lib-block/get_ajax_data_lib_block?sortby="  + sort_by + "&page=" + page + "&sorttype=" + sort_type + "&" + filter,
                                        success: function(data) {
                                            $('#table_data_lib_block').html(data);
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




                                $('#btn_save_lib_block').on('click',function(){
                                    var error_count=0;
                                    error_count += check_empty('section_id');
error_count += check_empty('block_number');
error_count += check_empty('block_description');

                                    if(error_count>0){
                                        swal_error('There is an empty required field.');
                                    }
                                    else{
                                        var section_id=$.trim($('#section_id').val());
var block_number=$.trim($('#block_number').val());
var block_description=$.trim($('#block_description').val());

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
                                                $('#btn_save_lib_block').prop('disabled', true);

                                                $.post(baseUrl + '/lib-block/save_lib_block',{'_token':_token,'transaction':transaction,'selected_id':selected_id,
                                                    'section_id':section_id,'block_number':block_number,'block_description':block_description,}
                                                    ,function(data){
                                                    if(data=='ok'){
                                                        if(transaction=='add'){
                                                            notify_success('', 'New LibBlock saved Successfully.');
                                                        }else{
                                                            notify_success('', 'LibBlock updated Successfully.');
                                                        }
                                                        
                                                        fetch_data(page, sort_type, column_name);
                                                        $('#modal_lib_block').modal('hide');
                                                    }else{
                                                        swal_error(data);
                                                    }
                                                    $('#btn_save_lib_block').prop('disabled', false);
                                                })
                                            }
                                        })


                                    }
                                })

                            
                                function add_lib_block(){
                                    transaction='add';
                                    $('#modal_lib_block_head').html('<i class="bi bi-plus-circle"></i> New Block');
                                    $('#btn_save_lib_block').html('<i class="bi bi-save"></i> Save Block');
                                    $('#modal_lib_block').modal('show');
                                }

                                function edit_lib_block(id,section_id,block_number,block_description){
                                    $('#modal_lib_block_head').html('<i class="bi bi-pencil-circle"></i> Update Block');
                                    $('#btn_save_lib_block').html('<i class="bi bi-save"></i> Save Changes');
                                    transaction='edit';
                                    selected_id=id;
                                    $('#section_id').val(section_id);
$('#block_number').val(block_number);
$('#block_description').val(block_description);

                                    $('#modal_lib_block').modal('show');
                                }
                                //STOPEDD HERE
                                function delete_lib_block(id){
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
                                                $.post(baseUrl + '/lib-block/delete_lib_block',{'_token':_token,'id':id},function(data){
                                                    if(data=='ok'){
                                                        notify_success('', 'LibBlock removed Successfully.');
                                                        fetch_data(page, sort_type, column_name);
                                                    }else{
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


                    