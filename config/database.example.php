<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS (EXAMPLE)
| -------------------------------------------------------------------
| Copia este archivo como config/database.php y rellena los valores
| reales. config/database.php NO se sube al repositorio (ver
| .gitignore) porque contiene credenciales de produccion.
*/

$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'CHANGE_ME';
$db['default']['password'] = 'CHANGE_ME';
$db['default']['database'] = 'CHANGE_ME';
$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = FALSE;
$db['default']['db_debug'] = FALSE;
$db['default']['cache_on'] = TRUE;
$db['default']['cachedir'] = 'application/cache';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;
