<?php
namespace aw\proyecto\clases;

class Reserva
{
    private $id;
    private $id_usuario;
    private $fecha;
    private $nPersonas;

    public function __construct( $id,$id_usuario, $fecha, $nPersonas)
    {
        $this->id = $id;
        $this->id_usuario = $id_usuario;
        $this->fecha = $fecha;
        $this->nPersonas = $nPersonas;
    }


    public static function listaReservas($idUs)
    {
        
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
        $listaReservas = array();
        
        $rol=$_SESSION['rol'];
        $id_usuario=$_SESSION['idUsuario'];
        if($rol==='Administrador'||$rol==='Empleado'||$rol==='Propietario'){
            $da=date('y/m/d');
            $query = sprintf("SELECT * FROM reservas R WHERE CAST(fecha AS Date) >='$da' ORDER BY fecha");
            $rs = $conn->query($query);
            if ($rs) {
                while($row = mysqli_fetch_assoc($rs)){
                  
                  $query = sprintf("SELECT * FROM usuarios  WHERE id LIKE '{$row['id_usuario']}'");
                  $rsa= $conn->query($query);
                  $us = mysqli_fetch_assoc($rsa);
                  $d=date('G:i, d/m/y', strtotime($row['fecha']));
                  $listaReservas[]=new Reserva($row['id'],$row['id_usuario'], $row['fecha'], $row['nPersonas']);
                }
                $rs->free();
            } else {
                echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                exit();
            }
        }else{
            
            
            $da=date('y/m/d');
            $query = sprintf("SELECT * FROM reservas R WHERE R.id_usuario = '%s'AND CAST(fecha AS Date) >='$da' ORDER BY fecha", $conn->real_escape_string($id_usuario));
            $rs = $conn->query($query);
            if ($rs) {
                
                while($row = mysqli_fetch_assoc($rs)) {
                  $d=date('G:i, d/m/y', strtotime($row['fecha']));
                  $listaReservas[]=new Reserva($row['id'],$row['id_usuario'], $row['fecha'], $row['nPersonas']);
                }
                $rs->free();
            } else {
                
                echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                exit();
            }
        }
        return $listaReservas;
    }

    public static function buscarReserva($idR){
        
        if (!$idR) {
            return false;
        } 
        
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM reservas WHERE id = %d", $idR);
        $reserva=false;
        $rs = $conn->query($query);
            if ($rs) {
                if($row = mysqli_fetch_assoc($rs)){
                  
                  $query = sprintf("SELECT * FROM usuarios  WHERE id LIKE '{$row['id_usuario']}'");
                  $rsa= $conn->query($query);
                  $us = mysqli_fetch_assoc($rsa);
                  $reserva=new Reserva($row['id'],$row['id_usuario'], $row['fecha'], $row['nPersonas']);
                }
                $rs->free();
        return $reserva;


    }

    }


    public static function borrarReserva($idR){
        if (!$idR) {
            return false;
        } 
 
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
        $query = sprintf("DELETE FROM reservas WHERE id = %d", $idR);
        if ( !$conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            
            return false;
        }
        
        return true;


    }

    
    public static function crea($id_usuario,$fecha, $hora, $nPersonas)
    {
        $stamp = strtotime($fecha . ' ' . $hora);
        $daTime=date("Y-m-d H:i", $stamp);
        $reserva = new Reserva(null,$id_usuario, $daTime, $nPersonas);
        return self::guarda($reserva);
    }

    public static function definirNuevaHora($hora)
    {
       // $stamp = strtotime($fecha . ' ' . $hora);

       //self::horasReserva() //habra que comprobar que no haya definido ya esa hora anteriormente, aunque si la hubiera
       //no habria problemas ni generaria errores
        $horaAGuardar = date('G:i', strtotime($hora));
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
       // $query2 = sprintf("INSERT INTO horasreservas (id, hora) VALUES (NULL, '%s')"); //funciona
        $query = sprintf("INSERT INTO horasreservas (id, hora) VALUES (NULL, '%s')", $horaAGuardar); //funciona

        if ($conn->query($query) ) {
            
            return true;
        }
        
        return false;
    }

    public static function BorrarHoraId($id)
    {
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
        
       // $query2 = sprintf("INSERT INTO horasreservas (id, hora) VALUES (NULL, '%s')"); //funciona
        $query = sprintf("DELETE FROM horasreservas WHERE horasreservas.id = '%d'", $id); //funciona
        

        if ($conn->query($query)) {
            return true;
        }
        return false;
    }



    public static function guarda($reserva)
   {
       if ($reserva->id !== null) {
          //  return self::actualiza($reserva); 
       }
       return self::inserta($reserva);
   }
   public static function compruebaSitio($fecha,$nPers){
    $app = Aplicacion::getInstancia();
    $conn = $app->conexionBd();
    $query=sprintf("SELECT * FROM reservas WHERE fecha = '%s'", $fecha);
    $rshoras=$conn->query($query);
    $total=0;
    
    if($rshoras) {
     while($rowHora = mysqli_fetch_assoc($rshoras)){
         $total = $total+$rowHora['nPersonas'];
     }
     $rshoras->free();
     
  }
    $query=sprintf("SELECT * FROM restaurante");
    $rscap=$conn->query($query);
    
    if($rscap){
        $rowcap = mysqli_fetch_assoc($rscap);
        if($rowcap['capacidad']<=$total+$nPers){
            $rscap->free();
            return false;
        }
    }
    
    return true;
   }
   public static function horasReserva(){
    $app = Aplicacion::getInstancia();
    $conn = $app->conexionBd();
    $query=sprintf("SELECT * FROM horasreservas ORDER BY hora");
    $rshoras=$conn->query($query);
    $listaHorasReservas = array();
    if($rshoras) {
        while($rowHora = mysqli_fetch_assoc($rshoras)){
            $listaHorasReservas[$rowHora['id']] =  date('G:i', strtotime($rowHora['hora']));
        }
        $rshoras->free();
   }
   
   return $listaHorasReservas;
   }
   private static function inserta($reserva)
   {
       $app = Aplicacion::getInstancia();
       $conn = $app->conexionBd();
       $query=sprintf("INSERT INTO reservas(id_usuario, fecha, nPersonas) VALUES('%s', '%s', '%u')"
           , $conn->real_escape_string($reserva->id_usuario)
           , $conn->real_escape_string($reserva->fecha)
           , $conn->real_escape_string($reserva->nPersonas));
       if ( $conn->query($query) ) {
           $reserva->id = $conn->insert_id;
       } else {
           echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
           exit();
       }
       return $reserva;
   }

   public static function actualizarReserva($id, $fecha, $nPersonas){
    $app = Aplicacion::getInstancia();
    $conn = $app->conexionBd();
    
    $query = sprintf("UPDATE reservas
                    SET fecha = '%s', nPersonas = '%u'
                    WHERE id = '%d'", $fecha, $nPersonas ,$id);
    /* echo "<script>console.log('Debug Objects: " . $fecha. "' );</script>";  */                               
    if($conn->query($query)) return true;
    else return false;
}

    public function getId()
    {
        return $this->id;
    }

    public function getIdUsusario()
    {
        return $this->id_usuario;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getNPersonas()
    {
        return $this->nPersonas;
    }
    public function getHora(){
        return date('G:i', strtotime($this->getFecha()));

    }
    public function getDia(){
        return date('Y-m-d', strtotime($this->getFecha()));
    }
}

?>