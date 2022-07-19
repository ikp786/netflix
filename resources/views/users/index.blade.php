@extends('layouts.master')


@section('content') 

    <ul class="breadcrumb">
        <li><a href="#">Home</a></li> 
        <li><a href="#">Users</a></li> 
    </ul> 

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2><span class="fa fa-users"></span> Manage Users</h2>
            </div>
            <div class="pull-right">  
                
            </div>
        </div>
    </div>  

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default">  

                <div class="page-head">        
                    <div class="page-head-text">
                        <h3 class="panel-title"><strong>Users</strong></h3> 
                    </div> 
                    <div class="page-head-controls">
                        <div style="float:right"> 
                            <!-- @can('user-create')
                                <a class="btn btn-primary" href="{{ route('users.create') }}"> Add </a>
                            @endcan -->
                        </div>
                        <div style="float:right">
                            <!-- <select style="padding: 5px; margin-right: 8px;" id="role_id" >
                                <option value="">Filter By</option>
                                @foreach($get_role as $role_dt) 
                                    <option value="{{ $role_dt->id }}">{{ $role_dt->name }}</option>
                                @endforeach
                            </select> -->
                        </div> 
                    </div>                    
                </div>  
                <div class="panel-default">
                    <div class="panel-body">

                        <div class="table-responsive">
                            <table id="my_data_table" class="table table-bordered table-striped table-actions" >
                                <thead>
                                    <tr>
                                        <th width="50">Sr No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Subscription</th>
                                        <th width="100">Status</th> 
                                        <th width="90">Create Date</th>
                                        <th width="280">Action</th>
                                    </tr>
                                </thead>
                                <tbody>       
                                      
                                </tbody>
                            </table>
                        </div>                                

                    </div>
                </div>
            </div>                                                

        </div> 
    </div>
 
    <input type="hidden" name="record_type" id="record_type" value="{{@$record_type}}" />
@endsection

 @section('script')    
    <script>

        $(document).ready(function() {  

            var URL = '{{url('/')}}';
 
            $("#role_id").change(function(){ 
                $('#my_data_table').DataTable().ajax.reload();  
            }); 

            call_table();
             
        });

        function call_table(){ 
            role_id = $("#role_id").val();
  
            if($('#my_data_table').length > 0){
                $('#my_data_table').DataTable({
                    processing:true,
                    serverSide:true,
                    "order": [[3,'desc']],
                    "pageLength": 5,
                    ajax: {
                        "url": URL+"/user_call_data",
                        "type": "GET",
                        "data": function(d) {
                            d.role_id = $("#record_type").val(), 
                            d.record_type = $("#record_type").val();
                        }
                    },
                    columns:[
                        {data:"DT_RowIndex",name:"DT_RowIndex",orderable:false},
                        {data:"name",name:"name"}, 
                        {data:"email",name:"email"}, 
                        {data:"phone",name:"phone"}, 
                        {data:"subscription_status_mn",name:"subscription_status_mn"},
                        {data:"status",name:"status"},
                        {data:"created_at",name:"created_at"},
                        {data:"action",name:"DT_RowIndex",orderable:false},
                    ]
                });
            }
        }
     </script>  
@endsection