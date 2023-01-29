<?php
namespace aw\proyecto\clases;
require_once __DIR__.'/includes/config.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];

}else{
    $id = $_POST['id'];
}

$reserva= Reserva::buscarReserva($id);
$contenido = modificarReservaForm($reserva);
function modificarReservaForm($reserva) {
   
    $datosIniciales = array();
    $datosIniciales["fecha"] = $reserva->getDia();
    $datosIniciales["hora"] = $reserva->getHora();
    $datosIniciales["nPersonas"] = $reserva->getNPersonas();
    $datosIniciales["id"] = $reserva->getId();
    $datosIniciales["idUsuario"] = $reserva->getIdUsusario();
    $contenidoModal = "";
    $contenidoModal .= '<p class="formTitle">Modificar reserva</p>';
   
    $form = new FormularioModificarReserva($reserva->getId());
    $contenidoModal .= <<<EOF
    {$form->gestiona($datosIniciales)}
    EOF;
  
    return $contenidoModal;
}
echo $contenido;
//http_response_code(200);
//echo "aqui en procesar hacer pedido";
//header('Location: '.'index.php');
    

?>