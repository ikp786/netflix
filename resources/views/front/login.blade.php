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
  .resend-top-button{
        background: transparent !important;
    color: #fff !important;
    padding: 0 !important;
    margin: 0 !important;
    font-size: 13px !!important;
    text-decoration: underline !important;
  }
   .btn-check:focus+.btn, .btn:focus {
      outline: 0;
      box-shadow: none !important;
  }
</style> 
@section('content') 
  <div class="container text-center">
    <div class="lgn-frm"  id="login_form_div">
        <h3>Login</h3>
          <form class="login-form" id="login_form">
              <div id="message_box"></div>

             <input type="hidden" name="country_code" id="country_code" value="" />
             <input type="hidden" name="country_flag_code" id="country_flag_code" value="" />

             <input type="text" maxlength="15"  onfocus="myFunctionUserLog()" id="mobile-number" class="mobile-no-coun decimal_number mnc" name="phone" placeholder="Mobile Number">
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
                <input type="number" pattern="[0-9]*" id="otp_1" class="decimal_number otp_box"  data-id="2" maxlength="1" placeholder="0">
                <input type="number" pattern="[0-9]*" id="otp_2" class="decimal_number otp_box"  data-id="3" maxlength="1" placeholder="0">
                <input type="number" pattern="[0-9]*" id="otp_3" class="decimal_number otp_box"  data-id="4" maxlength="1" placeholder="0">
                <input type="number" pattern="[0-9]*" id="otp_4" class="decimal_number otp_box"  data-id="1" maxlength="1" placeholder="0">
              </div> 
              <button type="button" id="save_form_login" data-id="otp_form" data-form_action="otp_verification_for_web" autofocus class="btn red btn-block uppercase btn_anchor">Login</button>

              <button type="button" id="resend_form_login" data-id="login_form" data-form_action="login_api" autofocus class="btn red btn-block uppercase btn_anchor resend-top-button">Resend OTP</button>
              <br/><br/>
          </form>
    </div>

  </div>
 
@endsection 
@section('script') 
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        function myFunctionUserLog() { 
            var title =   $('#login_form').find('.selected-flag').attr("title");                
            var strArray = title.split("+");              
            $('#country_code').val(strArray[1].trim()); 

            var title_flag_code =   $('#login_form').find('.selected-flag').children("div").attr("class");
            var strFlagCodeArray = title_flag_code.split(" "); 

            var country_flag_code = strFlagCodeArray[1];
            $('#country_flag_code').val(country_flag_code); 
        }  

        function otp_auto_input(otp_text){
            otp_output = []; 
            for (var i = 0, len = otp_text.length; i < len; i += 1) {
                otp_output.push(+otp_text.charAt(i));
            }   
            $('#otp_1').val(otp_output[0]);
            $('#otp_2').val(otp_output[1]);
            $('#otp_3').val(otp_output[2]);
            $('#otp_4').val(otp_output[3]);
        }

        $(document).ready(function (){

            var URL = '{{url('/')}}'; 
             
            $('#otp_form_div').hide();
            $('#login_form_div').show();

            $(".decimal_number").keypress(function(e){   // input number only with decimal value 
                return (e.charCode !=8 && e.charCode ==0 || ( e.charCode == 46 || (e.charCode >= 48 && e.charCode <= 57)))
            });

            $(".otp_box").keyup(function(e){  
                curr_val = $(this).val();
                if(e.key>=0 || e.key<=9){
                    $(this).val(e.key);
                    nid = $(this).data('id');
                    $('#otp_'+nid).focus();  
                }
            });

            


            $(".mnc").keydown(function (e) { 
              if (e.keyCode == 13) {  
                $("#save_form").click();

                return false;
              }
            });

            $("#otp_4").keydown(function (e) { 
              if (e.keyCode == 13) {  
                $("#save_form_login").click();

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
                     
                    success: function(response){  
                        $('#message_box').html('');  
                        if(response.code=='108'){ // alert('10 call'); 
                            
                            Swal.fire({
                              icon: 'info',
                              title: 'Alert!',
                              text: "Your account not found, Please Signup.",
                              confirmButtonColor: '#ffc107',
                            }).then((result) => {
                                   
                                  if(result.isConfirmed) { 
                                    code_mob = $('#country_code').val()+'-'+$('#country_flag_code').val()+'-'+$('#mobile-number').val();

                                    window.location.href="{{url('fr_signup')}}/"+code_mob;
                                  } 
                            })

                        }else if(response.code=='101'){ // alert('10 call'); 
                            var htt_box = '<span class="danger_msg" >'+response.message+'</span>'; 

                            $('#message_box').html(htt_box);  
                        }else if(response.code=='104'){  
                            var htt_box = '<span class="success_msg" >'+response.message+' '+response.data.otp_text+'</span>'; 
                            $('#message_box').html(htt_box);

                                otp_auto_input(response.data.otp_text);

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
                var country_code = $('#country_code').val();

                var otp_1  = $('#otp_1').val();
                var otp_2  = $('#otp_2').val();
                var otp_3  = $('#otp_3').val();
                var otp_4  = $('#otp_4').val();

                var otp = otp_1+''+otp_2+''+otp_3+''+otp_4;
                var uploadfile = new FormData($("#"+form_data_id)[0]);

                uploadfile.append("phone",phone);
                uploadfile.append("otp",otp);
                uploadfile.append("country_code",country_code);

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
                                red_url = URL+"/"; 
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

                $('#otp_1').val('');
                $('#otp_2').val('');
                $('#otp_3').val('');
                $('#otp_4').val('');

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
                        $('#message_box_otp').html('');  
                        if(response.code=='101'){ // alert('10 call'); 
                            var htt_box = '<span class="danger_msg" >'+response.message+'</span>'; 

                            $('#message_box_otp').html(htt_box);  
                        }else if(response.code=='104'){  
                            var htt_box = '<span class="success_msg" >'+response.message+' '+response.data.otp_text+'</span>'; 

                            $('#message_box_otp').html(htt_box);

                                otp_auto_input(response.data.otp_text);
                                
                            setTimeout(function(){  
                                $('#message_box_otp').html('');  
                                $("#my_api_token").val(response.data.token); 
                            }, 1400);
                        }  
                    }
                });

            });
        });


    </script>
@endsection
     
    