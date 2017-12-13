$(document).on('click', '#close-preview', function(){
    $('.image-preview').popover('hide');
    // Hover befor close the preview
    $('.image-preview').hover(
        function () {
           $('.image-preview').popover('show');
        },
         function () {
           $('.image-preview').popover('hide');
        }
    );
});

$(function() {
    // Create the close button
    var closebtn = $('<button/>', {
        type:"button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;',
    });

    closebtn.attr("class","close pull-right");

    // Set the popover default content
    $('.image-preview').popover({
        trigger:'manual',
        html:true,
        title: "<strong>Preliminar</strong>"+$(closebtn)[0].outerHTML,
        content: "Ninguna imagen seleccionada",
        placement:'top'
    });

    // Clear event
    $('.image-preview-clear').click(function(){
        $('.image-preview').attr("data-content","").popover('hide');
        $('.image-preview-filename').val("");
        $('.image-preview-clear').hide();
        $('.image-preview-input input:file').val("");
    });
    // Create the preview image
    $(".image-preview-input input:file").change(function (){
        var img = $('<img/>', {
            id: 'dynamic',
            width:250,
            height:200
        });
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(file.name);
            img.attr('src', e.target.result);
            $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
        }
        reader.readAsDataURL(file);
    });

});

$("#Fac li").on("click", function(){
  $("#FacR").val($(this).text());
});

$("#FacB li").on("click", function(){
  $("#FacRB").val($(this).text());
});

$(document).ready(function () {

    $('.aIdFile').click(function() {
      $('#idFileDecision').val($(this).attr("data-id"));
      $('#DescargarAFile').attr("href",$(this).attr("data-url"));
    });

    $('#passwordConfirm').on("keyup",function() {
      pass_regist();
    });
    $('#passwordSign').on("keyup",function() {
      pass_regist();
    });

    function pass_regist() {
      if ($('#passwordConfirm').val() == $('#passwordSign').val()) {
        $('#botonRegA').removeAttr("disabled");
      }
      else{
        $('#botonRegA').attr("disabled","disabled");
      }
    };

    $('#passwordConfirmA').on("keyup",function() {
      pass_registA();
    });

    $('#passwordSignA').on("keyup",function() {
      pass_registA();
    });

    function pass_registA() {
      if ($('#passwordConfirmA').val() == $('#passwordSignA').val()) {
        $('#botonActYo').removeAttr("disabled");
      }
      else{
        $('#botonActYo').attr("disabled","disabled");
      }
    };

    $('#passwordConfirmB').on("keyup",function() {
      pass_registB();
    });

    $('#passwordSignB').on("keyup",function() {
      pass_registB();
    });

    function pass_registB() {
      if ($('#passwordConfirmB').val() == $('#passwordSignB').val()) {
        $('#botonActYoB').removeAttr("disabled");
      }
      else{
        $('#botonActYoB').attr("disabled","disabled");
      }
    };

    $('#sinImgV').click(function() {
      $("#uploadFileV").val("profile.jpg");
      $("#img_registerV").attr("src","img_profile/profile.jpg");
    });

    $('#sinImgAV').click(function() {
      $("#uploadFileAV").val("profile.jpg");
      $("#img_registerAV").attr("src","img_profile/profile.jpg");
    });

    $('#uploadBtnV').change(function() {
        var filename = $("#uploadBtnV")[0].files[0].name;
          $("#uploadFileV").val(filename);
            readURL(this);
    });
    function readURL(input){
      var reader = new FileReader();
      reader.onload = function(e){
        $("#img_registerV").attr("src",e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }

    $('#uploadBtnAV').change(function() {
        var filename = $("#uploadBtnAV")[0].files[0].name;
          $("#uploadFileAV").val(filename);
            readURLA(this);
    });
    function readURLA(input){
      var reader = new FileReader();
      reader.onload = function(e){
        $("#img_registerAV").attr("src",e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }

    $(".edittype").click(function(){
      $("#idEdit").val($(this).parents("tr").find("td")[1].innerHTML);
      $("#extensionEdit").val($(this).parents("tr").find("td")[2].innerHTML);
      $("#filesizeEdit").val(($(this).parents("tr").find("td")[3].innerHTML)/1048576);
    });

    $(".editUser").click(function(){
      $("#cedSignB").val($(this).parents("tr").find("td")[1].innerHTML);
      $("#nameSignB").val($(this).parents("tr").find("td")[2].innerHTML);
      $("#FacRB").val($(this).parents("tr").find("td")[3].innerHTML);
      $("#passwordSignB").val($(this).parents("tr").find("td")[6].innerHTML);
      $("#passwordConfirmB").val($(this).parents("tr").find("td")[6].innerHTML);
      $("#img_registerAV").attr("src","img_profile/"+$(this).parents("tr").find("td")[5].innerHTML);
      $("#uploadFileAV").val($(this).parents("tr").find("td")[5].innerHTML);
    });

    $(".deleteType").click(function(){
      $("#deleteId").val($(this).parents("tr").find("td")[1].innerHTML);
    });

    $(".material-switch").click(function(){
      $("#cedPriv").val($(this).parents("tr").find("td")[0].innerHTML);
      $("#Priv").val($(this).attr("name"));
    });

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

});
