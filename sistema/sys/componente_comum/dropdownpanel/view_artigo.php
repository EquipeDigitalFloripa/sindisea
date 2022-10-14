 <script type="text/JavaScript">
 
 
var isInstalled = false;
var version = null;
if (window.ActiveXObject) {
    var control = null;
    try {
        // AcroPDF.PDF is used by version 7 and later
        control = new ActiveXObject('AcroPDF.PDF');
    } catch (e) {
        // Do nothing
    }
    if (!control) {
        try {
            // PDF.PdfCtrl is used by version 6 and earlier
            control = new ActiveXObject('PDF.PdfCtrl');
        } catch (e) {
            // Do nothing
        }
    }
    if (control) {
        isInstalled = true;
        version = control.GetVersions().split(',');
        version = version[0].split('=');
        version = parseFloat(version[1]);
    }
} else {

    var num_of_plugins = navigator.plugins.length;
    for (var i=0; i < num_of_plugins; i++) {
         var list_number=i+1;
         var str= ''+navigator.plugins[i].name+'';
         //alert(''+navigator.plugins[i].name+'');
         if(str.indexOf("Adobe Acrobat") >= 0 || str.indexOf("Adobe Reader") >= 0){
           isInstalled = true;
         }
    }

}
 
 
 if(isInstalled){

    var locat = "view_pdf3.php?id_artigo=<? echo $id_artigo; ?>&lingua=<? echo $lingua; ?>#navpanes=0&zoom=100";

 }else{

    var locat = "http://www.adobe.com/products/acrobat/readstep2.html";


 }
 
 
 
 

function criaNodo(){
 var iframe = document.createElement("iframe");
 iframe.setAttribute('id','pdf');
 iframe.setAttribute('name','pdf');
 iframe.setAttribute('width','100%');
 iframe.setAttribute('height','550');
 iframe.setAttribute('allowTransparency','yes');
 iframe.setAttribute('frameborder','1');
 iframe.setAttribute('src',locat);
 return iframe;
}


function abra(){
  if (window.addEventListener){ // para nao IE
    document.getElementById("minha").style.display="block";

    if(document.getElementById("pdf2")){
      document.getElementById("minha").removeChild(document.getElementById("pdf2"));
    }

    iframe = criaNodo();
    document.getElementById("minha").appendChild(iframe);
    document.getElementById("leg").innerHTML="<? echo $leg24; ?>";
  }else{

    if(document.getElementById("pdf2")){
      document.getElementById("minha").removeChild(document.getElementById("pdf2"));
    }
    iframe = criaNodo();
    document.getElementById("minha").appendChild(iframe);
    document.getElementById("leg").innerHTML="<? echo $leg24; ?>";
  }
}

function fecha(){
   if (window.addEventListener){ // para nao IE
     document.getElementById("minha").style.display="none";
     document.getElementById("leg").innerHTML="<? echo $leg23; ?>";
     document.getElementById("minha").removeChild(document.getElementById("pdf"));
   }else{
     document.getElementById("leg").innerHTML="<? echo $leg23; ?>";
     document.getElementById("minha").removeChild(document.getElementById("pdf"));
   }
}

function mostraDIV(){

      document.getElementById("minha").style.visibility = "visible";

}

function escondeDIV(){

      document.getElementById("minha").style.visibility = "hidden";

}



</script>

 <link rel="stylesheet" type="text/css" href="componente_comum/dropdownpanel/dddropdownpanel.css" />

<script type="text/javascript" src="componente_comum/dropdownpanel/dddropdownpanel.js"> </script>
