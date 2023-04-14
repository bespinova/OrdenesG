<?php
include_once("../ClsParam.php");
include_once("../ClsMsSql.php");
require("../core.php");

session_start();


class modRevisionImagenes{
  private $CodImg;
  private $CodRevision;
  private $FechaSubida;
  private $RutaImg;
  private $Comentario;

  private $ArrDat;
  var $conDb;
  var $objParam;


  function __construct($CodImg,$CodRevision,$FechaSubida,$RutaImg,$Comentario)
  {
    $this->CodImg = $CodImg;
    $this->CodRevision = $CodRevision;
    $this->FechaSubida = $FechaSubida;
    $this->RutaImg = $RutaImg;
    $this->Comentario = $Comentario;


    $this->ArrDat = array($this->CodImg,
                          $this->CodRevision,
                          $this->FechaSubida,
                          $this->RutaImg,
                          $this->Comentario
                          );

    $this->objParam = new ClsParam($_SESSION['path']);
    $this->conDb = new ClsmsSql($_SESSION['Servidor'],$_SESSION['Usuario'],$_SESSION['Datos'],$_SESSION['Passw']);

    if ($this->conDb->Conextar() > 0){
      return "Error al conectarse en la base de datos";
    }
  }

  public function guardaRevisionImg()
  {
     $strIns = "INSERT INTO PrRevsionImg(CodRevision,FechaSubida,RutaImg,Comentario)"
                . " VALUES (?,?,?,?)";
    $this->ArrDat = array(
                          $this->CodRevision,
                          $this->FechaSubida,
                          $this->RutaImg,
                          $this->Comentario
                        );
     if($this->conDb->AddRegistro($strIns, $this->ArrDat))
        return 1;
     else
         return 2;
  }

  public function muestraRevisionImg($varContenido){
            $strSlc = "SELECT RutaImg FROM PrRevsionImg WHERE CodRevision = '".$varContenido."' ";

    $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
     if (count($rsp) > 0){
         return $rsp;
     }
    else{
      return 'No hay registros que mostrar.';
    }

  }

}


 ?>
