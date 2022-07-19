<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <img src="{{ url('img/logo.png') }}" style="position: relative;z-index: 999; width: 91px; ">
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header" style="text-align: center; font-size: larger; padding: 29px;" >Verificcation Page</div>

                        <div class="card-body" style="text-align:center;" >

                                @if(session('status'))
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

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>

 
