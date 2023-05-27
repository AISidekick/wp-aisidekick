// Using ESNext syntax
import { PluginSidebar, PluginSidebarMoreMenuItem } from "@wordpress/edit-post";
import { registerPlugin } from "@wordpress/plugins";
import { more } from "@wordpress/icons";

const ComponentAiSidekick = () => (
    <>
        <PluginSidebarMoreMenuItem target="wp-sidekick">AI Sidekick</PluginSidebarMoreMenuItem>
        <PluginSidebar name="wp-sidekick" title="Sidekick">
            <iframe
                src={aiSidekickParameter.sidekickUrl}
                frameborder="0"
                allowfullscreen
                style={{ width: "100%", height: "calc(100vh - 133px)" }}
            ></iframe>
        </PluginSidebar>
    </>
);

//if (document.documentElement.lang.slice(0, 2) == "de") {
registerPlugin("aisidekick", {
    icon: more,
    render: ComponentAiSidekick,
});
