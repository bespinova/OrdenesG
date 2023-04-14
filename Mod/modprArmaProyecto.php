<?php
include_once("../ClsParam.php");
include_once("../ClsMsSql.php");
require("../core.php");
session_start();

class modprArmaProyecto {
    private $CodProyecto;
    private $CodRubro;
    private $ValorEnProyecto;
    private $ValorAvance;
    private $Estatus;
    public function getCodProyecto() {
        return $this->CodProyecto;
    }

    public function getCodRubro() {
        return $this->CodRubro;
    }

    public function getValorEnProyecto() {
        return $this->ValorEnProyecto;
    }

    public function getValorAvance() {
        return $this->ValorAvance;
    }

    public function getEstatus() {
        return $this->Estatus;
    }

    public function setCodProyecto($CodProyecto) {
        $this->CodProyecto = $CodProyecto;
    }

    public function setCodRubro($CodRubro) {
        $this->CodRubro = $CodRubro;
    }

    public function setValorEnProyecto($ValorEnProyecto) {
        $this->ValorEnProyecto = $ValorEnProyecto;
    }

    public function setValorAvance($ValorAvance) {
        $this->ValorAvance = $ValorAvance;
    }

    public function setEstatus($Estatus) {
        $this->Estatus = $Estatus;
    }

        private $ArrDat;

    var $conDb;
    var $objParam;



    public function __construct($CodProyecto, $CodRubro, $ValorEnProyecto, $ValorAvance,$Estatus) {
        $this->CodProyecto = $CodProyecto;
        $this->CodRubro = $CodRubro;
        $this->ValorEnProyecto = $ValorEnProyecto;
        $this->ValorAvance = $ValorAvance;
        $this->Estatus = $Estatus;

        $this->ArrDat = array($this->CodProyecto,
                                  $this->CodRubro,
                                  0,
                                  0,
                                  'A'
                    );

        $this->objParam = new ClsParam($_SESSION['path']);
        $this->conDb = new ClsmsSql($_SESSION['Servidor'],$_SESSION['Usuario'],$_SESSION['Datos'],$_SESSION['Passw']);
        //$this->conDb = new ClsmsSql("sigma6\locsql","sa","GcOSMtto","Remolachas1");
            if ($this->conDb->Conextar() > 0){
              return "Error al conectarse en la base de datos";
            }
    }

    //Agregar rubro al proyecto seleccionado
   public function AddRubroProtecto()
    {
      $strIns = "INSERT INTO PrProyectoRubro(CodProyecto,CodRubro,ValorEnProyecto,ValorAvance,Estatus)"
              . " Values(?,?,?,?,?)";

      if($this->conDb->AddRegistro($strIns, $this->ArrDat))
      {
         $strmsg = "Registro Agregado<br>";
         $strAct = "update PrProyectoRubro set ValorEnProyecto = (select round(100.00/COUNT(*),3)
                                               from PrProyectoRubro where CodProyecto = '".$this->CodProyecto."')
                    Where CodProyecto = '".$this->CodProyecto."'" ;
          if($this->conDb->QueryDml($strAct) > 0){
             $strmsg .= "Proyecto Actualizado<br>";
             $strTra = "insert into PrContenidoProyecto
                        Select  '".$this->CodProyecto."','".$this->CodRubro."',CodTarea,CONVERT (date, GETDATE()),'',
                            ValorEnRubro,0,NULL,'A',1
                            from  PrCatTareaRubro where CodRubro_fk = '".$this->CodRubro."'";
             if($this->conDb->QueryDml($strTra) > 0)
                $strmsg .= "Tareas agregadas al proyecto";
          }
         return $strmsg;
      }

      else
          return "No se pudo agregar el registro";
    }

    public function DelRubroProtecto()
    {
        $strMsg = "";
        $strDtra = "delete from PrContenidoProyecto where CodProyecto = '".$this->CodProyecto
                   ."' and CodRubro = '".$this->CodRubro."'";

         if($this->conDb->QueryDml($strDtra) > 0)
         {
            $strMsg .= "Tareas Eliminadas<br>";
            $strDpr = "delete from PrProyectoRubro  where CodProyecto = '".$this->CodProyecto.
                      "' and CodRubro = '".$this->CodRubro."'";
            if($this->conDb->QueryDml($strDpr) > 0)
            {
                $strMsg .= "Rubro eliminado<br>";
                $strAct = "update PrProyectoRubro set ValorEnProyecto = (select round(100.00/COUNT(*),3)
                                               from PrProyectoRubro where CodProyecto = '".$this->CodProyecto."')
                    Where CodProyecto = '".$this->CodProyecto."'" ;
                if($this->conDb->QueryDml($strAct) > 0)
                  $strMsg .= "Proyecto Actualizado<br>";
                else
                  $strMsg .= "Error en la actualizacion del prouecto";
            }
            else
             $strMsg .= "Error en la eliminacion de tareas";
         }
        else
           $strMsg .= "Error en la eliminacion de tareas";

       return $strMsg;
    }



    public function obtener_CatProyectosT()
    {
       $strUneg = "select P.CodProyecto,P.Nombre,p.Observacion,U.Nombre as Uneg
                    from PrCatProyectos P join CatUnidadNegocios U on P.CodUNegocio = U.CodUNegocio
                    where P.Estatus = 'A'";
       $rsp = $this->conDb->loadQueryARR_Asoc($strUneg);

        if (count($rsp) > 0){
            return $rsp;
        }
       else
           return  $rsp;
    }


    public function obtener_CatProyectosB($Uneg, $Busq)
    {
       $strUneg = "select P.CodProyecto,P.Nombre,p.Observacion,U.Nombre as Uneg
                    from PrCatProyectos P join CatUnidadNegocios U on P.CodUNegocio = U.CodUNegocio
                    where P.Estatus = 'A' ";
       if(strlen($Uneg) > 0)
             $strUneg .= "And P.CodUNegocio = '".$Uneg."'";

       if(strlen($Busq) > 0)
           $strUneg .= "And (P.Nombre like '%".$Busq."%' or P.Observacion like '%".$Busq."%')";

       $rsp = $this->conDb->loadQueryARR_Asoc($strUneg);

        if (count($rsp) > 0){
            return $rsp;
        }
       else
           return  $rsp;
    }    
    public function obtener_RubrosPrSlc($codProyecto)
    {
       $strRub = "select P.CodRubro,R.Descripcion,P.ValorEnProyecto,
                    case P.Estatus
                       When 'A' then 'Activo'
                       When 'T' then 'Terminado'
                       when 'I' then 'Iniciado'
                    End Estatus
                from prProyectoRubro P join PrCatRubros R on P.CodRubro = R.CodRubro
              where  P.CodPRoyecto = '".$codProyecto."' order by ord";

       $rsp = $this->conDb->loadQueryARR_Asoc($strRub);

        if (count($rsp) > 0){
            return $rsp;
        }
       else
           return  $rsp;
    }

    public function obtener_RubrosAsigProy($codProyecto)
    {
        $str1 = "select Pr.CodRubro,R.Descripcion,Pr.ValorEnProyecto
                from PrProyectoRubro Pr Join PrCatRubros R on Pr.CodRubro = R.CodRubro
                where Pr.CodProyecto = '".$codProyecto."'";
         $rsp = $this->conDb->loadQueryARR_Asoc($str1);

        if (count($rsp) > 0){
            return $rsp;
        }
       else
           return  $rsp;
    }

    public function Obtener_RubroGte($codProyecto,$codGte)
    {
        $str1 = "select  CodRubro,Descripcion from PrCatRubros where PerteneceA = '".$codGte."' and
                   CodRubro Not in (select codRubro from PrProyectoRubro where CodProyecto = '".$codProyecto."')";

        $rsp = $this->conDb->loadQueryARR_Asoc($str1);

        if (count($rsp) > 0){
            return $rsp;
        }
       else
           return  $rsp;
    }

    public function obtener_CatGteM()
    {
       $strUneg = "Select CodGteMtto,Nombre from CatGteMatto order by CodGteMtto";
       $rsp = $this->conDb->loadQueryARR_Asoc($strUneg);

        if (count($rsp) > 0){
            return $rsp;
        }
       else
           return  $rsp;
    }


    public function Obtener_TareaRubSlc($codProyecto,$codRubro)
    {
       $strTr = "select Pc.CodTarea,Tr.Descripcion,Pc.ValorEnRubro,Pc.ValorAvance
                  from PrContenidoProyecto Pc Join PrCatTareaRubro Tr on Pc.CodRubro = Tr.CodRubro_fk and
                                                                Pc.CodTarea = Tr.CodTarea
                  where Pc.CodProyecto = '".$codProyecto."' and Pc.CodRubro = '".$codRubro."'";
       $rsp = $this->conDb->loadQueryARR_Asoc($strTr);

        if (count($rsp) > 0)
            return $rsp;
        else
           return  $rsp;
    }

   public function obtener_Uneg()
   {
       $strUn = "select CodUNegocio,Nombre from CatUnidadNegocios ";
       $rsp = $this->conDb->loadQueryARR_Asoc($strUn);

        if (count($rsp) > 0)
            return $rsp;
        else
           return  $rsp;
   }

}
