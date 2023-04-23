<?php
/**
 * Template Name: Contact
 */

?>
<?php get_header(); ?>
<?php get_template_part( 'template-parts/title' ); ?>
<?php get_template_part( 'template-parts/secondary-nav' ); ?>
<main id="main">
	<div class="contact-form-container">
        <?php if ( isset( $_GET['status'] ) && 'success' == $_GET['status'] ): ?>
        <div class="contact-form success">
            <h1 class="font-title">Hooray!</h1>
            <p>We'll get back to you soon!</p>
            <p><a href="/contact" class="button button-secondary">Send Another</a></p>
        </div>
        <?php else: ?>
        <!-- Begin Mailchimp Signup Form -->
        <div id="mc_embed_signup">
            <form action="/" method="post" class="validate contact-form" target="_self">
                <div id="mc_embed_signup_scroll">
                    <div class="mc-field-group form-group">
                        <label for="mce-FNAME">First Name  <span class="asterisk">*</span></label>
                        <input type="text" value="" name="FNAME" class="required" id="mce-FNAME" required placeholder="Jane">
                    </div>
                    <div class="mc-field-group form-group">
                        <label for="mce-LNAME">Last Name  <span class="asterisk">*</span></label>
                        <input type="text" value="" name="LNAME" class="required" id="mce-LNAME" required placeholder="Doe">
                    </div>
                    <div class="mc-field-group form-group size1of2">
                        <label for="mce-PHONE">Phone <span class="asterisk">*</span></label>
                        <input type="text" name="PHONE" class="required" value="" id="mce-PHONE" required placeholder="+44 071234 5067">
                    </div>
                    <div class="mc-field-group form-group">
                        <label for="mce-EMAIL">Email Address <span class="asterisk">*</span></label>
                        <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" required placeholder="email address">
                    </div>
                    <div class="mc-field-group form-group input-group">
                        <label>Select from the following</label>
                        <label for="mce-group[89577]-89577-0" class="button-check button-unchecked">
                            <input type="checkbox" value="2" name="group[89577][2]" id="mce-group[89577]-89577-0">
                            Investing
                        </label>
                        <label for="mce-group[89577]-89577-1" class="button-check button-unchecked">
                            <input type="checkbox" value="4" name="group[89577][4]" id="mce-group[89577]-89577-1">
                            I'm looking to build my network
                        </label>
                        <label for="mce-group[89577]-89577-2" class="button-check button-unchecked">
                            <input type="checkbox" value="8" name="group[89577][8]" id="mce-group[89577]-89577-2">
                            Financial Education
                        </label>
                        <label for="mce-group[89577]-89577-3" class="button-check button-unchecked">
                            <input type="checkbox" value="16" name="group[89577][16]" id="mce-group[89577]-89577-3">
                            Entrepreneurship
                        </label>
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
                        <input type="hidden" name="tags" value="1356925">
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