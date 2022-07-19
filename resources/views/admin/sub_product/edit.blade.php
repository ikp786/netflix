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
        <li><a href="#">Edit Video</a></li> 
    </ul> 
    <div class="row">
        <div class="col-lg-12 margin-tb"> 
            <div class="pull-left">
                <h2>Edit Video</h2>
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
                        <h3 class="panel-title"><strong>Edit Video</strong></h3> 
                    </div>
                    <div class="page-head-controls">  
                    </div>                    
                </div>  
                <div class="panel-default">
                    <div class="panel-body"> 

                           <form id="validate" action="{{ route('sub_product.update',$get_data->id) }}"  class="form-horizontal comm_form" method="POST" role="form" enctype="multipart/form-data"  > 

                                @csrf
                                @method('PUT')

                                 <div class="row fil_ters">
                                    <div class="col-md-6"> 
                                       <div class="form-group">
                                          <label>Video Title<sub>*</sub></label>
                                          <input type="text" class="form-control  validate[required]" value="{{ old('sub_product_title') ? old('sub_product_title') : $get_data->sub_product_title }}" id="sub_product_title" placeholder="Video Title" name="sub_product_title" autocomplete="off">
                                       </div>   
                                    </div> 
                                    <div class="col-md-6"> 
                                       <div class="form-group">
                                          <label>Year<sub>*</sub></label>
                                          <input type="text" maxlength="4" class="form-control  validate[required]" value="{{ old('year') ? old('year') : $get_data->year }}" id="year" placeholder="Year" name="year" autocomplete="off">
                                       </div> 
                                    </div>  
                                    <div class="col-md-6"> 
                                       <div class="form-group">
                                          <label>U/A<sub>*</sub></label>
                                          <input type="text" class="form-control  validate[required]" value="{{ old('u_a') ? old('u_a') : $get_data->u_a }}" id="u_a" placeholder="U/A" name="u_a" autocomplete="off">
                                       </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                           <label>Category<sub>*</sub></label>
                                           <div class="">
                                              <select name="category_id" id="category_id" class="form-control" >
                                                 <option selected="">Select Category</option> 
                                                     @foreach($get_category as $cat_data)
                                                        <option {{ (old('product_id')==$cat_data->id || $cat_data->id==$get_data->category_id) ? "selected" : "" }}  value="{{ $cat_data->id }}">{{ ucwords($cat_data->category_name) }}</option>
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
                                                   <option selected="">Select Product</option> 
                                                    @foreach($GetProduct as $prod_data)
                                                        <option {{ (old('product_id')==$prod_data->id || $prod_data->id==$get_data->product_id) ? "selected" : "" }}  value="{{ $prod_data->id }}">{{ ucwords($prod_data->product_name) }}</option>
                                                     @endforeach
                                                </select>
                                           </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status<sub>*</sub></label> 
                                            <select name="status" class="form-control" >
                                                <option value="">Select option</option>
                                                <option {{ (old('status')=="1" || $get_data->status=="1") ? "selected" : "" }}  value="1">Active</option>
                                                <option {{ (old('status')=="0" || $get_data->status=="0") ? "selected" : "" }}  value="0">InActive</option>
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Video Type</label> 
                                            <select name="video_type" class="form-control" >
                                                <option value="">Select option</option>
                                                <option {{ (old('video_type')=="1" || $get_data->video_type=="1") ? "selected" : "" }}  value="1">Trending</option>
                                                <option {{ (old('video_type')=="2" || $get_data->video_type=="2") ? "selected" : "" }}  value="2">Popular</option>
                                                <option {{ (old('video_type')=="3" || $get_data->video_type=="3") ? "selected" : "" }}  value="3">Upcoming</option>
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                           <label>Banner Image<sub>*</sub></label> 
                                              <input type="file" name="banner_image" id="frm_banner" class="form-control" placeholder="Banner Image" >

                                              @if(isset($get_data->banner_image)) 
                                                <a target="_blank" href="{{ url('uploads/'.$get_data->banner_image) }}" >
                                                    <img src="{{ url('uploads/'.$get_data->banner_image) }}" style="float:right; height: 160; padding: 8px;"  />
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Media<sub>*</sub></label> 
                                            <input type="file" name="video" id="frm_media_url" class="form-control" placeholder="Name" >
                                            @if(isset($get_data->sub_media_url)) 
                                                <a target="_blank" href="{{ url('uploads/'.$get_data->sub_media_url) }}" >
                                                    <video  style="height:150" controls>
                                                      <source src="{{ url('uploads/'.$get_data->sub_media_url) }}" > 
                                                    </video>
                                                </a>
                                            @endif
                                        </div>
                                    </div> --> 
                                 </div>
                                 <div class="row fil_ters">
                                    <div class="col-md-12"> 
                                        <div class="form-group">
                                           <label>Description</label> 
                                              <textarea name="description" style="border: 1px solid #D5D5D5;  background: #F9F9F9;" rows="6" cols="30">{{ old('description') ? old('description') : $get_data->sub_product_description }}</textarea>
                                        </div>
                                    </div>
                                 </div><br/>
                                 <div class="row">
                                     <div class="col-xs-12 col-sm-12 col-md-6">
                                         <h3 class="panel-title"><strong>Videos</strong></h3><br/><br/>
                                     </div>
                                     <div class="col-xs-12 col-sm-12 col-md-6 text-right">
                                        <button id="addMoreVideoRow" type="button" class="btn btn-sm btn-info">Add More Video</button>
                                     </div>
                                 </div>
                                 <div class="">
                                    <div class="text-center" style="margin: 20px 0px 20px 0px;">
                                    </div> 
                                       <div class="row">
                                          <div class="col-lg-12">  
                                             <div id="newMoreVideoRow"> 

                                                @foreach($get_more_video_detail as $more_vid)
                                                    <input type="hidden" name="more_video_edit_id[]" value="{{ $more_vid->id }}" >
                                                    <div id="inputMoreVideoRow_{{ $more_vid->id }}" class="more_vid_append">
                                                        <div class="col-lg-5">
                                                            <select name="language_type_id[]" id="vid_lang_0" class="form-control"><option value="">Select Language</option>
                                                                @foreach($get_lang_types as $lang_val)
                                                                     <option {{ ($lang_val->id==$more_vid->language_type_id) ? 'selected' : ''}} value="{{ $lang_val->id}}">{{ $lang_val->language_title}}</option>   
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-5">  
                                                            <input style="margin-left: 4px;" type="file" class="form-control" name="vid_media_url[]"> 
                                                            @if(isset($more_vid->media_url))  
                                                                <a target="_blank" href="{{ url('uploads/'.$more_vid->media_url) }}" >
                                                                    <video  style="height:100" controls>
                                                                      <source src="{{ url('uploads/'.$more_vid->media_url) }}" > 
                                                                    </video>
                                                                </a>
                                                            @endif 
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <button  data-id="{{$more_vid->id}}" type="button" class="btn btn-danger removeMoreVideoRowAjax"><i class="fa fa-trash"></i></button>
                                                        </div>
                                                    </div> 
                                                @endforeach
                                             </div> 
                                          </div>
                                       </div> 
                                 </div>
                                 <hr/>
                                 <div class="row">
                                     <div class="col-xs-12 col-sm-12 col-md-6">
                                         <h3 class="panel-title"><strong>Video Cast</strong></h3><br/><br/>
                                     </div>
                                     <div class="col-xs-12 col-sm-12 col-md-6 text-right">
                                        <button id="addVideoCastRow" type="button" class="btn btn-sm btn-info">Add Cast</button>
                                     </div>
                                 </div>
                                 <div class="">
                                    <div class="text-center" style="margin: 20px 0px 20px 0px;">
                                    </div> 
                                       <div class="row">
                                          <div class="col-lg-12"> 
                                             <div id="newVideoCastRow"> 
                                                @foreach($get_video_casting_detail as $cast_vid)
                                                    <input type="hidden" name="cast_video_edit_id[]" value="{{ $cast_vid->id }}" >
                                                    <div id="inputVideoCastRow_{{ $cast_vid->id }}" class="cast_vid_append">
                                                        <div class="col-lg-4">
                                                            <input type="text" placeholder="Title" class="form-control" maxlength="200" name="cast_title[]" value="{{$cast_vid->cast_title}}" />
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <textarea name="cast_description[]" placeholder="Description" class="form-control rounded-0">{{$cast_vid->description}}</textarea>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <input style="margin-left: 4px;" type="file" class="form-control" name="cast_image[]"> 
                                                            @if(isset($cast_vid->cast_image)) 
                                                                <a target="_blank" href="{{ url('uploads/'.$cast_vid->cast_image) }}" >
                                                                    <img style="width:30px" src="{{ url('uploads/'.$cast_vid->cast_image) }}" /> 
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <div class="col-lg-1">
                                                            <button  data-id="{{$cast_vid->id}}" type="button" class="btn btn-danger removeVideoCastRowAjax"><i class="fa fa-trash"></i></button>
                                                        </div>
                                                    </div>

                                                @endforeach
                                             </div> 
                                          </div>
                                       </div> 
                                 </div>
                                 <hr/>

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