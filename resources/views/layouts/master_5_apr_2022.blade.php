<!DOCTYPE html>
<html lang="en">
   <head> 
        <title>{{ config('app.name', 'Laravel') }}</title>          
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon" />    
        <link rel="stylesheet" type="text/css" id="theme" href="{{ asset('css/theme-default.css') }}"/>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        @yield('style')
        
        <style>
            .s_btn1{
                margin-right: 4px;
            }
            .wrap_box{
                background: #ededec !important;
            }
            textarea{
                width: 100% !important;
                border: 1px solid #b3b3b3;
            }
        </style>      
            
   </head>
   <body>
      
      <div class="page-container">
         @include('admin.include.side_nav')   
         <div class="page-content"> 
               @include('admin.include.top_nav')
                
               <div class="page-content-wrap">
                  @yield('content')
               </div>  
 
        </div>
      </div> 
      <div class="message-box animated fadeIn" data-sound="alert" id="mb-remove-row">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-times"></span> Remove <strong>Data</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to remove this row?</p>                    
                        <p>Press Yes if you sure.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button class="btn btn-success btn-lg mb-control-yes">Yes</button>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>                    
                        <p>Press No if you want to continue work. </p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="{{ route('logout') }}" class="btn btn-success btn-lg">Yes</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->

        <!-- BLUEIMP GALLERY -->
        <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
            <div class="slides"></div>
            <h3 class="title"></h3>
            <a class="prev">‹</a>
            <a class="next">›</a>
            <a class="close">×</a>
            <a class="play-pause"></a>
            <ol class="indicator"></ol>
        </div> 

        <!-- START PRELOADS -->
        <audio id="audio-alert" src="{{ url('audio/alert.mp3') }}" preload="auto"></audio>
        <audio id="audio-fail" src="{{ url('audio/fail.mp3') }}" preload="auto"></audio>
        <!-- END PRELOADS -->                  
        
      <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="{{ asset('js/plugins/jquery/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/plugins/jquery/jquery-ui.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/plugins/bootstrap/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>        
        <!-- END PLUGINS -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script type="text/javascript" src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>

        <script type="text/javascript" src="{{ asset('js/plugins/summernote/summernote.js') }}"></script>
        
        <script>
            var URL = '{{url('/')}}';  

            var getUrl = window.location;
            var baseurl = getUrl.origin; //or
            var URL2 =  getUrl.origin + '/' +getUrl.pathname.split('/')[1]; 

            $(document).on('click', '#removePropImgRow', function(){
                $(this).closest('#inputPropImgRow').remove();
            });

            $(document).on('click', '.removePropImgRowAjax', function (e){
                
                form_data_id = $(this).data('id');  
                alert(form_data_id);
                e.preventDefault();
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover again!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => { 
                    if(willDelete){ 
                        $.ajax({
                            url:URL+"/time_slot_delete/"+form_data_id, 
                            success:function(response){   
                                $('#inputPropImgRow_'+form_data_id).remove(); 
                            }
                        });
                    } else {
                        swal("Your record file is safe!");
                    }
                });

            });


            $(document).ready(function() {  

                $("#addPropertyImgeRow").click(function (){
  
                  html  =  '<div class="row">'+
                              '<div class="col-lg-3">'+
                                 '<select class="form-control" name="time_slot[]" >'+
                                    '<option value="">Select Time Slot</option>'+
                                    '<option value="1">Morning</option>'+
                                    '<option value="2">Afternoon</option>'+
                                    '<option value="3">Evening</option>'+
                                 '</select>'+
                              '</div>'+
                              '<div class="col-lg-3">'+
                                 '<input type="time" name="from_time[]" class="form-control" />'+
                              '</div>'+
                              '<div class="col-lg-4">'+
                                 '<span class="cspan">--</span>'+
                                 '<input type="time" name="to_time[]" class="form-control ctime" />'+
                              '</div>'+
                              '<div class="col-lg-2">'+
                                 '<button id="removePropImgRow" type="button" class="btn btn-danger">'+
                                    '<i class="fa fa-trash"></i>'+
                                 '</button>'+
                              '</div>'+
                           '</div>';

                  $('#newPropImgRow').append(html);
               
            }); 

                $(document).on("click", '.ch_input', function(e){  // worked with dynamic loaded jquery content
        
                    this.value = this.checked ? 1 : 0; 

                    if(this.checked){
                        $(this).attr( 'checked', 'checked');
                    }else{
                        $(this).removeAttr('checked');
                    }
                    
                });
      
            
                $(document).on("click", '.common_status_update', function(e){

                    data_id = $(this).data('id');
                    
                    var updated_status = $(this).val();  

                    data_action = $(this).data('action'); 

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    }); 
                     
                    var form_data = new FormData();
                    form_data.append("record_id",data_id);
                    form_data.append("status",updated_status);
                    
                    if(data_action=='user' && updated_status=='0'){
 
                        $('#my_property_id').val(data_id); 

                        $('#rejection_modal').modal('show'); 
                        
                        return false;
                    
                    }else{

                        form_action = data_action+'_status_update';    
                          
                        $.ajax({
                            type:"POST", 
                            url: URL+"/"+form_action,
                            data:form_data, 
                            enctype: 'multipart/form-data',
                            processData: false,  // Important!
                            contentType: false,
                            cache: false,
                            dataType: "json",
                             
                            success: function(response){  
                          
                                $('#message_box').html(''); 

                                if(response.status=='10'){  
                                    htm ='';
                                    var array = $.map(response.missingParam, function(value, index){  
                                       htm +='<span class="invalid-feedback" role="alert"><strong>' + value + "</strong></span>"; 
                                    }); 
                                    var htt_box =   '<div class="alert alert-danger" >'+
                                                        '<button class="close" data-close="alert"></button>'+
                                                        '<span>'+response.message+'</span>'+
                                                    '</div>'; 
                                    $('#message_box').html(htt_box);

                                }else if(response.status=='1'){                                  
                                    swal(response.message); 
                                }

                            }
                        });

                    }

                });

                $(document).on("click", '.del-confirm', function(e){  // worked with dynamic loaded jquery content
        
                    data_id = $(this).data('id');  
                    e.preventDefault();
                    swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover again!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {  
                        if(willDelete){     
                            $('#form_del_'+data_id).submit();
                        } else {
                            swal("Your record file is safe!");
                        }
                    });

                });
               
               $("#common_form_submit").click(function(){   
                  setTimeout(function(){ $('#message_box').html(''); }, 6000);
              });

               $(".del-confirm").click(function(){  
                  e.preventDefault();
                  swal({
                      title: "Are you sure?",
                      text: "Once deleted, you will not be able to recover again!",
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                  })
                  .then((willDelete) => {  
                      if(willDelete){     
                            $(".del-confirm").closest('form').submit();
                            /*
                                $('#my_data_table').DataTable().ajax.reload(); 
                                if($(this).hasClass("my_data_table")){
                                    
                                }
                            */    
                      } else {
                          swal("Your record file is safe!");
                      }
                  });
               });

 
                  /*$("#addPropertyImgeRow").click(function (){

                     var html = '';
                     html += '<div id="inputPropImgRow">';
                     html += '<div class="input-group mb-3">';
                     html += '<input type="file" class="form-control" name="multi_product_image[]" />';
                     html += '<div class="input-group-append">';
                     html += '<button id="removePropImgRow" type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>';
                     html += '</div>';
                     html += '</div>';

                     $('#newPropImgRow').append(html);
                  
                  });*/

                  $(".update_booking_status").change(function (e) {  

                        booking_id = $(this).data('id');  
                        booking_status = $(this).val();

                        e.preventDefault();
                        swal({
                            title: "Are you sure?",
                            text: "Once deleted, you will not be able to recover again!",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((willDelete) => { 
                           if(willDelete){ 
                                $.ajax({
                                 url:URL+"/booking_status_update/"+booking_id+"/"+booking_status, 
                                 success:function(response){   
                                    if(response.status=='1'){
                                       swal(response.message);
                                    }
                                 }
                              }); 
                           } 
                        });

                  });

                  $(".decimal_number").keypress(function(e){   // input number only with decimal value 
                     return (e.charCode !=8 && e.charCode ==0 || ( e.charCode == 46 || (e.charCode >= 48 && e.charCode <= 57)))
                  });

            });


            $(document).on('click', '#removePropImgRow', function () {
                  $(this).closest('#inputPropImgRow').remove();
               });

               $(document).on('click', '#removeRow', function () {
                  $(this).closest('#inputFormRow').remove();
               });
 
               
         </script>

        <!-- START THIS PAGE PLUGINS-->        
        <script type='text/javascript' src="{{ asset('js/plugins/icheck/icheck.min.js') }}"></script>        
        <script type="text/javascript" src="{{ asset('js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/plugins/scrolltotop/scrolltopcontrol.js') }}"></script>
        
        <script type="text/javascript" src="{{ asset('js/plugins/morris/raphael-min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/plugins/morris/morris.min.js') }}"></script>       
        <script type="text/javascript" src="{{ asset('js/plugins/rickshaw/d3.v3.js') }}"></script>
        <!-- <script type="text/javascript" src="{{ asset('js/plugins/rickshaw/rickshaw.min.js') }}"></script> -->
        <script type='text/javascript' src="{{ asset('js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}" ></script>
        <script type='text/javascript' src="{{ asset('js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>                
        <script type='text/javascript' src="{{ asset('js/plugins/bootstrap/bootstrap-datepicker.js') }}" ></script>                
        <script type="text/javascript" src="{{ asset('js/plugins/owl/owl.carousel.min.js') }}"></script>    

        <script type='text/javascript' src='{{ asset("js/plugins/bootstrap/bootstrap-select.js") }}'></script> 
               

        
        <script type='text/javascript' src='{{ asset("js/plugins/maskedinput/jquery.maskedinput.min.js") }}'></script>

        
        <script type="text/javascript" src="{{ asset('js/plugins/moment.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
        <!-- END THIS PAGE PLUGINS-->        

        <!-- START TEMPLATE -->
        <!-- <script type="text/javascript" src="{{ asset('js/settings.js') }}"></script> -->
        
        <script type="text/javascript" src="{{ asset('js/plugins.js') }}"></script>        
        <script type="text/javascript" src="{{ asset('js/actions.js') }}"></script>
        
        <!-- <script type="text/javascript" src="{{ asset('js/demo_dashboard.js') }}"></script> -->

        @yield('script')
        <script type='text/javascript' src='{{ asset("js/plugins/jquery-validation/jquery.validate.js") }}'></script>
        <script type='text/javascript' src='{{ asset("js/plugins/validationengine/languages/jquery.validationEngine-en.js") }}'></script>
        <script type='text/javascript' src='{{ asset("js/plugins/validationengine/jquery.validationEngine.js") }}'></script> 
 
        <script type="text/javascript" src="{{ asset('js/plugins/blueimp/jquery.blueimp-gallery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/plugins/dropzone/dropzone.min.js') }}"></script>
   </body>
</html>