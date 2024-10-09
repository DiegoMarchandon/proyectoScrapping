<?php

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

        if(array_key_exists('id',$param) && array_key_exists('Fullname',$param) && array_key_exists('Marca', $param) && array_key_exists('Procesador', $param) && array_key_exists('URL', $param) && array_key_exists('Precio', $param)){
            $obj = new Notebook();
            $obj->setear($param['id'], $param['Fullname'], $param['Marca'], $param['Procesador'],$param['URL'],$param['Precio']);
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
        // $param['patente'] =null;
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
            if (isset($param['URL'])) $where.=" and URL = '".$param['URL']."'";
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

}

?>