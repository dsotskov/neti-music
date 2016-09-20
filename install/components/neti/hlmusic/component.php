<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
if (!CModule::IncludeModule('netihlmusic'))
{
	ShowError('Не установлен модуль netihlmusic');
	return 0;
}
$APPLICATION->AddChainItem('Список композиций',$arParams['SEF_FOLDER']);

$arComponentVariables = array('author_new', 'author_edit', 'music_new', 'music_edit', 'authors');
$arDefaultUrlTemplates404 = array(
	'index' => 'index.php',
	'authors' => 'authors/',
	'author_new' => 'authornew/',
	'author_edit' => 'authoredit/#author_edit#/',
	'music_new' => 'musicnew/',
	'music_edit' => 'musicedit/#music_edit#/',
);
$arDefaultVariableAliases404 = array();

$arResult['AUTHOR_FILTER_URI'] = $arParams['SEF_FOLDER'].'?author_id=';

if ($arParams['SEF_MODE'] == 'Y')
{
	$arVariables = array();

	$arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates($arDefaultUrlTemplates404, $arParams['SEF_URL_TEMPLATES']);
	$componentPage = CComponentEngine::ParseComponentPath($arParams['SEF_FOLDER'], $arUrlTemplates, $arVariables);	
	
	$arResult['NEW_AUTHOR_URI'] = $arParams['SEF_FOLDER'].$arUrlTemplates['author_new'];
	$arResult['NEW_MUSIC_URI'] = $arParams['SEF_FOLDER'].$arUrlTemplates['music_new'];
	$arResult['EDIT_MUSIC_URI'] = $arParams['SEF_FOLDER'].$arUrlTemplates['music_edit'];
	$arResult['EDIT_AUTHOR_URI'] = $arParams['SEF_FOLDER'].$arUrlTemplates['author_edit'];
	$arResult['AUTHORS_URI'] = $arParams['SEF_FOLDER'].$arUrlTemplates['authors'];
}
else
{
	$arVariableAliases = CComponentEngine::MakeComponentVariableAliases($arDefaultVariableAliases404, $arParams['VARIABLE_ALIASES']);
	CComponentEngine::InitComponentVariables(false, $arComponentVariables, $arVariableAliases, $arVariables);
	
	if (isset($arVariables['author_new']))
		$componentPage = 'author_new';
	elseif (isset($arVariables['authors']))
		$componentPage = 'authors';
	elseif (isset($arVariables['music_new']))
		$componentPage = 'music_new';
	elseif (isset($arVariables['author_edit']) && !empty($arVariables['author_edit']))
		$componentPage = 'author_edit';
	elseif (isset($arVariables['music_edit']) && !empty($arVariables['music_edit']))
		$componentPage = 'music_edit';
	else
		$componentPage = 'index';

	$arResult['NEW_AUTHOR_URI'] = $arParams['SEF_FOLDER'].'?'.$arVariableAliases['author_new'];
	$arResult['NEW_MUSIC_URI'] = $arParams['SEF_FOLDER'].'?'.$arVariableAliases['music_new'];
	$arResult['EDIT_MUSIC_URI'] = $arParams['SEF_FOLDER'].'?'.$arVariableAliases['music_edit'];;
	$arResult['EDIT_AUTHOR_URI'] = $arParams['SEF_FOLDER'].'?'.$arVariableAliases['author_edit'];;
	$arResult['AUTHORS_URI'] = $arParams['SEF_FOLDER'].'?'.$arVariableAliases['authors'];;
}

$arResult['SORT_DATA'] = array(
	'music' => array(
		'NAME' => 'Название композиции',
		'FIELD' => 'UF_NAME',
		'ACTIVE' => FALSE),
	'author' => array(
		'NAME' => 'Имя автора',
		'FIELD' => 'AUTHOR.UF_NAME',
		'ACTIVE' => FALSE),
	'duration' => array(
		'NAME' => 'Длительность композиции',
		'FIELD' => 'UF_DURATION',
		'ACTIVE' => FALSE),
	);

$arResult = array_merge(
	array(
		'DURATION_TYPE' => $arParams['DURATION_TYPE'],
		'SEF_MODE' => $arParams['SEF_MODE'],
		'SEF_FOLDER' => $arParams['SEF_FOLDER'],
		'USE_REVIEW' => $arParams['USE_REVIEW'],
		'VARIABLES' => $arVariables,
		'ALIASES' => $arParams['SEF_MODE'] == 'Y'? array(): $arVariableAliases,
		'SET_TITLE' => $arParams['SET_TITLE'],
	),
	$arResult
);

if ($componentPage == 'index')
{
	$filter = array();
	$order = array();
	$arResult['FILTER_DATA'] = '';
	
	$pAuthorID = (isset($_REQUEST['author_id'])) ? @intval($_REQUEST['author_id']) : 0 ;
	if (!empty($pAuthorID))
	{
		$result = Neti_AuthorsTable::getByID($pAuthorID);
		if($arRes = $result->Fetch())
		{
			$filter['UF_AUTHOR_ID'] = $pAuthorID;
			$arResult['FILTER_DATA'] = $arRes['UF_NAME'];
		}
	}
	
	$pSortName = (isset($_REQUEST['sort'])) ? mb_strtolower($_REQUEST['sort']) : '' ;
	if (!empty($pSortName))
	{
		if (isset($arResult['SORT_DATA'][$pSortName]))
		{
			$order[$arResult['SORT_DATA'][$pSortName]['FIELD']] = 'ASC';
			$arResult['SORT_DATA'][$pSortName]['ACTIVE'] = TRUE;
		}
	}
	else
	{
		$order[$arResult['SORT_DATA']['music']['FIELD']] = 'ASC';
		$arResult['SORT_DATA']['music']['ACTIVE'] = TRUE;
	}
	
	$result = Neti_MusicTable::getList(array(
		'select' => array('ID', 'UF_NAME', 'UF_AUTHOR_ID', 'UF_DURATION', 'AUTHORNAME' => 'AUTHOR.UF_NAME'),
		'filter' => $filter,
		'order' => $order,
		));
	while ($res = $result->Fetch())
	{
		if ($arParams['SEF_MODE'] == 'Y')
			$res['EDIT_URI'] = str_replace('#music_edit#',$res['ID'],$arResult['EDIT_MUSIC_URI']);
		else
			$res['EDIT_URI'] = $arResult['EDIT_MUSIC_URI'].'='.$res['ID'];
			
		$arResult['rows'][] = $res;
	}
}
elseif ($componentPage == 'authors')
{
	$result = Neti_AuthorsTable::getList(array(
		'select' => array('ID', 'UF_NAME'),
		'order' => array('UF_NAME' => 'ASC'),
		));
	while ($res = $result->Fetch())
	{
		if ($arParams['SEF_MODE'] == 'Y')
			$res['EDIT_URI'] = str_replace('#author_edit#',$res['ID'],$arResult['EDIT_AUTHOR_URI']);
		else
			$res['EDIT_URI'] = $arResult['EDIT_AUTHOR_URI'].'='.$res['ID'];
			
		$arResult['rows'][] = $res;
	}	
}
elseif ($componentPage == 'author_edit' || $componentPage == 'author_new')
{
	$arFormFieldNames = array();
	$hlAuthorID = COption::GetOptionString('netihlmusic','AUTHOR_HLBLOCK_ID');
	$arFieldsList = CUserTypeEntity::GetList(array()
		,array(
			'LANG'		=> 'ru',
			'ENTITY_ID'	=> 'HLBLOCK_'.$hlAuthorID,
			)
		);
	while($arRes = $arFieldsList->Fetch())
	{
		$arFormFieldNames[$arRes['FIELD_NAME']]['EDIT_FORM_LABEL'] = $arRes['EDIT_FORM_LABEL'];
		$arFormFieldNames[$arRes['FIELD_NAME']]['HELP_MESSAGE'] = $arRes['HELP_MESSAGE'];
	}
	$arResult['FORM_FIELD_NAMES'] = $arFormFieldNames;
	
	$pAuthorID = (isset($arVariables['author_edit'])) ? @intval($arVariables['author_edit']) : 0 ;
	$arAuthorData = array('ID' => 0, 'UF_NAME' => '');
	if (!empty($pAuthorID))
	{
		$result = Neti_AuthorsTable::getByID($pAuthorID);
		if($arRes = $result->Fetch())
		{
			$arAuthorData = $arRes;
		}
	}	
	$arResult['FORM_FIELD_DATA'] = $arAuthorData;
	
	$componentPage = 'author_form';
}
elseif ($componentPage == 'music_edit' || $componentPage == 'music_new')
{
	$arFormFieldNames = array();
	$hlMusicID = COption::GetOptionString('netihlmusic','MUSIC_HLBLOCK_ID');
	$arFieldsList = CUserTypeEntity::GetList(array()
		,array(
			'LANG'		=> 'ru',
			'ENTITY_ID'	=> 'HLBLOCK_'.$hlMusicID,
			)
		);
	while($arRes = $arFieldsList->Fetch())
	{
		$arFormFieldNames[$arRes['FIELD_NAME']]['EDIT_FORM_LABEL'] = $arRes['EDIT_FORM_LABEL'];
		$arFormFieldNames[$arRes['FIELD_NAME']]['HELP_MESSAGE'] = $arRes['HELP_MESSAGE'];
	}
	
	$result = Neti_AuthorsTable::getList(array(
		'select' => array('ID', 'UF_NAME'),
		'order' => array('UF_NAME' => 'ASC'),
		));
	$listdata = $result->FetchAll();
	$arResult['authors_rows'] = $listdata;
	
	$arResult['FORM_FIELD_NAMES'] = $arFormFieldNames;
	
	$pMusicID = (isset($arVariables['music_edit'])) ? @intval($arVariables['music_edit']) : 0 ;
	$arMusicData = array('ID' => 0, 'UF_NAME' => '', 'UF_AUTHOR_ID' => 0, 'UF_DURATION' => 0);
	if (!empty($pMusicID))
	{
		$result = Neti_MusicTable::getByID($pMusicID);
		if($arRes = $result->Fetch())
		{
			$arMusicData = $arRes;
		}
	}
	
	$arResult['FORM_FIELD_DATA'] = $arMusicData;
	
	$componentPage = 'music_form';
}

$this->IncludeComponentTemplate($componentPage);

?>