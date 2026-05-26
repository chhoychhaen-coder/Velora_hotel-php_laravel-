<!--
=========================================================
* Soft UI Dashboard Tailwind - v1.0.5
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard-tailwind
* Copyright 2023 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="apple-touch-icon"
      sizes="76x76"
      href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
    <title>Soft UI Dashboard Tailwind</title>
    <!-- Fonts and icons -->
    <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700"
      rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script
      src="https://kit.fontawesome.com/42d5adcbca.js"
      crossorigin="anonymous"></script>
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Main Styling -->
    <link
      href="../assets/css/soft-ui-dashboard-tailwind.css?v=1.0.5"
      rel="stylesheet" />

    <!-- Nepcha Analytics (nepcha.com) -->
    <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
    <script
      defer
      data-site="YOUR_DOMAIN_HERE"
      src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
  </head>

  <body
    class="m-0 font-sans antialiased font-normal bg-white text-start text-base leading-default text-slate-500">
    <div class="container sticky top-0 z-sticky">
      <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3 flex-0">
          <!-- Navbar -->

        </div>
      </div>
    </div>
    <main class="mt-0 transition-all duration-200 ease-soft-in-out">
      <section>
        <div
          class="relative flex items-center p-0 overflow-hidden bg-center bg-cover min-h-75-screen">
          <div class="container z-10">
            <div class="flex flex-wrap mt-0 -mx-3">
              <div
                class="flex flex-col w-full max-w-full px-3 mx-auto md:flex-0 shrink-0 md:w-6/12 lg:w-5/12 xl:w-4/12">
                <div
                  class="relative flex flex-col min-w-0 mt-32 break-words bg-transparent border-0 shadow-none rounded-2xl bg-clip-border">
                  <div
                    class="p-6 pb-0 mb-0 bg-transparent border-b-0 rounded-t-2xl">
                    <h3
                      class="relative z-10 font-bold text-transparent bg-gradient-to-tl from-blue-600 to-cyan-400 bg-clip-text">
                      Welcome back
                    </h3>
                    <p class="mb-0">Enter your email and password to sign in</p>
                  </div>
                  <div class="flex-auto p-6">
                    <form method="POST" action="{{ route('login') }}" role="form">
                      @csrf
                     <div class="mb-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input
                            id="email"
                            class="block mt-1 w-full focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft appearance-none rounded-lg border border-gray-300 bg-white px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus
                            autocomplete="username"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                     </div>
                      <x-input-label for="password" :value="__('Password')" class="mb-2 ml-1 font-bold text-xs text-slate-700" />
                      <div class="mb-4">
                        <x-text-input
                            id="password"
                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                      </div>
                      <div class="min-h-6 mb-0.5 block pl-12">
                        <input
                          id="rememberMe"
                          name="remember"
                          value="1"
                          class="mt-0.54 rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.25 h-5 relative float-left -ml-12 w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right"
                          type="checkbox"
                          @if(old('remember')) checked @endif />
                        <label
                          class="mb-2 ml-1 font-normal cursor-pointer select-none text-sm text-slate-700"
                          for="rememberMe"
                          >{{ __('Remember me') }}</label
                        >
                      </div>
                    <div class="flex items-center justify-between mt-6">

                        @if (Route::has('password.request'))
                            <a
                                class="text-sm text-gray-600 hover:text-blue-600 transition"
                                href="{{ route('password.request') }}"
                            >
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <x-primary-button
                            class="px-6 py-3 font-bold text-white uppercase rounded-lg shadow-soft-md bg-gradient-to-tl from-blue-600 to-cyan-400 hover:scale-105 hover:shadow-soft-xs transition-all"
                        >
                            {{ __('Sign in') }}
                        </x-primary-button>

                    </div>
                    </form>
                  </div>
                  <div
                    class="p-6 px-1 pt-0 text-center bg-transparent border-t-0 border-t-solid rounded-b-2xl lg:px-2">
                    <p class="mx-auto mb-6 leading-normal text-sm">
                      Don't have an account?
                      <a
                        href="{{ route('register') }}"
                        class="relative z-10 font-semibold text-transparent bg-gradient-to-tl from-blue-600 to-cyan-400 bg-clip-text"
                        >Sign up</a
                      >
                    </p>
                  </div>
                </div>
              </div>
              <div class="w-full max-w-full px-3 lg:flex-0 shrink-0 md:w-6/12">
                <div
                  class="absolute top-0 hidden w-3/5 h-full -mr-32 overflow-hidden -skew-x-10 -right-40 rounded-bl-xl md:block">
                  <div
                    class="absolute inset-x-0 top-0 z-0 h-full -ml-16 bg-cover skew-x-10"
                    style="
                      background-image: url('../assets/img/curved-images/curved6.jpg');
                    "></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>

  </body>
  <!-- plugin for scrollbar  -->
  <script src="../assets/js/plugins/perfect-scrollbar.min.js" async></script>
  <!-- main script file  -->
  <script
    src="../assets/js/soft-ui-dashboard-tailwind.js?v=1.0.5"
    async></script>
</html>
