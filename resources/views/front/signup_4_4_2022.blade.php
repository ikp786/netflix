@extends('front.app_auth_front')

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
    <div class="container text-center">
        <div class="lgn-frm sgn-frm "  id="signup_form_div">
            <h3>Sign Up</h3>
              <form class="signup-form" id="signup_form"> 
                <div id="message_box"></div>

                <input type="hidden" name="country_code" id="country_code" value="91" />
                <input type="hidden" name="country" id="country" value="96" />
                <input type="hidden" name="device_token" id="device_token" value="{{ rand() }}" />

                <input type="text" name="user_name" placeholder="Name">
                <input type="email" name="email" placeholder="Email"> 
                <input type="text" maxlength="12" name="phone" id="mobile-number" class="mobile-no-coun decimal_number"placeholder="" /> 
                
                <select name="" id="country_dt" class="form-control" required >
                    <option value="">Select Country</option>
                     @foreach($get_country as $cat_data)
                        <option value="{{ $cat_data->countries_id }}">{{ ucwords($cat_data->countries_name) }}</option>
                     @endforeach
                </select>

                <!-- <div class="wrapper">
                  <dl id="country-select" class="dropdown">
                    <dt><a href="javascript:void(0);"><span><span style="background-position:0px -1694px"></span><span>India</span><span>+91</span></span></a></dt>
                    <dd>
                      <ul style="display: none;">
                        <li><a cunt_code="+91" href="javascript:void(0);"><span style="background-position:0px -1694px"></span><span>India</span><span>+91</span></a></li>
                        <li><a cunt_code="" href="javascript:void(0);"><span style="background-position:0px -1694px"></span><span>India-Tollfree</span><span></span></a></li>
                        <li><a cunt_code="+1" href="javascript:void(0);"><span style="background-position:0px -44px"></span><span>United States</span><span>+1</span></a></li> 
                      </ul>
                    </dd>
                  </dl>
                </div> -->
                <div class="accept-policy"> <input type="checkbox" id="html"> <p>I agree with Terms & Conditions, Policy</p></div>
                
                <button type="button" id="save_form" data-id="signup_form" data-form_action="signup_api" autofocus class="btn red btn-block uppercase btn_anchor">Sign Up</button>  

              </form>
        </div>
        <div class="lgn-frm otp-frm" id="otp_form_div" >
        <h3>Enter OTP</h3>
          <form class="otp-form" id="otp_form">
              <div id="message_box_otp"></div> 
              @csrf
              <input type="hidden" name="token" id="my_api_token" />
              <div class="otp-frmin">
                <input type="text" id="otp_1" pattern='[0-9]{1}' oninput='digitValidate(this)'  onkeyup='tabChange(1)' maxlength="1" placeholder="0">
                <input type="text" id="otp_2" pattern='[0-9]{1}' oninput='digitValidate(this)'  onkeyup='tabChange(2)' maxlength="1" placeholder="0">
                <input type="text" id="otp_3" pattern='[0-9]{1}' oninput='digitValidate(this)'  onkeyup='tabChange(3)' maxlength="1" placeholder="0">
                <input type="text" id="otp_4" pattern='[0-9]{1}' oninput='digitValidate(this)'  onkeyup='tabChange(4)' maxlength="1" placeholder="0">
              </div> 
              <button type="button" id="save_form_login" data-id="otp_form" data-form_action="otp_verification_for_web" autofocus class="btn red btn-block uppercase btn_anchor">Login</button>

              <button type="button" id="resend_form_login" data-id="login_form" data-form_action="login_api" autofocus class="btn red btn-block uppercase btn_anchor">Resend OTP</button>
              <br/><br/>
          </form>
    </div>
  </div>
@endsection 

@section('script') 
    <script> 
        var URL = '{{url('/')}}'; 

        function setCountry(code){
            if(code || code==''){
                var text = jQuery('a[cunt_code="'+code+'"]').html();
                $(".dropdown dt a span").html(text);
            }
        }

        let digitValidate = function (ele) {
            console.log(ele.value);
            ele.value = ele.value.replace(/[^0-9]/g, '');
        }

       let tabChange = function (val) {
          let ele = document.querySelectorAll('input');
          if (ele[val - 1].value != '') {
            ele[val].focus()
          } else if (ele[val - 1].value == '') {
            ele[val - 2].focus()
          }
        }

        function resend_otp_call(){
        
              var uploadfile = new FormData();

              var country_code  = $('#country_code').val();
              var phone  = $('#mobile-number').val();
              uploadfile.append("country_code",country_code);
              uploadfile.append("phone",phone);

                $.ajax({
                  type:"POST", 
                  url: URL+"/api/resend_otp",
                  data:uploadfile, 
                  enctype: 'multipart/form-data',
                  processData: false,  // Important!
                  contentType: false,
                  cache: false,
                  dataType: "json",
                   
                  success: function(response){  
                      $('#message_box_otp').html('');  
                      if(response.code=='101'  || response.status==false){ // alert('10 call'); 
                          var htt_box = '<span class="danger_msg" >'+response.message+'</span>'; 

                          $('#message_box_otp').html(htt_box);  
                      }else if(response.code=='104'  || response.status==true){  
                          var htt_box = '<span class="success_msg" >'+response.message+' '+response.data.otp_text+'</span>'; 

                          $('#message_box_otp').html(htt_box);

                          setTimeout(function(){      
                                $('#signup_form_div').hide();
                                $('#otp_form_div').show(); 
                                $("#my_api_token").val(response.data.token); 
                          }, 1400);
                      }  
                  }
              }); 

              setTimeout(function(){   
                  $('#message_box_otp').html(''); 
              }, 1500);
}

        $(document).ready(function() {
            
            $('#otp_form_div').hide();
            $('#signup_form_div').show();

            $(".decimal_number").keypress(function(e){   // input number only with decimal value 
                return (e.charCode !=8 && e.charCode ==0 || ( e.charCode == 46 || (e.charCode >= 48 && e.charCode <= 57)))
            });

            $(".mnc").keydown(function (e) { 
              if (e.keyCode == 13) {  
                $("#save_form").click();

                return false;
              }
            });


            $("#save_form").click(function(){    
                form_reload = $(this).data('reload'); 
                form_data_id = $(this).data('id'); 
                form_action = $(this).data('form_action');    
                
                var uploadfile = new FormData($("#"+form_data_id)[0]);

                $.ajax({
                    type:"POST", 
                    url: URL+"/api/"+form_action,
                    data:uploadfile, 
                    enctype: 'multipart/form-data',
                    processData: false,  // Important!
                    contentType: false,
                    cache: false,
                    dataType: "json",
                     
                    success: function(response){  console.log(response);
                        $('#message_box').html('');  
                        if(response.code=='101'  || response.status==false){  alert('false call'); 
                            var htt_box = '<span class="danger_msg" >'+response.message+'</span>'; 
                            $('#message_box').html(htt_box);  
                        }else if(response.code=='104' || response.status==true){   alert('true call');  
                            var htt_box = '<span class="success_msg" >'+response.message+' '+response.data.otp_text+'</span>';
                            $('#message_box').html(htt_box); 

                            setTimeout(function(){    
                                // window.location.href = red_url; 

                                $('#signup_form_div').hide();
                                $('#otp_form_div').show();

                                $("#my_api_token").val(response.data.token);
                                 
                            }, 1400); 
                        }  
                    }
                }); 
            });

            $("#save_form_login").click(function(e){ 

                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('#_token').val()
                    }
                });

                form_data_id = $(this).data('id'); 
                form_action = $(this).data('form_action');    
                var phone  = $('#mobile-number').val();
                var country_code  = $('#country_code').val();

                var otp_1  = $('#otp_1').val();
                var otp_2  = $('#otp_2').val();
                var otp_3  = $('#otp_3').val();
                var otp_4  = $('#otp_4').val();

                var otp = otp_1+''+otp_2+''+otp_3+''+otp_4;
                var uploadfile = new FormData($("#"+form_data_id)[0]);

                uploadfile.append("country_code",country_code);
                uploadfile.append("phone",phone);
                uploadfile.append("otp",otp);

                $.ajax({
                    type:"POST", 
                    url: URL+"/"+form_action,
                    data:uploadfile, 
                    enctype: 'multipart/form-data',
                    processData: false,  // Important!
                    contentType: false,
                    cache: false,
                    dataType: "json",
                     
                    success: function(response){  
                        $('#message_box_otp').html('');  
                        if(response.code=='101' || response.status==false){ 
                            var htt_box = '<span class="danger_msg" >'+response.message+'</span>'; 

                            $('#message_box_otp').html(htt_box);  
                        }else if(response.code=='104' || response.status==true){  
                            var htt_box = '<span class="success_msg" >'+response.message+'</span>'; 

                            $('#message_box_otp').html(htt_box);

                            setTimeout(function(){   
                                red_url = URL+"/fr_profile"; 
                                window.location.href = red_url;  

                            }, 1400);
                        } 
                        setTimeout(function(){   
                             $('#message_box_otp').html(''); 
                        }, 3000);
                    }
                }); 
            });

            $("#resend_form_login").click(function(e){  
                
                 resend_otp_call();

            });




            $(".dropdown img.flag").addClass("flagvisibility");

            $(".dropdown dt a").click(function(){ 
                $(".dropdown dd ul").toggle();
            });

            $(".dropdown dd ul li a").click(function() {  
                //console.log($(this).html())
                var text = $(this).html();
                $(".dropdown dt a span").html(text);
                $(".dropdown dd ul").hide();
                $("#result").html("Selected value is: " + getSelectedValue("country-select"));
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
        });
    </script>
@endsection