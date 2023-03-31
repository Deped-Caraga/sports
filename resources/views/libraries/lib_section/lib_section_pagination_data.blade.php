
    
                        <div class='row'>

                        <div class='col-lg-12'>
                            <div id='table_detail'></div>
                                Showing <span class='fw-semibold'>{{$lib_sections->firstItem()}}</span> to <span class='fw-semibold'>{{$lib_sections->lastItem()}}</span> of
                                <span class='fw-semibold'>{{number_format($lib_sections->total(), 0,'', ',')}}</span> results
                                <table id='table_lib_sections' class='table table-stripped table-bordered table-hover' >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class='sorting text-center' data-sorting_type='asc' data-column_name='section_number'
                            style='cursor: pointer'>Section Number <span id='section_number_icon'></span></th><th class='sorting text-center' data-sorting_type='asc' data-column_name='description'
                            style='cursor: pointer'>Description <span id='description_icon'></span></th>
                                            
                                            <th style='min-width: 60px;text-align:center'><i class='bi bi-pencil text-success'></i> <i class='bi bi-trash text-danger'></i></th>
                                        </tr>
                                    </thead>
                                    <tbody id='tbody_lib_sections'>
                                        @php
                                        $count=$lib_sections->firstItem() - 1;
                                        @endphp
                                        @if(!empty($lib_sections) && $lib_sections->count())
                        
                                        @foreach($lib_sections as $lib_section)
                                        @php
                                        $count++;
                                        @endphp
                                        <tr onmouseover='show_hiddens({{$lib_section->id}})' onmouseout='hide_hiddens({{$lib_section->id}})'>
                                            <td style='vertical-align: middle'>{{$count}}</td>
                        
                                            <td>{{$lib_section->section_number }}</td><td>{{$lib_section->description }}</td>
                                            
                                            <td onclick=event.stopPropagation() style='font-size: 15px;text-align:center'>
                                                <div id='div_actions_{{$lib_section->id}}' style='display: none'>
                                                    @if(Auth::user() || $lib_section->created_by == Auth::user()->id)
                                                    <a href='#' style=''
                                                    onclick="edit_lib_section('{{Crypt::encrypt($lib_section->id)}}','{{$lib_section->section_number}}','{{$lib_section->description}}')"
                                                        class='text-success' title='Edit This Document'><i class='bi bi-pencil'></i></a>
                                                    <a href='#' style='margin: 1px' onclick="delete_lib_section('{{Crypt::encrypt($lib_section->id)}}')"
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
                                {!! $lib_sections->links('pagination::bootstrap-5') !!}
                            </div>
                        </div>

                    