			<!-- Main Header-->
			<div class="main-header side-header sticky">
				<div class="container-fluid">
					<div class="main-header-left">
						<a class="main-header-menu-icon" href="#" id="mainSidebarToggle"><span></span></a>
					</div>
					<div class="main-header-center">
						<div class="responsive-logo">
							<a href="{{url('index')}}"><img src="{{URL::asset('assets/img/brand/logo.png')}}" class="mobile-logo" alt="logo"></a>
							<a href="{{url('index')}}"><img src="{{URL::asset('assets/img/brand/logo-light.png')}}" class="mobile-logo-dark" alt="logo"></a>
						</div>
						
					</div>
					<div class="main-header-right">
						<div class="dropdown d-md-flex">
							<a class="nav-link icon full-screen-link" href="">
								<i class="fe fe-maximize fullscreen-button fullscreen header-icons"></i>
								<i class="fe fe-minimize fullscreen-button exit-fullscreen header-icons"></i>
							</a>
						</div>
						<div class="dropdown main-profile-menu">
							<a class="d-flex" href="">
								<span class="main-img-user" ><img alt="avatar" src="{{URL::asset('assets/img/users/1.jpg')}}"></span>
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
                                <a class="dropdown-item border-top" href="{{ route('cowshed.settings') }}">
                                    <i class="fe fe-power"></i> Cowshed settings
                                </a>
                                <a class="dropdown-item border-top" href="{{ route('dashboard') }}">
                                    <i class="fe fe-power"></i> Manohar farms
                                </a>
								<a class="dropdown-item border-top" href="{{ route('logout') }}">
									<i class="fe fe-power"></i> Sign Out
								</a>
							</div>
						</div>
						<button class="navbar-toggler navresponsive-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4"
							aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
							<i class="fe fe-more-vertical header-icons navbar-toggler-icon"></i>
						</button><!-- Navresponsive closed -->
					</div>
				</div>
			</div>
			<!-- End Main Header-->