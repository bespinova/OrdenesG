<?php
include_once("../ClsParam.php"); 
include_once("../ClsMsSql.php");

class modPrueba {
    private $CodReg;
    private $Descripcion;
    private $Cantidad1;
    private $Cantidad2;
    private $Fecha;
    
    private $ArrDat;
    
    var $conDb;
    var $objParam;
    
    public function getCodReg() {
        return $this->CodReg;
    }

    public function getDescripcion() {
        return $this->Descripcion;
    }

    public function getCantidad1() {
        return $this->Cantidad1;
    }

    public function getCantidad2() {
        return $this->Cantidad2;
    }

    public function getFecha() {
        return $this->Fecha;
    }

    public function setCodReg($CodReg) {
        $this->CodReg = $CodReg;
    }

    public function setDescripcion($Descripcion) {
        $this->Descripcion = $Descripcion;
    }

    public function setCantidad1($Cantidad1) {
        $this->Cantidad1 = $Cantidad1;
    }

    public function setCantidad2($Cantidad2) {
        $this->Cantidad2 = $Cantidad2;
    }

    public function setFecha($Fecha) {
        $this->Fecha = $Fecha;
    }

        public function __construct($codreg,$descripcion, $cantidad1, $cantidad2,$fecha)
        {
            $this->CodReg = $codreg;
            $this->Descripcion = $descripcion;
            $this->Cantidad1 = $cantidad1;
            $this->Cantidad2 = $cantidad2;
            $this->Fecha = $fecha;
            $this->ArrDat = array($this->Descripcion,
                                  $this->Cantidad1,
                                  $this->Cantidad2,
                                  $this->Fecha
                    );
            
            /*
               Ver si se puede conservar la conexion por session, o pasar la cnexion desde la pagina inicial
             *              */
            $this->objParam =  new ClsParam("C:\\inetpub\\wwwroot\\NominaW\\configWeb.txt");
            $this->conDb = new ClsmsSql($this->objParam->Servidor,$this->objParam->Usuario,$this->objParam->Datos,$this->objParam->Passw); 
            //print $this->objParam->Servidor."<br>".$this->objParam->Usuario."<br>".$this->objParam->Datos."<br>".$this->objParam->Passw."<br>";
            
            if ($this->conDb->Conextar() > 0){              
              return "Error al conectarse en la base de datos";   
            }
        }
    
    public function __toString() {
        
    }
    
    public function guardarPrueba()
    {
       $strIns = "Insert into tblPruebasPhp (Descripcion,Cantidad1,"
               . "Cantidad2,Fecha) Values(?,?,?,?)"; 
     
       if($this->conDb->AddRegistro ($strIns, $this->ArrDat))
          
          return "Registro Agregado"; 
       else
           return "No se agrego el registro ...";
    }
    
    
    public function obtenerPruebas()
    {
       $strSlc = "Select * from tblPruebasPhp "; 
       $rsp = $this->conDb->loadQueryARR_Asoc($strSlc); 
       //print_r($rsp);
        if (count($rsp) > 0){ 
            return $rsp;
        }   
       else 
           return 'no hay registros que mostrar ....';
    }
    
    
    public function obtenerPrueba($codreg)
    {
       $strSlc = "Select * from tblPruebasPhp where CodReg = '".$codreg."'"; 
       $rsp = $this->conDb->loadQueryARR_Asoc($strSlc); 
       //print_r($rsp);
        if (count($rsp) > 0){ 
            return $rsp;
        }   
       else 
           return 'no hay registros que mostrar ....';
    }
    
    
    public function DeletePrueba($codreg)
    {
        $strDlt = "delete from tblPruebasPhp where CodReg = ".$codreg;
        $rsp = $this->conDb->QueryDml( $strDlt); 
        //print $rsp;
        if (count($rsp) > 0){ 
            return 'Registro eliminado';
        }   
       else 
           return 'no hay registros que eliminar ....';
    }
    
    public function UpdatePrueba()
    {
        $strUpd = 'Update tblPruebasPhp set Descripcion = (?), Cantidad1 = (?), '
                . 'Cantidad2 = (?), Fecha = (?) where CodReg = (?)';


       $this->ArrDat = array(
                             $this->Descripcion,
                             $this->Cantidad1,
                             $this->Cantidad2,
                             $this->Fecha,
                             $this->CodReg
                    ); 
        
        
        print 'En mod arrd'. print_r($this->ArrDat);
       if($this->conDb->UpdateRegistro($strUpd, $this->ArrDat))             
            //echo "Información: ".$this->ArrDat;
          return "Registro Actualizado"; 
       else
           return "No se agrego el registro ...";
        
    }
    
    
}
