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
            <div class="row flex-center min-vh-100 py-6">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4"><a class="d-flex flex-center mb-4"
                        href="../../../index.html"><img class="me-2"
                            src="{{ asset('asset/public/assets/img/icons/spot-illustrations/falcon.png') }}" alt=""
                            width="58" /><span class="font-sans-serif fw-bolder fs-5 d-inline-block">falcon</span></a>
                    <div class="card">
                        <div class="card-body p-4 p-sm-5">
                            <h5 class="text-center">Reset new password</h5>
                            <form class="mt-3" action="{{ route('reset.password.post') }}" method="POST">
                                @csrf
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

                                <!-- Hidden field for token -->
                                <input type="hidden" name="token" value="{{ $token }}">

                                <!-- New Password -->
                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <input class="form-control" type="password" name="new_password"
                                        placeholder="New Password" required />
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input class="form-control" type="password" name="new_password_confirmation"
                                        placeholder="Confirm Password" required />
                                </div>

                                <button class="btn btn-primary d-block w-100 mt-3" type="submit">Set Password</button>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
