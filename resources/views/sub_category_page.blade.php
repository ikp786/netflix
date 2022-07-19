@extends('layouts.app_front')
<style>
   #submit_sub_cat_search{
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
</style>
@section('content')
    <main id="main" class="loginp" > 
        <div class="container text-center"> 
                <div class="lgn-frm chus-cate">
                    <h3>Choose Sub Categories</h3>
                    <ul>
                      @foreach($get_data as $dt)
                        <li class="check_cat" data-id="{{ $dt->id }}" id="cate_check_{{ $dt->id }}" >
                          @if($dt->media_url)
                            <img style="height: 145px;" src="{{ url('uploads/'.$dt->media_url) }}" alt="">
                          @endif 
                          <p class="text-center pt-2">{{ $dt->product_name }}</p>
                        </li>
                      @endforeach 
                    </ul>  
                    <input type="button" name="Continue" value="Continue" id="submit_sub_cat_search" />
                </div> 
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
                $('#prev_sub_category_ids').val(cat_ids);
          });
      });
  </script>  

@endsection
 
