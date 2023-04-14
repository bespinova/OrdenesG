<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsParam
 *
 * @author Administrador
 */
class ClsParam {
    var $Usuario;
    var $Passw;
    var $Datos;
    var $Servidor;

    var $Servidor2;
    var $Datos2;
    var $Usuario2;
    var $Passw2;

    var $Servidor3;
    var $Datos3;
    var $Usuario3;
    var $Passw3;
    var $path;

    public function __construct($fl)
    {
      $this->filename =  $fl;  //"C:\\avimrpt\\config.txt";
      $this->IniProp();
     // $this->IniPerfiles();
    }


  function IniProp()
    {
      $this->ct = 0;
       $this->handle = fopen($this->filename, "r");
         if ($this->handle) {
	      while (!feof($this->handle)) {
       	       $this->buffer = fgets($this->handle, 4096);
               $this->valores[$this->ct] = $this->getValor($this->buffer);
                 $this->ct ++;
	      }
          fclose($this->handle);
          }
       $this->Servidor = $this->valores[0];
       $this->Datos = $this->valores[1];
       $this->Usuario = $this->valores[2];
       $this->Passw = $this->valores[3];

           $this->Servidor2 = $this->valores[4];
           $this->Datos2 = $this->valores[5];
           $this->Usuario2 = $this->valores[6];
           $this->Passw2 = $this->valores[7];

           $this->Servidor3 = $this->valores[8];
           $this->Datos3 = $this->valores[9];
           $this->Usuario3 = $this->valores[10];
           $this->Passw3 = $this->valores[11];
           $this->path = $this->valores[12];
     }

 function getValor($cd)
  {
     $this->St = "";
     // $this->dv = substr(strstr($cd,"= "),2);
     $this->dv =ltrim( substr(strstr($cd,"="),1));	 //correcion para superar este error" = " para poder escribir =    server\sql   o =server\sql
	  $max = strlen($this->dv);
      $cdT = str_split($this->dv);
	   for ($j = 0; $j < $max; $j++ ){
	     if ($cdT[$j] <> ';')
	      $this->St = $this->St . $cdT[$j];
		  else break;
	   }
    return ($this->St);
  }

  function IniPerfiles(){
       $ct = 0;
       $handle = fopen($this->pathPerf, "r");
         if ($handle) {
	      while (!feof($handle)) {
        	 $buffer = fgets($handle, 4096);
	         $this->Perfiles[$ct] =$this->getValor2($buffer); //$this->getValor($buffer);
                 $ct ++;
	      }
           fclose($handle);
         }
  }

  function getValor2($cd)
  {
     $this->St = "";
     $max = strlen($cd);
      $cdT = str_split($cd);
	   for ($j = 0; $j < $max; $j++ ){
	     if ($cdT[$j] <> ';')
	      $this->St = $this->St . $cdT[$j];
		  else break;
	   }
    return ($this->St);
  }

}


?>