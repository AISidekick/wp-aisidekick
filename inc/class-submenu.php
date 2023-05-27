<?php
/**
 * Creates the AI Sidekick Submenu
 *
 * @package AI_Sidekick
 */
class Submenu
{
    /**
     * @var Submenu_Page
     * @access private
     */
    private $submenu_page;

    /**
     * Initializes all of the partial classes.
     *
     * @param Submenu_Page $submenu_page A reference to the class that renders the
     * page for the plugin.
     */
    public function __construct($submenu_page)
    {
        $this->submenu_page = $submenu_page;
    }

    /**
     * Adds a submenu for this plugin to the 'Tools' menu.
     */
    public function init()
    {
        add_action("admin_menu", [$this, "add_options_page"]);
    }

    /**
     * Creates the submenu item and calls on the Submenu Page object to render
     * the actual contents of the page.
     */
    public function add_options_page()
    {
        add_options_page("AI Sidekick", "AI Sidekick", "manage_options", "ai-sidekick-licence", [
            $this->submenu_page,
            "render",
        ]);
    }
}
