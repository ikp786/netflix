@extends('layouts.app_front')

@section('content') 
    <style type="text/css">
        .modal-window {
        position: fixed;
            background-color: rgb(0 0 0 / 80%);
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 999;
        visibility: hidden;
        opacity: 0;
        pointer-events: none;
        transition: all 0.3s;
      }
      .modal-window:target {
        visibility: visible;
        opacity: 1;
        pointer-events: auto;
      }
      .modal-window > div {
        width: 290px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 1em;
        background: white;
        border-radius: 20px;
      }
      .modal-window header {
        font-weight: bold;
      }
      .modal-window h1 {
        font-size: 18px;
        color: #000;
        text-align: center;
        margin: 25px 0 15px;

      }

      .modal-close {
          color: #000;
          font-size: 21px;
          position: absolute;
          right: 0;
          padding: 4px 8px;
          text-align: center;
          top: 0;
          text-decoration: none;
      }
      .modal-close:hover {
        color: black;
      }
      .add-review textarea{
        border: 1px solid #B2B2B2;
        border-radius: 5px;
        font-size: 15px;
        padding: 4px 6px;
        width: 100%;
      }
      .review-submit-btn{
        background: #FFFB2E;
        border-radius: 10px;
        width: 100%;
        padding: 10px 0;
        border: 1px solid #FFFB2E;
        font-weight: 600;
      }
      .modal-review {
        position: fixed;
            background-color: rgb(0 0 0 / 80%);
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 999;
        visibility: hidden;
        opacity: 0;
        pointer-events: none;
        transition: all 0.3s;
      }
      .modal-review:target {
        visibility: visible;
        opacity: 1;
        pointer-events: auto;
      }
      .modal-review > div {
        width: 450px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 10px;
        background: white;
        border-radius: 20px;
      }
      .modal-review header {
        font-weight: bold;
      }
      .modal-review h1 {
        font-size: 18px;
        color: #000;
        text-align: center;
        margin: 25px 0 15px;

      }

      .modal-close {
           color: #000;
          font-size: 21px;
          position: absolute;
          right: 0;
          padding: 4px 8px;
          text-align: center;
          top: 0;
          text-decoration: none;
      }
      .modal-close:hover {
        color: black;
      }


      .testimonial-box{ 
        box-shadow: 0px 3px 15px #00000029;
      border-radius: 15px;
          background-color: #ffffff;
          padding:15px 20px;
          margin: 15px 0;
          cursor: pointer;
      }
      .profile-img{
          width:30px;
          height: 30px;
          border-radius: 50%;
          overflow: hidden;
          margin-right: 10px;
      }
      .profile-img img{
          width: 100%;
          height: 100%;
          object-fit: cover;
          object-position: center;
      }
      .profile{
          display: flex;
          align-items: center;
      }
      .name-user{
          display: flex;
          flex-direction: column;
      }
      .name-user strong{
          color: #3d3d3d;
          font-size: 13px;
          letter-spacing: 0.5px;
      }
      .name-user span{
          color: #979797;
          font-size: 11px;
      }
      .reviews{
          color: #f9d71c;
      }
      .box-top{
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-bottom: 0px;
      }
      .client-comment p{
        font-size: 13px;
        line-height: 20px;
          color: #4b4b4b;
          margin: 0;
      }
      .testimonial-box:hover{
          transform: translateY(-10px);
          transition: all ease 0.3s;
      }
       
       
      @media(max-width:790px){
          .testimonial-box{
              width:100%;
          }
          .testimonial-heading h1{
              font-size: 1.4rem;
          }
      }
      @media(max-width:340px){
          .box-top{
              flex-wrap: wrap;
              margin-bottom: 10px;
          }
          .reviews{
              margin-top: 10px;
          }
      }
      ::selection{
          color: #ffffff;
          background-color: #252525;
      }
      #save_to_fav_form{
        border: none;
      }
      .save_to_fav_form_active{
        color: yellow;
      }
      .mod_rating{
            width: 85px;
      }
      .success_msg{ color: green; }
      .danger_msg{ color:red }
      .check_star_cat{ padding: 3px; text-align: center; }
      .vid_title{
          text-overflow: ellipsis;
          white-space: nowrap;
          overflow: hidden;
          width:100%; 
       }
    </style>
    <form class="login-form" id="video_form">@csrf</form>
    <main id="main"> 
         <section class="section-property section-t8 det-lft" style="background-image: url('{{ $video_data->banner_image }}');">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-6">
                     <h3 >{{ ucwords($video_data->video_name) }} </h3>
                     <ul>
                        <li>{{ $video_data->year }}</li>
                        <li>{{ $video_data->u_a }}</li>
                        <li>{{ $video_data->category_name }}</li>
                        <li>
                            @if($video_data->video_rating>=5)
                                <img src="{{ url('assets/img/5star.svg') }}" alt="">
                            @elseif($video_data->video_rating>=4 && $video_data->video_rating<5)
                                <img src="{{ url('assets/img/4star.svg') }}" alt="">
                            @elseif($video_data->video_rating>=3 && $video_data->video_rating<4) 
                                <img src="{{ url('assets/img/3star.svg') }}" alt="">
                            @elseif($video_data->video_rating>=2 && $video_data->video_rating<3) 
                                <img src="{{ url('assets/img/2star.svg') }}" alt="">
                            @elseif($video_data->video_rating>1 && $video_data->video_rating<2) 
                                <img src="{{ url('assets/img/1star.svg') }}" alt="">
                            @else
                                <img src="{{ url('assets/img/0star.svg') }}" alt="">
                            @endif    
                            <a href="#Review-modal">{{ $video_data->review_rating_count }} Review</a></li>
                     </ul>
                     <p>{{ $video_data->description }}</p>
                     <a href="{{ url('fr_video_play').'/'.$video_data->video_id }}" class="watch-nw"><img src="{{ url('assets/img/play-button.svg') }}" alt=""> Watch Now</a>

                     @if(\Auth::check())
                         <button type="button" id="save_to_fav_form" data-vid="{{ $video_data->video_id }}" data-id="video_form" data-form_action="add_to_my_list" autofocus class="save_to_fav_form_active ad-lst"><img src="{{ url('assets/img/plus-positive.svg') }}" alt=""> Add to My List</button>

                        <a class="thmb-up" href="#open-modal"><img src="{{ url('assets/img/like.svg') }}" alt=""> Rate</a>
                     @endif
                     <div id="open-modal" class="modal-window">
                        <div class="open-modal-section"> 
                           <a href="#" title="Close" class="modal-close"><i class="bi bi-x-circle"></i></a>
                           <h1>Share your experience</h1>
                           <div id="message_box"></div>
                           <div class="rating-star-img text-center reviews">
                              <!-- <img src="{{ url('assets/img/4star.svg') }}" class="check_star_cat" data-id="1" id="cate_star_check_1" alt=""> -->
                              @for($st=1;$st<=5;$st++)
                                <i class="bi bi-star check_star_cat" data-id="{{$st}}" id="cate_star_check_{{$st}}"></i>
                              @endfor
                           </div>
                           <div class="add-review text-center mt-3">
                              <form id="save_rev_rating_form" >
                                @csrf
                                 <input type="hidden" value="{{ $video_data->video_id }}" id="rev_video_id" name="video_id" />
                                 <input type="hidden" id="rev_ratting" value="0" name="rating" />
                                 <textarea rows="3" class="mb-3" name="comment" id="rev_comment" placeholder="Add your review"></textarea> 
                                 <button type="button" id="rev_rating_form" class="review-submit-btn">Submit</button> 
                              </form>
                           </div>
                        </div>
                     </div>
                     <div id="Review-modal" class="modal-review">
                        <div class="open-modal-section">
                           <a href="#" title="Close" class="modal-close"><i class="bi bi-x-circle"></i></a>
                           <h1>Reviews</h1>
                           <div class="profile-rating">
                            @if($video_data->review_rating_count)
                                @foreach($video_data->review_rating_list as $rev_dt)
                                  <div class="testimonial-box"> 
                                     <div class="box-top"> 
                                        <div class="profile"> 
                                           <div class="profile-img"> 
                                              @if($rev_dt->profile_photo_path!="")
                                                  @php $rat_user_img = $rev_dt->profile_photo_path; @endphp
                                                  <img src="{{ url('uploads/'.$rat_user_img) }}" style="width: 37px; margin-left:3px;" />
                                               @else
                                                  <img src="https://cdn3.iconfinder.com/data/icons/avatars-15/64/_Ninja-2-512.png" />
                                               @endif  
                                           </div> 
                                           <div class="name-user">
                                              <strong>{{ ucwords($rev_dt->name) }}</strong>
                                              <span></span>
                                           </div>
                                        </div> 
                                        <div class="reviews">
                                            @if($rev_dt->rating>=5)
                                                <img class="mod_rating" src="{{ url('assets/img/5star.svg') }}" alt="">
                                            @elseif($rev_dt->rating>=4 && $rev_dt->rating<5)
                                                <img class="mod_rating" src="{{ url('assets/img/4star.svg') }}" alt="">
                                            @elseif($rev_dt->rating>=3 && $rev_dt->rating<4) 
                                                <img class="mod_rating" src="{{ url('assets/img/3star.svg') }}" alt="">
                                            @elseif($rev_dt->rating>=2 && $rev_dt->rating<3) 
                                                <img class="mod_rating" src="{{ url('assets/img/2star.svg') }}" alt="">
                                            @elseif($rev_dt->rating>1 && $rev_dt->rating<2) 
                                                <img class="mod_rating" src="{{ url('assets/img/1star.svg') }}" alt="">
                                            @else
                                                <img class="mod_rating" src="{{ url('assets/img/0star.svg') }}" alt="">
                                            @endif    
                                        </div>
                                     </div> 
                                     <div class="client-comment">
                                        <p>{{ $rev_dt->comment }}</p>
                                     </div>
                                  </div> 
                                @endforeach
                            @endif      
                           </div>
                        </div>
                     </div>
                     <a href="{{ $video_data->media_url }}" class="thmb-up" download><i class="bi bi-arrow-down-circle"></i><span> Download</span></a>
                  </div>
                  <div class="col-md-6"></div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <div class="title-wrap">
                        <div class="title-box">
                           <h2 class="title-a">Similar Videos</h2>
                        </div>
                     </div>
                  </div>
               </div>
               <div id="property-carousel" class="swiper">
                  <div class="swiper-wrapper">
                    @if(count($GetSimilarVid)>0)
                        @foreach($GetSimilarVid as $pop_dt)
                           <div class="carousel-item-b swiper-slide">
                              <div class="card-box-a card-shadow">
                                 <div class="">
                                    @if(isset($pop_dt->banner_image))
                                      <a href="{{ url('fr_video_detail').'/'.$pop_dt->id }}"><img class="img-a img-fluid upcoming-videos" src="{{ url('uploads/'.$pop_dt->banner_image) }}" alt=""></a>
                                    @endif
                                 </div>
                                 <div class="card-overlay">
                                    <div class="card-overlay-a-content">
                                       <div class="card-header-a">
                                          <h2 class="card-title-a vid_title">
                                             <a href="{{ url('fr_video_detail').'/'.$pop_dt->id }}">{{ $pop_dt->sub_product_title }}</a>  
                                          </h2>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>  
                        @endforeach   
                    @else
                        <h5>No Similar Videos Found </h5>
                    @endif    
                  </div>
               </div>
               @if(count($GetSimilarVid)>6)
                    <div class="propery-carousel-pagination carousel-pagination"></div>
               @endif
            </div>
         </section> 
      </main>
@endsection 
@section('script') 
    <script>
        $(document).ready(function (){

            var URL = '{{url('/')}}'; 
            
            $(".check_star_cat").click(function(){  

                $('.check_star_cat').removeClass('bi-star-fill');
                $('.check_star_cat').addClass('bi-star');

                data_id = $(this).data('id');
                for(i=1;i<=5;i++){
                    if(i<=data_id){
                        $('#cate_star_check_'+i).removeClass('bi-star').addClass('bi-star-fill'); 
                    }else{
                        $('#cate_star_check_'+i).removeClass('bi-star-fill').addClass('bi-star');  
                    }
                }   
                $('#rev_ratting').val(data_id);
            });

            $("#save_to_fav_form").click(function(e){     

                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'Authorization': 'Bearer {{@$bearer_token}}'
                    }
                });

                form_data_id = $(this).data('id'); 
                form_action = $(this).data('form_action');    
                
                video_id = $(this).data('vid');
 
                var uploadfile = new FormData($("#"+form_data_id)[0]);
                uploadfile.append("video_id",video_id);

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
                        alert();
                        console.log(response.data.is_added);

                        if(response.data.is_added=='1'){
                            $('#save_to_fav_form').removeClass("save_to_fav_form_active");
                        }else{
                            $('#save_to_fav_form').addClass("save_to_fav_form_active");
                        }
                        alert(response.message);
                    }
                }); 
            }); 


            $("#rev_rating_form").click(function(e){     

                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'Authorization': 'Bearer {{@$bearer_token}}'
                    }
                }); 

                var uploadfile = new FormData($("#save_rev_rating_form")[0]);
 
                $.ajax({
                    type:"POST", 
                    url: URL+"/add_review_rating",
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
                            var htt_box = '<span class="success_msg" >'+response.message+'</span>'; 

                            $('#message_box').html(htt_box);
                        } 
                        setTimeout(function(){   
                             $('#message_box').html(''); 
                        }, 5000);
                    }
                }); 
            });

        }); 
    </script>
@endsection