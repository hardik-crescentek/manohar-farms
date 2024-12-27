<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="utf-8">
		<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">

        @include('cowshed.layouts.css')

	</head>

	<body class="main-body leftmenu">
		<!-- Loader -->
		<div id="global-loader">
			<img src="{{URL::asset('assets/img/loader.svg')}}" class="loader-img" alt="Loader">
		</div>
        <!-- End Loader -->

		<!-- Page -->
		<div class="page">

        @include('cowshed.layouts.side-menu')
        @include('cowshed.layouts.main-header')
		@include('cowshed.layouts.mobile-header')

			<!-- Main Content-->
			<div class="main-content side-content pt-0 error-bg">
				<div class="container-fluid">
					<div class="inner-body">

		@yield('content')

					</div>
				</div>
			</div>
			<!-- End Main Content-->

		@include('cowshed.layouts.footer')
		@include('cowshed.layouts.sidebar')

		</div>
        <!-- End Page -->

        @include('cowshed.layouts.script')

	</body>
</html>