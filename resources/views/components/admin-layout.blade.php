<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="{{ asset('css/admin/styles.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

    {{ $css ?? '' }}
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="{{ url('/') }}" target="_blank">Amazing Blog</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <form action="/" method="GET">
                <div class="input-group">
                    <input class="form-control" type="text" name="search" placeholder="Search Post..." value="{{ request()->query('search') }}"
                        aria-label="Search Post..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="submit">
                        <i class="fas fa-search"></i></button>
                </div>
            </form>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ route('admin.my-profile') }}">My Profile</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.logout') }}">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link {{ str_contains(url()->current(), route('admin.post.index')) ? 'active' : '' }}"
                            href="{{ route('admin.post.index') }}">
                            <div class="sb-nav-link-icon"><i class="bi bi-pencil"></i></div>
                            Posts
                        </a>
                        <a class="nav-link {{ str_contains(url()->current(), route('admin.user.index')) ? 'active' : '' }}"
                            href="{{ route('admin.user.index') }}">
                            <div class="sb-nav-link-icon"><i class="bi bi-shield-slash"></i></div>
                            Users
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    {{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    @if (isset($cta) && isset($title))
                        <div class="align-items-end d-flex justify-content-between mt-4">
                            @if ($title)
                                <h1 class="m-0">{{ $title }}</h1>
                            @endif
                            {{ $cta }}
                        </div>
                    @elseif(isset($title))
                        <h1 class="mt-4">{{ $title }}</h1>
                    @endif
                    <ol class="breadcrumb mb-4">
                        @if (isset($breadcrumbs) && count($breadcrumbs))
                            @foreach ($breadcrumbs as $key => $breadcrumb)
                                @if ($key === array_key_last($breadcrumbs))
                                    <li class="breadcrumb-item active">{{ $breadcrumb['title'] }}</li>
                                    @continue
                                @endif

                                <li class="breadcrumb-item">
                                    <a href="{{ $breadcrumb['url'] }}">
                                        {{ $breadcrumb['title'] }}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ol>

                    {{ $slot }}
                </div>
            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website {{ date('Y') }}</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
    <script src="{{ asset('js/admin/scripts.js') }}"></script>
    {{ $script ?? '' }}
</body>

</html>
