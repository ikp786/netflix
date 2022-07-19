@extends('layouts.app_front')

@section('content')     
    <main id="main"> 
         <section class="section-property section-t8">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-3"></div>  
                  <div class="col-md-6">
                    @if(isset($video_data->media_url))
                        <video controls style="width:100%" controlsList="nodownload" >
                          <source src="{{ $video_data->media_url }}" > 
                        </video>
                    @endif 
                  </div> 
                  <div class="col-md-3"></div> 
               </div> 
            </div>
        </section> 
    </main>
@endsection 
