			<!-- Mobile-header -->
			<div class="mobile-main-header">
			    <div class="mb-1 navbar navbar-expand-lg  nav nav-item  navbar-nav-right responsive-navbar navbar-dark  ">
			        <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
			            <div class="d-flex order-lg-2 ml-auto">
			                <div class="dropdown ">
			                    <a class="nav-link icon full-screen-link">
			                        <i class="fe fe-maximize fullscreen-button fullscreen header-icons"></i>
			                        <i class="fe fe-minimize fullscreen-button exit-fullscreen header-icons"></i>
			                    </a>
			                </div>			                
			                <div class="dropdown main-profile-menu">
			                    <a class="d-flex" href="#">
			                        <span class="main-img-user"><img alt="avatar" src="{{URL::asset('assets/img/users/1.jpg')}}"></span>
			                    </a>
			                    <div class="dropdown-menu">
                                    <div class="header-navheading">
                                        <h6 class="main-notification-title">{{ Auth::user()->name }}</h6>
                                        <p class="main-notification-text">{{ Auth::user()->role }}</p>
                                    </div>
			                        <!-- <a class="dropdown-item border-top" href="{{url('profile')}}">
			                            <i class="fe fe-user"></i> My Profile
			                        </a>
			                        <a class="dropdown-item" href="{{url('profile')}}">
			                            <i class="fe fe-edit"></i> Edit Profile
			                        </a>
			                        <a class="dropdown-item" href="{{url('profile')}}">
			                            <i class="fe fe-settings"></i> Account Settings
			                        </a>
			                        <a class="dropdown-item" href="{{url('profile')}}">
			                            <i class="fe fe-settings"></i> Support
			                        </a>
			                        <a class="dropdown-item" href="{{url('profile')}}">
			                            <i class="fe fe-compass"></i> Activity
			                        </a> -->
                                    <a class="dropdown-item border-top" href="{{ route('cowshed.dashboard') }}">
                                        <i class="fe fe-power"></i> Cowshed
                                    </a>
			                        <a class="dropdown-item border-top" href="{{url('signin')}}">
			                            <i class="fe fe-power"></i> Sign Out
			                        </a>
			                    </div>
			                </div>
			            </div>
			        </div>
			    </div>
			</div>
			<!-- Mobile-header closed -->