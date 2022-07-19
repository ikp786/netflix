@extends('layouts.master')

@section('content') 
    <ul class="breadcrumb">
        <li><a href="#">Home</a></li>  
        <li><a href="#">Video</a></li> 
    </ul> 
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2><span class="fa fa-film"></span> Manage Video</h2>
            </div>
            <div class="pull-right">  
                
            </div>
        </div>
    </div>  
    <div id="message_box" class="row col-md-12" ></div>
    <div class="row wrap_box">
        <!-- <input type="text" id="fetch_product_id" value="{{ $product_id }}" > -->

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default">  

                <div class="page-head">        
                    <div class="page-head-text">
                        <h3 class="panel-title"><strong>Video</strong></h3> 
                    </div>
                    <div class="page-head-controls">  
                        <div style="float:right">
                            @can('product-create')
                               <a class="btn btn-primary" href="{{ route('sub_product.create') }}"> Add </a>
                            @endcan
                        </div>
                        <div style="float:right">
                            <!-- <select style="padding: 5px; margin-right: 8px;" id="fetch_product_id" >
                                <option value="">Filter By Product</option>
                                @foreach($get_product as $prod_dt) 
                                    <option {{ ($product_id==$prod_dt->id) ? 'selected' : '' }} value="{{ $prod_dt->id }}">{{ $prod_dt->product_name }}</option>
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
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Video Id</th>
                                        <th>Video URL</th>
                                        <th>Year</th>
                                        <th>U/A</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Video Type</th>
                                        <th width="100">Status</th> 
                                        <th width="90">Updated Date</th>
                                        <th>Rating</th>
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
            
            fetch_product_id = $('#fetch_product_id').val();
            
            $("#fetch_product_id").change(function(){  
                $('#my_data_table').DataTable().ajax.reload();  
            }); 

            if($('#my_data_table').length > 0){
                $('#my_data_table').DataTable({
                    processing:true,
                    serverSide:true,
                    "order": [[3,'desc']],
                    "pageLength": 5, 
                    ajax: {
                        "url": URL+"/sub_product_call_data",
                        "type": "GET",
                        "data": function(d) {
                            d.product_id = $("#fetch_product_id").val(); 
                        }
                    },
                    columns:[
                        {data:"DT_RowIndex",name:"DT_RowIndex",orderable:false},
                        {data:"banner_image",name:"banner_image"},
                        {data:"sub_product_title",name:"sub_product_title"},
                        {data:"id",name:"id"},
                        {data:"video_url",name:"video_url"},
                        {data:"year",name:"year"},
                        {data:"u_a",name:"u_a"},
                        {data:"category_name",name:"category_name"},
                        {data:"sub_category_name",name:"sub_category_name"},
                        {data:"sub_product_type_name",name:"sub_product_type_name"},
                        {data:"status",name:"status"},
                        {data:"updated_at",name:"updated_at"},
                        {data:"rating",name:"rating"},
                        {data:"action",name:"DT_RowIndex",orderable:false},
                    ]
                });
            }  
        });
     </script>  
@endsection