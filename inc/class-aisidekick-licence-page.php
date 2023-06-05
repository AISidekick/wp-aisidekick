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
        $sidekickLicenceKey = get_option("aisidekick_licence_key", "");
        $client = HttpClient::create();

        try {
            $response = $client->request(
                "POST",
                "https://assistant.ai-sidekick.app/api/v1/apikey-status?language=?language=" . get_locale(),
                [
                    "json" => ["token" => $sidekickLicenceKey],
                ]
            );

            $statusCode = $response->getStatusCode();
            $decodedPayload = $response->toArray(false);

            if ($statusCode == 498 && !empty($decodedPayload["message"])) {
                $messageToShow = '<span style="color:red">' . $decodedPayload["message"] . "</span>";
            } elseif ($statusCode == 200 && !empty($decodedPayload["message"])) {
                $messageToShow = '<span style="color:green">' . $decodedPayload["message"] . "</span>";
            } elseif (!empty($decodedPayload["message"])) {
                $messageToShow = '<span style="color:red">' . $decodedPayload["message"] . "</span>";
            } else {
                $messageToShow = "Error retrieving your licence status.";
            }
        } catch (\Throwable $e) {
            $messageToShow = "Error retrieving your licence status.";
        }

        include_once plugin_dir_path(__FILE__) . "../views/licence-page.php";
    }
}
