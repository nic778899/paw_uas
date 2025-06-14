<x-layout bodyClass="bg-gray-200">

    {{-- <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <!-- Navbar -->
                <x-navbars.navs.guest signin='login' signup='register'></x-navbars.navs.guest>
                <!-- End Navbar -->
            </div>
        </div>
    </div> --}}
    <style>
        #color-white-social-media-icon {
            color: white
        }
    </style>
    <script src="https://kit.fontawesome.com/ad6b0a25ef.js" crossorigin="anonymous"></script>

    <main class="main-content  mt-0">

        <div class="page-header align-items-start min-vh-100" style="background-image: url('background-image.jpg');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row signin-margin">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                    <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Login</h4>
                                    <div class="row mt-1">
                                        {{-- <h6 class='text-white text-center'>
                                                <span class="font-weight-normal">Email:</span> admin@material.com
                                                <br>
                                                <span class="font-weight-normal">Password:</span> secret</h6> --}}
                                        <p class="text-white text-center" style="margin: 0%">
                                            Aplikasi Absensi</p>
                                        <h6 class="text-white text-center" style="">VIHARA VAJRA
                                            BHUMI
                                            SRIWIJAYA</h6>

                                        <div class="col-2 text-center ms-auto">
                                            <a class="btn btn-link px-3" href="#">
                                                <i class="fa-brands fa-instagram fa-2xl"
                                                    id="color-white-social-media-icon"></i>
                                            </a>
                                        </div>
                                        <div class="col-2 text-center px-1">
                                            <a class="btn btn-link px-3">
                                                <i class="fa-brands fa-facebook-f fa-2xl"
                                                    id="color-white-social-media-icon"></i>
                                            </a>
                                        </div>
                                        <div class="col-2 text-center px-1">
                                            <a class="btn btn-link px-3" href="#">
                                                <i class="fa-brands fa-whatsapp fa-2xl"
                                                    id="color-white-social-media-icon"></i>
                                            </a>
                                        </div>
                                        <div class="col-2 text-center me-auto">
                                            <a class="btn btn-link px-3"
                                                href="https://maps.app.goo.gl/qVu8ktGPDJfZvppk7">
                                                <i class="fa-solid fa-location-dot fa-2xl"
                                                    id="color-white-social-media-icon"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form role="form" method="POST" action="{{ route('login') }}" class="text-start">
                                    @csrf
                                    @if (Session::has('status'))
                                        <div class="alert alert-success alert-dismissible text-white" role="alert">
                                            <span class="text-sm">{{ Session::get('status') }}</span>
                                            <button type="button" class="btn-close text-lg py-3 opacity-10"
                                                data-bs-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ 'admin@material.com' }}">
                                    </div>
                                    @error('email')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label">Kata sandi</label>
                                        <input type="password" class="form-control" name="password"
                                            value='{{ 'secret' }}'>
                                    </div>
                                    @error('password')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                    @enderror
                                    <div class="form-check form-switch d-flex align-items-center my-3">
                                        <input class="form-check-input" type="checkbox" id="rememberMe">
                                        <label class="form-check-label mb-0 ms-2" for="rememberMe">Remember
                                            me</label>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-primary w-100 mb-2">Masuk</button>
                                    </div>
                                    {{-- <p class="mt-4 text-sm text-center">
                                        Belum punya akun?
                                        <a href="{{ route('register') }}"
                                            class="text-primary text-gradient font-weight-bold">Sign up</a>
                                    </p> --}}
                                    <p class="text-sm text-center mt-2">
                                        Lupa kata sandi? pulihkan di
                                        <a href="{{ route('verify') }}"
                                            class="text-primary text-gradient font-weight-bold">sini</a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <x-footers.guest></x-footers.guest> --}}
        </div>
    </main>
    @push('js')
        <script src="{{ asset('assets') }}/js/jquery.min.js"></script>
        <script>
            $(function() {

                var text_val = $(".input-group input").val();
                if (text_val === "") {
                    $(".input-group").removeClass('is-filled');
                } else {
                    $(".input-group").addClass('is-filled');
                }
            });
        </script>
    @endpush
</x-layout>
