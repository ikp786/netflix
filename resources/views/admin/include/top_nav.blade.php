<style type="text/css">
   .form-control {
        height: 40px !important;
        line-height: 18px;
        margin-bottom: 10px !important;
    }
    label {
        font-size: 13px;
    }
    sub{
        color: red;
        top: -4px;
    }
</style>
 
<ul class="x-navigation x-navigation-horizontal x-navigation-panel" > 
     <li class="xn-icon-button" >
         <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent" ></span></a>
     </li> 
     <li class="xn-icon-button pull-right last" >  
         <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-power-off"></span></a>
     </li> 
     <li class="xn-icon-button pull-right last" style="padding: 16px;
    color: #e5da31;
    font-weight: 700;
    text-transform: capitalize;" >  
         {{\Auth::user()->name}}
     </li> 
 </ul>




