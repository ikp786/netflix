@extends('layouts.app_front')
<style>
    .vid_img{ height: 145px !important;  }
    .delett{ cursor:pointer; }
</style>
@section('content')
    <main id="main"> 
        <section class="section-property section-t8 prfil-bg">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12 prfl-top "> 
                @if($get_data->profile_photo_path!="")
                  @php $prof_img = $get_data->profile_photo_path; @endphp
                  <img class="profile-account-section" src="{{ url('uploads/'.$prof_img) }}"/>
               @else
                  <img src="{{ asset('front/assets/img/profile-pic.png') }}" alt="">
               @endif

                <h2>{{ ucwords($get_data->name) }}
                    <a href="{{ url('fr_edit_profile') }}" >
                        <img src="{{ asset('front/assets/img/edit.svg') }}" alt="">
                    </a>
                </h2>
              </div>
            </div>

            <div id="exTab2">
              <div class="panel panel-default"> 
                <div class="panel-heading">
                  <div class="panel-title">
                    <ul class="nav nav-tabs">
                      <li class="{{ ($tab_id=='' || $tab_id=='1') ? 'active' : '' }} ">
                        <a href="{{ url('fr_profile') }}/1" >Watching</a>
                      </li>
                      <li class="{{ ($tab_id=='2') ? 'active' : '' }}" ><a href="{{ url('fr_profile') }}/2" >My Fav</a>
                      </li>
                      <li class="{{ ($tab_id=='3') ? 'active' : '' }}" ><a href="{{ url('fr_profile') }}/3" >Download</a>
                      </li>
                      <li class="{{ ($tab_id=='4') ? 'active' : '' }}" ><a href="{{ url('fr_profile') }}/4" >Subscription</a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="panel-body">
                  <div class="tab-content ">
                    <div class="tab-pane {{ ($tab_id=='' || $tab_id=='1') ? 'active' : '' }} " id="1">
                        @if(count($get_popular_data)+count($get_trending_data) > 0)
                          @if(count($get_trending_data)>0)
                            <h3>Trending</h3>
                              <ul>
                                @foreach($get_trending_data as $tr_data)
                                    <li>
                                      <a href="{{ url('fr_video_detail/').$tr_data->id }}">
                                        <div class="img-ply">
                                            <div class="video-ply-bar">
                                              @if($tr_data->banner_image)
                                                <img class="img-a img-fluid vid_img" src="{{ url('uploads/'.$tr_data->banner_image) }}" alt="">
                                              @endif 
                                            </div>                      
                                          </div>
                                          <p>Flesh</p>
                                      </a>
                                    </li> 
                                @endforeach 
                              </ul>
                            @else
                                <div style="text-align: center;">  
                                    <i class="bi bi-info-circle" style="font-size: 100px;"></i>
                                    <span>No video found</span>                                     
                                </div>
                            @endif  
                          @if(count($get_popular_data)>0)
                            <h3>Popular</h3>
                              <ul>
                                @foreach($get_popular_data as $pop_data)
                                    <li>
                                      <a href="{{ url('fr_video_detail/').$pop_data->id }}">
                                        <div class="img-ply">
                                            <div class="video-ply-bar">
                                              @if($pop_data->banner_image)
                                                <img class="img-a img-fluid vid_img" src="{{ url('uploads/'.$pop_data->banner_image) }}" alt="">
                                              @endif 
                                            </div>                      
                                          </div>
                                          <p>Flesh</p>
                                      </a>
                                    </li> 
                                @endforeach 
                              </ul>
                            @else
                                <div style="text-align: center;">  
                                    <i class="bi bi-info-circle" style="font-size: 100px;"></i>
                                    <span>No video found</span>                                     
                                </div>
                            @endif
                        @else
                            <div style="text-align: center;">  
                                <i class="bi bi-info-circle" style="font-size: 100px;"></i>
                                <span>No video found</span>                                     
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane {{ ($tab_id=='2') ? 'active' : '' }}" >
                      @if(count($get_mylist_data)>0) 
                            <h3>My List</h3>
                            @foreach($get_mylist_data as $mylist_data) 
                                <div class="listt" id="my_list_div_{{ $mylist_data->id }}">
                                    @if($mylist_data->banner_image)
                                        <img class="vid_img" src="{{ url('uploads/'.$mylist_data->banner_image) }}" alt="">
                                    @endif  
                                    <p>{{ $mylist_data->sub_product_title }}</p>
                                    <p>{{ $mylist_data->year }}</p>
                                    <span>{{ $mylist_data->u_a }}</span>
                                    <form id="del_fav_form_{{ $mylist_data->id }}" action="{{url('delete_from_my_list_web') }}" method="POST" >
                                        @csrf
                                        <input type="hidden" name="video_id" value="{{ $mylist_data->id }}" />
                                        <img src="{{ asset('front/assets/img/list-cancel.svg') }}" class="delett delete_video_mn" data-id="{{ $mylist_data->id }}" alt="" />
                                    </form>
                                </div>
                            @endforeach  
                        @else
                            <div style="text-align: center;">  
                                <i class="bi bi-info-circle" style="font-size: 100px;"></i>
                                <span>No video found</span>                                     
                             </div>
                        @endif
                      
                       
                    </div>
                    <div class="tab-pane dwnlad {{ ($tab_id=='3') ? 'active' : '' }}" id="3">  
                        @if(count($get_download_data)>0) 
                            @foreach($get_download_data as $down_data) 
                                <div class="listt" id="my_list_div_{{ $down_data->id }}">
                                    @if($down_data->banner_image)
                                        <img class="vid_img" src="{{ url('uploads/'.$down_data->banner_image) }}" alt="">
                                    @endif  
                                    <p>{{ $down_data->sub_product_title }}</p>
                                    <p>{{ $down_data->year }}</p>
                                    <span>{{ $down_data->u_a }}</span>
                                    <form id="del_down_form_{{ $down_data->id }}" action="{{url('delete_from_download_web') }}" method="POST" >
                                        @csrf
                                        <input type="hidden" name="video_id" value="{{ $down_data->id }}" />
                                        <img src="{{ asset('front/assets/img/list-cancel.svg') }}" class="delett delete_down_video_mn" data-id="{{ $down_data->id }}" alt="" />
                                    </form>
                                </div>
                            @endforeach
                        @else
                            <div style="text-align: center;">
                                <img src="{{ asset('front/assets/img/download.svg') }}" alt="">
                                <span>No videos download</span>
                            </div>
                        @endif 
                    </div>
                    <div class="tab-pane {{ ($tab_id=='4') ? 'active' : '' }}" id="4">
                      <h3>Plan Details</h3>
                      <div class="sbscrpt">
                        @if(isset($get_subscribed_data->id))
                            <p>{{$get_subscribed_data->plan_title}}</p>
                            <span>{{$get_subscribed_data->plan_for_month}} months</span>
                            <span class="expired-date">Expired on {{ date('d F Y',strtotime($get_subscribed_data->expiry_date)) }}</span>
                            <div>
                              <a href="{{ url('fr_membership') }}" class="chng-pln">Renew Plan</a>
                              <a href="" class="cncl-pln">Cancel</a>
                            </div>
                        @else
                            <span>No Plan Exist</span>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


          </div>
        </section>
    </main>
@endsection
@section('script')
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>  
    <script>
        $(document).ready(function (){

            var URL = '{{url('/')}}'; 
            
            $(".delete_video_mn").click(function(e){ 
                form_data_id = $(this).data('id');
                $("#del_fav_form_"+form_data_id).submit(); 
            });
             
            $(".delete_down_video_mn").click(function(e){ 
                form_data_id = $(this).data('id');
                $("#del_down_form_"+form_data_id).submit(); 
            });

        }); 
    </script>
@endsection
