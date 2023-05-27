<?php
use Symfony\Component\HttpClient\HttpClient;
/**
 * Creates the submenu page for the plugin.
 *
 * @package AI_Sidekick
 */
class AISidekickLicencePage
{
    public function render()
    {
        /*$client = HttpClient::create();

        $response = $client->request(
            "POST",
            "https://assistant.ai-sidekick.app/apikeystatus?language=" . get_locale(),
            [
                "body" => "1234123jp",
            ]
        );

        var_dump($response->getContent())*/

        include_once plugin_dir_path(__FILE__) . "../views/licence-page.php";
    }
}
