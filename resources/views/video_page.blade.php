@extends('layouts.app_front')

@section('content')
   <style>
      .span_category {
          font-size: 14px;
          color: #000;
          background: #fff;
          padding: 10px 20px;
          border-radius: 25px;
      }
      .span_active{
         background: #FFFB2E !important;
      }
      .vid_title{
         text-overflow: ellipsis;
         white-space: nowrap;
         overflow: hidden;
         width:100%; 
      }
   </style>
    <main id="main">
         <section class="section-property section-t8">
            <div>
               <ul class="nav nav-tabs" style="float:right; width:200px"> 
                  <li class="change-preference" >
                     <a href="{{ url('/fr_category')}}" class="change-preference span_category1" >Change Preference</a> 
                  </li>
               </ul>
            </div>
            <div class="container-fluid">
               <div id="exTab2">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <div class="panel-title"> 
                           <ul class="nav nav-tabs"> 
                              <li class="{{ ($selected_sub_category=="") ? 'active' : '' }}" > 

                                 <form id="validate" action="{{ url('fr_video') }}"  class="form-horizontal comm_form" method="POST" role="form" enctype="multipart/form-data" > 
                                       @csrf
                                       <input type="hidden" name="category_ids" id="category_ids" value="{{ $prev_sub_category_ids }}" required /> 
                                       <input type="submit" class="change-preference span_category {{ ($record_type=="all" ? 'span_active ' : '') }}" name="submit_all" value="All" />
                                 </form>

                              </li>
                              @foreach($get_sub_category as $cat_dt)
                                <li>
                                 <!-- <span class="span_category check_search_cat {{ ($selected_sub_category==$cat_dt->id) ? 'span_active' : ''}} " data-id="{{ $cat_dt->id }}" >{{ $cat_dt->product_name }}</span> -->

                                 <form id="validate" action="{{ url('fr_video') }}"  class="form-horizontal comm_form" method="POST" role="form" enctype="multipart/form-data" > 
                                       @csrf
                                       <input type="hidden" name="category_ids" id="category_ids" value="{{ $prev_sub_category_ids }}" required />
                                       <input type="hidden" name="sub_category_ids" id="sub_category_ids" value="{{ $cat_dt->id }}" required />
                                       <input type="submit" class="{{ ($selected_sub_category==$cat_dt->id) ? 'span_active' : ''}}" name="submit" value="{{ $cat_dt->product_name }}"  />
                                 </form>

                                </li>
                              @endforeach  
                     
                           </ul>
                        </div>
                        </div>
                     </div>
                     <div class="panel-body">
                        <div class="tab-content ">
                           <div class="tab-pane active" id="mn_1">
                              @if(@$sm_record_count>0)
                                @if(count($get_popular_data)>0)
                                   <h3>Popular Videos</h3>
                                   <div id="property-carousel" class="swiper">
                                      <div class="swiper-wrapper">
                                         @foreach($get_popular_data as $pop_dt)
                                           <div class="carousel-item-b swiper-slide">
                                              <div class="card-box-a card-shadow">
                                                    <div class="">   
                                                       <a href="{{ url('fr_video_detail').'/'.$pop_dt->id }}">
                                                         @if($pop_dt->banner_image)
                                                           <img class="img-a img-fluid upcoming-videos" src="{{ url('uploads/'.$pop_dt->banner_image) }}" alt="">
                                                         @else
                                                            <img class="img-a img-fluid upcoming-videos" src="{{ url('uploads/video/no_video_image.png') }}" alt="">
                                                         @endif
                                                      </a>
                                                    </div>
                                                    <div class="card-overlay">
                                                       <div class="card-overlay-a-content">
                                                           <div class="card-header-a">
                                                             <h2 class="card-title-a vid_title" >
                                                               <a href="{{ url('fr_video_detail').'/'.$pop_dt->id }}">{{ $pop_dt->sub_product_title }}</a> 
                                                             </h2>
                                                           </div>
                                                       </div>
                                                    </div>
                                              </div>
                                           </div> 
                                         @endforeach
                                      </div>
                                   </div>
                                 @endif

                                 @if(count($get_trending_data)>0)
                                   <h3>Trending Videos</h3>
                                   <div id="property-carousel" class="swiper">
                                      <div class="swiper-wrapper">
                                         @foreach($get_trending_data as $tr_dt)
                                           <div class="carousel-item-b swiper-slide">
                                              <div class="card-box-a card-shadow">
                                                    <div class="">  
                                                      <a href="{{ url('fr_video_detail').'/'.$tr_dt->id }}">
                                                         @if($tr_dt->banner_image)
                                                           <img class="img-a img-fluid upcoming-videos" src="{{ url('uploads/'.$tr_dt->banner_image) }}" alt="">
                                                         @else
                                                            <img class="img-a img-fluid upcoming-videos" src="{{ url('uploads/video/no_video_image.png') }}" alt="">
                                                         @endif
                                                      </a>

                                                    </div>
                                                    <div class="card-overlay">
                                                       <div class="card-overlay-a-content">
                                                           <div class="card-header-a">
                                                             <h2 class="card-title-a vid_title">
                                                               <a href="{{ url('fr_video_detail').'/'.$tr_dt->id }}">{{ $tr_dt->sub_product_title }}</a> </h2>
                                                             </h2>
                                                           </div>
                                                       </div>
                                                    </div>
                                              </div>
                                           </div>
                                         @endforeach  
                                      </div>
                                   </div>
                                 @endif

                                 @if(count($get_upcomming_data)>0)
                                   <h3>Upcoming Videos</h3>
                                   <div id="property-carousel" class="swiper">
                                      <div class="swiper-wrapper">
                                         @foreach($get_upcomming_data as $up_dt)
                                           <div class="carousel-item-b swiper-slide">
                                              <div class="card-box-a card-shadow">
                                                    <div class="">  
                                                       <a href="{{ url('fr_video_detail').'/'.$up_dt->id }}">
                                                         @if($up_dt->banner_image)
                                                           <img class="img-a img-fluid upcoming-videos" src="{{ url('uploads/'.$up_dt->banner_image) }}" alt="">
                                                         @else
                                                            <img class="img-a img-fluid upcoming-videos" src="{{ url('uploads/video/no_video_image.png') }}" alt="">
                                                         @endif
                                                      </a>
                                                    </div>
                                                    <div class="card-overlay">
                                                       <div class="card-overlay-a-content">
                                                           <div class="card-header-a">
                                                             <h2 class="card-title-a vid_title">
                                                               <a href="{{ url('fr_video_detail').'/'.$up_dt->id }}">{{ $up_dt->sub_product_title }}</a> 
                                                             </h2>
                                                           </div>
                                                       </div>
                                                    </div>
                                              </div>
                                           </div>
                                         @endforeach  
                                      </div>
                                   </div>
                                 @endif
                              @else
                                 <div style="text-align: center;">  
                                   <i class="bi bi-info-circle" style="font-size: 100px;"></i>
                                   <span>No video found</span>                                     
                                </div>
                              @endif
                           </div> 

                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- End Latest Properties Section -->
      </main> 
  
@endsection

 
