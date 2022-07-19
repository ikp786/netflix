@extends('layouts.app_front')
<link rel="stylesheet" type="text/css" href="https://www.jquery-az.com/jquery/css/intlTelInput/intlTelInput.css">
  <link rel="stylesheet" type="text/css" href="https://www.jquery-az.com/jquery/css/intlTelInput//demo.css">
<style type="text/css">
  
.dropdown dd, .dropdown dt, .dropdown ul {
  margin: 0px;
  padding: 0px;
}
.dropdown dd ul li a span:first-child, .dropdown dt a span span:first-child {
  background-image: url('https://i.imgur.com/OQiDoZe.png');
  background-repeat: no-repeat;
  width: 16px;
  height: 11px;
  display: inline-block;
  margin:5px;
  vertical-align: top;
}
.dropdown dt a span {
  cursor: pointer;
  display: block;
  padding: 5px;
  white-space: nowrap;
}
.dropdown dt a img {
  position: relative;
  z-index: 1;
}
.dropdown dt a span span:first-child:before {
  position: absolute;
  content: '';
  width: 15px;
  height: 10px;
  box-shadow: 0 1px 1px rgba(0,0,0,0.2) inset;
}
.dropdown dt a span span {
  display: inline-block;
  padding: 0;
}
.dropdown dt a span span:first-child {
  padding: 0;
}
.dropdown dd {
  position: relative;
}
.dropdown a, .dropdown a:visited {
  color: #4a535f;
  text-decoration: none;
  outline: none;
}
.dropdown a:hover {
  color: #5d4617;
}
.dropdown dt a:hover, .dropdown dt a:focus {
  color: #5d4617;
}
.dropdown dt a {
    position: relative;
    background: #282828;
    display: block;
    padding: 7px;
    overflow: hidden;
    width: 100%;
    margin: 0;
    color: #fff;
    text-align: left;
}
 

 
.dropdown dd ul {
  background: #f0f2f7;
  
  color: #C5C0B0;
  display: none;
  left: 0px;
  padding: 5px 0px;
  position: absolute; 
  width: 100%; 
  list-style: none;
  max-height: 170px;
  overflow-y: scroll;
  top:10px;
  z-index: 2;
}

li a {
  font-size:13px;
}

li a span:nth-child(2) {
    line-height: 2em;
}
.dropdown dd ul::-webkit-scrollbar-track {
 -webkit-box-shadow: inset 0 0 1px rgba(0,0,0,0.3);
 border-left:1px solid rgba(0,0,0,0.1);
}
.dropdown dd ul::-webkit-scrollbar-thumb {
 background: rgba(0,0,0,0.4);
/*-webkit-box-shadow: inset 0 0 1px rgba(0,0,0,0.5), 1px 0 0 #5cace9 inset, 2px 0 0 #b3d5ee inset;
    border-radius:10px;*/
}
.dropdown dd ul::-webkit-scrollbar-thumb:window-inactive {
 background: blue;
}
.dropdown span.value {
  display: none;
}
.dropdown dd ul li a {
  padding: 5px;
    display: block;
    font-size: 12px !important;
    margin: 0;
    background: transparent;
    text-align: left;
}
.dropdown dd ul li a:hover {
  background-color: rgba(0,0,0,0.05);
}
dl.dropdown {
  display: inline-block;
  width: 100%;
  margin: -3px 0 0 1px;
}
dl.dropdown span:nth-child(3) {
  color: rgba(0,0,0,0.4)
}
dl.dropdown > span:nth-child(2) {
  overflow: hidden;
  white-space: nowrap;
  display: inline-block;
}
dl.dropdown span:nth-child(3) {
  float: right;
}
dl.dropdown dt span:nth-child(2) {
  color: rgb(255 255 255);
    font-size: 14px;
    font-weight: bold;
    line-height: 1.6em;
}
dl.dropdown dt span:nth-child(3) {
  display: none;
}
.countryFlag {
  padding: 0;
  background-image: url("https://i.imgur.com/OQiDoZe.png");
  background-repeat: no-repeat;
  display: inline-block;
  height: 11px;
  margin-right: 4px;
  width: 16px;
  cursor: pointer;
  white-space: nowrap;
  -moz-border-bottom-colors: none;
  -moz-border-left-colors: none;
  -moz-border-right-colors: none;
  -moz-border-top-colors: none;
  border-color: #BFBFC1 #B6B6B6 #969696;
  border-image: none;
  border-radius: 2px 2px 2px 2px;
  border-style: solid;
  border-width: 1px;
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.09);
} 
  .btn_anchor{
    background: #FFFB2E;
    border-radius: 10px;
    border: none;
    display: block;
    width: 100%;
    padding: 20px;
    color: #000;
    font-size: 18px;
    font-weight: 500;
    margin-top: 25px;
  }
  .danger_msg{
    color: #842029;
  } 
  .lgn-frm{
    margin: auto;
  }
  #country_dt{
    background: #282828;
    color: #fff; 
    border-radius: 10px;
    border: none;
    display: block;
    width: 100%;
    background-position: 20px;
    background-image: none;
    margin-bottom: 20px;
    padding: 14px 17px 18px 20px;
  }
</style>
 
@section('content') 
  <div class="ch-ur-pl" style="margin-top: 73px;" >
    <div class="container text-center" >
        <div class="lgn-frm sgn-frm profile_edit"  id="signup_form_div">
            <h3>Edit Profile</h3>

              <form id="profile_edit_form" action="{{ url('save_profile') }}"  class="form-horizontal comm_form " method="POST" role="form" enctype="multipart/form-data" >
                @csrf   
                @if (\Session::has('success'))
                    <div id="message_box">{!! \Session::get('success') !!}</div> 
                @endif

                <input type="hidden" name="country_code" id="country_code" value="{{ old('country_code') ? old('country_code') : $user->country_code }}" />

                <input type="hidden" name="country_flag_code" id="country_flag_code" value="{{ old('country_flag_code') ? old('country_flag_code') : $user->country_flag_code }}" />

                <input type="text" class="form-control  validate[required]"
                   value="{{ old('name') ? old('name') : $user->name }}"
                   id="name" placeholder="User Name" name="name" autocomplete="off"required >

                <input type="email" class="form-control  validate[required]" value="{{ old('email') ? old('email') : $user->email }}" id="name" placeholder="Email" name="email" autocomplete="off"required >
  
                <input type="text" maxlength="15" name="phone" id="mobile-number" class="mobile-no-coun decimal_number"
                placeholder=""  onblur="myFunctionUserLog()" onkeyup="myFunctionUserLog()" value="{{ old('phone') ? old('phone') : $user->phone }}" placeholder="Phone" required  /> 

                <select name="country" id="country_dt" class="form-control" required >
                    <option value="">Select Country</option>
                     @foreach($get_country as $cat_data)
                        <option {{ (old('country')==$cat_data->countries_id || $cat_data->countries_id==@$user->country) ? "selected" : "" }}  value="{{ $cat_data->countries_id }}">{{ ucwords($cat_data->countries_name) }}</option>
                     @endforeach
                </select>
                <!-- <div class="wrapper">
                  <dl id="country-select" class="dropdown">
                    <dt><a href="javascript:void(0);"><span><span style="background-position:0px -1694px"></span><span>India</span><span>+91</span></span></a></dt>
                    <dd>
                      <ul style="display: none;">
                        @foreach($get_country as $cat_data)
                          <li><a cunt_code="+{{ $cat_data->countries_isd_code }}" href="javascript:void(0);"><span style="background-position:0px -1694px"></span><span>{{ ucwords($cat_data->countries_name) }}</span><span>+{{ $cat_data->countries_isd_code }}</span></a></li>
                        @endforeach
                        <li><a cunt_code="" href="javascript:void(0);"><span style="background-position:0px -1694px"></span><span>India-Tollfree</span><span></span></a></li>
                        <li><a cunt_code="+1" href="javascript:void(0);"><span style="background-position:0px -44px"></span><span>United States</span><span>+1</span></a></li> 
                      </ul>
                    </dd>
                  </dl>
                </div> <br/>--> 
                <input type="file" style="color:white" class="form-control upload-img-file" name="profile_photo_path" >
                @if($user->profile_photo_path) 
                    <img src="{{ url('uploads/'.$user->profile_photo_path) }}" style="width: 150px;" /> 
                @endif 
                <br>

                <button type="submit" class="btn red btn-block uppercase btn_anchor">Submit</button>  

              </form>
        </div> 
  </div>
  </div>
@endsection 

@section('script') 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://www.jquery-az.com/jquery/js/intlTelInput/intlTelInput.js"></script>
    <script> 

      setTimeout(function(){   
           $('#message_box').html(''); 
      }, 8000);

      var URL = '{{url('/')}}'; 

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


      function myFunctionUserLog() { 
            var title =   $('#profile_edit_form').find('.selected-flag').attr("title");
            
            var strArray = title.split("+");      
            var countr_name = strArray[0].trim();
            var countr_code = strArray[1].trim();
             
            $('#country_code').val(countr_code); 

            var title_flag_code =   $('#profile_edit_form').find('.selected-flag').children("div").attr("class");
            var strFlagCodeArray = title_flag_code.split(" ");   

            var country_flag_code = strFlagCodeArray[1];
            $('#country_flag_code').val(country_flag_code); 
            
            console.log('mn='+country_flag_code);
        }  


      

      function setCountry(code){
          if(code || code==''){
              var text = jQuery('a[cunt_code="'+code+'"]').html();
              $(".dropdown dt a span").html(text);
          }
      } 
 
      $(document).ready(function() {  
          $(".dropdown img.flag").addClass("flagvisibility");

            $(".dropdown dt a").click(function(){ 
                $(".dropdown dd ul").toggle();
            }); 

            $(".dropdown dd ul li a").click(function() {  
                //console.log($(this).html())
                var text = $(this).html();
                $(".dropdown dt a span").html(text);
                $(".dropdown dd ul").hide();
                country_sel_id = getSelectedValue("country-select"); alert(country_sel_id);
                $("#result").html("Selected value is: " + country_sel_id);
            });

            function getSelectedValue(id) {
                //console.log(id,$("#" + id).find("dt a span.value").html())
                return $("#" + id).find("dt a span.value").html();
            }

            $(document).bind('click', function(e) {
                var $clicked = $(e.target);
                if (! $clicked.parents().hasClass("dropdown"))
                    $(".dropdown dd ul").hide();
            });


            $("#flagSwitcher").click(function() {
                $(".dropdown img.flag").toggleClass("flagvisibility");
            });

            setTimeout(function(){
              $('.selected-flag .iti-flag').addClass('{{ old('country_flag_code') ? old('country_flag_code') : $user->country_flag_code }}');
            }, 1000);

      });
    </script>
@endsection