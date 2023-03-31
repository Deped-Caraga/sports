<div class='row'>

    <div class='col-lg-12'>
        <div id='table_detail'></div>
        Showing <span class='fw-semibold'>{{ $lib_lots->firstItem() }}</span> to <span
            class='fw-semibold'>{{ $lib_lots->lastItem() }}</span> of
        <span class='fw-semibold'>{{ number_format($lib_lots->total(), 0, '', ',') }}</span> results
        <table id='table_lib_lots' class='table table-stripped table-bordered table-hover'>
            <thead>
                <tr>
                    <th>#</th>
                    <th class='sorting text-center' data-sorting_type='asc' data-column_name='description'
                        style='cursor: pointer'>Section<span id='description_icon'></span></th>
                    <th class='sorting text-center' data-sorting_type='asc' data-column_name='block_description'
                        style='cursor: pointer'>Block<span id='block_description_icon'></span></th>
                    <th class='sorting text-center' data-sorting_type='asc' data-column_name='lot_number'
                        style='cursor: pointer'>Lot Number <span id='lot_number_icon'></span></th>
                    <th class='sorting text-center' data-sorting_type='asc' data-column_name='client_name'
                        style='cursor: pointer'>Client Name <span id='client_name_icon'></span></th>
                    <th class='sorting text-center' data-sorting_type='asc' data-column_name='balance'
                        style='cursor: pointer'>Balance <span id='balance_icon'></span></th>
                    <th class='sorting text-center' data-sorting_type='asc' data-column_name='due_date'
                        style='cursor: pointer'>Due Date<span id='due_date_icon'></span></th>
                    <th style='min-width: 60px;text-align:center'><i class='bi bi-pencil text-success'></i> <i
                            class='bi bi-trash text-danger'></i></th>
                </tr>
            </thead>
            <tbody id='tbody_lib_lots'>
                @php
                    $count = $lib_lots->firstItem() - 1;
                @endphp
                @if (!empty($lib_lots) && $lib_lots->count())

                    @foreach ($lib_lots as $lib_lot)
                        @php
                            $count++;
                        @endphp
                        <tr onmouseover='show_hiddens({{ $lib_lot->id }})'
                            onmouseout='hide_hiddens({{ $lib_lot->id }})'>
                            <td style='vertical-align: middle'>{{ $count }}</td>

                            <td>{{ $lib_lot->description }}</td>
                            <td>{{ $lib_lot->block_description }}</td>
                            <td>{{ $lib_lot->lot_number }}</td>
                            <td>{{ $lib_lot->client_name }}</td>
                            <td>{{ number_format($lib_lot->balance, 2) }}</td>
                            <td class='{{ $lib_lot->due_date > date('Y-m-d') ? '' : 'text-danger' }}'>
                                {{ $lib_lot->due_date }}</td>

                            <td onclick=event.stopPropagation() style='font-size: 15px;text-align:center'>
                                <div id='div_actions_{{ $lib_lot->id }}' style='display: none'>
                                    @if (Auth::user() || $lib_lot->created_by == Auth::user()->id)
                                        <a href='#' style=''
                                            onclick="edit_lib_lot('{{ Crypt::encrypt($lib_lot->id) }}','{{ $lib_lot->block_id }}','{{ $lib_lot->lot_number }}','{{ $lib_lot->lot_description }}')"
                                            class='text-success' title='Edit This Document'><i
                                                class='bi bi-pencil'></i></a>
                                        <a href='#' style='margin: 1px'
                                            onclick="delete_lib_lot('{{ Crypt::encrypt($lib_lot->id) }}')"
                                            class='text-danger' title='Delete This Document'> <i
                                                class='bi bi-trash'></i></a>
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
        {!! $lib_lots->links('pagination::bootstrap-5') !!}
    </div>
</div>
