@extends('layouts.app_front')
<style>
   #submit_continue{
      background: #FFFB2E;
      border-radius: 10px;
      border: none;
      display: block;
      width: 100%;
      padding: 20px;
      color: #000;
      font-size: 18px;
      font-weight: 500;
      margin-top: 25px;
  }
  .categry-section {
    height: 1000px !important;
}

</style>
@section('content')
    <main id="main" class="loginp categry-section" > 
        <div class="container text-center">
            <form id="validate" action="{{ url('fr_video') }}"  class="form-horizontal comm_form" method="POST" role="form" enctype="multipart/form-data" > 
                <input type="hidden" name="category_ids" id="category_ids" value="" required />
                @csrf
                <div class="lgn-frm chus-cate">
                    <h3>Choose Preference Categories</h3>
                    <ul>
                      @foreach($get_data as $dt) 
                        @php
                            $user_id = \Auth::id();
                            $prefered_cat_Count = \App\Models\PreferedCategory::where(['user_id' => $user_id,'category_id'=>$dt->id])->count(); 
                        @endphp
                        <li class="check_cat {{($prefered_cat_Count>0) ? 'active' : ''}} " data-id="{{ $dt->id }}" id="cate_check_{{ $dt->id }}" >
                          @if($dt->category_image)
                            <img style="height: 145px;" src="{{ url('uploads/'.$dt->category_image) }}" alt="">
                          @endif

                          <p class="text-center pt-2">{{ $dt->category_name }} </p>
                        </li>
                      @endforeach 
                    </ul>  
                    <input type="submit" name="Continue" value="Continue" id="submit_continue" />
                </div>
            </form>
          </div>
    </main> 

    <script>   
      $(document).ready(function() {  
          var dataselected = "";
          $(".check_cat").click(function(){  
              if($(this).hasClass('active')){
                  $(this).removeClass('active'); 
              }else{
                data_id = $(this).data('id'); 
                $('#cate_check_'+data_id).addClass('active');  
              } 
                var cat_ids = []; 
                $('ul li.active').each(function(){ 
                  var dataselected = $(this).data('id');  
                  cat_ids.push(dataselected);                   
                }) 
                $('#category_ids').val(cat_ids);
          });
      });
  </script>  

@endsection
 
