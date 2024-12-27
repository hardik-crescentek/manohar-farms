@extends('layouts-verticalmenu-light.master2')
@section('css')
@endsection
@section('content')

		<!-- Page -->
		<div class="page main-signin-wrapper">

			<!-- Row -->
			<div class="row signpages text-center">
				<div class="col-md-12">
					<div class="card">
						<div class="row row-sm">
							<div class="col-lg-6 col-xl-5 d-none d-lg-block text-center bg-primary details">
								<div class="mt-5 pt-4 p-2 pos-absolute">
									<!-- <img src="{{URL::asset('assets/img/brand/logo-light.png')}}" class="header-brand-img mb-4" alt="logo"> -->
                                    <h2 class="text-light">Manohar Farms</h2>
									<div class="clearfix"></div>
									<img src="{{URL::asset('assets/img/svgs/user.svg')}}" class="ht-100 mb-0" alt="user">
									<h5 class="mt-4 text-white">Create Your Account</h5>
									<span class="tx-white-6 tx-13 mb-5 mt-xl-0">Signup to create, discover and connect with the global community</span>
								</div>
							</div>
							<div class="col-lg-6 col-xl-7 col-xs-12 col-sm-12 login_form ">
								<div class="container-fluid">
									<div class="row row-sm">
										<div class="card-body mt-2 mb-2">
											<img src="{{URL::asset('assets/img/brand/logo.png')}}" class=" d-lg-none header-brand-img text-left float-left mb-4" alt="logo">
											<div class="clearfix"></div>
											<form method="POST" action="{{ route('post.login') }}">
                                                @csrf
                                                <input type="hidden" name="device_token" id="device_token" value="">
												<h5 class="text-left mb-2">Signin to Your Account</h5>
												<p class="mb-4 text-muted tx-13 ml-0 text-left">Signin to create, discover and connect with the global community</p>
												<div class="form-group text-left">
													<label>Email</label>
													<input class="form-control" placeholder="Type Here" type="text" name="email" value="{{ old('email') }}" required autofocus>
												</div>
												<div class="form-group text-left">
													<label>Password</label>
													<input class="form-control" placeholder="Type Here" type="password" name="password" required>
												</div>
												<button class="btn ripple btn-main-primary btn-block">Sign In</button>
											</form>
											<div class="text-left mt-5 ml-0">
												<div class="mb-1"><a href="{{ route('password.request') }}">Forgot password?</a></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End Row -->

		</div>
		<!-- End Page -->

@endsection
@section('script')
<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
<script>
    var firebaseConfig = {
        apiKey: "AIzaSyDooCwUavodQuFPpLzD0f26csVF0w13rgs",
        authDomain: "manohar-farms.firebaseapp.com",
        projectId: "manohar-farms",
        storageBucket: "manohar-farms.appspot.com",
        messagingSenderId: "336631609177",
        appId: "1:336631609177:web:f48896d90b5ef9fc87be48",
        measurementId: "G-YT4TGQZPKM"
    };
      
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();

    $(document).ready(function(){
        initFirebaseMessagingRegistration();
    });
  
    function initFirebaseMessagingRegistration() {
        messaging.requestPermission().then(function () {
            return messaging.getToken()
        })
        .then(function(token) {
            $('#device_token').val(token);

            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': '{{ csrf_token() }}'
            //     }
            // });

            // $.ajax({
            //     url: '{{ route("save-token") }}',
            //     type: 'POST',
            //     data: {
            //         token: token
            //     },
            //     dataType: 'JSON',
            //     success: function (response) {
            //         alert('Token saved successfully.');
            //     },
            //     error: function (err) {
            //         console.log('User Chat Token Error'+ err);
            //     },
            // });

        }).catch(function (err) {
            console.log('User Chat Token Error'+ err);
        });
    }

    // messaging.onMessage(function(payload) {
    //     const noteTitle = payload.notification.title;
    //     const noteOptions = {
    //         body: payload.notification.body,
    //         icon: payload.notification.icon,
    //     };
    //     new Notification(noteTitle, noteOptions);
    // });
</script>
@endsection
