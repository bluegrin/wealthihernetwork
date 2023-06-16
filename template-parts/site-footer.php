<footer class="site-footer">
	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'ungated_footer_menu',
			'walker' => new Wealthiher_Walker_Nav_Menu_Footer,
			'container' => 'nav',
			'container_class' => 'nav-menu',
			'container_id' => 'site-footer-nav-menu',
			'items_wrap' => '<ul>%3$s</ul>',
		)
	);
	?>
	<div class="newsletter">
		<h3><?= __wh( 'Stay Updated' ) ?></h3>
        <!-- Begin Mailchimp Signup Form -->
        <div id="mc_embed_signup">
            <form action="https://wealthihernetwork.us2.list-manage.com/subscribe/post?u=edc078a4aeaac3b1a112878f0&amp;id=1018afa473&amp;f_id=00364ae0f0" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_self">
                <div id="mc_embed_signup_scroll">
                    <div class="mc-field-group form-group">
                        <label for="mce-EMAIL">Sign up for our monthly newsletter <span class="asterisk">*</span></label>
                        <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" required placeholder="email address">
                    </div>
                    <div style="position: absolute; left: -5000px;" aria-hidden="true">
                        <input type="text" name="b_edc078a4aeaac3b1a112878f0_1018afa473" tabindex="-1" value="">
                        <input type="hidden" name="tags" value="1357105">
                    </div>
                    <div class="clear"><input type="submit" value="Sign Up" name="subscribe" id="mc-embedded-subscribe" class="button button-primary"></div>
                </div>
            </form>
        </div>
        <!--End mc_embed_signup-->
	</div>
	<div class="colophon">
		<p class="colophon-text"><?= __wh( 'Copyright&nbsp;© WealthiHer&nbsp;' ) ?><?php echo date( 'Y' ); ?></p>
	</div>
</footer>