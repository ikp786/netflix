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
        <li><a href="#">View Sub Category</a></li> 
    </ul> 
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show Sub Category</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('product.index') }}"> Back</a>
            </div>
        </div>
    </div> 
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default">  
                <div class="page-head">        
                    <div class="page-head-text">
                        <h3 class="panel-title"><strong>View Sub Category</strong></h3> 
                    </div>
                    <div class="page-head-controls">  
                    </div>                    
                </div>  
                <div class="panel-default">
                    <div class="panel-body">

                          <div class="row fil_ters">
                             <div class="col-md-6">
                                <div class="card-body">
                                   <div class="row">
                                      <div class="col-md-12">  
                                          <div class="form-group">
                                              <label>Sub Category Name : </label>
                                              {{ ucwords(@$get_data->product_name) }}
                                          </div> 
                                      </div> 
                                      <div class="col-md-12">
                                         <div class="form-group">
                                            <label>Category : </label>
                                             {{ ucwords(@$get_data->category_detail->category_name) }}
                                         </div>
                                      </div>  
                                   </div>
                                </div>
                             </div>
                             <div class="col-md-6">
                                <div class="card-body">
                                   <div class="row">                            
                                      <div class="col-md-12">
                                         <div class="form-group">
                                            <label>Status : </label>
                                            {!!  
                                             ($get_data->status=='1') ? '<span class="label label-success sdd">Active</span>' : '<span class="label label-warning  sdd">InActive</span>'
                                             !!}
                                         </div>
                                      </div>
                                      <div class="col-md-12">
                                         <div class="form-group">
                                            <label>Image. : </label>  
                                            @if(isset($get_data->media_url))
                                               <a href="{{ url('uploads/'.$get_data->media_url) }}" target="_balnk"  >
                                                   <img src="{{ url('uploads/'.$get_data->media_url) }}" style="width: 50px; padding: 8px;"  />
                                               </a>
                                            @endif
                                         </div>
                                      </div>  
                                   </div>
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