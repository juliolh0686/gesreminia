<?php

function convertirMes($mes, $anio) {

        switch ($mes) {
          case '01':
            $mes_texto='Enero';
            break;
          case '02':
            $mes_texto='Febrero';
            break;
          case '03':
            $mes_texto='Marzo';
            break;
          case '04':
            $mes_texto='Abril';
            break;
          case '05':
            $mes_texto='Mayo';
            break;
          case '06':
            $mes_texto='Junio';
            break;
          case '07':
            $mes_texto='Julio';
            break;
          case '08':
            $mes_texto='Agosto';
            break;
          case '09':
            $mes_texto='Septiembre';
            break;
          case '10':
            $mes_texto='Octubre';
            break;
          case '11':
            $mes_texto='Noviembre';
            break;
          case '12':
            $mes_texto='Diciembre';
            break;
          default:
            $mes_texto='No Encontrado';
          }
          
          return $mes_texto . " - " . $anio;

      }

?>