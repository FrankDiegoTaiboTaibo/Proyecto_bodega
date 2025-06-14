<?php

  require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
  require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
  require_once ("config/dbaan.php"); // Contine la conexion a base de datos de BAAN
  require_once ("config/conexionODATA.php");
  $conBaan = db_baan_Consulta_baandb();
  $conBaan2 = db_baan_sa_PV();
  require_once ("classes/PHPExcel.php");// Funciones PHP Excel  

  $sql_taller = "SELECT t1.chasis,
                        t1.mante,
                        CONVERT(varchar, t1.fecha, 120) as fecha,
                        t1.texto,
                        t1.ce,
                        t1.km,
                        t1.tipo,
                        t2.rut,
                        t2.dv
                  FROM taller t1 
                  LEFT JOIN cliente t2 ON ltrim(rtrim(t1.chasis)) = ltrim(rtrim(t2.chasis))
                  WHERE MONTH(t1.fecha) = 6 AND YEAR(t1.fecha) = 2020
                  ORDER BY t1.fecha DESC";

  $query_taller = mssql_query($sql_taller, $conBaan2);


  $objPHPExcel = new PHPExcel();

  //Creación de celdas con el título de cada columna
  $objPHPExcel->getActiveSheet()->setCellValue('A1', 'CLAIMID');
  $objPHPExcel->getActiveSheet()->setCellValue('B1', 'CAUSECODE');
  $objPHPExcel->getActiveSheet()->setCellValue('C1', 'CTACUSTOMER');
  $objPHPExcel->getActiveSheet()->setCellValue('D1', 'CTORIGIN');
  $objPHPExcel->getActiveSheet()->setCellValue('E1', 'CUSTODIANUPDATE');
  $objPHPExcel->getActiveSheet()->setCellValue('F1', 'DATE1');
  $objPHPExcel->getActiveSheet()->setCellValue('G1', 'DATE2');
  $objPHPExcel->getActiveSheet()->setCellValue('H1', 'DECIMAL1');
  $objPHPExcel->getActiveSheet()->setCellValue('I1', 'DECIMAL2');    
  $objPHPExcel->getActiveSheet()->setCellValue('J1', 'DEVICEID');
  $objPHPExcel->getActiveSheet()->setCellValue('K1', 'DEVICEUSAGEQTY');
  $objPHPExcel->getActiveSheet()->setCellValue('L1', 'DISTRICTID');
  $objPHPExcel->getActiveSheet()->setCellValue('M1', 'DISTRICTNAME');
  $objPHPExcel->getActiveSheet()->setCellValue('N1', 'EMAILCUSTOD');
  $objPHPExcel->getActiveSheet()->setCellValue('O1', 'NAME');
  $objPHPExcel->getActiveSheet()->setCellValue('P1', 'NAMECITY');
  $objPHPExcel->getActiveSheet()->setCellValue('Q1', 'NAMECUSTOD');
  $objPHPExcel->getActiveSheet()->setCellValue('R1', 'PHONENUM');
  $objPHPExcel->getActiveSheet()->setCellValue('S1', 'RAC');
  $objPHPExcel->getActiveSheet()->setCellValue('T1', 'REGISTERUPDATE');
  $objPHPExcel->getActiveSheet()->setCellValue('U1', 'RUT_LCL');
  $objPHPExcel->getActiveSheet()->setCellValue('V1', 'SERVICEENDDATE');
  $objPHPExcel->getActiveSheet()->setCellValue('W1', 'STREET');
  $objPHPExcel->getActiveSheet()->setCellValue('X1', 'STREETNUMBER');
  $objPHPExcel->getActiveSheet()->setCellValue('Y1', 'SYMPTOMS');
  $objPHPExcel->getActiveSheet()->setCellValue('Z1', 'TXT1');
  $objPHPExcel->getActiveSheet()->setCellValue('AA1', 'TXT2');
  $objPHPExcel->getActiveSheet()->setCellValue('AB1', 'TYPE');

  $linea = 1;

  while ( $fila_taller = mssql_fetch_array($query_taller) ) {

    $rac = trim(substr($ce, 5));

    if ( $rac != ''){

      $claimid ="HST-".substr("0000000$linea", -7);
      $linea += 1;

      $chasis = strtoupper($fila_taller['chasis']);
      $km = $fila_taller['km'];
      $ce = $fila_taller['ce'];
      $mante = $fila_taller['mante'];
      $fecha = $fila_taller['fecha'];
      $texto = utf8_encode($fila_taller['texto']);
      $rac = trim(substr($ce, 5));
      $tipo = trim($fila_taller['tipo']);
      $rut = trim($fila_taller['rut']);
      $dv = strtoupper($fila_taller['dv']);


      if( $rut == ''){

        $sql_rut = "SELECT t2.t_rutn_d as rut,
                           t2.t_rutd_d as dv
                    FROM ttssma102620 t1
                    INNER JOIN ttccom010620 t2 ON t1.t_cuno = t2.t_cuno
                    WHERE RTRIM(LTRIM(t1.t_cins)) = UPPER('$chasis')";

        $query_rut = mssql_query($sql_rut, $conBaan);
        $fila_rut = mssql_fetch_array($query_rut);

        $rut = trim($fila_rut['rut']);
        $dv = strtoupper($fila_rut['dv']);


      }


      $sql_vin = "SELECT t_nvin_c AS VIN
                  FROM ttcctr037620
                  WHERE rtrim(ltrim(t_clot_c)) = '$chasis'";

      $query_vin = mssql_query($sql_vin, $conBaan);
      $fila_vin = mssql_fetch_array($query_vin);

      $vin = trim($fila_vin['VIN']);

      if($vin == '')
        $vin = $chasis;

      $sql_cuenta = "SELECT cod_cuenta_dyn365
                     FROM ce
                     WHERE id_EVN = '$ce'";

      $query_cuenta = mysqli_query($con,$sql_cuenta);

      $fila_cuenta = mysqli_fetch_array($query_cuenta);
      $cuentadyn = $fila_cuenta['cod_cuenta_dyn365'];


      if( $tipo == 'Rep. Generales' )
        $tipo = 'Generales';
      else if( $tipo == 'D y P')
        $tipo = 'DYP';
      else if( $tipo == 'Mantenciones')
        $tipo = 'Mantencion';

      if( $mante == '0')
        $mante = '';
      else
        $mante = number_format($mante,0,',','.').' Km';

      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linea, $claimid);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linea, $mante);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linea, $rut.'-'.$dv.'C');
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linea, 'HISTORICO');
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $linea, 'No');
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $linea, '1900-01-01 00:00:00');
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $linea, '1900-01-01 00:00:00');
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $linea, '.000000');
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $linea, '.000000');
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $linea, $vin);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $linea, $km);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $linea, $rac);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $linea, $fecha);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24, $linea, $texto);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(27, $linea, $tipo);


    }//rac

  }//while

  ob_end_clean(); // Limpia el buffer de salida para evitar problemas de desconocimiento del formato

  //Generación del excel y descarga
  $objPHPExcel->getActiveSheet()->setTitle('Hoja1');
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="Etaller.xlsx"');
  header('Cache-Control: max-age=0');
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
  $objWriter->save('php://output');

?>