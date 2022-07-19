@extends('layouts.master')
<style type="text/css">
     label {
        font-size: 15px;
        line-height: 34px;
    }    
</style> 
@section('content')
   <ul class="breadcrumb">
        <li><a href="#">Home</a></li> 
        <li><a href="#">View {{ $page_title }}</a></li> 
    </ul> 
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> View {{ ucfirst($page_title) }}</h2>
            </div>
            <div class="pull-right">
                @if($page_title=='profile')
                    <a class="btn btn-primary" href="{{ url('profile_edit') }}"> Edit</a>
                @endif
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default">  
                <div class="page-head">        
                    <div class="page-head-text">
                        <h3 class="panel-title"><strong>View {{ ucfirst($page_title) }}</strong></h3> 
                    </div>
                    <div class="page-head-controls"> 
                    </div>                    
                </div>  
                <div class="panel-default">
                    <div class="panel-body">
                        <div class="row fil_ters">  

                            <div class="col-md-6"> 
                                <div class="table-responsive">
                                    <table class="table table-bordered" >
                                        <tr>
                                            <th>Name</th>
                                            <td>{{ ucwords($user->name) }}</td>
                                        </tr> 
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $user->email }}</td>
                                        </tr> 
                                        <tr>
                                            <th>Phone</th>
                                            <td>{{ $user->phone }}</td>
                                        </tr>   
                                    </table>
                                </div>   
                            </div>


                            <div class="col-md-6"> 
                                <div class="table-responsive">
                                    <table class="table table-bordered" >   
                                        <tr>
                                            <th>Profile Image</th>
                                            <td>
                                                @if($user->profile_photo_path)
                                                    <a href="{{ url('uploads/'.$user->profile_photo_path) }}" target="_balnk" >
                                                        <img src="{{ url('uploads/'.$user->profile_photo_path) }}" style="width: 47px; margin-left:3px;" />
                                                    </a>
                                                @endif 
                                            </td>
                                        </tr> 
                                        <tr>
                                            <th>Role</th>
                                            <td>{{ @$user->getRoleNames()->name }}</td>
                                        </tr>  
                                    </table>
                                </div>   
                            </div>
                        </div>   
                  </div>
                </div>
            </div>
        </div> 
    </div>
    
@endsection 
 