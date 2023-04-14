<?php
include_once("../ClsParam.php"); 
include_once("../ClsMsSql.php");

//echo phpinfo();
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
//date_default_timezone_set('Etc/UTC');

//Create a new PHPMailer instance
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

class modSolicitud {
    private $codEmpleado;
    private $nombre;
    private $apeP;
    private $apeM;
    private $fecNac;
    private $tArea;
    private $tDep;
    private $tCarg;
    private $tBen;
    private $tJor;
    private $fecIni;
    private $fecFin;
    private $cubN;
    private $FechaSol;
    private $fecSol;
    private $fecGuard;
    private $CantidadSol;
    private $FecSolicitud;
    private $IdSeguro;
    private $Marca;
    private $Modelo;
    private $Anio;
    private $NumPuertas;
    private $Placas;
    private $Factura;
    private $TarCirculacion;
    private $NumSerie;
    private $NumMotor;
    private $FecSol;
    private $FecAutorizacion;
    private $Monto;
    private $Fuma;
    private $Toma;
    private $MontoS;
    private $MontoD;
    private $MontoAut;
    private $MontoDesAut;
    private $CodAut;
    private $Act;
    private $Url;

    //prestamo
    //FechaExpedicion,CodEmpleado,CodArea,CodSubArea,CodPuesto,Sueldo,CantidadSolicita,Motivo
    private $FechaExpedicion;
    private $CodEmpleado;
    private $CodArea;
    private $CodSubArea;
    private $CodPuesto;
    private $Sueldo;
    private $CantidadSolicita;
    private $Motivo;
    //update prestamo
    private $CantidadAutorizada;
    private $Descuento;
    private $Autorizado;
    private $FechaAutorizacion;
    private $Estatus;
    private $FechaCaptura;
    
    
    private $ArrDat;

    var $conDb;
    var $objParam;
    
    public function getcodEmpleado() {
        return $this->codEmpleado;
    }

    public function getnombre() {
        return $this->nombre;
    }

    public function getapeP() {
        return $this->apeP;
    }

    public function getapeM() {
        return $this->apeM;
    }

    public function getfecNac() {
        return $this->fecNac;
    }

    public function gettArea() {
        return $this->tArea;
    }

    public function gettDep() {
        return $this->tDep;
    }

    public function gettCarg() {
        return $this->tCarg;
    }

    public function gettBen() {
        return $this->tBen;
    }

    public function gettJor() {
        return $this->tJor;
    }

    public function getfecIni() {
        return $this->fecIni;
    }

    public function getfecFin() {
        return $this->fecFin;
    }

    public function getcubN() {
        return $this->cubN;
    }

    public function getFechaSol() {
        return $this->FechaSol;
    }

    public function getfecSol() {
        return $this->fecSol;
    }

    public function getfecGuard() {
        return $this->fecGuard;
    }

    public function getCantidadSol() {
        return $this->CantidadSol;
    }

    public function getFecSolicitud() {
        return $this->FecSolicitud;
    }

    public function getIdSeguro() {
        return $this->IdSeguro;
    }

    public function getMarca() {
        return $this->Marca;
    }

    public function getModelo() {
        return $this->Modelo;
    }

    public function getAnio() {
        return $this->Anio;
    }

    public function getNumPuertas() {
        return $this->NumPuertas;
    }

    public function getPlacas() {
        return $this->Placas;
    }

    public function getFactura() {
        return $this->Factura;
    }

    public function getTarCirculacion() {
        return $this->TarCirculacion;
    }

    public function getNumSerie() {
        return $this->NumSerie;
    }

    public function getNumMotor() {
        return $this->NumMotor;
    }

    public function getFecAutorizacion() {
        return $this->FecAutorizacion;
    }

    public function getMonto() {
        return $this->Monto;
    }

    public function getFuma() {
        return $this->Fuma;
    }

    public function getToma() {
        return $this->Toma;
    }

    public function getMontoS() {
        return $this->MontoS;
    }

    public function getMontoD() {
        return $this->MontoD;
    }

    public function getMontoAut() {
        return $this->MontoAut;
    }

    public function getMontoDesAut() {
        return $this->MontoDesAut;
    }

    public function getCodAut() {
        return $this->CodAut;
    }

    public function getAct() {
        return $this->Act;
    }

    public function getUrl() {
        return $this->Url;
    }

    //prestamo
    //FechaExpedicion,CodEmpleado,CodArea,CodSubArea,CodPuesto,Sueldo,CantidadSolicita,Motivo
    public function getFechaExpedicion() {
        return $this->FechaExpedicion;
    }

    public function getCodArea() {
        return $this->CodArea;
    }

    public function getCodSubArea() {
        return $this->CodSubArea;
    }

    public function getCodPuesto() {
        return $this->CodPuesto;
    }

    public function getSueldo() {
        return $this->Sueldo;
    }

    public function getCantidadSolicita() {
        return $this->CantidadSolicita;
    }

    public function getMotivo() {
        return $this->Motivo;
    }

    public function getCantidadAutorizada() {
        return $this->CantidadAutorizada;
    }

    public function getDescuento() {
        return $this->Descuento;
    }

    public function getAutorizado() {
        return $this->Autorizado;
    }

    public function getFechaAutorizacion() {
        return $this->FechaAutorizacion;
    }

    public function getEstatus() {
        return $this->Estatus;
    }

    public function getFechaCaptura() {
        return $this->FechaCaptura;
    }

    public function setcodEmpleado($codEmpleado) {
        $this->codEmpleado = $codEmpleado;
    }

    public function setnombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setapeP($apeP) {
        $this->apeP = $apeP;
    }

    public function setapeM($apeM) {
        $this->apeM = $apeM;
    }

    public function setfecNac($fecNac) {
        $this->fecNac = $fecNac;
    }

    public function settArea($tArea) {
        $this->tArea = $tArea;
    }

    public function settDep($tDep) {
        $this->tDep = $tDep;
    }

    public function settCarg($tCarg) {
        $this->tCarg = $tCarg;
    }

    public function settBen($tBen) {
        $this->tBen = $tBen;
    }

    public function settJor($tJor) {
        $this->tJor = $tJor;
    }

    public function setfecIni($fecIni) {
        $this->fecIni = $fecIni;
    }

    public function setfecFin($fecFin) {
        $this->fecFin = $fecFin;
    }

    public function setcubN($cubN) {
        $this->cubN = $cubN;
    }

    public function setFechaSol($FechaSol) {
        $this->FechaSol = $FechaSol;
    }

    public function setfecSol($fecSol) {
        $this->fecSol = $fecSol;
    }

    public function setfecGuard($fecGuard) {
        $this->fecGuard = $fecGuard;
    }

    public function setCantidadSol($CantidadSol) {
        $this->CantidadSol = $CantidadSol;
    }

    public function setFecSolicitud($FecSolicitud) {
        $this->FecSolicitud = $FecSolicitud;
    }

    public function setIdSeguro($IdSeguro) {
        $this->IdSeguro = $IdSeguro;
    }

    public function setMarca($Marca) {
        $this->Marca = $Marca;
    }

    public function setModelo($Modelo) {
        $this->Modelo = $Modelo;
    }

    public function setAnio($Anio) {
        $this->Anio = $Anio;
    }

    public function setNumPuertas($NumPuertas) {
        $this->NumPuertas = $NumPuertas;
    }

    public function setPlacas($Placas) {
        $this->Placas = $Placas;
    }

    public function setFactura($Factura) {
        $this->Factura = $Factura;
    }

    public function setTarCirculacion($TarCirculacion) {
        $this->TarCirculacion = $TarCirculacion;
    }

    public function setNumSerie($NumSerie) {
        $this->NumSerie = $NumSerie;
    }

    public function setNumMotor($NumMotor) {
        $this->NumMotor = $NumMotor;
    }

    public function setMonto($Monto) {
        $this->Monto = $Monto;
    }

    public function setFuma($Fuma) {
        $this->Fuma = $Fuma;
    }

    public function setToma($Toma) {
        $this->Toma = $Toma;
    }

    public function setMontoS($MontoS) {
        $this->MontoS = $MontoS;
    }

    public function setMontoD($MontoD) {
        $this->MontoD = $MontoD;
    }

    public function setMontoAut($MontoAut) {
        $this->MontoAut = $MontoAut;
    }

    public function setMontoDesAut($MontoDesAut) {
        $this->MontoDesAut = $MontoDesAut;
    }

    public function setCodAut($CodAut) {
        $this->CodAut = $CodAut;
    }

    public function setFecAutorizacion($FecAutorizacion) {
        $this->FecAutorizacion = $FecAutorizacion;
    }

    public function setAct($Act) {
        $this->Act = $Act;
    }

    public function setUrl($Url) {
        $this->Url = $Url;
    }
    //prestamo
    //FechaExpedicion,CodEmpleado,CodArea,CodSubArea,CodPuesto,Sueldo,CantidadSolicita,Motivo

    public function setFechaExpedicion($FechaExpedicion) {
        $this->FechaExpedicion = $FechaExpedicion;
    }

    public function setCodArea($CodArea) {
        $this->CodArea = $CodArea;
    }

    public function setCodSubArea($CodSubArea) {
        $this->CodSubArea = $CodSubArea;
    }

    public function setCodPuesto($CodPuesto) {
        $this->CodPuesto = $CodPuesto;
    }

    public function setSueldo($Sueldo) {
        $this->Sueldo = $Sueldo;
    }

    public function setCantidadSolicita($CantidadSolicita) {
        $this->CantidadSolicita = $CantidadSolicita;
    }

    public function setMotivo($Motivo) {
        $this->Motivo = $Motivo;
    }

    public function setCantidadAutorizada($CantidadAutorizada) {
        $this->CantidadAutorizada = $CantidadAutorizada;
    }

    public function setDescuento($Descuento) {
        $this->Descuento = $Descuento;
    }

    public function setAutorizado($Autorizado) {
        $this->autorizado = $Autorizado;
    }

    public function setFechaAutorizacion($FechaAutorizacion) {
        $this->FechaAutorizacion = $FechaAutorizacion;
    }

    public function setEstatus($Estatus) {
        $this->Estatus = $Estatus;
    }

    public function setFechaCaptura($FechaCaptura) {
        $this->FechaCaptura = $FechaCaptura;
    }

    //prestamo
    //FechaExpedicion,CodEmpleado,CodArea,CodSubArea,CodPuesto,Sueldo,CantidadSolicita,Motivo
        public function __construct($codEmpleado,$nombre, $apeP, $apeM,$fecNac,$tArea,$tDep,$tCarg,$tBen,$tJor,$fecIni,$fecFin,$cubN,$FechaSol,$fecSol,$fecGuard,$CantidadSol,$FecSolicitud,$IdSeguro,$Marca,$Modelo,$Anio,$NumPuertas,$Placas,$Factura,$TarCirculacion,$NumSerie,$NumMotor,$FecAutorizacion,$Monto,$Fuma,$Toma,$MontoS,$MontoD,$MontoAut,$MontoDesAut,$CodAut,$Act,$Url,$FechaExpedicion,$CodEmpleado,$CodArea,$CodSubArea,$CodPuesto,$Sueldo,$CantidadSolicita,$Motivo,$CantidadAutorizada,$Descuento,$Autorizado,$FechaAutorizacion,$Estatus,$FechaCaptura)
        {
            $this->codEmpleado = $codEmpleado;
            $this->nombre = $nombre;
            $this->apeP = $apeP;
            $this->apeM = $apeM;
            $this->fecNac = $fecNac;
            $this->tArea = $tArea;
            $this->tDep = $tDep;
            $this->tCarg = $tCarg;
            $this->tBen = $tBen;
            $this->tJor = $tJor;
            $this->fecIni = $fecIni;
            $this->fecFin = $fecFin;
            $this->cubN = $cubN;
            $this->FechaSol = $FechaSol;
            $this->fecSol = $fecSol;
            $this->fecGuard = $fecGuard;
            $this->CantidadSol = $CantidadSol;
            $this->FecSolicitud = $FecSolicitud;
            $this->IdSeguro = $IdSeguro;
            $this->Marca = $Marca;
            $this->Modelo = $Modelo;
            $this->Anio = $Anio;
            $this->NumPuertas = $NumPuertas;
            $this->Placas = $Placas;
            $this->Factura = $Factura;
            $this->TarCirculacion = $TarCirculacion;
            $this->NumSerie = $NumSerie;
            $this->NumMotor = $NumMotor;
            $this->FecAutorizacion = $FecAutorizacion;
            $this->Monto = $Monto;
            $this->Fuma = $Fuma;
            $this->Toma = $Toma;
            $this->MontoS = $MontoS;
            $this->MontoD = $MontoD;
            $this->MontoAut = $MontoAut;
            $this->MontoDesAut = $MontoDesAut;
            $this->CodAut = $CodAut;
            $this->Act = $Act;
            $this->Url = $Url;
            $this->FechaExpedicion = $FechaExpedicion;
            $this->CodArea = $CodArea;
            $this->CodSubArea = $CodSubArea;
            $this->CodPuesto = $CodPuesto;
            $this->Sueldo = $Sueldo;
            $this->CantidadSolicita = $CantidadSolicita;
            $this->Motivo = $Motivo;
            $this->CantidadAutorizada = $CantidadAutorizada;
            $this->Descuento = $Descuento;
            $this->Autorizado = $Autorizado;
            $this->FechaAutorizacion = $FechaAutorizacion;
            $this->Estatus = $Estatus;
            $this->FechaCaptura = $FechaCaptura;
            $this->ArrDat = array($this->codEmpleado,
                                  $this->nombre,
                                  $this->apeP,
                                  $this->apeM,
                                  $this->fecNac,
                                  $this->tArea,
                                  $this->tDep,
                                  $this->tCarg,
                                  $this->tBen,
                                  $this->tJor,
                                  $this->fecIni,
                                  $this->fecFin,
                                  $this->cubN,
                                  $this->FechaSol,
                                  $this->fecSol,
                                  $this->fecGuard,
                                  $this->CantidadSol,
                                  $this->FecSolicitud,
                                  $this->IdSeguro,
                                  $this->Fuma,
                                  $this->Toma,
                                  $this->MontoS,
                                  $this->MontoD,
                                  $this->Marca,
                                  $this->Modelo,
                                  $this->Anio,
                                  $this->NumPuertas,
                                  $this->Placas,
                                  $this->Factura,
                                  $this->TarCirculacion,
                                  $this->NumSerie,
                                  $this->NumMotor,
                                  $this->FecSol,
                                  $this->FecAutorizacion,
                                  $this->Monto,
                                  $this->Act,
                                  $this->Url,
                                  $this->FechaExpedicion,
                                  $this->CodArea,
                                  $this->CodSubArea,
                                  $this->CodPuesto,
                                  $this->Sueldo,
                                  $this->CantidadSolicita,
                                  $this->Motivo,
                                  $this->CantidadAutorizada,
                                  $this->Descuento,
                                  $this->Autorizado,
                                  $this->FechaAutorizacion,
                                  $this->Estatus,
                                  $this->FechaCaptura
                    );
            //FechaExpedicion,CodEmpleado,CodArea,CodSubArea,CodPuesto,Sueldo,CantidadSolicita,Motivo
            /*
               Ver si se puede conservar la conexion por session, o pasar la cnexion desde la pagina inicial
             *              */
            $this->objParam =  new ClsParam("C:\\NominaW\\configWeb.txt");
            $this->conDb = new ClsmsSql($this->objParam->Servidor,$this->objParam->Usuario,$this->objParam->Datos,$this->objParam->Passw); 
            //echo $this->objParam->Servidor."<br>".$this->objParam->Usuario."<br>".$this->objParam->Datos."<br>".$this->objParam->Passw."<br>";
            
            if ($this->conDb->Conextar() > 0){              
              return "Error al conectarse en la base de datos";   
            }
        }
    
    public function __toString() {
        
    }
    
    public function guardarSol()
    {
        //return "Estas en esta parte";
       $strIns = "Insert into catSolicitudes(codEmpleado,nombre,apeP,apeM,fecNac,tArea,tDep,tCarg,tBen,tJor,fecIni,fecFin,cubN,FechaSol) Values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)"; 
     
       if($this->conDb->AddRegistro ($strIns, $this->ArrDat)){
            alert('Hola perro');
            return "Registro Agregado"; 
       }

       else
           return "No se agrego el registro ...";
    }

//función en donde se guarda la solicitud de la guardia
    public function SaveSolGuar()
    {
		print_r($this->curp);
        //return "Estas en esta parte";
       $strIns = "Insert into CatSolGuardias(codEmpleado,fecSol,fecGuard) Values(?,?,?)"; 
       echo($strIns);
       
       echo($this->ArrDat);
       $this->EnvioSolCar($this->codEmpleado);
       if($this->conDb->AddRegistro ($strIns, $this->ArrDat)){
        alert('Hola perro');
        return "Registro Agregado"; 
        }

        else
            return "No se agrego el registro ...";

        //return $this->ArrDat;
           //return "<---->No se agrego el registro ...";
    }
    
    public function SavePres(){
        

        $strIns = "Insert into PresSolPrestamo(FechaExpedicion,CodEmpleado,CodArea,CodSubArea,CodPuesto,Sueldo,CantidadSolicitada,Motivo) Values (?,?,?,?,?,?,?,?)";
        
        //"insert into CatSolPrestamos(CodEmpleado,FecSolicitud,CantidadSol) values(?,?,?)";
        //echo $this->ArrDat;
        //echo $strIns;
        if($this->conDb->AddRegistro ($strIns, $this->ArrDat)){
            $this->actSolPres($this->CodEmpleado);
            return "Registro Agregado"; 
            }
            else
                return $this->ArrDat;
    }
    
    public function SaveSegA(){
        $strIns = "insert into CatSegAuto(IdSeguro,CodEmpleado,Marca,Modelo,Anio,NumPuertas,Placas,Factura,TarCirculacion,NumSerie,NumMotor) values(?,?,?,?,?,?,?,?,?,?,?)";
        echo $this->ArrDat;
        echo $strIns;
        if($this->conDb->AddRegistro ($strIns, $this->ArrDat)){
            alert('Hola perro');
            return "Registro Agregado"; 
            }
    
            else
                return $this->ArrDat;
    }

    public function SaveSegV(){
        $strIns = "insert into catSegVida(IdSeguro,CodEmpleado,Fuma,Toma,MontoS,MontoD) values(?,?,?,?,?,?)";

        //alert($strIns);
        if($this->conDb->AddRegistro ($strIns, $this->ArrDat)){
            alert('Hola perro');
            return "Registro Agregado"; 
            }
    
            else
                return $this->ArrDat;
    }

    public function SaveUp(){
        $strIns = "insert into tblUploadFile(CodEmpleado,Url) values(?,?)";

        //alert($strIns);
        if($this->conDb->AddRegistro ($strIns, $this->ArrDat)){
            alert('Hola perro');
            return "Registro Agregado"; 
            }
    
            else
                return $this->ArrDat;
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
    
    /////////////////////////////GRID AUTORIZACIÓN PRESTAMOS///////////////////////////

    public function muestraPres()
    {
        $strUpd = "select P.CodEmpleado, convert(varchar,P.FechaExpedicion , 101) as Fecha_Solicitud, (E.Nombre +' '+E.ApellidoPaterno+' '+E.ApellidoMaterno) as Nombre,
        P.CodArea, A.Nombre as DescA, P.CodSubArea, Sa.Descripcion as DescSa, P.Sueldo, P.CantidadSolicitada,P.Motivo,E.CodPuesto
        from PresSolPrestamo P
        join CatAreas A on P.CodArea = A.CodArea
        join CatSubAreas Sa on P.CodSubArea = Sa.CodSubArea
        join CatEmpleados E on P.CodEmpleado = E.CodEmpleado
        Where P.Estatus = 0";

        $rsp = $this->conDb->loadQueryARR_Asoc($strUpd); 
       //print_r($rsp);
        if (count($rsp) > 0){ 
            return $rsp;
        }   
        else 
           return 'no hay registros que mostrar ....';
    }

    public function actSolPres($cod){
        $struc = "select folio,foliosiguiente from Documentos where CodDocumento = 'SPRE'";

        $inf = $this->conDb->loadQueryARR_Asoc($struc);
        $folioA;
        $folioN;
        $folioAux;
        foreach($inf as $key => $val){
            //print_r($val[0]["Nombre"]);
            $folioA =$val[0]["folio"];
            $folioN =$val[0]["foliosiguiente"];
            $folioAux =$val[0]["folio"];
       }
       alert($folioA);
       print_r($folioN);
       print_r($folioAux);

       $uos = "update PresSolPrestamo set FolSolPrestamo = (?) where CodEmpleado = (?)";

       $this->ArrDat = array(
                $this->folioA,
                $this->cod
        ); 

        if($this->conDb->UpdateRegistro($uos, $this->ArrDat))             
            
          return "Registro Actualizado"; 
        else
           return "No se agrego el registro ...";
    }

    public function updSolPres(){
        $trisp = 'UPDATE PresSolPrestamo set CantidadAutorizada = (?), Descuento = (?), Autorizado = (?), FechaAutorizacion = GETDATE(), '
        . 'Estatus = (?), FechaCaptura = GETDATE() WHERE CodEmpleado = (?)';

        //print_r($trisp);
        $this->ArrDat = array(
                    $this->CantidadAutorizada,
                    $this->Descuento,
                    $this->Autorizado,
                    $this->Estatus,
                    $this->CodEmpleado
        ); 

        //print_r($this->ArrDat);
        if($this->conDb->UpdateRegistro($trisp, $this->ArrDat)){
            print_r($this->ArrDat);
            /*$strUpd = "Insert into PresPrestamos (FechaExpedicion, FechaAutorizacion,CodEmpleado,CodArea,CodSubArea,CodPuesto,Sueldo,
            MontoSolicitado,Monto,Descuento,DescViaNomina,Estatus) values (?,?,?,?,?,?,?,?,?,?,?,?) ";
            echo $strUpd;
        
            if($this->conDb->AddRegistro ($strUpd, $this->ArrDat))*/
            return "Registro Actualizado de la solicitud";
        }else
          return "No se agrego el registro perro...";
    }

    public function ActualizarPres(){
        print_r($this->CodEmpleado);
        $strUpd = 'UPDATE PresSolPrestamo SET CantidadAutorizada = (?), Descuento = (?), Autorizado = (?), FechaAutorizacion = GETDATE(),'
        . 'Estatus = (?), FechaCaptura = GETDATE() WHERE CodEmpleado = (?)';
       // echo $strUpd;
        $this->ArrDat = array(
                    $this->CantidadAutorizada,
                    $this->Descuento,
                    $this->Autorizado,
                    $this->Estatus,
                    $this->CodEmpleado
                );
        
       // print_r($this->ArrDat);
        if($this->conDb->UpdateRegistro($strUpd, $this->ArrDat))
        return "Registro Actualizado";
        else
        return "No se agrego el registro perro...";
    }

	//envio de correos electronicos

public function EnvioSolCar($adm)
     { 
      $SlcGetDatGte = "select 'Email' as NombreParametro, Email as Valor from CatEmpleados where Curp = 'PEMG861212MCSRND13'";
	  
	  echo $SlcGetDatGte;
      $rdg = $this->conDb->loadQueryARR_AsocPrm($SlcGetDatGte);
      
      $Info = "Select (E.Nombre +' '+E.ApellidoPaterno+' '+E.ApellidoMaterno) as Nombre
               from CatEmpleados E 
               where E.CodEmpleado = '".$adm."'";
	 echo $Info;
     $inf = $this->conDb->loadQueryARR_Asoc($Info);
     //print_r($Info);
     $nombre;
     $fecI;
     $fecF;
     $Gerente;
     $NGerente;
     $CelGe;
     foreach($inf as $key => $val){
          //print_r($val[0]["Nombre"]);
          $nombre =$val[0]["Nombre"];
     }

     echo $nombre;
      $mail = new PHPMailer();
      $mail->isSMTP();
      $mail->Host = 'grupoavimarca.com';
        //Set the SMTP port number - likely to be 25, 465 or 587
      $mail->Port = '587';
      $mail->SMTPAuth = true;
        //Username to use for SMTP authentication
      $mail->Username = 'nominaweb';
        //Password to use for SMTP authentication
      $mail->Password = 'NqtuEf3S17T6GcD';
      $mail->SMTPSecure = 'tls';
      
      
      $mail->setFrom('nominaweb@grupoavimarca.com', 'Solicitud de dia de guardia');
        //Set an alternative reply-to address
        //  $mail->addReplyTo('correo@dominio.tld', 'Magic');
        //Set who the message is to be sent to
      $mail->addAddress($rdg['Email'], 'Personal en General');

        //Set the subject line
		echo $nombre;
        $mail->Subject = 'Solicitud de dia de guardia de: '.$nombre.'';
        $mail->isHTML(true);

        if($opc == ''){
          $mailContent = "<h1>Tiene una solicitud para un dia de guardia.</h1><br>".
		  "<p>Puede ver la solicitud desde la nomina20</p>".
          "<p>Correo enviado automaticamente por el sistema de Nomina Web</p>";
          $mail->Body = $mailContent; 
        }else{
          $mailContent = "<h1>Tu solicitud de Requerimientos NO ha sido autorizada</h1><br>".
          "<h1>Cualquier duda o aclaracion, comuniquese con su Gerente</h1>".
           "<p>Correo enviado automaticamente por el sistema de Nomina Web</p>";
          $mail->Body = $mailContent;
        }

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

