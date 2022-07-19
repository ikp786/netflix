@extends('layouts.master')


@section('content') 

    <ul class="breadcrumb">
        <li><a href="#">Home</a></li> 
        <li><a href="#">Banner</a></li> 
    </ul> 

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="page-title">                    
        <h2><span class="fa fa-flag"></span> Manage Banner</h2>
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
            <form id="validate" action="{{ route('slider.store') }}"  class="form-horizontal comm_form" method="POST" role="form" >
                @csrf
                <input type="hidden" id="record_id" class="form-control" name="record_id" value="" />
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3><span class="fa fa-label"></span> Add/Edit Banner</h3> 
                    </div> 
                    <div class="panel-body form-group-separated">
                        <!-- <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Name <code>*</code></label>
                            <div class="col-md-9 col-xs-7"> 
                                <input type="text" name="slider_name" id="frm_slider_name" class="form-control validate[required]" placeholder="Name">
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Banner Type <code>*</code></label>
                            <div class="col-md-9 col-xs-7">
                                <select name="slider_type"  id="frm_slider_type" class="form-control validate[required]" >
                                    <option value="0">App Banner</option>
                                    <option value="1">Profile Banner</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Image <span id="show_cat_img"></span> </label>
                            <div class="col-md-9 col-xs-7"> 
                                <input type="file" name="slider_image" id="frm_slider_image" class="form-control validate[required]" placeholder="Name">
                                <span class="img-size-text">Maximum Upload  size  1200*1100</span>
                            </div>
                        </div>
                        <div class="form-group" id="video_id_div">
                            <label class="col-md-3 col-xs-5 control-label">Video Id </label>
                            <div class="col-md-9 col-xs-7"> 
                                <input type="text" name="video_id" id="frm_video_id" class="form-control decimal" maxlength="5" placeholder="Video Id">
                            </div>
                        </div>
                        <div class="form-group" id="video_url_div" >
                            <label class="col-md-3 col-xs-5 control-label">Video Url </label>
                            <div class="col-md-9 col-xs-7"> 
                                <input type="text" name="video_url" id="frm_video_url" class="form-control" placeholder="Video Url">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-xs-5 control-label">Status <code>*</code></label>
                            <div class="col-md-9 col-xs-7">
                                <select name="status"  id="frm_status" class="form-control validate[required]" >
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>                                  
                        <div class="form-group">
                            <div class="col-md-12 col-xs-5">
                                <button class="btn btn-default reset_form" type="button" onClick="$('#validate').validationEngine('hide');" >Clear Form</button>                                

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
                        <h3 class="panel-title"><strong>Banner</strong></h3>
                        
                    </div>
                    <div class="page-head-controls">  
                    </div>                    
                </div>  
                <div class="panel-default">
                    <div class="panel-body">

                        <div class="table-responsive" style="overflow-x: auto;">
                            <table id="my_data_table" class="table table-bordered table-striped table-actions" >
                                <thead>
                                    <tr>
                                        <th width="50">Sr No</th>
                                        <th>Banner Type</th>
                                        <th>Banner Image</th>
                                        <th>Video ID</th>
                                        <th>Video Url</th>
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

    <div class="modal animated fadeIn" id="modal_view_dt" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="smallModalHead">Banner Information</h4>
                    </div> 
                    <div class="modal-body form-horizontal form-group-separated">                        
                        <!-- <div class="form-group">
                            <label class="col-md-3 control-label">Slider Name</label>
                            <div class="col-md-9">
                                <span class="form-control" id="show_cat_name" ></span>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label class="col-md-3 control-label">Banner Type</label>
                            <div class="col-md-9">
                                <span class="form-control" id="show_slider_type" ></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Banner Image</label>
                            <div class="col-md-9">
                                <span class="form-control" id="show_slider_image" ></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Video Id</label>
                            <div class="col-md-9">
                                <span class="form-control" id="show_video_id" ></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Video Url</label>
                            <div class="col-md-9">
                                <span class="form-control" id="show_video_url" ></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Status</label>
                            <div class="col-md-9">
                                <span class="form-control" id="show_cat_status" ></span>
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
                url: URL+"/slider_get_data",
                data:form_data, 
                enctype: 'multipart/form-data',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                dataType: "JSON", 
                success: function(response){   
                    if(response.result.length>0){ 
                        slider_name = response.result[0].slider_name;
                        slider_status_name = response.result[0].slider_status_name; 

                        slider_type = response.result[0].slider_type; 
                        video_id = response.result[0].video_id; 
                        video_url = response.result[0].video_url; 
                        slider_type = (slider_type=='1') ? 'Profile Banner' : 'App Banner';
                        slider_image = response.result[0].slider_image;  

                        if(slider_image!=''){
                            cat_img_dt = '<a target="_blank" href="'+URL+'/uploads/'+slider_image+'" ><img src="'+URL+'/uploads/'+slider_image+'" style="width:30px;" /></a>';
                            $('#show_slider_image').html(cat_img_dt);
                        }
                        $('#show_cat_name').text(slider_name);
                        $('#show_video_id').text(video_id);
                        $('#show_video_url').text(video_url);
                        $('#show_cat_status').text(slider_status_name); 
                        $('#show_slider_type').text(slider_type); 
                    }  
                }
            });
        });

        $('#video_id_div').hide();
        $('#video_url_div').hide();

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
                    url: URL+"/slider_get_data",
                    data:form_data, 
                    enctype: 'multipart/form-data',
                    processData: false,  // Important!
                    contentType: false,
                    cache: false,
                    dataType: "JSON", 
                    success: function(response){   
                        if(response.result.length>0){ 

                            id = response.result[0].id;
                            slider_name = response.result[0].slider_name;
                            status = response.result[0].status; 
                            slider_type = response.result[0].slider_type; 
                            video_id = response.result[0].video_id; 
                            video_url = response.result[0].video_url; 
                            // slider_type = (slider_type=='1') ? 'Profile Banner' : 'App Banner';

                            $('#record_id').val(id);
                            $('#frm_slider_name').val(slider_name);
                            $('#frm_status').val(status);
                            $('#frm_slider_type').val(slider_type);
                            $('#frm_video_id').val(video_id);
                            $('#frm_video_url').val(video_url);

                            if(slider_type=='1'){
                                $('#video_id_div').hide();
                                $('#video_url_div').hide();
                            }else{
                                $('#video_id_div').show();
                                $('#video_url_div').show();
                            }

                            slider_image = response.result[0].slider_image;  

                            if(slider_image){
                                cat_img_dt = '<a target="_blank" href="'+URL+'/uploads/'+slider_image+'" ><img src="'+URL+'/uploads/'+slider_image+'" style="width:30px;" /></a>';
                                $('#show_cat_img').html(cat_img_dt);
                            } 

                        }
                        $('#message_box').html(''); 
 
                    }
                });
        });

        $(document).ready(function() { 
             
            $("#frm_slider_type").change(function() {
                type = $(this).val();
                 if(type=='1'){
                    $('#video_id_div').hide();
                    $('#video_url_div').hide();
                 }else{
                    $('#video_id_div').show();
                    $('#video_url_div').show();
                 }
            });

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
                    ajax: URL+"/slider_call_data",
                    columns:[
                        {data:"DT_RowIndex",name:"DT_RowIndex",orderable:false},
                        {data:"slider_type_name",name:"slider_type_name"},
                        {data:"slider_image",name:"slider_image"},
                        {data:"status",name:"status"},
                        {data:"created_at",name:"created_at"},
                        {data:"action",name:"DT_RowIndex",orderable:false},
                    ]
                });
            }  
        });
     </script> 
 @endsection


