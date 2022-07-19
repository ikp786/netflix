<style type="text/css">
    .min-h-screen.flex.flex-col.sm\:justify-center.items-center.pt-6.sm\:pt-0.bg-gray-100 {
        background-size: cover;
    position: absolute;
    height: 100%;
    width: 100%;
    /*background-image: linear-gradient(to bottom right,#18d9c8,#0ecbba);*/
    /*background-image: linear-gradient(to bottom right,#f8f4e8,#f8f4e8) !important;*/
    background-image: url('my_admin/img/Singapore.jpg');
}
.min-h-screen.flex.flex-col.sm\:justify-center.items-center.pt-6.sm\:pt-0.bg-gray-100:after {
    content: "";
    position: absolute;
    background-image: linear-gradient( 
120deg , #f8f4e8, #f8f4e8);
    opacity: .1;
    left: 0;
    width: 100%;
    height: 100%;
    top: 0;
}
.w-full.sm\:max-w-md.mt-6.px-6.py-4.bg-white.shadow-md.overflow-hidden.sm\:rounded-lg {
    z-index: 99999;
    position: relative;
    background: #fff;
}
</style>

<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <img src="{{ url('img/logo.png') }}" style="position: relative;z-index: 999; width: 120px; ">
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif
        @if(Session::has('flash_message')) 
            <div class="alert {{ Session::get('flash_type') }}">
                <button data-dismiss="alert" class="close close-sm" type="button">
                      <i class="icon-remove"></i>
                </button>
                {{ Session::get('flash_message') }} 
            </div> 
        @endif 
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ url('forgot-password') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-jet-button class="ml-4" style="background: #d7cf4a;">
                    {{ __('Log in') }}
                </x-jet-button>
            </div>
            
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
