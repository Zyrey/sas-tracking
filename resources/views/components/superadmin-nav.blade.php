<div class="collapse navbar-collapse" id="nav">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a href="{{ route('superadmin.home') }}" class="nav-link bg-secondary text-warning">Home</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admins.index') }}" class="nav-link bg-secondary text-warning">Admins</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('coordinators.index') }}" class="nav-link bg-secondary text-warning">GPCs</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('roles.index') }}" class="nav-link bg-secondary text-warning">Roles</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('clusters.index') }}" class="nav-link bg-secondary text-warning">Clusters</a>
        </li>
    </ul>

    <!-- Right Side Of Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Authentication Links -->
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                Logged in as superadmin - {{ Auth::user()->email }} <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('superadmin.show', Auth()->user()->email) }}">
                    View Profile
                </a>

                <a class="dropdown-item" href="{{ route('superadmin.logout') }}">
                    Logout
                </a>
            </div>

        </li>
    </ul>
</div>

