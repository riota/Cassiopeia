function ventana(url){
  hintWindow =window.open(url,'Hint','height=450px,width=700px,toolbar=no,resizable=yes,scrollbars=yes')
};

$(document).ready(function () {
    $('#buscar').click(function (){
      hintWindow =window.open('buscar.php','Hint','height=450px,width=700px,toolbar=no,resizable=yes,scrollbars=yes')
    });

    function ventana(url){
      hintWindow =window.open(url,'Hint','height=450px,width=700px,toolbar=no,resizable=yes,scrollbars=yes')
    };

  $("textarea").jqte();

  var trigger = $('.hamburger'),
      overlay = $('.overlay'),
     isClosed = false;

    trigger.click(function () {
      hamburger_cross();
    });

    function hamburger_cross() {

      if (isClosed == true) {
        overlay.hide();
        trigger.removeClass('is-open');
        trigger.addClass('is-closed');
        isClosed = false;
      } else {
        overlay.show();
        trigger.removeClass('is-closed');
        trigger.addClass('is-open');
        isClosed = true;
      }
  }

  $('[data-toggle="offcanvas"]').click(function () {
        $('#wrapper').toggleClass('toggled');
  });
  $("#computer").hover(
      function() {
          $(this).attr("src", "css/img/computer-gif.gif");
      },
      function() {
          $(this).attr("src", "css/img/computer-still.png");
      }
  );
});
