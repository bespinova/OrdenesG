<?php
include_once("../ClsParam.php");
include_once("../ClsMsSql.php");
require("../core.php");
session_start();

class modCatRubroTarea {
    private $CodTarea;
    private $Descripcion;
    private $CodRubro_fk;
    private $ValorEnRubro;

    private $ArrDat;
    var $conDb;
    var $objParam; 
     
    public function getCodTarea() {
        return $this->CodTarea;
    }

    public function getDescripcion() {
        return $this->Descripcion;
    }

    public function getCodRubro_fk() {
        return $this->CodRubro_fk;
    }

    public function getValorEnObra() {
        return $this->ValorEnRubro;
    }

    public function setCodTarea($CodTarea) {
        $this->CodTarea = $CodTarea;
    }

    public function setDescripcion($Descripcion) {
        $this->Descripcion = $Descripcion;
    }

    public function setCodRubro_fk($CodRubro_fk) {
        $this->CodRubro_fk = $CodRubro_fk;
    }

    public function setValorEnRubro($ValorEnRubro) {
        $this->ValorEnObra = $ValorEnRubro;
    }


    public function __construct($CodTarea, $Descripcion, $CodRubro_fk, $ValorEnRubro) {
        $this->CodTarea = $CodTarea;
        $this->Descripcion = $Descripcion;
        $this->CodRubro_fk = $CodRubro_fk;
        $this->ValorEnRubro = $ValorEnRubro;
        
        $this->ArrDat = array($this->CodTarea,
                              $this->Descripcion,
                              $this->CodRubro_fk,
                              $this->ValorEnRubro
                    );

           $this->objParam = new ClsParam($_SESSION['path']);
           $this->conDb = new ClsmsSql($_SESSION['Servidor'],$_SESSION['Usuario'],$_SESSION['Datos'],$_SESSION['Passw']);
           //$this->conDb = new ClsmsSql("sigma6\locsql","sa","GcOSMtto","Remolachas1");


            if ($this->conDb->Conextar() > 0){
              return "Error al conectarse en la base de datos";
            }
    }
    
    
    public function guardarprCatTareaRubros()
    {
       $strIns = "Insert into PrCatTareaRubro (CodTarea,Descripcion,"
               . "CodRubro_fk,ValorEnRubro) Values(?,?,?,?)";      
     
       if($this->conDb->AddRegistro ($strIns, $this->ArrDat)){
         
           $strUp = "update PrCatTareaRubro set ValorEnRubro = (Select round(100.00/COUNT(*),3) 
                                               from PrCatTareaRubro where CodRubro_fk = '".$this->CodRubro_fk."') ".
                   " where CodRubro_fk = '".$this->CodRubro_fk."'";
         
         if($this->conDb->QueryDml($strUp) > 0)
            return "Registro Agregado Y Actualizado"; 
       }  
       else
           return "No se agrego el registro ...";
    }
    
    
    public function UpdateCatRubrosTarea($CodRubroAnt)
    {
        $strUpd = 'Update PrCatTareaRubro set Descripcion = (?), CodRubro_fk = (?),ValorEnRubro = (?) '
                . ' where CodTarea = (?)';
       $this->ArrDat = array(
                             $this->Descripcion,
                             $this->CodRubro_fk,
                             $this->ValorEnRubro,
                             $this->CodTarea
                    );
     
       if($this->conDb->UpdateRegistro($strUpd, $this->ArrDat))
       {
           if(strcmp($this->CodRubro_fk,$CodRubroAnt) == 0)
           {
                $strUp = "update PrCatTareaRubro set ValorEnRubro = (Select round(100.00/COUNT(*),3) 
                                               from PrCatTareaRubro where CodRubro_fk = '".$this->CodRubro_fk."') ".
                   " where CodRubro_fk = '".$this->CodRubro_fk."'";
            
              if($this->conDb->QueryDml($strUp) > 0)
               return "Registro actualizado y Valor en rubro"; 
           }
           else
           {
              $strUp = "update PrCatTareaRubro set ValorEnRubro = (Select round(100.00/COUNT(*),3) 
                                               from PrCatTareaRubro where CodRubro_fk = '".$this->CodRubro_fk."') ".
                   " where CodRubro_fk = '".$this->CodRubro_fk."'"; 
              $strUp2 = "update PrCatTareaRubro set ValorEnRubro = (Select round(100.00/COUNT(*),3) 
                                               from PrCatTareaRubro where CodRubro_fk = '".$CodRubroAnt."') ".
                   " where CodRubro_fk = '".$CodRubroAnt."'";
               if($this->conDb->QueryDml($strUp) > 0) 
                   if($this->conDb->QueryDml($strUp2) > 0)
                       return "Registro actualizado y Valor en rubro";
                   else
                       return "No se agrego el registro ...";
               else
                  return "No se agrego el registro ..."; 
           }
                      
       }         
       else
           return "No se agrego el registro ...";
    }
    
    
    
    public  function DeleteprCatRubroTarea($CodTarea)
    {
        $strGetCr = "select 'CodRubroDel' as NombreParametro,CodRubro_fk as Valor from PrCatTareaRubro 
                      where CodTarea = '".$CodTarea."'";
        $rsCr = $this->conDb->loadQueryARR_AsocPrm($strGetCr);        
        $strDlt = "delete from PrCatTareaRubro where CodTarea = '".$CodTarea."'";

        $rsp = $this->conDb->QueryDml( $strDlt);
        
        if (count($rsp) > 0){
            $strUp2 = "update PrCatTareaRubro set ValorEnRubro = (Select round(100.00/COUNT(*),3) 
                                               from PrCatTareaRubro where CodRubro_fk = '".$rsCr['CodRubroDel']."') ".
                   " where CodRubro_fk = '".$rsCr['CodRubroDel']."'";
             if($this->conDb->QueryDml($strUp2) > 0)
                       return "Registro eliminado y Valor en rubro actualizado";
        }
       else
           return 'no hay registros que eliminar ....';
    }

    
    public function Obtener_Seg($CodPantalla)
    {
        $strSeg = "select A.CodPerfil,P.CodPantalla,A.CodProceso,P.Descripcion,A.Acceso
                     from SgAccesos A join  SgProcesos P on A.CodProceso = P.CodProceso
                                                         and P.CodPantalla = '".$CodPantalla."' ".
                     " where A.CodPerfil = '".$_SESSION['CodPerfil'] ."'";

        $rsp = $this->conDb->loadQueryARR_Asoc($strSeg);

        if (count($rsp) > 0){
            return $rsp;
        }
       else
           return  $rsp;
    }
    
    
    
    


    public function obtenerCatRubroTareaT($CodRubro)
    {
       if (strlen($CodRubro) == 0)
            $strSlc = "Select T.CodTarea,T.Descripcion,R.Descripcion as Rubro,T.ValorEnRubro
                         from PrCatTareaRubro T join PrCatRubros R on T.codRubro_fk = R.CodRubro";
       else
          $strSlc = "Select T.CodTarea,T.Descripcion,R.Descripcion as Rubro,T.ValorEnRubro
                         from PrCatTareaRubro T join PrCatRubros R on T.codRubro_fk = R.CodRubro
                         Where T.CodRubro_fk = '".$CodRubro."' "; 
       
       $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
       
        if (count($rsp) > 0){
            return $rsp;
        }
       else
           return  $rsp;//'no hay registros que mostrar ....';
    }

    
   public function  obtenerprCatRubroTarea1($CodTarea)
   {
       $strgetT = "select  Tr.*,Gm.CodGteMtto from PrCatTareaRubro Tr Join PrCatRubros Rb on Tr.CodRubro_fk = Rb.CodRubro
                                     Join CatGteMatto Gm on Rb.PerteneceA = Gm.CodGteMtto
                    where Tr.CodTarea = '".$CodTarea."'";
       $rsp = $this->conDb->loadQueryARR_Asoc($strgetT);
       
        if (count($rsp) > 0){
            return $rsp;
        }
       else
           return  $rsp;//'no hay registros que mostrar ....';
   }
    
    
    
    
    
    
    public function obtener_Rubros($CodGteMtto)
    {
       if (strlen($CodGteMtto)  == 0)
            $strUneg = "select CodRubro,Descripcion from PrCatRubros order by CodRubro";
       else
            $strUneg = "select CodRubro,Descripcion from PrCatRubros Where PerteneceA = '".$CodGteMtto."' order by CodRubro";
      
       $rsp = $this->conDb->loadQueryARR_Asoc($strUneg);
        if (count($rsp) > 0){ 
            return $rsp;
        }   
       else 
           return  $rsp;
    }
    
    
    public function obtener_GteMtto()
    {
        $strGmtto = "select CodGteMtto,Nombre from CatGteMatto order by CodGteMtto";
       
       $rsp = $this->conDb->loadQueryARR_Asoc($strGmtto);
        if (count($rsp) > 0){ 
            return $rsp;
        }   
       else 
           return  $rsp;
    }
    
}
?>
