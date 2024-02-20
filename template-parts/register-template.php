<?php /* Template Name: Register Template */ ?>
<?php
global $wpdb, $user_ID;  
// if (!$user_ID) {  
//    //All code goes in here.  
// }  
// else {  
//    wp_redirect( home_url() ); exit;  
// }
// ?>
<?php 
    if (isset($_POST['btnregister']))
    {
        //registration_validation($_POST['username'], $_POST['useremail']);
        global $reg_errors;
        $reg_errors = new WP_Error;
        $username=$_POST['full_name'];
        $addressname=$_POST['address_name'];//chưa có 
        $phonenumber=$_POST['phone_user'];
        $useremail=$_POST['email_user'];

        $nameuser=$_POST['name_user'];//chưa có 
        $password1=$_POST['pwd1'];
        $password2=$_POST['pwd2'];

        
        
        
        if(empty( $username ) || empty( $useremail ) || empty($password1))
        {
            $reg_errors->add('field', 'Required form field is missing');
        }    
        if ( 6 > strlen( $username ) )
        {
            $reg_errors->add('username_length', 'Username too short. At least 6 characters is required' );
        }
        if ( username_exists( $username ) )
        {
            $reg_errors->add('user_name', 'The username you entered already exists!');
        }
        if ( ! validate_username( $username ) )
        {
            $reg_errors->add( 'username_invalid', 'The username you entered is not valid!' );
        }
        if ( !is_email( $useremail ) )
        {
            $reg_errors->add( 'email_invalid', 'Email id is not valid!' );
        }
        
        if ( email_exists( $useremail ) )
        {
            $reg_errors->add( 'email', 'Email đã tồn tại!' );
        }
        if ( 5 > strlen( $password1 ) ) {
            $reg_errors->add( 'password', 'Password length must be greater than 5!' );
        }
        if( $password1 !== $password2){
            $reg_errors->add( 'password', 'đăng nhập thành công' );
        }
        if (is_wp_error( $reg_errors ))
        { 
            foreach ( $reg_errors->get_error_messages() as $error )
            {
                 $signUpError='<p style="color:#FF0000; text-aling:left;"><strong>ERROR</strong>: '.$error . '<br /></p>';
            } 
        }
        else{
            $reg_errors->add( 'mess', 'Password phải trùng nhau' );
        }
        
        if ( 1 > count( $reg_errors->get_error_messages() ) )
        {
            // sanitize user form input
            global $username, $useremail;
            $username   =   sanitize_user( $_POST['full_name'] );
            $addressuser =   esc_attr( $_POST['address_name'] );
            $userphone   =   esc_attr( $_POST['phone_user'] );
            $useremail  =   sanitize_email( $_POST['email_user'] );
            $nameuser  =   esc_attr( $_POST['name_user'] );
            $password   =   esc_attr( $_POST['pwd1'] );
            
            $userdata = array(
                'user_login'    =>   $username,
                'user_address'    =>   $addressuser,
                'user_activation_key'     =>   $userphone,
                'user_email'    =>   $useremail,
                'user_pass'     =>   $password,
                'display_name'     =>   $nameuser,
                );
            $user = wp_insert_user( $userdata );
            if (!is_wp_error($user_id)) {
            // Đăng nhập người dùng tự động sau khi đăng ký thành công
            // wp_set_auth_cookie($user_id, true, false);
            // do_action('wp_login', $name_user, get_user_by('login', $name_user));
            echo '<script>alert("Đăng ký thành công");</script>';
            wp_redirect(home_url('/dang-nhap')); 
            exit;
        } else {
            $signUpError = '<p style="color:#FF0000; text-align:left;"><strong>ERROR</strong>: Đăng ký không thành công. Vui lòng thử lại sau.</p>';
        }
        }
    
    }
?>
<?php get_header()?>
<section class="registerForm">
    <section class="container">
        <section class="wrapperRegister">
                <div class="titleArcharProduct uppercase relative">
                    <h2 class="">ĐĂng ký</h2>
                    <div class="lineGrey">
                        <span class="itemLineGrey"></span>
                    </div>
                </div>
                <div class="registerContent">
                    <div id="message"></div>
                    <form method="post" id="form-login-register" name="user_registeration">
                        <div class="wrapperInput">
                            <div class="rightFormRegister">
                                <p>
                                    <label><span class="required">*</span></label>
                                    <input type="text" value="" name="name_user" id="name_user" placeholder="Họ và tên" required="">
                                </p>
                                <p>
                                    <label>
                                        <span class="required">*</span>
                                    </label>
                                    <input type="text" value="<?php echo ( ! empty( $_POST['address_name'] ) ) ? esc_attr( wp_unslash( $_POST['address_name'] ) ) : ''; ?>" name="address_name" id="address_name" placeholder="Địa chỉ" required="">
                                </p>
                                <p>
                                    <label><span class="required"></span></label>
                                    <input type="tel" value="" name="phone_user" id="phone_user" placeholder="Số điện thoại">
                                </p>
                                <p>
                                    <label>
                                        <span class="required">*</span>
                                    </label>
                                    <input type="email" value="<?php echo ( ! empty( $_POST['email_user'] ) ) ? esc_attr( wp_unslash( $_POST['email_user'] ) ) : ''; ?>" name="email_user" id="email_user" placeholder="Email" required="">
                                </p>
                            </div>
                            <div class="rightFormRegister">
                                <p>
                                    <label>
                                        <span class="required">*</span>
                                    </label>
                                    <input type="text" value="<?php echo ( ! empty( $_POST['full_name'] ) ) ? esc_attr( wp_unslash( $_POST['full_name'] ) ) : ''; ?>" name="full_name" id="full_name" placeholder="Tên truy cập" required="">
                                </p>
                                
                                <p>
                                    <label><span class="required">*</span></label>
                                    <input type="password" value="" name="pwd1" id="pwd1" placeholder="Mật khẩu" required="">
                                </p>
                                <p>
                                    <label><span class="required">*</span></label>
                                    <input type="password" value="" name="pwd2" id="pwd2" placeholder="Nhập lại mật khẩu" required="">
                                </p>
                                <p>
                                    <label>
                                        <span class="required">*</span>
                                    </label>
                                    <input type="text" value="<?php echo ( ! empty( $_POST['capcha_token'] ) ) ? esc_attr( wp_unslash( $_POST['capcha_token'] ) ) : ''; ?>" name="capcha_token" id="capcha_token" placeholder="Mã bảo mật" >
                                </p>
                            </div>
                        </div>
                        <p class="gap16">
                            <button type="submit" name="btnregister" id="nut-dk" class="button">Đăng ký</button>
                            <button type="rest" name="btnreset" id="nut-reset" class="button">Làm lại</button>
                            <input type="hidden" name="task" value="register">
                        </p>							
                    </form>
                    <?php if(isset($signUpError)){echo '<div>'.$signUpError.'</div>';}?>

                </div>
        </section>
    </section>
</section>

<?php get_footer()?>