@extends('layouts.master')


@section('content') 

    <ul class="breadcrumb">
        <li><a href="#">Home</a></li> 
        <li><a href="#">Subscribed Users</a></li> 
    </ul> 

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="page-title">                    
        <h2><span class="fa fa-user-plus"></span> {{ $user_name }}</h2>
    </div>
    <style>
        .is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + 0.75rem);
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
        .s_btn1{
            margin-right: 3px;
        }
    </style>
    <div id="message_box" class="row col-md-12" ></div>
    <div class="row wrap_box">        
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-default">  

                <div class="page-head">        
                    <div class="page-head-text">
                        <h3 class="panel-title"><strong>Membership Plan History</strong></h3>
                        
                    </div>
                    <div class="page-head-controls">  
                    </div>                    
                </div>  
                <div class="panel-default">
                    <div class="panel-body">
                        <input type="hidden" id="fetch_user_id" value="{{ $user_id }}" >
                        <div class="table-responsive">
                            <table id="my_data_table" class="table table-bordered table-striped table-actions" >
                                <thead>
                                    <tr>
                                        <th width="50">Sr No</th> 
                                        <th>Plan</th>
                                        <th>Txn. Id</th>
                                        <th>Month</th>
                                        <th>Status</th>
                                        <th width="90">Expiry Date</th> 
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
        var URL = '{{url('/')}}';  
           
        $(document).ready(function() {  

            $(".reset_form").click(function(){
                $('#record_id').val('');
                this.form.reset();
                $('#show_cat_img').html('');
            });

            if($('#my_data_table').length > 0){
                $('#my_data_table').DataTable({
                    processing:true,
                    serverSide:true,
                    "order": [[3,'desc']],
                    "pageLength": 5, 
                    ajax: {
                        "url": URL+"/subscribed_plan_call_data",
                        "type": "GET",
                        "data": function(d) {
                            d.user_id = $("#fetch_user_id").val(); 
                        }
                    },
                    columns:[
                        {data:"DT_RowIndex",name:"DT_RowIndex",orderable:false}, 
                        {data:"plan_title",name:"plan_title"},
                        {data:"transaction_id",name:"transaction_id"},
                        {data:"plan_for_month",name:"plan_for_month"},
                        {data:"status",name:"status"},
                        {data:"expiry_date",name:"expiry_date"}, 
                    ]
                });
            }  
        });
     </script> 
 @endsection


