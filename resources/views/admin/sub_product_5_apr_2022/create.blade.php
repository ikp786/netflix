@extends('layouts.master')
<style>
   #inputPropImgRow .input-group{
      display: inline-flex;
   }
   #removePropImgRow{
      padding: 12px;
      margin-left: 3px;
   }
</style>

@section('content')
    <ul class="breadcrumb">
        <li><a href="#">Home</a></li> 
        <li><a href="{{ route('product.index') }}">Video</a></li> 
        <li><a href="#">Video Create</a></li> 
    </ul> 
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Video</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('sub_product.index') }}"> Back</a>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default">  

                <div class="page-head">        
                    <div class="page-head-text">
                        <h3 class="panel-title"><strong>Video</strong></h3> 
                    </div>
                    <div class="page-head-controls">  
                    </div>                    
                </div>  
                <div class="panel-default">
                    <div class="panel-body">
                            

                         <form id="validate" action="{{ route('sub_product.store') }}"  class="form-horizontal comm_form" method="POST" role="form" enctype="multipart/form-data" > 
                             @csrf
                             <div class="row fil_ters">
                                <div class="col-md-6"> 
                                       <div class="form-group">
                                          <label>Video Title<sub>*</sub></label>
                                          <input type="text" class="form-control  validate[required]" value="{{ old('sub_product_title') }}" id="sub_product_title" placeholder="Video Title" name="sub_product_title" autocomplete="off">
                                       </div> 
                                </div> 
                                <div class="col-md-6"> 
                                       <div class="form-group">
                                          <label>Year<sub>*</sub></label>
                                          <input type="text" maxlength="4" class="form-control  validate[required]" value="{{ old('year') }}" id="year" placeholder="Year" name="year" autocomplete="off">
                                       </div> 
                                </div> 
                                <div class="col-md-6"> 
                                       <div class="form-group">
                                          <label>U/A<sub>*</sub></label>
                                          <input type="text" class="form-control  validate[required]" value="{{ old('u_a') }}" id="u_a" placeholder="U/A" name="u_a" autocomplete="off">
                                       </div> 
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <label>Category<sub>*</sub></label>
                                       <div class="">
                                          <select name="category_id" id="category_id" class="form-control" >
                                             <option selected="">Select Category</option> 
                                                 @foreach($get_category as $cat_data)
                                                    <option value="{{ $cat_data->id }}">{{ ucwords($cat_data->category_name) }}</option>
                                                 @endforeach 
                                          </select>
                                       </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <label>Sub Category<sub>*</sub></label>
                                       <div class="">
                                          <select name="sub_category_id" id="speciality_id_mn" class="form-control" >
                                             <option selected="">Select Sub Category</option> 
                                          </select>
                                       </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <label>Banner Image<sub>*</sub></label> 
                                          <input type="file" name="banner_image" id="frm_banner" class="form-control validate[required]" placeholder="Banner Image" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <label>Attach Video<sub>*</sub></label> 
                                          <input type="file" name="video" id="frm_media_url" class="form-control validate[required]" placeholder="Image" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status<sub>*</sub></label> 
                                        <select name="status" class="form-control" >
                                            <option value="">Select option</option>
                                            <option {{ (old('status')=="1") ? "selected" : "" }}  value="1">Active</option>
                                            <option {{ (old('status')=="0") ? "selected" : "" }}  value="0">InActive</option>
                                        </select> 
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Video Type</label> 
                                        <select name="video_type" class="form-control" >
                                            <option value="">Select option</option>
                                            <option {{ (old('video_type')=="1") ? "selected" : "" }}  value="1">Trending</option>
                                            <option {{ (old('video_type')=="2") ? "selected" : "" }}  value="2">Popular</option>
                                            <option {{ (old('video_type')=="3") ? "selected" : "" }}  value="3">Upcomming</option>
                                        </select> 
                                    </div>
                                </div>
                             </div>
                             <div class="row fil_ters">
                                <div class="col-md-12"> 
                                    <div class="form-group">
                                       <label>Description</label> 
                                          <textarea name="description" style="border: 1px solid #D5D5D5;  background: #F9F9F9;" rows="6" cols="30">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                             </div><br/>
                             <div class="row">
                                 <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                                     <button type="submit" class="btn btn-primary">Submit</button>
                                 </div>
                             </div>
                         </form>

                    </div>
                </div>
            </div>                                                

        </div> 
    </div>
     
@endsection

@section('script')    
    <script>

        $(document).ready(function() { 
            
            $("#category_id").change(function(){
                 
               categories_id = $(this).val(); 
               
               $.ajaxSetup({
                   headers: { 
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   }
               }); 
 
               var form_data = new FormData();
               form_data.append("category_id",categories_id); 
                 
                $.ajax({
                    type:"POST", 
                    url: URL+"/api/get_sub_category",
                    data:form_data, 
                    enctype: 'multipart/form-data',
                    processData: false,  // Important!
                    contentType: false,
                    cache: false,
                    dataType: "JSON", 
                    success: function(response){    
                        $('#speciality_id_mn').empty(); 
                        
                        if(response.data.length>0){ 
                           htm = '<option value="">Nothing Select</option>';
                  
                           for(i=0;i<response.data.length;i++){
                                 htm +='<option value="'+response.data[i].sub_category_id+'">'+response.data[i].sub_category_name+'</option>';
                           }
                            $('#speciality_id_mn').append(htm);
                            
                            $("#speciality_id_mn").find('option:selected').prop('selected',false);
                            $("#speciality_id_mn").trigger('chosen:updated');

                        }else{
                            htm = '<option value="">Nothing Select</option>';
                            $('#speciality_id_mn').append(htm);
                            
                            $("#speciality_id_mn").find('option:selected').prop('selected',false);
                            $("#speciality_id_mn").trigger('chosen:updated');

                        }
                    }
               });
            });  
        });
     </script>  
@endsection
