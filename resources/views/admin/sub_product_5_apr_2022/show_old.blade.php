@extends('layouts.master')
<style type="text/css">
     label {
        font-size: 15px;
        line-height: 34px;
    }   
    .sdd{
      font-size: 14px !important;
    } 
</style> 
@section('content')
   <ul class="breadcrumb">
        <li><a href="#">Home</a></li> 
        <li><a href="{{ route('product.index') }}">Program</a></li> 
        <li><a href="#">View Episode</a></li> 
    </ul> 
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show Episode</h2>
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
                        <h3 class="panel-title"><strong>View Episode</strong></h3> 
                    </div>
                    <div class="page-head-controls">  
                    </div>                    
                </div>  
                <div class="panel-default">
                    <div class="panel-body">
                          <div class="row fil_ters" style="background: #dae1c24f;" > 
                            <div class="col-md-6">
                                <div class="col-md-12" >
                                    <div class="form-group">
                                        <label>Program Name : </label>
                                        {{ ucwords(@$get_product_detail->product_name) }}
                                    </div> 
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Category : </label>
                                        {{ ucwords($get_product_detail->category_detail->category_name) }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Year. : </label> 
                                        {{ $get_product_detail->year }} 
                                    </div>
                                </div>
                                <style>
                                    .fl_left{ float: left; padding-left:3px; }
                                    .yel_cls{ color:#feb202; }
                                </style>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="fl_left" >Rating. : </label> 
                                        <span class="fl_left" style="padding-top: 12px;" >
                                            @php  $rat_count = ($get_product_detail->product_rating) ? $get_product_detail->product_rating : '0' @endphp
                                            @for($i=1;$i<=5;$i++)
                                                <i class="fa fa-star fl_left {{ ($i<=$rat_count) ? 'yel_cls' : ''}}  " aria-hidden="true"></i>
                                            @endfor
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"> 
                                <div class="col-md-12"> 
                                    @if(isset($get_product_detail->media_url))
                                        <img src="{{ url('uploads/'.$get_product_detail->media_url) }}" style="float:right; width: 280px; padding: 8px;"  />
                                    @endif  
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Program Description : </label> 
                                    {{ ucwords(@$get_product_detail->description) }} 
                                </div>
                            </div>
                          </div><hr/>   
                          <div class="row fil_ters"> 
                            <div class="col-md-6">
                                <div class="col-md-12" >
                                    <div class="form-group">
                                        <label>Episode Name : </label>
                                        {{ ucwords(@$get_data->sub_product_title) }}
                                    </div> 
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Description : </label>
                                        {{ ucwords($get_data->sub_product_description) }}
                                    </div>
                                </div>
                                <div class="col-md-12" style="margin-top:23px;" >
                                    <div class="form-group">
                                        <label>Status. : </label> 
                                        {!!  
                                         ($get_data->status=='1') ? '<span class="label label-success sdd">Approve</span>' : '<span class="label label-warning  sdd">Reject</span>'
                                         !!}
                                    </div>
                                </div> 
                            </div>
                            <div class="col-md-6"> 
                                <div class="col-md-12"> 
                                    @if(isset($get_data->sub_media_url))
                                        <video  style="width:325px; float:right" controls>
                                          <source src="{{ url('uploads/'.$get_data->sub_media_url) }}" > 
                                        </video>
                                    @endif  
                                </div>
                            </div>
                          </div><hr/>

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