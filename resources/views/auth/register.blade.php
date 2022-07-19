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
120deg , #000000, #18D9C8);
    opacity: .6;
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
    background: #16d9c8;
}
</style>

<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
           <img src="{{ url('img/logo.png') }}" style="position: relative;z-index: 999; width: 91px; ">
        </x-slot>

        <x-jet-validation-errors class="mb-4" />
        @if(Session::has('flash_message')) 
            <div class="alert {{ Session::get('flash_type') }}">
                <button data-dismiss="alert" class="close close-sm" type="button">
                      <i class="icon-remove"></i>
                </button>
                {{ Session::get('flash_message') }} 
            </div> 
        @endif 
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>
            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Phone') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
            </div>    
            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms"/>

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
