<?php
require_once('tcpdf/tcpdf.php'); //Llamando a la Libreria TCPDF
require_once('database.php'); //Llamando a la conexión para BD
date_default_timezone_set('America/Caracas');


ob_end_clean(); //limpiar la memoria


class MYPDF extends TCPDF{
      
    	public function Header() {
            $bMargin = $this->getBreakMargin();
            $auto_page_break = $this->AutoPageBreak;
            $this->SetAutoPageBreak(false, 0);
            $img_file = dirname( __FILE__ ) .'/assets/img/logo.png';
            
            $this->SetAutoPageBreak($auto_page_break, $bMargin);
            $this->setPageMark();
	    }
}


//Iniciando un nuevo pdf
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, 'mm', 'Letter', true, 'UTF-8', false);
 
//Establecer margenes del PDF
$pdf->SetMargins(20, 35, 25);
$pdf->SetHeaderMargin(20);
$pdf->setPrintFooter(false);
$pdf->setPrintHeader(true); //Eliminar la linea superior del PDF por defecto
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM); //Activa o desactiva el modo de salto de página automático
 
//Informacion del PDF
$pdf->SetCreator('Thomsom');
$pdf->SetAuthor('Admin');
$pdf->SetTitle('Informe de botellones llenados');
 
/** Eje de Coordenadas
 *          Y
 *          -
 *          - 
 *          -
 *  X ------------- X
 *          -
 *          -
 *          -
 *          Y
 * 
 * $pdf->SetXY(X, Y);
 */

//Agregando la primera página
$pdf->AddPage();
$pdf->SetFont('helvetica','B',10); //Tipo de fuente y tamaño de letra
$pdf->SetXY(150, 20);
$pdf->Write(0, 'Código: 0014ABC');
$pdf->SetXY(150, 25);
$pdf->Write(0, 'Fecha: '. date('d-m-Y'));
$pdf->SetXY(150, 30);
$pdf->Write(0, 'Hora: '. date('h:i A'));

$canal ='ThomsomAdmin';
$pdf->SetFont('helvetica','B',10); //Tipo de fuente y tamaño de letra
$pdf->SetXY(15, 20); //Margen en X y en Y
$pdf->SetTextColor(204,0,0);
$pdf->Write(0, 'Desarrollador: Fabian Alvarez');
$pdf->SetTextColor(0, 0, 0); //Color Negrita
$pdf->SetXY(15, 25);
$pdf->Write(0, 'Canal: '. $canal);



$pdf->Ln(35); //Salto de Linea
$pdf->Cell(40,26,'',0,0,'C');
/*$pdf->SetDrawColor(50, 0, 0, 0);
$pdf->SetFillColor(100, 0, 0, 0); */
$pdf->SetTextColor(34,68,136);
//$pdf->SetTextColor(255,204,0); //Amarillo
//$pdf->SetTextColor(34,68,136); //Azul
//$pdf->SetTextColor(153,204,0); //Verde
//$pdf->SetTextColor(204,0,0); //Marron
//$pdf->SetTextColor(245,245,205); //Gris claro
//$pdf->SetTextColor(100, 0, 0); //Color Carne
$pdf->SetFont('helvetica','B', 15); 
$pdf->Cell(100,6,'LISTA DE BOTELLONES LLENADOS',0,0,'C');


$pdf->Ln(10); //Salto de Linea
$pdf->SetTextColor(0, 0, 0); 

// Configuración de la cabecera de la tabla
$pdf->SetFillColor(232,232,232);
$pdf->SetFont('helvetica','B',12); // La B es para letras en Negritas
$pdf->Cell(40,6,'Cliente Cédula',1,0,'C',1);
$pdf->Cell(60,6,'Cantidad',1,0,'C',1);
$pdf->Cell(35,6,'Nombre de Zona',1,0,'C',1);
$pdf->Cell(35,6,'Fecha y Hora',1,1,'C',1); 

$pdf->SetFont('helvetica','',10);

// SQL para consultas llenados
if (isset($_POST['generar_reporte'])) {
    $conn = connect();
    $query = "SELECT `llenados`.`cliente_cedula`, `llenados`.`cantidad`, `zonas`.`nombre`, `llenados`.`fecha_hora`
            FROM `llenados`
            LEFT JOIN `clientes` ON `llenados`.`cliente_cedula` = `clientes`.`cedula`
            LEFT JOIN `zonas` ON `clientes`.`zona_id` = `zonas`.`id`";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $dataRow) {
        $pdf->Cell(40,6,$dataRow['cliente_cedula'],1,0,'C');
        $pdf->Cell(60,6,$dataRow['cantidad'],1,0,'C');
        $pdf->Cell(35,6,$dataRow['nombre'],1,0,'C');
        $pdf->Cell(35,6,$dataRow['fecha_hora'],1,1,'C');
    }
}

//$pdf->AddPage(); // Agregar nueva Pagina

$pdf->Output('Resumen_Pedido_'.date('d_m_y').'.pdf', 'I'); 
// Output funcion que recibe 2 parameros, el nombre del archivo, ver archivo o descargar,
// La D es para Forzar una descarga
