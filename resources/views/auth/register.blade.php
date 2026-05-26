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
      href="{{ asset('assets/img/apple-icon.png') }}" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}" />
    <title>Register - Velora Hotel</title>
    <!-- Fonts and icons -->
    <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700"
      rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script
      src="https://kit.fontawesome.com/42d5adcbca.js"
      crossorigin="anonymous"></script>
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Main Styling -->
    <link
      href="{{ asset('assets/css/soft-ui-dashboard-tailwind.css?v=1.0.5') }}"
      rel="stylesheet" />
  </head>

  <body
    class="m-0 font-sans antialiased font-normal bg-white text-start text-base leading-default text-slate-500">
    <!-- Navbar -->


    <main class="mt-0 transition-all duration-200 ease-soft-in-out">
      <section class="min-h-screen mb-32">
        <div
          class="relative flex items-start pt-12 pb-56 m-4 overflow-hidden bg-center bg-cover min-h-50-screen rounded-xl"
          style="
            background-image: url('{{ asset('assets/img/curved-images/curved14.jpg') }}');
          ">
          <span
            class="absolute top-0 left-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-gray-900 to-slate-800 opacity-60"></span>
          <div class="container z-10">
            <div class="flex flex-wrap justify-center -mx-3">
              <div
                class="w-full max-w-full px-3 mx-auto mt-0 text-center lg:flex-0 shrink-0 lg:w-5/12">
                <h1 class="mt-12 mb-2 text-white">Welcome!</h1>
                <p class="text-white">
                  Create your account to manage bookings and reservations.
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="container">
          <div class="flex flex-wrap -mx-3 -mt-48 md:-mt-56 lg:-mt-48">
            <div
              class="w-full max-w-full px-3 mx-auto mt-0 md:flex-0 shrink-0 md:w-7/12 lg:w-5/12 xl:w-4/12">
              <div
                class="relative z-0 flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div
                  class="p-6 mb-0 text-center bg-white border-b-0 rounded-t-2xl">
                  <h5>Register</h5>
                </div>

                <div class="flex-auto p-6">
                  <form method="POST" action="{{ route('register') }}" role="form" class="text-left">
                    @csrf
                    <div class="mb-4">
                      <x-input-label for="name" :value="__('Name')" />
                      <x-text-input
                        id="name"
                        name="name"
                        type="text"
                        class="text-sm focus:shadow-soft-primary-outline leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow"
                        :value="old('name')"
                        required
                        autofocus
                        autocomplete="name"
                      />
                      <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="mb-4">
                      <x-input-label for="email" :value="__('Email')" />
                      <x-text-input
                        id="email"
                        name="email"
                        type="email"
                        class="text-sm focus:shadow-soft-primary-outline leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow"
                        :value="old('email')"
                        required
                        autocomplete="username"
                      />
                      <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="mb-4">
                      <x-input-label for="phone" :value="__('Phone')" />
                      <x-text-input
                        id="phone"
                        name="phone"
                        type="tel"
                        class="text-sm focus:shadow-soft-primary-outline leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow"
                        :value="old('phone')"
                        autocomplete="tel"
                      />
                      <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>
                    <div class="mb-4">
                      <x-input-label for="password" :value="__('Password')" />
                      <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="text-sm focus:shadow-soft-primary-outline leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow"
                        required
                        autocomplete="new-password"
                      />
                      <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div class="mb-4">
                      <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                      <x-text-input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        class="text-sm focus:shadow-soft-primary-outline leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow"
                        required
                        autocomplete="new-password"
                      />
                      <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                    <div class="min-h-6 pl-6.92 mb-0.5 block">
                      <input
                        id="terms"
                        name="terms"
                        class="w-4.92 h-4.92 ease-soft -ml-6.92 rounded-1.4 checked:bg-gradient-to-tl checked:from-gray-900 checked:to-slate-800 after:text-xxs after:font-awesome after:duration-250 after:ease-soft-in-out duration-250 relative float-left mt-1 cursor-pointer appearance-none border border-solid border-slate-200 bg-white bg-contain bg-center bg-no-repeat align-top transition-all after:absolute after:flex after:h-full after:w-full after:items-center after:justify-center after:text-white after:opacity-0 after:transition-all after:content-['\f00c'] checked:border-0 checked:border-transparent checked:bg-transparent checked:after:opacity-100"
                        type="checkbox"
                        value="1"
                        @if(old('terms')) checked @endif />
                      <label
                        class="mb-2 ml-1 font-normal cursor-pointer select-none text-sm text-slate-700"
                        for="terms">
                        I agree the
                        <a href="javascript:;" class="font-bold text-slate-700"
                          >Terms and Conditions</a
                        >
                      </label>
                    </div>
                    <div class="text-center">
                      <button
                        type="submit"
                        class="inline-block w-full px-6 py-3 mt-6 mb-2 font-bold text-center text-white uppercase align-middle transition-all border-0 rounded-lg cursor-pointer active:opacity-85 hover:scale-102 hover:shadow-soft-xs leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-gradient-to-tl from-gray-900 to-slate-800 hover:border-slate-700 hover:bg-slate-700 hover:text-white">
                        {{ __('Sign up') }}
                      </button>
                    </div>
                    <p class="mt-4 mb-0 leading-normal text-sm">
                      Already have an account?
                      <a
                        href="{{ route('login') }}"
                        class="font-bold text-slate-700"
                        >Sign in</a
                      >
                    </p>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->

      <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
    </main>
  </body>
  <!-- plugin for scrollbar  -->
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}" async></script>
  <!-- main script file  -->
  <script
    src="{{ asset('assets/js/soft-ui-dashboard-tailwind.js?v=1.0.5') }}"
    async></script>
</html>
