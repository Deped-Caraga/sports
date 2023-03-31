<div class='row'>

    <div class='col-lg-12'>
        <div id='table_detail'></div>
        Showing <span class='fw-semibold'>{{ $tbl_teams->firstItem() }}</span> to <span
            class='fw-semibold'>{{ $tbl_teams->lastItem() }}</span> of
        <span class='fw-semibold'>{{ number_format($tbl_teams->total(), 0, '', ',') }}</span> results
        <table id='table_tbl_teams' class='table table-stripped table-bordered table-hover'>
            <thead>
                <tr class="bg-info">
                    <th>#</th>
                    <th class='sorting text-center' data-sorting_type='asc' data-column_name='team_name'
                        style='cursor: pointer'>Team Name <span id='team_name_icon'></span></th>
                    @if (Auth::user()->can('Manage Users'))
                        <th style='min-width: 60px;text-align:center'><i class='bi bi-pencil text-success'></i> <i
                                class='bi bi-trash text-danger'></i></th>
                    @endif
                </tr>
            </thead>
            <tbody id='tbody_tbl_teams'>
                @php
                    $count = $tbl_teams->firstItem() - 1;
                @endphp
                @if (!empty($tbl_teams) && $tbl_teams->count())

                    @foreach ($tbl_teams as $tbl_team)
                        @php
                            $count++;
                        @endphp
                        <tr onmouseover='show_hiddens({{ $tbl_team->id }})'
                            onmouseout='hide_hiddens({{ $tbl_team->id }})'>
                            <td style='vertical-align: middle'>{{ $count }}</td>

                            <td class="fw-bold"><a target="_blank"
                                    href="{{ url('winners/team/' . $tbl_team->id) }}">{{ $tbl_team->team_name }}</a></td>

                            @if (Auth::user()->can('Manage Users'))
                                <td onclick=event.stopPropagation() style='font-size: 15px;text-align:center'>
                                    <div id='div_actions_{{ $tbl_team->id }}' style='display: none'>
                                        @if (Auth::user() || $tbl_team->created_by == Auth::user()->id)
                                            <a href='#' style=''
                                                onclick="edit_tbl_team('{{ Crypt::encrypt($tbl_team->id) }}','{{ $tbl_team->team_name }}')"
                                                class='text-success' title='Edit This Document'><i
                                                    class='bi bi-pencil'></i></a>
                                            <a href='#' style='margin: 1px'
                                                onclick="delete_tbl_team('{{ Crypt::encrypt($tbl_team->id) }}')"
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
        {!! $tbl_teams->links('pagination::bootstrap-5') !!}
    </div>
</div>
