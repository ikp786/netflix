@extends('layouts.app_front')
<style type="text/css">
    .text-center {
        text-align: center!important;
    }
</style>
@section('content')
    <div class="ch-ur-pl">
        <main id="main"> 
          <div class="container text-center">
            <div class="lgn-frm ur-plan">
                <h3>Choose Your Plan</h3>
                <ul>
                  <li>You won't be changed until after<br>your free month.</li>
                  <li>We'll remind you 3 days before your<br>trial ends.</li>
                  <li>No commitments, cancel at any <br>time</li>
                </ul>
                <a href="{{ url('fr_plan_list')}}" class="text-dark">See The Plans</a> 
            </div>
          </div> 
      </main> 
  </div>
@endsection
