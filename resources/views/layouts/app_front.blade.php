<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">  
        <title>{{ config('app.name', 'Laravel') }}</title> 
 
          <link href="{{ asset('img/favicon.png') }}" rel="icon" >
          <link href="{{ asset('front/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon" >
 
          <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet" > 
          <link href="{{ asset('front/assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet" >
          <link href="{{ asset('front/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" >
          <link href="{{ asset('front/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" >
          <link href="{{ asset('front/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet" > 
          <link href="{{ asset('front/assets/css/style.css') }}" rel="stylesheet"> 
           <link rel="stylesheet" type="text/css" href="{{ asset('front/assets/css/wow-demo-slider.css') }}" />
        
        <script>var SITE_URL = 'https://wowslider.com/';</script>
        <script type="text/javascript" src="https://wowslider.com/images/demo/jquery.js"></script> 
        <style type="text/css">
           .vid_title_cat{
               padding: 2px;
               text-overflow: ellipsis;
               white-space: nowrap;
               overflow: hidden;
               width:100%; 
           }
           .category_search-btn button{
               padding: 8px 7px;
           }
        </style>
    </head>
    <body> 
          <div class="click-closed"></div>
          <div class="box-collapse srch">
             <span class="close-box-collapse right-boxed bi bi-x"></span>
             <div class="box-collapse-wrap form" style="overflow-y: hidden;">
              
                   <div class="row">
                      <div class="col-md-12  mb-2">
                         <div class="form-group">
                            <input type="text" id="find_title" class="form-control form-control-lg form-control-a" placeholder="Search by title...">
                         </div>
                      </div>


                      <section class="section-property section-t8 p-0 m-3 mr-0 ml-0">
                        <div class="row">
                           <div class="col-md-12 pl-0">
                              <div class="title-wrap p-0">
                                <div class="title-box">
                                 <label class="m-0">Browse by</label>
                                </div>
                             </div> 
                           </div>
                        </div>
                       <div class="container mt-4 p-0  "> 
                          <div id="property-carousel" class="swiper">
                             <div class="swiper-wrapper">      
                                   @php
                                    $get_sb_cat = App\Models\Product::orderBy('product_name','asc')->where(['status'=>'1'])->get();
                                   @endphp 
                                   @foreach($get_sb_cat as $subb_dt)  
                                      <div class="carousel-item-b swiper-slide">
                                         <div class="col-md-12 tags  category_search-btn mt-0">  
                                             <button type="button" class="btn check_search_cat_pre vid_title_cat" data-id="{{ $subb_dt->id }}" >{{ $subb_dt->product_name }}</button>

                                        </div>
                                      </div> 
                                   @endforeach 

                             </div>
                          </div>
                       </div>
                    </section>


                     <!--  <div class="col-md-12 tags">
                         <label>Browse by</label>
                         @php
                           $get_sb_cat = App\Models\Product::orderBy('product_name','asc')->where(['status'=>'1'])->get();
                         @endphp 
                         @foreach($get_sb_cat as $subb_dt) 
                           <button type="button" class="btn check_search_cat_pre" data-id="{{ $subb_dt->id }}" >{{ $subb_dt->product_name }}</button>
                         @endforeach 
                      </div> -->
                      <ul id="search_vd_list_div" class="searech-list-title" style="max-height: 50vh; overflow-y: scroll;">
                      </ul>
                   </div>
                 
             </div>
          </div>
          
          <form action="{{ url('fr_video') }}"  class="form-horizontal comm_form" id="cat_search_form" method="POST" role="form" enctype="multipart/form-data" > 
         @csrf
            <input type="hidden" name="filter_by" id="filter_by" value="category_search" />
            <input type="hidden" name="prev_sub_category_ids" id="prev_sub_category_ids" value="" />

            <input type="hidden" name="sub_category_ids" id="search_by_sub_cat_id" value="" />
            <input type="hidden" name="search_by_name" id="search_by_name" value="" />
            <!-- <input type="submit" name="submitt" /> -->
         </form>


          @include('layouts.top_nav')
  
          @yield('content')

        <footer>
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <nav class="nav-footer">
                     <ul class="list-inline">
                        <li class="list-inline-item">
                           <a href="{{ url('fr_page/1') }}">Terms & Conditions</a>
                        </li>
                        <li class="list-inline-item">
                           <a href="{{ url('fr_page/2') }}">Privacy Policy</a>
                        </li>
                        <li class="list-inline-item">
                           <a href="{{ url('fr_contact') }}">Contact Us</a>
                        </li>
                     </ul>
                  </nav>
                  <div class="copyright-footer">
                     <p class="copyright color-text-a">
                        &copy; Copyright Cocrico All Rights Reserved.
                     </p>
                  </div>
               </div>
            </div>
         </div>
        </footer>
        <div id="preloader"></div>
        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
        <script type="text/javascript" src="{{ asset('front/assets/js/wowslider.js') }}"></script>
        <script type="text/javascript">
         jQuery('#wowslider-container1').wowSlider({
             effect:"carousel", 
             prev:"", 
             next:"", 
             duration: 20*100, 
             delay:20*100, 
             width:960,
             height:360,
             autoPlay:true,
             autoPlayVideo:false,
             playPause:false,
             stopOnHover:false,
             loop:false,
             bullets:1,
             caption: true, 
             captionEffect:"fade",
             controls:true,
             responsive:2,
             fullScreen:false,
             gestures: 2,
             onBeforeStep:0,
             images:0
         });
      </script> 
      <script src="{{ asset('front/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('front/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
      <script src="{{ asset('front/assets/vendor/php-email-form/validate.js') }}"></script>
      <script src="{{ asset('front/assets/js/main.js') }}"></script>
      <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
       
      <script> 
         let faqLabel=document.querySelectorAll(".faq-label");
         faqLabel.forEach(item=>item.onclick=()=>{ 
             item.nextElementSibling.classList.toggle('active');    
             let labelIcon=item.lastElementChild;
             let icons=labelIcon.lastElementChild;
             icons.classList.toggle('rotate');
         })

         $(document).ready(function() {  
            var dataselected = "";
            var URL = '{{url('/')}}'; 

            $(".decimal_number").keypress(function(e){   // input number only with decimal value 
                return (e.charCode !=8 && e.charCode ==0 || ( e.charCode == 46 || (e.charCode >= 48 && e.charCode <= 57)))
            });
            
            $(".check_login").click(function(){    
               var is_auth_user = $('#is_auth_user').val();
               if(is_auth_user==""){
                  Swal.fire({
                    title: 'Error!',
                    text: 'Please Login Your Account',
                    icon: 'error',
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#ffc107', 
                  }) 
                  return false;
               } 
            });

             /*$("#mobile-number-new").intlTelInput({ 
                preferredCountries: [ "tt" ],
                geoIpLookup: function(callback) {
                  $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    callback(countryCode);
                  });
                },
                utilsScript: "../../build/js/utils.js" // just for formatting/placeholders etc
              });*/

            $("#search_by_all").click(function(){   
               $("#filter_by").val("search_by_all");
               prev_cat_ids = $('#prev_sub_category_ids').val();   
               if(prev_cat_ids!='') 
                  $("#cat_search_form").submit();

               return false;
            });

            $("#submit_sub_cat_search").click(function(){   
               cat_ids = $('#prev_sub_category_ids').val();   
               $('#search_by_sub_cat_id').val(cat_ids);
               if(cat_ids!='') 
                  $("#cat_search_form").submit();

               return false;
            });

            $(".check_search_cat").click(function(){    
               cat_ids = $(this).data('id');   
               
               $('#search_by_sub_cat_id').val(cat_ids);
               $("#cat_search_form").submit();

               return false;
            });

            $(".check_search_cat_pre").click(function(){    
               cat_ids = $(this).data('id');   
               $('#prev_sub_category_ids').val(cat_ids);
               $('#search_by_sub_cat_id').val(cat_ids);
               $("#cat_search_form").submit();

               return false;
            });

            $("#find_title").keyup(function (e) {  
               var mnn = $('#find_title').val();
               
               // $('#search_by_name').val(mnn);

               $.ajaxSetup({
                   headers: { 
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   }
               }); 
 
               var form_data = new FormData();
               form_data.append("search_term",mnn); 
                 
                $.ajax({
                    type:"POST", 
                    url: URL+"/get_search_video_list",
                    data:form_data, 
                    enctype: 'multipart/form-data',
                    processData: false,  // Important!
                    contentType: false,
                    cache: false,
                    dataType: "JSON", 
                    success: function(response){    
                        $('#search_vd_list_div').empty(); 
                        htm ='';
                        if(response.data.length>0){   
                           for(i=0;i<response.data.length;i++){
                                 htm +='<li style="padding:9px">'+
                                    '<a href="'+URL+'/fr_video_detail/'+response.data[i].video_id+'">'+
                                        '<div style="float:left">'+
                                           '<img  src="'+response.data[i].banner_image+'" />'+
                                        '</div>'+
                                        '<div style="margin-top: 20px;">'+response.data[i].video_name+'</div>'+
                                     '</a>'+
                                  '</li>';
                           }
                            $('#search_vd_list_div').append(htm); 
                        }else{
                            htm = '<li> No record found </li>';
                            $('#search_vd_list_div').html(htm); 
                        }
                    }
               });

            });

            /*$("#find_title").keydown(function (e) { 
              if(e.keyCode == 13) {  
                $("#cat_search_form").submit();

                return false;
              }
            });*/
         });
      </script>
      @yield('script')
   </body>
</html>
