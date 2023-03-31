<x-app-layout>
    <x-slot name='page_title'>
        <title>Dashboard</title>
    </x-slot>

    <x-slot name='my_css'>

    </x-slot>

    <x-slot name="page_breadcrumb">
        <div class="pagetitle">
            <h1> Dashboard </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="url('')">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
    </x-slot>


    <section class="section dashboard">

        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- TOTAL MEDALS Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">

                            <div class="card-body">
                                <h5 class="card-title">Total Events <span>|
                                        {{ ucfirst($game_category) }} Games
                                    </span></h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bx bx-medal"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ number_format($data['total_events'], 0) }}</h6>
                                        <span class="text-success small pt-1 fw-bold"></span> <span
                                            class="text-muted small pt-2 ps-1">Total number of events</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- TOTAL MEDALS Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">

                            <div class="card-body">
                                <h5 class="card-title">Scored <span>|
                                        {{ ucfirst($game_category) }} Games
                                    </span></h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bx bx-medal"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ number_format($data['total_scored'], 0) }}</h6>
                                        <span
                                            class="@if ($data['percentage_scored'] == 100) text-success @elseif($data['percentage_scored'] > 50) text-info @else text-danger @endif small pt-1 fw-bold">{{ $data['percentage_scored'] }}%</span>
                                        <span class="text-muted small pt-2 ps-1">complete</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- TOTAL MEDALS Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">

                            <div class="card-body">
                                <h5 class="card-title">Waiting Results <span>|
                                        {{ ucfirst($game_category) }} Games
                                    </span></h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bx bx-medal"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ number_format($data['total_events'] - $data['total_scored'], 0) }}</h6>
                                        <span
                                            class="@if ($data['percentage_remaining'] > 50) text-danger @elseif($data['percentage_remaining'] >= 1) text-info @else text-success @endif small pt-1 fw-bold">{{ $data['percentage_remaining'] }}%</span>
                                        <span class="text-muted small pt-2 ps-1">remaining</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                </div>
            </div><!-- End Left side columns -->
        </div><!-- End Row -->

    </section>

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success" role="alert">
                <strong>Elementary Category:</strong> Events in which Elementary and Secondary athletes play
                together are counted in the Elementary category.
            </div>
            <div class="alert alert-success" role="alert">
                <strong>Boys Category:</strong> Events in which Boys and Girls athletes play
                together are counted in the boys category.
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-12">
            <div class="card recent-sales overflow-auto">

                <div class="card-body">
                    <h5 class="card-title">Overall Summary<span>| {{ ucfirst($game_category) }} Games
                            @if ($game_category == 'all')
                                Including Demo and Special Games
                            @endif
                            {{-- as of with time --}}
                            as of {{ date('F d, Y h:i A') }}
                        </span>
                    </h5>

                    {{-- Add span badge saying that the elementary is  --}}


                    {!! $data['overall'] !!}

                </div>

            </div>
        </div><!-- End Recent Sales -->
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card recent-sales overflow-auto">

                <div class="card-body">
                    <h5 class="card-title">Overall Elementary<span>| {{ ucfirst($game_category) }} Games
                            @if ($game_category == 'all')
                                Including Demo and Special Games
                            @endif
                            {{-- as of with time --}}
                            as of {{ date('F d, Y h:i A') }}
                        </span>
                    </h5>

                    {{-- Add span badge saying that the elementary is  --}}


                    {!! $data['overall_elementary'] !!}

                </div>

            </div>
        </div><!-- End Recent Sales -->
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card recent-sales overflow-auto">

                <div class="card-body">
                    <h5 class="card-title">Overall Secondary<span>| {{ ucfirst($game_category) }} Games
                            @if ($game_category == 'all')
                                Including Demo and Special Games
                            @endif
                            {{-- as of with time --}}
                            as of {{ date('F d, Y h:i A') }}
                        </span>
                    </h5>

                    {{-- Add span badge saying that the elementary is  --}}


                    {!! $data['overall_secondary'] !!}

                </div>

            </div>
        </div><!-- End Recent Sales -->
    </div>


    <x-slot name="my_js">
        <script>
            var baseUrl = "{{ url('/') }}";
            var _token = "{{ csrf_token() }}";


            $(document).ready(function() {

                $('#table_summary').DataTable({
                    "paging": false,
                    "searching": false,
                    "lengthChange": false,
                    "info": false
                });
                $('#table_summary_elementary').DataTable({
                    "paging": false,
                    "searching": false,
                    "lengthChange": false,
                    "info": false
                });
                $('#table_summary_secondary').DataTable({
                    "paging": false,
                    "searching": false,
                    "lengthChange": false,
                    "info": false
                });
            });
        </script>
    </x-slot>

</x-app-layout>
