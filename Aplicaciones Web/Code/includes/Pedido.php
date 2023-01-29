<?php
namespace aw\proyecto\clases;

class Pedido
{
    private $id;
    private $fecha;
    private $id_usuario;
    private $direccion;
    private $estado;

    private const listaEstados = array('procesando','preparando','reparto','entregado');

    private $listaPlatos = array();

    private function __construct( $id, $fecha, $id_usuario, $direccion, $estado)
    {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->id_usuario = $id_usuario;
        $this->direccion = $direccion;
        $this->estado = $estado;
    }

    public static function listaPedidosActivos($idUs)
    {
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
        $listaPedidos = array();
        
        $rol=$_SESSION['rol'];
        $id_usuario=$_SESSION['idUsuario'];
        if($rol==='Administrador'||$rol==='Empleado'||$rol==='Propietario'){
            $da=date('y/m/d');
            $query = sprintf("SELECT * FROM pedidos P WHERE CAST(fecha AS Date) >='$da' ORDER BY fecha");
            $rs = $conn->query($query);
            if ($rs) {
                while($row = mysqli_fetch_assoc($rs)){
                  
                  $query = sprintf("SELECT * FROM usuarios  WHERE id LIKE '{$row['id_usuario']}'");
                  $rsa= $conn->query($query);
                  $us = mysqli_fetch_assoc($rsa);
                  $d=date('G:i, d/m/y', strtotime($row['fecha']));
                  $listaPedidos[]=new Pedido($row['id'], $row['fecha'], $row['id_usuario'], $row['direccion'], $row['estado']);
                }
                $rs->free();
            } else {
                echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                exit();
            }
        }else{            
            
            $da=date('y/m/d');
            $query = sprintf("SELECT * FROM pedidos P WHERE P.id_usuario = '%s'AND CAST(fecha AS Date) >='$da' ORDER BY fecha", $conn->real_escape_string($id_usuario));
            $rs = $conn->query($query);
            if ($rs) {
                
                while($row = mysqli_fetch_assoc($rs)) {
                  $d=date('y/m/d', strtotime($row['fecha']));
                  $listaPedidos[]=new Pedido($row['id'], $row['fecha'], $row['id_usuario'], $row['direccion'], $row['estado']);
                }
                $rs->free();
            } else {
                echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                exit();
            }
        }
        return $listaPedidos;
    }

    public static function listaPedidosAntiguos($idUs)
    {
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
        $listaPedidos = array();
        
        $rol=$_SESSION['rol'];
        $id_usuario=$_SESSION['idUsuario'];
        if($rol==='Administrador'||$rol==='Empleado'||$rol==='Propietario'){
            $da=date('y/m/d');
            $query = sprintf("SELECT * FROM pedidos P WHERE CAST(fecha AS Date) <'$da' ORDER BY fecha");
            $rs = $conn->query($query);
            if ($rs) {
                while($row = mysqli_fetch_assoc($rs)){
                  
                  $query = sprintf("SELECT * FROM usuarios  WHERE id LIKE '{$row['id_usuario']}'");
                  $rsa= $conn->query($query);
                  $us = mysqli_fetch_assoc($rsa);
                  $d=date('G:i, d/m/y', strtotime($row['fecha']));
                  $listaPedidos[]=new Pedido($row['id'], $row['fecha'], $row['id_usuario'], $row['direccion'], $row['estado']);
                }
                $rs->free();
            } else {
                echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                exit();
            }
        }else{            
            
            $da=date('y/m/d');
            $query = sprintf("SELECT * FROM pedidos P WHERE P.id_usuario = '%s'AND CAST(fecha AS Date) <'$da' ORDER BY fecha", $conn->real_escape_string($id_usuario));
            $rs = $conn->query($query);
            if ($rs) {
                
                while($row = mysqli_fetch_assoc($rs)) {
                  $d=date('y/m/d', strtotime($row['fecha']));
                  $listaPedidos[]=new Pedido($row['id'], $row['fecha'], $row['id_usuario'], $row['direccion'], $row['estado']);
                }
                $rs->free();
            } else {
                echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                exit();
            }
        }
        return $listaPedidos;
    }

    public static function borrarPedido($idR){

        if (!$idR) {
            return false;
        } 
 
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
        $query = sprintf("DELETE FROM pedidos WHERE id = %d", $idR);

        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }


    public static function nuevoPedido($id, $id_usuario, $direccion, $estado, $listaPlatos)
    {
        $daTime=date("Y-m-d H:i", time());
        
         $pedido = new Pedido(null, $daTime, $id_usuario, $direccion, $estado);
 
         $pedido->setPlatos($listaPlatos);

         $app = Aplicacion::getInstancia();
         $conn = $app->conexionBd();
         
         $query=sprintf("INSERT INTO pedidos(fecha, id_usuario, direccion, estado) VALUES('%s', '%s', '%s', '%s')"
           , $conn->real_escape_string($pedido->fecha)
           , $conn->real_escape_string($pedido->id_usuario)
           , $conn->real_escape_string($pedido->direccion)
           , $conn->real_escape_string($pedido->estado));
         if ( $conn->query($query) ) {
           $pedido->id = $conn->insert_id;
        } else {
           echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
           exit();
        }

       
        foreach($pedido->getPlatos() as $idPlato => $num)
        {
            $query2=sprintf("INSERT INTO platospedido(id_pedido, id_plato, num) VALUES('%s', '%s', '%d')"
            , $conn->real_escape_string($pedido->id)
            , $conn->real_escape_string($idPlato)
            , $conn->real_escape_string($num)
            );
            if ( $conn->query($query2) ) {
                $lineaId = $conn->insert_id;
            } else {
                echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                exit();
            }
        }
       return $pedido;
 
       }

 public static function modificarEstado($idPedido, $estado){

    $app = Aplicacion::getInstancia();
    $conn = $app->conexionBd();
    $query=sprintf("UPDATE pedidos P SET estado = '%s' WHERE P.id=%d"
        , $conn->real_escape_string($estado)
        , $idPedido);
    if ( $conn->query($query) ) {
        if ( $conn->affected_rows != 1) {
            echo "No se ha podido actualizar el pedido";
            return false;
        }

    } else {
        echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
        return false;
    }

    return true;
 }

    public function getId()
    {
        return $this->id;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getIdUsusario()
    {
        return $this->id_usuario;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setPlatos($listaPlatos)
    {
        $this->listaPlatos = $listaPlatos;
    }

    public function getPlatos()
    {
        return $this->listaPlatos;
    }

    public static function getListaEstados()
    {
        return self::listaEstados;
    }

    public static function getListaEstadosInvertida()
    {
        return array_reverse(self::listaEstados);
    }
}
?>