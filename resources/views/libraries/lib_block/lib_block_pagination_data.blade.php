
    
                        <div class='row'>

                        <div class='col-lg-12'>
                            <div id='table_detail'></div>
                                Showing <span class='fw-semibold'>{{$lib_blocks->firstItem()}}</span> to <span class='fw-semibold'>{{$lib_blocks->lastItem()}}</span> of
                                <span class='fw-semibold'>{{number_format($lib_blocks->total(), 0,'', ',')}}</span> results
                                <table id='table_lib_blocks' class='table table-stripped table-bordered table-hover' >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class='sorting text-center' data-sorting_type='asc' data-column_name='section_id'
                            style='cursor: pointer'>Section Id <span id='section_id_icon'></span></th><th class='sorting text-center' data-sorting_type='asc' data-column_name='block_number'
                            style='cursor: pointer'>Block Number <span id='block_number_icon'></span></th><th class='sorting text-center' data-sorting_type='asc' data-column_name='block_description'
                            style='cursor: pointer'>Block Description <span id='block_description_icon'></span></th>
                                            
                                            <th style='min-width: 60px;text-align:center'><i class='bi bi-pencil text-success'></i> <i class='bi bi-trash text-danger'></i></th>
                                        </tr>
                                    </thead>
                                    <tbody id='tbody_lib_blocks'>
                                        @php
                                        $count=$lib_blocks->firstItem() - 1;
                                        @endphp
                                        @if(!empty($lib_blocks) && $lib_blocks->count())
                        
                                        @foreach($lib_blocks as $lib_block)
                                        @php
                                        $count++;
                                        @endphp
                                        <tr onmouseover='show_hiddens({{$lib_block->id}})' onmouseout='hide_hiddens({{$lib_block->id}})'>
                                            <td style='vertical-align: middle'>{{$count}}</td>
                        
                                            <td>{{$lib_block->section_id }}</td><td>{{$lib_block->block_number }}</td><td>{{$lib_block->block_description }}</td>
                                            
                                            <td onclick=event.stopPropagation() style='font-size: 15px;text-align:center'>
                                                <div id='div_actions_{{$lib_block->id}}' style='display: none'>
                                                    @if(Auth::user() || $lib_block->created_by == Auth::user()->id)
                                                    <a href='#' style=''
                                                    onclick="edit_lib_block('{{Crypt::encrypt($lib_block->id)}}','{{$lib_block->section_id}}','{{$lib_block->block_number}}','{{$lib_block->block_description}}')"
                                                        class='text-success' title='Edit This Document'><i class='bi bi-pencil'></i></a>
                                                    <a href='#' style='margin: 1px' onclick="delete_lib_block('{{Crypt::encrypt($lib_block->id)}}')"
                                                        class='text-danger' title='Delete This Document'> <i class='bi bi-trash'></i></a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan='4'>No data found.</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-lg-12'>
                                {!! $lib_blocks->links('pagination::bootstrap-5') !!}
                            </div>
                        </div>

                    