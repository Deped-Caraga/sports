<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    {!! isset($page_title) ? $page_title : '<title>Sports Competition Scoring System</title>' !!}

    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ url('/niceadmin') }}/assets/img/favicon.png" rel="icon">
    <link href="{{ url('/niceadmin') }}/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ url('/niceadmin') }}/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ url('/niceadmin') }}/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ url('/niceadmin') }}/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="{{ url('/niceadmin') }}/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="{{ url('/niceadmin') }}/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="{{ url('/niceadmin') }}/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="{{ url('/niceadmin') }}/assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <link href="{{ url('/css/iziToast.min.css') }}" rel="stylesheet">
    <link href="{{ url('/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ url('/niceadmin') }}/assets/css/style.css" rel="stylesheet">


    {{ isset($my_css) ? $my_css : '' }}
    <style>
        .error_input {
            border: 1px solid red;
            background: url("{{ url('images/error_input.svg') }}") no-repeat;
            background-size: 20px;
            background-position: right 5px top 6.5px;
        }

        .error_label {
            color: red;
        }
    </style>
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html">
                <img style="width:200px" src="{{ url('/images/logo2.png') }}" alt="">
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        {{-- <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div><!-- End Search Bar --> --}}

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                {{-- <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon--> --}}
                {{-- 
                <li class="nav-item dropdown">

                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number">4</span>
                    </a><!-- End Notification Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            You have 4 new notifications
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-exclamation-circle text-warning"></i>
                            <div>
                                <h4>Lorem Ipsum</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>30 min. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-x-circle text-danger"></i>
                            <div>
                                <h4>Atque rerum nesciunt</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>1 hr. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-check-circle text-success"></i>
                            <div>
                                <h4>Sit rerum fuga</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>2 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-info-circle text-primary"></i>
                            <div>
                                <h4>Dicta reprehenderit</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>4 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="dropdown-footer">
                            <a href="#">Show all notifications</a>
                        </li>

                    </ul><!-- End Notification Dropdown Items -->

                </li><!-- End Notification Nav --> --}}

                {{-- <li class="nav-item dropdown">

                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-chat-left-text"></i>
                        <span class="badge bg-success badge-number">3</span>
                    </a><!-- End Messages Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                        <li class="dropdown-header">
                            You have 3 new messages
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="message-item">
                            <a href="#">
                                <img src="{{ url('/niceadmin') }}/assets/img/messages-1.jpg" alt=""
                                    class="rounded-circle">
                                <div>
                                    <h4>Maria Hudson</h4>
                                    <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                    <p>4 hrs. ago</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="message-item">
                            <a href="#">
                                <img src="{{ url('/niceadmin') }}/assets/img/messages-2.jpg" alt=""
                                    class="rounded-circle">
                                <div>
                                    <h4>Anna Nelson</h4>
                                    <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                    <p>6 hrs. ago</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="message-item">
                            <a href="#">
                                <img src="{{ url('/niceadmin') }}/assets/img/messages-3.jpg" alt=""
                                    class="rounded-circle">
                                <div>
                                    <h4>David Muldon</h4>
                                    <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                    <p>8 hrs. ago</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="dropdown-footer">
                            <a href="#">Show all messages</a>
                        </li>

                    </ul><!-- End Messages Dropdown Items -->

                </li><!-- End Messages Nav --> --}}

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        <img src=" {{ Auth::user()->profile_picture
                            ? url('storage/profile_pictures/' . Auth::user()->profile_picture)
                            : url('/images/default_image.png') }}"
                            alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">
                            {{ Auth::user()->email }}
                        </span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li>
                            <a class="dropdown-item d-flex align-items-center"
                                href="{{ '/user-profile/' . Auth::user()->id }}">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        @if (Auth::user()->can('Manage Users'))
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ url('user') }}">
                                    <i class="bi bi-people"></i>
                                    <span>Users</span>
                                </a>
                            </li>
                        @endif
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ url('/permissions') }}">
                                <i class="bi bi-question-circle"></i>
                                <span>Permissions</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard/regular') ? '' : 'collapsed' }}"
                    href="{{ url('dashboard/regular') }}">
                    <i class="bi bi-grid"></i>
                    <span>Summary - Regular Games</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard/special') ? '' : 'collapsed' }}"
                    href="{{ url('dashboard/special') }}">
                    <i class="bi bi-grid"></i>
                    <span>Summary - Special Games</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard/demo') ? '' : 'collapsed' }}"
                    href="{{ url('dashboard/demo') }}">
                    <i class="bi bi-grid"></i>
                    <span>Summary - Demo Games</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard/all') ? '' : 'collapsed' }}"
                    href="{{ url('dashboard/all') }}">
                    <i class="bi bi-grid"></i>
                    <span>Summary - All Games</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('per-event') ? '' : 'collapsed' }}" href="{{ url('per-event') }}">
                    <i class="bi bi-grid"></i>
                    <span>Summary - Per Event </span>
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link {{ Request::is('events') ? '' : 'collapsed' }}" href="{{ url('/events') }}">
                    <i class="bi bi-view-list"></i>
                    <span>Events</span>
                </a>
            </li>
            @if (Auth::user())
                <li class="nav-item">
                    <a target="_blank" class="nav-link {{ Request::is('events') ? '' : 'collapsed' }}"
                        href="{{ url('/print-final') }}">
                        <i class="bi bi-printer"></i>
                        <span>Final Results</span>
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <a class="nav-link {{ Request::is('teams') ? '' : 'collapsed' }}" href="{{ url('/teams') }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Teams</span>
                </a>
            </li>


        </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main">

        {{ isset($page_breadcrumb) ? $page_breadcrumb : '' }}
        {{ $slot }}

    </main><!-- End #main -->

    <div class="modal" data-bs-backdrop="static" id="modal_loading" tabindex="-1">
        <div class="modal-dialog modal-sm" style=" transform: translate(0, -50%);top: 40%;margin: 0 auto;">
            <div class="modal-body">
                <img src='{{ url('images/loading.gif') }}' class="img-fluid">

                <div id="loading_title" style="color:white;background:rgb(131, 116, 202)"></div>
                <div id="loading_message" style="color:white;background:rgb(131, 116, 202)"></div>
            </div>
        </div>
    </div>



    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Sports Competition Scoring System</span></strong>. All Rights Reserved
        </div>
        <div class="credits">

            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <script src="{{ url('/js/jquery.min.js') }}"></script>
    <script src="{{ url('/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('/js/dataTables.bootstrap5.min.js') }}"></script>

    <!-- Vendor JS Files -->
    <script src="{{ url('/niceadmin') }}/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="{{ url('/niceadmin') }}/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ url('/niceadmin') }}/assets/vendor/chart.js/chart.min.js"></script>
    <script src="{{ url('/niceadmin') }}/assets/vendor/echarts/echarts.min.js"></script>
    <script src="{{ url('/niceadmin') }}/assets/vendor/quill/quill.min.js"></script>
    <script src="{{ url('/niceadmin') }}/assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="{{ url('/niceadmin') }}/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="{{ url('/niceadmin') }}/assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="{{ url('/niceadmin') }}/assets/js/main.js"></script>

    <!-- Sweet Alert and iziToast -->
    <script src="{{ url('/js/sweetalert2.js') }}"></script>
    <script src="{{ url('/js/iziToast.min.js') }}"></script>

    <script>
        function swal_error(msg = "An error occured!") {
            Swal.fire('Eror!', msg, 'error');
        }

        function swal_success(msg = "Transaction copleted successfully!") {
            Swal.fire('Success!', msg, 'success');
        }

        function notify_success(title, message) {
            if (title == "") title = "Success";
            if (message == "") message = "Transaction complete!";
            iziToast.success({
                title: title,
                message: message,
                position: 'topRight',
                maxWidth: '400px',
            });
        }

        function notify_error(title, message) {
            if (title == "") title = "Error";
            if (message == "") message = "Transaction did not complete!";
            iziToast.error({
                title: title,
                message: message,
                position: 'topRight',
                maxWidth: '400px',
            });
        }


        function color_empty(object_id) {
            var val = $.trim($('#' + object_id).val());
            if (val == "") {
                $('#' + object_id).addClass('error_input');
                $('#label_' + object_id).addClass('error_label');
            } else {
                $('#' + object_id).removeClass('error_input');
                $('#label_' + object_id).removeClass('error_label');
            }
        }

        function color_empty_number(object_id) {
            var val = $.trim($('#' + object_id).val());
            if (val == "" || isNaN(val)) {
                $('#' + object_id).addClass('error_input');
                $('#label_' + object_id).addClass('error_label');
            } else {
                $('#' + object_id).removeClass('error_input');
                $('#label_' + object_id).removeClass('error_label');
            }
        }

        function check_empty(object_id) {
            var val = $.trim($('#' + object_id).val());
            if (val == "") {
                $('#' + object_id).addClass('error_input');
                $('#label_' + object_id).addClass('error_label');
                return 1;
            } else {
                $('#' + object_id).removeClass('error_input');
                $('#label_' + object_id).removeClass('error_label');
                return 0;
            }
        }

        function check_empty_number(object_id) {
            var val = $.trim($('#' + object_id).val());
            if (val == "" || isNaN(val)) {
                $('#' + object_id).addClass('error_input');
                $('#label_' + object_id).addClass('error_label');
                return 1;
            } else {
                $('#' + object_id).removeClass('error_input');
                $('#label_' + object_id).removeClass('error_label');
                return 0;
            }
        }


        function show_loading(title = "", message = "") {
            $('#loading_title').html('');
            $('#loading_message').html('');
            if (title != "") {
                $('#loading_title').html("<h5 style='padding:7px;font-weight:bold'>" + title + "</h5>");
            }
            if (message != "") {
                $('#loading_message').html("<p style='padding:7px'>" + message + "</p>");
            }
            $('#modal_loading').modal('show');

        }

        function hide_loading() {
            $("#modal_loading").modal('hide');
        }

        function validateEmail(email) {
            var re = /\S+@\S+\.\S+/;
            return re.test(email);
        }
    </script>

    {!! isset($my_js) ? $my_js : '' !!}

</body>

</html>
