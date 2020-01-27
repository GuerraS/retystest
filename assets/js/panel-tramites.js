const baseUrl = window.location.href;
const siteUrl = `${baseUrl}index.php`;
//Mostrar los botones de tramites en linea

document.getElementById("tramiteLinea").addEventListener("click",MostrarCategoriaDependenciasLiea,true);
function MostrarCategoriaDependenciasLiea(){

    document.getElementById("categoria-dependencia-Linea").style.display="flex";
    document.getElementById("tramites_y_servicios_en_linea").style.display="flex";
    document.getElementById("categoria-dependencia-presencial").style.display="none";
    document.getElementById("tramites_y_servicios_presenciales").style.display="none";
    document.getElementById("panel-tramites-categoria-dependencia-linea").style.display="flex";
    document.getElementById("panel-tramite-presencial").style.display="none";  
    document.getElementById("buesquedaRety").style.display="none";
    document.getElementById("tramites_y_servicios_en_linea").focus();
    
};
//Mostrar tramites en linea por categoria
document.getElementById("categoria-linea").addEventListener("click",MostrarTramitesCategoria,true);
function MostrarTramitesCategoria(){
    var elemento = document.getElementById("categoria-linea");
    elemento.classList.add('activo');
    var elemento = document.getElementById("dependencia-linea");
    elemento.classList.remove('activo');  
    document.getElementById("panel-tramite-linea").style.display="flex";
    document.getElementById("panel-tramite-dependencia").style.display="none";
    $(".info-tramite-dependencia").empty();  
};
//Mostrar tramites en linea por dependencia
document.getElementById("dependencia-linea").addEventListener("click",MostrarTramitesDependencia,true);
function MostrarTramitesDependencia(){
    var elemento = document.getElementById("dependencia-linea");
    elemento.classList.add('activo');
    var elemento = document.getElementById("categoria-linea");
    elemento.classList.remove('activo');
    document.getElementById("panel-tramite-linea").style.display="none";
    document.getElementById("panel-tramite-dependencia").style.display="flex";
    $(".info-tramite-categoria").empty();
};
document.getElementById("tipo-usuario-presencial").addEventListener("click",MostrarTramitesTipoUsuario,true);
function MostrarTramitesTipoUsuario(){
    var elemento = document.getElementById("dependencia-presencial");
    elemento.classList.remove('activo');
    var elemento = document.getElementById("categoria-presencial");
    elemento.classList.remove('activo');
    var elemento = document.getElementById("tipo-usuario-presencial");
    elemento.classList.add('activo');
    document.getElementById("panel-tramite-linea").style.display="none";
    document.getElementById("panel-tramites-categoria-dependencia-presencial").style.display="flex";
    document.getElementById("panel-busquedaRetys").style.display="none";
    document.getElementById("panel-tramite-presencial").style.display="flex";
    $(".info-tramite-presencial").empty();
    
};

function CargaTramite(id_tramite,div){
    var id_tramite;
    var div;
    $.ajax({
        method:'get',
        url: 'index.php/prueba/getTramitesLineaId',
        data:{id_tramite:id_tramite},
        dataType: 'json',
        success: function(success){
            if(div==1){
               var panel="info-tramite-categoria";     
            }else{
               var panel="info-tramite-dependencia"
            }
            var html='';
            if(success.length==3){
                html +='<div >'+
              
                                    '<h4 id="detalles" tabindex="0">'+success[0].nombre+'</h4>'+
                                    '<br>'+
                                    '<br>'+
                                    '<span tabindex="0">'+success[0].descripcion+'</span>'+
                                    '<div class="subcategory">'+
                                        '<a href="'+success[1]+'" target="_blank">'+
                                        '<div class="btn btn-default custom-buttom-noticias col-12 col-sm-12 col-md-6 col-lg-6 cursor ">'+"Ir a Trámite"+'</div>'+
                                        '</a>'+
                                        '<a href="'+success[2]+'" target="_blank">'+
                                        '<div class="btn btn-default custom-buttom-noticias col-12 col-sm-12 col-md-6 col-lg-6 cursor ">'+"Ver más"+'</div>'+
                                        '</a>'+
                                    '</div>'+             		
                    '</div>';
                    
					$("."+panel).html(html);
               
            }else{
                html +='<div >'+
                                    '<h4>'+success[0].nombre+'</h4>'+
                                    '<br>'+
                                    '<br>'+
                                    '<span>'+success[0].descripcion+'</span>'+
                                    '<div class="subcategory">'+
                                        '<a href="'+success[0].url_tramite+'" target="_blank">'+
                                        '<div class="btn btn-default custom-buttom-noticias col-12 col-sm-12 col-md-6 col-lg-6 cursor ">'+"Ir a Trámite"+'</div>'+
                                        '</a>'+                                    
                                    '</div>'+           		
                    '</div>';
                    $("."+panel).html(html);
                   
                      
                     
            }   
            $("#detalles").focus();
        },
        error: function(data){    
        }
    });
}
//Mostrar los botones de tramites presenciales
document.getElementById("tramitePresencial").addEventListener("click",MostrarCategoriaDependenciasPresencial,true);
function MostrarCategoriaDependenciasPresencial(){
    document.getElementById("categoria-dependencia-presencial").style.display="flex";
    document.getElementById("tramites_y_servicios_presenciales").style.display="flex";
    document.getElementById("categoria-dependencia-Linea").style.display="none";
    document.getElementById("tramites_y_servicios_en_linea").style.display="none";
    document.getElementById("panel-tramites-categoria-dependencia-linea").style.display="none";
    document.getElementById("panel-tramites-categoria-dependencia-presencial").style.display="flex";
    document.getElementById("panel-tramite-presencial").style.display="flex";
    document.getElementById("tramites_y_servicios_presenciales").focus();
};
document.getElementById("categoria-presencial").addEventListener("click",MostrarCategoriasPresencial,true);
function MostrarCategoriasPresencial(){
    var elemento = document.getElementById("categoria-presencial");
    elemento.classList.add('activo');
    var elemento = document.getElementById("dependencia-presencial");
    elemento.classList.remove('activo');
    var elemento = document.getElementById("tipo-usuario-presencial");
    elemento.classList.remove('activo');
    document.getElementById("panel-tramite-presencial").style.display="flex";
    document.getElementById("panel-tramites-categoria-dependencia-presencial").style.display="flex";
    document.getElementById("panel-busquedaRetys").style.display="none";
    $(".info-tramite-presencial").empty();
}
document.getElementById("dependencia-presencial").addEventListener("click",MostrarDependenciaPresencial,true);
function MostrarDependenciaPresencial(){
    var elemento = document.getElementById("categoria-presencial");
    elemento.classList.remove('activo');
    var elemento = document.getElementById("dependencia-presencial");
    elemento.classList.add('activo');
    var elemento = document.getElementById("tipo-usuario-presencial");
    elemento.classList.remove('activo');
    document.getElementById("panel-tramite-presencial").style.display="flex";
    
    document.getElementById("panel-tramites-categoria-dependencia-presencial").style.display="flex";
    document.getElementById("panel-busquedaRetys").style.display="none";
    $(".info-tramite-presencial").empty();
}
//
function MostrarTramitesPresenciales(div){
    switch(div){
        case 3:
        var tipo_tramite="Dependencia"
        var url='index.php/prueba/getTramitesDependenciaPresencial'
        var coll=3;
        break;
        case 4:
        var tipo_tramite="Categoría"
        var url='index.php/prueba/getTramitesCategoriaPresencial'
        var coll=4;
        break;
        case 5:
        var tipo_tramite="Tipo de usuario"
        var url='index.php/prueba/getTramitesTipoUsuarioPresencial'
        var coll=5;
        break;
    }   
    $.ajax({
        method:'get',
        url: url,
        dataType: 'json',
        success: function(success){  
            var html='';       
            for(var i=0; i<success.length;i++){ 
                html +=
                        '<div class="card-header">'+
                            '<h5 class="panel-title">'+
                                '<a  data-toggle="collapse" title="'+tipo_tramite+''+success[i].descripcion+' "aria-label="'+tipo_tramite+''+success[i].descripcion+'"data-parent="#accordion" aria-expanded="true" href="#collapse_p'+coll+success[i].Id_Ads+'"><p>'+success[i].descripcion+'</p></a>'+
                            '</h5>'+
                        '</div>'+
                        '<div id="collapse_p'+coll+success[i].Id_Ads+'" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">';
                            for(var j=0; j<success[i].tramites.length;j++){
                                html +=
                                '<div class="col-12 card-body"  role="button">';
                                if(div==3){
                                html += '<a class="tramite-liga" href="javascript:CargaTramiteRetys('+success[i].tramites[j].id_tramite+');">'+
                                                '<div class="col-11">'+
                                                    '<span>'+success[i].tramites[j].nombre+
                                                    '</span>'+
                                                '</div>'+
                                                '<div class="col-1 arrow">'+
                                                    '<span class="fa fa-chevron-right"></span>'+
                                                '</div>'+
                                            '</a>'+
                                '</div>';
                            }else{
                                html += '<a class="tramite-liga liga_presencial" href="javascript:CargaTramiteRetys('+success[i].tramites[j].Id_Tramite+');">'+
                                                '<div class="col-11">'+
                                                    '<span>'+success[i].tramites[j].Nombre+
                                                    '</span>'+
                                                '</div>'+
                                                '<div class="col-1 arrow">'+
                                                    '<span class="fa fa-chevron-right"></span>'+
                                                '</div>'+
                                            '</a>'+
                                '</div>';
                            }
                            }
                html +=
                        '</div>';  
            }         
            $("#card3").html(html); 
            $(".liga_presencial").click(function (){
                $('html, body').animate({
                    scrollTop: $(".categoria-dependencia-presencial").offset().top
                }, 1500);
            });   
        },
        error: function(data){
        }
    });
}
function CargaTramiteRetys(id_tramite){
    var id_tramite;  
    $.ajax({
        method:'get',
        url: 'index.php/prueba/getTramiteRetysId',
        data:{id_tramite:id_tramite},
        dataType: 'json',
        success: function(success){
            var html='';
            if(success.length==4){
                html +=
                '<div >'+
                    '<h4 id="detalles2" tabindex="0">'+success[0]+'</h4>'+
                            '<br>'+
                            '<br>'+
                            '<span tabindex="0">'+success[1]+'</span>'+
                    '<div class="subcategory">'+
                        '<a href="'+success[2]+'" target="_blank">'+
                            '<div class="btn btn-default custom-buttom-noticias col-12 col-sm-12 col-md-6 col-lg-6 cursor ">'+"Ver más información"+'</div>'+
                        '</a>'+
                        '<div class="col-12 " >'+
                            '<a  class="aviso"href="http://www.tramitesyservicios.col.gob.mx/formatos/'+success[3]+'" target="_blank">'+
                            "Política de privacidad y manejo de datos&nbsp"+'</a>'+
                        '</div>'+
                    '</div>'+             		
                '</div>';
					$(".info-tramite-presencial").html(html);
            }else{
                html +=
                '<div >'+
                    '<h4>'+success[0]+'</h4>'+
                            '<br>'+
                            '<br>'+
                            '<span>'+success[1]+'</span>'+
                    '<div class="subcategory">'+
                        '<a href="'+success[2]+'"target="_blank">'+
                            '<div class="btn btn-default custom-buttom-noticias col-12 col-sm-12 col-md-6 col-lg-6 cursor ">'+"Ver más"+'</div>'+
                        '</a>'+
                    '</div>'+             		
                '</div>'; 
               
                    $(".info-tramite-presencial").html(html);     
            } 
            $("#detalles2").focus();
             
        },
        error: function(data){    
        }
    });
}
function check_param() {
    var pattern = /^[a-zA-Z Ñ-ñ.áéíóúäëïöü\'-]+$/;
    var param = $("#busqueda").val();
    if((pattern.test(param) && param.length>=3)){
        return error_param = true;
    }else{
        return error_param = false;
    }
}
document.getElementById("boton-busqueda").addEventListener("click",MostrarBusquedaPresencial,true);
function MostrarBusquedaPresencial(){
    var elemento = document.getElementById("categoria-presencial");
    elemento.classList.remove('activo');
    var elemento = document.getElementById("dependencia-presencial");
    elemento.classList.remove('activo');
    var elemento = document.getElementById("tipo-usuario-presencial");
    elemento.classList.remove('activo');
    document.getElementById("panel-tramite-presencial").style.display="none";
    document.getElementById("panel-tramites-categoria-dependencia-presencial").style.display="none";
    document.getElementById("buesquedaRety").style.display="flex";
    document.getElementById("panel-busquedaRetys").style.display="flex";
    check_param();
    var param = $("#busqueda").val();
    if(error_param===true){
        $.ajax({
            method:'get',
            url: 'index.php/prueba/busquedaTramitesGeneralesRetys',
            data:{param:param},
            dataType: 'json',
            success: function(success){
                console.log(success);
                var html='';
                html +=
                        '<table class="table table-striped table-bordered">'+
                        '<tr>'+
                                '<th>'+"#"+'</th>'+
                                '<th>'+"Trámites"+'</th>'+ 
                                '<th>'+"--"+'</th>';
                    for(var i=0; i<success.length; i++){
                        j=i+1;
                        html += 
                            '</tr>'+
                            '<tr>'+
                                '<td>'+j+'</td>'+
                                '<td>'+
                                    '<a target="_blank" class="links_busqueda" href="http://www.col.gob.mx/Portal/DetalleTramiteReTYS/'+success[i].id+'">'+success[i].nombre+'</a>'+
                                '</td>'+
                                '<td>'+
                                '<a target="_blank" class="links_busqueda" href="http://www.col.gob.mx/Portal/DetalleTramiteReTYS/'+success[i].id+'">'+
                                    '<i class="fa fa-external-link titlu-rojo-pu"></i>'+
                                '</a>'+
                                '</td>'+
                            '</tr>';
                    }
                    html +=  '</table>';
                            $("#table").html(html);
            },
            error: function(data){    
            }
        }); 
        

    }
    
    
}
//Busuqeda de trámites presenciales

    

