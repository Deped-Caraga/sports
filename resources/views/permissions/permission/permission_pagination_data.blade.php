<div class='row'>

    <div class='col-lg-12'>
        <div id='table_detail'></div>
        Showing <span class='fw-semibold'>{{ $permissions->firstItem() }}</span> to <span
            class='fw-semibold'>{{ $permissions->lastItem() }}</span> of
        <span class='fw-semibold'>{{ number_format($permissions->total(), 0, '', ',') }}</span> results
        <table id='table_permissions' class='table table-stripped table-bordered table-hover'>
            <thead>
                <tr>
                    <th>#</th>
                    <th class='sorting text-center' data-sorting_type='asc' data-column_name='name'
                        style='cursor: pointer'>Name <span id='name_icon'></span></th>
                    <th class='sorting text-center' data-sorting_type='asc' data-column_name='guard_name'
                        style='cursor: pointer'>Guard Name <span id='guard_name_icon'></span></th>

                    <th style='min-width: 60px;text-align:center'><i class='bi bi-pencil text-success'></i> <i
                            class='bi bi-trash text-danger'></i></th>
                </tr>
            </thead>
            <tbody id='tbody_permissions'>
                @php
                    $count = $permissions->firstItem() - 1;
                @endphp
                @if (!empty($permissions) && $permissions->count())

                    @foreach ($permissions as $permission)
                        @php
                            $count++;
                        @endphp
                        <tr onmouseover='show_hiddens({{ $permission->id }})'
                            onmouseout='hide_hiddens({{ $permission->id }})'>
                            <td style='vertical-align: middle'>{{ $count }}</td>

                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->guard_name }}</td>

                            <td onclick=event.stopPropagation() style='font-size: 15px;text-align:center'>
                                <div id='div_actions_{{ $permission->id }}' style='display: none'>
                                    @if (Auth::user() || $permission->created_by == Auth::user()->id)
                                        <a href='#' style=''
                                            onclick="edit_permission('{{ Crypt::encrypt($permission->id) }}','{{ $permission->name }}','{{ $permission->guard_name }}')"
                                            class='text-success' title='Edit This Document'><i
                                                class='bi bi-pencil'></i></a>
                                        <a href='#' style='margin: 1px'
                                            onclick="delete_permission('{{ Crypt::encrypt($permission->id) }}')"
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
        {!! $permissions->links('pagination::bootstrap-5') !!}
    </div>
</div>
