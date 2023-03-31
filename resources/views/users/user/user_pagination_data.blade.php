<div class='row'>

    <div class='col-lg-12'>
        <div id='table_detail'></div>
        Showing <span class='fw-semibold'>{{ $users->firstItem() }}</span> to <span class='fw-semibold'>{{
            $users->lastItem() }}</span> of
        <span class='fw-semibold'>{{ number_format($users->total(), 0, '', ',') }}</span> results
        <table id='table_users' class='table table-stripped table-bordered table-hover'>
            <thead>
                <tr>
                    <th>#</th>
                    <th class='sorting text-center' data-sorting_type='asc' data-column_name='name'
                        style='cursor: pointer'>Name <span id='name_icon'></span></th>
                    <th class='sorting text-center' data-sorting_type='asc' data-column_name='email'
                        style='cursor: pointer'>Email <span id='email_icon'></span></th>
                    <th>Permissions</th>
                    <th>Update</th>
                </tr>
            </thead>
            <tbody id='tbody_users'>
                @php
                $count = $users->firstItem() - 1;
                @endphp
                @if (!empty($users) && $users->count())

                @foreach ($users as $user)
                @php
                $count++;
                @endphp
                <tr onmouseover='show_hiddens({{ $user->id }})' onmouseout='hide_hiddens({{ $user->id }})'>
                    <td style='vertical-align: middle'>{{ $count }}</td>

                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach ($user->getDirectPermissions() as $permission)
                        <span class="badge bg-info">{{ $permission->name }}</span>
                        @endforeach
                    </td>
                    <td onclick=event.stopPropagation() style='font-size: 15px;text-align:center'>
                        <div id='div_actions_{{ $user->id }}' style='display: none'>
                            @php
                            $permissions = '';
                            foreach ($user->getDirectPermissions() as $permission) {
                            if ($permissions == '') {
                            $permissions = $permission->id;
                            } else {
                            $permissions .= '||' . $permission->id;
                            }
                            }
                            @endphp
                            @if (Auth::user() || $user->created_by == Auth::user()->id)
                            <a href='#' style='' onclick="edit_permission({{ $user->id }},`{{ $permissions }}`)"
                                class=' btn btn-info btn-sm' title='Edit Permissions'>Update Permissions</a>
                            <button type="button" class="btn btn-success btn-sm"
                                onclick="edit_account({{ $user->id }}, `{{ $user->name }}`, `{{ $user->email }}`)">Update
                                Account</button>
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
        {!! $users->links('pagination::bootstrap-5') !!}
    </div>
</div>