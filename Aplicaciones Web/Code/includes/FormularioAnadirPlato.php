<?php
namespace aw\proyecto\clases;

class FormularioAnadirPlato extends Form {

    public function __construct() {
        $opciones['action'] = "carta.php?page=carta";
        parent::__construct('formAnadirPlato', $opciones);
    }

    protected function generaCamposFormulario($datos, $errores = array()) {
       
        // Se reutilizan los valores que habia en los campos, en caso de haya habiado algun error y se haya
        //vuelto a generar el formulario
        $nombre =$datos['nombre'] ?? '';
        $precio =$datos['precio'] ?? '';
        $foto =$datos['foto'] ?? '';
        $descripcion =$datos['descripcion'] ?? '';
        $categoriaElegida =$datos['categoriaElegida'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorFotoMSG = self::createMensajeError($errores, 'errorFoto', 'span', array('class' => 'errorMSG'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
       
        <!-- El display block sirve para que haya un salto de linea despues de la etiqueta -->
        <label for="nombrePlato" class="campoFormulario">Nombre del plato</label>
        <input type="text" class="formInput" id="nombrePlato" name="nombre" value="$nombre" required>

        <label for="precioPlato" class="campoFormulario">Precio del plato</label>
        <input type="number" class="formInput" id="precioPlato" name="precio" value="$precio" step="0.01" min="0" max="999" required>

        <label for="categoriaPlato" class="campoFormulario">Categoria del plato</label>
        <select class="form-select formInput" id="categoriaPlato" name="categoriaElegida" size="1" required>

        <option value="">Por favor, escoja una categoría</option>

EOF;

        $res = Categoria::listaCategorias();
        foreach ($res as $cat){
            $html .= <<<EOF
            <option value="{$cat->getId()}">{$cat->getNombre()}</option>
EOF;
        }

        $html .= <<<EOF
        </select>
        <label for="fotoPlato" class="campoFormulario" id="fotoLabel">Foto del plato $errorFotoMSG</label>
        <input type="file" class="formInput" name="foto" id="fotoPlato">

        <label for="descripcionPlato" class="campoFormulario">Descripción del plato</label>
        <textarea id="descripcionPlato" class="formInput" rows="4" cols="50" name="descripcion" required>$descripcion</textarea>
        
        <button type="submit" id="anadirPlatoButton" class="campoFormulario buttonPropio formSubmitButton">Añadir plato</button>
        
EOF;

        return $html;
    }

    protected function procesaFormulario($datos) {
        $result = array();

        $nombrePlato = $datos["nombre"];
        $precio = $datos["precio"];
        $idCategoria = $datos["categoriaElegida"];
        $descripcion = $datos["descripcion"];

        $foto = $_FILES['foto']['name'];

        if($foto != NULL) {
            $fileParts = pathinfo($foto);
            $validExtensions = Array('jpg','png', 'jpeg', 'webp');
            if (!in_array($fileParts['extension'], $validExtensions)) {
                $result['errorFoto'] = "Formato de la foto no válido";
                $showToast = <<<EOF
                <script src="js/comun.js"></script>
                <div id="errorToast">
                    <div class="toastTitleDiv">
                    <p class="toastTitle">ERROR</p>
                    </div>
                ⚠️ Error al añadir Plato. Compruebe el formulario para más detalles
                </div>
                <script>
                formToast();
                </script>
EOF;
                echo $showToast;
                
            } else {
                $dir_subida = 'images/carta/';
                $fichero_subido = $dir_subida . basename($foto);

                if (move_uploaded_file($_FILES['foto']['tmp_name'], $fichero_subido)) {
                   // echo "El fichero es válido y se subió con éxito.\n";
                } else {
                   // echo "El fichero no se ha podido mover a la dir $dir_subida, fichero subido: $fichero_subido";
                }
            }

        }
        

        if(count($result) != 0) //ha habido errores en algun campo
        {
            $result[] = "Error en los datos del formulario"; //mensaje de error global que se mostrara por encima del formulario
        }
        else{
            
            if(Plato::insertarPlato($nombrePlato, $precio, $descripcion, $idCategoria, $foto)) {
                $result = 'carta.php?page=carta';
            }
            else echo "<p>ERROR: no se ha podido insertar el plato</p>";
        }

        return $result;
    }

}
