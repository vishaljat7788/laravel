<head>
     <meta charset="utf-8">
     <meta http-equiv="x-ua-compatible" content="ie=edge">
     <title>Otp</title>
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
                                        <h6 class="mb-4">Email Verification</h6>
                                        <form class="" id="loginform" name="loginform" method="POST"
                                             action="{{ route('customer.verify_post') }}">
                                             @csrf
                                             @include('web.common.flash')

                                             <div class="form-group">
                                                  <label for="register-email">Email </label>
                                                  <input type="email" class="form-control" id="email" name="email" style="font-size: 18px;"
                                                       required="" placeholder="Enter your email">
                                             </div>


                                             <div class="form-group">
                                                  <label for="register-email">OTP </label>
                                                  <input type="text" class="form-control" id="otp" name="otp" style="font-size: 18px;"
                                                       required="" placeholder="Enter your OTP">
                                             </div>

                                        
                                             </div>

                                             
                                             <div class="row">
                                                  <div class="col-6" style="width: 49%;">
                                                       <!-- <a href="home.php" class="d-inline-block w-100 primary_btn mt-4">Sign In</a> -->
                                                       <button style="margin-left:-48%;" type="submit" class="d-inline-block w-100 primary_btn mt-4">Submit</button>
                                                  </div>
                                                
                                             </div>
                                            
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
            otp: {
                required: true,
            },
            email: {
                required: true,
                email: true, 
            },
        },
        messages: {
            otp: {
                required: "Please enter OTP",
            },
            email: {
                required: "Please enter email",
                email: "Please enter a valid email address",
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
