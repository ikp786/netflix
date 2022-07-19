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
</style>

@section('content')
    <ul class="breadcrumb">
        <li><a href="#">Home</a></li> 
        <li><a href="#">User Create</a></li> 
    </ul> 
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
              <h2>Add New User</h2>
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
                        <h3 class="panel-title"><strong>User</strong></h3> 
                    </div>
                    <div class="page-head-controls">  
                    </div>                    
                </div>  
                <div class="panel-default">
                    <div class="panel-body"> 

                            <form id="validate" action="{{ route('users.store') }}"  class="form-horizontal comm_form" method="POST" role="form" enctype="multipart/form-data"  > 
                             @csrf
                             <div class="row fil_ters">
                                <div class="col-md-6">
                                   <div class="card-body">
                                      <div class="row">

                                         <div class="col-md-12"> 
                                               <div class="form-group">
                                                  <label>User Name<sub>*</sub></label>
                                                  <input type="text" class="form-control validate[required]" value="{{ old('name') }}" id="name" placeholder="User Name" name="name" autocomplete="off" >
                                               </div> 
                                         </div> 
                                         <div class="col-md-12"> 
                                               <div class="form-group">
                                                  <label>Email<sub>*</sub></label>
                                                  <input type="email" class="form-control validate[required]" value="{{ old('email') }}" id="email" placeholder="Email" name="email" autocomplete="off" >
                                               </div> 
                                         </div>
                                         <div class="col-md-12"> 
                                               <div class="form-group">
                                                  <label>Country Code<sub>*</sub></label>
                                                  <input maxlength="10" type="text" class="form-control validate[required] decimal_number" value="{{ old('country_code') }}" id="country_code" placeholder="Country Code" name="country_code" autocomplete="off" >
                                               </div> 
                                          </div>
                                         <div class="col-md-12"> 
                                               <div class="form-group">
                                                  <label>Phone<sub>*</sub></label>
                                                  <input maxlength="15" type="text" class="form-control validate[required] decimal_number" value="{{ old('phone') }}" id="phone" placeholder="Phone" name="phone" autocomplete="off" >
                                               </div> 
                                          </div>
                                          <div class="col-md-12"> 
                                                <div class="form-group">
                                                    <label>Country<sub>*</sub></label>
                                                    <select name="country" id="country" class="form-control" >
                                                        <option selected="">Select Category</option> 
                                                        @foreach($get_country as $cat_data)
                                                            <option {{ (old('country')==$cat_data->countries_id) ? "selected" : "" }} value="{{ $cat_data->countries_id }}">{{ ucwords($cat_data->countries_name) }}</option>
                                                        @endforeach 
                                                    </select>
                                                </div> 
                                          </div>
                                          <div class="col-md-12">
                                             <div class="form-group mensa">
                                                <label style="">Profile Image</label> <br> 
                                                <input type="file" class="form-control" name="profile_photo_path" >
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
                                                  <label>Role<sub>*</sub></label>
                                                  {!! Form::select('roles[]', $roles,[], array('id' => 'role_type','class' => 'form-control','')) !!}
                                               </div> 
                                          </div>
                                          
                                         <div class="col-md-12"> 
                                            <div class="form-group">
                                               <label>Password<sub>*</sub></label>
                                               <input type="password" class="form-control validate[required]" value="{{ old('password') }}" id="password" placeholder="Password" name="password" autocomplete="off">
                                            </div> 
                                         </div>
                                         <div class="col-md-12"> 
                                            <div class="form-group">
                                               <label>Confirm Password<sub>*</sub></label>
                                               <input type="password" class="form-control  validate[required]" value="{{ old('confirm-password') }}" id="confirm-password" placeholder="Confirm Password" name="confirm-password" autocomplete="off">
                                            </div> 
                                         </div>
                                         <div class="col-md-12 patient_cls">
                                             <div class="form-group mensa">
                                                <label style="">Report</label> <br> 
                                                <input type="file" class="form-control" name="report" >
                                             </div>
                                          </div>
                                      </div>
                                   </div>
                                </div>
                             </div>   
                             <hr/> 
                             <div class="row">
                                 <div class="col-xs-12 col-sm-12 col-md-12 text-right"><br/>
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
      $(document).ready(function(){

         var URL = '{{url('/')}}';  

         $('.doctor_cls').show();
         $('.patient_cls').hide();
         $("#role_type").change(function(){
               type = $(this).val();
               if(type=='3'){
                  $('.doctor_cls').show();
                  $('.patient_cls').hide();
               }
               else{
                  $('.patient_cls').show();
                  $('.doctor_cls').hide();
               }
         });

         $("#categories_ids_mn").change(function(){
                 
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
                    url: URL+"/api/get_speciality",
                    data:form_data, 
                    enctype: 'multipart/form-data',
                    processData: false,  // Important!
                    contentType: false,
                    cache: false,
                    dataType: "JSON", 
                    success: function(response){   
                        // alert(response.data.length);
                        $('#speciality_id_mn').empty(); 

                        if(response.data.length>0){
                           // htm = '<option value="">Nothing Select</option>';
                           htm = '';
                           for(i=0;i<response.data.length;i++){
                                 htm +='<option value="'+response.data[i].id+'">'+response.data[i].specialist_name+'</option>';
                           }
                        
                           // $('#speciality_id_mn').html(htm);
 
                             $('#speciality_id_mn').append(htm);
                            //  $('#speciality_id_mn').multiselect('refresh');


                            $("#speciality_id_mn").find('option:selected').prop('selected',false);
                            $("#speciality_id_mn").trigger('chosen:updated');

                           // $("#speciality_id_mn").trigger('liszt:updated');
                        }
                    }
               });
         });

      }); 
  </script> 
 @endsection