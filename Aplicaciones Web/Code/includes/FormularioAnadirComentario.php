<?php
namespace aw\proyecto\clases;

class FormularioAnadirComentario extends Form {

    public function __construct($idPlato) {
        $opciones['action'] = "verPlato.php?page=carta&idPlato=$idPlato";
        parent::__construct('formAnadirComentario', $opciones);
    }

    protected function generaCamposFormulario($datos, $errores = array()) {
       
        // Se reutilizan los valores que habia en los campos, en caso de haya habiado algun error y se haya
        //vuelto a generar el formulario
       
        $valoracion = $datos['valoracion'] ?? '';
        $descripcion = $datos['descripcion'] ?? '';
        $idPlato = $datos['idPlato'] ?? '';
        
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF

        <label for="valoracionPlato" class="campoFormulario">Valoración</label>
        <select class="form-select formInput" name="valoracionElegida" id="valoracionPlato" required>
        <option value="">Por favor, escoja una valoración</option>
EOF;

        $estrellas = "";
        for ($i = 1; $i < 6; $i++) {
            $estrellas .= "⭐";
        
            $html .= <<<EOF
            <option value="$i">$estrellas</option>
EOF;
        }

        $html .= <<<EOF
        </select>
        <label for="descripcionValoracion" class="campoFormulario">Descripción</label>
        <textarea id="descripcionValoracion" class="formInput" rows="4" cols="50" name="descripcion" required>$descripcion</textarea>

        <input type="hidden" name="idPlato" value="$idPlato">
       

        <button type="submit" id="anadirValoraButton" class="campoFormulario buttonPropio formSubmitButton">Añadir valoración</button>
EOF;

        return $html;
    }

    protected function procesaFormulario($datos) {
        $result = array();

        $id_user = $_SESSION["idUsuario"];
        $valoracion = $datos["valoracionElegida"];
        $descripcion = $datos["descripcion"];
        $idPlato = $datos["idPlato"];
        
        
        if(count($result) != 0) //ha habido errores en algun campo
        {
            $result[] = "Error en los datos del formulario"; //mensaje de error global que se mostrara por encima del formulario
        }
        else{
            $int = intval($idPlato); //pq el value de un input es string, lo paso a int que es como esta el id en la BD

            if(!(Valoracion::insertarComentario($id_user, $int, $valoracion, $descripcion))) {
                echo "<p>ERROR: no se ha podido añadir la valoración</p>";
            } else {
                $result = "verPlato.php?page=carta&idPlato=$idPlato";
            }
            
        }

        return $result;
    }
}
