<div class="wrap">
    <h1><?= esc_html(get_admin_page_title()); ?></h1>
    <form method="post"
          action="<?= esc_attr(wp_nonce_url(admin_url("admin-post.php"), "aisidekick_update_licence_key")); ?>">
        <div id="universal-message-container">
            <h2>AI Sidekick</h2>
            <div class="options">
                <p>
                    <label for="license_key">Licence key:</label>
                    <input id="license_key" type="password" name="aisidekick-licence-key"
                           value="<?= esc_attr(get_option("aisidekick_licence_key", "")); ?>" /><br />
                    <span style="color:<?= esc_attr($messageColor); ?>"><?= $messageToShow; ?></span>
                </p>
            </div><!-- #universal-message-container -->
            <?php
            wp_nonce_field("aisidekick-settings-save", "aisidekick-settings-submission");
            submit_button();
            ?>
    </form>
</div><!-- .wrap -->