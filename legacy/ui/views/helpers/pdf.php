<?php 
App::import('Vendor', 'Ui.fpdf');

if (!defined('PARAGRAPH_STRING')) define('PARAGRAPH_STRING', '~~~');

if (!defined('FPDF_FONTPATH')) {
	define('FPDF_FONTPATH', APP.'plugins/ui/vendors/fpdf/font/');
}

if (!defined('PT')) { // COnverts typographic points to milimeters use 5 * PT
	define('PT', 25.4/72);
}

class PdfHelper extends AppHelper {
    var $fpdf;
	var $defaultSettings = array(
		'orientation' => 'P',	// Orientation: (P)ortrait (L)andscape
		'unit' => 'mm',			// Measurement Units
		'format' => 'A4',		// Page format
		'lineWidth' => 0.22		// Width for lines
		);
	var $settings;
	var $position = array(
		'x' => 10,
		'y' => 10,
		'width' => 128,
		'last_style' => 'default'
		);
	var $styles = array(
		'default' => array(
			'line-height' => 5,
			'font-family' => 'Helvetica',
			'font-size' => 10,
			'font-style' => '',
			'border' => 0,	// 1: border or T R B L in any order to specify what borders to draw
			'before' => 0,
			'after' => 0,
			'text-align' => 'left',
			'background' => false
			)
		);
	var $style = 'default';
	
	// TODO Soporte para poder definir espaciado de líneas en distintas unidades, conversión entre pt, in, cm, mm, líneas, uso de retícula, etc.
	// TODO Tablas. Gestión de las alturas, estilos para celdas, etc

    public function setup($settings = array()) {
		$this->settings = array_merge($this->defaultSettings, $settings);
        $this->fpdf = new FPDF();
		extract ($this->settings);
        $this->fpdf->FPDF($orientation, $unit, $format);
		$this->fpdf->setLineWidth($lineWidth);
		// De momento no queremos que salte sola de página
		$this->fpdf->SetAutoPageBreak(false);
		$this->position['x'] = $this->fpdf->GetX();
		$this->position['y'] = $this->fpdf->GetY();
    }

/**
 * Wrapper for fpdf->addpage. Adds a new page to the document
 *
 * @param string $orientation (P)ortrait (L)andscape
 * @param string $size
 *
 * @return void
 */
	public function addPage($orientation='', $size='') {
		$this->fpdf->AddPage($orientation, $size);
	}

/**
 * Define a text style sheet
 *
 * @param string $style    The name for the stylesheet
 * @param string $settings An array of settings
 *
 * @return void
 */
	public function defineStyle($style, $settings = array()) {
		$base = 'default';
		if (!empty($settings['extends'])) {
			$base = $settings['extends'];
		}
		$this->styles[$style] = array_merge($this->styles[$base], $settings);
	}

	public function rectangle($x, $y, $width, $height, $line = 0.25, $lineColor = 0, $backgroundColor = 251) {
		$this->fpdf->SetLineWidth($line);
		$this->fpdf->SetDrawColor($lineColor);
		$this->fpdf->SetFillColor($backgroundColor);
		$this->fpdf->Rect($x, $y, $width, $height, 'DF');
	}

    /**
 * Draws a Line With Dashes
 *
     * @param string $x
     * @param string $y
     * @param string $xx
     * @param string $yy
     * @param string $dash  Dash lenght
     * @param string $sep   Separation between dashes
 * @param string     $width the width of the line in mm
 * @param string     $color The color
     *
 * @return void
 */
	public function dashLine($x, $y, $xx, $yy, $dash = 1, $sep = 1, $width = 0.25, $color = 0) {
		$stepLength = ($dash + $sep) * $width;
		// Corrección para conseguir dash más precisos por el tipo de cap que tiene la línea
		$dash = ($dash - ($dash > 1 ? 1 : 0.75)) * $width;
		$length = sqrt( pow($xx - $x, 2) + pow($yy - $y, 2));
		$steps = $length / $stepLength;
		$horizontal = $xx - $x;
		$vertical = $yy - $y;
		// Calculate dash line
		$xl = $horizontal / $length * $dash;
		$yl = $vertical / $length * $dash;
		// Calculate delta for new dash
		$xd = $horizontal / $length * $stepLength;
		$yd = $vertical / $length * $stepLength;
		for ($step=0; $step < $steps; $step++) {
			// Start points for dash
			$xs = $x + $xd * $step;
            $ys = $y + $yd * $step;
			$this->line($xs, $ys, $xs+$xl, $ys+$yl, $width, $color);
		}
	}

    /**
     * Draws a line
     *
     * @param string $x     X start coordinate
     * @param string $y     Y start coordinate
     * @param string $xx    X end coordinate
     * @param string $yy    Y end coordiante
     * @param string $width Width in mm
     * @param string $color Color (0-255) black to white
     *
     * @return void
     */
    public function line($x, $y, $xx, $yy, $width = 0.25, $color = 0)
    {
        $this->fpdf->SetLineWidth($width);
        $this->fpdf->SetDrawColor($color);
        $this->fpdf->Line($x, $y, $xx, $yy);
    }

/**
 * Writes an image file
 *
 * @param string $x X coordinate
 * @param string $y Y coordinate
 * @param string $image The image file
 * @param string $width THe width to display the image
 * @param string $height The height of the image, 0 for proportional scaling
 *
 * @return void
 */
	public function writeImageAt($x, $y, $image, $width = 0, $height = 0) {
		$this->fpdf->Image($image, $x, $y, $width, $height);
	}

    /**
     * Relies on writeTextAt. Writes a text in the current position
     *
     * @param string $text  The text
     * @param string $style An stylesheet
     *
     * @return void
     */
    public function writeText($text = '', $style = 'default')
    {
        $this->writeTextAt(false, false, 0, $text, $style);
    }

/**
 * Write text at a given position
 *
 * @param string $x X Coordinate
 * @param string $y Y Coordinate
 * @param string $width Max width for text box
 * @param string $text The text
 * @param string $style An stylesheet, defaults to default
 *
 * @return void
 */
	public function writeTextAt($x = false, $y = false, $width = 100, $text='', $style = 'default') {
		// Gestiona los estilos de texto, asegurándose de que tienen todas las especificaciones necesarias
		$style = $this->__parseTextStyles($style);
		// Retoma la última posición si no se especifica una nueva
		if ($x === false) {
			$x = $this->position['x'];
		};
		if ($y === false) {
			$y = $this->position['y'];
		}
		if ($width == 0) {
			$width = $this->position['width'];
		}
		$lastStyle = $this->__parseTextStyles($this->position['last_style']);
		// Prepara el texto y los estilos y lo escribe
		$text = utf8_decode ($text);
		$y = ife($lastStyle['after'] > $style['before'], $lastStyle['after']-$style['before'], $style['before']-$lastStyle['after']) + $y;
		$this->fpdf->SetFont($style['font-family'], $style['font-style'], $style['font-size']);
		$this->fpdf->SetXY($x, $y);
		if (!empty($style['background'])) {
			$this->fpdf->SetFillColor($style['background']);
		}
		$this->fpdf->MultiCell($width, $style['line-height'], $text, $style['border'], $style['text-align'], $style['background']);
		// Calculo de la nueva posición Y. Obtenemos la que haya quedado por defecto y le añadimos lo que corresponde de valorar after.

		$this->position['y'] = $this->fpdf->GetY() + $style['after'];
		$this->position['x'] = $x;
		$this->position['width'] = $width;
	}

    function __parseTextStyles($newStyle)
    {
        // Si recibe un array lo fusiona con el estilo por defecto para asegurarnos de que adquiere todas las propiedades que necesitamos que tenga. Si es una cadena, busca un estilo predefinido. Si no toma el estilo por defecto
        if (is_array($newStyle)) {
            $newStyle = array_merge($newStyle, $this->styles['default']);
        } elseif (is_string($newStyle) && isset ($this->styles[$newStyle])) {
            $newStyle = $this->styles[$newStyle];
        } else {
            $newStyle = $this->styles['default'];
        }
        $longFontStyles = array('bold', 'italic', 'underline');
        $shortFontStyles = array('B', 'I', 'U');
        $newStyle['font-style'] = str_replace(
            ' ',
            '',
            str_replace($longFontStyles, $shortFontStyles, $newStyle['font-style'])
        );

        $longAlignStyles = array('left', 'right', 'center', 'justify');
        $shortAlignStyles = array('L', 'R', 'C', 'J');
        $newStyle['text-align'] = str_replace($longAlignStyles, $shortAlignStyles, $newStyle['text-align']);

        return $newStyle;
    }

    public function save($name)
    {
        $destination = 'F';
        $this->output($name, $destination);
	}

/**
 * Outputs the document
 *
 * @param string $name        A file name
 * @param string $destination // I D F S
 *                            I: send the file inline to the browser. The plug-in is used if available.
 * The name given by name is used when one selects the "Save as" option on the link generating the PDF.
 * D: send to the browser and force a file download with the name given by name.
 * F: save to a local file with the name given by name.
 * S: return the document as a string. name is ignored.
 *
 * @return void
 */
    public function output($name = 'pagetest.pdf', $destination = 'I') {
		if ($destination == 'F') {
			$name = 'files/'.$name;
		}
		// TODO Si $destination es 'F' poder configurar dónde se van a guardar los archivos. Ver cómo obtener URL
		// TODO Idem, no enviar header. Sólo necesito header cuando es para descargar
        return $this->fpdf->Output($name, $destination);
    }

/**
 * Sets metadata
 *
 * @param array $metadata
 * keys:
 *		author
 *		creator
 *		subject
 *		title
 *		keywords (comma separated)
 *
 * @return void
 */
	public function setMetaData($metadata) {
		$metadata = array_intersect_key($metadata, array(
			'author' => true,
			'creator' => true,
			'subject' => true,
			'title' => true,
			'keywords' => true
		));
		if (empty($metadata)) {
			return;
		}
		foreach ($metadata as $key => $value) {
			$method = 'Set'.ucfirst($key);
			$this->fpdf->{$method}($value, true);
		}
    }
	
/**
 * Draws a table in the X, Y coordinates
 *
 * @param string $x       X Coordinate
 * @param string $y       Y Coordinate
 * @param array  $data    The data to show in the table
 * array(
 *		array(
 *			'column_1' => 'content of column_1 in 1st row',
 *			'column_2' => 'content of column_2 in 1st row',
 *		),
 *		array(
 *			'column_1' => 'content of column_1 in 2nd row',
 *			'column_2' => 'content of column_2 in 2nd row',
 *		),
 *		... other rows
 * );
 *
 * @param array $settings Description of the table
 *
 *	array(
 *		'columns' => array(  // Description of every column, width and style
 *				'cabecera' => array(
 *					'width' => 48,
 *					'style' => 'pie',
 *					'label' => 'Label for column header'
 *				),
 *				'contenido' => array(
 *					'width' => 80,
 *					'label' => 'column 2 header'
 *				),
 *				'_style' => 'cuerpo' // Default column style
 *			),
 *		'caption' => array(
 *			'text' => 'Ejemplo de tabla',
 *			'position' => 'top'
 *			),
 *		'table' => array(
 *			'width' => 128,
 *			'headers' => false // or true to show headers
 *			'header-style' => 'style'
 *			),
 *		'rows' => array(
 *			'_height' => 7
 *			)
 *		);
 *
 * @return void
 */
	public function writeTableAt($x, $y, $data, $settings = false) {
		// Obtener width de la tabla, y si no se obtiene, coger el por defecto que está en this->position
		// Obtener si es necesario anchos por defecto para las columnas
		if (isset ($settings['rows']['_height'])) {
			$height = $settings['rows']['_height'];
		} else {
			 $settings['rows']['_height'] = $height = 5;
		}
		if (!isset ($settings['table']['width'])) {
			$settings['table']['width'] = $this->position['width'];
		}
		$numColumns = count($data[0]);
		if ($anchos = Set::extract($settings, 'columns.{n}.width')) {
			$defColumns = count($settings['columns']);
			$width = 0;
			foreach ($anchos as $value) {
				$width += $value;
			}
			if (($numColumns > $defColumns) and ($width < $this->position['width'])) {
				$settings['columns']['_width'] = ($settings['table']['width'] - $width) / ($numColums - $defColums);
			}
		} else {
			$width = $settings['table']['width'];
			$settings['columns']['_width'] = $width / $numColumns;
		}
		// Fijar estilos por defecto para las columnas que no lo tengan
		if (empty ($settings['columns']['_style'])) {
			$settings['columns']['_style'] = 'default';
		}

		// Caption. Obtener width de la tabla
		// Antes de dibujar las celdas averiguo si tengo que dibujar el Caption y en qué posición. Si es antes de la tabla tengo que bajar esta un poco, si es después, tengo que esperar a que se dibuje la tabla para saber en donde le toca. Al menos mientras no tengo un método que me calcule las alturas de las filas
		$drawCaption = false;
		if (isset($settings['caption'])) {
			$drawCaption = true;
			if (!isset($settings['caption']['style'])) {
				$settings['caption']['style'] = 'default';
			}
			if (!isset($settings['caption']['position'])) {
				$settings['caption']['position'] = 'top';
			}
			if (strtolower($settings['caption']['position']) == 'top') {
				$captionY = $y;
				$y = $captionY + $height;
			} else {
				$captionY = false;
			}
		}
		// Cabecera. La extraigo de la primera fila de datos (que es la de clave 0, claro)
		// TODO where to define Style for headers
		if (!empty($settings['table']['headers'])) {
			$dataColumns = array_keys($settings['columns']);
			$headers = array();
			foreach ($dataColumns as $column) {
				if (strpos($column, '_') === 0) {
					continue;
				}
				if (empty($settings['columns'][$column]['label'])) {
					$settings['columns'][$column]['label'] = $data[0][$column];
				}
				$headers[$column] = $settings['columns'][$column]['label'];
			}
			$this->writeTableRowAt($x, $y, $headers, $settings);
			$y += $height;
        }

		// Celdas
		$yy = $y;
		foreach ($data as $number => $row) {
			$this->writeTableRowAt($x, $yy, $row, $settings);
			$yy += $height;
		}
		// Poner Caption
		if ($drawCaption) {
			if (!$captionY) {
				$captionY = $yy;
			}
			$this->writeTableCellAt($x, $captionY, $width, $height, $settings['caption']['text'], $settings['caption']['style']) ;
		}
	}
	
	function writeTableRowAt($x, $y, $data, &$settings) {
		$xx = $x;
		$yy = $y;
		$height = $settings['rows']['_height'];
		foreach ($data as $column => $value) {
			// Calcular nueva posición
			if (empty($settings['columns'][$column]['width'])) {
				$width = $settings['columns']['_width'];
			} else {
				$width = $settings['columns'][$column]['width'];
			};
			if (empty($settings['columns'][$column]['style'])) {
				$style = $settings['columns']['_style'];
			} else {
				$style = $settings['columns'][$column]['style'];
			}
			$this->writeTableCellAt($xx, $yy, $width, $height, $value, $style);
			$xx += $width;
		}
    }

	function writeTableCellAt($x, $y, $width, $height, $text='', $style = 'default') {
		$style = $this->__parseTextStyles($style);
		// Estos ajustes los tenemos que reescribir
		$style['line-height'] = $height;
		$style['border'] = 1;
		// Prepara el texto y los estilos y lo escribe. La decodificación es necesaria porque la librería no soporta UTF-8
		$text = utf8_decode ($text);
		extract($style);
		$this->fpdf->SetFont($style['font-family'], $style['font-style'], $style['font-size']);
		$this->fpdf->SetXY($x, $y);
		if (!empty($style['background'])) {
			$this->fpdf->SetFillColor($style['background']);
		}
		$this->fpdf->Cell($width, $style['line-height'], $text, $style['border'], 0, $style['text-align'], $style['background']);
	}

}

?>
