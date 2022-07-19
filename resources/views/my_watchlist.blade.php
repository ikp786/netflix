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
              <div class="col-md-12 prfl-top"> 
                <h2 style="font-size: 30px;">My Favourite</h2>
              </div>
            </div>

            <div id="exTab2">
              <div class="panel panel-default"> 
                <div class="panel-body">
                  <div class="tab-content ">
                    <div class="tab-pane active" > 
                      @if(count($get_mylist_data)>0) 
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
                            <span>No videos Found</span>
                        @endif
                                             
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
