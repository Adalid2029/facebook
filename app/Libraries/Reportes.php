<?php defined('BASEPATH') or exit('No direct script access allowed');
require_once 'Fpdf.php';
class Reportes extends FPDF
{
    public function __construct()
    {
        parent::__construct();
        $this->CI = &get_instance();
        //$this->CI->load->model('correspondencia_model');
        $this->CI->load->model('asistencia_model');
    }
    public function imprimir_documento($id_documento)
    {
        $doc = $this->CI->correspondencia_model->documento('select', $id_documento, NULL);
        $referencia = utf8_decode('Ref. ' . $doc[0]['referencia']);

        $pdf = new Reportes('P', 'mm', 'Letter');
        $pdf->AddFont('ITCEDSCR', '', 'ITCEDSCR.php');
        $pdf->SetY(-15);
        $pdf->SetMargins(30, 25, 30);
        $pdf->AddPage();
        $pdf->SetLineWidth(80);
        $pdf->SetFont('ITCEDSCR', '', 42);
        $pdf->Cell(40, 10, utf8_decode('Universidad Pública De El Alto'));
        $pdf->SetFont('Arial', '', 5);
        $pdf->Ln(11);
        $pdf->Cell(0, 5, 'Creada por Ley 2115 del 5 de septiembre de 2000 y Autónoma por Ley 2556 del 12 de noviembre de 2003', 0, 1, 'C');
        $pdf->Ln(15);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 5, $doc[0]['tipo_documento'], 0, 1, 'R');
        $pdf->Cell(0, 5, $doc[0]['cite'] . ' - ' . $doc[0]['sigla'] . ' - ' . $doc[0]['correlativo'], 0, 1, 'R');
        $pdf->Cell(0, 5, $doc[0]['denominacion_sede'] . ', ' . $doc[0]['fecha_emision'], 0, 1, 'R');
        $pdf->Cell(0, 10, utf8_decode('Señor(a):'), 0, 1, 'L');
        $pdf->Cell(0, 5, ucwords(strtolower($doc[0]['destinatario'])), 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(0, 5, ucwords(strtolower($doc[0]['descripcion_destinatario'])), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 10, 'Presente.-', 0, 1, 'L');
        $pdf->SetFont('Arial', 'BU', 11);
        if (strlen($referencia) >= 69) {
            $this->divide_cadena($referencia, 45, $pdf);
        } else {
            $pdf->Cell(0, 10, $referencia, 0, 1, 'R');
        }

        $pdf->SetFont('Arial', '', 11);
        //$pdf->MultiCell(150, 5, utf8_decode('Mediante el presente escrito le hago llegar mis saludos cordiales a su persona deseandole exitos en la labor que desempeña en beneficio de nuesMediante el presente escrito le hago llegar mis saludos cordiales a su persona deseandole exitos en la labor que desempeña en beneficio de nuesMediante el presente escrito le hago llegar mis saludos cordiales a su persona deseandole exitos en la labor que desempeña en beneficio de nuesMediante el presente escrito le hago llegar mis saludos cordiales a su persona deseandole exitos en la labor que desempeña en beneficio de nuesMediante el presente escrito le hago llegar mis saludos cordiales a su persona deseandole exitos en la labor que desempeña en beneficio de nuestra...'));
        $pdf->WriteHTML($doc[0]['contenido']);
        $pdf->Cell(0, 40, '', 0, 1, 'L');
        $pdf->Cell(0, 5, '..................................................', 0, 1, 'C');
        $pdf->Cell(0, 5, ucwords(strtolower($doc[0]['remitente'])), 0, 1, 'C');
        $pdf->Cell(0, 5, ucwords(strtolower($doc[0]['descripcion_remitente'])), 0, 1, 'C');
        $pdf->Output();
    }
    function divide_cadena($string, $corte, $pdf)
    {

        while (strlen($string) > $corte) {
            $pdf->Cell(0, 5, utf8_decode(substr($string, 0, $corte) . ' - '), 0, 1, 'R');
            $string = substr($string, $corte);
            $pdf->Cell(0);
        }
        $pdf->Cell(0, 5, utf8_decode(substr($string, 0, $corte)), 0, 1, 'R');
    }

    public function imprimir_hoja_ruta($id_hoja_ruta)
    {
        $doc = $this->CI->correspondencia_model->hoja_ruta('select', $id_hoja_ruta, NULL, NULL);
        //return var_dump($doc);
        $pdf = new Reportes('P', 'mm', 'Letter');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 25);
        //$pdf->Cell(40,10,'¡Hola, Mundo!');
        $pdf->Image('img/hr.png', 0, 0, 210);
        $pdf->Cell(155);
        $pdf->Cell(0, 14, utf8_decode('N° ' . $doc['id_hoja_ruta']));
        $pdf->Ln(16);
        $pdf->Cell(165);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 4, utf8_decode(date("Y", strtotime($doc['fecha_hr']))));
        $pdf->Ln(3);
        $pdf->Cell(50);
        $pdf->Cell(0, 15, utf8_decode(date("d/m/Y", strtotime($doc['fecha_hr'])) . '                                                               ' . date("H:i:s", strtotime($doc['fecha_hr']))));
        $pdf->Ln(4);
        $pdf->Cell(50);
        $pdf->Cell(0, 16, utf8_decode('----------'));
        $pdf->Ln(8);
        $pdf->Cell(135);
        $pdf->Cell(0, 0, utf8_decode($doc['cantidad_fojas']));
        $pdf->Ln(4);
        $pdf->Cell(21);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(0, 0, utf8_decode($doc['destinatario']));
        $pdf->Ln(4);
        $pdf->Cell(140);
        $pdf->Cell(0, 0, utf8_decode('---------------------------------------'));
        $pdf->Ln(1);
        $pdf->Cell(21);
        $pdf->Cell(0, 0, utf8_decode(trim($doc['remitente_externo']) == '') ? $doc['remitente'] : $doc['remitente_externo']);
        $pdf->Ln(5);
        $pdf->Cell(21);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(0, 0, utf8_decode($doc['referencia']));
        $pdf->Output();
    }
    /**
     * Uso  : Imprimir tarjeta de asistencia
     */
    public function imprimir_tarjeta_asistencia($data, $cargo)
    {

        require('code128.php');

        $pdf = new PDF_Code128();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 10);
        $pdf->Image('assets/images/asistencia/tarjeta.png', 10, 10, 65);
        $pdf->Ln(34);
        $pdf->SetFont('Times', 'B', 14);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(65, 10, utf8_decode($cargo), 0, 0, 'C');
        $pdf->Ln(6);
        $pdf->SetTextColor(255, 117, 020);
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(65, 10, utf8_decode($data[0]['nombre_completo']), 0, 0, 'C');
        $pdf->Ln(5);
        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(65, 10, utf8_decode($data[0]['ci']) . " " . $data[0]['expedido'], 0, 0, 'C');

        $pdf->Code128(15, 68, utf8_decode($data[0]['codigo_archivo_personal']), 55, 15);
        $pdf->Output();
    }

    /**
     * Uso : Imprimir Reporte de asistencia 
     * 
     */
    public function imprimir_reporte_asistencia($data, $data_user)
    {

        $pdf = new Reportes();
        $pdf->AddPage('P', 'Letter');
        $pdf->Image('assets/images/asistencia/reporte_asistencia.png', 2, 2, 212);
        $pdf->SetFont('Arial', 'B', 9);

        if (date('m') == '01' || date('m') == '02' || date('m') == '03' || date('m') == '04' || date('m') == '05' || date('m') == '06') {
            $titulo = "I/" . date('Y');
        } else {
            $titulo = "II/" . date('Y');
        }

        $pdf->Cell(196, 7, "PLANILLA DE ASISTENCIA PASANTIA " . $titulo, 0, 0, 'C');


        $pdf->Ln(12);
        $pdf->SetFont('Arial', '', 9);

        date_default_timezone_set('America/La_Paz');
        $pdf->SetX(43);
        $pdf->Cell(80, 7, $data_user[0]["nombre_completo"], '', 0, 'L', false);

        $pdf->SetX(132);
        $pdf->Cell(50, 7, $data_user[0]["ci"] . " " . $data_user[0]["expedido"], '', 0, 'L', false);

        $pdf->SetX(180);
        $pdf->Cell(30, 7, date('d-m-yy'), '', 0, 'L', false);

        $header = array(
            utf8_decode('Nº'),
            utf8_decode('Fecha'),
            utf8_decode('Entrada'),
            utf8_decode('Salida'),
            utf8_decode('Actividad del día')
        );

        $pdf->Ln(12);
        $pdf->SetX(10);
        $pdf->imprimirAsistencia($header, $data);

        $pdf->Output($data_user[0]["nombre_completo"] . ".pdf", "I");
    }

    /**
     * Uso: Imprimir reporte de permiso
     */
    public function imprimir_reporte_permiso($fecha_permiso, $user, $tipo_marcado, $motivo)
    {
        $pdf = new Reportes();
        $pdf->AddPage('P', 'Letter');
        $pdf->Image('assets/images/asistencia/permiso.png', 2, 2, 212);
        $pdf->Ln(15);
        $fecha = explode("-", date('Y-m-d'));

        $mes = "";
        if ($fecha[1] == "01") {
            $mes = "enero";
        } else if ($fecha[1] == "02") {
            $mes = "febrero";
        } else if ($fecha[1] == "03") {
            $mes = "marzo";
        } else if ($fecha[1] == "04") {
            $mes = "abril";
        } else if ($fecha[1] == "05") {
            $mes = "mayo";
        } else if ($fecha[1] == "06") {
            $mes = "junio";
        } else if ($fecha[1] == "07") {
            $mes = "julio";
        } else if ($fecha[1] == "08") {
            $mes = "agosto";
        } else if ($fecha[1] == "09") {
            $mes = "septiembre";
        } else if ($fecha[1] == "10") {
            $mes = "octubre";
        } else if ($fecha[1] == "11") {
            $mes = "noviembre";
        } else {
            $mes = "diciembre";
        }
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetX(15);
        $pdf->Cell(186, 20, "El Alto, " . $fecha[2] . " de " . $mes . " de " . $fecha[0], 0, 1, 'R');
        $pdf->SetX(15);
        $pdf->Cell(186, 7, utf8_decode("Señor: Ing. Walter Paco Siles"), 0, 1, 'L');
        $pdf->SetX(15);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(186, 7, utf8_decode("JEFE DE ÁREA DE SISTEMAS - UNIDAD DE POSGRADO"), 0, 1, 'L');
        $pdf->SetX(15);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(186, 10, utf8_decode("Presente.-"), 0, 1, 'L');
        $pdf->SetFont('Arial', 'BU', 12);
        $pdf->SetX(15);
        $pdf->Cell(186, 12, "REF.: SOLICITUD DE PERMISO", 0, 1, 'R');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetX(15);
        $pdf->MultiCell(186, 10, utf8_decode("               Por intermedio de la presente le hago llegar un saludo cordial y fraterno, deseándole mis mejores deseos de éxitos en las actividades que desempeña en pro de la Unidad de Posgrado."), 0, 'J', 0);

        $pdf->Ln(4);
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetX(15);
        $date = new DateTime($fecha_permiso);
        $pdf->MultiCell(186, 10, utf8_decode("                 El motivo de la misiva es solicitar de manera más atenta, me permita ausentarme de las actividades que desempeño en la Unidad de Posgrado, " . $motivo . " en la fecha " . $date->format("d-m-Y") . "."), 0, 'J', 0);

        $pdf->Ln(4);
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetX(15);
        $pdf->MultiCell(186, 10, utf8_decode("               Sin otro particular y agredeciendo su comprensión, quedo en espera de su respuesta comprometiéndome a reintegrarme a mis actividades al concluir la fecha solicitado."), 0, 'J', 0);

        $pdf->Ln(5);
        $pdf->SetX(15);
        $pdf->MultiCell(186, 10, utf8_decode("Atentamente,"), 0, 'J', 0);


        $pdf->Ln(15);
        $pdf->SetX(15);
        $pdf->MultiCell(186, 5, utf8_decode("----------------------------------------------------------"), 0, 'C', 0);
        $pdf->SetX(15);
        $pdf->MultiCell(186, 5, $user[0]['nombre_completo'], 0, 'C', 0);
        $pdf->SetX(15);
        $pdf->MultiCell(186, 5, "C.I.: " . $user[0]['ci'] . " " . $user[0]['expedido'], 0, 'C', 0);
        $pdf->SetX(15);
        $pdf->MultiCell(186, 5, $tipo_marcado, 0, 'C', 0);




        $pdf->Output("permiso.pdf", "I");
    }



    function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        $k = $this->k;
        if ($this->y + $h > $this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak()) {
            $x = $this->x;
            $ws = $this->ws;
            if ($ws > 0) {
                $this->ws = 0;
                $this->_out('0 Tw');
            }
            $this->AddPage($this->CurOrientation);
            $this->x = $x;
            if ($ws > 0) {
                $this->ws = $ws;
                $this->_out(sprintf('%.3F Tw', $ws * $k));
            }
        }
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $s = '';
        if ($fill || $border == 1) {
            if ($fill)
                $op = ($border == 1) ? 'B' : 'f';
            else
                $op = 'S';
            $s = sprintf('%.2F %.2F %.2F %.2F re %s ', $this->x * $k, ($this->h - $this->y) * $k, $w * $k, -$h * $k, $op);
        }
        if (is_string($border)) {
            $x = $this->x;
            $y = $this->y;
            if (is_int(strpos($border, 'L')))
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - $y) * $k, $x * $k, ($this->h - ($y + $h)) * $k);
            if (is_int(strpos($border, 'T')))
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - $y) * $k);
            if (is_int(strpos($border, 'R')))
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', ($x + $w) * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
            if (is_int(strpos($border, 'B')))
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - ($y + $h)) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
        }
        if ($txt != '') {
            if ($align == 'R')
                $dx = $w - $this->cMargin - $this->GetStringWidth($txt);
            elseif ($align == 'C')
                $dx = ($w - $this->GetStringWidth($txt)) / 2;
            elseif ($align == 'FJ') {
                //Set word spacing
                $wmax = ($w - 2 * $this->cMargin);
                $this->ws = ($wmax - $this->GetStringWidth($txt)) / substr_count($txt, ' ');
                $this->_out(sprintf('%.3F Tw', $this->ws * $this->k));
                $dx = $this->cMargin;
            } else
                $dx = $this->cMargin;
            $txt = str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));
            if ($this->ColorFlag)
                $s .= 'q ' . $this->TextColor . ' ';
            $s .= sprintf('BT %.2F %.2F Td (%s) Tj ET', ($this->x + $dx) * $k, ($this->h - ($this->y + .5 * $h + .3 * $this->FontSize)) * $k, $txt);
            if ($this->underline)
                $s .= ' ' . $this->_dounderline($this->x + $dx, $this->y + .5 * $h + .3 * $this->FontSize, $txt);
            if ($this->ColorFlag)
                $s .= ' Q';
            if ($link) {
                if ($align == 'FJ')
                    $wlink = $wmax;
                else
                    $wlink = $this->GetStringWidth($txt);
                $this->Link($this->x + $dx, $this->y + .5 * $h - .5 * $this->FontSize, $wlink, $this->FontSize, $link);
            }
        }
        if ($s)
            $this->_out($s);
        if ($align == 'FJ') {
            //Remove word spacing
            $this->_out('0 Tw');
            $this->ws = 0;
        }
        $this->lasth = $h;
        if ($ln > 0) {
            $this->y += $h;
            if ($ln == 1)
                $this->x = $this->lMargin;
        } else
            $this->x += $w;
    }

    // Load data
    function LoadData($file)
    {
        // Read file lines
        $lines = file($file);
        $data = array();
        foreach ($lines as $line)
            $data[] = explode(';', trim($line));
        return $data;
    }

    // Colored table
    function imprimirAsistencia($header, $data)
    {
        // Colors, line width and bold font
        // var_dump($data);
        $this->SetFillColor(105, 105, 105);
        $this->SetTextColor(255);
        $this->SetDrawColor(105, 105, 105);
        $this->SetLineWidth(.3);

        // Header
        $w = array(10, 20, 20, 20, 126);
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(192, 192, 192);
        $this->SetTextColor(0);


        // Data
        $fill = false;

        if ($data != null) {

            for ($i = 0; $i < count($data); $i++) {
                $this->SetFont('Arial', '', 8);
                $this->Cell($w[0], 8, $i + 1, 'LR', 0, 'C', $fill);
                $this->Cell($w[1], 8, date_format(date_create($data[$i]['fecha']), "d-m-yy"), 'LR', 0, 'C', $fill);
                $this->Cell($w[2], 8, ($data[$i]['ingreso'] == null) ? "" : date_format(date_create($data[$i]['ingreso']), "H:i:s"), 'LR', 0, 'C', $fill);
                $this->Cell($w[2], 8, ($data[$i]['salida'] == null) ? "S. N. M." : date_format(date_create($data[$i]['salida']), "H:i:s"), 'LR', 0, 'C', $fill);
                if (strlen($data[$i]['descripcion']) <= 88) {
                    $tamanio = 8;
                } else {
                    $tamanio = 7;
                }
                $this->SetFont('Arial', '', $tamanio);
                $this->Cell($w[4], 8, utf8_decode($data[$i]['descripcion']), 'LR', 0, 'L', $fill);

                $this->Ln();

                $fill = !$fill;
            }
        } else {

            $this->Cell(196, 8, "NO EXISTEN DATOS PARA MOSTRAR", 'LR', 0, 'C', false);
            $this->Ln();
        }



        // Closing line
        $this->Cell(array_sum($w), 0, '', 'T');
    }

    protected $B = 0;
    protected $I = 0;
    protected $U = 0;
    protected $HREF = '';

    function WriteHTML($html)
    {
        // Intérprete de HTML
        $html = str_replace("\n", ' ', $html);
        $a = preg_split('/<(.*)>/U', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
        foreach ($a as $i => $e) {
            if ($i % 2 == 0) {
                // Text
                if ($this->HREF)
                    $this->PutLink($this->HREF, $e);
                else
                    $this->Write(5, utf8_decode($e));
            } else {
                // Etiqueta
                if ($e[0] == '/')
                    $this->CloseTag(strtoupper(substr($e, 1)));
                else {
                    // Extraer atributos
                    $a2 = explode(' ', $e);
                    $tag = strtoupper(array_shift($a2));
                    $attr = array();
                    foreach ($a2 as $v) {
                        if (preg_match('/([^=]*)=["\']?([^"\']*)/', $v, $a3))
                            $attr[strtoupper($a3[1])] = $a3[2];
                    }
                    $this->OpenTag($tag, $attr);
                }
            }
        }
    }

    function OpenTag($tag, $attr)
    {
        // Etiqueta de apertura
        if ($tag == 'B' || $tag == 'I' || $tag == 'U')
            $this->SetStyle($tag, true);
        if ($tag == 'A')
            $this->HREF = $attr['HREF'];
        if ($tag == 'BR')
            $this->Ln(5);
        if ($tag == 'P')
            $this->Ln(7);
    }

    function CloseTag($tag)
    {
        // Etiqueta de cierre
        if ($tag == 'B' || $tag == 'I' || $tag == 'U')
            $this->SetStyle($tag, false);
        if ($tag == 'A')
            $this->HREF = '';
    }

    function SetStyle($tag, $enable)
    {
        // Modificar estilo y escoger la fuente correspondiente
        $this->$tag += ($enable ? 1 : -1);
        $style = '';
        foreach (array('B', 'I', 'U') as $s) {
            if ($this->$s > 0)
                $style .= $s;
        }
        $this->SetFont('', $style);
    }

    function PutLink($URL, $txt)
    {
        // Escribir un hiper-enlace
        $this->SetTextColor(0, 0, 255);
        $this->SetStyle('U', true);
        $this->Write(5, $txt, $URL);
        $this->SetStyle('U', false);
        $this->SetTextColor(0);
    }
}
