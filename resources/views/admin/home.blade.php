@extends('layouts.master')

@section('content') 
    
    <style>
        .widget-item-left{
            background: #ebe6d9;
            padding: 29px !important;
            padding-left: 21px !important;
        }
        .widget-item-left span{
            font-size: 31px !important;
        }
        .s_cursor{ cursor: pointer; }
         
        .dash_icon{
        color: #003288;
        font-size: 24px;
        }
        .dash .bank_three {
        background-image: linear-gradient( 90deg,#0b9d8f,#12b1a2);
        color: #fff;
        width: 33%;
        }
        .bank_two {
        background-image: linear-gradient( 90deg,#18d9c8,#0a998c) !important;
        color: #fff !important;
        width: 33% !important;
        }
        .dash .bank_one {
            /* background-image: linear-gradient( 90deg,#000000,#c9c42e) !important;*/
            color: #fff;  
            background: #000;
        width: 33%;
        }
        .dash_icon {
        color: #ffffff;
        font-size: 40px;
            box-shadow: 0px 0px 5px #ebebeb;

    background: #2c2c2c;
        }
        .buld {
            text-align: center;
        }
        .dash h3 {
        background: no-repeat;
        font-size: 20px;
        padding: 5px;
        color: #fff;
        }
        .buld {
        border-right: 0px solid #E4E4E4;
        }
        .dash_icon {
            color: #d3ce33;
            font-size: 40px;
            padding: 15px;
            border-radius: 120px;
            width: 70px;
                box-shadow: 0px 0px 5px #ebebeb;
    height: 70px;
    background: #2c2c2c;
        }
        .bank_wlt h3 {
            margin: 12px 20px 0;
        }

        .buld {
           padding: 20px;
        }
        .buld h5 {
            margin: 0;
            padding-top: 15px;
            font-size: 30px;
            text-align: center;
        }
         .bank_wlt {
            display: flex;
            width: 100%; 
        }
        .dash .bank_one {
           /* background-image: linear-gradient( 90deg,#000000,#c9c42e) !important;*/
            color: #fff;  
            background: #000;
        }
        .dash .bank_one { 
            border-radius: 15px;
            margin: 5px;
        }
        .bank_one { 
            border-radius: 15px;
            margin: 5px;
        }
        .bank_one h3{ text-align: left; }
        .footer {
    text-align: center;
    position: absolute;
    z-index: 999;
    bottom: 0;
    width: 100%;
}
.footer p{
    color: #f3f3f3;
    text-align: center;
}
    </style>
  
    <div class="card-body">
        <div class="row mb-2">
         <div class="bank_wlt dash"> 
           <div class="bank_one">
              <h3>Total Users</h3>
               <div class="row">
                 <div class="col-md-6 buld">
                    <h5 style="color: #fff;">{{ $totalCustomer }}</h5>
                 </div>
                 <div class="col-md-6 buld">
                    <a href="{{ route('users.index') }}"><i class="dash_icon fa fa-users"></i></a>
                 </div>
              </div> 
           </div>  
           <div class="bank_one">
               <h3>Total Categories</h3>
               <div class="row">
                  <div class="col-md-6 buld">
                     <h5 style="color: #fff;">{{ $totalCategory }}</h5>
                  </div>
                  <div class="col-md-6 buld">
                      <a href="{{ url('category') }}"><i class="dash_icon fa fa-list"></i></a>
                  </div>
               </div> 
            </div>
            <div class="bank_one">
               <h3>Total Sub Categories</h3>
               <div class="row">
                  <div class="col-md-6 buld">
                     <h5 style="color: #fff;">{{ $totalSubCategory }}</h5>
                  </div>
                  <div class="col-md-6 buld">
                      <a href="{{ url('product') }}"><i class="dash_icon fa fa-list-alt"></i></a>
                  </div>
               </div> 
            </div>
        </div>
        <div class="bank_wlt dash">  
            <div class="bank_one">
               <h3>Total Videos</h3>
               <div class="row">
                  <div class="col-md-6 buld">
                     <h5 style="color: #fff;">{{ $totalVideo }}</h5>
                  </div>
                  <div class="col-md-6 buld">
                      <a href="{{ url('sub_product') }}"><i class="dash_icon fa fa-film"></i></a>
                  </div>
               </div> 
            </div>
            <div class="bank_one">
               <h3>Total Subscribed Users</h3>
               <div class="row">
                  <div class="col-md-6 buld">
                     <h5 style="color: #fff;">{{ $totalSubscribers }}</h5>
                  </div>
                  <div class="col-md-6 buld">
                      <a href="{{ url('subscripted_user_list') }}"><i class="dash_icon fa fa-user-plus"></i></a>
                  </div>
               </div> 
            </div>
            <div class="bank_one">
               <h3>Total Enquires</h3>
               <div class="row">
                  <div class="col-md-6 buld">
                     <h5 style="color: #fff;">{{ $totalContact }}</h5>
                  </div>
                  <div class="col-md-6 buld">
                      <a href="{{ url('contact_us') }}"><i class="dash_icon fa fa-envelope-o"></i></a>
                  </div>
               </div> 
            </div> 
         </div>
      </div>
      <div class="footer">
          <p>Copyright @ 2022</p>
      </div>
    </div>    

@endsection



