<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsMsSql
 *
 * @author Administrador
 */
class ClsMsSql 
{
   var $SerSql;
	var $UsrSql;
	var $dbSql;
	var $pwdSql;   
	var $ArrDv;
	
	var $cn;
	  
    public function __construct($srv,$usr,$db,$pwd)
    { 
        $this->ServSql = $srv;
	$this->UsrSql = $usr;
	$this->dbSql = $db;
	$this->pwdSql = $pwd; 
        $this->cn = 0; 
    }
	
	public function Conextar()
	{ 
            $datCon = Array("Database" => $this->dbSql, "UID" => $this->UsrSql, "PWD" => $this->pwdSql);	
            $this->cn = sqlsrv_connect( $this->ServSql, $datCon);
           
            if($this->cn)
                   return 1;
            else		 
                   return 0;
	}
	
   public function Close()
	{
		//mssql_close($this->cn);
		sqlsrv_close($this->cn);
	}
	
	//metodo que ejecuta un procedimiento almacenado, el resultado lo agrega a un arreglo.
        //Todos los parametros que se le pasa al procedimiento almacenado son de tipo Varchar
	public function loadProc($nm,$Prm)
	{ 
	  switch(count($Prm)){
			case 1: $stmt = "Exec ".$nm." ?";  
					$params = array($Prm[0][1]);
			break;
			case 2: $stmt = "Exec ".$nm." ?,?";  
					$params = array($Prm[0][1],$Prm[1][1]);
			break;
			case 3: $stmt = "Exec ".$nm." ?,?,?";  
					$params = array($Prm[0][1],$Prm[1][1],$Prm[2][1]);
			break;
			case 4: $stmt = "Exec ".$nm." ?,?,?,?";  
					$params = array($Prm[0][1],$Prm[1][1],$Prm[2][1],$Prm[3][1]);
			break;
			case 5: $stmt = "Exec ".$nm." ?,?,?,?,?";  
					$params = array($Prm[0][1],$Prm[1][1],$Prm[2][1],$Prm[3][1],
									$Prm[4][1]);
			break;
			case 6: $stmt = "Exec ".$nm." ?,?,?,?,?,?";  
					$params = array($Prm[0][1],$Prm[1][1],$Prm[2][1],$Prm[3][1],
									$Prm[4][1],$Prm[5][1]); 
			break;		
			case 7: $stmt = "Exec ".$nm." ?,?,?,?,?,?,?"; 
					$params = array($Prm[0][1],$Prm[1][1],$Prm[2][1],$Prm[3][1],
									$Prm[4][1],$Prm[5][1],$Prm[6][1]);                                 
			break;
			case 8: $stmt = "Exec ".$nm." ?,?,?,?,?,?,?,?";
					$params = array($Prm[0][1],$Prm[1][1],$Prm[2][1],$Prm[3][1],
									$Prm[4][1],$Prm[5][1],$Prm[6][1],$Prm[7][1]);
			break;
			case 9: $stmt = "Exec ".$nm." ?,?,?,?,?,?,?,?,?";
					$params = array($Prm[0][1],$Prm[1][1],$Prm[2][1],$Prm[3][1],
									$Prm[4][1],$Prm[5][1],$Prm[6][1],$Prm[7][1],
									$Prm[8][1]);
		    break;							
			case 10: $stmt = "Exec ".$nm." ?,?,?,?,?,?,?,?,?"; 
					 $params = array($Prm[0][1],$Prm[1][1],$Prm[2][1],$Prm[3][1],
									$Prm[4][1],$Prm[5][1],$Prm[6][1],$Prm[7][1],
									$Prm[8][1],$Prm[9][1]);
			break;
	  }	          
	   $result = sqlsrv_query($this->cn, $stmt, $params); 
	   $k = 0;
		 while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_NUMERIC))
		  {      
			 for ($p = 0; $p < sqlsrv_num_fields($result); $p++){			 
					 $this->ArrDv[$k][$p]= $row[$p];               			 
				} 
			$k++;			
		  }
		 return ($this->ArrDv); 
	}

	
   public function loadProc2($nm,$Prm)
	{ 	  
	 switch(count($Prm)){
		case 1: $stmt = "Exec ".$nm." ?";  
		        $params = array($Prm[0][1]);
		break;
		case 2: $stmt = "Exec ".$nm." ?,?";  
		        $params = array($Prm[0][1],$Prm[1][1]);
		break;
		case 3: $stmt = "Exec ".$nm." ?,?,?";  
		        $params = array($Prm[0][1],$Prm[1][1],$Prm[2][1]);
		break;
		case 4: $stmt = "Exec ".$nm." ?,?,?,?";  
		        $params = array($Prm[0][1],$Prm[1][1],$Prm[2][1],$Prm[3][1]);
		break;
		case 5: $stmt = "Exec ".$nm." ?,?,?,?,?";  
		        $params = array($Prm[0][1],$Prm[1][1],$Prm[2][1],$Prm[3][1],
				                $Prm[4][1]);
		break;
		case 6: $stmt = "Exec ".$nm." ?,?,?,?,?,?";  
		        $params = array($Prm[0][1],$Prm[1][1],$Prm[2][1],$Prm[3][1],
				                $Prm[4][1],$Prm[5][1]); 
		break;		
		case 7: $stmt = "Exec ".$nm." ?,?,?,?,?,?,?"; 
		        $params = array($Prm[0][1],$Prm[1][1],$Prm[2][1],$Prm[3][1],
				                $Prm[4][1],$Prm[5][1],$Prm[6][1]);                                 
		break;
		case 8: $stmt = "Exec ".$nm." ?,?,?,?,?,?,?,?";
		        $params = array($Prm[0][1],$Prm[1][1],$Prm[2][1],$Prm[3][1],
				                $Prm[4][1],$Prm[5][1],$Prm[6][1],$Prm[7][1]);
		break;
		case 9: $stmt = "Exec ".$nm." ?,?,?,?,?,?,?,?,?";
		        $params = array($Prm[0][1],$Prm[1][1],$Prm[2][1],$Prm[3][1],
				                $Prm[4][1],$Prm[5][1],$Prm[6][1],$Prm[7][1],
								$Prm[8][1]);
        break;								
		case 10: $stmt = "Exec ".$nm." ?,?,?,?,?,?,?,?,?"; 
		         $params = array($Prm[0][1],$Prm[1][1],$Prm[2][1],$Prm[3][1],
				                $Prm[4][1],$Prm[5][1],$Prm[6][1],$Prm[7][1],
								$Prm[8][1],$Prm[9][1]);
		break;
		case 16: $stmt = "Exec ".$nm." ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?"; 
		         $params = array($Prm[0][1],$Prm[1][1],$Prm[2][1],$Prm[3][1],
				                 $Prm[4][1],$Prm[5][1],$Prm[6][1],$Prm[7][1],
								 $Prm[8][1],$Prm[9][1],$Prm[10][1],$Prm[11][1],
								 $Prm[12][1],$Prm[13][1],$Prm[14][1],$Prm[15][1]);								
		break;
	 }
	
	 $result = sqlsrv_query($this->cn, $stmt, $params); 
	   $k = 0;
	   while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_NUMERIC))
		{      
		  for ($p = 0; $p < sqlsrv_num_fields($result); $p++){			 
				 $this->ArrDv[$k][$p]= $row[$p];               			 
				} 
		  $k++;			
		 }
	 return ($this->ArrDv);  
	}   


   public function loadProc3($nm,$Prm,$nrslt)
	{ 	  
	 switch(count($Prm)){
		case 1: $stmt = "Exec ".$nm." ?";  
		        $params = array($Prm[0][1]);
		break;
		case 2: $stmt = "Exec ".$nm." ?,?";  
		        $params = array($Prm[0][1],$Prm[1][1]);
		break;
		case 3: $stmt = "Exec ".$nm." ?,?,?";  
		        $params = array($Prm[0][1],$Prm[1][1],$Prm[2][1]);
		break;
		case 4: $stmt = "Exec ".$nm." ?,?,?,?";  
		        $params = array($Prm[0][1],$Prm[1][1],$Prm[2][1],$Prm[3][1]);
		break;
		case 5: $stmt = "Exec ".$nm." ?,?,?,?,?";  
		        $params = array($Prm[0][1],$Prm[1][1],$Prm[2][1],$Prm[3][1],
				                $Prm[4][1]);
		break;
		case 6: $stmt = "Exec ".$nm." ?,?,?,?,?,?";  
		        $params = array($Prm[0][1],$Prm[1][1],$Prm[2][1],$Prm[3][1],
				                $Prm[4][1],$Prm[5][1]); 
		break;		
		case 7: $stmt = "Exec ".$nm." ?,?,?,?,?,?,?"; 
		        $params = array($Prm[0][1],$Prm[1][1],$Prm[2][1],$Prm[3][1],
				                $Prm[4][1],$Prm[5][1],$Prm[6][1]);                                 
		break;
		case 8: $stmt = "Exec ".$nm." ?,?,?,?,?,?,?,?";
		        $params = array($Prm[0][1],$Prm[1][1],$Prm[2][1],$Prm[3][1],
				                $Prm[4][1],$Prm[5][1],$Prm[6][1],$Prm[7][1]);
		break;
		case 9: $stmt = "Exec ".$nm." ?,?,?,?,?,?,?,?,?";
		        $params = array($Prm[0][1],$Prm[1][1],$Prm[2][1],$Prm[3][1],
				                $Prm[4][1],$Prm[5][1],$Prm[6][1],$Prm[7][1],
								$Prm[8][1]);
        break;								
		case 10: $stmt = "Exec ".$nm." ?,?,?,?,?,?,?,?,?,?"; 
		         $params = array($Prm[0][1],$Prm[1][1],$Prm[2][1],$Prm[3][1],
				                $Prm[4][1],$Prm[5][1],$Prm[6][1],$Prm[7][1],
								$Prm[8][1],$Prm[9][1]);								
		break;		
	 }
	
	 $result = sqlsrv_query($this->cn, $stmt, $params); 
      
	  for($p = 1; $p <= $nrslt; $p++){
	    $next_result = sqlsrv_next_result($result);
      }
	 
	   $k = 0;
	   while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_NUMERIC))
		{      
		  for ($p = 0; $p < sqlsrv_num_fields($result); $p++){			 
				 $this->ArrDv[$k][$p]= $row[$p];               			 
				} 
		  $k++;			
		 }
	 return ($this->ArrDv);  
	}   


      public function loadProc1($nm)
       {       
      	 $stmt = "Exec ".$nm." ";  
		 $params = array();
         $result = sqlsrv_query($this->cn, $stmt, $params); 
		 $k = 0;
		  while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_NUMERIC))
			{      
			  for ($p = 0; $p < sqlsrv_num_fields($result); $p++){			 
					 $this->ArrDv[$k][$p]= $row[$p];               			 
					} 
			  $k++;			
			 }	
         return ($this->ArrDv);     
       }

	   
	   
	   
     public function loadQuery($clst)
      { 	    
		$k = 0;
		$rs = sqlsrv_query($this->cn,$clst);
		while($row=sqlsrv_fetch_array($rs)){
        	  for ($p = 0; $p < sqlsrv_num_fields($rs); $p++){ 
	        	 $this->ArrDv[$k][$p]= $row[$p]; 
	          }  
                 $k++;
        	} 
         return ($this->ArrDv);        		 
      }

      
      public function loadQueryARR_Asoc($clst)
      {
          $rs = sqlsrv_query($this->cn,$clst);
          $ct = 0;     
          //($this->ArrDv = array_diff($this->ArrDv,$this->ArrDv); //array_diff( $array, $array);
          $this->ArrDv = Array();
          while ($row=sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)){
            $this->ArrDv[$ct] = array($row);
            $ct++;           
          }
         sqlsrv_free_stmt($rs);
         return ($this->ArrDv);  
      }
         
     
      public function loadQueryARR_AsocPrm($clst)
      {
          $rs = sqlsrv_query($this->cn,$clst);          
          $this->ArrDv = Array();
           while ($row=sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)){
               $this->ArrDv[$row['NombreParametro']] = $row['Valor'];               
           }
                    
                
         sqlsrv_free_stmt($rs);
         return ($this->ArrDv);  
      }
      
      
      
      
    
    public function QueryDml($clst)
    {
        //$rs = mssql_query($clst,$this->cn);
        $rs = sqlsrv_query($this->cn,$clst);
        // print_r($rs);
        if ($rs)  
            $dv = 1;    
        else   
           $dv = 0;  
        
        sqlsrv_free_stmt($rs);
        return($dv);
    }
    
    
    public function getIdRegistroUltimo($tabla)
    {
        $sqlGetidReg = "SELECT top 1 SCOPE_IDENTITY() as UltReg  from ".$tabla;
        $rs = sqlsrv_query($this->cn, $sqlGetidReg);
             
        if($rs){
           while ($row=sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)){
             print_r ($row);
           }       
            $dv = 1;
        }            
        else
            $dv = 0;
       
      return($dv); 
    }
    
    
    public function AddRegistro($sql, $prm)
    {
        $rs = sqlsrv_query($this->cn, $sql, $prm);
        print_r($rs);
        if($rs)
            $dv = 1;
        else
            $dv = 0;
        sqlsrv_free_stmt($rs);
      return($dv); 
    }
    
    
     public function AddRegistro2($sql, $prm,$tbl)
    {
       $rs = sqlsrv_query($this->cn, $sql, $prm);
       
        if($rs){
            $strGetUltReg = 'SELECT top 1 @@IDENTITY AS UltReg from ' . $tbl;
            $rs2 = sqlsrv_query($this->cn,$strGetUltReg);
            $row=sqlsrv_fetch_array($rs2,SQLSRV_FETCH_ASSOC);
            //print '<br>Ultimo registro agregado '. $row['UltReg'];
            $dv = $row['UltReg'];
        }
        else
            $dv = 0;
        sqlsrv_free_stmt($rs);
      return($dv); 
    }
    
    
    
    
    public function UpdateRegistro($sql, $prm)
    {
        $rs = sqlsrv_query($this->cn, $sql, $prm);
       
        if($rs)
            $dv = 1;
        else
            $dv = 0;
        sqlsrv_free_stmt($rs);
      return($dv); 
    }
    
}

?>
