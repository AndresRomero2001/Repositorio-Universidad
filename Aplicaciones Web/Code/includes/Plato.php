<?php
namespace aw\proyecto\clases;

class Plato
{
    private $id;
    private $foto;
    private $nombre;
    private $precio;
    private $descripcion;
    private $idCategoria;

    private function __construct($id, $foto, $nombre, $precio, $descripcion, $idCategoria)
    {
        $this->id = $id;
        $this->foto = $foto;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->descripcion = $descripcion;
        $this->idCategoria = $idCategoria;
    }

    public static function buscarPlato($idPlato)
    {
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();

        $queryPlatos = sprintf("SELECT * FROM platos WHERE id = '%d'", $idPlato);
        $rsPlatos = $conn->query($queryPlatos);
        if($rsPlatos) {
            $rowPlato = mysqli_fetch_assoc($rsPlatos);
            $rsPlatos->free();
            return new Plato($rowPlato['id'], $rowPlato['foto'], $rowPlato['nombre'], $rowPlato['precio'], $rowPlato['descripcion'], $rowPlato['id_categoria']);
        } else {
            return false;
        }

    }

    public static function listaPlatosCategoria($idCat)
    {
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
        $listaPlatos = array();
        
        $queryPlatos = sprintf("SELECT * FROM platos WHERE id_categoria = '%d'", $idCat);
        $rsPlatos = $conn->query($queryPlatos);
        if($rsPlatos) {
            while($rowPlato = mysqli_fetch_assoc($rsPlatos)){
                $listaPlatos[] = new Plato($rowPlato['id'], $rowPlato['foto'], $rowPlato['nombre'], $rowPlato['precio'], $rowPlato['descripcion'], $rowPlato['id_categoria']);
            }
            $rsPlatos->free();
            return $listaPlatos;
        }
        else {
            return false;
        }
    }

    public static function insertarPlato($nombrePlato, $precioPlato, $descripcionPlato, $idCategoria, $foto){
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();

        $nombre = $conn->real_escape_string($nombrePlato);
        //$precio = $conn->real_escape_string($precioPlato);
        $descripcion = $conn->real_escape_string($descripcionPlato);

        $query = sprintf("INSERT INTO platos (nombre, precio, descripcion, id_categoria, foto) VALUES('%s', '%f', '%s', '%d', '%s')", $nombre, $precioPlato, $descripcion, $idCategoria, $foto);
        // de la siguiente manera no hace falta "liberar memoria"
        if($conn->query($query)) return true;
        else return false;
    }

    public static function borrarPlato($idPlato){
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();

        $query = sprintf("DELETE FROM platos WHERE id=%d", $idPlato);
        if($conn->query($query)) return true;
        else return false;
    }

    public static function actualizarPlato($nombrePlato, $precio, $descripcionPlato, $idCategoria, $foto, $idPlato){
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();

        $nombre = $conn->real_escape_string($nombrePlato);
        $descripcion = $conn->real_escape_string($descripcionPlato);

        $query = sprintf("UPDATE platos
                        SET foto = '%s', nombre = '%s', precio = '%f', descripcion = '%s', id_categoria = '%d'
                        WHERE id = '%d'", $foto, $nombre ,$precio , $descripcion, 
                        $idCategoria, $idPlato);               
        if($conn->query($query)) return true;
        else return false;
    }

    public static function listaPlatos($idPed)
    {
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
        $listaPlatos = array();
        
        $query = sprintf("SELECT * FROM platospedido P WHERE P.id_pedido LIKE '%d'", $idPed);
        $rs = $conn->query($query);
        if ($rs) {
            while($row = mysqli_fetch_assoc($rs)){
                
                $query = sprintf("SELECT * FROM platos Pl WHERE Pl.id LIKE '{$row['id_plato']}'");
                $rsa= $conn->query($query);
                $rowPlato = mysqli_fetch_assoc($rsa);
                $listaPlatos[] = array(new Plato($rowPlato['id'], $rowPlato['foto'], $rowPlato['nombre'], $rowPlato['precio'],
                 $rowPlato['descripcion'], $rowPlato['id_categoria']),$row['num']);
            }
            $rs->free();
        } else {
            $rs->free();
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    
        return $listaPlatos;
    }    

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function getIdCategoria()
    {
        return $this->idCategoria;
    }

}

?>