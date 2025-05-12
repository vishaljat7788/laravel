@if(session('success'))
<div class="alert alert-success" role="alert" id="success-alert">
     {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="alert alert-danger" role="alert" id="error-alert">
     {{ session('error') }}
</div>
@endif

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
     $(document).ready(function() {
          // Hide success message after 3 seconds
          setTimeout(function() {
               $('#success-alert').fadeOut('slow');
          }, 3000);

          // Hide error message after 3 seconds
          setTimeout(function() {
               $('#error-alert').fadeOut('slow');
          }, 3000);
     });
</script>
