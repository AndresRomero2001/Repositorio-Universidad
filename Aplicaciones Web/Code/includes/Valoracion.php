<?php 
namespace aw\proyecto\clases;

class Valoracion
{
    private $id;
    private $id_usuario;
    private $id_plato;
    private $valoracion;
    private $descripcion;

    private function __construct($id, $id_usuario, $id_plato, $valoracion, $descripcion)
    {
        $this->id = $id;
        $this->id_usuario = $id_usuario;
        $this->id_plato = $id_plato;
        $this->valoracion = $valoracion;
        $this->descripcion = $descripcion;
    }

    public static function buscarValoracion($idValoracion)
    {
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();

        $queryValoraciones = sprintf("SELECT * FROM valoraciones WHERE id = '%d'", $idValoracion);
        $rsValoraciones = $conn->query($queryValoraciones);
        if($rsValoraciones) {
            $rowValoracion = mysqli_fetch_assoc($rsValoraciones);
            $rsValoraciones->free();
            return new Valoracion($rowValoracion['id'], $rowValoracion['id_usuario'], $rowValoracion['id_plato'], $rowValoracion['valoracion'], $rowValoracion['descripcion']);
        } else {
            return false;
        }

    }

    public static function listaValoracionesPlato($idPlato)
    {
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
        $listaValoraciones = array();
        
        $queryValoraciones = sprintf("SELECT * FROM valoraciones WHERE id_plato = '%d'", $idPlato);
        $rsValoraciones = $conn->query($queryValoraciones);
        if($rsValoraciones) {
            while($rowValoracion = mysqli_fetch_assoc($rsValoraciones)){
                $listaValoraciones[] = new Valoracion($rowValoracion['id'], $rowValoracion['id_usuario'], $rowValoracion['id_plato'], $rowValoracion['valoracion'], $rowValoracion['descripcion']);
            }
            $rsValoraciones->free();
            return $listaValoraciones;
        }
        else {
            return false;
        }
    }

    public static function insertarComentario($id_usuario, $id_plato, $valoracion, $descripcionPlato){
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();

        $descripcion = $conn->real_escape_string($descripcionPlato);

        $query = sprintf("INSERT INTO valoraciones (id_usuario, id_plato, valoracion, descripcion) VALUES ('%d', '%d', '%u','%s')", 
        $id_usuario, $id_plato, $valoracion, $descripcion);
        if($conn->query($query)) return true;
        else return false;
    }

    public static function borrarValoracion($idComentario){
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();

        $query = sprintf("DELETE FROM valoraciones WHERE id=%d", $idComentario);
        if($conn->query($query)) return true;
        else return false;
    }

    

    public function getId()
    {
        return $this->id;
    }

    public function getId_usuario()
    {
        return $this->id_usuario;
    }

    public function getId_plato()
    {
        return $this->id_plato;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getValoracion()
    {
        return $this->valoracion;
    }

}



?>