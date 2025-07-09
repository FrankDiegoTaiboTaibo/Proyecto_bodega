<?php
  /* Conexion*/
  require_once("../config/db.php");
  require_once("../config/conexion.php");
  require_once("../classes/PHPExcel.php");

  include('is_logged.php');


  $id = $_GET['id'];




  $objPHPExcel = new PHPExcel();

  $estiloColumna2 = new PHPExcel_Style();

  $estiloTituloReporte = array(
    'font' => array(
      'name'      => 'Verdana',
      'bold'      => true,
      'italic'    => false,
      'strike'    => false,
      'size'      => 16,
      'color'     => array('rgb' => '000000')
    ),

    'borders' => array(
      'allborders' => array('style' => PHPExcel_Style_Border::BORDER_NONE)
    ),
    'alignment' => array(
      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      'rotation' => 0,
      'wrap' => TRUE
    )
  );

  $estiloColumna2->applyFromArray(
    array(
      'font' => array(
        'name'  => 'Arial',
        'bold'  => true,
        'color' => array(
          'rgb' => '000000'
        )
      ),
      'borders' => array(
        'top' => array(
          'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
          'color' => array(
            'rgb' => '000000'
          )
        ),
        'bottom' => array(
          'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
          'color' => array(
            'rgb' => '000000'
          )
        ),
        'left' => array(
          'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
          'color' => array(
            'rgb' => '000000'
          )
        ),
        'right' => array(
          'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
          'color' => array(
            'rgb' => '000000'
          )
        )
      ),
      'alignment' =>  array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'wrap'      => TRUE
      ),
      'fill' => array(
        'type'  => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'dff0d8')
      )
    )
  );

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:Q2');

  /* Titulo hoja 1*/
  $titulo = "Stock Actual";
  $objPHPExcel->getActiveSheet()->setCellValue('A2', $titulo);

  /* Columnas tabla vhi */
  $objPHPExcel->getActiveSheet()->setCellValue('B4', 'STOCK ACTUAL');
  $objPHPExcel->getActiveSheet()->setCellValue('C4', 'LOTE');
  $objPHPExcel->getActiveSheet()->setCellValue('D4', 'ARTÍCULO');
  $objPHPExcel->getActiveSheet()->setCellValue('E4', 'CONCENTRACIÓN');
  $objPHPExcel->getActiveSheet()->setCellValue('F4', 'FORMA FARMACEUTICA');
  $objPHPExcel->getActiveSheet()->setCellValue('G4', 'VÍA ADMINISTRACIÓN');
  $objPHPExcel->getActiveSheet()->setCellValue('H4', 'UNIDAD MEDIDA');
  $objPHPExcel->getActiveSheet()->setCellValue('I4', 'LABORATORIO');
  $objPHPExcel->getActiveSheet()->setCellValue('J4', 'TIPO ARTÍCULO');
  $objPHPExcel->getActiveSheet()->setCellValue('K4', 'CÓDIGO BARRA');
  $objPHPExcel->getActiveSheet()->setCellValue('L4', 'CÓDIGO ISP');
  $objPHPExcel->getActiveSheet()->setCellValue('M4', 'FECHA VENCIMIENTO');
  $objPHPExcel->getActiveSheet()->setCellValue('N4', 'TIPO INGRESO');
  $objPHPExcel->getActiveSheet()->setCellValue('O4', 'PROVEEDOR');
  $objPHPExcel->getActiveSheet()->setCellValue('P4', 'FECHA INGRESO');
  $objPHPExcel->getActiveSheet()->setCellValue('Q4', 'USUARIO INGRESO');

  $linea_vhi = 5;

  
  $sql_vhi = "SELECT * 
              FROM articulos t1 
              LEFT JOIN ingreso t2 ON t1.id_articulo = t2.id_articulo 
              LEFT JOIN users t3 ON t2.usuario_creador_id = t3.user_id
              WHERE t2.id_ingreso";

  $query_vhi =  mysqli_query($con, $sql_vhi);
  $count_vhi = mysqli_num_rows($query_vhi);


  if ($count_vhi > 0) {

    while ($fila_vhi = mysqli_fetch_array($query_vhi)) {
      $id_ingreso = $fila_vhi['id_ingreso'];
      $id_articulo = $fila_vhi['id_articulo'];
      $lote = $fila_vhi['lote'];
      $nombre_articulo = $fila_vhi['nombre_articulo'];
      $concentracion = $fila_vhi['concentracion'];
      $forma_farmaceutica = $fila_vhi['forma_farmaceutica'];
      $via_administracion = $fila_vhi['via_administracion'];
      $unidad_medida = $fila_vhi['unidad_medida'];
      $laboratorio = $fila_vhi['laboratorio'];
      $tipo_articulo = $fila_vhi['tipo_articulo'];
      $codigo_isp = $fila_vhi['codigo_isp'];
      $fecha_vencimiento = $fila_vhi['fecha_vencimiento'];
      $tipo_ingreso = $fila_vhi['tipo_ingreso'];
      $proveedor = $fila_vhi['proveedor'];
      $codigo_barra = $fila_vhi['codigo_barra'];
      $fecha_ingreso = $fila_vhi['fecha_ingreso'];
      $user_name = $fila_vhi['user_name'];
    
    // Calcular stock actual del lote (si no tienes tabla egreso, solo SUMA ingresos)
                            $sql_stock = "SELECT SUM(cantidad) AS stock_actual 
                                          FROM ingreso 
                                          WHERE id_articulo = '$id_articulo' 
                                          AND lote = '$lote' 
                                          AND id_ingreso = '$id_ingreso'";

                            $res_stock = mysqli_query($con, $sql_stock);
                            $stock_data = mysqli_fetch_assoc($res_stock);
                            $stock_actual = $stock_data['stock_actual'] ?? 0;

      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linea_vhi, $stock_actual);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $linea_vhi, $lote);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $linea_vhi, $nombre_articulo);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $linea_vhi, $concentracion);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $linea_vhi, $forma_farmaceutica);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $linea_vhi, $via_administracion);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $linea_vhi, $unidad_medida);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $linea_vhi, $laboratorio);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $linea_vhi, $tipo_articulo);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $linea_vhi, $codigo_barra);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $linea_vhi, $codigo_isp);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $linea_vhi, $fecha_vencimiento);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $linea_vhi, $tipo_ingreso);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $linea_vhi, $proveedor);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $linea_vhi, $fecha_ingreso);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $linea_vhi, $user_name);

     

      $linea_vhi += 1;
    }
  }

  /* Tilulo */
  $objPHPExcel->getActiveSheet()->getStyle('A2:Q2')->applyFromArray($estiloTituloReporte);

  $objPHPExcel->getActiveSheet()->setSharedStyle($estiloColumna2, "B4:Q4"); //nombre columnas 

  for ($i = 'A'; $i <= 'Q'; $i++) {
    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
  }

  $objPHPExcel->getActiveSheet()->setTitle('vhi');

  ob_end_clean();

  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="vhi_' . str_replace(' ', '_', $lote) . '.xlsx"');
  header('Cache-Control: max-age=0');
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
  $objWriter->save('php://output');
?>