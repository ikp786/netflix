@extends('layouts.master')


@section('content') 

    <ul class="breadcrumb">
        <li><a href="#">Home</a></li> 
        <li><a href="#">Membership Plan</a></li> 
    </ul> 

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="page-title">                    
        <h2><span class="fa fa-sitemap"></span> Manage Membership Plan</h2>
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
        <div class="col-md-4 col-sm-4 col-xs-5">
            <form id="validate" action="{{ route('subscription_plan.store') }}"  class="form-horizontal comm_form" method="POST" role="form" >
                @csrf
                <input type="hidden" id="record_id" class="form-control" name="record_id" value="" />
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3><span class="fa fa-label"></span> Add/Edit Membership Plan</h3> 
                    </div> 
                    <div class="panel-body form-group-separated">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Plan Title <code>*</code></label>
                            <div class="col-md-9 col-xs-7"> 
                                <input type="text" name="plan_title" id="frm_plan_title" class="form-control validate[required]" placeholder="Plan Title">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Duration(In Month) <code>*</code></label>
                            <div class="col-md-9 col-xs-7"> 
                                <input type="text" maxlength="4" name="plan_for_month" id="frm_plan_for_month" class="form-control validate[required] decimal_number" placeholder="Duration(In Month)">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Actual Price <code>*</code></label>
                            <div class="col-md-9 col-xs-7"> 
                                <input type="text" name="price" id="frm_price" class="form-control validate[required] decimal_number" placeholder="Price" maxlength="20" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Discounted Price <code>*</code></label>
                            <div class="col-md-9 col-xs-7"> 
                                <input type="text" name="discount_price" id="frm_discount_price" class="form-control validate[required] decimal_number" placeholder="Discounted Price" maxlength="20" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Discount(%) <code>*</code></label>
                            <div class="col-md-9 col-xs-7"> 
                                <input type="text" name="discount_in_percent" id="frm_discount_in_percent" class="form-control validate[required] decimal_number" placeholder="Discount(%)"  maxlength="10" >
                            </div>
                        </div>      
                        <div class="form-group">
                            <div class="col-md-12 col-xs-5">
                                <button class="btn btn-default reset_form" type="button" onClick="$('#validate').validationEngine('hide');" >Clear Form</button>                               
                                <!-- <button type="submit" class="btn btn-primary pull-right">Submit</button> -->

                                <button type="submit" id="common_form_submit" class="btn btn-primary pull-right">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-7">
            <div class="panel panel-default">  

                <div class="page-head">        
                    <div class="page-head-text">
                        <h3 class="panel-title"><strong>Membership Plan</strong></h3>
                        
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
                                        <th width="50">Sr No</th>
                                        <th>Plan Title</th>
                                        <th>Duration(In Month)</th>
                                        <th>Actual Price</th>
                                        <th>Discount(%)</th>
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

    <div class="modal animated fadeIn" id="modal_view_dt" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="smallModalHead">Subscription Plan Information</h4>
                    </div> 
                    <div class="modal-body form-horizontal form-group-separated">                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">Plan Title</label>
                            <div class="col-md-9">
                                <span class="form-control" id="show_plan_title" ></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Duration(In Month)</label>
                            <div class="col-md-9">
                                <span class="form-control" id="show_plan_for_month" ></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Actual Price</label>
                            <div class="col-md-9">
                                <span class="form-control" id="show_price" ></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Discounted Price</label>
                            <div class="col-md-9">
                                <span class="form-control" id="show_discount_price" ></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Discount(%)</label>
                            <div class="col-md-9">
                                <span class="form-control" id="show_discount_in_percent" ></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"> 
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('script')  
    <script> 

        var URL = '{{url('/')}}';  
        
        $(document).on("click", '.view_in_modal', function(e){   
            
            $.ajaxSetup({
                headers: { 
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }); 

            form_data_id = $(this).data('id');    

            var form_data = new FormData();
            form_data.append("record_id",form_data_id); 
             
            $.ajax({
                type:"POST", 
                url: URL+"/subscription_plan_get_data",
                data:form_data, 
                enctype: 'multipart/form-data',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                dataType: "JSON", 
                success: function(response){   
                    if(response.result.length>0){ 

                        plan_title = response.result[0].plan_title;
                        plan_for_month = response.result[0].plan_for_month;                         
                        price = response.result[0].price; 
                        discount_price = response.result[0].discount_price;  
                        discount_in_percent = response.result[0].discount_in_percent;  

                        $('#show_plan_title').text(plan_title);
                        $('#show_plan_for_month').text(plan_for_month); 
                        $('#show_price').text(price);
                        $('#show_discount_price').text(discount_price);
                        $('#show_discount_in_percent').text(discount_in_percent);
                    }  
                }
            });
        });

        $(document).on("click", '.form_data_act', function(e){  // worked with dynamic loaded jquery content
                $('#show_cat_img').html('');
            $.ajaxSetup({
                headers: { 
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }); 

            form_data_id = $(this).data('id');   

            $('#record_id').val(form_data_id);

                var form_data = new FormData();
                form_data.append("record_id",form_data_id); 
                 
                $.ajax({
                    type:"POST", 
                    url: URL+"/subscription_plan_get_data",
                    data:form_data, 
                    enctype: 'multipart/form-data',
                    processData: false,  // Important!
                    contentType: false,
                    cache: false,
                    dataType: "JSON", 
                    success: function(response){   
                        if(response.result.length>0){
                            // console.log(response.result[0]); 

                            id = response.result[0].id;
                            
                            plan_title = response.result[0].plan_title;
                            plan_for_month = response.result[0].plan_for_month;                         
                            price = response.result[0].price;  
                            discount_price = response.result[0].discount_price;  
                            discount_in_percent = response.result[0].discount_in_percent;

                            $('#record_id').val(id);
                            $('#frm_plan_title').val(plan_title);
                            $('#frm_plan_for_month').val(plan_for_month);
                            $('#frm_price').val(price);
                            $('#frm_discount_price').val(discount_price);
                            $('#frm_discount_in_percent').val(discount_in_percent);

                        }
                        $('#message_box').html(''); 
 
                    }
                });
        });

        $(document).ready(function() { 
            
            $(".comm_form").submit(function(e) {
                
                e.preventDefault(); 

                $.ajaxSetup({
                    headers: { 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }); 

                var form = $(this);
                var url = form.attr('action');
                
                errorFlag = true;
                $(this).find("input, select, textarea").each(function () {

                    if ($(this).hasClass("validate[required]") && $(this).val() == "") {
 
                        $(this).addClass("is-invalid"); 
                        errorFlag = false;
                    }
                });

                $('#message_box').html('');

                if(errorFlag){  
                    $.ajax({ 
                        type:"POST", 
                        url: url,
                        data:new FormData(this), 
                        enctype: 'multipart/form-data',
                        processData: false,  // Important!
                        contentType: false,
                        cache: false,
                        dataType: "JSON",  
                        success: function(response)
                        {    
                             if(response.status=='2' || response.status=='1' || response.status=='0'){    

                                if(response.status=='2')
                                    alert_type = 'alert-warning';
                                else if(response.status=='1')
                                    alert_type = 'alert-success';
                                else
                                     alert_type = 'alert-danger';

                                var htt_box = '<div class="alert '+alert_type+' " role="alert">'+
                                                '<button type="button" class="close" data-dismiss="alert">'+
                                                '<span aria-hidden="true">×</span>'+
                                                '<span class="sr-only">Close</span></button>'+ response.message+'</div>';

                                $('#message_box').html(htt_box);

                                $('#my_data_table').DataTable().ajax.reload(); 
                                $('.reset_form').click();
                                // setTimeout(function(){ $('#message_box').html(''); }, 6000);
                            }
                             
                        }
                     }); 
                }    
                
            });


            /*$("#common_form_submit").click(function(){
                $('#record_id').val('');
                this.form.reset();
            });*/

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
                    ajax: URL+"/subscription_plan_call_data",
                    columns:[
                        {data:"DT_RowIndex",name:"DT_RowIndex",orderable:false},
                        {data:"plan_title",name:"plan_title"},
                        {data:"plan_for_month",name:"plan_for_month"},
                        {data:"price",name:"price"},
                        {data:"discount_in_percent",name:"discount_in_percent"},
                        {data:"created_at",name:"created_at"},
                        {data:"action",name:"DT_RowIndex",orderable:false},
                    ]
                });
            }  
        });
     </script> 
 @endsection


