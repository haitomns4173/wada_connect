$(document).ready(function () {
    $("#marital-status-column").change(function () {
    var maritalStatus = $(this).val();

    if (maritalStatus === "unmarried") {
        $("#spouse-name-field").hide();
        $( "#spouse-name-field").val("");

        $("#children-field").hide();
        $( "#children-field").val("");

        $("#spouse-name-column-np-field").hide();
        $( "#spouse-name-column-np-field").val("");
    } else {
        $("#spouse-name-field").show();
        $("#children-field").show();
        $("#spouse-name-column-np-field").show();
    }
    });

    $("#marital-status-column").trigger("change");
});
