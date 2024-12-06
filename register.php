<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Wada Connect</title>

  <link rel="shortcut icon" href="./assets/compiled/jpg/shortcut.png" type="image/png" />

  <link rel="stylesheet" crossorigin href="./assets/compiled/css/app.css">
  <link rel="stylesheet" crossorigin href="./assets/compiled/css/app-dark.css">
  <link rel="stylesheet" crossorigin href="./assets/compiled/css/auth.css">
  <style>
        #auth-right {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        
        #auth-right img {
            max-width: 80%;
            max-height: 80%;
            object-fit: contain;
        }
    </style>
</head>

<body>
  <script src="assets/static/js/initTheme.js"></script>
  <div id="auth">
    <div class="row h-100">
      <div class="col-lg-5 col-12">
        <div id="auth-left">
          <h1 class="auth-title">Sign Up</h1>
          <p class="auth-subtitle mb-5">Register to WadaConnect.</p>

          <form method="POST" action="php/register_wada_members.php" data-parsley-validate>
            <div class="form-group position-relative has-icon-left mb-4">
              <input type="email" class="form-control form-control-xl" name="wadaMemberEmail" placeholder="Email" data-parsley-required="true" data-parsley-error-message="Email is required.">
              <div class="form-control-icon">
                <i class="bi bi-envelope"></i>
              </div>
            </div>
            <div class="form-group position-relative has-icon-left mb-4">
              <input type="text" class="form-control form-control-xl" name="wadaMemberUsername" placeholder="Username" data-parsley-required="true" data-parsley-error-message="Username is required.">
              <div class="form-control-icon">
                <i class="bi bi-person"></i>
              </div>
            </div>
            <div class="form-group position-relative has-icon-left mb-4">
              <input type="password" class="form-control form-control-xl" name="wadaMemberPassword" placeholder="Password" data-parsley-required="true" data-parsley-error-message="Password is required.">
              <div class="form-control-icon">
                <i class="bi bi-shield-lock"></i>
              </div>
            </div>
            <div class="form-group position-relative has-icon-left mb-4">
              <input type="password" class="form-control form-control-xl" name="wadaMemberConfirmPassword" placeholder="Confirm Password" data-parsley-required="true" data-parsley-error-message="Confirm Password is required.">
              <div class="form-control-icon">
                <i class="bi bi-shield-lock"></i>
              </div>
            </div>
            <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Sign Up</button>
          </form>
          <div class="text-center mt-5 text-lg fs-4">
            <p class='text-gray-600'>
              Already have an account?
              <a href="login.php" class="font-bold">Login</a>.
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-7 d-none d-lg-block">
        <div id="auth-right">
          <img src="assets/compiled/jpg/wada_connect_auth.png" alt="Login Logo" height="230px">
        </div>
      </div>
    </div>
  </div>
</body>

<script src="assets/extensions/jquery/jquery.min.js"></script>
<script src="assets/extensions/parsleyjs/parsley.min.js"></script>
<script src="assets/static/js/pages/parsley.js"></script>

</html>