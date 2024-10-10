<?php

class Notebook{
    private $id;
    private $fullname;
    private $marca;
    private $procesador;
    private $sitio;
    private $precio;
    private $mensajeoperacion;

    public function __construct() {
        $this->id = 0;
        $this->fullname='';
        $this->marca='';
        $this->procesador='';
        $this->sitio = '';
        $this->mensajeoperacion='';
    }

    /* GETTERS */
    public function getId(){
        return $this->id;
    }
    public function getFullname(){
        return $this->fullname;
    }
    public function getMarca(){
        return $this->marca;
    }
    public function getProcesador(){
        return $this->procesador;
    }
    public function getSitio(){
        return $this->sitio;
    }
    public function getPrecio(){
        return $this->precio;
    }
    public function getMensajeOperacion(){
        return $this->mensajeoperacion;
    }

    /* SETTERS */
    public function setId($newValue){
        $this->id = $newValue;
    }
    public function setFullname($newValue){
        $this->fullname = $newValue;
    }
    public function setMarca($newValue){
        $this->marca = $newValue;
    }
    public function setProcesador($newValue){
        $this->procesador = $newValue;
    }
    public function setSitio($newValue){
        $this->sitio = $newValue;
    }
    public function setPrecio($newValue){
        $this->precio = $newValue;
    }
    public function setMensajeOperacion($nuevoMensajeOperacion){
        $this->mensajeoperacion = $nuevoMensajeOperacion;
    }

    public function setear($id, $fullname, $marca, $procesador, $sitio, $precio){
        $this->setId($id);
        $this->setFullname($fullname);
        $this->setMarca($marca);
        $this->setProcesador($procesador);
        $this->setSitio($sitio);
        $this->setPrecio($precio);
    }

    public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM notebook WHERE id = ".$this->getId();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    // $objDuenio = new Persona();
                    // $objDuenio->setNroDni($row['DniDuenio']);
                    // $objDuenio->cargar();
                    $this->setear($row['id'], $row['Fullname'], $row['Marca'],$row['Procesador'],$row['Sitio'], $row['Precio']);
                    
                }
            }
        } else {
            $this->setmensajeoperacion("Notebook->listar: ".$base->getError());
        }
        return $resp;
     
    }

    /**
	 * Recupera los datos de una notebook por id
	 * @param int $id
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($id){
		$base=new BaseDatos();
		$consulta="Select * from notebook where id=".$id;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consulta)){
				if($row2=$base->Registro()){
				    $this->setId($id);
				    $this->setFullname($row2['Fullname']);
					$this->setMarca($row2['Marca']);
					$this->setProcesador($row2['Procesador']);
					$this->setSitio($row2['Sitio']);
                    $this->setPrecio($row2['Precio']);
					$resp= true;
				}				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }		
		 return $resp;
	}	

    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="INSERT INTO notebook(Fullname, Marca, Procesador, Sitio, Precio)  VALUES('".$this->getFullname()."', '".$this->getMarca()."', '".$this->getProcesador()."', '".$this->getSitio()."',".$this->getPrecio().");";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                if($id = $base->lastInsertId($sql)){
                    $this->setId($id);
                }else{
                    echo "no se encontró el id";
                }
                $resp = true;
            } else {
                $this->setmensajeoperacion("Notebook->insertar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Notebook->insertar: ".$base->getError());
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="UPDATE notebook SET Marca ='".$this->getMarca()."', Fullname= '".$this->getFullname()."', Procesador = '".$this->getProcesador()."', Sitio = '".$this->getSitio()."', Precio = ".$this->getPrecio()." WHERE id= '".$this->getId()."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Notebook->modificar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Notebook->modificar: ".$base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="DELETE FROM notebook WHERE id=".$this->getId();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Notebook->eliminar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Notebook->eliminar: ".$base->getError());
        }
        return $resp;
    }

    public function listar($parametro=""){
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM notebook ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    
                    $net = new Notebook();
                    $net->setear($row['id'], $row['Fullname'], $row['Marca'], $row['Procesador'],$row['Sitio'],$row['Precio']);      
                    array_push($arreglo, $net);
                }
               
            }
            
        } else {
            $this->setmensajeoperacion("Auto->listar: ".$base->getError());
        }
 
        return $arreglo;
    }

    public function arrayToString($arreglo){
        $string = '';
        foreach ($arreglo as $elemento){
            $string .= "$elemento.\n";
        }
        return $string;
    }

    public function __toString()
    {
        return "\nfullName: ".$this->getFullname().
        "\nMarca: " .$this->getMarca().
        "\nProcesador: ".$this->getProcesador().
        "\nSitio: ".$this->getSitio().
        "\nPrecio: ".$this->getPrecio()."\n";
    }

}