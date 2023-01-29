<?php
namespace aw\proyecto\clases;

class FormularioAnadirCategoria extends Form
{
    public function __construct() {
        /* $opciones['action'] = "configuracionRestaurante.php?page=configuracionRestaurante"; */
        $opciones['action'] = "";
        parent::__construct('formDatosRest', $opciones);
    }
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <label for="categoria">Nombre de la categoria</label>
        <input class="formInput-XS" id="categoria" type="text" name="categoria">
        <button class="botonesFormConfRes" type="submit"> Añadir </button>
        EOF;

        return $html;
    }
    
    /**
    *
    *result sera la dir de la pagina destino si ha ido todo bien, o sino un array con los mensajes de error a mostrar
    *Los mensajes de error estan organizados de la siguinete manera:
    *Si se meten sin clave (se le asigna valor numerico automaticamente): se mostraran al principio del formulario
    * Para mostrarlos habra que llamar en generarCampos a la funcion generaListaErroresGlobales pasandole la lista de errores
    *Si se meten con clave seran errores de un campo concreto
    * Para mostrarlos habra que llamar en generarCampos a la funcion createMensajeError pasandole la lista de errores y la clave de ese error en esa lista 
    */
    protected function procesaFormulario($datos)
    {
        $result[] = "error en los datos del formulario";
        echo "holaaaaaaaaaaaaaaaaaaaaaa";
        $cat = $datos['categoria'];
        if(Categoria::insertarCategoria($cat)) $result = 'configuracionRestaurante.php?page=configuracionRestaurante';
        else $result[] = "error en los datos del formulario";
        
        /* return $result; */
    }
}