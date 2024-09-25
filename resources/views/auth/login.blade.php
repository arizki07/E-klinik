@extends('layouts.main_auth')
@section('content_auth')
    <main class="main" id="top">
        <div class="container-fluid">
            <div class="row min-vh-100 flex-center g-0">
                <div class="col-lg-8 col-xxl-5 py-3 position-relative"><img class="bg-auth-circle-shape"
                        src="asset/public/assets/img/icons/spot-illustrations/bg-shape.png" alt="" width="250"><img
                        class="bg-auth-circle-shape-2" src="asset/public/assets/img/icons/spot-illustrations/shape-1.png"
                        alt="" width="150">
                    <div class="card overflow-hidden z-index-1">
                        <div class="card-body p-0">
                            <div class="row g-0 h-100">
                                <div class="col-md-5 text-center bg-card-gradient">
                                    <div class="position-relative p-4 pt-md-5 pb-md-7 light">
                                        <div class="bg-holder bg-auth-card-shape"
                                            style="background-image:url(asset/public/assets/img/icons/spot-illustrations/half-circle.png);">
                                        </div>
                                        <!--/.bg-holder-->

                                        <div class="z-index-1 position-relative"><a
                                                class="link-light mb-4 font-sans-serif fs-4 d-inline-block fw-bolder"
                                                href="asset/public/index.html">falcon</a>
                                            <p class="opacity-75 text-white">With the power of Falcon, you can now focus
                                                only on functionaries for your digital products, while leaving the UI
                                                design on us!</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 mb-4 mt-md-4 mb-md-5 light">
                                        <p class="text-white">Don't have an account?<br><a
                                                class="text-decoration-underline link-light"
                                                href="{{ route('register') }}">Get started!</a>
                                        </p>
                                        <p class="mb-0 mt-4 mt-md-5 fs--1 fw-semi-bold text-white opacity-75">Read our
                                            <a class="text-decoration-underline text-white" href="#!">terms</a> and
                                            <a class="text-decoration-underline text-white" href="#!">conditions
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-7 d-flex flex-center">
                                    <div class="p-4 p-md-5 flex-grow-1">
                                        <div class="row flex-between-center">
                                            <div class="col-auto">
                                                <h3>Account Login</h3>
                                            </div>
                                        </div>
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
                                        <form action="{{ route('log.authenticate') }}" method="post" name="handleAjax"
                                            id="handleAjax">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label" for="card-email">Email address</label>
                                                <input type="text" name="email" id="email" class="form-control"
                                                    placeholder="Masukkan Email" autofocus="true">
                                                @if ($errors->has('email'))
                                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between">
                                                    <label class="form-label" for="card-password">Password</label>
                                                </div>
                                                <input type="password" name="password" id="password" class="form-control"
                                                    placeholder="Masukkan password">
                                                @if ($errors->has('password'))
                                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                                @endif
                                            </div>
                                            <div class="row flex-between-center">
                                                <div class="col-auto">
                                                    <div class="form-check mb-0">
                                                        <input class="form-check-input" type="checkbox" name="remember"
                                                            id="card-checkbox" checked="checked" />
                                                        <label class="form-check-label mb-0" for="card-checkbox">Remember
                                                            me</label>
                                                    </div>
                                                </div>
                                                <div class="col-auto"><a class="fs--1" href="{{ url('forgot') }}">Forgot
                                                        Password?</a></div>
                                            </div>
                                            <div class="mb-3">
                                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                                    id="submitLogin">Log in</button>
                                            </div>
                                        </form>
                                        <div class="position-relative mt-4">
                                            <hr class="bg-300" />
                                            <div class="divider-content-center">or log in with</div>
                                        </div>
                                        <div class="row g-2 mt-2">
                                            <div class="col-sm-6"><a
                                                    class="btn btn-outline-google-plus btn-sm d-block w-100"
                                                    href="#"><span class="fab fa-google-plus-g me-2"
                                                        data-fa-transform="grow-8"></span> google</a></div>
                                            <div class="col-sm-6"><a class="btn btn-outline-facebook btn-sm d-block w-100"
                                                    href="#"><span class="fab fa-facebook-square me-2"
                                                        data-fa-transform="grow-8"></span> facebook</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="{{ asset('asset/public/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('asset/public/jquery.validate.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            /*------------------------------------------==============================================================================================================================================================
            --------------------------------------------==============================================================================================================================================================
            Ajax Login
            --------------------------------------------==============================================================================================================================================================
            --------------------------------------------==============================================================================================================================================================*/

            if ($("#handleAjax").length > 0) {
                $("#handleAjax").validate({
                    rules: {
                        email: {
                            required: true,
                        },
                        password: {
                            required: true,
                        },
                    },
                    messages: {
                        email: {
                            required: "Email tidak boleh kosong",
                        },
                        password: {
                            required: "Password tidak boleh kosong",
                        },
                    },

                    submitHandler: function(form) {

                        $('#submitLogin').html(
                            '<span class="spinner-border spinner-border-sm me-2" role="status"></span> Please Wait<span class="animated-dots"></span>'
                        );
                        $("#submitLogin").attr("disabled", true);


                        $.ajax({
                            url: $(form).attr('action'),
                            data: $(form).serialize(),
                            type: "POST",
                            dataType: 'json',

                            success: function(data) {

                                if (data.status) {
                                    $('#submitLogin').html(
                                        '<span class="spinner-border spinner-border-sm me-2" role="status"></span> Redirect to Dashboard<span class="animated-dots"></span>'
                                    );
                                    window.location = data.redirect;
                                } else {

                                    $('#submitLogin').html('Login');
                                    $("#submitLogin").attr("disabled", false);
                                    $('#email').focus();

                                    $(".alert").remove();
                                    $.each(data.errors, function(key, val) {
                                        $("#errors-list").append(
                                            "<div class='alert  alert-danger alert-dismissible' role='alert'><div class='d-flex'><div><svg xmlns='http://www.w3.org/2000/svg' class='icon alert-icon' width='24' height='24' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'></path><path d='M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0'></path><path d='M12 8v4'></path><path d='M12 16h.01'></path></svg></div><div><h4 class='alert-title'>" +
                                            data.header +
                                            "</h4><div class='text-secondary'>" +
                                            val +
                                            "</div></div></div><a class='btn-close' data-bs-dismiss='alert' aria-label='close'></a></div>"
                                        );
                                    });
                                }

                            },
                        });
                    }
                })
            }

            /*------------------------------------------==============================================================================================================================================================
            --------------------------------------------==============================================================================================================================================================
            End Ajax
            --------------------------------------------==============================================================================================================================================================
            --------------------------------------------==============================================================================================================================================================*/
        });
    </script>
@endsection
