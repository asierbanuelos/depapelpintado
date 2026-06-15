<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter URL Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/url_helper.html
 */

// ------------------------------------------------------------------------


if ( ! function_exists('text2url'))
{

	function text2url($string) {
		$string = text2url_clean($string);
		$string = trim($string);
		$spacer = "-";
		$string = strtolower($string);
		$string = trim(preg_replace("/[^ A-Za-z0-9_]/", " ", $string));
		$string = preg_replace("/[ \t\n\r]+/", "-", $string);
		$string = str_replace(" ", $spacer, $string);
		$string = preg_replace("/[ -]+/", "-", $string);
		return $string;
	}
	function text2url_clean($String) {
		$String = str_replace(array('á', 'à', 'â', 'ã', 'ª', 'ä','&aacute;'), 'a', $String);
		$String = str_replace(array('Á', 'À', 'Â', 'Ã', 'Ä','&Aacute;'), "A", $String);
		$String = str_replace(array('Í', 'Ì', 'Î', 'Ï','&Iacute;'), "I", $String);
		$String = str_replace(array('í', 'ì', 'î', 'ï','&iacute;'), "i", $String);
		$String = str_replace(array('é', 'è', 'ê', 'ë','&eacute;'), "e", $String);
		$String = str_replace(array('É', 'È', 'Ê', 'Ë','&Eacute;'), "E", $String);
		$String = str_replace(array('ó', 'ò', 'ô', 'õ', 'ö', 'º','&oacute;'), "o", $String);
		$String = str_replace(array('Ó', 'Ò', 'Ô', 'Õ', 'Ö','&Oacute;'), "O", $String);
		$String = str_replace(array('ú', 'ù', 'û', 'ü','&uacute;'), "u", $String);
		$String = str_replace(array('Ú', 'Ù', 'Û', 'Ü','&Uacute;'), "U", $String);
		$String = str_replace(array('[', '^', '´', '`', '¨', '~', ']','¿','?','!','¡','&iquest;','&iexcl;'), "", $String);
		$String = str_replace("ç", "c", $String);
		$String = str_replace("Ç", "C", $String);
		$String = str_replace(array("ñ",'&ntilde;'), "n", $String);
		$String = str_replace(array("Ñ",'&Ntilde;'), "N", $String);
		$String = str_replace("Ý", "Y", $String);
		$String = str_replace("ý", "y", $String);
		return $String;
	}
}
