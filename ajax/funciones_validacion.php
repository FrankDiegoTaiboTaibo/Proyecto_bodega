<?php

  function validaRut($rut){

    if (!preg_match("/^[0-9.]+[-]?+[0-9kK]{1}/", $rut)) {
      return false;
    }

    $rut = preg_replace('/[\.\-]/i', '', $rut);
    $dv = substr($rut, -1);
    $numero = substr($rut, 0, strlen($rut) - 1);
    $i = 2;
    $suma = 0;

    if($numero > 99999999)
      return false;

    foreach (array_reverse(str_split($numero)) as $v) {
      if ($i == 8)
        $i = 2;
      $suma += $v * $i;
      ++$i;
    }
    $dvr = 11 - ($suma % 11);

    if ($dvr == 11)
      $dvr = 0;
    if ($dvr == 10)
      $dvr = 'K';
    if ($dvr == strtoupper($dv))
      return true;
    else
      return false;

  }

  function validaFecha($fecha,$propio){

    $valores = explode('/', $fecha);

    if(!(count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2]))){
      return 'No fecha';
    }

    $fecha_ingresada = new DateTime($valores[2].'-'.$valores[1].'-'.$valores[0]);
    $fecha_actual = new DateTime();

    if($fecha_ingresada->format('n') === $fecha_actual->format('n') && $fecha_ingresada->format('Y') === $fecha_actual->format('Y') && $fecha_ingresada <= $fecha_actual) {
      return "Mes Actual";
    }
    else{
      return 'Fecha fuera plazo';
    }

  }
  
  function formatoFechaMySQL($fecha){

    $valores = explode('/', $fecha);

    return $valores[2].'-'.$valores[1].'-'.$valores[0];

  }

  function validaEmail($email){

    $patron = '/^([A-Z|a-z|0-9](\.|_){0,1})+[A-Z|a-z|0-9]\@([A-Z|a-z|0-9]|-)+((\.){0,1}[A-Z|a-z|0-9]|-){1}(\.[a-z]{2,3}){1,2}$/i';

    return preg_match($patron, $email);

  }

?>