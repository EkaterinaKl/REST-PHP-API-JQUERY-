//api_php/api/?company.findByID={"id_c":1}

$(document).ready(function() {
// url = "php/api.php";

// Attach a submit handler to the form
$("#form1").submit(function( event ) {
  event.preventDefault();

// Get some values from elements on the page:
var $form = $(this);
term = $form.find("#adress").val();

settings = $('input[name=id_type]:checked', '#form1').val();


var posting = $.post('api/?company.findByAdress={"adress": "'+term+'", "id_type":'+settings +'}');



// Put the results in a div
posting.done(function( data ) {

  out="";
  var dataObj = JSON.parse(data);
  //alert(dataObj.response.result);

  if (!dataObj.response.result) {
    out=dataObj.response.error;
  }
  else {
    out=dataObj.response.count;
    if (dataObj.response.items.length>0) {

     dataObj.response.items.forEach(function(entry) {

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

var posting = $.post('api/?company.findByCat={"id_ca": '+term +'}');

// Put the results in a div
posting.done(function( data ) {

  out="";
  var dataObj = JSON.parse(data);
  if (!dataObj.response.result) {
    out=dataObj.response.error;
  }
  else {
   out=dataObj.response.count;
   if (dataObj.response.items.length>0) {


    dataObj.response.items.forEach(function(entry) {

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
var params="";
params = $form.find("#num_x").val()!=="" ? params+'"num_x": '+ $form.find("#num_x").val()+', ': params;
params = $form.find("#num_y").val()!=="" ? params+'"num_y": '+ $form.find("#num_y").val()+', ': params;
params = $form.find("#num_R").val()!=="" ? params+'"num_R": '+ $form.find("#num_R").val()+', ': params;
params = $form.find("#num_x1").val()!=="" ? params+'"num_x1": '+ $form.find("#num_x1").val()+', ': params;
params = $form.find("#num_y1").val()!=="" ? params+'"num_y1": '+ $form.find("#num_y1").val()+', ': params;
settings = $('input[name=id_type]:checked', '#form3').val();

var posting = $.post('api/?company.findByCoord={'+params+'"id_type":'+settings +'}');

// Put the results in a div
posting.done(function( data ) {

  out="";
  var dataObj = JSON.parse(data);
  if (!dataObj.response.result) {
    out=dataObj.response.error;
  }
  else {
    out=dataObj.response.count;
    if (dataObj.response.items.length>0) {


      dataObj.response.items.forEach(function(entry) {

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


var posting = $.post('api/?building.findBuildings={}');

// Put the results in a div
posting.done(function( data ) {

  out="";
  var dataObj = JSON.parse(data);
  if (!dataObj.response.result) {
    out=dataObj.response.error;
  }
  else {
    out=dataObj.response.count;
    if (dataObj.response.items.length>0) {


      dataObj.response.items.forEach(function(entry) {

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
term = $form.find("#name").val();

var r = new RegExp("\x22+","g"); 
term=term.replace(r,'\\"');

var posting = $.post('api/?company.findByName={"name": "'+term +'"}');

// Put the results in a div
posting.done(function( data ) {

  out="";
  var dataObj = JSON.parse(data);
  if (!dataObj.response.result) {
    out=dataObj.response.error;
  }
  else {
    out=dataObj.response.count;
    if (dataObj.response.items.length>0) {


      dataObj.response.items.forEach(function(entry) {

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

//var posting = $.post( url, { id_c: term } );
var posting = $.post('api/?company.findByID={"id_c":'+term+'}');

// Put the results in a div
posting.done(function( data ) {

  out="";
  var dataObj = JSON.parse(data);
  if (!dataObj.response.result) {
    out=dataObj.response.error;
  }
  else {
   out=dataObj.response.count;
   if (dataObj.response.items.length>0) {




    out+="<br><b>"+dataObj.response.items[0].name+"</b>";
    out+="<br>"+dataObj.response.items[0].adress;
    out+="<br>"+"Тел:";
    out+="<br>"+dataObj.response.items[0].phones;
    out+="<br>"+"Категории:";
    out+="<br>"+dataObj.response.items[0].path;

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
  term= (term != '')?  term:"\"\"";
  // JSON.stringify(term);
  
  var posting = $.post( 'api/?catalog.getTree={"id_ca":'+term+'}' );

// Put the results in a div
posting.done(function( data ) {

  out="";
  var dataObj = JSON.parse(data);
  if (!dataObj.response.result) {
    out=dataObj.response.error;
  }
  else {
    if (dataObj.response.items.length>0) {



      out=dataObj.response.items[0].tree;

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