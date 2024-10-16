<?php


namespace Controlador;
use Clase\Notebook;
use Conector\BaseDatos;

class ABMNotebook{

    /**
     * Función utilizada en caso que esperemos un arreglo de un solo elemento.
     * Llama a Buscar, convierte el obj del indice 0 a arreglo y lo retorna.
     * Si retorna un arreglo vacío, devuelve null.
     * @return array|null
     */
    public function arrayOnull($arrAsoc){
        $objetoOnull = $this->buscar($arrAsoc);
        $element = null;

        if(count($objetoOnull) === 1){
            $element = dismount($objetoOnull[0]);
        }
        
        return $element;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $datos
     * @return bool
     */
    public function abm($datos){
        $resp = false;
        if($datos['accion']=='editar'){
            if($this->modificacion($datos)){
                $resp = true;
            }
        }
        if($datos['accion']=='borrar'){
            if($this->baja($datos)){
                $resp =true;
            }
        }
        if($datos['accion']=='nuevo'){
            if($this->alta($datos)){
                $resp =true;
            }
            
        }
        return $resp;

    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Notebook
     */
    private function cargarObjeto($param){
        $obj = null;

        if(array_key_exists('id',$param) && array_key_exists('Fullname',$param) && array_key_exists('Marca', $param) && array_key_exists('Procesador', $param) && array_key_exists('Sitio', $param) && array_key_exists('Precio', $param)){
            $obj = new Notebook();
            $obj->setear($param['id'], $param['Fullname'], $param['Marca'], $param['Procesador'],$param['Sitio'],$param['Precio']);
        }

        return $obj;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Notebook
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        
        if( isset($param['id']) ){
            $obj = new Notebook();
            $obj->setear($param['id'], null, null, null, null, null);
        }
        return $obj;
    }
    
    
    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    
    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['id']))
            $resp = true;
        return $resp;
    }
    
    /**
     * permite ingresar un objeto
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $param['id'] =null;
        $objNet = $this->cargarObjeto($param);
//        verEstructura($elObjtTabla);
        if ($objNet!=null and $objNet->insertar()){
            $resp = true;
        }
        return $resp;
        
    }
    /**
     * permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $objNet = $this->cargarObjetoConClave($param);
            if ($objNet!=null and $objNet->eliminar()){
                $resp = true;
            }
        }
        
        return $resp;
    }
    
    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
        
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $objNet = $this->cargarObjeto($param);
            if($objNet!=null and $objNet->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }
    
    /**
     * permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param){
        $where = " true ";
        if ($param<>NULL){
            if (isset($param['id'])) $where.=" and id =".$param['id']."";
            if (isset($param['Fullname'])) $where.=" and Fullname ='".$param['Fullname']."'";
            if (isset($param['Marca'])) $where.=" and Marca ='".$param['Marca']."'";
            if (isset($param['Procesador'])) $where.=" and Procesador ='".$param['Procesador']."'";
            if (isset($param['Sitio'])) $where.=" and Sitio = '".$param['Sitio']."'";
            if (isset($param['Precio'])) $where.=" and Precio =".$param['Precio']."";

        }
        $net = new Notebook();
        $arreglo = $net->listar($where);  
        return $arreglo;
        
    }

    /**
     * Si recibe como parámetro un arreglo asociativo clave-valor, llama al Buscar  
     * y retorna un arreglo con arreglos asociativos. 
     * Si recibe como parámetro un objeto, convierte sus propiedades en un arreglo asociativo.
     * @param array|object $param
     * @return array  
     */
    public function buscarArray($param){
        $arreglo = [];
        if(is_object($param)){
            $arreglo = dismount($param);
        }else{
            $arreglo = convert_array($this->buscar($param));
        }
        return $arreglo;
    }


    /**
     * devuelve los arreglos asociativos de notebooks que coinciden con el input ingresado
     */
    public function returnMatches($input){
        $colNets = $this->buscarArray(null);
        $coincidenciaNet = [];
        // el "use" pasado a la función callback de array_filter se utiliza para que el $input sea accesible adentro de la misma.
            // pasamos & al inicio de la variable para indicar que la pasamos "por referencia" en lugar de pasar una copia de la misma. 
            // Lo que significa que cualquier modificación a la variable dentro de la función también afectará a la variable original.
        array_filter($colNets,function($notebook) use ($input, &$coincidenciaNet){
            // buscamos la aparición del $input en el 'fullname' de cada notebook
            // echo "<br>----input:".$input."----<br>";
            // echo "<br>----notebook fullname----<br>";
            // print_r($notebook['fullname']);
            $busqueda = stripos(strtolower($notebook['fullname']),strtolower($input));
            // !== false porque la coincidencia también se puede encontrar en la posición 0
            if($busqueda !== false){
                // echo "<br><b>hay coincidencia</b><br>";
                $coincidenciaNet[] = $notebook;
            }
        });
        return $coincidenciaNet;
    }

    /**
     * Actualiza la base de datos, eliminando los datos anteriores y agregando nuevos.
     * Retorna un numero mayor a 0 si se pudo. -1 caso contrario.
     * @return void
     */
    public function deleteRegis(){
        $BD = new BaseDatos;
        $respuesta = $BD->Ejecutar("DELETE FROM notebook;");
        return $respuesta;
    }

}

?>