@extends('layouts.master')

<style>
   #inputPropImgRow .input-group{
      display: inline-flex;
   }
   #removePropImgRow{
      padding: 12px;
      margin-left: 3px;
   }
   .ctime{
      float: left;
      width: 80% !important;
      margin-left: 18px;
   }
   .cspan{
      float: left;
      padding-top: 9px;
      font-weight: bold;
   }
   .removePropImgRowAjax {
       padding: 12px !important;
       margin-left: 3px;
   }
</style>
@section('content')
   <ul class="breadcrumb">
        <li><a href="#">Home</a></li> 
        <li><a href="#">Edit {{ ucfirst($page_title) }}</a></li> 
    </ul> 
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit {{ ucfirst($page_title) }}</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
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
                        <h3 class="panel-title"><strong>Edit {{ ucfirst($page_title) }}</strong></h3> 
                    </div>
                    <div class="page-head-controls">  
                    </div>                    
                </div>  
                <div class="panel-default">
                    <div class="panel-body"> 

                            <form id="validate" action="{{ route('users.update',$user->id) }}"  class="form-horizontal comm_form" method="POST" role="form" enctype="multipart/form-data" >
  
                                @csrf
                                @method('PUT')
                                 <input type="hidden" name="page_title" value="{{ $page_title }}" />
                                 <div class="row fil_ters">
                                   <div class="col-md-6">
                                      <div class="card-body">
                                         <div class="row">

                                            <div class="col-md-12"> 
                                                <div class="form-group">
                                                    <label>Name<sub>*</sub></label>
                                                    <input type="text" class="form-control  validate[required]"
                                                     value="{{ old('name') ? old('name') : $user->name }}"
                                                     id="name" placeholder="Name" name="name" autocomplete="off">
                                                </div> 
                                            </div> 
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Email<sub>*</sub></label>
                                                    <div class="">
                                                     <input type="email" class="form-control  validate[required]" value="{{ old('email') ? old('email') : $user->email }}" id="name" placeholder="Email" name="email" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12"> 
                                                <div class="form-group">
                                                    <label>Country Code<sub>*</sub></label>
                                                    <input type="text" class="form-control  validate[required]"
                                                     value="{{ old('country_code') ? old('country_code') : $user->country_code }}"
                                                     id="country_code" maxlength="8" placeholder="Country Code" name="country_code" autocomplete="off">
                                                </div> 
                                            </div>
                                            <div class="col-md-12"> 
                                               <div class="form-group">
                                                  <label>Phone<sub>*</sub></label>
                                                  <input maxlength="15" type="text" class="form-control validate[required] decimal_number" value="{{ old('phone') ? old('phone') : $user->phone }}" id="phone" placeholder="Phone" name="phone" autocomplete="off" >
                                               </div> 
                                            </div>  
                                            <div class="col-md-12"> 
                                                <div class="form-group">
                                                    <label>Country<sub>*</sub></label>
                                                    <select name="country" id="country" class="form-control" >
                                                        <option selected="">Select Country</option> 
                                                        @foreach($get_country as $cat_data)
                                                            <option {{ (old('country')==$cat_data->countries_id || $cat_data->countries_id==@$user->country) ? "selected" : "" }} value="{{ $cat_data->countries_id }}">{{ ucwords($cat_data->countries_name) }}</option>
                                                        @endforeach 
                                                    </select>
                                                </div> 
                                          </div>
                                            <div class="col-md-12">
                                                <div class="form-group mensa">
                                                   <label style="">Profile Image</label>
                                                     @if($user->profile_photo_path)
                                                         <a href="{{ url('uploads/'.$user->profile_photo_path) }}" target="_balnk" >
                                                            <img src="{{ url('uploads/'.$user->profile_photo_path) }}" style="width: 17px; margin-left:3px;" />
                                                         </a>
                                                      @endif 
                                                    <br> 
                                                   <input type="file" class="form-control" name="profile_photo_path" >
                                                </div>
                                             </div>   
                                         </div>
                                      </div>
                                   </div>
                                   <div class="col-md-6">
                                      <!-- <div class="card-body">
                                         <div class="row">   
                                             <div class="col-md-12"> 
                                                <div class="form-group">
                                                   <label>Role<sub>*</sub></label>
                                                   {!! Form::select('roles[]', $roles,$user->role_id, array('class' => 'form-control','disabled')) !!}
                                                </div> 
                                             </div>   
                                             <div class="col-md-12"> 
                                                   <div class="form-group">
                                                      <label>Password</label>
                                                      <input type="password" class="form-control" value="" id="password" placeholder="Password" name="password" autocomplete="off">
                                                   </div> 
                                             </div>
                                             <div class="col-md-12"> 
                                                   <div class="form-group">
                                                      <label>Confirm Password</label>
                                                      <input type="password" class="form-control" value="" id="confirm-password" placeholder="Confirm Password" name="confirm-password" autocomplete="off">
                                                   </div> 
                                             </div> 
                                         </div>
                                      </div> -->
                                   </div>
                                </div> 
                               
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