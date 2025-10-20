<!DOCTYPE html>
<html lang="id" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="{{asset('sneat')}}/assets" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>

    <title>Masuk</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('sneat')}}/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"/>

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{asset('sneat')}}/assets/vendor/fonts/boxicons.css" />
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('sneat')}}/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('sneat')}}/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('sneat')}}/assets/css/demo.css" />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('sneat')}}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <!-- Page CSS -->
    <link rel="stylesheet" href="{{asset('sneat')}}/assets/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="{{asset('sneat')}}/assets/vendor/js/helpers.js"></script>
    <script src="{{asset('sneat')}}/assets/js/config.js"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="{{route('login')}}" class="app-brand-link">
                  <span class="app-brand-logo demo">
                    <i class="menu-icon tf-icons bx bx-book-reader text-primary" style="font-size: 2rem;"></i>
                  </span>
                  <span class="fw-bolder" style="font-size: 1.2rem">Magang Berdampak</span>
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-2">Selamat Datang 🙌</h4>
              <p class="mb-4">Silahkan login untuk Kelola Kegiatan Magang</p>

              @if($errors->has('login_error'))
              <div class="alert alert-danger">
                  {{ $errors->first('login_error') }}
              </div>
              @endif

              <form id="login" class="mb-3" action="{{route('login')}}" method="POST">
                @csrf
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    id="email"
                    name="email"
                    placeholder="Masukkan email"
                    value="{{ old('email') }}"
                    autofocus
                  />
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Password</label>
                  </div>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control @error('password') is-invalid @enderror"
                      name="password"
                      placeholder="Masukkan Password"
                      aria-describedby="password"
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    @error('password')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember-me" name="remember-me" />
                    <div class="d-flex justify-content-between align-items-center w-100">
                      <label class="form-check-label mb-0" for="remember-me"> Ingat Saya </label>
                      <a href="{{route('register')}}" class="ms-auto text-primary" style="font-size: 1rem;">
                        <span>Daftar Sekarang!</span>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
                </div>
              </form>

              <p class="text-center">
                <span>Lupa Kata Sandi?</span>
                <a href="{{route('forgot-password')}}">
                  <span>Ganti Password</span>
                </a>
              </p>
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{asset('sneat')}}/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="{{asset('sneat')}}/assets/vendor/libs/popper/popper.js"></script>
    <script src="{{asset('sneat')}}/assets/vendor/js/bootstrap.js"></script>
    <script src="{{asset('sneat')}}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="{{asset('sneat')}}/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->
    <!-- Vendors JS -->
    <!-- Main JS -->
    <script src="{{asset('sneat')}}/assets/js/main.js"></script>
    <!-- Page JS -->
    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
