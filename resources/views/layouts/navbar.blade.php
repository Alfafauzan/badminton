    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>

        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    {{-- <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}"
                      class="user-image img-circle elevation-2" alt="User Image"> --}}
                    <span
                        class="d-none d-md-inline">{{ Auth::user()->name }}({{ Auth::user()->roles->pluck('name')->implode(', ') }})</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header bg-primary">
                        <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                            alt="User Image">

                        <p>
                            {{ Auth::user()->name }}
                            <small
                                class="badge badge-success">{{ Auth::user()->roles->pluck('name')->implode(', ') }}</small>
                        </p>
                    </li>

                    <!-- Menu Footer-->
                    <li class="user-footer d-flex justify-content-between">

                        {{-- Contoh tombol Profil di kiri --}}
                        <a href="" class="btn btn-default btn-flat">Profil</a>

                        {{-- Form Logout di kanan --}}
                        <form method="POST" action="{{ route('logout') }}" id="logout-form">
                            @csrf

                            {{-- Kita menggunakan <a> yang di-style seperti tombol, 
                                 namun fungsinya untuk men-submit form di atas via JavaScript --}}
                            <a href="{{ route('logout') }}" class="btn btn-danger btn-flat"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                                <i class="fas fa-sign-out-alt mr-2"></i>Log out
                            </a>
                        </form>

                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->
