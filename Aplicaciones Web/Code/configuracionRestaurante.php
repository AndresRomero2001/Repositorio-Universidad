<?php
namespace aw\proyecto\clases;
require_once __DIR__.'/includes/config.php';
GestionPermisos::validar(array("Administrador", "Propietario"));



if(isset($_POST["borrarHora"]))
{
Reserva::BorrarHoraId($_POST["borrarHora"]);
} 

if(isset($_POST["borrarEmpleado"]))
{
    Usuario::borraPorId($_POST["borrarEmpleado"]);
} 

if(isset($_POST["nuevaHora"]))
{
    $res = Reserva::definirNuevaHora($_POST["nuevaHora"]);
}

$errorCategoria = "";
if(isset($_POST['categoria'])) {
    if(!Categoria::insertarCategoria($_POST['categoria'])) $errorCategoria = "<span id=\"errorCat\">⚠️ La categoría ya existe</span>";
}

$tituloPagina = 'Configuración';
$listaCSS["confRes"] = "configuracionRestaurante.css";
$contenidoPrincipal = "";

$form = new FormularioDatosRest();

//datos por defecto del formulario
$app = Aplicacion::getInstancia();
$conn = $app->conexionBd();
$query=sprintf("SELECT * FROM restaurante");
$fila = $conn->query($query);
$datos = mysqli_fetch_assoc($fila);
$personas = array();
$personas["maxPers"] = $datos["capacidad"];


$contenidoPrincipal .= <<<EOF
<div class="centeredDivMedium">
    <h1 class="centeredText">Configuración</h1>
    <a href="#formAnadirCat" id="linkFormAnadirCat">Añadir categoría</a>
    {$form->gestiona($personas)}
    <div class='verticalSpacerDiv-S'> </div>
    <div> Horas en las que se podrán hacer reservas: </div>
    <div class='verticalSpacerDiv-S'> </div>
EOF;

$horasR=Reserva::horasReserva();
                           
    foreach ($horasR as $id => &$horaR){
        $contenidoPrincipal .= <<<EOF
        <div class ='hora inlineBlockDiv'> $horaR
                <form class= 'inlineBlockDiv' action ='configuracionRestaurante.php?page=configuracionRestaurante' method='post'>
                    <button class='botonBorrar' name ='borrarHora' value="$id"> ❌ </button> 
                </form>
        </div>
        
EOF;
    }

$contenidoPrincipal .= <<<EOF
<div> Definir nueva hora: 
    <form action='configuracionRestaurante.php?page=configuracionRestaurante' method='post'>
        <input type='time' name ='nuevaHora' required>
        <button class="botonesFormConfRes" type='submit'> Confirmar </button>
    </form>
</div>
EOF;

//Lista empleados ->

$contenidoPrincipal .= <<<EOF
<div class='verticalSpacerDiv-M'> </div>
    <div class="tituEmp">
        <h3> Lista de empleados: </h3> 
            <button id="abrirModalButton" class="modalButton">Añadir empleado</button>
    </div>
    
EOF;

$listaEmpleados=Usuario::listaEmpleados();
                           
    foreach ($listaEmpleados as $id => &$empleado){

        $nombre=$empleado->getNombre();
        $email = $empleado->getEmail();
        $direccion = $empleado->getDir();
        $telefono = $empleado->getTel();


        $contenidoPrincipal .= <<<EOF
        <hr class='barraSeparacion'>
        <div> 
            <h4> $nombre </h4>
            <p>Email: $email </p>
            <p>Direccion: $direccion </p>
            <p>Telefono: $telefono </p>
            <form class= 'inlineBlockDiv' action ='configuracionRestaurante.php?page=configuracionRestaurante' method='post'>
                    <button class='botonBorrar' name ='borrarEmpleado' value="$id"> ❌ Eliminar empleado ❌ </button> 
            </form>
        </div>
    
EOF;
    }


$formNuevoEmp = new FormularioRegistro("Empleado", "configuracionRestaurante.php?page=configuracionRestaurante");

$contenidoPrincipal .= <<<EOF
<div id="anadirEmpleadoModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h1>Añadir empleado</h1>
        {$formNuevoEmp->gestiona()}
    </div>
</div>
EOF;

$listaCat = Categoria::listaCategorias();
$categorias = "<h3>Categorías actuales</h3>";
foreach($listaCat as $cat) {
    $categorias .= <<<EOF
    <p>{$cat->getNombre()}</p>
    EOF;
}

$contenidoPrincipal .= <<<EOF
<div class='verticalSpacerDiv-M'> </div>
<div id="divCategorias"> 
    <hr class='barraSeparacionGris'>
    <h2> Añadir categoría </h2>
    <form action="configuracionRestaurante.php?page=configuracionRestaurante" method="POST" id="formAnadirCat">
    <label for="categoria" id="labelCategoria">Nombre de la categoria $errorCategoria</label>
    <input class="formInput-XS" id="categoria" type="text" name="categoria">
    <button class="botonesFormConfRes" type="submit"> Añadir </button>
    </form>
    $categorias
</div>
EOF;

$contenidoPrincipal .= <<<EOF
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="js/configuracionRestaurante.js"></script>
</div>
EOF;


include __DIR__.'/includes/plantillas/plantilla.php';