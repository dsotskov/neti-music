<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arComponentParameters = array(
	'PARAMETERS' => array( 
		'CACHE_TIME'  =>  Array('DEFAULT'=>3600),
		'SET_TITLE' => Array(),
		'DURATION_TYPE' => Array(
			'NAME' => 'Отображать длительность в',
			'TYPE' => 'LIST',
			'VALUES' => Array(
				'sec' => 'секундах',
				'min' => 'минутах',
			),
			'MULTIPLE' => 'N',
			'DEFAULT' => 'sec',
		),
		'VARIABLE_ALIASES' => array(
			'authors' => array(
				'NAME' => 'Список композиторов',
			),
			'author_new' => array(
				'NAME' => 'новый композитор',
			),
			'author_edit' => array(
				'NAME' => 'редактирование данных композитора',
			),
			'music_new' => array(
				'NAME' => 'новая композиция',
			),
			'music_edit' => array(
				'NAME' => 'редактирование данных композиции',
			),
		),
		'SEF_MODE' => array(
			'index' => array(
				'NAME' => 'Главная страница раздела',
				'DEFAULT' => 'index.php',
				'VARIABLES' => array(),
			),
			'authors' => array(
				'NAME' => 'Список композиторов',
				'DEFAULT' => 'authors/',
				'VARIABLES' => array(),
			),
			'author_new' => array(
				'NAME' => 'Новый композитор',
				'DEFAULT' => 'authornew/',
				'VARIABLES' => array('title'),
			),
			'author_edit' => array(
				'NAME' => 'Изменить композитора',
				'DEFAULT' => 'authoredit/#author_edit#/',
				'VARIABLES' => array('title'),
			),
			'music_new' => array(
				'NAME' => 'Новая композиция',
				'DEFAULT' => 'musicnew/',
				'VARIABLES' => array('title'),
			),
			'music_edit' => array(
				'NAME' => 'Изменить данные композиции',
				'DEFAULT' => 'musicedit/#music_edit#/',
				'VARIABLES' => array('title'),
			),
		),
	),
);
?>