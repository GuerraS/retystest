
    if ($.cookie('highcontrast') == "yes") {
        $("body").addClass("highcontrast");     
    }
    if($.cookie('invertcolors') == "yes"){
        $("body").addClass("invertcolors");
    }
    if($.cookie('enfatizar') == "yes"){
        $("body").addClass("enfatizar");
    }
    if($.cookie('subrayar') == "yes"){
        $("body").addClass("subrayar");
    }
    if($.cookie('legible') == "yes"){
        $("body").addClass("legible");
    }
    if($.cookie('legible') == "yes"){
        $("body").addClass("legible");
    }
    if($.cookie('contraste-oscuro') == "yes"){
        $("body").addClass("contraste-oscuro");
    }
    if($.cookie('monocromo') == "yes"){
        $("body").addClass("monocromo");
    }
    if($.cookie('contraste-luz') == "yes"){
        $("body").addClass("contraste-luz");
    }
    if($.cookie('cursor-negro-grande') == "yes"){
        $("body").addClass("cursor-negro-grande");
    }
    if($.cookie('cursor-blanco-grande') == "yes"){
        $("body").addClass("cursor-blanco-grande");
    }
    if($.cookie('enfatizar-al-pasar-cursor') == "yes"){
        $("body").addClass("enfatizar-al-pasar-cursor");
    }
  
    //Inicio Incrementar y decrementar la fuente e la pagina 
        var $elementosAfectados = $("p,.contenido-info-tramites, .tramite-liga,#linea-icono,#detalles");
        $elementosAfectados.each(function(){
            var $this=$(this);
            $this.data("origin-size",$this.css("font-size"));
        });
        //Incrementar Fuente
        document.getElementById("btn-increase")
        .addEventListener("keyup", function(event) {
            event.preventDefault();
            if (event.keyCode == 13) {
                document.getElementById("btn-increase").click();
            }
        });
        $("#btn-increase").click(function(){
            changeFontSize(1);
        });
        //Decrementar fuente
        document.getElementById("btn-decrease")
        .addEventListener("keyup", function(event) {
            event.preventDefault();
            if (event.keyCode == 13) {
                document.getElementById("btn-decrease").click();
            }
        });
        $("#btn-decrease").click(function(){
            changeFontSize(-1);
        });
        //Tamaño fuente Original
        document.getElementById("btn-origin")
        .addEventListener("keyup", function(event) {
            event.preventDefault();
            if (event.keyCode == 13) {
                document.getElementById("btn-origin").click();
            }
        });
        $("#btn-origin").click(function(){
            $elementosAfectados.each(function(){
                var $this=$(this);
                $this.css("font-size",$this.data("origin-size"));
            });
        });
        function changeFontSize(value){
            $elementosAfectados.each(function(){
                var $this=$(this);
                $this.css( "font-size" , parseInt($this.css("font-size"))+value);
            });
        }    
        $("#GobNavbar").addClass("fixed-top");


   
    //Cambiar contraste  
        //alert("El color del texto es " + $("#leyenda").css("fontFamily"));
        $(".contraste-alto").click(function (){ 
            // Check the current cookie value
            // If the cookie is empty or set to no, then add highcontrast
            if ($.cookie('highcontrast') == "undefined" || $.cookie('highcontrast') == "no") {
                // Set cookie value to yes
                $.cookie('highcontrast','yes', {expires: 7, path: '/'});
                $.cookie('invertcolors','no',  {expires: 7, path: '/'});
                $.cookie('enfatizar','no',  {expires: 7, path: '/'});
                $.cookie('subrayar','no',  {expires: 7, path: '/'});
                $.cookie('contraste-oscuro','no',     {expires: 7, path: '/'});
                $.cookie('contraste-luz','no',     {expires: 7, path: '/'});
                $.cookie('monocromo','no',     {expires: 7, path: '/'});

                // Add the class to the body
                $("body").removeClass("invertcolors");
                $("body").removeClass("subrayar");
                $("body").removeClass("enfatizar");
                $("body").addClass("highcontrast");
                $("body").removeClass("contraste-oscuro"); 
                $("body").removeClass("contraste-luz");              

            }
            // If the cookie was already set to yes then remove it
            else {
                $.cookie('highcontrast','no',  {expires: 7, path: '/'});
                $("body").removeClass("highcontrast");
            }
		}); 
    //Invertir Color
        $(".invertir-color").click(function () {
            // Check the current cookie value
            // If the cookie is empty or set to no, then add highcontrast
            if ($.cookie('invertcolors') == "undefined" || $.cookie('invertcolors') == "no") {
                // Set cookie value to yes
                $.cookie('highcontrast','no', {expires: 7, path: '/'});
                $.cookie('enfatizar','no',  {expires: 7, path: '/'});
                $.cookie('invertcolors','yes',  {expires: 7, path: '/'});
                $.cookie('subrayar','no',     {expires: 7, path: '/'});
                $.cookie('contraste-oscuro','no',     {expires: 7, path: '/'});
                $.cookie('contraste-luz','no',     {expires: 7, path: '/'});
                $.cookie('cursor-negro-grande','no',     {expires: 7, path: '/'});

                // Add the class to the body
                
                $("body").removeClass("highcontrast");
                $("body").removeClass("enfatizar");
                $("body").removeClass("subrayar");
                $("body").removeClass("contraste-oscuro");
                $("body").removeClass("contraste-luz");
                $("body").removeClass("cursor-negro-grande");  
                $("body").addClass("invertcolors"); 
            }
            // If the cookie was already set to yes then remove it
            else {
                $.cookie('invertcolors','no',  {expires: 7, path: '/'});
                $("body").removeClass("invertcolors");
            }   
		});
    //subrayar titulos
        $(".btn-subrayar").click(function () {
            // Check the current cookie value
            // If the cookie is empty or set to no, then add highcontrast
            if ($.cookie('subrayar') == "undefined" || $.cookie('subrayar') == "no") {
                // Set cookie value to yes
                $.cookie('highcontrast','no', {expires: 7, path: '/'});
                $.cookie('invertcolors','no',  {expires: 7, path: '/'});
                
                $.cookie('contraste-oscuro','no',     {expires: 7, path: '/'});
                $.cookie('subrayar','yes',  {expires: 7, path: '/'});
                // Add the class to the body
                $("body").removeClass("highcontrast");
                $("body").removeClass("invertcolors");
                
                $("body").removeClass("contraste-oscuro");               
                $("body").addClass("subrayar");
            }
            // If the cookie was already set to yes then remove it
            else {
                $.cookie('subrayar','no',  {expires: 7, path: '/'});
                $("body").removeClass("subrayar");
            }
        });
    //Fuente legible(Negritas)
        $(".btn-legible").click(function () {
            // Check the current cookie value
            // If the cookie is empty or set to no, then add highcontrast
            if ($.cookie('legible') == "undefined" || $.cookie('legible') == "no") {
                // Set cookie value to yes
                $.cookie('legible','yes',  {expires: 7, path: '/'});
                // Add the class to the body
                         
                $("body").addClass("legible");                 
            }
            // If the cookie was already set to yes then remove it
            else {
                $.cookie('legible','no',  {expires: 7, path: '/'});
                $("body").removeClass("legible");
            }
		    }); 
    //enfatizar
        $(".btn-enfatizar").click(function () {
            //Check the current cookie value
            //If the cookie is empty or set to no, then add highcontrast
            if ($.cookie('enfatizar') == "undefined" || $.cookie('enfatizar') == "no") {
                console.log("Bien");
                //Set cookie value to yes
                $.cookie('highcontrast','no', {expires: 7, path: '/'});
                $.cookie('invertcolors','no', {expires: 7, path: '/'});
                $.cookie('subrayar','no',     {expires: 7, path: '/'});
                $.cookie('contraste-oscuro','no',     {expires: 7, path: '/'});
                $.cookie('contraste-luz','no',     {expires: 7, path: '/'});
                $.cookie('monocromo','no',     {expires: 7, path: '/'});
                $.cookie('enfatizar','yes',  {expires: 7, path: '/'});
                //Add the class to the body
                $("body").removeClass("highcontrast");
                $("body").removeClass("invertcolors");
                $("body").removeClass("subrayar");
                $("body").removeClass("contraste-oscuro");
                $("body").removeClass("contraste-luz");
                $("body").removeClass("monocromo");
                $("body").addClass("enfatizar");
            }
            //If the cookie was already set to yes then remove it
            else {
                $.cookie('enfatizar','no',  {expires: 7, path: '/'});
                $("body").removeClass("enfatizar");
            }
        });
/*Contraste oscuro*/
        $(".btn-contraste-oscuro").click(function () {
            // Check the current cookie value
            // If the cookie is empty or set to no, then add highcontrast
            if ($.cookie('contraste-oscuro') == "undefined" || $.cookie('contraste-oscuro') == "no") {
                // Set cookie value to yes
                $.cookie('highcontrast','no', {expires: 7, path: '/'});
                $.cookie('invertcolors','no',  {expires: 7, path: '/'});
                $.cookie('enfatizar','no',  {expires: 7, path: '/'});
                $.cookie('subrayar','no',  {expires: 7, path: '/'}); 
                $.cookie('contraste-luz','no',  {expires: 7, path: '/'});
                $.cookie('monocromo','no',  {expires: 7, path: '/'}); 
                $.cookie('cursor-negro-grande','no',  {expires: 7, path: '/'});             
                $.cookie('contraste-oscuro','yes',  {expires: 7, path: '/'});
                // Add the class to the body
                $("body").addClass("contraste-oscuro");
                $("body").removeClass("highcontrast");
                $("body").removeClass("invertcolors");
                $("body").removeClass("enfatizar"); 
                $("body").removeClass("subrayar");
                $("body").removeClass("monocromo");
                $("body").removeClass("contraste-luz");  
                $("body").removeClass("cursor-negro-grande"); 
            }
            // If the cookie was already set to yes then remove it
            else {
                $.cookie('contraste-oscuro','no',  {expires: 7, path: '/'});
                $("body").removeClass("contraste-oscuro");
            }
            });
/*monocromo*/
        $(".btn-monocromo").click(function () {
            // Check the current cookie value
            // If the cookie is empty or set to no, then add highcontrast
            if ($.cookie('monocromo') == "undefined" || $.cookie('monocromo') == "no") {
                // Set cookie value to yes
                $.cookie('highcontrast','no', {expires: 7, path: '/'});
                $.cookie('invertcolors','no',  {expires: 7, path: '/'});
                $.cookie('enfatizar','no',  {expires: 7, path: '/'});
                $.cookie('subrayar','no',  {expires: 7, path: '/'});
                $.cookie('monocromo','yes',  {expires: 7, path: '/'});
                $.cookie('contraste-oscuro','no',  {expires: 7, path: '/'});
                $.cookie('contraste-luz','no',  {expires: 7, path: '/'});
                // Add the class to the body
                $("body").removeClass("highcontrast");
                $("body").removeClass("invertcolors");
                $("body").removeClass("enfatizar");     
                $("body").addClass("monocromo");
                $("body").removeClass("contraste-oscuro");
                $("body").removeClass("subrayar");
                $("body").removeClass("contraste-luz");      
            }
            // If the cookie was already set to yes then remove it
            else {
                $.cookie('monocromo','no',  {expires: 7, path: '/'});
                $("body").removeClass("monocromo");
            }
            }); 
            /*Contraste luz */
        $(".btn-contraste-luz").click(function () {
                // Check the current cookie value
                // If the cookie is empty or set to no, then add highcontrast
                if ($.cookie('contraste-luz') == "undefined" || $.cookie('contraste-luz') == "no") {
                    // Set cookie value to yes
                    $.cookie('highcontrast','no', {expires: 7, path: '/'});
                    $.cookie('invertcolors','no',  {expires: 7, path: '/'});
                    $.cookie('enfatizar','no',  {expires: 7, path: '/'});            
                    $.cookie('monocromo','no',  {expires: 7, path: '/'});
                    $.cookie('contraste-oscuro','no',  {expires: 7, path: '/'});
                    $.cookie('contraste-luz','yes',  {expires: 7, path: '/'});
                    // Add the class to the body
                    $("body").removeClass("highcontrast");
                    $("body").removeClass("invertcolors");
                    $("body").removeClass("enfatizar");                  
                    $("body").removeClass("monocromo");
                    $("body").removeClass("contraste-oscuro");                
                    $("body").addClass("contraste-luz");               
                }
                // If the cookie was already set to yes then remove it
                else {
                    $.cookie('contraste-luz','no',  {expires: 7, path: '/'});
                    $("body").removeClass("contraste-luz");
                }
        });
/*CURSOR GRANDE blanco*/
$(".btn-cursor-blanco-grande").click(function () {
    // Check the current cookie value
    // If the cookie is empty or set to no, then add highcontrast
    if ($.cookie('cursor-blanco-grande') == "undefined" || $.cookie('cursor-blanco-grande') == "no") {
        // Set cookie value to yes
        
        $.cookie('invertcolors','no',  {expires: 7, path: '/'});
        $.cookie('enfatizar','no',  {expires: 7, path: '/'});   
        $.cookie('monocromo','no',  {expires: 7, path: '/'});
        $.cookie('contraste-oscuro','no',  {expires: 7, path: '/'});
        $.cookie('contraste-luz','no',  {expires: 7, path: '/'});
        $.cookie('cursor-negro-grande','no',  {expires: 7, path: '/'});
        $.cookie('cursor-blanco-grande','yes',  {expires: 7, path: '/'});
        // Add the class to the body
        
        $("body").removeClass("invertcolors");
        $("body").removeClass("enfatizar");                  
        $("body").removeClass("monocromo");
        $("body").removeClass("contraste-oscuro");
        $("body").removeClass("contraste-luz");
        $("body").removeClass("cursor-negro-grande");
        $("body").addClass("cursor-blanco-grande");     
    }
    // If the cookie was already set to yes then remove it
    else {
        $.cookie('cursor-blanco-grande','no',  {expires: 7, path: '/'});
        $("body").removeClass("cursor-blanco-grande");
    }
});
/*CURSOR GRANDE negro*/
$(".btn-cursor-negro-grande").click(function () {
    // Check the current cookie value
    // If the cookie is empty or set to no, then add highcontrast
    if ($.cookie('cursor-negro-grande') == "undefined" || $.cookie('cursor-negro-grande') == "no") {
        // Set cookie value to yes
        $.cookie('highcontrast','no', {expires: 7, path: '/'});
        $.cookie('invertcolors','no',  {expires: 7, path: '/'});
        $.cookie('enfatizar','no',  {expires: 7, path: '/'});
        $.cookie('contraste-oscuro','no',  {expires: 7, path: '/'});
        $.cookie('contraste-LUZ','no',  {expires: 7, path: '/'});
        $.cookie('cursor-blanco-grande','no',  {expires: 7, path: '/'});
        $.cookie('cursor-negro-grande','yes',  {expires: 7, path: '/'});
        // Add the class to the body
        $("body").removeClass("highcontrast");
        $("body").removeClass("invertcolors");
        $("body").removeClass("enfatizar");                  
        
        $("body").removeClass("contraste-oscuro");
        $("body").removeClass("contraste-luz");
        $("body").removeClass("cursor-blanco-grande");
        $("body").addClass("cursor-negro-grande");     
    }
    // If the cookie was already set to yes then remove it
    else {
        $.cookie('cursor-negro-grande','no',  {expires: 7, path: '/'});
        $("body").removeClass("cursor-negro-grande");
    }
});
$(".btn-restablecer-ajustes").click(function () {
   
        // Set cookie value to yes
        $.cookie('highcontrast','no', {expires: 7, path: '/'});
        $.cookie('invertcolors','no',  {expires: 7, path: '/'});
        $.cookie('enfatizar','no',  {expires: 7, path: '/'});
        $.cookie('legible','no',  {expires: 7, path: '/'});
        $.cookie('subrayar','no',  {expires: 7, path: '/'});
        $.cookie('monocromo','no',  {expires: 7, path: '/'});
        $.cookie('contraste-oscuro','no',  {expires: 7, path: '/'});
        $.cookie('contraste-LUZ','no',  {expires: 7, path: '/'});
        $.cookie('cursor-blanco-grande','no',  {expires: 7, path: '/'});
        $.cookie('cursor-negro-grande','no',  {expires: 7, path: '/'});
        $.cookie('enfatizar-al-pasar-cursor','no',  {expires: 7, path: '/'});
        // Add the class to the body
        $("body").removeClass("highcontrast");
        $("body").removeClass("invertcolors");
        $("body").removeClass("enfatizar");                  
        $("body").removeClass("monocromo");
        $("body").removeClass("contraste-oscuro");
        $("body").removeClass("contraste-luz");
        $("body").removeClass("cursor-blanco-grande");
        $("body").removeClass("cursor-negro-grande");  
        $("body").removeClass("enfatizar-al-pasar-cursor");
        $("body").removeClass("legible");  
        $("body").removeClass("subrayar"); 
    
    // If the cookie was already set to yes then remove it
});
$(".enfatizar-al-pasar-cursor").click(function () {
    console.log("Bien");
        // Set cookie value to yes
    if ($.cookie('enfatizar-al-pasar-cursor') == "undefined" || $.cookie('enfatizar-al-pasar-cursor') == "no") {
        $.cookie('highcontrast','no', {expires: 7, path: '/'});
        $.cookie('invertcolors','no',  {expires: 7, path: '/'});
        $.cookie('enfatizar','no',  {expires: 7, path: '/'});
        $.cookie('legible','no',  {expires: 7, path: '/'});
        $.cookie('subrayar','no',  {expires: 7, path: '/'});
        $.cookie('monocromo','no',  {expires: 7, path: '/'});
        $.cookie('contraste-oscuro','no',  {expires: 7, path: '/'});
        $.cookie('contraste-LUZ','no',  {expires: 7, path: '/'});
        $.cookie('cursor-blanco-grande','no',  {expires: 7, path: '/'});
        $.cookie('cursor-negro-grande','no',  {expires: 7, path: '/'});
        $.cookie('enfatizar-al-pasar-cursor','yes',  {expires: 7, path: '/'});
        // Add the class to the body
        $("body").removeClass("highcontrast");
        $("body").removeClass("invertcolors");
        $("body").removeClass("enfatizar");                  
        $("body").removeClass("monocromo");
        $("body").removeClass("contraste-oscuro");
        $("body").removeClass("contraste-luz");
        $("body").removeClass("cursor-blanco-grande");
        $("body").removeClass("cursor-negro-grande");  
        $("body").addClass("enfatizar-al-pasar-cursor");
        $("body").removeClass("legible");  
        $("body").removeClass("subrayar"); 
    }
    // If the cookie was already set to yes then remove it
    else {
        $.cookie('enfatizar-al-pasar-cursor','no',  {expires: 7, path: '/'});
        $("body").removeClass("enfatizar-al-pasar-cursor");
    }
    
    // If the cookie was already set to yes then remove it
    
});
 //Side navbar
    
        //Abrir el navbar de herramientas de acceseibilidad
        document.getElementById("accesibility-content").addEventListener("click", openTool, true);
        function openTool(){
            
        document.getElementById("myToolbar").style.display = "block";
        document.getElementById("accesibility-content").style.display = "none";
        document.getElementById("closeTool").focus();

        }
        //Cerrar navbar de herramientas de accesibilidad
        document.getElementById("closeTool").addEventListener("click", closeTool, true);
        function closeTool(){
            //Cerrar herramientas de accesibilidad
            document.getElementById("myToolbar").style.display = "none";
            //mostrar boton accesibilidad
            document.getElementById("accesibility-content").style.display = "block";
            document.getElementById("accesibility-content").focus();
        };

        //Focus a detalle de tramite
        
        





        
        


  


 

