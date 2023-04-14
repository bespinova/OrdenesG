<?php
include_once("../ClsParam.php"); 
include_once("../ClsMsSql.php");
include_once("../core.php");
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
//date_default_timezone_set('Etc/UTC');

//Create a new PHPMailer instance
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';



class modOsGeneral {
    private $FechaExpedicion;
    private $TipoMatto;
    private $CodSolicitante;
    private $CodUNegocio;
    private $CodArea;
    private $CodGteMatto;
    private $Estatus;
    private $EstatusDoc;
    private $CvePrioridad;
    private $DscFallo; 
    private $CodTipoOS;
    
    private $ArrDat;    
    var $conDb;
    var $objParam;
    
    public function getFechaExpedicion() {
        return $this->FechaExpedicion;
    }

    public function getTipoMatto() {
        return $this->TipoMatto;
    }

    public function getCodSolicitante() {
        return $this->CodSolicitante;
    }

    public function getCodUNegocio() {
        return $this->CodUNegocio;
    }

    public function getCodArea() {
        return $this->CodArea;
    }

    public function getCodGteMatto() {
        return $this->CodGteMatto;
    }

    public function getEstatus() {
        return $this->Estatus;
    }

    public function getCvePrioridad() {
        return $this->CvePrioridad;
    }

    public function getDscFallo() {
        return $this->DscFallo;
    }
    
    public function getEstatusDoc() {
        return $this->EstatusDoc;
    }
    
     public function getCodTipoOS() {
        return $this->CodTipoOS;
    }

    public function setEstatusDoc($EstatusDoc) {
        $this->EstatusDoc = $EstatusDoc;
    }

    
    public function setFechaExpedicion($FechaExpedicion) {
        $this->FechaExpedicion = $FechaExpedicion;
    }

    public function setTipoMatto($TipoMatto) {
        $this->TipoMatto = $TipoMatto;
    }

    public function setCodSolicitante($CodSolicitante) {
        $this->CodSolicitante = $CodSolicitante;
    }

    public function setCodUNegocio($CodUNegocio) {
        $this->CodUNegocio = $CodUNegocio;
    }

    public function setCodArea($CodArea) {
        $this->CodArea = $CodArea;
    }

    public function setCodGteMatto($CodGteMatto) {
        $this->CodGteMatto = $CodGteMatto;
    }

    public function setEstatus($Estatus) {
        $this->Estatus = $Estatus;
    }

    public function setCvePrioridad($CvePrioridad) {
        $this->CvePrioridad = $CvePrioridad;
    }

    public function setDscFallo($DscFallo) {
        $this->DscFallo = $DscFallo;
    }

    public function setCodTipoOS($CodTipoOS) {
        $this->CodTipoOS = $CodTipoOS;
    }
    
    
    
        public function __construct($FechaExpedicion,$TipoMatto, $CodSolicitante,$CodUNegocio,$CodArea,$CodGteMatto,
                                    $Estatus,$EstatusDoc,$CvePrioridad,$DscFallo,$CodTipoOS)
        {
            
            $this->FechaExpedicion = $FechaExpedicion;
            $this->TipoMatto = $TipoMatto;
            $this->CodSolicitante = $CodSolicitante;
            $this->CodUNegocio = $CodUNegocio;
            $this->CodArea = $CodArea;
            $this->CodGteMatto = $CodGteMatto;
            $this->Estatus = $Estatus;
            $this->EstatusDoc = $EstatusDoc;
            $this->CvePrioridad = $CvePrioridad;
            $this->DscFallo = $DscFallo; 
            $this->CodTipoOS = $CodTipoOS;
            
            
            $this->ArrDat = array(
                $this->FechaExpedicion,
                $this->TipoMatto,
                $this->CodSolicitante,
                $this->CodUNegocio,
                $this->CodArea,
                $this->CodGteMatto,
                $this->Estatus,
                $this->EstatusDoc,
                $this->CvePrioridad,
                $this->DscFallo,
                $this->CodTipoOS
             );
          // echo 'Con = '.$_SESSION['Conn'];
            
            /*
               Ver si se puede conservar la conexion por session, o pasar la cnexion desde la pagina inicial
             *              */
            //$this->objParam =  new ClsParam(PATH);
            //$this->conDb = new ClsmsSql($this->objParam->Servidor,$this->objParam->Usuario,$this->objParam->Datos,$this->objParam->Passw); 
           
            //$this->objParam =  new ClsParam(PATH);
           $this->conDb = new ClsmsSql($_SESSION['Servidor'],$_SESSION['Usuario'],$_SESSION['Datos'],$_SESSION['Passw']);
          //   $this->conDb = new ClsmsSql("sigma6\locsql","sa","GcOsMtto","Remolachas1");
            if ($this->conDb->Conextar() == 0){              
              return "Error al conectarse en la base de datos";   
            }
        }
    
    public function __toString() {
        
    }
    
    public function guardarOsGeneral()
    {
       $strIns = "Insert into OsGeneral (FechaExpedicion,TipoMatto,CodSolicitante,CodUNegocio,"
               . "CodArea,CodGteMatto,Estatus,EstatusDoc,CvePrioridad,DscFallo,CodTipoOS) Values(?,?,?,?,?,?,?,?,?,?,?)"; 
       //echo "Cadena sql ". $strIns;
       //print_r($this->ArrDat);
       $Os = $this->conDb->AddRegistro2 ($strIns, $this->ArrDat,'OsGeneral');
       if($Os > 0){
          $dev = "OS Agregada <br>";
          if ($this->EnvioMail($Os,$this->CodGteMatto)){
              $dev = $dev . 'Correo enviado';  
               return $dev; 
          }
       }
       else
           return "No se agrego el registro ...";
    }
    
    
    public function obtenerOSGeneralT($Fini,$Ffin,$EdoDoc,$Prd,$Tmtto,$Uneg,$Gmtto,$Solt)
    {
       if((strlen($Solt) == 0)) $Solt = 'Todos';
       if((strlen($Uneg) == 0)) $Uneg = 'Todos';
       if((strlen($Gmtto) == 0)) $Gmtto = 'Todos';
       
       //echo strlen($Solt) + $Solt;
       $strWhr = " "; 
       $strWhr .= (strcmp($EdoDoc,"Todos"))? " AND EstatusDoc = ".$EdoDoc : "";
       $strWhr .= (strcmp($Prd,"Todos"))? " AND CvePrioridad = ".$Prd : "";
       $strWhr .= (strcmp($Tmtto,"Todos"))? " AND TipoMatto = '".$Tmtto."'" : "";
       $strWhr .= (strcmp($Uneg,"Todos"))? "  AND  O.CodUNegocio = '".$Uneg."'" : "";
       $strWhr .= (strcmp($Gmtto,"Todos"))? " AND O.CodGteMatto = '".$Gmtto."'" : "";
       $strWhr .= (strcmp($Solt,"Todos") )? " AND  O.CodSolicitante = '".$Solt."'" : "";
       
       $strSlc = "select Folio,FechaExpedicion,TipoMatto,U.Nombre as UNegocio,A.Nombre as Area,
                  S.Nombre as Solicitante,G.Nombre as GerenteM,
                    Case EstatusDoc
                       when 1 then 'Creado'
                       when 2 then 'Atendido'
                       when 3 then 'Terminado'
                       when 4 then 'Aceptado'
                       when 5 then 'Rechazado'
                       else ''
                    End as StatusDoc,
                    Case CvePrioridad
                       when '100' then 'Normal'
                       when '200' then 'Media'
                       when '300' then 'Urgente'
                       else ''
                    End as Prioridad,
                    CodGteMatto
                from OsGeneral O Join CatUnidadNegocios U on O.CodUNegocio = U.CodUNegocio
                                 Join CatAreas A on O.CodArea = A.CodArea 
                                 join CatSolicitantes S on O.CodSolicitante = S.CodSolicitante
                                 join CatGteMatto G on  O.CodGteMatto = G.CodGteMtto 
                where FechaExpedicion between '".$Fini ."' and '".$Ffin."' " . $strWhr;       
     
       //echo $strSlc;
       $rsp = $this->conDb->loadQueryARR_Asoc($strSlc); 
     
        if (count($rsp) > 0){ 
            return $rsp;
        }   
       else 
           return  $rsp;//'no hay registros que mostrar ....';
    }
    
    
    public function obtenerOsGeneralB($cmpBusc)
    {
       $strSlc = "Select * from CatUnidadNegocios where CodUNegocio like '%".$cmpBusc."%' or "
               . " nombre like '%".$cmpBusc."%'"; 
       $rsp = $this->conDb->loadQueryARR_Asoc($strSlc); 
       //print_r($rsp);
        if (count($rsp) > 0){ 
            return $rsp;
        }   
       else 
           return 'no hay registros que mostrar ....';
    }
    
    public function obtenerOsGeneral1($cmpBusc)
    {
       $strSlc = "Select * from CatUnidadNegocios where CodUNegocio = '".$cmpBusc."' ";  
       
       $rsp = $this->conDb->loadQueryARR_Asoc($strSlc); 
       //print_r($rsp);
        if (count($rsp) > 0){ 
            return $rsp;
        }   
       else 
           return 'no hay registros que mostrar ....';
    }
    
    
    /*Para llenar el combo de unidad de negocios */
    public function obtenerOsG_CatUNeg()
    {
        $strUneg = "Select CodUNegocio,Nombre from CatUnidadNegocios order by CodUNegocio";
        $rsp = $this->conDb->loadQueryARR_Asoc($strUneg); 
     
        if (count($rsp) > 0){ 
            return $rsp;
        }   
       else 
           return  $rsp;//'n
    }
    
    
     public function obtenerOsG_CatSol()
     {
        $strUneg = "Select CodSolicitante,Nombre from CatSolicitantes order by CodSolicitante";
        $rsp = $this->conDb->loadQueryARR_Asoc($strUneg); 
     
        if (count($rsp) > 0){ 
            return $rsp;
        }   
       else 
           return  $rsp;//'n
     }
     
     
    public function obtenerOsG_CatArea()
     {
        $strUneg = "Select CodArea,Nombre from CatAreas order by CodArea";
        $rsp = $this->conDb->loadQueryARR_Asoc($strUneg); 
     
        if (count($rsp) > 0){ 
            return $rsp;
        }   
       else 
           return  $rsp;//'n
     }
     
     
    public function obtenerOsG_CatGteM()
    {
       $strUneg = "Select CodGteMtto,Nombre from CatGteMatto order by CodGteMtto";
       $rsp = $this->conDb->loadQueryARR_Asoc($strUneg); 
     
        if (count($rsp) > 0){ 
            return $rsp;
        }   
       else 
           return  $rsp;
    }
     
   public function obtenerOsG_CatTipoOS()
   {
       $strUneg = "select * from CatTipoOS";
       $rsp = $this->conDb->loadQueryARR_Asoc($strUneg); 
     
        if (count($rsp) > 0){ 
            return $rsp;
        }   
       else 
           return  $rsp; 
   }
    
   
   
    public function obtenerOsG($os,$estdoc)
    {
        if ($estdoc == 1)
        {
            $strSql = "select os.Folio,os.FechaExpedicion,Un.Nombre as UNeg,Ar.Nombre as Area,Sl.Nombre as Sol,os.DscFallo,
                       isnull(Tos.Descripcion,'')as DscTipoOS, isnull(Tos.CodTipoOS,'') as CodTipoOS
                     from osGeneral os join CatUnidadNegocios Un on os.CodUNegocio = Un.CodUNegocio
                       join CatAreas Ar on os.CodArea = Ar.CodArea
                       Join CatSolicitantes Sl on os.CodSolicitante = Sl.CodSolicitante  
                       Left Join CatTipoOS Tos on os.CodTipoOS = Tos.CodTipoOS
                   where os.Folio = ".$os; 
        }
        else if($estdoc == 2)
        {
             $strSql = "select Top 1 os.Folio,os.FechaExpedicion,Un.Nombre as UNeg,Ar.Nombre as Area,Sl.Nombre as Sol,os.DscFallo,
                        isnull(Tos.Descripcion,'')as DscTipoOS,os.FechaPrometida,Ce.Nombre as Emp,os.DscAtendido,
                        dbo.strUnMaqP(".$os.") as UnidadVh,os.CodTipoOS,Uas.FecAsignacion
                        from osGeneral os join CatUnidadNegocios Un on os.CodUNegocio = Un.CodUNegocio
                          join CatAreas Ar on os.CodArea = Ar.CodArea
                          Join CatSolicitantes Sl on os.CodSolicitante = Sl.CodSolicitante   
                          left join CatEmpleados Ce    on os.CodEmpleado = Ce.CodEmpleado 
                          Left Join CatTipoOS Tos on os.CodTipoOS = Tos.CodTipoOS  
                          left Join OSUniMaqPesada Uas on  os.Folio = Uas.FolioOS    
                      where os.Folio = ".$os; 
        }
        else if($estdoc == 3)
        {
           $strSql = "select os.Folio,Case EstatusDoc
                            when 1 then 'Creado'
                            when 2 then 'Atendido'
                            when 3 then 'Terminado'
                            when 4 then 'Aceptado'
                            when 5 then 'Rechazado'
                            else ''
                         End as StatusDoc,
                         Case CvePrioridad
                            when '100' then 'Normal'
                            when '200' then 'Media'
                            when '300' then 'Urgente'
                         End as Prioridad,
                    os.FechaExpedicion,Un.Nombre as UNeg,Ar.Nombre as Area,Sl.Nombre as Sol,Gt.Nombre as Gte,os.DscFallo,
                    isnull(Tos.Descripcion,'')as DscTipoOS,
                    isnull(os.FechaPrometida,'') as FechaPrometida,isnull(Ce.Nombre,'') as Emp,isnull(os.DscAtendido,'') as DscAtendido,
                    isnull(os.FechaTermino,'') as FechaTermino,isnull(os.DscTermino,'') as DscTermino,
                    isnull(os.DscLiberacion,'') as DscLiberacion,dbo.strUnMaqP(".$os.") as UnidadVh
                        from osGeneral os join CatUnidadNegocios Un on os.CodUNegocio = Un.CodUNegocio
                          join CatAreas Ar on os.CodArea = Ar.CodArea
                          Join CatSolicitantes Sl on os.CodSolicitante = Sl.CodSolicitante  
                          Join CatGteMatto Gt on os.CodGteMatto = Gt.CodGteMtto 
                          Left Join CatTipoOS Tos on os.CodTipoOS = Tos.CodTipoOS 
                          left join CatEmpleados Ce    on os.CodEmpleado = Ce.CodEmpleado                          
                      where os.Folio = ".$os;  
        }
        else 
        {
           $strSql = "select top 1 os.Folio,Case EstatusDoc
                            when 1 then 'Creado'
                            when 2 then 'Atendido'
                            when 3 then 'Terminado'
                            when 4 then 'Aceptado'
                            when 5 then 'Rechazado'
                            else ''
                         End as StatusDoc,
                         Case CvePrioridad
                            when '100' then 'Normal'
                            when '200' then 'Media'
                            when '300' then 'Urgente'
                         End as Prioridad,
                    os.FechaExpedicion,Un.Nombre as UNeg,Ar.Nombre as Area,Sl.Nombre as Sol,Gt.Nombre as Gte,os.DscFallo,
                    isnull(Tos.Descripcion,'') as DscTipoOS,
                    isnull(os.FechaPrometida,'') as FechaPrometida,isnull(Ce.Nombre,'') as Emp,isnull(os.DscAtendido,'') as DscAtendido,
                    isnull(os.FechaTermino,'') as FechaTermino,isnull(os.DscTermino,'') as DscTermino,
                    isnull(os.DscLiberacion,'') as DscLiberacion,os.CodEmpleado,os.CodTipoOS, 
                     dbo.strUnMaqP(".$os.") as UnidadVh,Va.FecAsignacion
                        from osGeneral os join CatUnidadNegocios Un on os.CodUNegocio = Un.CodUNegocio
                          join CatAreas Ar on os.CodArea = Ar.CodArea
                          Join CatSolicitantes Sl on os.CodSolicitante = Sl.CodSolicitante  
                          Join CatGteMatto Gt on os.CodGteMatto = Gt.CodGteMtto 
                          Left Join CatTipoOS Tos on os.CodTipoOS = Tos.CodTipoOS 
                          left join CatEmpleados Ce    on os.CodEmpleado = Ce.CodEmpleado
                          left join OSUniMaqPesada Va  on os.Folio = Va.FolioOS
                      where os.Folio = ".$os;  
        }
       
        
         $rsp = $this->conDb->loadQueryARR_Asoc($strSql);
        if (count($rsp) > 0){ 
            return $rsp;
        }   
       else 
           return  $rsp;
    }
    
    public function LlenaCboRel($tbl,$fil)
    {
        $cols = "";
        $condicion = "";
        switch ($tbl){
            case "CatEmpleados": 
                $cols = "CodEmpleado,Nombre"; 
                $condicion = "where ClaveGteMtto = '".$fil."'";
            break;
            case "CatSolicitantes":
                $cols = "CodSolicitante,Nombre"; 
                $condicion = "where CodUNegocio = '".$fil."'";
            break;
            case "CatAreas":
                $cols = "ca.CodArea,ca.Nombre"; 
                $condicion = "CA inner join CatSolicitantes CS on ca.CodArea = cs.CodArea where cs.CodSolicitante = '".$fil."'";
            break;    
        }
        $strSql = "Select ".$cols." from ".$tbl." ".$condicion;
        //echo $strSql;
        $rsp = $this->conDb->loadQueryARR_Asoc($strSql);      
        if (count($rsp) > 0){ 
            return $rsp;
        }   
       else 
           return  $rsp;//'n
    }
    
    
    public function LlenaCboUnidades()
    {        
        $strSql = "select CodUnidad,Descripcion from CatUnidadesVh where Disponible = 1 and Estatus = 1";
        //echo $strSql;
        $rsp = $this->conDb->loadQueryARR_Asoc($strSql);      
        if (count($rsp) > 0){ 
            return $rsp;
        }   
       else 
           return  $rsp;//'n
    }
    
    
    public function CargaCatUniMaqPesada()
    {
      $strSql = "select CodUnidad,Descripcion,TipoVeh from CatUnidadesVh where Estatus = 1 and Disponible = 1";
        //echo $strSql;
        $rsp = $this->conDb->loadQueryARR_Asoc($strSql);      
        if (count($rsp) > 0){ 
            return $rsp;
        }   
       else 
           return  $rsp;//'n  
    }
    
        
    public function AtenderOS($FechaAtencion,$FechaPrometida,$CodEmpleado,$DscAtendido,$EstatusDoc,
                              $NoOS,$CodUnidad,$RegOsUnMaqP,$FechaAsigMaqP,$RegVhFree)
    {
        $strTos = "Select CodTipoOS, CodUnidad from OsGeneral where Folio = ".$NoOS;
        $Tos = $this->conDb->loadQueryARR_Asoc($strTos);
                        
        $ar = explode(",", trim($RegOsUnMaqP,'[]'));
        $arVd = explode(",", trim($RegVhFree,'[]'));
        //print_r($ar);
        //echo "<br>".strchr($ar[0],"|",true)."<br>".strchr($ar[1],"|",true)."<br>en mod<br>";
        
        if ( strcmp ($Tos[0][0]['CodTipoOS'], 'OS100') == 0)
        {
          $strUpAtOs = 'Update OsGeneral set FecAtencion = (?), FechaPrometida = (?),'
                     .'CodEmpleado = (?),DscAtendido = (?), EstatusDoc = (?) Where Folio = (?)';
           $this->ArrDat = array(
                             $FechaAtencion,
                             $FechaPrometida,
                             $CodEmpleado,
                             $DscAtendido,
                             $EstatusDoc,
                             $NoOS
                    );  
           $dv = "";
                if($this->conDb->UpdateRegistro($strUpAtOs, $this->ArrDat)) {
                   $dv .= "Registro Actualizado"; 
                   if ($this->EnvioMailAsig($NoOS)){
                      $dv = $dv . ' Correo enviado';  
                       return $dv; 
                   }
                } 
                else
                   return "No se agrego el registro ...";  
        }
        else // Atiende os de maquinaria pesada
        { 
           $strUpAtOs = 'Update OsGeneral set FecAtencion = (?), FechaPrometida = (?),'
                     .'CodUnidad = (?),DscAtendido = (?), EstatusDoc = (?) Where Folio = (?)';
           $this->ArrDat = array(
                             $FechaAtencion,
                             $FechaPrometida,
                             $CodUnidad,
                             $DscAtendido,
                             $EstatusDoc,
                             $NoOS
                    );  
           $dv = ""; 
           if($this->conDb->UpdateRegistro($strUpAtOs, $this->ArrDat)) {
                   $dv .= "Registro Actualizado"; 
                   //if ($this->ActUnidadesVh($CodUnidad,0) == 1){
                                   
                     for($k = 0; $k < count($ar); $k++)
                       {
                           $strIns = "Insert into OSUniMaqPesada (FolioOS,CodUnidad,FecAsignacion)Values(".$NoOS.
                                   ",'".strchr(trim($ar[$k],'"'),"|",true)."','".$FechaAsigMaqP."')";
                           echo $strIns . "<br>";
                           if($this->conDb->QueryDml($strIns) != 0){
                               if ($this->ActUnidadesVh(strchr(trim($ar[$k],'"'),"|",true),0) == 0){
                                   $dv = $dv . "ERROR al actualizar en campo disponible la tabla CatUnidadesVh"; 
                                   return $dv; 
                                }
                               else
                                 $dv = $dv . ' Unidad Vh '.$CodUnidad.'Actualiza';    
                           }
                       }     
                     
                        //print_r($arVd);
                        for($k = 0; $k < count($arVd); $k++)
                          {
                            $strDel = "Delete from OSUniMaqPesada Where FolioOS = ".$NoOS." and ".
                                    "CodUnidad = '".strchr(trim($arVd[$k],'"'),"|",true)."'";
                            echo $strDel . '<br>';
                            if($this->conDb->QueryDml($strDel) != 0)
                             {
                                if ($this->ActUnidadesVh(strchr(trim($arVd[$k],'"'),"|",true),1) == 0)
                                 {
                                   $dv = $dv . "ERROR al actualizar en campo disponible la tabla CatUnidadesVh"; 
                                   return $dv; 
                                 }
                                 else
                                      $dv = $dv . ' Unidad Vh '.$CodUnidad.'Actualiza';  
                             }
                             else
                              {
                                 $dv = $dv . "ERROR al actualizar en campo disponible la tabla CatUnidadesVh"; 
                                 return $dv; 
                              }
                          }
                    
                       
                     
                       return $dv; 
                   
                       
                    //}
                   
                } 
            else
              return "No se agrego el registro ...";
         } 
    }
    
    
    public function TerminarOS($FecTerminoCap,$FechaTermino,$DscTermino,$EstatusDoc,$NoOS,$UnMaqP)
    {
       $strTos = "Select CodTipoOS, CodUnidad from OsGeneral where Folio = ".$NoOS;
       $Tos = $this->conDb->loadQueryARR_Asoc($strTos);   
       
       $ar = explode(",", trim($UnMaqP,'[]'));
        
       $strUpAtOs = 'Update OsGeneral set FecTerminoCap = (?), FechaTermino = (?),'
                     .' DscTermino = (?), EstatusDoc = (?) Where Folio = (?)';
        $this->ArrDat = array(
                             $FecTerminoCap,
                             $FechaTermino,
                             $DscTermino,                             
                             $EstatusDoc,
                             $NoOS
                    );  
        $dv = "";
        if($this->conDb->UpdateRegistro($strUpAtOs, $this->ArrDat)) {
           $dv .= "Registro Actualizado "; 
           
           //Si la os es de maquinaria pesasa liberar la unidad al terminar la os
          if ( strcmp ($Tos[0][0]['CodTipoOS'], 'OS200') == 0)
           {
               /*
               $strVh = "Update CatUnidadesVh set Disponible = (?) where CodUnidad = (?)";               
               $this->ArrDat = array(1,$Tos[0][0]['CodUnidad']);
               if($this->conDb->UpdateRegistro($strVh, $this->ArrDat))
                   $dv .="Unidad Liberada ";   
                *  Probar la afecatacion liberacion y actualizacion de la unidad
                */   
                 for($k = 0; $k < count($ar); $k++)
                  {
                     $strIns = "Update OSUniMaqPesada set FecLiberacion = '".$FechaTermino
                                . "' Where FolioOS = ".$NoOS;                        
                                
                           if($this->conDb->QueryDml($strIns) == 0){
                             $dv = $dv . "ERROR al actualizar la tabla OSUniMaqPesada"; 
                             return $dv;
                           } 
                           else{
                               if ($this->ActUnidadesVh(strchr(trim($ar[$k],'"'),"|",true),1) == 0){
                                   $dv = $dv . "ERROR al actualizar en campo disponible la tabla CatUnidadesVh"; 
                                   return $dv; 
                               }
                           }
                  }
           }
           
           if ($this->EnvioMailTer($NoOS)){
              $dv = $dv . ' Correo enviado';  
               return $dv; 
           }
        } 
        else
           return "No se agrego el registro ..."; 
    }
    
    
     public function AceptarOS($FecLiberacion,$DscLiberacion,$EstatusDoc,$NoOS)
    {
       $strUpAtOs = 'Update OsGeneral set FecLiberacion = (?), DscLiberacion = (?),'
                     .' EstatusDoc = (?) Where Folio = (?)';
       
        $this->ArrDat = array(
                             $FecLiberacion,
                             $DscLiberacion,                                                  
                             $EstatusDoc,
                             $NoOS
                    );  
        
        if($this->conDb->UpdateRegistro($strUpAtOs, $this->ArrDat))             
          return "Registro Actualizado"; 
        else
           return "No se agrego el registro ..."; 
    }
    
    
    
    
    
    public function DeleteOS($os)
    {
        $strDlt = "delete from OsGeneral where Folio = ".$os;
        $rsp = $this->conDb->QueryDml( $strDlt); 
        //print $rsp;
        if ($rsp > 0){ 
            return 'Registro eliminado';
        }   
       else 
           return 'no hay registros que eliminar ....';
    }
    
    
    public function Obterner_Seg($CodPantalla,$CodPerfil)
    {
        $strSeg = "select A.CodPerfil,P.CodPantalla,A.CodProceso,P.Descripcion,A.Acceso  
                     from SgAccesos A join  SgProcesos P on A.CodProceso = P.CodProceso
                                                         and P.CodPantalla = '".$CodPantalla."' ".
                     " where A.CodPerfil = '".$CodPerfil."'  order by CodProceso";
            
        $rsp = $this->conDb->loadQueryARR_Asoc($strSeg); 
        
        if (count($rsp) > 0){ 
            return $rsp;
        }   
       else 
           return  $rsp;//'n
    }
    
    /*
    public function DeleteOsGeneral($coduneg)
    {
        $strDlt = "delete from CatUnidadNegocios where CodUNegocio = '".$coduneg."'";
        
        $rsp = $this->conDb->QueryDml( $strDlt); 
        //print $rsp;
        if (count($rsp) > 0){ 
            return 'Registro eliminado';
        }   
       else 
           return 'no hay registros que eliminar ....';
    }
    
    public function UpdateOsGeneral()
    {
        $strUpd = 'Update CatUnidadNegocios set Nombre = (?), Obs = (?) '
                . ' where CodUNegocio = (?)'; 
       $this->ArrDat = array(
                             $this->Nombre,
                             $this->Obs,
                             $this->CodUNegocio
                    ); 
        
       if($this->conDb->UpdateRegistro($strUpd, $this->ArrDat))             
          return "Registro Actualizado"; 
       else
           return "No se agrego el registro ...";
        
    }
    */
    
   
    public function EnvioMail($OsGen,$CgMtto)
    {
      $SlcRecParam = "Select NombreParametro,Valor from ParametrosSys where NombreParametro like 'mail%'";
      $rsp = $this->conDb->loadQueryARR_AsocPrm($SlcRecParam);
      
      $SlcGetDatGte = "select 'Email' as NombreParametro,Email as Valor from CatGteMatto where CodGteMtto = '".$CgMtto."'";
      $rdg = $this->conDb->loadQueryARR_AsocPrm($SlcGetDatGte);
      
      //$SlcPrioridad = "Select 'DscPrioridad' as NombreParametro, Descripcion as Valor  from CatPrioridad where CvePrioridad = '".$CvePrioridad."'";
      //$rPri = $this->conDb->loadQueryARR_AsocPrm($SlcPrioridad);
      
      $os1 = $this->obtenerOsG($OsGen,3);     
      //echo "<br>UnidadNeg: ".$os1[0][0]["UNeg"];
     
      $mail = new PHPMailer();
      $mail->isSMTP();
      $mail->Host = $rsp['mailServidor'];
        //Set the SMTP port number - likely to be 25, 465 or 587
      $mail->Port = $rsp['mailPuerto'];
        //Whether to use SMTP authentication
      $mail->SMTPAuth = true;
        //Username to use for SMTP authentication
      $mail->Username = $rsp['mailUsuario'];
        //Password to use for SMTP authentication
      $mail->Password = $rsp['mailPassword'];
      $mail->SMTPSecure = 'tls';
      
      
      $mail->setFrom($rsp['mailCuenta'], 'Ordenes de Servicio');
        //Set an alternative reply-to address
        //  $mail->addReplyTo('correo@dominio.tld', 'Magic');
        //Set who the message is to be sent to
      $mail->addAddress($rdg['Email'], 'Gerente de Mtto');

        //Set the subject line
        $mail->Subject = 'Orden de Servicio '.$OsGen.' por atender, Prioridad: '.$os1[0][0]["Prioridad"];
        $mail->isHTML(true);
        $mailContent = "<h1>Tienes una Orden de Servicio generada para tu departamento No.OS: ".$OsGen. "</h1><br>".
           "<h2><strong>Prioridad:</strong> ".$os1[0][0]["Prioridad"]."</h2>".
           "<h2><strong>Unidad de Negocio:</strong> ".$os1[0][0]["UNeg"]."</h2>".
           "<h2><strong>Area:</strong> ".$os1[0][0]["Area"]."</h2>".
           "<h2><strong>Solicitante:</strong> ".$os1[0][0]["Area"]."</h2>".
           "<h2><strong>Dsc. Fallo:</strong> ".$os1[0][0]["DscFallo"]."</h2>".
           "<p>Correo enviado automaticamente por el sistema de OS's</p>";
        $mail->Body = $mailContent;
         if (!$mail->send()) {
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
            return 0;
         } 
         else {
            //echo 'Message sent!';
            return 1;
         }
    }
    
    
    
    public function EnvioMailAsig($OsGen)
    {
       $SlcRecParam = "Select NombreParametro,Valor from ParametrosSys where NombreParametro like 'mail%'";
       $rsp = $this->conDb->loadQueryARR_AsocPrm($SlcRecParam);
       $os1 = $this->obtenerOsG($OsGen,3); 
      
       $SlcGetDatEmp = "select 'Email' as NombreParametro,Email as Valor from CatEmpleados where CodEmpleado = ( " 
                                             ." select  CodEmpleado from OsGeneral where Folio =".$OsGen.")";
        $rdg = $this->conDb->loadQueryARR_AsocPrm($SlcGetDatEmp);
        
       if(strlen($rdg['Email']) > 0){        
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = $rsp['mailServidor'];
             //Set the SMTP port number - likely to be 25, 465 or 587
            $mail->Port = $rsp['mailPuerto'];
             //Whether to use SMTP authentication
            $mail->SMTPAuth = true;
             //Username to use for SMTP authentication
            $mail->Username = $rsp['mailUsuario'];
             //Password to use for SMTP authentication
            $mail->Password = $rsp['mailPassword'];
            $mail->SMTPSecure = 'tls';


            $mail->setFrom($rsp['mailCuenta'], 'Ordenes de Servicio');
             //Set an alternative reply-to address
             //  $mail->addReplyTo('correo@dominio.tld', 'Magic');
             //Set who the message is to be sent to
            $mail->addAddress($rdg['Email'], 'Empleado ');



             //Set the subject line
             $mail->Subject = 'Tienes la Orden de Servicio '.$OsGen.' asignada, Prioridad: '.$os1[0][0]["Prioridad"];
             $mail->isHTML(true);
             $mailContent = "<h1>Tienes una Orden de Servicio generada para tu departamento No.OS: ".$OsGen. "</h1><br>".
                "<h2><strong>Prioridad:</strong> ".$os1[0][0]["Prioridad"]."</h2>".
                "<h2><strong>Unidad de Negocio:</strong> ".$os1[0][0]["UNeg"]."</h2>".
                "<h2><strong>Area:</strong> ".$os1[0][0]["Area"]."</h2>".
                "<h2><strong>Solicitante:</strong> ".$os1[0][0]["Area"]."</h2>".
                "<h2><strong>Dsc. Fallo:</strong> ".$os1[0][0]["DscFallo"]."</h2>".

                //Datos de la atencion      
                "<h2><strong>Instrucciones:</strong> ".$os1[0][0]["DscAtendido"]."</h2>".
                "<p>Correo enviado automaticamente por el sistema de OS's</p>";               


             $mail->Body = $mailContent;
              if (!$mail->send()) {
                 //echo 'Mailer Error: ' . $mail->ErrorInfo;
                 return 0;
              } 
              else {
                 //echo 'Message sent!';
                 return 1;
              }
       }
        
    }
    
    
    
    
    
    //Envia correo al gerente del area
    public function EnvioMailTer($OsGen)
    {
      $SlcRecParam = "Select NombreParametro,Valor from ParametrosSys where NombreParametro like 'mail%'";
      $rsp = $this->conDb->loadQueryARR_AsocPrm($SlcRecParam);
      
       $os1 = $this->obtenerOsG($OsGen,3); 
      
      $SlcGetDatSol = "select 'Email' as NombreParametro,Email as Valor from CatSolicitantes where CodSolicitante = ( " 
                                             ." select  CodSolicitante from OsGeneral where Folio =".$OsGen.")";
      $rdg = $this->conDb->loadQueryARR_AsocPrm($SlcGetDatSol);
      
      //$SlcPrioridad = "Select 'DscPrioridad' as NombreParametro, Descripcion as Valor  from CatPrioridad where CvePrioridad = '".$CvePrioridad."'";
      //$rPri = $this->conDb->loadQueryARR_AsocPrm($SlcPrioridad);
      
         
      //echo "<br>UnidadNeg: ".$os1[0][0]["UNeg"];
     
      $mail = new PHPMailer();
      $mail->isSMTP();
      $mail->Host = $rsp['mailServidor'];
        //Set the SMTP port number - likely to be 25, 465 or 587
      $mail->Port = $rsp['mailPuerto'];
        //Whether to use SMTP authentication
      $mail->SMTPAuth = true;
        //Username to use for SMTP authentication
      $mail->Username = $rsp['mailUsuario'];
        //Password to use for SMTP authentication
      $mail->Password = $rsp['mailPassword'];
      $mail->SMTPSecure = 'tls';
      
      
      $mail->setFrom($rsp['mailCuenta'], 'Ordenes de Servicio');
        //Set an alternative reply-to address
        //  $mail->addReplyTo('correo@dominio.tld', 'Magic');
        //Set who the message is to be sent to
      $mail->addAddress($rdg['Email'], 'Gerente de U. Negocio');
             
      $d = $os1[0][0]["FechaTermino"];
  
        //Set the subject line
        $mail->Subject = 'Orden de Servicio '.$OsGen.' que genero ya esta Terminada, Prioridad: '.$os1[0][0]["Prioridad"];
        $mail->isHTML(true);
        $mailContent = "<h1>Tienes una Orden de Servicio generada para tu departamento No.OS: ".$OsGen. "</h1><br>".
           "<h2><strong>Prioridad:</strong> ".$os1[0][0]["Prioridad"]."</h2>".
           "<h2><strong>Unidad de Negocio:</strong> ".$os1[0][0]["UNeg"]."</h2>".
           "<h2><strong>Area:</strong> ".$os1[0][0]["Area"]."</h2>".
           "<h2><strong>Solicitante:</strong> ".$os1[0][0]["Area"]."</h2>".
           "<h2><strong>Dsc. Fallo:</strong> ".$os1[0][0]["DscFallo"]."</h2>".
         //poner Datos del termino de la os. 
           "<h2><strong>Fecha Termino:</strong> ".$d->format('Y-m-d')."</h2>".     
           "<h2><strong>Dsc. Termino:</strong> ".$os1[0][0]["DscTermino"]."</h2>".
           "<p>Correo enviado automaticamente por el sistema de OS's</p>";
        $mail->Body = $mailContent;
         if (!$mail->send()) {
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
            return 0;
         } 
         else {
            //echo 'Message sent!';
            return 1;
         }
    }
   
    //Cambie es estatus de la unidad a disponible o no disponible
    public function ActUnidadesVh($codUnidad,$valor)
    {
        $strUpUVh = 'Update CatUnidadesVh set Disponible = (?)'
                     .' Where CodUnidad = (?)';
           $this->ArrDat = array(
                             $valor,                             
                             $codUnidad
                    );  
           if($this->conDb->UpdateRegistro($strUpUVh, $this->ArrDat))             
                return 1; 
           else
                 return 0; 
    }
    
    
}
