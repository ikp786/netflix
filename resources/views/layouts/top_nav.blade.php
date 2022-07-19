<nav class="navbar navbar-default navbar-trans navbar-expand-lg fixed-top">
 <div class="container-fluid">
    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDefault" aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span></span>
    <span></span>
    <span></span>
    </button>
    <a class="navbar-brand text-brand web-logo" href="{{ url('/') }}"><img src="{{ asset('front/assets/img/logo.png') }}" alt=""></a>
    <a class="navbar-brand text-brand mob-logo" href="{{ url('/') }}"><img src="{{ asset('front/assets/img/mob-logo.png') }}" alt=""></a>
    <input type="hidden" id="is_auth_user" value="{{ \Auth::id() }}" >
    <div class="navbar-collapse collapse justify-content-center" id="navbarDefault">
       <ul class="navbar-nav">
          <li class="nav-item">
             <a class="nav-link {{ (request()->is('/')) ? 'active' : ''}}" href="{{ url('/')}}">Home</a>
          </li>
          <li class="nav-item">
             <a class="nav-link {{ (request()->is('fr_category') || request()->is('fr_sub_category')) ? 'active' : ''}}" href="{{ url('/fr_category')}}">Categories </a>
          </li>
          @if(\Auth::check())
             <li class="nav-item">
                <a class="nav-link {{ (request()->is('fr_my_watchlist')) ? 'active' : ''}}" href="{{ url('fr_my_watchlist')}}" >MY Favs</a>
             </li>
          @endif
          <li class="nav-item">
             <a class="nav-link {{ (request()->is('fr_membership') || request()->is('fr_plan_list')) ? 'active' : ''}}" href="{{ url('fr_membership')}}">Membership</a>
          </li>
          <!-- <li class="nav-item">
             <a class="nav-link " href="profile.html">Upcoming</a>
             </li> -->
       </ul>
    </div>
    <div class="rght-mnu">
      @if(!\Auth::check())
          <div class="login-btn">
             <a href="{{ url('fr_login') }}">Login</a>
          </div>
      @else
         <div class="login-btn">
             <a href="{{ url('fr_logout') }}">Logout</a>
          </div>
      @endif 
          <button type="button" class="btn btn-b-n navbar-toggle-box navbar-toggle-box-collapse" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01">
          <i class="bi bi-search"></i>
          </button>
      @if(\Auth::check())

          <div class="profl top-profile-img">
             <p>{{ ucwords(\Auth::user()->name) }}<span>{{ \Auth::user()->phone }}</span></p>
             <a href="{{ url('fr_profile') }}"> 
               @if(\Auth::user()->profile_photo_path!="")
                  @php $prof_img = \Auth::user()->profile_photo_path; @endphp
                  <img src="{{ url('uploads/'.$prof_img) }}"/>
               @else
                  <img src="{{ asset('front/assets/img/profile-pic.png') }}" alt="">
               @endif
            </a>
          </div>
      @endif
    </div>
 </div>
</nav>