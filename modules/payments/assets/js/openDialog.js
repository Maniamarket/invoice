$(".withdrawDialogBox").dialog({
    autoOpen: false,
    width: 500,
    modal: true,
    show: {
        effect: "fade",
        duration: 500
    },
    hide: {
        effect: "fade",
        duration: 500
    }
});

$("a.openDialog").click(function() {
    $("#dialog" + this.id).dialog("open");
    return false;
});