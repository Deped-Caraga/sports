<x-app-layout>
    <x-slot name='page_title'>
        <title>Dashboard</title>
    </x-slot>

    <x-slot name='my_css'>
        <style>
            table,
            tr,
            td,
            th {
                border: 1px solid black;
                padding: 5px;
            }

            td {
                page-break-inside: avoid;
            }
        </style>
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


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>List of Winners - {{ $team->team_name }}
                        {{-- add a button with print icon label Print --}}
                        <a href="{{ url('print-winners/' . $team->id) }}" class="btn btn-success btn-sm float-right"
                            target="_blank"><i class="bi bi-printer"></i> Print</a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            {!! $winners !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <x-slot name="my_js">
        <script>
            var baseUrl = "{{ url('/') }}";
            var _token = "{{ csrf_token() }}";


            $(document).ready(function() {


            });
        </script>
    </x-slot>

</x-app-layout>
