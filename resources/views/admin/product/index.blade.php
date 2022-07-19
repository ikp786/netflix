@extends('layouts.master')

@section('content') 
    <ul class="breadcrumb">
        <li><a href="#">Home</a></li> 
        <li><a href="#">Sub Category</a></li> 
    </ul> 
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2><span class="fa fa-list-alt"></span> Manage Sub Category</h2>
            </div>
            <div class="pull-right">  
                
            </div>
        </div>
    </div>  
    <div id="message_box" class="row col-md-12" ></div>
    <div class="row wrap_box">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default">  

                <div class="page-head">        
                    <div class="page-head-text">
                        <h3 class="panel-title"><strong>Sub Category</strong></h3> 
                    </div>
                    <div class="page-head-controls">  
                        @can('product-create')
                           <a class="btn btn-primary" href="{{ route('product.create') }}"> Add </a>
                        @endcan
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
                                        <th>Category</th>
                                        <th>Image</th>
                                        <th width="100">Status</th>  
                                        <th width="90">Create Date</th>
                                        <th width="180">Action</th>
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
 
@endsection

 @section('script')    
    <script>

        $(document).ready(function() { 
   
            if($('#my_data_table').length > 0){
                $('#my_data_table').DataTable({
                    processing:true,
                    serverSide:true,
                    "order": [[3,'desc']],
                    "pageLength": 5,
                    ajax: URL+"/product_call_data",
                    columns:[
                        {data:"DT_RowIndex",name:"DT_RowIndex",orderable:false},
                        {data:"product_name",name:"product_name"},
                        {data:"category_id",name:"category_id"},
                        {data:"media_url",name:"media_url"},
                        {data:"status",name:"status"}, 
                        {data:"created_at",name:"created_at"},
                        {data:"action",name:"DT_RowIndex",orderable:false},
                    ]
                });
            }  
        });
     </script>  
@endsection