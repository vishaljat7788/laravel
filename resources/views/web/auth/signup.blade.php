
<head>
     <meta charset="utf-8">
     <meta http-equiv="x-ua-compatible" content="ie=edge">
     <title>Signup</title>
     <meta name="robots" content="noindex, follow" />
     <meta name="description" content="">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

 </head>


<style>

.modal-content {
    border: none !important;
}

input[type=submit] {
     padding: 14px 28px;
     background-color: #1D1F1F;
     box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.05);
     backdrop-filter: blur(20px);
     color: #fff;
     text-align: center;
     transition: all 0.3s ease;
     position: relative;
     display: inline-block;
     font-size: 16px;
     font-weight: 500;
     line-height: 21.6px;
     font-family: 'Urbanist';
}

button[type=submit] {
     padding: 14px 28px;
     background-color: #1D1F1F;
     box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.05);
     backdrop-filter: blur(20px);
     color: #fff;
     text-align: center;
     transition: all 0.3s ease;
     position: relative;
     display: inline-block;
     font-size: 16px;
     font-weight: 500;
     line-height: 21.6px;
     font-family: 'Urbanist';
}

input[type=submit]:hover {
     background: #1D1F1F;
}

input[type=password] {
     font-size: var(--font-size-b2);
     font-weight: 700;
     height: auto;
     line-height: 37px;
     background: #fff;
     -webkit-box-shadow: none;
     box-shadow: none;
     /* padding: 0 30px; */
     outline: none;
     border: 1px solid rgba(128, 128, 128, 0.329);
     border-radius: var(--radius);
}

.form-group label.error {
     font-size: 14px;
     display: block;
     margin-top: 5px;
     font-weight: normal;
     color: #F44336;
     font-weight: 600;
     margin-bottom: -22px;
     margin-top: -15px;
}


span ul li {

list-style: none;
padding: 0;
margin: 0;
/* font-weight: bold; */
color: red;
  margin-top: -16px;
  margin-left: -18px;

}


       
</style>

@include('web.common.stylesheet')
<!-- <div class="modal fade" id="verify-email" tabindex="-1" aria-hidden="true"> -->

<div class="modal-dialog  modal-xl modal-dialog-centered" style="max-width: 1200px; margin-top: 100px;">
     <div class="modal-content">
          <div class="modal-body  p-0">
               

          <div class="login-stage signup-area">
                       <div class="row g-0">
                           <div class="col-12 col-lg-6 col-md-6 ">
                               <div class="signin-process-left">
                               </div>
                           </div>
                           <div class="col-12 col-lg-6 col-md-6">
                               <div class="rgt-sign-in pop-up-signup" style="margin-left: -44%;margin-right: 57%;">
                                   <div class="mb-3"> 
                                   </div>
                                   <h6 class="mb-4">Signup</h6>

                                   <form class="" id="signupform" name="signupform" method="POST"
                                        action="{{ route('customer.customer.signup') }}" data-parsley-validate="">
                                        @csrf
                                        @include('web.common.flash')
                                   <div class="row align-items-center m-1">
                                           <div class="col-12 col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                  <div class="form-group">
                                                                 <label for="register-email">First Name</label>
                                                                 <input type="text" class="form-control" id="first_name"  data-parsley-required="true"  data-parsley-pattern="^(?!\s)(?!.*[._@#]).*"data-parsley-errors-container="#firstnameerror"data-parsley-required-message="Please enter first name" data-parsley-pattern-message="first name cannot start with a space"
                                                                      name="first_name" style="font-size: 18px;" >
                                                  </div>
                                                  <span id="firstnameerror" class="text-danger"></span>
                                           </div>
                                           <div class="col-12 col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                  <div class="form-group">
                                                                 <label for="register-email">Last Name</label>
                                                                 <input type="text" class="form-control" id="last_name"  data-parsley-required="true"  data-parsley-pattern="^(?!\s)(?!.*[._@#]).*"data-parsley-errors-container="#lastnameerror"data-parsley-required-message="Please enter last name" data-parsley-pattern-message="last name cannot start with a space"
                                                                      name="last_name" style="font-size: 18px;" >
                                                  </div>
                                                  <span id="lastnameerror" class="text-danger"></span>
                                           </div>


                                           <div class="col-12 col-xl-12 col-lg-12 col-md-6 col-sm-6">
                                           <div class="form-group">
                                        <label for="register-email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" style="font-size: 18px;" data-parsley-required="true" data-parsley-pattern="/^\S+@\S+\.\S+$/" data-parsley-errors-container="#emailerror" data-parsley-required-message="Please enter email" required="" placeholder="">
                                        </div>
                                        <span id="emailerror" class="text-danger"></span>
                                           </div>


                                           <div class="col-12 col-xl-12 col-lg-12 col-md-6 col-sm-6">
                                           <label for="register-password">Password</label>
                                        <div class="input-group mb-3 align-items-center">
                                        <input type="password" class="form-control" name="password" id="password" style="margin-bottom: 0px; padding: 1.85rem 1rem; font-size: 18px;" pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$" data-parsley-required="true" data-parsley-required-message="Please enter a password" data-parsley-pattern-message="Please enter a valid password. It should contain at least one uppercase letter, one digit, one special character, and have a minimum length of 8 characters." data-parsley-errors-container="#newpassworderror">
                                        <span class="input-group-text cursor-pointer" id="toggle-password">
                                             <i class="fas fa-eye-slash fa-lg" id="eye-icon"></i>
                                        </span>
                                   </div>
                                   <span id="newpassworderror" class="text-danger"></span>
                                           </div>


                                           


                                           <div class="col-12 col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                           <button type="submit"
                                                       class="d-inline-block w-100 primary_btn mt-4">Sign
                                                       Up</button>
                                           </div>
                                          
                                       </div>

                                       <a href="{{route('customer.loginuser')}}" class="text-center w-100 d-inline-block mt-3 footertext">Already a member?<span class="dark_black">Sign In</span></a>
                                   </form>
                               </div>

                           </div>
                       </div>
                   </div>
           



          </div>
     </div>
</div>


<!-- </div> -->
@include('web.common.script')
<script src="https://cdn.jsdelivr.net/npm/parsleyjs@2.9.2/dist/parsley.min.js"></script>


<script>

function showAlert() {
        alert("This feature is under development");
    }
</script>
