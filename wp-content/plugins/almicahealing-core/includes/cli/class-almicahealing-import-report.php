<?php
/**
 * Collector for problems found while validating the content workbook.
 *
 * Kept apart from import.php because the WordPress standard wants a file
 * to hold either functions or a class, not both.
 *
 * @package AlmicaHealingCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Collects problems found during validation.
 */
class Almicahealing_Import_Report {

	/**
	 * Fatal problems. Any of these aborts the import.
	 *
	 * @var string[]
	 */
	public $errors = array();

	/**
	 * Non-fatal notes worth printing.
	 *
	 * @var string[]
	 */
	public $warnings = array();

	/**
	 * Records a fatal problem.
	 *
	 * @param string $sheet Sheet name.
	 * @param int    $row   1-based row number in that sheet.
	 * @param string $msg   What's wrong.
	 */
	public function error( $sheet, $row, $msg ) {
		$this->errors[] = $row ? sprintf( '%s fila %d: %s', $sheet, $row, $msg ) : sprintf( '%s: %s', $sheet, $msg );
	}

	/**
	 * Records a non-fatal note.
	 *
	 * @param string $sheet Sheet name.
	 * @param int    $row   1-based row number, or 0.
	 * @param string $msg   The note.
	 */
	public function warn( $sheet, $row, $msg ) {
		$this->warnings[] = $row ? sprintf( '%s fila %d: %s', $sheet, $row, $msg ) : sprintf( '%s: %s', $sheet, $msg );
	}
}
