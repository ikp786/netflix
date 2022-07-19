@extends('layouts.app_front')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/SH20RAJ/Sopplayer/mooviejs/css/moovie.min.css">

<style>
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
        background: #dcdde282;
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

    #language_type_id{
            width: 103px;
    float: right;
    margin: 5px 50px;
    background: black;
    color: white;
    border: 1px solid white;
    padding: 5px 0;
    border-radius: 5px;

    }
   #rboxx{
        float: right;
        margin-left: 12px;
        position: absolute;
        right: 20px;
        top: 116px;
        padding-top: 7px;
   }
   .video-desc{
    position: relative;
   }
   /*.video-js .vjs-tech{
        width: 100% !important;
   }*/
   .video-js{

    width: 100% !important;
   }
   .vjs-poster{
        background-size: cover !important;
   }
   .modal-review{
    background: transparent !important;
   }
   .modal-review > div{
    background: transparent;
   }
</style>
@section('content')     

    @php $poster = @$video_data[0]->banner_image; @endphp 

    <div id="Review-modal" class="modal-review">
        <div class="open-modal-section">
           <a href="#" title="Close" class="modal-close"><i class="bi bi-x-circle"></i></a> 
           <div class="profile-rating"> 
             @foreach($get_video_casting as $vd_cast)
                <div class="testimonial-box"> 
                     <div class="box-top"> 
                        <div style="width:100%" > 
                           <div> 
                              @if($vd_cast->cast_image!="")
                                  @php $cast_video_img = $vd_cast->cast_image; @endphp
                                  <img src="{{ url('uploads/'.$cast_video_img) }}" style="width: 78px; margin-left:3px; float: right;" />
                               @else
                                  <img src="https://cdn3.iconfinder.com/data/icons/avatars-15/64/_Ninja-2-512.png" style="float: right;" />
                               @endif  
                           </div> 
                           <div class="name-user">
                              <strong>{{ ucwords($vd_cast->cast_title) }}</strong>
                              <span></span>
                           </div>
                        </div>  
                     </div> 
                     <div class="client-comment">
                        <p>{{ $vd_cast->description }}</p>
                     </div>
                  </div> 
             @endforeach   
           </div>
        </div>
     </div>

    <main id="main"> 
         <section class="section-property section-t8">
            

            <div class="container-fluid">
               <div class="row">  
                  <div class="col-md-12"> 
                    <div >
                        @if(@$video_data[0]->video_id!="")
                            <select name="language_type_id" id="language_type_id" data-video_id="{{ @$video_data[0]->video_id }}"  >  
                                    @foreach($get_video_language as $vid_lang_data)
                                        <option {{ (@$lang_id==$vid_lang_data->id || $vid_lang_data->id==@$video_data[0]->language_type_id) ? 'selected' : ''}} value="{{ $vid_lang_data->id }}">{{ ucwords($vid_lang_data->language_title) }}</option>
                                    @endforeach 
                            </select>
                            <a href="#Review-modal" id="rboxx"><i class="bi bi-info-circle"></i></a>
                        @endif  

                        <video id="example1" poster="{{$poster}}" controls  >
                          <source src="{{ @$video_data[0]->media_url }}" type="video/mp4" > 
                          <!-- <track kind="captions" label="Portuguese" srclang="pt" src="<<path-to-caption.vtt>>" >
                          <track kind="captions" label="English" srclang="en" src="https://cdn.jsdelivr.net/gh/BMSVieira/moovie.js@main/demo-template/subtitles/en.vtt" >  -->
                          Your browser does not support the video tag.
                        </video>

                    </div>     
                  </div>  
               </div> 
            </div>
        </section> 
    </main>
@endsection 
@section('script') 
<script src="https://cdn.jsdelivr.net/gh/SH20RAJ/Sopplayer/mooviejs/js/moovie.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
       video1 = new Moovie({
          selector: "#example1",
          config: {
              controls : {
                  playtime : true,
                  mute : true,
                  volume : true,
                  subtitles : true,
                  config : true,
                  fullscreen : true,
                  submenuCaptions : true,
                  submenuOffset : true,
                  submenuSpeed : true,
                  allowLocalSubtitles : true
              }
          } 
       });
    });
    
    $(document).ready(function () {
        var URL = '{{url('/')}}';   

        $("#language_type_id").change(function(){

            video_id = $(this).data('video_id');     
            language_type_id = $(this).val(); 
            
            window.location.href = URL+'/fr_video_play/'+video_id+'/'+language_type_id;

            /*$.ajaxSetup({
               headers: { 
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
            }); 

            var form_data = new FormData();
            form_data.append("video_id",video_id); 
            form_data.append("language_type_id",language_type_id); 
             
            $.ajax({
                type:"POST", 
                url: URL+"/fr_more_video_api",
                data:form_data, 
                enctype: 'multipart/form-data',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                dataType: "JSON", 
                success: function(response){    
                    media_url = response.data[0].media_url;  alert(media_url);
                    $("#playing_video").attr("src",media_url);
                    $("#my-video").load();  
                }
            });*/
        });

    });
</script>
@endsection