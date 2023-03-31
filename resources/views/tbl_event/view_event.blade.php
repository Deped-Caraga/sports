<x-app-layout>
    <x-slot name='page_title'>
        <title>Events</title>
    </x-slot>

    <x-slot name='my_css'>
        <style>
            .btn-custom-sm {
                font-size: 0.7rem;
                padding: 0.2rem 0.4rem;
                transform-origin: top left;
            }

            .btn-custom-sm2 {
                font-size: 0.5rem;
                padding: 0.2rem 0.4rem;
                transform-origin: top left;
            }
        </style>
    </x-slot>

    <x-slot name="page_breadcrumb">
        <div class="pagetitle">
            <h1> {{ $event->event_name }} </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="url('/')">Home</a></li>
                    <li class="breadcrumb-item active">{{ $event->event_name }}</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
    </x-slot>


    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Event Categories
                <a href="{{ url('/print/event/' . $event->id) }}" target="_blank" class="btn btn-success btn-sm"
                    data-bs-toggle="tooltip" title="Print result for {{ $event->event_name }}"><i
                        class="bi bi-printer-fill"></i></a>
                @if (Auth::user()->can('Manage Users'))
                    <button onclick="add_event_category()" class="btn btn-success"><i class="bi bi-plus-circle"></i>
                        Add Category</button>
                @endif
            </h3>
        </div>

        <div class="card-body" style="overflow-x: auto">
            @if ($event->eventCategories->count() > 0)
                <table class="table table-bordered">
                    <th>Level</th>
                    <th>Category</th>
                    <th># Events</th>
                    <th>Validated</th>
                    <th>Percentage</th>
                    @if (Auth::user()->can('Manage Users'))
                        <th>Action</th>
                    @endif
                    @foreach ($event->eventCategories as $category)
                        @php
                            $total_validated = $category->eventSubCategories->whereNotNull('validated_by')->count();
                        @endphp
                        <tr>
                            <td><a href="#div_event_{{ $category->id }}">{{ $category->category_level }}</a></td>
                            <td>{{ $category->category_sex }}</td>
                            <td>
                                {{ $category->eventSubCategories->count() }}
                            </td>
                            <td>
                                {{ $total_validated }}
                            </td>
                            <td>
                                {{-- Get the percentage of validated --}}
                                @php
                                    $percentage = 0;
                                    if ($category->eventSubCategories->count() > 0) {
                                        $percentage = ($total_validated / $category->eventSubCategories->count()) * 100;
                                    }
                                    $for_class = '';
                                    if ($percentage == 100) {
                                        $for_class = 'text-success';
                                    } elseif ($percentage >= 50) {
                                        $for_class = 'text-info';
                                    } elseif ($percentage >= 20) {
                                        $for_class = 'text-warning';
                                    } else {
                                        $for_class = 'text-danger';
                                    }
                                @endphp
                                <span class="{{ $for_class }}">{{ number_format($percentage, 2) }}%</span>
                            </td>
                            @if (Auth::user()->can('Manage Users'))
                                <td>
                                    <button
                                        onclick="edit_event_category({{ $category->id }}, `{{ $category->category_level }}`, `{{ $category->category_sex }}`)"
                                        class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i></button>
                                    <button onclick="delete_event_category({{ $category->id }})"
                                        class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            @else
                <div class="alert alert-warning">
                    <h4>No Categories Found</h4>
            @endif
        </div>
    </div>


    @if ($event->eventCategories->count() > 0)
        @foreach ($event->eventCategories as $category)
            <div class="card" id="div_event_{{ $category->id }}">
                <div class="card-header">
                    <h3 class="card-title">{{ $event->event_name }} [{{ $category->category_level }} -
                        {{ $category->category_sex }}]
                        <a href="{{ url('/print/category/' . $category->id) }}" target="_blank"
                            class="btn btn-success btn-sm" data-bs-toggle="tooltip"
                            title="Print result for {{ $event->event_name . ' - ' . $category->category_level . ' - ' . $category->category_sex }}"><i
                                class="bi bi-printer-fill"></i></a>
                        @if (Auth::user()->can('Manage Users'))
                            <button onclick="add_sub_category({{ $category->id }})" class="btn btn-mini btn-success"><i
                                    class="bi bi-plus-circle"></i> Add Sub
                                Category</button>
                        @endif
                    </h3>

                </div>
                <div class="card-body">
                    @if ($category->eventSubCategories->count() > 0)
                        <table class="table table-bordered">
                            <tr>
                                @if (Auth::user()->can('Manage Users'))
                                    <th style="width: 80px !important"></th>
                                @endif
                                <th>Category</th>
                                <th>Gold</th>
                                <th>Silver</th>
                                <th>Bronze</th>
                                <th>Validated</th>
                            </tr>
                            @foreach ($category->eventSubCategories as $sub_category)
                                <tr>
                                    @if (Auth::user()->can('Manage Users'))
                                        <td style="vertical-align: middle">
                                            <button
                                                onclick="edit_event_sub_category({{ $sub_category->id }}, `{{ $sub_category->category_id }}`, `{{ $sub_category->sub_category }}`)"
                                                class="btn btn-primary btn-sm btn-custom-sm"><i
                                                    class="bi bi-pencil"></i></button>
                                            <button onclick="delete_event_sub_category({{ $sub_category->id }})"
                                                class="btn btn-danger btn-sm btn-custom-sm"><i
                                                    class="bi bi-trash"></i></button>
                                        </td>
                                    @endif
                                    <td style="vertical-align: middle">
                                        {{ strtoupper($sub_category->sub_category) }}
                                        @if ($sub_category->validated_by != null)
                                            <span class="text-success"><i class="bi bi-check-circle-fill"></i></span>
                                        @else
                                            <span class="text-danger"><i class="bi bi-x-circle-fill"></i></span>
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle">
                                        @if ($sub_category->golds->count() > 0)
                                            @php
                                                $scored_by_user = false;
                                                $last_edit_by = '';
                                                $last_edit_at = '';
                                            @endphp
                                            @foreach ($sub_category->golds as $gold)
                                                @php
                                                    $last_edit_by = $gold->encodedBy->name;
                                                    $last_edit_at = (new \DateTime($gold->encoded_at))->format('F d, Y g:iA');
                                                @endphp
                                                @if ($gold->encoded_by == Auth::user()->id)
                                                    @php
                                                        $scored_by_user = true;
                                                        
                                                    @endphp
                                                @endif
                                                <span class="badge bg-success">{{ $gold->team->team_name }}</span>
                                                @foreach ($gold->goldWinners as $winner)
                                                    <span title="Athlete"
                                                        class="badge bg-primary">{{ $winner->name }}</span>
                                                @endforeach
                                                @foreach ($gold->goldCoaches as $coach)
                                                    <span title="Coach"
                                                        class="badge bg-info">{{ $coach->coach_name }}</span>
                                                @endforeach
                                            @endforeach

                                            @if (
                                                (Auth::user()->can('Manage Users') || $scored_by_user || Auth::user()->can('Validate Score')) &&
                                                    $sub_category->validated_by == null)
                                                <button title="Edit"
                                                    onclick="edit_score('1',{{ $sub_category->id }})"
                                                    class="btn btn-warning btn-sm btn-custom-sm"><i
                                                        class="bi bi-pencil-fill"></i></button>
                                            @endif
                                            <div style="font-size:12px">{{ ucwords($last_edit_by) }}
                                                {{ $last_edit_at }}</div>
                                        @else
                                            @if (Auth::user()->can('Add Score') && $sub_category->validated_by == null)
                                                <button onclick="add_score('1',{{ $sub_category->id }})"
                                                    class="btn btn-warning btn-sm"><i class="bi bi-plus-circle"></i>
                                                    Add Score</button>
                                            @else
                                                @if ($sub_category == null)
                                                    <span class="text-danger"><i class="bi bi-x-circle-fill">
                                                        </i>Waiting Results</span>
                                                @else
                                                    {{-- Not Applicable --}}
                                                    <span class="text-success"><i class="bi bi-check-circle">
                                                        </i>No Winner</span>
                                                @endif
                                            @endif
                                        @endif
                                    </td>

                                    <td style="vertical-align: middle">
                                        @if ($sub_category->silvers->count() > 0)
                                            @php
                                                $scored_by_user = false;
                                                $last_edit_by = '';
                                                $last_edit_at = '';
                                            @endphp
                                            @foreach ($sub_category->silvers as $silver)
                                                @php
                                                    $last_edit_by = $silver->encodedBy->name;
                                                    $last_edit_at = (new \DateTime($silver->encoded_at))->format('F d, Y g:iA');
                                                @endphp
                                                @if ($silver->encoded_by == Auth::user()->id)
                                                    @php
                                                        $scored_by_user = true;
                                                        
                                                    @endphp
                                                @endif
                                                <span class="badge bg-success">{{ $silver->team->team_name }}</span>
                                                @foreach ($silver->silverWinners as $winner)
                                                    <span title="Athlete"
                                                        class="badge bg-primary">{{ $winner->name }}</span>
                                                @endforeach
                                                @foreach ($silver->silverCoaches as $coach)
                                                    <span title="Coach"
                                                        class="badge bg-info">{{ $coach->coach_name }}</span>
                                                @endforeach
                                            @endforeach

                                            @if (
                                                (Auth::user()->can('Manage Users') || $scored_by_user || Auth::user()->can('Validate Score')) &&
                                                    $sub_category->validated_by == null)
                                                <button title="Edit"
                                                    onclick="edit_score('2',{{ $sub_category->id }})"
                                                    class="btn btn-warning btn-sm btn-custom-sm"><i
                                                        class="bi bi-pencil-fill"></i></button>
                                            @endif
                                            <div style="font-size:12px">{{ ucwords($last_edit_by) }}
                                                {{ $last_edit_at }}</div>
                                        @else
                                            @if (Auth::user()->can('Add Score') && $sub_category->validated_by == null)
                                                <button onclick="add_score('2',{{ $sub_category->id }})"
                                                    class="btn btn-warning btn-sm"><i class="bi bi-plus-circle"></i>
                                                    Add Score</button>
                                            @else
                                                @if ($sub_category == null)
                                                    <span class="text-danger"><i class="bi bi-x-circle-fill">
                                                        </i>Waiting Results</span>
                                                @else
                                                    {{-- Not Applicable --}}
                                                    <span class="text-success"><i class="bi bi-check-circle">
                                                        </i>No Winner</span>
                                                @endif
                                            @endif
                                        @endif
                                    </td>

                                    {{-- ADD td for the bronze --}}
                                    <td style="vertical-align: middle">
                                        @if ($sub_category->bronzes->count() > 0)
                                            @php
                                                $scored_by_user = false;
                                                $last_edit_by = '';
                                                $last_edit_at = '';
                                            @endphp
                                            @foreach ($sub_category->bronzes as $bronze)
                                                @php
                                                    $last_edit_by = $bronze->encodedBy->name;
                                                    $last_edit_at = (new \DateTime($bronze->encoded_at))->format('F d, Y g:iA');
                                                @endphp
                                                @if ($bronze->encoded_by == Auth::user()->id)
                                                    @php
                                                        $scored_by_user = true;
                                                        
                                                    @endphp
                                                @endif
                                                <span class="badge bg-success">{{ $bronze->team->team_name }}</span>
                                                @foreach ($bronze->bronzeWinners as $winner)
                                                    <span title='Athlete'
                                                        class="badge bg-primary">{{ $winner->name }}</span>
                                                @endforeach
                                                @foreach ($bronze->bronzeCoaches as $coach)
                                                    <span title='Coach'
                                                        class="badge bg-info">{{ $coach->coach_name }}</span>
                                                @endforeach
                                            @endforeach

                                            @if (
                                                (Auth::user()->can('Manage Users') || $scored_by_user || Auth::user()->can('Validate Score')) &&
                                                    $sub_category->validated_by == null)
                                                <button title="Edit"
                                                    onclick="edit_score('3',{{ $sub_category->id }})"
                                                    class="btn btn-warning btn-sm btn-custom-sm"><i
                                                        class="bi bi-pencil-fill"></i></button>
                                            @endif
                                            <div style="font-size:12px">{{ ucwords($last_edit_by) }}
                                                {{ $last_edit_at }}</div>
                                        @else
                                            @if (Auth::user()->can('Add Score') && $sub_category->validated_by == null)
                                                <button onclick="add_score('3',{{ $sub_category->id }})"
                                                    class="btn btn-warning btn-sm"><i class="bi bi-plus-circle"></i>
                                                    Add Score</button>
                                            @else
                                                @if ($sub_category == null)
                                                    <span class="text-danger"><i class="bi bi-x-circle-fill">
                                                        </i>Waiting Results</span>
                                                @else
                                                    {{-- Not Applicable --}}
                                                    <span class="text-success"><i class="bi bi-check-circle">
                                                        </i>No Winner</span>
                                                @endif
                                            @endif
                                        @endif
                                    </td>

                                    <td style="vertical-align: middle">
                                        @if ($sub_category->validated_by)
                                            <span class="text-success">
                                                {{-- add a success button with tooltip --}}


                                                <a href="{{ url('/print/sub/' . $sub_category->id) }}"
                                                    target="_blank" class="btn btn-success btn-sm"
                                                    data-bs-toggle="tooltip"
                                                    title="Print result for {{ $event->event_name }} [{{ $category->category_level }} -
                                                    {{ $category->category_sex }}] - {{ $sub_category->sub_category }} "><i
                                                        class="bi bi-printer-fill"></i></a>
                                                <a href="{{ url('/print/certificate/' . $sub_category->id) }}"
                                                    target="_blank" class="btn btn-success btn-sm"
                                                    data-bs-toggle="tooltip"
                                                    title="Print athletes' and coaches certificates for {{ $event->event_name }} [{{ $category->category_level }} -
                                                    {{ $category->category_sex }}] - {{ $sub_category->sub_category }} ">
                                                    {{-- add bi icon  --}}
                                                    <i class="bi bi-people-fill"></i>
                                                </a>
                                                Validated</span>
                                            @if (Auth::user()->can('Manage Users'))
                                                <button title="Invalidate"
                                                    onclick="invalidate_score({{ $sub_category->id }})"
                                                    class="btn btn-warning btn-sm"><i class="bi bi-reply-fill"></i>
                                                </button>
                                            @endif
                                            <div style="font-size:12px">
                                                {{ ucwords($sub_category->validatedBy->name) }},
                                                {{ (new \DateTime($sub_category->validated_at))->format('F d, Y g:iA') }}
                                            </div>
                                        @else
                                            {{-- check if there is score in gold, silver or bronze --}}
                                            @if ($sub_category->golds->count() > 0 || $sub_category->silvers->count() > 0 || $sub_category->bronzes->count() > 0)
                                                @if (Auth::user()->can('Validate Score'))
                                                    <button onclick="validate_score({{ $sub_category->id }})"
                                                        class="btn btn-warning btn-sm"><i
                                                            class="bi bi-check-circle"></i>
                                                        Validate</button>
                                                @else
                                                    <span class="text-danger"><i class="bi bi-x-circle-fill"></i> For
                                                        Validation</span>
                                                @endif
                                            @else
                                                <span class="text-danger"><i class="bi bi-x-circle-fill"></i> Not
                                                    Scored
                                                    Yet</span>
                                            @endif
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </table>
                    @else
                        <div class="alert alert-warning">
                            <h4>No events found.</h4>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    @endif


    <div class="modal fade" id="modal_category" tabindex="-1" data-bs-backdrop="static" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_category_head"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="event_level" id="label_event_level" class="form-label">Level</label><select
                            class="form-control" id="event_level" name="event_level">
                            <option value="">---Select---</option>
                            <option value="Elementary">Elementary</option>
                            <option value="Secondary">Secondary</option>
                            <option value="Mixed">Mixed</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="event_sex" id="label_event_sex" class="form-label">Sex</label><select
                            class="form-control" id="event_sex" name="event_sex">
                            <option value="">---Select---</option>
                            <option value="Boys">Boys</option>
                            <option value="Girls">Girls</option>
                            <option value="Mixed">Mixed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class='bi bi-x'></i>Close</button>
                    <button type="button" class="btn btn-success" id="btn_save_event_category"></button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_sub_category" tabindex="-1" data-bs-backdrop="static" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_sub_category_head"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="event_level" id="label_event_level" class="form-label">Sub Category</label>
                        <input type="text" class="form-control" id="text_sub_category" name="text_sub_category">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class='bi bi-x'></i>Close</button>
                    <button type="button" class="btn btn-success" id="btn_save_event_sub_category"></button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal_score" tabindex="-1" data-bs-backdrop="static" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_score_head"> </h5>
                    <div style="margin-left: 5px">
                        @if (Auth::user()->can('Manage Users'))
                            <button type="button" class="btn btn-primary btn-sm" onclick="duplicateRowScore()">
                                <i class="bi bi-plus"></i></button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeLastRowScore()">
                                <i class="bi bi-dash"></i></button>
                            </button>
                        @endif
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body" id="modal_body_score">
                    {{-- Initial row_score div --}}
                    <div class="row row_score">
                        <div class="mb-2">
                            <label for="event_level" id="label_score_winner" class="form-label">Gold Winner</label>
                            <select class="form-control" id="team_name" name="team_name[]">
                                <option value="">--Select Team---</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                                @endforeach
                            </select>
                            <label class="mt-2">Athletes' Name/s (One Name Per Line)</label>
                            <textarea id="players_name" name="players_name[]" class="form-control" rows="5"></textarea>

                            <label class="mt-2">Coaches' Name/s (One Name Per Line)</label>
                            <textarea id="coaches_name" name="coaches_name[]" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btn_delete_score" onclick="delete_score()" style="display: none"
                        class="btn btn-danger"><i class="bi bi-trash"></i> Delete
                        Score</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class='bi bi-x'></i>Close</button>
                    <button type="button" class="btn btn-success" id="btn_save_score"></button>
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
            var event_id = "{{ $event->id }}";
            var selected_category_id;
            var current_medal_number;
            var current_sub_category_id;
            let rowCount = 1;


            function add_event_category() {
                transaction = 'add';
                $('#modal_category_head').html('Add Event Category');
                $('#btn_save_event_category').html("<i class='bi bi-plus-circle'></i> Save New Event Category");
                $('#modal_category').modal('show');
            }

            function add_event_category() {
                transaction = 'add';
                $('#modal_category_head').html('Add Event Category');
                $('#btn_save_event_category').html("<i class='bi bi-plus-circle'></i> Save New Event Category");
                $('#modal_category').modal('show');
            }

            function add_score(medal_number, sub_category_id) {
                $('.row_score').not(':first').remove();
                transaction = 'add';
                rowCount = 1;
                current_sub_category_id = sub_category_id;
                current_medal_number = medal_number;
                if (medal_number == 1) {
                    $('#label_score_winner').html('Gold Winner');
                } else if (medal_number == 2) {
                    $('#label_score_winner').html('Silver Winner');
                } else if (medal_number == 3) {
                    $('#label_score_winner').html('Bronze Winner');
                }
                $('#modal_score_head').html('Add Score');
                $('#btn_save_score').html("<i class='bi bi-plus-circle'></i> Save Score");
                $('#modal_score').modal('show');
            }

            $('#btn_save_score').on('click', function() {
                var teamNames = document.querySelectorAll("#team_name");
                var playersNames = document.querySelectorAll("#players_name");
                var coachesNames = document.querySelectorAll("#coaches_name");
                var error_count = 0;

                for (var i = 0; i < teamNames.length; i++) {
                    teamNames[i].classList.remove("error_input");
                    playersNames[i].classList.remove("error_input");
                    if (teamNames[i].value === "") {
                        error_count++;
                        teamNames[i].classList.add("error_input");
                    }
                    if (playersNames[i].value === "") {
                        error_count++;
                        playersNames[i].classList.add("error_input");
                    }
                    if (coachesNames[i].value === "") {
                        error_count++;
                        coachesNames[i].classList.add("error_input");
                    }
                }

                if (error_count > 0) {
                    swal_error("Please fill up all fields");
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
                            show_loading('Saving to database.');
                            var team_name = [];
                            var players_name = [];
                            var coaches_name = [];
                            for (var i = 0; i < teamNames.length; i++) {
                                team_name.push(teamNames[i].value);
                                players_name.push(playersNames[i].value);
                                coaches_name.push(coachesNames[i].value);
                            }
                            $.ajax({
                                url: baseUrl + "/event/save_score",
                                type: "POST",
                                data: {
                                    _token: _token,
                                    medal_number: current_medal_number,
                                    sub_category_id: current_sub_category_id,
                                    team_name: team_name,
                                    players_name: players_name,
                                    coaches_name: coaches_name,
                                    transaction: transaction,
                                },
                                success: function(data) {
                                    if (data == "ok") {
                                        swal_success("Score Saved Successfully.");
                                        location.reload();
                                    } else {
                                        swal_error(data);
                                    }
                                },
                                error: function(data) {
                                    swal_error(data);
                                }
                            });
                        }
                    })


                }
            });


            function delete_score() {
                //swal.fire then confirm delete Score
                Swal.fire({
                    title: 'Are you sure to delete score?',
                    text: "This action cannot be reverted.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        show_loading();
                        $.post(baseUrl + '/event/delete_score', {
                            '_token': _token,
                            'current_sub_category_id': current_sub_category_id,
                            'current_medal_number': current_medal_number,
                        }, function(data) {
                            if (data == 'ok') {
                                notify_success('', 'Score removed successfully.');
                                location.reload();
                            } else {
                                swal_error(data);
                            }
                            hide_loading;
                        })
                    }
                })

            }

            function edit_score(medal_number, sub_category_id) {
                current_sub_category_id = sub_category_id;
                transaction = 'edit';
                current_medal_number = medal_number;
                //get the scores from database
                $('#btn_delete_score').show();
                $.ajax({
                    url: baseUrl + "/event/get_score",
                    type: "POST",
                    data: {
                        _token: _token,
                        medal_number: medal_number,
                        sub_category_id: sub_category_id,
                    },
                    success: function(data) {
                        $('.row_score').not(':first').remove();
                        const res = JSON.parse(data);
                        for (let i = 0; i < res.length; i++) {
                            var winnerNames = '';
                            var coachesNames = '';
                            if (i == 0) {
                                // Populate first score
                                if (medal_number == 1) {
                                    $('#team_name').val(res[i].team.id);
                                    for (let j = 0; j < res[i].gold_winners.length; j++) {
                                        const name = res[i].gold_winners[j].name;
                                        winnerNames += `${name}`;
                                        if (j < res[i].gold_winners.length - 1) {
                                            winnerNames += '\n';
                                        }
                                    }
                                    for (let j = 0; j < res[i].gold_coaches.length; j++) {
                                        const name = res[i].gold_coaches[j].coach_name;
                                        coachesNames += `${name}`;
                                        if (j < res[i].gold_coaches.length - 1) {
                                            coachesNames += '\n';
                                        }
                                    }
                                } else if (medal_number == 2) {
                                    $('#team_name').val(res[i].team.id);
                                    for (let j = 0; j < res[i].silver_winners.length; j++) {
                                        const name = res[i].silver_winners[j].name;
                                        winnerNames += `${name}`;
                                        if (j < res[i].silver_winners.length - 1) {
                                            winnerNames += '\n';
                                        }
                                    }
                                    for (let j = 0; j < res[i].silver_coaches.length; j++) {
                                        const name = res[i].silver_coaches[j].coach_name;
                                        coachesNames += `${name}`;
                                        if (j < res[i].silver_coaches.length - 1) {
                                            coachesNames += '\n';
                                        }
                                    }
                                } else if (medal_number == 3) {
                                    $('#team_name').val(res[i].team.id);
                                    for (let j = 0; j < res[i].bronze_winners.length; j++) {
                                        const name = res[i].bronze_winners[j].name;
                                        winnerNames += `${name}`;
                                        if (j < res[i].bronze_winners.length - 1) {
                                            winnerNames += '\n';
                                        }
                                    }
                                    for (let j = 0; j < res[i].bronze_coaches.length; j++) {
                                        const name = res[i].bronze_coaches[j].coach_name;
                                        coachesNames += `${name}`;
                                        if (j < res[i].bronze_coaches.length - 1) {
                                            coachesNames += '\n';
                                        }
                                    }
                                }
                                document.getElementById('players_name').value = winnerNames;
                                document.getElementById('coaches_name').value = coachesNames;
                            } else {
                                // Duplicate row for subsequent scores
                                duplicateRowScore();
                                var teamNames = document.querySelectorAll("#team_name");
                                var playersNames = document.querySelectorAll("#players_name");
                                var coachesNames = document.querySelectorAll("#coaches_name");
                                teamNames[i].value = res[i].team.id;
                                var winnerNames = '';
                                var coachNames = '';
                                if (medal_number == 1) {
                                    for (let j = 0; j < res[i].gold_winners.length; j++) {
                                        const name = res[i].gold_winners[j].name;
                                        winnerNames += `${name}`;
                                        if (j < res[i].gold_winners.length - 1) {
                                            winnerNames += '\n';
                                        }
                                    }
                                    for (let j = 0; j < res[i].gold_coaches.length; j++) {
                                        const name = res[i].gold_coaches[j].coach_name;
                                        coachNames += `${name}`;
                                        if (j < res[i].gold_coaches.length - 1) {
                                            coachNames += '\n';
                                        }
                                    }
                                } else if (medal_number == 2) {
                                    for (let j = 0; j < res[i].silver_winners.length; j++) {
                                        const name = res[i].silver_winners[j].name;
                                        winnerNames += `${name}`;
                                        if (j < res[i].silver_winners.length - 1) {
                                            winnerNames += '\n';
                                        }
                                    }
                                    for (let j = 0; j < res[i].silver_coaches.length; j++) {
                                        const name = res[i].silver_coaches[j].coach_name;
                                        coachNames += `${name}`;
                                        if (j < res[i].silver_coaches.length - 1) {
                                            coachNames += '\n';
                                        }
                                    }
                                } else if (medal_number == 3) {
                                    for (let j = 0; j < res[i].bronze_winners.length; j++) {
                                        const name = res[i].bronze_winners[j].name;
                                        winnerNames += `${name}`;
                                        if (j < res[i].bronze_winners.length - 1) {
                                            winnerNames += '\n';
                                        }
                                    }
                                    for (let j = 0; j < res[i].bronze_coaches.length; j++) {
                                        const name = res[i].bronze_coaches[j].coach_name;
                                        coachNames += `${name}`;
                                        if (j < res[i].bronze_coaches.length - 1) {
                                            coachNames += '\n';
                                        }
                                    }
                                }
                                playersNames[i].value = winnerNames;
                                coachesNames[i].value = coachNames;
                            }
                        }
                        $('#modal_score_head').html('Edit Score');
                        $('#btn_save_score').html("<i class='bi bi-plus-circle'></i> Update Score");

                        $('#modal_score').modal('show');
                    },
                    error: function(data) {
                        swal_error(data);
                    }
                });
            }

            // function edit_score(medal_number, sub_category_id) {
            //     current_sub_category_id = sub_category_id;
            //     transaction = 'edit';
            //     current_medal_number = medal_number;
            //     //get the scores from database
            //     $('#btn_delete_score').show();
            //     $.ajax({
            //         url: baseUrl + "/event/get_score",
            //         type: "POST",
            //         data: {
            //             _token: _token,
            //             medal_number: medal_number,
            //             sub_category_id: sub_category_id,
            //         },
            //         success: function(data) {
            //             var playersNames = document.querySelectorAll('#winner_names');
            //             $('.row_score').not(':first').remove();
            //             const res = JSON.parse(data);
            //             for (let i = 0; i < res.length; i++) {
            //                 var winnerNames = '';
            //                 var coachesNames = '';
            //                 if (i == 0) {
            //                     // Populate first score
            //                     if (medal_number == 1) {
            //                         $('#team_name').val(res[i].team.id);
            //                         for (let j = 0; j < res[i].gold_winners.length; j++) {
            //                             const name = res[i].gold_winners[j].name;
            //                             winnerNames += `${name}`;
            //                             if (j < res[i].gold_winners.length - 1) {
            //                                 winnerNames += '\n';
            //                             }
            //                         }
            //                         for (let j = 0; j < res[i].gold_coaches.length; j++) {
            //                             const name = res[i].gold_coaches[j].name;
            //                             coachesNames += `${name}`;
            //                             if (j < res[i].gold_coaches.length - 1) {
            //                                 coachesNames += '\n';
            //                             }
            //                         }
            //                     } else if (medal_number == 2) {
            //                         $('#team_name').val(res[i].team.id);
            //                         for (let j = 0; j < res[i].silver_winners.length; j++) {
            //                             const name = res[i].silver_winners[j].name;
            //                             winnerNames += `${name}`;
            //                             if (j < res[i].silver_winners.length - 1) {
            //                                 winnerNames += '\n';
            //                             }
            //                         }
            //                         for (let j = 0; j < res[i].silver_coaches.length; j++) {
            //                             const name = res[i].silver_coaches[j].name;
            //                             coachesNames += `${name}`;
            //                             if (j < res[i].silver_coaches.length - 1) {
            //                                 coachesNames += '\n';
            //                             }
            //                         }
            //                     } else if (medal_number == 3) {
            //                         for (let j = 0; j < res[i].bronze_winners.length; j++) {
            //                             const name = res[i].bronze_winners[j].name;
            //                             winnerNames += `${name}`;
            //                             if (j < res[i].bronze_winners.length - 1) {
            //                                 winnerNames += '\n';
            //                             }
            //                         }
            //                     }
            //                     playersNames[i].value = winnerNames;
            //                     // Add coaches to the coaches field
            //                     var coachesNames = document.querySelectorAll("#coaches_name");
            //                     for (let j = 0; j < res[i].coaches.length; j++) {
            //                         const name = res[i].coaches[j].name;
            //                         coachesNames[i].value += `${name}`;
            //                         if (j < res[i].coaches.length - 1) {
            //                             coachesNames[i].value += '\n';
            //                         }
            //                     }
            //                 }
            //             }
            //             $('#modal_score_head').html('Edit Score');
            //             $('#btn_save_score').html("<i class='bi bi-plus-circle'></i> Update Score");
            //             $('#modal_score').modal('show');
            //         },
            //         error: function(data) {
            //             swal_error(data);
            //         }
            //     });
            // }


            function add_sub_category(id) {
                transaction = 'add';
                selected_category_id = id;
                $('#modal_sub_category_head').html('Add Event Sub Category');
                $('#btn_save_event_sub_category').html("<i class='bi bi-plus-circle'></i> Save New Event Sub Category");
                $('#modal_sub_category').modal('show');
            }

            function duplicateRowScore() {
                var rowScore = document.getElementsByClassName("row_score")[0];
                var newRowScore = rowScore.cloneNode(true);
                document.getElementById("modal_body_score").appendChild(newRowScore);
            }

            function removeLastRowScore() {
                var rowScores = document.getElementsByClassName("row_score");
                if (rowScores.length > 1) {
                    var lastRowScore = rowScores[rowScores.length - 1];
                    lastRowScore.parentNode.removeChild(lastRowScore);
                }
            }

            function edit_event_category(id, category_level, category_sex) {
                transaction = 'edit';
                selected_id = id;
                $('#modal_category_head').html('Edt Event Category');
                $('#btn_save_event_category').html("<i class='bi bi-pencil-fill'></i> Update Event Category");
                $('#event_level').val(category_level);
                $('#event_sex').val(category_sex);
                $('#modal_category').modal('show');
            }

            function edit_event_sub_category(id, category_id, sub_category) {
                transaction = 'edit';
                selected_id = id;
                selected_category_id = category_id;
                $('#modal_sub_category_head').html('Edt Event Category');
                $('#btn_save_event_sub_category').html("<i class='bi bi-pencil-fill'></i> Update Event Category");
                $('#text_sub_category').val(sub_category);
                $('#modal_sub_category').modal('show');
            }

            function delete_event_category(id) {
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
                        $.post(baseUrl + '/event/delete_event_category', {
                            '_token': _token,
                            'id': id
                        }, function(data) {
                            if (data == 'ok') {
                                notify_success('', 'Event Category removed Successfully.');
                            } else {
                                swal_error(data);
                            }

                            location.reload();
                        })
                    }
                })
            }

            function delete_event_sub_category(id) {
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
                        $.post(baseUrl + '/event/delete_event_sub_category', {
                            '_token': _token,
                            'id': id
                        }, function(data) {
                            if (data == 'ok') {
                                notify_success('', 'Event Sub Category removed Successfully.');
                                location.reload();
                            } else {
                                swal_error(data);
                            }
                            hide_loading();
                        })
                    }
                })
            }


            $('#btn_save_event_category').on('click', function() {
                var error_count = 0;
                error_count += check_empty('event_level');
                error_count += check_empty('event_sex');

                if (error_count > 0) {
                    swal_error('There is an empty required field.');
                } else {
                    var event_level = $.trim($('#event_level').val());
                    var event_sex = $.trim($('#event_sex').val());

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
                            show_loading('Saving to database.');
                            $.post(baseUrl + '/event/save_tbl_event_category', {
                                '_token': _token,
                                'event_id': event_id,
                                'transaction': transaction,
                                'selected_id': selected_id,
                                'event_level': event_level,
                                'event_sex': event_sex,
                            }, function(data) {
                                if (data == 'ok') {
                                    if (transaction == 'add') {
                                        notify_success('', 'New Event Category Saved Successfully.');
                                    } else {
                                        notify_success('', 'Events Category updated Successfully.');
                                    }
                                    $('#modal_category').modal('hide');
                                    location.reload();
                                } else {
                                    swal_error(data);
                                }
                                hide_loading();
                            })
                        }
                    })
                }
            })

            $('#btn_save_event_sub_category').on('click', function() {
                var error_count = 0;
                error_count += check_empty('text_sub_category');

                if (error_count > 0) {
                    swal_error('There is an empty required field.');
                } else {
                    var text_sub_category = $.trim($('#text_sub_category').val());
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
                            show_loading('Saving to database.');
                            $.post(baseUrl + '/event/save_tbl_event_sub_category', {
                                '_token': _token,
                                'transaction': transaction,
                                'selected_id': selected_id,
                                'text_sub_category': text_sub_category,
                                'selected_category_id': selected_category_id,
                            }, function(data) {
                                if (data == 'ok') {
                                    if (transaction == 'add') {
                                        notify_success('',
                                            'New Event Sub Category Saved Successfully.');
                                    } else {
                                        notify_success('', 'Events Sub Category updated Successfully.');
                                    }
                                    $('#modal_category').modal('hide');
                                    location.reload();
                                } else {
                                    swal_error(data);
                                }
                                hide_loading();
                            })
                        }
                    })
                }
            })

            function validate_score(sub_category_id) {
                //ask swal to confirm
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
                        show_loading('Validating Score');
                        $.ajax({
                            url: baseUrl + "/event/validate_score",
                            type: "POST",
                            data: {
                                _token: _token,
                                sub_category_id: sub_category_id,
                            },
                            success: function(data) {
                                if (data == "ok") {
                                    swal_success("Score Validated Successfully.");
                                    location.reload();
                                } else {
                                    swal_error(data);
                                }
                            },
                            error: function(data) {
                                swal_error(data);
                            }
                        });
                    }
                })
            }

            function invalidate_score(sub_category_id) {
                //ask swal to confirm
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
                        show_loading('Invalidating Score');
                        $.ajax({
                            url: baseUrl + "/event/invalidate_score",
                            type: "POST",
                            data: {
                                _token: _token,
                                sub_category_id: sub_category_id,
                            },
                            success: function(data) {
                                if (data == "ok") {
                                    swal_success("Score Invalidated Successfully.");
                                    location.reload();
                                } else {
                                    swal_error(data);
                                }
                            },
                            error: function(data) {
                                swal_error(data);
                            }
                        });
                    }
                })
            }
        </script>
    </x-slot>

</x-app-layout>
