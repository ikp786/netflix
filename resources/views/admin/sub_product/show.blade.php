@extends('layouts.master')
<style type="text/css">
     label {
        font-size: 15px;
        line-height: 34px;
    }   
    .sdd{
      font-size: 14px !important;
    } 
    .crss{
        border: 1px solid #e9e3e3;
        border-radius: 5px;
        margin: 2px;
    }
</style> 
@section('content')
   <ul class="breadcrumb">
        <li><a href="#">Home</a></li>  
        <li><a href="#">View Episode</a></li> 
    </ul> 
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show Video</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('sub_product.index') }}"> Back</a>
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default">  
                <div class="page-head">        
                    <div class="page-head-text">
                        <h3 class="panel-title"><strong>View Video</strong></h3> 
                    </div>
                    <div class="page-head-controls">  
                    </div>                    
                </div>  
                <div class="panel-default">
                    <div class="panel-body">
                          <div class="row fil_ters" style="background: #dae1c24f;" > 
                            <div class="col-md-8">
                                <div class="col-md-12" >
                                    <div class="form-group">
                                        <label>Title : </label>
                                        {{ ucwords(@$get_data->sub_product_title) }}
                                    </div> 
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Category : </label>
                                        {{ ucwords($get_data->category_detail->category_name) }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Sub Category : </label>
                                        {{ ucwords($get_data->product_detail->product_name) }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>U/A. : </label> 
                                        {{ $get_data->u_a }} 
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Year. : </label> 
                                        {{ $get_data->year }} 
                                    </div>
                                </div>
                                <style>
                                    .fl_left{ float: left; padding-left:3px; }
                                    .yel_cls{ color:#feb202; }
                                </style>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="fl_left" >Rating. :</label> 
                                        <span class="fl_left" style="padding-top: 12px;" >
                                            @php  $rat_count = ($get_data->rating_avg) ? $get_data->rating_avg : '0' @endphp
                                            @for($i=1;$i<=5;$i++)
                                                <i class="fa fa-star fl_left {{ ($i<=$rat_count) ? 'yel_cls' : ''}}  " aria-hidden="true"></i>
                                            @endfor
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Description : </label>
                                        {{ ucwords($get_data->sub_product_description) }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Uploaded Date : </label>
                                        {{ date("Y-m-d", strtotime(@$get_data->created_at)) }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Video Type. : </label> 
                                        {{ ucwords($get_data->sub_product_type_name) }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Status. : </label> 
                                        {!!  
                                         ($get_data->status=='1') ? '<span class="label label-success sdd">Active</span>' : '<span class="label label-warning  sdd">InActive</span>'
                                         !!}
                                    </div>
                                </div>  
                            </div>
                            <div class="col-md-4"> 
                                <div class="col-md-12"> 
                                    @if(isset($get_data->banner_image))
                                        <img src="{{ url('uploads/'.$get_data->banner_image) }}" style="float:right; width: 230px; padding: 8px;"  />
                                    @endif  <br/>
                                    @if(isset($get_data->sub_media_url))
                                        <video  style="width:225px; float:right" controls >
                                           <source src="{{ url('uploads/'.$get_data->sub_media_url) }}" > 
                                        </video>
                                    @endif 
                                </div>
                            </div> 
                          </div><hr/>

                            <div style="background: #dae1c24f;" >
                                 <div class="row">
                                     <div class="col-xs-12 col-sm-12 col-md-6">
                                         <h3 class="panel-title"><strong>Videos</strong></h3><br/><br/>
                                     </div> 
                                 </div>
                                 <div class="">
                                    <div class="text-center" style="margin: 20px 0px 20px 0px;">
                                    </div> 
                                       <div class="row" >
                                          <div class="col-lg-12"> 
                                                @foreach($get_more_video_detail as $more_vid)   
                                                    <div class="col-md-4">
                                                        <div class="form-group"> 
                                                            @if(isset($more_vid->media_url))  
                                                                <a target="_blank" href="{{ url('uploads/'.$more_vid->media_url) }}" >
                                                                    <video  style="height:100" controls>
                                                                      <source src="{{ url('uploads/'.$more_vid->media_url) }}" > 
                                                                    </video>
                                                                </a> <br/>
                                                            @endif 
                                                            <label style="text-center">
                                                                @foreach($get_lang_types as $lang_val)  
                                                                     {{ ($lang_val->id==$more_vid->language_type_id) ? $lang_val->language_title : ''}} 
                                                                @endforeach
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach 
                                          </div>
                                       </div> 
                                 </div>
                                 <hr/>
                                 <div class="row">
                                     <div class="col-xs-12 col-sm-12 col-md-6">
                                         <h3 class="panel-title"><strong>Video Cast</strong></h3><br/><br/>
                                     </div> 
                                 </div>
                                 <div class="">
                                    <div class="text-center" style="margin: 20px 0px 20px 0px;">
                                    </div> 
                                       <div class="row"  style="margin: 12px;" >
                                           
                                             @foreach($get_video_casting_detail as $cast_vid)   
                                                <div class="col-lg-12 crss">
                                                    <div class="col-md-8">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Title : </label>
                                                                {{$cast_vid->cast_title}}
                                                            </div> 
                                                        </div> 
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Description : </label>
                                                                {{$cast_vid->description}}
                                                            </div>
                                                        </div> 
                                                    </div>
                                                    <div class="col-md-4"> 
                                                        <div class="col-md-12"> 
                                                            @if(isset($cast_vid->cast_image)) 
                                                                <a target="_blank" href="{{ url('uploads/'.$cast_vid->cast_image) }}" >
                                                                    <img style="float:right; width: 230px; padding: 8px;" src="{{ url('uploads/'.$cast_vid->cast_image) }}" /> 
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div> 
                                                </div>    
                                            @endforeach 
                                          
                                       </div> 
                                 </div>
                                 <hr/>
                            </div> 
                    </div>
                </div>
            </div>
        </div> 
    </div>
    
@endsection 

@section('script')  
   <script> 

     var URL = '{{url('/')}}';  
     
     document.getElementById('links').onclick = function (event) {
          event = event || window.event;
          var target = event.target || event.srcElement;
          var link = target.src ? target.parentNode : target;
          var options = {index: link, event: event,onclosed: function(){
                  setTimeout(function(){
                      $("body").css("overflow","");
                  },200);                        
              }};
          var links = this.getElementsByTagName('a');
          blueimp.Gallery(links, options);
      };
            
     $(document).ready(function() { 
         
         
     });
   </script> 
 @endsection