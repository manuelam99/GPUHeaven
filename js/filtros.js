$(document).ready(function(){
    $("#nom").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#tarj *").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });