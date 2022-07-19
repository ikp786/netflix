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
        <li><a href="#">Sub Category Create</a></li> 
    </ul> 
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add Sub Category</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('product.index') }}"> Back</a>
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
                        <h3 class="panel-title"><strong>Sub Category</strong></h3> 
                    </div>
                    <div class="page-head-controls">  
                    </div>                    
                </div>  
                <div class="panel-default">
                    <div class="panel-body">
                            

                         <form id="validate" action="{{ route('product.store') }}"  class="form-horizontal comm_form" method="POST" role="form" enctype="multipart/form-data" > 
                             @csrf
                             <div class="row fil_ters">
                                <div class="col-md-6">
                                   <div class="card-body">
                                      <div class="row">
                                         <div class="col-md-12"> 
                                               <div class="form-group">
                                                  <label>Sub Category Name<sub>*</sub></label>
                                                  <input type="text" class="form-control  validate[required]" value="{{ old('product_name') }}" id="product_name" placeholder="Sub Category Name" name="product_name" autocomplete="off">
                                               </div> 
                                         </div>
                                         <div class="col-md-12"> 
                                               <div class="form-group">
                                                  <label>Image</label>
                                                  <input type="file" name="media_url" id="frm_media_url" class="form-control validate[required]" placeholder="Name" >
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
                                               <label>Category<sub>*</sub></label>
                                               <div class="">
                                                  <select name="category_id" id="category_id" class="form-control" >
                                                     <option selected="">Select Category</option> 
                                                         @foreach($GetCategory as $cat_data)
                                                            <option {{ (old('category_id')==$cat_data->id) ? "selected" : "" }} value="{{ $cat_data->id }}">{{ ucwords($cat_data->category_name) }}</option>
                                                         @endforeach 
                                                  </select>
                                               </div>
                                            </div>
                                         </div>   
                                          <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Status</label> 
                                                <select name="status" class="form-control" >
                                                    <option value="">Select option</option>
                                                    <option {{ (old('status')=="1") ? "selected" : "" }}  value="1">Active</option>
                                                    <option {{ (old('status')=="0") ? "selected" : "" }}  value="0">InActive</option>
                                                </select> 
                                            </div>
                                          </div> 
                                       </div>
                                   </div>
                                </div>
                             </div> <br/>
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