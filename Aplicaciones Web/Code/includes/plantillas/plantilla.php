<?php
   namespace aw\proyecto\clases;
    
/* ?>
<!-- 
<!DOCTYPE html>
<html>
<head> -->
	<!-- <?php --> */
	
//importante: ../ sirve para acceder al dir padre.
//si se ponen los requiere o los href sin nada, van al dir base del proyecto

//css por defecto que usan todas las paginas
function cargarEstilos()
{
	global $listaCSS;
	$listaCSS["navbar"] = "navbar.css";
	$listaCSS["comun"] = "comun.css";
	foreach($listaCSS as $css)
	{
		echo "<link rel=\"stylesheet\" href=\"css/$css\">";
	}
}
	 


	?>
		<!-- <link rel="stylesheet" href="../comun.css">
        <link rel="stylesheet" href="../navbar.css">
        <link rel="stylesheet" href="../carta.css"> -->
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
    <title><?= $tituloPagina ?></title>
	<?php 
	cargarEstilos();
	?>
	
</head>
<!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> -->


<body>

<div id="contenedor">

<?php
	$navBar;
	 require('includes/comun/navBar.php');
	 $contenidoPrincipal = $navBar.$contenidoPrincipal;
?>
	<main>
		<article>
			<?= $contenidoPrincipal ?>
		</article>
	</main>
</div>

</body>
</html>