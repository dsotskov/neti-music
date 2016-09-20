<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	'NAME'			=> 'Список музыки. Комплексный компонент.',
	'DESCRIPTION'	=> 'Раздел музыки',
	'COMPLEX'		=> 'Y',
	'SORT'			=> 20,
	'PATH'			=> array(
		'ID'	=> 'neti',
		'NAME'	=> 'NETI LTD.',
		'CHILD'	=> array(
			'ID'	=> 'music_catalog',
			'NAME'	=> 'Музыка',
			'SORT'	=> 10,
		),
	),
);
?>