<?php
/**
 * Minimal XLSX reader.
 *
 * An .xlsx file is a zip of XML parts, and PHP ships both `ZipArchive`
 * and SimpleXML, so reading one needs no third-party library. That
 * matters here: PhpSpreadsheet would pull a `vendor/` tree into this
 * plugin, which then has to be built or committed and shipped to
 * Cloudways — and there is no deploy pipeline yet (KW plan, phase 9).
 *
 * Scope is deliberately narrow: enough to read the content workbook
 * (strings and numbers in a rectangular grid). It does not handle
 * dates, styles or formulas beyond their cached values.
 *
 * @package AlmicaHealingCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Reads the sheets of an .xlsx file into plain arrays.
 */
class Almicahealing_Xlsx_Reader {

	/**
	 * Shared string table, indexed as the sheet XML references it.
	 *
	 * @var string[]
	 */
	private $shared = array();

	/**
	 * Open zip handle.
	 *
	 * @var ZipArchive
	 */
	private $zip;

	/**
	 * Opens the workbook.
	 *
	 * @param string $path Absolute path to the .xlsx file.
	 * @throws RuntimeException If the file can't be opened.
	 */
	public function __construct( $path ) {
		if ( ! class_exists( 'ZipArchive' ) ) {
			throw new RuntimeException( 'La extensión zip de PHP no está disponible.' );
		}

		if ( ! file_exists( $path ) ) {
			throw new RuntimeException( sprintf( 'No se encontró el archivo: %s', esc_html( $path ) ) );
		}

		$this->zip = new ZipArchive();

		if ( true !== $this->zip->open( $path ) ) {
			throw new RuntimeException( sprintf( 'No se pudo abrir %s como archivo .xlsx.', esc_html( $path ) ) );
		}

		$this->read_shared_strings();
	}

	/**
	 * Closes the zip handle.
	 */
	public function close() {
		if ( $this->zip ) {
			$this->zip->close();
			$this->zip = null;
		}
	}

	/**
	 * Loads an XML part as SimpleXML.
	 *
	 * @param string $name Path inside the archive.
	 * @return SimpleXMLElement|null
	 */
	private function xml( $name ) {
		$raw = $this->zip->getFromName( $name );

		if ( false === $raw ) {
			return null;
		}

		$previous = libxml_use_internal_errors( true );
		$xml      = simplexml_load_string( $raw );
		libxml_clear_errors();
		libxml_use_internal_errors( $previous );

		return $xml ? $xml : null;
	}

	/**
	 * Builds the shared-string table.
	 *
	 * A shared string is either a single <t>, or a run of <r><t> pieces
	 * when part of the cell was styled differently — those are joined,
	 * since the styling isn't content.
	 */
	private function read_shared_strings() {
		$xml = $this->xml( 'xl/sharedStrings.xml' );

		if ( ! $xml ) {
			return;
		}

		foreach ( $xml->si as $si ) {
			if ( isset( $si->t ) ) {
				$this->shared[] = (string) $si->t;
				continue;
			}

			$text = '';

			foreach ( $si->r as $run ) {
				$text .= (string) $run->t;
			}

			$this->shared[] = $text;
		}
	}

	/**
	 * Maps sheet names to their XML part, via the workbook relationships.
	 *
	 * @return array<string,string> Sheet name => path inside the archive.
	 */
	public function sheet_map() {
		$workbook = $this->xml( 'xl/workbook.xml' );
		$rels     = $this->xml( 'xl/_rels/workbook.xml.rels' );

		if ( ! $workbook || ! $rels ) {
			return array();
		}

		$targets = array();

		// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase -- OOXML element name.
		foreach ( $rels->Relationship as $rel ) {
			$targets[ (string) $rel['Id'] ] = ltrim( (string) $rel['Target'], '/' );
		}

		$map = array();

		foreach ( $workbook->sheets->sheet as $sheet ) {
			$id     = (string) $sheet->attributes( 'http://schemas.openxmlformats.org/officeDocument/2006/relationships' )->id;
			$target = $targets[ $id ] ?? '';

			if ( ! $target ) {
				continue;
			}

			// Targets are usually relative to xl/, occasionally absolute.
			$path = ( 0 === strpos( $target, 'xl/' ) ) ? $target : 'xl/' . $target;

			$map[ (string) $sheet['name'] ] = $path;
		}

		return $map;
	}

	/**
	 * Converts a cell reference's column letters to a 1-based index.
	 *
	 * @param string $ref Cell reference, e.g. "AB12".
	 * @return int
	 */
	private static function column_index( $ref ) {
		preg_match( '/^([A-Z]+)/', $ref, $m );

		$letters = $m[1] ?? 'A';
		$index   = 0;

		foreach ( str_split( $letters ) as $letter ) {
			$index = $index * 26 + ( ord( $letter ) - 64 );
		}

		return $index;
	}

	/**
	 * Resolves a single cell's value to a string.
	 *
	 * @param SimpleXMLElement $cell The <c> element.
	 * @return string
	 */
	private function cell_value( $cell ) {
		$type = (string) $cell['t'];

		if ( 'inlineStr' === $type ) {
			if ( isset( $cell->is->t ) ) {
				return (string) $cell->is->t;
			}

			$text = '';

			foreach ( $cell->is->r as $run ) {
				$text .= (string) $run->t;
			}

			return $text;
		}

		if ( ! isset( $cell->v ) ) {
			return '';
		}

		$raw = (string) $cell->v;

		if ( 's' === $type ) {
			return $this->shared[ (int) $raw ] ?? '';
		}

		if ( 'b' === $type ) {
			return '1' === $raw ? 'true' : 'false';
		}

		if ( 'e' === $type ) {
			return '';
		}

		// Numbers arrive as "850" or "850.0"; trim a pointless decimal so
		// downstream code sees the value an editor typed.
		if ( '' === $type || 'n' === $type ) {
			if ( is_numeric( $raw ) && floor( (float) $raw ) === (float) $raw ) {
				return (string) (int) round( (float) $raw );
			}
		}

		return $raw;
	}

	/**
	 * Reads one sheet as a list of associative rows keyed by the header row.
	 *
	 * @param string $path        Sheet path inside the archive.
	 * @param int    $header_row  1-based row holding the column names.
	 * @param int    $first_data  1-based first row of data.
	 * @return array{headers: string[], rows: array<int,array<string,string>>}
	 */
	public function read_sheet( $path, $header_row = 1, $first_data = 3 ) {
		$xml = $this->xml( $path );

		if ( ! $xml ) {
			return array(
				'headers' => array(),
				'rows'    => array(),
			);
		}

		$grid = array();

		// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase -- OOXML element name.
		foreach ( $xml->sheetData->row as $row ) {
			$number = (int) $row['r'];

			foreach ( $row->c as $cell ) {
				$ref = (string) $cell['r'];
				$col = self::column_index( $ref );

				$grid[ $number ][ $col ] = trim( $this->cell_value( $cell ) );
			}
		}

		$headers = array();

		foreach ( $grid[ $header_row ] ?? array() as $col => $value ) {
			if ( '' !== $value ) {
				$headers[ $col ] = $value;
			}
		}

		$rows = array();

		foreach ( $grid as $number => $cells ) {
			if ( $number < $first_data ) {
				continue;
			}

			$assoc = array();

			foreach ( $headers as $col => $name ) {
				$assoc[ $name ] = $cells[ $col ] ?? '';
			}

			// Skip rows that are entirely blank across the known columns.
			if ( ! array_filter( $assoc, 'strlen' ) ) {
				continue;
			}

			$assoc['__row'] = $number;
			$rows[]         = $assoc;
		}

		return array(
			'headers' => array_values( $headers ),
			'rows'    => $rows,
		);
	}
}
