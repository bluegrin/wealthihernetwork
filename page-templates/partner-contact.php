<?php
/**
 * Template Name: Partner Contact
 */

?>
<?php get_header(); ?>
<?php get_template_part( 'template-parts/title' ); ?>
<?php get_template_part( 'template-parts/secondary-nav' ); ?>
<main id="main">
	<div class="contact-form-container partner-contact">
        <?php if ( isset( $_GET['status'] ) && 'success' == $_GET['status'] ): ?>
        <div class="contact-form success">
            <h1 class="font-title">Hooray!</h1>
            <p>We'll get back to you soon!</p>
            <p><a href="/contact" class="button button-secondary">Send Another</a></p>
        </div>
        <?php else: ?>
        <!-- Begin Mailchimp Signup Form -->
        <div id="mc_embed_signup">
            <form action="https://wealthihernetwork.us2.list-manage.com/subscribe/post?u=edc078a4aeaac3b1a112878f0&amp;id=1018afa473&amp;f_id=00364ae0f0" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate contact-form" target="_self">
                <div id="mc_embed_signup_scroll">
                    <div class="mc-field-group form-group">
                        <label for="mce-FNAME">First Name  <span class="asterisk">*</span></label>
                        <input type="text" value="" name="FNAME" class="required" id="mce-FNAME" required placeholder="Jane">
                    </div>
                    <div class="mc-field-group form-group">
                        <label for="mce-LNAME">Last Name  <span class="asterisk">*</span></label>
                        <input type="text" value="" name="LNAME" class="required" id="mce-LNAME" required placeholder="Doe">
                    </div>
                    <div class="mc-field-group form-group">
                        <label for="mce-COMPANY">Company </label>
                        <input type="text" value="" name="COMPANY" class="" id="mce-COMPANY" placeholder="company">
                    </div>
                    <div class="mc-field-group form-group">
                        <label for="mce-JOBTITLE">Job Title </label>
                        <input type="text" value="" name="JOBTITLE" class="" id="mce-JOBTITLE" placeholder="job title">
                    </div>
                    <div class="mc-field-group form-group size1of2">
                        <label for="mce-PHONE">Phone <span class="asterisk">*</span></label>
                        <input type="text" name="PHONE" class="required" value="" id="mce-PHONE" required placeholder="+44 071234 5067">
                    </div>
                    <div class="mc-field-group form-group">
                        <label for="mce-EMAIL">Email Address <span class="asterisk">*</span></label>
                        <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" required placeholder="email address">
                    </div>
                    <div class="mc-field-group form-group">
                        <label for="mce-MESSAGE">Message  <span class="asterisk">*</span></label>
                        <input type="text" value="" name="MESSAGE" class="required" id="mce-MESSAGE" required placeholder="Type your message here">
                    </div>
                    <div id="mce-responses" class="clear">
                        <div class="response" id="mce-error-response" style="display:none"></div>
                        <div class="response" id="mce-success-response" style="display:none"></div>
                    </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                    <div style="position: absolute; left: -5000px;" aria-hidden="true">
                        <input type="text" name="b_edc078a4aeaac3b1a112878f0_1018afa473" tabindex="-1" value="">
                        <input type="hidden" name="tags" value="1357101">
                    </div>
                    <div class="clear"><input type="submit" value="Submit" name="subscribe" id="mc-embedded-subscribe" class="button button-secondary"></div>
                </div>
            </form>
        </div>
        <!--End mc_embed_signup-->
        <?php endif; ?>
    </div>
	<?php the_content(); ?>
</main>
<?php get_template_part( 'template-parts/join-forces' ); ?>
<?php get_footer();