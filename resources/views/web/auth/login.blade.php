<head>
     <meta charset="utf-8">
     <meta http-equiv="x-ua-compatible" content="ie=edge">
     <title>Login</title>
     <meta name="robots" content="noindex, follow" />
     <meta name="description" content="">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

 </head>

<style>
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
     margin-top: 0px;
}
</style>

@include('web.common.stylesheet')
<!-- <div class="modal fade" id="verify-email" tabindex="-1" aria-hidden="true"> -->
<div class="modal-dialog  modal-xl modal-dialog-centered" style="max-width: 1200px; margin-top: 100px;">
          <div class="modal-content ">
               
               <div class="modal-body p-0">
                    
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
                                        <h6 class="mb-4">Login</h6>
                                        <form class="" id="loginform" name="loginform" method="POST"
                                             action="{{ route('customer.customer.login') }}">
                                             @csrf
                                             @include('web.common.flash')
                                             <div class="form-group">
                                                  <label for="register-email">Email </label>
                                                  <input type="email" class="form-control" id="email" name="email" style="font-size: 18px;"
                                                       required="" placeholder="Enter your email">
                                             </div><!-- End .form-group -->

                                             <label for="register-password">Password</label>
                                             <div class="input-group mb-3 align-items-center">
                                                  <input type="password" class="form-control" placeholder="Enter your password" name="password"
                                                       id="password" style="margin-bottom: 0px; padding: 1.85rem 1rem; font-size: 18px; ">
                                                  <span class="input-group-text cursor-pointer" id="toggle-password">
                                                       <i class="fas fa-eye-slash fa-lg" id="eye-icon"></i>
                                                  </span>
                                             </div>

                                             
                                             <div class="row">
                                                  <div class="col-6" style="width: 49%;">
                                                       <!-- <a href="home.php" class="d-inline-block w-100 primary_btn mt-4">Sign In</a> -->
                                                       <button type="submit" class="d-inline-block w-100 primary_btn mt-4">Sign In</button>
                                                  </div>
                                                
                                             </div>
                                             <a href="{{ route('customer.signupuser') }}"
                                                  class="text-center w-100 d-inline-block mt-4 footertext">New
                                                  Member?<span class="dark_black">Register Now</span></a>
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
<script src="{{ asset('user_assets/js/jquery.validate.min.js') }}"></script> 
    <script src="{{ asset('user_assets/js/jquery-validation-additional-methods.min.js') }}"></script>
    <script>
   
   $("#loginform").validate({
        rules: {
            email: {
                required: true,
                email: true, 
            },
            password: {
                required: true,
                // checklower: true,
                // checkupper: true,
                // checkdigit: true,
                // checkspecialchar: true,
                minlength: 8,
                maxlength: 15        
            },
        },
        messages: {
            email: {
                required: "Please enter email",
                email: "Please enter a valid email address",
            },
            password: {
                required: 'Please enter password',
                // checklower: "Need atleast 1 lowercase alphabet",
                // checkupper: "Need atleast 1 uppercase alphabet",
                // checkdigit: "Need atleast 1 digit",
                // checkspecialchar: "Need atleast 1 special character",
                minlength: 'Password should be of minimum 8 characters',
                maxlength: 'Password should not be of more than 15 characters',            
            },
        },
        submitHandler: function(form) {
            loader('show');
            form.submit();
        },
        highlight: function(input) {
            $(input).parents('.form-line').addClass('error');
        },
        unhighlight: function(input) {
            $(input).parents('.form-line').removeClass('error');
        },
        // errorPlacement: function(error, element) {
        //     if (element.attr("name") === "terms_conditions") {
        //         error.insertAfter(element.parent());
        //     } else {
        //         $(element).parents('.form-group').append(error);
        //     }        
        // }
        errorPlacement: function (error, element) {
            if (element.attr("name") === "terms_conditions") {
                error.insertAfter(element.parent());
            } else if (element.attr("name") === "password") {
                error.insertAfter(element.closest('.input-group'));
            } else {
                // error.insertAfter(element);
                $(element).parents('.form-group').append(error);
            }
        }
    });
    </script>


<script>

function showAlert() {
        alert("This feature is under development");
    }
</script>
