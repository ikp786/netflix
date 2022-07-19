@extends('layouts.master')


@section('content')

   <ul class="breadcrumb">
        <li><a href="#">Home</a></li> 
        <li><a href="#">View Role</a></li> 
    </ul> 
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Role</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
            </div>
        </div>
    </div>  
   
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default">  

                <div class="page-head">        
                    <div class="page-head-text">
                        <h3 class="panel-title"><strong>View Role</strong></h3> 
                    </div>
                    <div class="page-head-controls">  
                    </div>                    
                </div>  
                <div class="panel-default">
                    <div class="panel-body"> 
                        <div class="row fil_ters">
                          <div class="col-md-12">
                             <div class="card-body">
                                <div class="row">
                                   <div class="col-md-12">  
                                       <div class="form-group">
                                           <label>Name : </label>
                                           {{ ucwords($role->name) }}
                                       </div> 
                                   </div> 
                                </div>
                                <div class="row">
                                   <div class="col-md-12">  
                                       <div class="form-group">
                                            <label>Permissions : </label> 
                                            @if(!empty($rolePermissions))
                                                @foreach($rolePermissions as $v)
                                                    <label class="label label-success">{{ $v->name }},</label>
                                                @endforeach
                                            @endif 
                                       </div> 
                                   </div> 
                                </div>
                             </div>
                          </div> 
                        </div> 
                           
                    </div>
                </div>
            </div>                                                

        </div> 
    </div>
    
@endsection 