/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function SlcMenu(op)
{
    switch(op){
        case 1:
             $('#winTrabajo').load('../vis/CatUNegocios.php');
        break;
        case 2:
             $('#winTrabajo').load('../vis/OSGeneral.php');
        break;
    }
}
