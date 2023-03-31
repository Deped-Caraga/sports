<div class='row'>

    <div class='col-lg-12'>
        <div id='table_detail'></div>
        Showing <span class='fw-semibold'>{{ $tbl_events->firstItem() }}</span> to <span
            class='fw-semibold'>{{ $tbl_events->lastItem() }}</span> of
        <span class='fw-semibold'>{{ number_format($tbl_events->total(), 0, '', ',') }}</span> results
        <table id='table_tbl_events' class='table table-hover border-primary'>
            <thead>
                <tr class='bg-info'>
                    <th>#</th>
                    <th>Image</th>
                    <th class='sorting text-center' data-sorting_type='asc' data-column_name='event_name'
                        style='cursor: pointer'>Event Name <span id='event_name_icon'></span></th>
                    <th class='sorting text-center' data-sorting_type='asc' data-column_name='event_type'
                        style='cursor: pointer'>Event Type <span id='event_type_icon'></span></th>
                    <th class='sorting text-center' data-sorting_type='asc' data-column_name='sub_categories_count'
                        style='cursor: pointer'>Medal Count <span id='sub_categories_count_icon'></span></th>
                    <th class='sorting text-center' data-sorting_type='asc' data-column_name='validated_count'
                        style='cursor: pointer'>Scored<span id='validated_count_icon'></span></th>
                    <th class='sorting text-center' data-sorting_type='asc' data-column_name='validated_percentage'
                        style='cursor: pointer'>Percentage<span id='validated_percentage_icon'></span></th>
                    @if (Auth::user()->can('Manage Users'))
                        <th style='min-width: 60px;text-align:center'><i class='bi bi-pencil text-success'></i> <i
                                class='bi bi-trash text-danger'></i></th>
                    @endif
                </tr>
            </thead>
            <tbody id='tbody_tbl_events'>
                @php
                    $count = $tbl_events->firstItem() - 1;
                @endphp
                @if (!empty($tbl_events) && $tbl_events->count())

                    @foreach ($tbl_events as $tbl_event)
                        @php
                            $count++;
                        @endphp
                        <tr onmouseover='show_hiddens({{ $tbl_event->id }})'
                            onmouseout='hide_hiddens({{ $tbl_event->id }})'>
                            <td style='vertical-align: middle'>{{ $count }}</td>
                            <td>
                                {{-- display the event image here. The image were uploading using  $event_picture->storeAs('public/event_picture', $model->id . '.' . $event_picture->getClientOriginalExtension()); --}}
                                {{-- check if event_picture is not null --}}
                                @if ($tbl_event->event_picture != null)
                                    <img src="{{ asset('storage/event_picture/' . $tbl_event->event_picture) }}"
                                        alt="{{ $tbl_event->event_name }}" width="50" height="50">
                                @else
                                    <img src="{{ asset('storage/event_picture/empty.jpg') }}"
                                        alt="{{ $tbl_event->event_name }}" width="50" height="50">
                                @endif

                            </td>
                            <td style="vertical-align: middle"><a class="text-primary fw-bold"
                                    href="{{ url('event/view/' . $tbl_event->id) }}">{{ strtoupper($tbl_event->event_name) }}</a>
                            </td>
                            <td style="vertical-align: middle">
                                @if ($tbl_event->event_type == '1')
                                    <span class='badge bg-success'>Regular Sports</span>
                                @elseif ($tbl_event->event_type == '2')
                                    <span class='badge bg-info'>Special</span>
                                @else
                                    <span class='badge bg-warning'>Demo</span>
                                @endif
                            </td>
                            <td style="vertical-align: middle">
                                <span class='badge bg-info'>
                                    {{ $tbl_event->sub_categories_count }}</span>
                            </td>
                            <td style="vertical-align: middle">
                                <span class='badge bg-info'>
                                    {{ $tbl_event->validated_count }}</span>
                            </td>
                            <td style="vertical-align: middle">
                                {{-- add bootstrap5 progress with label Striped Animated Backgrounds --}}
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped 
                                    @if ($tbl_event->validated_percentage == 100) bg-success
                                    @elseif($tbl_event->validated_percentage >= 50)
                                        bg-info
                                    @else 
                                        bg-danger @endif
                                    "
                                        role="progressbar" style="width: {{ $tbl_event->validated_percentage }}%"
                                        aria-valuenow="{{ $tbl_event->validated_percentage }}" aria-valuemin="0"
                                        aria-valuemax="100">{{ $tbl_event->validated_percentage }}%
                                    </div>
                            </td>
                            @if (Auth::user()->can('Manage Users'))
                                <td onclick=event.stopPropagation()
                                    style='font-size: 15px;text-align:center;vertical-align: middle'>
                                    <div id='div_actions_{{ $tbl_event->id }}' style='display: none'>
                                        @if (Auth::user() || $tbl_event->created_by == Auth::user()->id)
                                            <a href='#' style=''
                                                onclick="edit_tbl_event('{{ Crypt::encrypt($tbl_event->id) }}','{{ $tbl_event->event_name }}','{{ $tbl_event->event_type }}')"
                                                class='text-success' title='Edit This Document'><i
                                                    class='bi bi-pencil'></i></a>
                                            <a href='#' style='margin: 1px'
                                                onclick="delete_tbl_event('{{ Crypt::encrypt($tbl_event->id) }}')"
                                                class='text-danger' title='Delete This Document'> <i
                                                    class='bi bi-trash'></i></a>
                                        @endif
                                    </div>
                                </td>
                            @endif
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
        {!! $tbl_events->links('pagination::bootstrap-5') !!}
    </div>
</div>
