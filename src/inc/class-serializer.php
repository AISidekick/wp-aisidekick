<?php

if (!defined("ABSPATH")) {
    exit();
} // Exit if accessed directly

/**
 * Performs all sanitization functions required to save the option values to
 * the database.
 *
 * This will also check the specified nonce and verify that the current user has
 * permission to save the data.
 *
 * @package AI_Sidekick
 */
class AiSidekickSerializer
{
    public function init()
    {
        add_action("admin_post", [$this, "save"]);
    }

    public function save()
    {
        check_admin_referer("aisidekick_update_licence_key");

        // If the above are valid, sanitize and save the option.
        if (null !== wp_unslash($_POST["aisidekick-licence-key"])) {
            $value = sanitize_text_field($_POST["aisidekick-licence-key"]);
            update_option("aisidekick_licence_key", $value);
        }
        $this->redirect();
    }

    private function redirect()
    {
        check_admin_referer("aisidekick_update_licence_key");
        if (!isset($_POST["_wp_http_referer"])) {
            wp_safe_redirect(wp_login_url());
        }

        $url = sanitize_url(wp_unslash($_POST["_wp_http_referer"]));
        wp_safe_redirect(urldecode($url));
        exit();
    }
}
