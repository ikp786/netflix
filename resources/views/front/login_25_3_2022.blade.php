@extends('front.app_auth_front')
<style>
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
</style> 
@section('content') 


  <div class="container text-center">
    <div class="lgn-frm"  id="login_form_div">
        <h3>Login</h3>
          <form class="login-form" id="login_form">
              <div id="message_box"></div>
              <input type="hidden" name="country_code" id="country_code" value="91" />
             <input type="number" id="mobile-number" class="mobile-no-coun decimal_number" name="phone" placeholder="+91 Mobile Number">
          <!--   <input type="email" name="email" id="email" placeholder="Mobile Number"> -->
            
            <button type="button" id="save_form" data-id="login_form" data-form_action="login_api" autofocus class="btn red btn-block uppercase btn_anchor">Continue</button> 
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
              <br/><br/>
          </form>
    </div>

  </div>
 
@endsection 
@section('script') 
    <script>
        $(document).ready(function (){

            var URL = '{{url('/')}}'; 
 
            /*setTimeout(function(){  
               $('#message_box').html(""); 
               $('.help-block').remove();
               $('.help-block').html('');
            }, 8000); */  

            $('#otp_form_div').hide();
            $('#login_form_div').show();

            $(".decimal_number").keypress(function(e){   // input number only with decimal value 
                return (e.charCode !=8 && e.charCode ==0 || ( e.charCode == 46 || (e.charCode >= 48 && e.charCode <= 57)))
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
                     
                    success: function(response){  
                        $('#message_box').html('');  
                        if(response.code=='101'){ // alert('10 call'); 
                            var htt_box = '<span class="danger_msg" >'+response.message+'</span>'; 

                            $('#message_box').html(htt_box);  
                        }else if(response.code=='104'){  
                            var htt_box = '<span class="success_msg" >'+response.message+' '+response.data.otp_text+'</span>'; 

                            $('#message_box').html(htt_box);

                            setTimeout(function(){    
                                // window.location.href = red_url; 

                                $('#login_form_div').hide();
                                $('#otp_form_div').show();

                                $("#my_api_token").val(response.data.token);
                                 
                            }, 1400);
                        } 
                        setTimeout(function(){   
                           //  $('#message_box').html(''); 
                        }, 3000);
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

                var otp_1  = $('#otp_1').val();
                var otp_2  = $('#otp_2').val();
                var otp_3  = $('#otp_3').val();
                var otp_4  = $('#otp_4').val();

                var otp = otp_1+''+otp_2+''+otp_3+''+otp_4;
                var uploadfile = new FormData($("#"+form_data_id)[0]);

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

        });


    </script>
@endsection
     
    