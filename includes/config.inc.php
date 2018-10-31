<?php

// A more formal comments structure, only used in this one page but could (should) be used everywhere:
/* 	*
	* Title: config.inc.php
	* Created by:  Korenev
	* Contact: korenev@iled.com.ua
	* Last modified: 16.10.2018
	*
	* Configuration file does the following things:
	* - Has site settings in one location.
	* - Stores URLs and URIs as constants.
	* - Starts the session.
	* - Sets how errors will be handled.
	* - Defines a redirection function.
	*
	* This script is begun in Chapter 3.
*/

// ********************************** //
// ************ SETTINGS ************ //

// Функционирует ли сайт?
if(!defined('LIVE')) DEFINE('LIVE', false);

// Отсылаются сообщения об ошибках
DEFINE('CONTACT_EMAIL', 'korenev@iled.com.ua');

// Идентификация местоположения файлов и URL-ссылки сайта:
define('BASE_URI', 'D:/OSPanel/domains/');
define('BASE_URL', 'coffee/');
define('MYSQL', BASE_URI . 'mysql_coffee.inc.php');

// Для сложного кода HTML
define('BOX_BEGIN', '<!-- box begin --><div class="box alt"><div class="left-top-corner"><div class="right-top-corner"><div class="border-top"></div></div></div><div class="border-left"><div class="border-right"><div class="inner">');
define('BOX_END', '</div></div></div><div class="left-bot-corner"><div class="right-bot-corner"><div class="border-bot"></div></div></div></div><!-- box end -->');

// Для Authorize.net
define('API_LOGIN_ID', '2ErR9S2h8R');
define('TRANSACTION_KEY', '73N77c7bH6TbZd86');

// ************ КОНСТАНТЫ *********** //
// ********************************** //

// ****************************************** //
// ************ УПРАВЛЕНИЕ ОШИБКАМИ ************ //

// Функция, предназначенная для обработки ошибок.
// Принимает пять аргументов: номер ошибки, сообщение об ошибке (строка), название файла с ошибкой (строка), 
// номер строки с ошибкой и значения переменных на этот момент времени (массив).
// Возвращает true.

function my_error_handler ($e_number, $e_message, $e_file, $e_line, $e_vars) {

	// Создание сообщения об ошибке:
	$message = "Произошла ошибка в сценарии '$e_file' в строке $e_line:\n$e_message\n";
	
	// Добавление обратной трассировки:
	$message .= "<pre>" .print_r(debug_backtrace(), 1) . "</pre>\n";
	
	// Либо просто включение $e_vars в сообщение:
	//	$message .= "<pre>" . print_r ($e_vars, 1) . "</pre>\n";

	if (!LIVE) { // отображение сообщения об ошибке в окне браузера.
		
		echo '<div class="error">' . nl2br($message) . '</div>';

	} else { // разработка (вывод ошибки на печать).

		// Отправка сообщения об ошибке по электронной почте:
		error_log ($message, 1, CONTACT_EMAIL, 'From:korenev@iled.com.ua');
		
		// Вывод сообщения об ошибке в окне браузера, если ошибка не является предупреждением:
		if ($e_number != E_NOTICE) {
			echo '<div class="error">Произошла системная ошибка. Приносим извинения за доставленные неудобства.</div>';
		}

	} // завершение блока IF-ELSE $live .
	
	return true; // PHP не пытается обрабатывать ошибку.

} // завершение определения my_error_handler().

// Использование моего обработчика ошибок:
set_error_handler ('my_error_handler');

// ************ ERROR MANAGEMENT ************ //
// ****************************************** //

// Пропуск закрывающего тега РНР во избежание ошибок 'headers already sent' errors!