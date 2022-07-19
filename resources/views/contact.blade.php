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
  .desc{
    padding: 10px 20px;
  }
</style>

@section('content') 
 
  <main id="main"> 
    <div class="container text-center">
      <div class="lgn-frm sgn-frm">
          <h3>Contact Us</h3>
            <form class="login-form" id="contact_form">
              @csrf
              <div id="message_box"></div>
              <input type="text" name="subject" placeholder="Subject">
              <textarea class="desc"  name="description" class="w-100" rows="4" cols="" placeholder="Description"></textarea>
              
               <button type="button" id="save_form" data-id="contact_form" data-form_action="contact_us" autofocus class="btn red btn-block uppercase btn_anchor">Submit</button> 

            </form>
            <div class="drop-mail">
              <p>Drop Your Query / Write Us On</p>
              <a href="#">
                <span><i class="bi bi-envelope"></i></span>   
                support@cocrico.com</a>
            </div>
      </div>
    </div>
  </main>

@endsection 
@section('script') 
    <script>
        $(document).ready(function (){

            var URL = '{{url('/')}}'; 
   
            $("#save_form").click(function(){     
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
                        if(response.code=='101'){ 
                            var htt_box = '<span class="danger_msg" >'+response.message+'</span>'; 

                            $('#message_box').html(htt_box);  
                        }else if(response.code=='104'){  
                            var htt_box = '<span class="success_msg" >'+response.message+'</span>'; 

                            $('#message_box').html(htt_box); 
                        } 
                        setTimeout(function(){   
                             $('#message_box').html(''); 
                        }, 3000);
                    }
                }); 
            }); 
 
        });


    </script>
@endsection