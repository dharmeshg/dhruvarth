<header class="navbar pcoded-header navbar-expand-lg navbar-light">
    <div class="m-header">
        <a class="mobile-menu" id="mobile-collapse1" href="javascript:"><span></span></a>
        <a class="b-brand">
            @if(isset($bs->business_logo) && $bs->business_logo != '')
                <img src="{{ asset('uploads/images/'.$bs->business_logo) }}" alt="{{$bs->business_name}}" style="width: 100px;height: auto;">
            @else
                <img src="{{ asset('images/jewelxy-full-logo 1.svg') }}" class="img-fluid" style="width: 100px;height: auto;"> 
            @endif
        </a>
    </div>
    <a class="mobile-menu" id="mobile-header" href="javascript:">
        <i class="feather icon-more-horizontal"></i>
    </a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            {{-- <li><a href="javascript:" class="full-screen" onclick="javascript:toggleFullScreen()"><i class="feather icon-maximize"></i></a></li> --}}
            {{-- <li class="nav-item">
                <div class="main-search">
                    <div class="input-group">
                        <input type="text" id="m-search" class="form-control" placeholder="Search . . .">
                        <a href="javascript:" class="input-group-append search-close">
                            <i class="feather icon-x input-group-text"></i>
                        </a>
                        <span class="input-group-append search-btn btn btn-primary">
                            <i class="feather icon-search input-group-text"></i>
                        </span>
                    </div>
                </div>
            </li>  --}}
            {{-- <li class="nav-item">
                
                <input type="text" style="height: 35px;">
            </li> --}}
            {{-- <li class="nav-item">
                <a class="" href="{{ route('users') }}">User</a>
            </li>
            <li class="nav-item">
                <a class="" href="{{ route('setting.index') }}">Settings</a>
            </li>  --}}
        </ul>
        <ul class="navbar-nav ml-auto">
            {{-- <li class="p-0">
                <a href="{{route('home')}}" class="" target = "_blank">
                        <i class="fa fa-globe" aria-hidden="true" style="font-size: 18px;"></i></a>
            </li> --}}
            <li>
                <div class="dropdown drp-user user_dropdown">
                    <a href="javascript:" class="dropdown-toggle d-flex align-items-center  " data-toggle="dropdown">
                        @if(isset($bs->business_favicon) && $bs->business_favicon != '')
                            <img src="{{ asset('uploads/images/'.$bs->business_favicon) }}" class="img-fluid" style="width: 35px;height: 35px;">
                        @else
                            <img src="{{ asset('images/Favicon_new.svg') }}" class="img-fluid" style="width: 30px;height: 30px;"> 
                        @endif
                        
                        <div class="username_div">
                            <span class="sitename">{{$bs->business_name}}</span>
                        <span>Admin</span>
                    </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-notification">
                        <div class="pro-head">
                            <img src="{{ asset('assets/img/new-profile.svg') }}" class="img-radius" alt="User-Profile-Image">
                            <span>{{$bs->business_name}}</span>
                            <!-- <a href="{{ route('logout') }}" class="dud-logout" title="Logout" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="feather icon-log-out"></i>
                            </a> -->
                        </div>
                        <ul class="pro-body">
                            <li><a href="{{ route('setting_all.index') }}" class="dropdown-item"><i class="feather icon-settings"></i> Settings</a></li>
                            <li><a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="feather icon-log-out"></i> Log Out</a></li>
                        </ul>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>