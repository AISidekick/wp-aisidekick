jQuery(document).ready(function () {
    jQuery("#aisidekick").draggable({
        handle: "#aisidekickheader",
    });

    setTimeout(function () {
        updateAiSidekick();
        document.querySelector("h1.editor-post-title").addEventListener("change", function () {
            updateAiSidekick("page-updated");
        });

        //var editable = document.querySelectorAll('div[contentEditable]');

        var editable = document.querySelectorAll("h1.editor-post-title");

        for (var i = 0, len = editable.length; i < len; i++) {
            editable[i].setAttribute("data-orig", editable[i].innerHTML);

            editable[i].onblur = function () {
                if (this.innerHTML != this.getAttribute("data-orig")) {
                    // change has happened, store new value
                    this.setAttribute("data-orig", this.innerHTML);
                    updateAiSidekick("page-updated");
                }
            };
        }

        /*
        document.querySelector("#aisidekick iframe").addEventListener("message", function (event) {
            if (event.data.eventName === "write-content") {
                let changes = event.data.data;

                console.log(changes);
            }
        });*/
    }, 1000);
});

function updateAiSidekick(event = "page-changed") {
    const pageTitle = document.querySelector("h1.editor-post-title").innerText;
    const pageUrl = window.location.href; // WRONG!!!

    const editableElements = document.querySelectorAll("#editor [contenteditable=true]:not(h1.editor-post-title)");
    contentOfPageExceptTitle = "";
    for (let i = 0; i < editableElements.length; i++) {
        contentOfPageExceptTitle = contentOfPageExceptTitle + editableElements[i].outerHTML;
    }

    aiSidekickData = {
        version: "1.0",
        eventName: event,
        data: {
            url: aiSidekickPageUrl,
            title: pageTitle,
            content: contentOfPageExceptTitle,
        },
    };

    result = document.querySelector("#aisidekick iframe").contentWindow.postMessage(aiSidekickData, "*");
    console.log(result);
}

function aiSidekickLandscape() {
    jQuery("#aisidekick").removeClass("full portrait disabled");
    jQuery("#aisidekick").addClass("landscape");
}

function aiSidekickPortrait() {
    jQuery("#aisidekick").removeClass("landscape full disabled");
    jQuery("#aisidekick").addClass("portrait");
}

function aiSidekickFull() {
    jQuery("#aisidekick").removeClass("landscape portrait disabled");
    jQuery("#aisidekick").addClass("full");
}

function aiSidekickDisable() {
    jQuery("#aisidekick").removeClass("landscape portrait full");
    jQuery("#aisidekick").addClass("disabled");
}
