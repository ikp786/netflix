@extends('layouts.app_front')

@section('content')
    <div class="ch-ur-pl" >
        <main id="main"> 
          <div class="container text-center">
            <div class="lgn-frm ur-plan">
                <h3><span>Limited Time Offer</span> All of Cocrico. For Less</h3>
                
                <!-- <div class="card active">
                  <div class="d-flex">
                    <h3><i class="fas fa-check"></i></h3>
                    <p>12 months<span>50% OFF</span></p>
                  </div>
                  <p>$69.99<small>$140.00</small></p>        
                </div> -->
                <form class="login-form" id="subscribe_plan_form" method="post" action="add_update_subscription_plan_web" >
                    @csrf
                    <div id="message_box"></div>
                    @if(count($get_data)>0)
                        @foreach($get_data as $sub_dt)
                            <div class="card {{ (@$current_subscribed_data->subscription_plan_id==$sub_dt->id) ? 'active' : '' }}" data-id="{{ $sub_dt->id }}">
                              <div class="d-flex">
                                <h3><i class="fas fa-check"></i></h3>
                                <p>{{ $sub_dt->plan_for_month }} months<span>{{ $sub_dt->discount_in_percent }}% OFF</span></p>
                              </div>
                              <p>${{ $sub_dt->discount_price }}<small>${{ $sub_dt->price }}</small></p>        
                            </div>
                            
                        @endforeach
                        <input type="hidden" name="plan_id" value="{{@$get_data[0]->id}}" id="plan_id" required />   
                        <button type="{{ (\Auth::check()) ? 'submit' : 'button' }}"   data-id="subscribe_plan_form" data-form_action="add_update_subscription_plan_web" autofocus class="btn red btn-block text-dark btn_anchor {{ (\Auth::check()) ? '' : 'check_login' }}">Buy</button> 
                    @else
                        <p style="text-align: center; color: #fffb2e;" >No Plan Exists</p>
                    @endif  
                </form>
            </div>
          </div> 
        </main>
    </div>
@endsection
@section('script')  
    <script>
        $(document).ready(function (){

            var URL = '{{url('/')}}';

            $("#save_form").click(function(e){   

                form_action = $(this).data('form_action');    
                
                var uploadfile = new FormData();

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
                        $('#message_box').html('');  
                        if(response.code=='101' || response.status==false){ // alert('10 call'); 
                            var htt_box = '<span class="danger_msg" >'+response.message+'</span>'; 

                            $('#message_box').html(htt_box);  
                        }else if(response.code=='104'  || response.status==true){  
                            var htt_box = '<span class="success_msg" >'+response.message+'</span>'; 

                            $('#message_box').html(htt_box); 
                        }  
                        setTimeout(function(){  
                           $('#message_box').html('');  
                        }, 1400);
                    }
                });

            });
        });
     
        let cards = document.querySelectorAll(".card");
        console.log(cards);

        Array.from(cards).forEach((el) => {
          el.addEventListener("click", function () {
            Array.from(cards).forEach((card) => {
              card.classList.remove("active");
            });
              el.classList.add("active");
              idd = $(this).data('id');
              $('#plan_id').val(idd); 
          });

        });
    </script>
@endsection