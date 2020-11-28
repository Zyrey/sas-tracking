<div class="collapse navbar-collapse" id="nav">
    <ul class="navbar-nav mr-auto">

        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link bg-secondary text-warning">Home</a>
        </li>

        <li class="nav-item">
            <div class="dropdown">
                <a class="nav-link bg-secondary text-warning dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Programs
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a href="{{ route('programs.index') }}" class="dropdown-item">Programs</a>
                    <a href="{{ route('courses.index') }}" class="dropdown-item">Courses</a>
                    @can('isAdmin')
                        <a href="{{ route('courseLevels.index') }}" class="dropdown-item">Course Levels</a>
                        <a href="{{ route('steps.index') }}" class="dropdown-item">Course Steps</a>
                        <a href="{{ route('institutions.index') }}" class="dropdown-item">Institution</a>
                    @endcan
                </div>
            </div>
        </li>

        @can('isAdmin')
            <li class="nav-item">
                <a href="{{ route('semesters.index') }}" class="nav-link bg-secondary text-warning">Semesters</a>
            </li>
        @endcan

        <li class="nav-item">
            <a href="{{ route('faculties.index') }}" class="nav-link bg-secondary text-warning">Faculties</a>
        </li>

        <li class="nav-item">
            <a href="{{ route('student.index') }}" class="nav-link bg-secondary text-warning">Students</a>
        </li>

        <li class="nav-item">
            <a href="{{ route('enrollments.index') }}" class="nav-link bg-secondary text-warning">Enrollments</a>
        </li>

    </ul>

    <!-- Right Side Of Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Authentication Links -->
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                @if(Auth::user()->is_admin)
                    Logged in as Admin -
                @else
                    Logged in as GPC -
                @endif
                {{ Auth::user()->email }} <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                <a class="dropdown-item" href="{{ route('user.show', Auth()->user()->email) }}">
                    View Profile
                </a>
                <a class="dropdown-item" href="{{ route('logout') }}">
                    Logout
                </a>

            </div>

        </li>
    </ul>
</div>

