<nav class="navbar">
    <a href="#" class="sidebar-toggler">
        <i data-feather="menu"></i>
    </a>
    <div class="navbar-content">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="wd-30 ht-30 rounded-circle" src="{{ asset('assets/images/user.png') }}" alt="profile">
                </a>
                <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                    <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                        <div class="mb-3">
                            <img class="wd-80 ht-80 rounded-circle" src="{{ asset('assets/images/user.png') }}"
                                alt="">
                        </div>
                        <div class="text-center">
                            <p class="tx-16 fw-bolder">{{ auth()->user()->pegawai->nama_pegawai }}</p>
                            <p class="tx-12 text-muted">{{ auth()->user()->pegawai->email }}</p>
                        </div>
                    </div>
                    <ul class="list-unstyled p-1">
                        <form id="myForm" action={{ route('logout') }} method="POST">
                            @csrf
                            <button type="submit" style="display: none;">
                            </button>
                        </form>
                        <li class="dropdown-item py-2">
                            <a href="#" class="text-body ms-0" style="padding-right:100%"
                                onclick="event.preventDefault(); document.getElementById('myForm').submit();">
                                <i class="me-2 icon-md" data-feather="log-out"></i>
                                <span>Log Out</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
