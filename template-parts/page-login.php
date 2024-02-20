<?php /* Template Name: Login Template */ ?>
<?php
   do_action('user_redirect_if_logged_in');

   // get_header();
   $login = home_url()."/login-new/";
   $dashboard = home_url()."/dashboard/";
   
   if(isset($_REQUEST['signin'])){
      $email = $_POST['username'];
      $password = $_POST['password'];
      $creds = array();
      $creds['user_login'] = $_POST['username'];
      $creds['user_password'] = $_POST['password'];
      $creds['remember'] = false;
      $user = wp_signon( $creds, false );
      $user = wp_signon( $creds);

      if(isset($user->errors)){
      // if(is_wp_error($user)) {
         echo $user->get_error_message();
         die;
      }else{ //successfully logged in
            session_start();  //check for wp_session storage 
            $_SESSION["new_dashboard"] = '1';  //if you want to redirect user to a new page or set any conditions on login
         
                if ($user->is_admin == '1') {
                  $dashboard = home_url()."";
                } else {
                  $dashboard = home_url()."";
                }
        
        //set cookie for remember me //save user login details as cookie if remember me is set, so that if user logs out next time and comes to this log in page, username & password auto fills by checking
        $user_login_details = $email.'_pass_'.$password;
        if(!empty($_POST["remember"])) {
          setcookie ("user_login_details",$user_login_details,time()+ (10 * 365 * 24 * 60 * 60)); //set cookie time as per you need
        } else {  //remove login details from cookie
          if(isset($_COOKIE["user_login_details"])) {
            setcookie ("user_login_details","");
          }
        }
         wp_redirect($dashboard);
         exit;
      }
   }
   
   if(isset($_COOKIE["user_login_details"])) {
          $login_details = $_COOKIE["user_login_details"];
          $login_details = explode('_pass_', $login_details);
          $email_set = $login_details[0];
          $pass_set = $login_details[1];
   }

   ?>
       <!-- value="<?php if(isset($email_set)){ echo $email_set; } ?>"  -->
       <!-- value="<?php if(isset($pass_set)){ echo $pass_set; } ?>" -->
           
<script>
function show_pass() {
  var x = document.getElementById("user_pass");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>

<?php get_header()?>
<?php 
   global $wpdb;
   $db_name = $wpdb->dbname;
?>
<?php
    $home_url = get_home_url();
    if ( is_user_logged_in() ) {
        echo '<p class="container">Bạn đã đăng nhập rồi. <a href="'.wp_logout_url($home_url).'">Đăng xuất</a> ?</p>';
    }else{
      ?>
       
        <section class="login-Form">
          <section class="container">
            <section class="wrapperLogin">
              <section class="contentLoginForm">
                <div class="titleLoginForm">
                  <div class="titleArcharProduct uppercase relative">
                      <h2 class="">ĐĂng nhập</h2>
                      <div class="lineGrey">
                          <span class="itemLineGrey"></span>
                      </div>
                  </div>
                  <div class="loginContent">
                    <form action="" method="POST" name="form-login-register" class="woocommerce-form woocommerce-form-login login" id="form-login-register">
                        <p class="login-username">
                            <label for="user-login">
                                <span class="required">*</span>
                            </label>
                            <input type="text" name="username" id="user_login" autocomplete="username" class="input" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" size="20" placeholder="Email">
                        </p>
                        <p class="login-password" >
                              <label for="user_pass" >
                               <span class="required">*</span>
                              </label>
                            <input type="password" name="password"  id="user_pass" autocomplete="current-password" spellcheck="false" class="input" value="<?php if(isset($pass_set)){ echo $pass_set; } ?>" size="20" placeholder="Mật khẩu">
                            <i class="fa fa-eye" aria-hidden="true" onClick="show_pass()"></i>
                        </p>
                        
                        <button type="submit" id="signin" name="signin">
                            Đăng nhập
                        </button>
                      <?php do_action( 'woocommerce_login_form_end' ); ?>
                    </form>
                  </div>
                  <div class="hrefFormLogin">
                    <h4 class="rememberPassword">
                      <a href="#">Quên mật khẩu</a>
                    </h4>
                    <div class="w30s-widget w30s-widget-line w30s-widget-929690 w30s-widget-unique-1604481372028"><span class="w30s-widget-line-item"></span></div>
                    <h4 class="registerForm">
                      <a href="/shopCar/dang-ky">Đăng ký</a>
                    </h4>
                  </div>
                  <div class="loginSocial">
                    <div class="socialFacebook social-item bg-fb">
                        <div class="borderText color-fb">
                          <span>F</span>
                        </div>
                        <a href="#">Facebook</a>
                    </div>
                    <div class="socialGoogle social-item bg-gg">
                        <div class="borderText color-gg">
                          <span>G</span>
                        </div>
                        <a href="#">Google</a>
                    </div>
                    <div class="socialZalo social-item bg-zl">
                        <div class="borderText color-zl">
                          <span>Z</span>
                        </div>
                        <a href="#">Zalo</a>
                    </div>
                  </div>
                </div>
              </section>
            </section>
          </section>
        </section>
      <?php 
    }
?>

<?php get_footer()?>