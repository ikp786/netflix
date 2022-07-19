<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link href="{{ asset('front/assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('front/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="https://www.jquery-az.com/jquery/css/intlTelInput/intlTelInput.css">
  <link rel="stylesheet" type="text/css" href="https://www.jquery-az.com/jquery/css/intlTelInput//demo.css">
  <link href="{{ asset('front/assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
  <link href="{{ asset('front/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('front/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('front/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet"> 
  <link href="{{ asset('front/assets/css/style.css') }}" rel="stylesheet"> 
   <link rel="stylesheet" type="text/css" href="{{ asset('front/assets/css/wow-demo-slider.css') }}" />
  
<script>var SITE_URL = 'https://wowslider.com/';</script>
<script type="text/javascript" src="https://wowslider.com/images/demo/jquery.js"></script>

</head>

<body>
<div class="loginp"> 
  <nav class="navbar navbar-default navbar-trans navbar-expand-lg fixed-top">
    <div class="container-fluid">
      <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDefault" aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <a class="navbar-brand text-brand web-logo" href="{{ url('/') }}"><img src="{{ asset('front/assets/img/logo.png') }}" alt=""></a>
      <a class="navbar-brand text-brand mob-logo" href="{{ url('/') }}"><img src="{{ asset('front/assets/img/mob-logo.png') }}" alt=""></a> 
    </div>
  </nav> 
  <main id="main">
      @yield('content')
  </main> 
</div> 
<footer>
 <div class="container">
   <div class="row">
     <div class="col-md-12">
       <nav class="nav-footer">
         <ul class="list-inline"> 
           <li class="list-inline-item">
             <a href="#">Terms & Conditions</a>
           </li>
           <li class="list-inline-item">
             <a href="#">Privacy Policy</a>
           </li>
           <li class="list-inline-item">
             <a href="#">Contact Us</a>
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

<script src="{{ asset('front/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('front/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('front/assets/vendor/php-email-form/validate.js') }}"></script> 
<script src="{{ asset('front/assets/js/main.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://www.jquery-az.com/jquery/js/intlTelInput/intlTelInput.js"></script>
<script> 
     $("#mobile-number").intlTelInput({ 
       preferredCountries: [ "tt" ],
       geoIpLookup: function(callback) {
         $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
           var countryCode = (resp && resp.country) ? resp.country : "";
           callback(countryCode);
         });
       },
       utilsScript: "../../build/js/utils.js" // just for formatting/placeholders etc
     });
</script> 
@yield('script')
</body>

</html>