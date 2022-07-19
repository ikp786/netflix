@extends('layouts.app_front')
<style>
   .vid_title{
      text-overflow: ellipsis;
      white-space: nowrap;
      overflow: hidden;
      width:100%; 
   }
   .swiper-wrapper{
      height: auto !important;
   }
   .search-box .search-btn {
    width: auto;  
    top: 10px !important;
 } 
 .bar-line:before, .bar-line:after{
   position: absolute;
   display: none;
 }
 .member_submitt{
   width: 100%;
   padding: 4px 35px 34px !important;
   border-radius: 10px !important;
   outline: none !important;
   margin-left: 0.5rem;
   border: 1px solid #FFFB2E !important;
   background-color: #FFFB2E !important;
   color: #303037 !important;
   cursor: pointer !important;
   transition: 0.3s ease-in-out;
   font-size: 20px;
   font-weight: 400;
   min-width: auto !important;
 } 
.plan-view-input{
      padding: 21px 50px !important;
}
.disabled {
  pointer-events: none;
  cursor: default;
}
.watchbtn .ws-title{
   position: relative !important;
   background: transparent !important;
   margin: 0  auto !important;
   bottom: 220px !important; 

} 
.watchbtn .ws-title span{
color: #000000;
display: none;
}
.ws_cover{
   display: none !important;
}
.ws_cover a {
    display: none !important;
}
#wowslider-container1 .ws_images img{
       height: 100% !important;
    width: 100% !important;
    object-fit: cover;
}
.manvendra{
   background: #FFFB2E;
    box-shadow: 0px 3px 15px #00000029;
    border-radius: 8px;
    font: 500 18px/22px Roboto;
    letter-spacing: 1.44px;
    color: #000000 !important;
    text-transform: uppercase;
    padding: 10px 25px;
    height: auto !important;
    width: 150px !important;
    margin: auto !important;
}
.tooltip:hover {
  visibility: hidden !important;
}
</style>

<link rel="stylesheet" type="text/css" href="https://www.jquery-az.com/jquery/css/intlTelInput/intlTelInput.css">
<link rel="stylesheet" type="text/css" href="https://www.jquery-az.com/jquery/css/intlTelInput/demo.css">

@section('content')
   <div class="container-fluid">
             <div id="wowslider-container1">
                <div class="ws_images watchbtn">
                   <ul>
                     @foreach($get_slider_data as $key=> $sl_val)
                        @if($sl_val->slider_image)
                         <li class="call_slider_link" data-link="javascript:void(0)" data-text="Chetan" data-label="Chetan">
                           
                   
                              <a  ><img src="{{ url('uploads/'.$sl_val->slider_image) }}" alt="" title="-" ></a>
                              <a href="{{$sl_val->video_url}}" class="manvendra" >&#x25B6; WATCH</a>
                         </li>                           
                        @endif
                     @endforeach 
                   </ul>
                </div>
             </div>
             <div class='row'>
                <div class='col-md-4'></div>
                <div class='col-md-4'>
                   <div class='search-box'>
                      <!-- <form class='search-form'>
                         <input class='form-control' placeholder='Search by Name or Genres' type='text'>
                         <button class='btn btn-link search-btn'>Search</button>
                      </form> -->

                        <form id="validate" action="{{ url('fr_video_front_search') }}"  class="m-0 form-horizontal search-form'" method="POST" role="form" enctype="multipart/form-data" > 
                              @csrf
                              <input type="hidden" name="filter_by" id="filter_by" value="front_search" />
                              <input type="hidden" name="prev_sub_category_ids" value="" /> 
                              <input type="hidden" name="sub_category_ids"  value="" />
                              <input type="text" name="search_by_name" class="form-control" value="" placeholder="Search by Name or Genres" />
                              <input type="submit" class="btn btn-link search-btn" name="front_search" value="Search"  />
                        </form>

                   </div>
                   <span class="">{{ $get_category_data }}</span>
                </div>
                <div class='col-md-4'></div>
             </div>
          </div>
    <main id="main"> 
      
      <section class="section-property section-t8">
           <div class="container">
              <div class="row">
                 <div class="col-md-12">
                    <div class="title-wrap">
                       <div class="title-box">
                          <h2 class="title-a"> Upcomings</h2>
                       </div>
                    </div>
                 </div>
              </div>
              <div id="property-carousel" class="swiper">
                 <div class="swiper-wrapper">
                     @foreach($get_upcomming_data as $up_val)
                       <div class="carousel-item-b swiper-slide">
                          <div class="card-box-a card-shadow">
                             <div class="img-box-a bar-line"> 
                                 <a  href="{{ url('fr_video_detail').'/'.$up_val->id }}">
                                    @if($up_val->banner_image)
                                      <img class="img-a img-fluid upcoming-videos" src="{{ url('uploads/'.$up_val->banner_image) }}" alt="">
                                    @else
                                       <img class="img-a img-fluid upcoming-videos" src="{{ url('uploads/video/no_video_image.png') }}" alt="">
                                    @endif
                                 </a>
                             </div>
                             <div class="card-overlay">
                                <div class="card-overlay-a-content">
                                   <div class="card-header-a">
                                      <h2 class="card-title-a vid_title">
                                         <a href="{{ url('fr_video_detail').'/'.$up_val->id }}">{{ $up_val->sub_product_title }}</a>
                                      </h2>
                                   </div>
                                </div>
                             </div>
                          </div>
                       </div> 
                     @endforeach  
                 </div>
              </div>
              @if(count($get_upcomming_data)>6)
               <div class="propery-carousel-pagination carousel-pagination"></div>
              @endif
           </div>
         </section>
         
     @if(\Auth::check())

         <section class="section-property section-t8">
           <div class="container">
              <div class="row">
                 <div class="col-md-12">
                    <div class="title-wrap">
                       <div class="title-box">
                          <h2 class="title-a"> Trending</h2>
                       </div>
                    </div>
                 </div>
              </div>
              <div id="property-carousel" class="swiper">
                 <div class="swiper-wrapper">
                     @foreach($get_trending_data as $trending_val)
                       <div class="carousel-item-b swiper-slide">
                          <div class="card-box-a card-shadow">
                             <div class="img-box-a bar-line"> 
                                 <a href="{{ url('fr_video_detail').'/'.$trending_val->id }}">
                                    @if($trending_val->banner_image)
                                      <img class="img-a img-fluid upcoming-videos" src="{{ url('uploads/'.$trending_val->banner_image) }}" alt="">
                                    @else
                                       <img class="img-a img-fluid upcoming-videos" src="{{ url('uploads/video/no_video_image.png') }}" alt="">
                                    @endif
                                 </a>
                             </div>
                             <div class="card-overlay">
                                <div class="card-overlay-a-content">
                                   <div class="card-header-a">
                                      <h2 class="card-title-a vid_title">
                                         <a href="{{ url('fr_video_detail').'/'.$trending_val->id }}">{{ $trending_val->sub_product_title }}</a>
                                      </h2>
                                   </div>
                                </div>
                             </div>
                          </div>
                       </div> 
                     @endforeach  
                 </div>
              </div>
              @if(count($get_trending_data)>6)
               <div class="propery-carousel-pagination carousel-pagination"></div>
              @endif
           </div>
         </section>

         <section class="section-property section-t8">
           <div class="container">
              <div class="row">
                 <div class="col-md-12">
                    <div class="title-wrap">
                       <div class="title-box">
                          <h2 class="title-a"> Popular</h2>
                       </div>
                    </div>
                 </div>
              </div>
              <div id="property-carousel" class="swiper">
                 <div class="swiper-wrapper">
                     @foreach($get_popular_data as $pop_val)
                       <div class="carousel-item-b swiper-slide">
                          <div class="card-box-a card-shadow">
                             <div class="img-box-a bar-line"> 
                                 <a href="{{ url('fr_video_detail').'/'.$pop_val->id }}">
                                    @if($pop_val->banner_image)
                                      <img class="img-a img-fluid upcoming-videos" src="{{ url('uploads/'.$pop_val->banner_image) }}" alt="">
                                    @else
                                       <img class="img-a img-fluid upcoming-videos" src="{{ url('uploads/video/no_video_image.png') }}" alt="">
                                    @endif
                                 </a>
                             </div>
                             <div class="card-overlay">
                                <div class="card-overlay-a-content">
                                   <div class="card-header-a">
                                      <h2 class="card-title-a vid_title">
                                         <a href="{{ url('fr_video_detail').'/'.$pop_val->id }}">{{ $pop_val->sub_product_title }}</a>
                                      </h2>
                                   </div>
                                </div>
                             </div>
                          </div>
                       </div> 
                     @endforeach  
                 </div>
              </div>
              @if(count($get_popular_data)>6)
               <div class="propery-carousel-pagination carousel-pagination"></div>
              @endif
           </div>
         </section>
 
      @else
        <section class="section-agents section-t8">
           <div class="container">
              <div class="row do-prt mt-5">
                 <div class="col-md-6">
                    <h3>One App, Many Devices</h3>
                    <p>Stream unlimited movies and TV shows on your phone, tablet, laptop, and TV.</p>
                    <div class="app-store-icon">
                       <a href="#">
                       <img src="{{ asset('front/assets/img/app-store.svg') }}" class="img-fluid">
                       </a>
                       <a href="https://play.google.com/store">
                       <img src="{{ asset('front/assets/img/google_play.svg') }}" class="img-fluid">
                       </a>
                    </div>
                 </div>
                 <div class="col-md-6">
                    <img src="{{ asset('front/assets/img/bird-bx.png') }}" alt="" class="img-fluid">
                 </div>
              </div>
              <div class="row do-prt mt-5">
                 <div class="col-md-6">
                    <img src="{{ asset('front/assets/img/bird-bx1.png') }}" alt="" class="img-fluid">
                 </div>
                 <div class="col-md-6">
                    <h3>Enjoy Your Favourite Shows.</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam et eros in sapien malesuada sodales nec eu purus. Aliquam venenatis aliquet nisi, dictum tristique lectus faucibus vitae.</p>
                 </div>
              </div>
           </div>
        </section> 
        <section class="mt-5 faq">
           <div class="row mt-5">
              <div class="col-md-12">
                 <h1>Frequently Asked Questions</h1>
              </div>
           </div>
           <div class="row mt-5">
              <div class="col-md-3"></div>
              <div class="col-md-6">
                 <div class="faq-container"> 
                    <div class="faq-label">
                       <div class="faq-label-text">
                          What is Cocrico?
                       </div>
                       <div class="faq-label-icon">
                          <span class="material-icons">
                          <img src="{{ asset('front/assets/img/next.svg') }}" alt="" class="img-fluid">
                          </span>
                       </div>
                    </div>
                    <div class="faq-answer ">
                       <div class="faq-answer-content">
                          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam et eros in sapien malesuada sodales nec eu purus. Aliquam venenatis aliquet nisi, dictum tristique lectus faucibus vitae.
                       </div>
                    </div>
                 </div>
                 <!--2 question-->
                 <div class="faq-container">
                    <div class="faq-label">
                       <div class="faq-label-text">
                          How much does Cocrico cost?
                       </div>
                       <div class="faq-label-icon">
                          <span class="material-icons">
                          <img src="{{ asset('front/assets/img/next.svg') }}" alt="" class="img-fluid">
                          </span>
                       </div>
                    </div>
                    <div class="faq-answer ">
                       <div class="faq-answer-content">
                          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam et eros in sapien malesuada sodales nec eu purus. Aliquam venenatis aliquet nisi, dictum tristique lectus faucibus vitae.
                       </div>
                    </div>
                 </div>
                 <!-- 3 question -->
                 <div class="faq-container">
                    <div class="faq-label">
                       <div class="faq-label-text">
                          How do I cancel?
                       </div>
                       <div class="faq-label-icon">
                          <span class="material-icons">
                          <img src="{{ asset('front/assets/img/next.svg') }}" alt="" class="img-fluid">
                          </span>
                       </div>
                    </div>
                    <div class="faq-answer ">
                       <div class="faq-answer-content">
                          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam et eros in sapien malesuada sodales nec eu purus. Aliquam venenatis aliquet nisi, dictum tristique lectus faucibus vitae.
                          Aliquam venenatis aliquet nisi, dictum tristique lectus faucibus vitae.
                          Aliquam venenatis aliquet nisi, dictum tristique lectus faucibus vitae.
                       </div>
                    </div>
                 </div>
                 <div class="faq-container">
                    <div class="faq-label">
                       <div class="faq-label-text">
                          What can I watch on Cocrico?
                       </div>
                       <div class="faq-label-icon">
                          <span class="material-icons">
                          <img src="{{ asset('front/assets/img/next.svg') }}" alt="" class="img-fluid">
                          </span>
                       </div>
                    </div>
                    <div class="faq-answer ">
                       <div class="faq-answer-content">
                          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam et eros in sapien malesuada sodales nec eu purus. Aliquam venenatis aliquet nisi, dictum tristique lectus faucibus vitae.
                          Aliquam venenatis aliquet nisi, dictum tristique lectus faucibus vitae.
                          Aliquam venenatis aliquet nisi, dictum tristique lectus faucibus vitae.
                       </div>
                    </div>
                 </div>
              </div>
              <div class="col-md-3"></div>
           </div>
        </section>
      @endif 


     <section class="news-ltr">
        <div class="row">
           <div class="col-md-12 text-center">
              <h3>Enter your mobile number to get plans according to you</h3>
              <div class="subscribe mt-3">
                 <form method="POST" action="{{url('fr_membership')}}">
                     @csrf  
                    <input class="plan-view-input decimal_number" type="text" name="phone" id="mobile-number-new" placeholder="Enter Mobile Number" autocomplete="off" maxlength="12" required>
                    <!-- <a href="{{url('fr_membership')}}" >View Plans</a> -->
                    <input type="submit" class="member_submitt w-auto" value="View Plans" />
                 </form>
              </div>
           </div>
        </div>
     </section>

    </main>



    <script src="https://www.jquery-az.com/jquery/js/intlTelInput/intlTelInput.js"></script>
      <script>  
         
         $("#mobile-number-new").intlTelInput({ 
             preferredCountries: [ "tt" ],
             geoIpLookup: function(callback) {
               $.get('http://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                 var countryCode = (resp && resp.country) ? resp.country : "";
                 callback(countryCode);
               });
             },
             utilsScript: "../../build/js/utils.js" // just for formatting/placeholders etc
           });

         

         $(document).ready(function() { 
// #wowslider-container1 .ws_images ul li
            $(".call_slider_link").click(function(){  
               var link = $(this).data('link');
               if(link!="")
                  window.location.href=link;
            }); 

         });

      </script>
   
@endsection

