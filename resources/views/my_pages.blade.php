@extends('layouts.app_front')
<style>
    .vid_img{ height: 145px !important;  }
    .delett{ cursor:pointer; }
</style>
@section('content')
    <main id="main"> 
        <section class="section-property section-t8 prfil-bg">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12 prfl-top"> 
                <h2 style="font-size: 30px;">{{ ucwords($get_page_data->page_name) }}</h2>
              </div>
            </div>

            <div class="container mt-4 pt-4">
              <div id="exTab2">
              <div class="panel panel-default"> 
                <div class="panel-body">
                  {!! $get_page_data->page_content !!}
                </div>
              </div>
            </div>
            </div>


          </div>
        </section>
    </main>
@endsection 
