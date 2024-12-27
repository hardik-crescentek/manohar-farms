<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="utf-8">
		<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">

        @include('layouts-verticalmenu-light.css')

	</head>

	<body class="main-body leftmenu">
		<!-- Loader -->
		<div id="global-loader">
			<img src="{{URL::asset('assets/img/loader.svg')}}" class="loader-img" alt="Loader">
		</div>
        <!-- End Loader -->

		<!-- Page -->
		<div class="page">

        @include('layouts-verticalmenu-light.side-menu')
        @include('layouts-verticalmenu-light.main-header')
		@include('layouts-verticalmenu-light.mobile-header')

			<!-- Main Content-->
			<div class="main-content side-content pt-0 error-bg">
				<div class="container-fluid">
					<div class="inner-body">

		@yield('content')

					</div>
				</div>
			</div>
			<!-- End Main Content-->

		@include('layouts-verticalmenu-light.footer')
		@include('layouts-verticalmenu-light.sidebar')

		</div>
        <!-- End Page -->

        @include('layouts-verticalmenu-light.script')

	</body>
</html>