<style type="text/css">
    .min-h-screen.flex.flex-col.sm\:justify-center.items-center.pt-6.sm\:pt-0.bg-gray-100 {
        background-size: cover;
    position: absolute;
    height: 100%;
    width: 100%;
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
button.inline-flex.items-center.px-4.py-2.bg-gray-800.border.border-transparent.rounded-md.font-semibold.text-xs.text-white.uppercase.tracking-widest.hover\:bg-gray-700.active\:bg-gray-900.focus\:outline-none.focus\:border-gray-900.focus\:ring.focus\:ring-gray-300.disabled\:opacity-25.transition {
    background: #d7cf4a;
}
</style>

<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo"> 
            <img src="{{ url('img/logo.png') }}" style="position: relative;z-index: 999; width: 120px; ">
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ url('forgot-password') }}">
            @csrf

            <div class="block">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button>
                    {{ __('Email Password Reset Link') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
