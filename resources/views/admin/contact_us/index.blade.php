@extends('layouts.master')

@section('content') 

    <ul class="breadcrumb">
        <li><a href="#">Home</a></li> 
        <li><a href="#">Enquiry</a></li> 
    </ul> 

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2><span class="fa fa-support"></span> Enquiry</h2>
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
                        <h3 class="panel-title"><strong>Enquiry</strong></h3> 
                    </div>
                    <div class="page-head-controls">   
                    </div>                    
                </div>  
                <div class="panel-default">
                    <div class="panel-body">
                        <div class="table-responsive"> 

                            <table id="my_data_table" class="table table-bordered table-striped table-actions" >
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Subject</th>
                                        <th>Status</th> 
                                        <th>Create Date</th>
                                        <th width="80px">Action</th>
                                    </tr>
                                </thead> 
                            </table>
                        </div>                           

                    </div>
                </div>
            </div>                                                

        </div> 
    </div> 
@endsection
 
@section('script')    
    <script>

        $(document).ready(function() { 
          if($('#my_data_table').length > 0){
                $('#my_data_table').DataTable({
                    processing:true,
                    serverSide:true,
                    "pageLength": 5,
                    ajax: URL+"/contact_us_call_data",
                    columns:[
                        {data:"DT_RowIndex",name:"DT_RowIndex",orderable:false},
                        {data:"user_name",name:"user_name"},
                        {data:"email",name:"email"}, 
                        {data:"mobile",name:"mobile"}, 
                        {data:"enquiry",name:"enquiry"}, 
                        {data:"status",name:"status"},
                        {data:"created_at",name:"created_at"},
                        {data:"action",name:"DT_RowIndex",orderable:false},
                    ]
                });
            }  
        });
    </script>  
@endsection
    

  