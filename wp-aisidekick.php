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
 * Version: 0.9.3
 * Author: Matteo Savio
 * Author URI: https://ai-sidekick.app/
 **/

// If this file is called directly, abort.
if (!defined("WPINC")) {
    die();
}

define("PLUGIN_VERSION", "0.9.3");

require_once "vendor/autoload.php";
include_once plugin_dir_path(__FILE__) . "inc/class-submenu.php";
include_once plugin_dir_path(__FILE__) . "inc/class-serializer.php";
include_once plugin_dir_path(__FILE__) . "inc/class-aisidekick-licence-page.php";

add_action("plugins_loaded", "aisidekick_custom_admin_settings");

function aisidekick_custom_admin_settings()
{
    $serializer = new Serializer();
    $serializer->init();

    $plugin = new Submenu(new AISidekickLicencePage());
    $plugin->init();
}

add_filter("plugin_action_links_" . plugin_basename(__FILE__), "aisidekick_settings_link");
function aisidekick_settings_link($links)
{
    $url = "options-general.php?page=ai-sidekick-licence";

    $settings_link = ["<a href='$url'>" . __("Settings") . "</a>"];

    return array_merge($settings_link, $links);
}

function aisidekick_admin_head()
{
    wp_enqueue_script("aisidekick", plugin_dir_url(__FILE__) . "js/aisidekick.js", [], PLUGIN_VERSION);
    wp_enqueue_style("aisidekick", plugin_dir_url(__FILE__) . "css/aisidekick.css", [], PLUGIN_VERSION);

    wp_enqueue_script("jquery-ui-core");
    wp_enqueue_script("jquery-ui-dialog");

    wp_add_inline_script("aisidekick", 'var aiSidekickPageUrl = "' . get_permalink() . '"', "before");
}
add_action("admin_head", "aisidekick_admin_head");

function aisidekick_admin_footer($data)
{
    $current_screen = get_current_screen();
    if ($current_screen->base != "post") {
        return;
    }
    $locale = get_locale();
    $sidekickLicenceKey = get_option("aisidekick_licence_key", "");
    $userInfo = wp_get_current_user();

    $parameter = [
        "contentLanguage" => $locale,
        "interfaceLanguage" => $locale,
        "language" => $locale,
        "domain" => home_url(),
        "siteName" => get_bloginfo("name"),
        "userId" => $userInfo->data->user_login,
        "platform" => "wordpress",
    ];

    if (!empty($sidekickLicenceKey)) {
        $parameter["apikey"] = $sidekickLicenceKey;
    }?>
    <div id="aisidekick" class="portrait">
       <div style="display: flex;">
      <div id="aisidekickheader">
         <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 165.28864 39.08993" class="h-8 w-auto sm:h-10"><defs><clipPath id="a"><rect x="-50.47784" width="173.28" height="43.92" style="fill: none"></rect></clipPath><linearGradient id="b" data-name="Unbenannter Verlauf 54" x1="67.47692" y1="49.1013" x2="136.0099" y2="-4.44254" gradientUnits="userSpaceOnUse"><stop offset="0.00064" stop-color="#0ff46d"></stop><stop offset="1" stop-color="#12b1d7"></stop><stop offset="1" stop-color="#0bafd6"></stop></linearGradient></defs><g style="clip-path: url(#a)"><path d="M11.56353,8.53449l1.219-.598" style="fill: #fff"></path><circle cx="9.74653" cy="2.83049" r="2.162" style="fill: #64aed4"></circle><line x1="10.50553" y1="4.80849" x2="12.23053" y2="8.28149" style="fill: none;stroke: #64aed4;stroke-miterlimit: 10;stroke-width: 1.14093797683716px"></line><path d="M33.98853,7.91349l1.219.598" style="fill: #fff"></path><circle cx="37.04753" cy="2.83049" r="2.162" style="fill: #64aed4"></circle><line x1="36.28853" y1="4.80849" x2="34.56353" y2="8.28149" style="fill: none;stroke: #64aed4;stroke-miterlimit: 10;stroke-width: 1.14093797683716px"></line><path d="M23.31653,4.70428A16.01736,16.01736,0,1,1,7.44653,20.721a15.961,15.961,0,0,1,15.87-16.01668m0-1.99628a17.99051,17.99051,0,1,0,17.825,17.98975A17.90855,17.90855,0,0,0,23.31653,2.708Z" style="fill: #64aed4"></path><circle cx="17.17553" cy="19.59749" r="2.093" style="fill: #64aed4"></circle><path d="M32.63153,22.90949h-18.4a3.23924,3.23924,0,0,1-3.243-3.243v-.069a3.23924,3.23924,0,0,1,3.243-3.243h18.4a3.23924,3.23924,0,0,1,3.243,3.243v.069A3.254,3.254,0,0,1,32.63153,22.90949Z" style="fill: none;stroke: #64aed4;stroke-miterlimit: 10;stroke-width: 2.08642192840576px"></path><path d="M6.91753,26.61249h-4.025a1.67409,1.67409,0,0,1-1.702-1.656v-7.843a1.70413,1.70413,0,0,1,1.702-1.656h4.025" style="fill: none;stroke: #64aed4;stroke-miterlimit: 10;stroke-width: 1.95589690208435px"></path><path d="M39.27853,26.61249h4.025a1.67409,1.67409,0,0,0,1.702-1.656v-7.843a1.70413,1.70413,0,0,0-1.702-1.656h-4.025" style="fill: none;stroke: #64aed4;stroke-miterlimit: 10;stroke-width: 1.95589690208435px"></path><path d="M18.80853,29.16549a6.5155,6.5155,0,0,0,8.97.115" style="fill: none;stroke: #64aed4;stroke-linecap: round;stroke-miterlimit: 10;stroke-width: 1.95589690208435px"></path></g><g><path d="M60.33888,23.65621H54.084l-1.40478,3.90625H50.64894l5.70117-14.9292h1.72265l5.71143,14.9292h-2.02Zm-5.66016-1.61035H59.7544l-2.543-6.98242Z" style="fill: url(#b)"></path><path d="M67.90626,27.56246H65.93751V12.63326h1.96875Z" style="fill: url(#b)"></path><path d="M81.103,20.90865a9.25531,9.25531,0,0,1-3.68653-1.79A3.41892,3.41892,0,0,1,76.26319,16.499a3.61132,3.61132,0,0,1,1.41016-2.91748,5.60438,5.60438,0,0,1,3.66553-1.15332,6.11392,6.11392,0,0,1,2.74267.59473,4.504,4.504,0,0,1,1.86621,1.64063,4.19174,4.19174,0,0,1,.66211,2.28662H84.63038A2.72977,2.72977,0,0,0,83.769,14.8149a3.50421,3.50421,0,0,0-2.43017-.77685,3.58313,3.58313,0,0,0-2.271.64209,2.14064,2.14064,0,0,0-.81543,1.78222,1.9253,1.9253,0,0,0,.77441,1.5459,7.60032,7.60032,0,0,0,2.63477,1.15625,12.18032,12.18032,0,0,1,2.91211,1.1543A4.41245,4.41245,0,0,1,86.13233,21.789a3.75532,3.75532,0,0,1,.50782,1.9795,3.48933,3.48933,0,0,1-1.415,2.90722,6.03629,6.03629,0,0,1-3.78369,1.0918,7.00983,7.00983,0,0,1-2.8711-.58984,4.82491,4.82491,0,0,1-2.05615-1.61524,3.94075,3.94075,0,0,1-.72266-2.32715h1.979A2.57138,2.57138,0,0,0,78.77,25.373a4.20845,4.20845,0,0,0,2.67139.78515,3.86327,3.86327,0,0,0,2.38916-.63671,2.06248,2.06248,0,0,0,.83007-1.73243,2.028,2.028,0,0,0-.76855-1.69726A8.8477,8.8477,0,0,0,81.103,20.90865Z" style="fill: url(#b)"></path><path d="M88.87452,13.52535a1.1348,1.1348,0,0,1,.28223-.77929,1.06,1.06,0,0,1,.83594-.31788,1.07517,1.07517,0,0,1,.84082.31788,1.12039,1.12039,0,0,1,.2871.77929,1.08352,1.08352,0,0,1-.2871.769,1.09467,1.09467,0,0,1-.84082.30762,1.079,1.079,0,0,1-.83594-.30762A1.09719,1.09719,0,0,1,88.87452,13.52535ZM90.9253,27.56246H89.02882V16.46822H90.9253Z" style="fill: url(#b)"></path><path d="M93.5005,21.92281a6.4969,6.4969,0,0,1,1.209-4.10595,4.11763,4.11763,0,0,1,6.25586-.22071V11.813h1.89649V27.56246h-1.74317l-.09277-1.18945a3.86087,3.86087,0,0,1-3.168,1.39453,3.7884,3.7884,0,0,1-3.14258-1.5791,6.57015,6.57015,0,0,1-1.21484-4.12207Zm1.89648.21582a4.921,4.921,0,0,0,.7793,2.95313,2.51933,2.51933,0,0,0,2.15332,1.0664,2.76833,2.76833,0,0,0,2.63574-1.62109V19.44186A2.79024,2.79024,0,0,0,98.35011,17.873a2.5312,2.5312,0,0,0-2.17383,1.07666A5.41923,5.41923,0,0,0,95.397,22.13863Z" style="fill: url(#b)"></path><path d="M110.40772,27.76754a4.847,4.847,0,0,1-3.66992-1.48145,5.50092,5.50092,0,0,1-1.416-3.96386v-.34766a6.66325,6.66325,0,0,1,.63086-2.94775,4.92619,4.92619,0,0,1,1.76367-2.03028,4.43645,4.43645,0,0,1,2.45605-.7334,4.15511,4.15511,0,0,1,3.36328,1.4253,6.17278,6.17278,0,0,1,1.2002,4.08105v.78907h-7.5166a3.93992,3.93992,0,0,0,.959,2.65039,3.01158,3.01158,0,0,0,2.333,1.00976,3.29314,3.29314,0,0,0,1.70117-.41015,4.26042,4.26042,0,0,0,1.2207-1.08594l1.15821.90234A4.6586,4.6586,0,0,1,110.40772,27.76754Zm-.23535-9.9458a2.5305,2.5305,0,0,0-1.92773.83594,4.05975,4.05975,0,0,0-.96387,2.34277h5.55762v-.14356a3.61122,3.61122,0,0,0-.7793-2.24023A2.38245,2.38245,0,0,0,110.17237,17.82174Z" style="fill: url(#b)"></path><path d="M120.02686,22.42574,118.83741,23.666v3.89648H116.94V11.813h1.89746v9.5249l1.01465-1.21924,3.45605-3.65039h2.30762L121.29835,21.103l4.81934,6.45947h-2.22461Z" style="fill: url(#b)"></path><path d="M127.58351,13.52535a1.1348,1.1348,0,0,1,.28222-.77929,1.06,1.06,0,0,1,.83594-.31788,1.07517,1.07517,0,0,1,.84082.31788,1.12035,1.12035,0,0,1,.28711.77929,1.08349,1.08349,0,0,1-.28711.769,1.09467,1.09467,0,0,1-.84082.30762,1.079,1.079,0,0,1-.83594-.30762A1.09718,1.09718,0,0,1,127.58351,13.52535Zm2.05078,14.03711H127.7378V16.46822h1.89649Z" style="fill: url(#b)"></path><path d="M137.11964,26.21871a2.73562,2.73562,0,0,0,1.77441-.61523,2.16479,2.16479,0,0,0,.83985-1.53711h1.79492a3.44136,3.44136,0,0,1-.65625,1.81445,4.31913,4.31913,0,0,1-1.61524,1.374,4.65745,4.65745,0,0,1-2.13769.5127,4.57023,4.57023,0,0,1-3.60449-1.5127,6.02429,6.02429,0,0,1-1.33789-4.13769v-.31738a6.68418,6.68418,0,0,1,.59472-2.88135,4.53385,4.53385,0,0,1,1.707-1.958,4.85019,4.85019,0,0,1,2.62989-.69727,4.4523,4.4523,0,0,1,3.10254,1.11768,3.99606,3.99606,0,0,1,1.31738,2.90186H139.7339a2.61408,2.61408,0,0,0-.81446-1.76856,2.535,2.535,0,0,0-1.81054-.69238,2.65665,2.65665,0,0,0-2.24024,1.041,4.887,4.887,0,0,0-.79492,3.00831v.35937a4.79037,4.79037,0,0,0,.79,2.95313A2.66743,2.66743,0,0,0,137.11964,26.21871Z" style="fill: url(#b)"></path><path d="M146.75831,22.42574,145.56886,23.666v3.89648H143.6714V11.813h1.89746v9.5249l1.01465-1.21924,3.45605-3.65039h2.30762L148.02979,21.103l4.81934,6.45947h-2.22461Z" style="fill: url(#b)"></path></g></svg>
      </div>
      <div id="aisidekickmenu">
         <button onclick="aiSidekickLandscape()" id="aiSidekickLandscape"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M448 112c8.8 0 16 7.2 16 16V384c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V128c0-8.8 7.2-16 16-16H448zM64 64C28.7 64 0 92.7 0 128V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H64z"/></svg></button>
         <button onclick="aiSidekickPortrait()" id="aiSidekickPortrait"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 448c0 8.8-7.2 16-16 16L64 464c-8.8 0-16-7.2-16-16L48 64c0-8.8 7.2-16 16-16l256 0c8.8 0 16 7.2 16 16l0 384zM384 64c0-35.3-28.7-64-64-64L64 0C28.7 0 0 28.7 0 64L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-384z"/></svg></button>
         <button onclick="aiSidekickFull()" id="aiSidekickFull"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M136 32c13.3 0 24 10.7 24 24s-10.7 24-24 24H48v88c0 13.3-10.7 24-24 24s-24-10.7-24-24V56C0 42.7 10.7 32 24 32H136zM0 344c0-13.3 10.7-24 24-24s24 10.7 24 24v88h88c13.3 0 24 10.7 24 24s-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V344zM424 32c13.3 0 24 10.7 24 24V168c0 13.3-10.7 24-24 24s-24-10.7-24-24V80H312c-13.3 0-24-10.7-24-24s10.7-24 24-24H424zM400 344c0-13.3 10.7-24 24-24s24 10.7 24 24V456c0 13.3-10.7 24-24 24H312c-13.3 0-24-10.7-24-24s10.7-24 24-24h88V344z"/></svg></button>
         <button onclick="aiSidekickDisable()" id="aiSidekickDisable"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M0 256c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32z"/></svg></button>
       </div>
       </div>
      <iframe
            src="https://assistant.ai-sidekick.app/chat?<? echo http_build_query($parameter); ?>"
            frameborder="0"
            allow="clipboard-write"
            allowfullscreen
        ></iframe>
    </div>
    
    <?php
}
add_action("admin_footer", "aisidekick_admin_footer");
