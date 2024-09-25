@extends('layouts.main_auth')
@section('content_auth')
    <main class="main" id="top">
        <div class="container" data-layout="container">
            <script>
                var isFluid = JSON.parse(localStorage.getItem('isFluid'));
                if (isFluid) {
                    var container = document.querySelector('[data-layout]');
                    container.classList.remove('container');
                    container.classList.add('container-fluid');
                }
            </script>
            <div class="row flex-center min-vh-100 py-6 text-center">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4"><a class="d-flex flex-center mb-4"
                        href="../../../index.html"><img class="me-2"
                            src="../../../assets/img/icons/spot-illustrations/falcon.png" alt=""
                            width="58" /><span class="font-sans-serif fw-bolder fs-5 d-inline-block">falcon</span></a>
                    <div class="card">
                        <div class="card-body p-4 p-sm-5">
                            <h5 class="mb-0">Your Otp</h5><small>Enter the OTP code that is already in your
                                email.</small>
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form class="mt-4" action="{{ route('otp.verify') }}" method="POST">
                                @csrf
                                <input class="form-control" type="text" name="otp" placeholder="Enter OTP"
                                    required />
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit">Verify OTP</button>
                            </form><a class="fs--1 text-600" href="#!">Thank you for verifying<span
                                    class="d-inline-block ms-1">&rarr;</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
