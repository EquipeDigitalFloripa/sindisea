jQuery(function( $ ) {

$('.menu').click(function() {
    if (this.id != "home"){
var height = $(this).children('.submenu').height()+20;
if ($(this).children('.submenu').css('visibility') == 'visible'){
    $('#submenu').css({'height':'0', 'opacity': '1'}); 
    $('#submenu2').css({'height':'0', 'opacity': '1'});
    $('.submenu').css({'opacity': '0', visibility:'hidden', 'margin-top':'-80px'});
} else {
$('.submenu').css({'opacity': '0', visibility:'hidden', 'margin-top':'-80px'});
$('#submenu').css({'height':height, 'opacity': '1'});
$('#submenu2').css({'height':height, 'opacity': '1'});
$(this).children().css({'opacity': '1', visibility:'visible', 'margin-top':'+20px'});
}
    }else{
        
    }

});

//menu principal
var quantidadeLi = $('.menu').length;
var width = 100/quantidadeLi+'%';
$('.menu').css({'width':width});


$( ".menu" ).each(function( index ) {
var quantidadeSp = $(this).children('.submenu').children('.subpartes').length;
var submenu = $(this).children('.submenu').width() - 60;
var width = parseInt(submenu)/parseInt(quantidadeSp);  
$(this).children('.submenu').children('.subpartes').css({'width':width});
});

//bolinhas
$( ".link_ball1" ).mouseover(function() {
$('.nav_moldura').css({'opacity': '1', display:'block'});
$('.nav_moldura2').css({'opacity': '0', display:'none'});
$('.nav_moldura3').css({'opacity': '0', display:'none'});
})
$( ".link_ball1" ).mouseout(function() {
$('.nav_moldura').css({'opacity': '1',display:'block'});
$('.nav_moldura2').css({'opacity': '0', display:'none'});
$('.nav_moldura3').css({'opacity': '0', display:'none'});
});
$( ".link_ball2" ).mouseover(function() {
$('.nav_moldura').css({'opacity': '0', display:'none'});
$('.nav_moldura2').css({'opacity': '1',display:'block'});
$('.nav_moldura3').css({'opacity': '0', display:'none'});
})
$( ".link_ball2" ).mouseout(function() {
$('.nav_moldura').css({'opacity': '1',display:'block'});
$('.nav_moldura2').css({'opacity': '0', display:'none'});
$('.nav_moldura3').css({'opacity': '0', display:'none'});
});
$( ".link_ball3" ).mouseover(function() {
$('.nav_moldura').css({'opacity': '0', display:'none'});
$('.nav_moldura2').css({'opacity': '0', display:'none'});
$('.nav_moldura3').css({'opacity': '1',display:'block'});
})
$( ".link_ball3" ).mouseout(function() {
$('.nav_moldura').css({'opacity': '1',display:'block'});
$('.nav_moldura2').css({'opacity': '0', display:'none'});
$('.nav_moldura3').css({'opacity': '0', display:'none'});
});

//Login
$( "#login.textfields" ).focus(function() {
$('.fa-user').css({ 'transform': 'rotate(360deg)','-webkit-transform': 'rotate(360deg)','-moz-transform': 'rotate(360deg)','-o-transform': 'rotate(360deg)'});
})

$( "#senha.textfields" ).focus(function() {
$('.fa-key').css({ 'transform': 'rotate(360deg)','-webkit-transform': 'rotate(360deg)','-moz-transform': 'rotate(360deg)','-o-transform': 'rotate(360deg)'});
})


});