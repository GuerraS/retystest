<script type="text/javascript">
	var BaseUrl='<?php echo base_url();?>';
	var SiteUrl='<?php echo site_url();?>';
</script>
<link rel="stylesheet" media="all" href="<?php echo base_url('assets/css/application.css');?>" data-turbolinks-track="true" />
<!--<script src="https://www.gob.mx/assets/application.js"></script>-->
<script src="<?php echo base_url('assets/js/categoria.js');?>"></script>
<script src="https://www.gob.mx/assets/scrollft.js"></script>

<style type="text/css">
	.Tramite{
		font-size: 18px;
	    font-weight: bold;
	    letter-spacing: 0px;
	    color: #ffffff;
	    margin-top: 8px;
	}
	.subcategory h4{
		color: white;
	}
</style>
<main class="inner-page interior ficha">
<div class="container" id="sec_atencion"><br><br>
	<div class="hidden-xs font-changer internal print">
      <button class="inc-font font-modifier">Aa+</button>
      <button class="dec-font font-modifier">Aa-</button>
    </div>
	<div class="row texto-blanco-pu">
		<h1>Trámites</h1>
		<div class="col-12 separador-secciones-dark-2-pu"></div>
		<span class="col-1 separador-secciones-dark-1-pu"></span>
	</div>
	<br><br>
	<div class="row">
		<div class="col-12 text-justify">
			<p>El Registro Estatal de Trámites y Servicios (RETyS) es 
			el sistema electrónico que contiene la información de los 
			trámites y servicios de las dependencias y entidades de la 
			administración pública estatal. Las dependencias no podrán 
			aplicar trámites o servicios adicionales a los establecidos 
			en este registro, ni podrán exigir requisitos adicionales en 
			forma distinta a como se inscriben. La legalidad y el contenido 
			de la información que inscriben las dependencias en el registro 
			son de su estricta responsabilidad.</p>
		</div>
	</div>
	<div class="row">
		<div class="col-6 text-justify">		
			¿Tienes alguna duda con un servicio en línea?<br>
			<span class="fa fa-envelope" style="color:#f68d91;">&nbsp;
			<!-- </span><span><b> tramitesenlinea@gobiernocolima.gob.mx</b></span><br> -->
			</span><span><b> tramitesenlineacolima@gmail.com</b></span><br>
			<!-- <span>(312) 31 6 20 58, <br>(312) 31 6 20 96 y <br> (312) 31 6 20 00 ext. 2370</span> -->
			<span class="fa fa-phone" style="color:#f68d91;">&nbsp;</span>
			<span>(312) 31 6 20 00 ext. 20314<br></span>
			<span class="fa fa-phone" style="color:#f68d91;">&nbsp;</span>
			<span>(312) 31 6 20 00 ext. 20313 <br></span>
			<span class="fa fa-phone" style="color:#f68d91;">&nbsp;</span>
			<span>(312) 31 6 20 00 ext. 20312</span>
		</div>
		<div class="col-6" style="text-align: center">		
			<a href="http://sefome.ddns.net:8080/Gobmx/buzon.do" target="_blank"> <img src="<?php echo base_url("assets/img/mejoraregulatoria.jpg"); ?>" style="width:80%;"></a>
		</div>	
	</div>
	<br><br>
	<div class="row">
		<div class="col-md-1 d-none d-lg-block"></div>
		<div class="col-md-4 col-6 no-padding-left-right" style="padding-right: 3px;">
			<a href="javascript:TipoTramite(1);">
				<div id="BGL1" class="Fill-3">
					<div id="BGL2" class="col-2 Fill-4">
						<span class="fa fa-exchange Icon fa-2x"></span>
					</div>
					<div class="col-10 text-center padding-top-10">
						<span class="Tramite"><?php echo $EnLinea_Tramites_Count->Tramites;?> Trámites y servicios en línea</span>
					</div>
				</div>
			</a>
		</div>
		<div class="col-md-2 d-none d-lg-block"></div>
		<div class="col-md-4 col-6 no-padding-left-right">
			<a href="javascript:TipoTramite(2);">
				<div id="BGP1" class="Fill-3">
					<div id="BGP2" class="col-2 Fill-4">
						<span class="fa fa-pencil Icon fa-2x"></span>
					</div>
					<div class="col-10 text-center padding-top-10">
						<span class="Tramite"><?php echo $Retys_Total_Tramites->Tramites;?> Trámites presenciales</span>
					</div>
				</div>
			</a>
		</div>
		<div class="col-1"></div>
	</div>
	<br><br>
<?php
$this->load->view("tramites_en_linea");

$this->load->view("tramites_presencial");
?>



	<div id="resultadoBusqueda">
		<h3 style="margin-bottom: 40px;"></h3>

		<table class='table table-striped' id="table-tramites">
		  <thead>
		    <tr>
		      <th>#</th>
		      <th>Trámites</th>
		      <th>--</th>
		    </tr>
		  </thead>
		  <tbody>

		  </tbody>
		</table>
		<div id="cutomDivmsg" class="msg-busqueda-tramite alert" role="alert"></div>

	</div>
  </div>
</div>
<form name="formTramiteRetys" id="formTramiteRetys" method="POST" target="_blank"></form>
</main>
<script type="text/javascript">

	$(function() {
		TipoTramite(1);
	 	TramitesLinea(1);
	});

	function TipoTramite(Id){
		$.ajax({
			dataType:'json',
		  	url: SiteUrl+"/Portal/CargaToken"
		}).done(function(response) {
			var Hash=response.CSRF_Hash;
			$("#frmBusquedaRetys #"+response.CSRF_Name).val(Hash);
		});

		if(parseInt(Id)==1){
			$("#TramitePresencial").hide();
			$("#TramiteEnLinea").show();

			$("#ContentTramiteEnLinea").show();
			$("#resultadoBusqueda").hide();
			$("#BGP1").removeClass("Fill-1");
			$("#BGP2").removeClass("Fill-2");
			$("#BGP1").addClass("Fill-3");
			$("#BGP2").addClass("Fill-4");

			$("#BGL1").removeClass("Fill-3");
			$("#BGL2").removeClass("Fill-4");
			$("#BGL1").addClass("Fill-1");
			$("#BGL2").addClass("Fill-2");
		}else{
			$("#TramiteEnLinea").hide();
			$("#TramitePresencial").show();
			$("#ContentTramitePresencial").show();
			$("#resultadoBusqueda").hide();

			$("#BGP1").removeClass("Fill-3");
			$("#BGP2").removeClass("Fill-4");
			$("#BGP1").addClass("Fill-1");
			$("#BGP2").addClass("Fill-2");

			$("#BGL1").removeClass("Fill-1");
			$("#BGL2").removeClass("Fill-2");
			$("#BGL1").addClass("Fill-3");
			$("#BGL2").addClass("Fill-4");
		}
	}

    function IrArriba(){
//        $('html,body').animate({
//            scrollTop: $("#BusquedaTramiteEnLinea").offset().top - 120 }, { duration: 'slow', easing: 'swing'
//        });
    }

	function CargaTramites(Id){
		$.ajax({
			dataType:'html',
		  	url: SiteUrl+"/Portal/Categoria/"+Id
		}).done(function(html) {

            $('html,body').animate({
                scrollTop: ($("#BusquedaTramiteEnLinea").offset().top - 120) }, { duration: 'slow', easing: 'swing'
            });

			$("#pane li").removeClass("active");
			$("#pane2").html(html);
			$("#P1_"+Id).addClass("active");
			$("#pane3").html('');
		});
	}

	function CargaTramitesDependencia(Id){
		$.ajax({
			dataType:'html',
		  	url: SiteUrl+"/Portal/TramitesDependencia/"+Id
		}).done(function(html) {

			$('html,body').animate({
                scrollTop: ($("#BusquedaTramiteEnLinea").offset().top - 120) }, { duration: 'slow', easing: 'swing'
            });

			$("#pane3").html('');
			$("#pane6").html('');
			$("#pane4 li").removeClass("active");
			$("#pane5").html(html);
			$("#PD1_"+Id).addClass("active");
		});
	}

	function CargaTramite(Id,Div){
		$.ajax({
			dataType:'html',
		  	url: SiteUrl+"/Portal/CargaTramite/"+Id
		}).done(function(html) {
			$('html,body').animate({
                scrollTop: ($("#BusquedaTramiteEnLinea").offset().top - 120) }, { duration: 'slow', easing: 'swing'
            });

			switch(Div){
				case 'pane3':
					$("#pane2 li").removeClass("active");
					
					$("#P2_"+Id).addClass("active");
					$("#PR2_"+Id).addClass("active");

					$("#pane3 h3").addClass("Title");
					$("#pane3 p").addClass("Texto");
					break;
				case 'pane6':
					$("#pane5 li").removeClass("active");
					$("#pane6").html(html);

					$("#PD2_"+Id).addClass("active");

					$("#pane6 h3").addClass("Title");
					$("#pane6 p").addClass("Texto");
					break;
			}

		});
	}	
</script>