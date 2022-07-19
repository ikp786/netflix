@php
    $auth_id = \Auth::id();
    $linkk =  \Request::segment(1);  
@endphp
<div class="page-sidebar"> 
    <ul class="x-navigation">
        <li class="xn-logo">
            <a href="{{ route('dashboard') }}">{{ config('app.name') }}</a>
            <a href="#" class="x-navigation-control"></a>
        </li>  
        <li class=" {{ ($linkk=='admin') ? 'active' : ''}}" >
           <a href="{{ route('dashboard') }}"><span class="fa fa-dashboard"></span> <span class="xn-text">Dashboard</span></a>
        </li>
        @can('user-list')
           <li class=" {{ ($linkk=='users') ? 'active' : ''}}" >
               <a href="{{ route('users.index') }}"><span class="fa fa-users"></span> <span class="xn-text">Users</span></a>
           </li>
        @endcan
         @can('category-list')           
           <li class=" {{ ($linkk=='category') ? 'active' : ''}}" >
               <a href="{{ route('category.index') }}"><span class="fa fa-list"></span> <span class="xn-text">Category</span></a>
           </li> 
        @endcan  
        <li class=" {{ ($linkk=='product') ? 'active' : ''}}" >
           <a href="{{ url('product') }}"><span class="fa fa-list-alt"></span> <span class="xn-text">Sub Category</span></a>
        </li> 
        <li class=" {{ ($linkk=='sub_product') ? 'active' : ''}}" >
           <a href="{{ url('sub_product') }}"><span class="fa fa-film"></span> <span class="xn-text">Video</span></a>
        </li>
        <li class=" {{ ($linkk=='subscription_plan') ? 'active' : ''}}" >
           <a href="{{ url('subscription_plan') }}"><span class="fa fa-book"></span> <span class="xn-text">Membership Plan</span></a>
        </li>
        @can('slider-list')           
           <li class=" {{ ($linkk=='slider') ? 'active' : ''}}" >
               <a href="{{ route('slider.index') }}"><span class="fa fa-flag"></span> <span class="xn-text">Banner</span></a>
           </li> 
        @endcan 
         <li class=" {{ ($linkk=='setting' || $linkk=='setting') ? 'active' : ''}}" >
           <a href="{{ url('setting') }}"><span class="fa fa-cog"></span> <span class="xn-text">Setting</span></a>
        </li> 
        <li class=" {{ ($linkk=='contact_us') ? 'active' : ''}}" >
           <a href="{{ route('contact_us.index') }}"><span class="fa fa-life-ring"></span> <span class="xn-text">Enquires</span></a>
        </li>        
        <!-- @can('sub_category-list')           
           <li class=" {{ ($linkk=='specialist') ? 'active' : ''}}" >
               <a href="{{ route('specialist.index') }}"><span class="fa fa-hospital-o"></span> <span class="xn-text">Sub Category</span></a>
           </li> 
        @endcan -->         
        
        <!-- <li class=" {{ ($linkk=='subscribed_plan') ? 'active' : ''}}" >
           <a href="{{ url('subscribed_plan') }}"><span class="fa fa-user-plus"></span> <span class="xn-text">Subscribed Users</span></a>
        </li>
        <li class=" {{ ($linkk=='page') ? 'active' : ''}}" >
           <a href="{{ url('page') }}"><span class="fa fa-book"></span> <span class="xn-text">Page</span></a>
        </li>  
        <li class=" {{ ($linkk=='profile_show' || $linkk=='profile_edit') ? 'active' : ''}}" >
           <a href="{{ url('profile_show') }}"><span class="fa fa-user"></span> <span class="xn-text">Profile</span></a>
        </li>  -->
       
    
   
    </ul> 
</div>
