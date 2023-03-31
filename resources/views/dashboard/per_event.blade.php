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


    <div class="row">
        <div class="col-12">
            <div class="card recent-sales overflow-auto">

                <div class="card-body">
                    <h5 class="card-title">Overall Summary<span>| Games

                        as of {{ date('F d, Y h:i A') }}

                    </span>
                    </h5>

                    {!!  $summary  !!}

                  

                </div>

            </div>
        </div><!-- End Recent Sales -->
    </div>



    <x-slot name="my_js">
        <script>
            var baseUrl = "{{ url('/') }}";
            var _token = "{{ csrf_token() }}";


            $(document).ready(function() {

                $('#tbl_per_event').DataTable({
                    "paging": false,
                    "searching": false,
                    "lengthChange": false,
                    "info": false
                });
                
            });
        </script>
    </x-slot>

</x-app-layout>
