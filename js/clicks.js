$(document).ready(function () {
    $("#modif").click(function (event) {
        event.preventDefault();
        $(".form-control").prop("disabled", false);
    });
});

$(document).ready(function () {
    $('.form-control').on('input',function(e){
        $("button#save").prop("disabled", false);
    });
});