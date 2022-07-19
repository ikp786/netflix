@extends('layouts.master')


@section('content') 

    <ul class="breadcrumb">
        <li><a href="#">Home</a></li> 
        <li><a href="#">Permission</a></li> 
    </ul> 

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="page-title">                    
        <h2><span class="fa fa-sitemap"></span> Manage Permission</h2>
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
            <form id="validate" action="{{ route('permission.store') }}"  class="form-horizontal comm_form" method="POST" role="form" >
                @csrf
                <input type="hidden" id="record_id" class="form-control" name="record_id" value="" />
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3><span class="fa fa-label"></span> Add/Edit Permission</h3> 
                    </div> 
                    <div class="panel-body form-group-separated">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Name <code>*</code></label>
                            <div class="col-md-9 col-xs-7"> 
                                <input type="text" name="name" id="frm_permission_name" class="form-control validate[required] " placeholder="Name">
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
                        <h3 class="panel-title"><strong>Permission</strong></h3>
                        
                    </div>
                    <div class="page-head-controls"> 
                        <!-- @can('category-create')                   
                            <a class="btn btn-success btn-rounded"  href="{{ route('category.create') }}" ><span class="fa fa-pencil"></span> Add</a>
                        @endcan -->
                    </div>                    
                </div>  
                <div class="panel-default">
                    <div class="panel-body">

                        <div class="table-responsive">
                            <table id="my_data_table" class="table table-bordered table-striped table-actions" >
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Name</th> 
                                        <th>Create Date</th> 
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
                        <h4 class="modal-title" id="smallModalHead">Permission Information</h4>
                    </div> 
                    <div class="modal-body form-horizontal form-group-separated">                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">Permission Name</label>
                            <div class="col-md-9">
                                <span class="form-control" id="show_permission_name" ></span>
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
                url: URL+"/permission_get_data",
                data:form_data, 
                enctype: 'multipart/form-data',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                dataType: "JSON", 
                success: function(response){   
                    if(response.result.length>0){ 
                        permission_name = response.result[0].name;
                         
                        $('#show_permission_name').text(permission_name);  
                    }  
                }
            });
        });

        $(document).on("click", '.form_data_act', function(e){  // worked with dynamic loaded jquery content
            
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
                    url: URL+"/permission_get_data",
                    data:form_data, 
                    enctype: 'multipart/form-data',
                    processData: false,  // Important!
                    contentType: false,
                    cache: false,
                    dataType: "JSON", 
                    success: function(response){   
                        if(response.result.length>0){ 
                            id = response.result[0].id;
                            permission_name = response.result[0].name; 
                            $('#record_id').val(id);
                            $('#frm_permission_name').val(permission_name);  
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
            });

            if($('#my_data_table').length > 0){  
                $('#my_data_table').DataTable({
                    processing:true,
                    serverSide:true,
                    "order": [[3,'desc']],
                    "pageLength": 5,
                    ajax: URL+"/permission_call_data",
                    columns:[
                        {data:"DT_RowIndex",name:"DT_RowIndex",orderable:false},
                        {data:"name",name:"name"}, 
                        {data:"created_at",name:"created_at"},
                        {data:"action",name:"DT_RowIndex",orderable:false},
                    ]
                });
            }  
        });
     </script> 
 @endsection


