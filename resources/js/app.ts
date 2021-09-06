require('./boot');

/**
 * Constants
 */

const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
const DOCUMENT_GESTURE_HANDLER = new Hammer(document.body);

/**
 * Global functions
 */

function handleFormSubmitLinkClick(event: JQuery.ClickEvent): void {
    event.preventDefault();

    let isConfirmed = true;
    let confirmMessage = event.currentTarget.dataset.confirm;

    if (confirmMessage !== undefined && confirmMessage !== null && confirmMessage !== "") {
        isConfirmed = confirm(confirmMessage);
    }

    if (isConfirmed) {
        let formIdentifier = event.currentTarget.dataset.form;
        if (!formIdentifier) {
            return;
        }

        $(formIdentifier).trigger("submit");
    }
}

$("a[data-form]").on("click", handleFormSubmitLinkClick);

function copyToClipboard(text: string): boolean {
    const textAreaElement = document.createElement("textarea");

    textAreaElement.value = text;
    textAreaElement.setAttribute("readonly", "readonly");
    textAreaElement.style.position = "absolute";
    textAreaElement.style.left = "-10000px";

    document.body.append(textAreaElement);

    const documentSelection = document.getSelection();

    if (documentSelection === null) {
        return false;
    }

    const selected = documentSelection.rangeCount > 0 ?
        documentSelection.getRangeAt(0) : false;

    textAreaElement.select();

    const copySuccessful = document.execCommand("copy");

    if (!copySuccessful) {
        return false;
    }

    document.body.removeChild(textAreaElement);

    if (selected !== false) {
        documentSelection.removeAllRanges();
        documentSelection.addRange(selected);
    }

    return true;
}

function error(message: string): void {
    let element = document.createElement("div");
    element.setAttribute("class", "error");
    element.innerText = message;

    let mainElement = document.getElementById("main");

    if (mainElement === null) {
        return;
    }

    mainElement.prepend(element);
    setTimeout(function() {
        if (mainElement !== null) mainElement.removeChild(element);
    }, 5000);
}

/**
 * Sidebar
 */

function openMobileSidebar(): void {
    let sidebar = $("#sidebar");

    sidebar.animate({
        "margin-left": "0"
    });
}

function closeMobileSidebar(): void {
    let sidebar = $("#sidebar");

    sidebar.animate({
        "margin-left": "-100vw"
    }, () => {
        sidebar.css("margin-left", "");
    });
}

$("#mobile-menu-open").on("click", openMobileSidebar);
$("#mobile-menu-close").on("click", closeMobileSidebar);
$("#mobile-menu-reload").on("click", (event: JQuery.ClickEvent) => {
    $(event.target).addClass('rotate');
    window.location.reload();
});

DOCUMENT_GESTURE_HANDLER.on('swiperight', function() {
    openMobileSidebar();
});

const sidebarElement = document.getElementById("sidebar");

if (sidebarElement !== null) {
    const sidebarGestureHandler = new Hammer(sidebarElement);
    sidebarGestureHandler.on('swipeleft', function() {
        closeMobileSidebar();
    });
}

/**
 * Group overview
 *
 * Route: /app/group/{group}/overview
 */

function updateTurfAmount(row: JQuery, operation: "increment" | "decrement") {
    const user_id = row.data("user");
    const group_id = document.body.dataset["group"];

    const error_message = $("#turf-overview").data("error");

    if (user_id === undefined || group_id === undefined || error_message === undefined) {
        // We don't know who the user is; abort.
        return;
    }

    $.ajax({
        url: '/api/group/' + group_id + '/amount',
        type: 'PUT',
        data: { "receiver": user_id, "operation": operation },
        headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
        success: function() {
            const turfAmountElement = row.find(".amount");
            const currentTurfAmount = parseInt(turfAmountElement.text());

            if (operation === "increment") {
                turfAmountElement.text(currentTurfAmount + 1);
            } else if (operation === "decrement") {
                turfAmountElement.text(currentTurfAmount - 1);
            }
        },
        error: function() {
            error(error_message);
        }
    });
}

$(".decrement").on("click", (event: JQuery.ClickEvent) => {
    const row = $(event.target).closest(".row");
    updateTurfAmount(row, "decrement");

    // Stop the event propagation, since we do not want the click handler
    // of the parent to fire
    event.stopPropagation()
});

$(".increment").on("click", (event: JQuery.ClickEvent) => {
    const row = $(event.target).closest(".row");
    updateTurfAmount(row, "increment")

    // Stop the event propagation, since we do not want the click handler
    // of the parent to fire
    event.stopPropagation()
});

/**
 * Member view
 *
 * Route: /app/group/{group}/member/{user}
 */

/**
 * Add view
 *
 * Route: /app/group/{group}/add
 */
const joinLinkElement = $("#join-link");

joinLinkElement.on("mouseover", (event: JQuery.MouseOverEvent) => {
    event.currentTarget.select();
});

joinLinkElement.on("click", (event: JQuery.ClickEvent) => {
    event.currentTarget.select();
});

$("#copy-link").on("click", (event: JQuery.ClickEvent) => {
    const joinLink = joinLinkElement.val();
    const copiedMessage = event.currentTarget.dataset.copied;
    const copyFailed = event.currentTarget.dataset.copyfailed;
    const copyLinkButton = $("#copy-link-button");
    const originalText = copyLinkButton.text();

    if (copyFailed === undefined) {
        // :(
        return;
    }

    if (copiedMessage === undefined || typeof joinLink !== "string") {
        copyLinkButton.text(copyFailed);
        setTimeout(() => copyLinkButton.text(originalText), 2000);
        return;
    }

    const copySuccessful = copyToClipboard(joinLink);

    if (!copySuccessful) {
        copyLinkButton.text(copyFailed);
        setTimeout(() => copyLinkButton.text(originalText), 2000);
        return;
    }

    copyLinkButton.text(copiedMessage);
    setTimeout(() => copyLinkButton.text(originalText), 2000);
});

const iconWelcome = $("#icon-welcome");

iconWelcome.on("click", (event: JQuery.ClickEvent) => {
    const color = Math.floor(Math.random() * 16777215).toString(16);
    event.currentTarget.style.color = "#" + color;
});
