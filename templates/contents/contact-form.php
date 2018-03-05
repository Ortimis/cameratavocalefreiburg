<?php
/**
 * Displays Contact Form on Contact Page Template
 *
 * @package  Eveny
 */

// Captcha on/off
$captcha_option = esc_attr( get_theme_mod( 'eveny_contact_captcha_setting' ) );

?>

<form method="GET" id="contactform" class="contact-form" action="#" >

    <!-- Name -->
    <p class="contact-form-author">
        <label for="contactname"><?php _e( 'Name&nbsp;', 'eveny' ); ?><span class="required"></span></label>
        <input type="text" value="<?php if(isset($_GET['captcha']) && $_GET['captcha'] == 'error'){echo esc_attr($_SESSION['contactname']);} ?>" name="contactname" id="contactname" tabindex="1" />
    </p>
    <!-- Email -->
    <p class="contact-form-email">
        <label for="contactemail"><?php _e( 'Email&nbsp;', 'eveny' ); ?><span class="required"></span></label>
        <input type="text" value="<?php if(isset($_GET['captcha']) && $_GET['captcha'] == 'error'){echo esc_attr($_SESSION['contactemail']);} ?>" name="email" id="contactemail" tabindex="2" />
    </p>
    <!-- Message -->
    <p class="contact-form-contact">
        <label for="contactmessage"><?php _e( 'Message&nbsp;', 'eveny' ); ?><span class="required"></span></label>
        <textarea name="message" id="contactmessage" tabindex="3" rows="6"><?php if(isset($_GET['captcha']) && $_GET['captcha'] == 'error'){echo esc_attr($_SESSION['contactmessage']);} ?></textarea>

        <?php if ( empty( $captcha_option ) ) { //Disable captcha ?>

            <div class="contact-captcha">
                <img src="<?php echo get_template_directory_uri(); ?>/inc/captcha/captcha.php" id="captcha" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/>
                <div class="bg-input captcha-holder">
                    <div class="control-group">
                        <div class="input-prepend">
                            <input type="text" name="captcha" id="captcha-form" autocomplete="off" />
                        </div>
                    </div>
                    <div class="refresh-text">
                        <?php _e( 'Cant read? Refresh Image: ', 'eveny' ); ?>
                            <a onclick="document.getElementById('captcha').src='<?php echo get_template_directory_uri();?>/inc/captcha/captcha.php?'+Math.random(); document.getElementById('captcha-form').focus();"
                        id="change-image" class="captcha-refresh"><img src="<?php echo get_template_directory_uri();?>/theme-images/refresh.png" /></a>
                    </div>
                </div>
            </div>

        <?php } //Disable captcha ?>

    </p>

    <p class="form-submit">
        <input name="submit" type="submit" id="send_contact" value="<?php _e( 'Send Message', 'eveny' ); ?>">
    </p>

    <div id="contact-error"></div>

</form>
