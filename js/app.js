$(document).ready(function() {
  url = "php/api.php";

// Attach a submit handler to the form
$("#form1").submit(function( event ) {
  event.preventDefault();

// Get some values from elements on the page:
var $form = $(this);
term = $form.find("#adress").val();

settings = $('input[name=id_type]:checked', '#form1').val();


var posting = $.post( url, { adress: term, id_type:settings } );

// Put the results in a div
posting.done(function( data ) {

  out="";
  var resp = JSON.parse(data);
  if (!resp.result) {
    out=resp.error;
  }
  else {
    out=resp.count;
    if (resp.items.length>0) {

     resp.items.forEach(function(entry) {

      out+="<br>"+entry.name+":"+entry.adress;
    });

   }
 }
 $( "#result" ).html( out );
 $("#modalBox").modal('show');

});


});



$("#form2").submit(function( event ) {
  event.preventDefault();

// Get some values from elements on the page:
var $form = $(this);
term = $form.find("#id_ca").val();

var posting = $.post( url, { id_ca: term } );

// Put the results in a div
posting.done(function( data ) {

  out="";
  var resp = JSON.parse(data);
  if (!resp.result) {
    out=resp.error;
  }
  else {
   out=resp.count;
   if (resp.items.length>0) {


    resp.items.forEach(function(entry) {

      out+="<br>"+entry.name;
    });

  }
}
$( "#result" ).html( out );
$("#modalBox").modal('show');

});


});


$("#form3").submit(function( event ) {
  event.preventDefault();

// Get some values from elements on the page:
var $form = $(this);
num_x = $form.find("#num_x").val();
num_y = $form.find("#num_y").val();
num_R = $form.find("#num_R").val();
num_x1 = $form.find("#num_x1").val();
num_y1 = $form.find("#num_y1").val();
settings = $('input[name=id_type]:checked', '#form3').val();


var posting = $.post( url, { num_x: num_x,
  num_y: num_y, num_R : num_R, num_x1: num_x1, 
  num_y1 : num_y1, id_type:settings } );

// Put the results in a div
posting.done(function( data ) {

  out="";
  var resp = JSON.parse(data);
  if (!resp.result) {
    out=resp.error;
  }
  else {
    out=resp.count;
    if (resp.items.length>0) {


      resp.items.forEach(function(entry) {

        out+="<br>"+entry.name+". Координаты: x-"+entry.x+", y-"+entry.y;
      });

    }
  }
  $( "#result" ).html( out );
  $("#modalBox").modal('show');

});


});


$("#form4").submit(function( event ) {
  event.preventDefault();

// Get some values from elements on the page:
var $form = $(this);
action = "list";


var posting = $.post( url, { action: action } );

// Put the results in a div
posting.done(function( data ) {

  out="";
  var resp = JSON.parse(data);
  if (!resp.result) {
    out=resp.error;
  }
  else {
    out=resp.count;
    if (resp.items.length>0) {


      resp.items.forEach(function(entry) {

        out+="<br>"+entry.name;
      });

    }
  }
  $( "#result" ).html( out );
  $("#modalBox").modal('show');

});


});

$("#form7").submit(function( event ) {
  event.preventDefault();

// Get some values from elements on the page:
var $form = $(this);
name = $form.find("#name").val();


var posting = $.post( url, { name: name } );

// Put the results in a div
posting.done(function( data ) {

  out="";
  var resp = JSON.parse(data);
  if (!resp.result) {
    out=resp.error;
  }
  else {
    out=resp.count;
    if (resp.items.length>0) {


      resp.items.forEach(function(entry) {

        out+="<br>"+entry.name+". Адрес: "+entry.adress;
      });

    }
  }
  $( "#result" ).html( out );
  $("#modalBox").modal('show');

});


});

$("#form5").submit(function( event ) {
  event.preventDefault();

// Get some values from elements on the page:
var $form = $(this);
term = $form.find("#id_c").val();

var posting = $.post( url, { id_c: term } );

// Put the results in a div
posting.done(function( data ) {

  out="";
  var resp = JSON.parse(data);
  if (!resp.result) {
    out=resp.error;
  }
  else {
   out=resp.count;
   if (resp.items.length>0) {




    out+="<br><b>"+resp.items[0].name+"</b>";
    out+="<br>"+resp.items[0].adress;
    out+="<br>"+"Тел:";
    out+="<br>"+resp.items[0].phones;
    out+="<br>"+"Категории:";
    out+="<br>"+resp.items[0].path;

  }
}
$( "#result" ).html( out );
$("#modalBox").modal('show');

});


});



$("#form6").submit(function( event ) {
  event.preventDefault();


  var $form = $(this);
  term = $form.find("#id_ca").val();


  action= "getTree";
  var posting = $.post( url, { id_ca: term, action:action } );

// Put the results in a div
posting.done(function( data ) {

  out="";
  var resp = JSON.parse(data);
  if (!resp.result) {
    out=resp.error;
  }
  else {
    if (resp.items.length>0) {



      out=resp.items[0].tree;

    }
  }
  $( "#result" ).html( out );
  $("#modalBox").modal('show');

});


});



$(document) .on('show.bs.modal', function (e)
{
  var thisDialog = $(e.target).find('.modal-dialog');
  $(e.target).css('display','block');

  $(window).bind("resize.modalAlign", function ()
  {
    thisDialog.css('margin-top', (thisDialog .outerHeight() < $(window).height()) ? (($(window).height() - thisDialog.outerHeight()) / 2 + 'px') : '')
  })
  .resize();
})



});