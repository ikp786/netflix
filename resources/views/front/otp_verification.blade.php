@extends('front.app_auth_front')
 
@section('content') 
 
  <div class="container text-center">
    <div class="lgn-frm otp-frm">
        <h3>Enter OTP</h3>
          <form>
            <div class="otp-frmin">
              <input type="text" pattern='[0-9]{1}' oninput='digitValidate(this)'  onkeyup='tabChange(1)' maxlength="1" placeholder="0">
              <input type="text" pattern='[0-9]{1}' oninput='digitValidate(this)'  onkeyup='tabChange(2)' maxlength="1" placeholder="0">
              <input type="text" pattern='[0-9]{1}' oninput='digitValidate(this)'  onkeyup='tabChange(3)' maxlength="1" placeholder="0">
              <input type="text" pattern='[0-9]{1}' oninput='digitValidate(this)'  onkeyup='tabChange(4)' maxlength="1" placeholder="0">
            </div> 
            <a class="text-dark" href="index.html">Login</a>
            <!-- <button type="submit" ><a class="text-dark p-0 m-0" href="index.html">Login</a></button> -->
            <!-- <button type="submit" ></button> -->

          </form>
    </div>
  </div>

@endsection 
@section('script') 
  <script> 
      let digitValidate = function (ele){
          console.log(ele.value);
          ele.value = ele.value.replace(/[^0-9]/g, '');
        }

     let tabChange = function (val) {
        let ele = document.querySelectorAll('input');
        if (ele[val - 1].value != '') {
          ele[val].focus()
        } else if (ele[val - 1].value == '') {
          ele[val - 2].focus()
        }
      }
  </script>
@endsection