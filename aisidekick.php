<?php
/*
 * AI Sidekick is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 * 
 * AI Sidekick is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with AI Sidekick. If not, see {URI to Plugin License}.
 *
 * @package AI_Sidekick
 *
 * Plugin Name: AI Sidekick
 * Plugin URI: https://ai-sidekick.app/
 * Description: Embed plugin for AI Sideckick in WordPress
 * Version: 0.9.0
 * Author: Matteo Savio
 * Author URI: https://ai-sidekick.app/
 **/

// If this file is called directly, abort.
if (!defined("WPINC")) {
    die();
}

require_once "vendor/autoload.php";
include_once plugin_dir_path(__FILE__) . "inc/class-submenu.php";
include_once plugin_dir_path(__FILE__) . "inc/class-aisidekick-licence-page.php";

add_action("plugins_loaded", "aisidekick_custom_admin_settings");

function aisidekick_custom_admin_settings()
{
    $plugin = new Submenu(new AISidekickLicencePage());
    $plugin->init();
}

add_action("enqueue_block_editor_assets", function () {
    $aiSidekickParameter = [
        "sidekickUrl" => "https://api.neosidekick.com/chat?contentLanguage=en&interfaceLanguage=de&language=de",
        "domain" => home_url(),
        "siteName" => get_bloginfo("name"),
        "apikey" => get_option("aisidekick_licence_key", ""),
        "locale" => get_locale(),
    ];

    wp_enqueue_script(
        "aisidekick-sidebar",
        plugins_url("/aisidekick/js/sidebar.js"),
        ["wp-edit-post", "wp-element", "wp-components", "wp-plugins", "wp-data"],
        filemtime(plugin_dir_path(__FILE__) . "/js/sidebar.js")
    );
    wp_add_inline_script(
        "aisidekick-sidebar",
        "var aiSidekickParameter = " . wp_json_encode($aiSidekickParameter),
        "before"
    );
});

add_filter("plugin_action_links_" . plugin_basename(__FILE__), "aisidekick_settings_link");
function aisidekick_settings_link($links)
{
    $url = "options-general.php?page=ai-sidekick-licence";

    $settings_link = ["<a href='$url'>" . __("Settings") . "</a>"];

    return array_merge($settings_link, $links);
}
