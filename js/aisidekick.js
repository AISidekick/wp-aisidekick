jQuery(document).ready(function () {
    dragElement(document.getElementById("aisidekick"));

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

    document.querySelector("#aisidekick iframe").contentWindow.postMessage(
        {
            version: "1.0",
            eventName: event,
            data: {
                url: aiSidekickPageUrl,
                title: pageTitle,
                content: contentOfPageExceptTitle,
            },
        },
        "*"
    );
}

function dragElement(elmnt) {
    var pos1 = 0,
        pos2 = 0,
        pos3 = 0,
        pos4 = 0;
    if (document.getElementById(elmnt.id + "header")) {
        // if present, the header is where you move the DIV from:
        document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
    } else {
        // otherwise, move the DIV from anywhere inside the DIV:
        elmnt.onmousedown = dragMouseDown;
    }

    function dragMouseDown(e) {
        e = e || window.event;
        e.preventDefault();
        // get the mouse cursor position at startup:
        pos3 = e.clientX;
        pos4 = e.clientY;
        document.onmouseup = closeDragElement;
        // call a function whenever the cursor moves:
        document.onmousemove = elementDrag;
    }

    function elementDrag(e) {
        e = e || window.event;
        e.preventDefault();
        // calculate the new cursor position:
        pos1 = pos3 - e.clientX;
        pos2 = pos4 - e.clientY;
        pos3 = e.clientX;
        pos4 = e.clientY;
        // set the element's new position:
        elmnt.style.top = elmnt.offsetTop - pos2 + "px";
        elmnt.style.left = elmnt.offsetLeft - pos1 + "px";
    }

    function closeDragElement() {
        // stop moving when mouse button is released:
        document.onmouseup = null;
        document.onmousemove = null;
    }
}

function toggleAiSidekickSize() {
    if (jQuery("#aisidekick").hasClass("small")) {
        jQuery("#aisidekick").removeClass("small");
        jQuery("#aisidekick").addClass("large");
    } else {
        jQuery("#aisidekick").removeClass("large");
        jQuery("#aisidekick").addClass("small");
    }

    if (parseInt(jQuery("#aisidekick").css("bottom")) < 0 || parseInt(jQuery("#aisidekick").css("right")) < 0) {
        jQuery("#aisidekick").css("top", "").css("left", "");
        jQuery("#aisidekick").css("bottom", "40px");
        jQuery("#aisidekick").css("right", "20px");
    }
}

function toggleAiSidekick() {
    if (parseInt(jQuery("#aisidekick").css("bottom")) < 0 || parseInt(jQuery("#aisidekick").css("right")) < 0) {
        jQuery("#aisidekick").css("top", "").css("left", "");
        jQuery("#aisidekick").css("bottom", "40px");
        jQuery("#aisidekick").css("right", "20px");
    } else {
        if (jQuery("#aisidekick").hasClass("large")) {
            jQuery("#aisidekick").removeClass("large");
            jQuery("#aisidekick").addClass("small");
        }

        jQuery("#aisidekick").css("top", "").css("left", "");
        jQuery("#aisidekick").css("bottom", "calc(-70vh + 39px)");
        jQuery("#aisidekick").css("right", "20px)");
    }
}
