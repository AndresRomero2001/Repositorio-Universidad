<?php
namespace aw\proyecto\clases;

class Categoria
{
    private $id;
    private $nombre;

    private function __construct($id, $nombre)
    {
        $this->id = $id;
        $this->nombre = $nombre;
    }

    public static function listaCategorias()
    {
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();

        $query = sprintf("SELECT * FROM categoria");
        $rs = $conn->query($query);
        if($rs) {
            $listaCategorias = array();
            while($row = mysqli_fetch_assoc($rs)){
                $listaCategorias[] = new Categoria($row['id'], $row['nombre']);
            }
            $rs->free();
            return $listaCategorias;
        }
        else {
            $rs->free();
            return false;
        }
    }

    public static function insertarCategoria($nombreCategoria){
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();

        $nombre = $conn->real_escape_string($nombreCategoria);

        $query = sprintf("INSERT INTO categoria (nombre) VALUES('$nombre')");
        // de la siguiente manera no hace falta "liberar memoria"
        if($conn->query($query)) return true;
        else return false;
    }

    public static function borrarCategoria($idCategoria){
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();

        $query = sprintf("DELETE FROM categoria WHERE id = '$idCategoria'");
        // de la siguiente manera no hace falta "liberar memoria"
        if($conn->query($query)) return true;
        else return false;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
}

?>