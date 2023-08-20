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

        const debounce = (context, func, delay) => {
            let timeout;

            return (...arguments) => {
                if (timeout) {
                    clearTimeout(timeout);
                }

                timeout = setTimeout(() => {
                    func.apply(context, arguments);
                }, delay);
            };
        };

        const contentArea = document.querySelector("#editor .edit-post-visual-editor__content-area");

        // Create an observer instance linked to the callback function
        const observer = new MutationObserver(
            debounce(
                this,
                (mutationList, observer) => {
                    // TODO SEND
                    if (!contentArea) {
                        console.info("The content area is gone");
                    }
                    //console.info(contentArea.innerHTML);
                    updateAiSidekick("page-updated");
                },
                500
            )
        );

        observer.observe(contentArea, { attributes: true, childList: true, subtree: true });
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
    console.log(contentOfPageExceptTitle);
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
