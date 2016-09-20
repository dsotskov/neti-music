<?php
global $MESS;

use Bitrix\Highloadblock\HighloadBlockTable as HLBT;
CModule::IncludeModule('highloadblock');

if(class_exists('netihlmusic')) return;

Class netihlmusic extends CModule
{
	var $MODULE_ID = 'netihlmusic';
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $MODULE_GROUP_RIGHTS = 'Y';
	var $error = '';
	
	function netihlmusic()
	{
		$arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen('/index.php'));
		include($path.'/version.php');

		$this->MODULE_VERSION = $arModuleVersion['VERSION'];
		$this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
		$this->MODULE_NAME = 'NETI: Каталог музыки на highload блоках';
		$this->MODULE_DESCRIPTION = 'Модуль позволяет использовать каталог музыки на HL блоках.';
	}
	
	function InstallDB()
	{
		// creating highload block tables ----------------------------------------
		$highloadBlockData = array ('NAME' => 'Authors', 'TABLE_NAME' => 'netihlmusic_authors');
		$result = HLBT::add($highloadBlockData);
		$hlAuthorID = $result->getId();
		COption::SetOptionString('netihlmusic', 'AUTHOR_HLBLOCK_ID', $hlAuthorID);
		
		$highloadBlockData = array ('NAME' => 'Music', 'TABLE_NAME' => 'netihlmusic_music');
		$result = HLBT::add($highloadBlockData);
		$hlMusicID = $result->getId();
		COption::SetOptionString('netihlmusic', 'MUSIC_HLBLOCK_ID', $hlMusicID);
		
		// config highload block table Fields ------------------------------------
		$arUserTypeFields = array();
		$userTypeEntity    = new CUserTypeEntity();
		
		$userTypeData = array(
    		'ENTITY_ID'			=> 'HLBLOCK_'.$hlAuthorID,
    		'FIELD_NAME'        => 'UF_NAME',
    		'USER_TYPE_ID'      => 'string',
			'XML_ID'            => 'XML_ID_NAME',
			'SORT'              => 500,
			'MULTIPLE'          => 'N',
    		'MANDATORY'         => 'Y',
    		'SHOW_FILTER'       => 'N',
    		'SHOW_IN_LIST'      => '',
    		'EDIT_IN_LIST'      => '',
    		'IS_SEARCHABLE'     => 'N',
    		'SETTINGS'          => array(
        		'DEFAULT_VALUE' => '',
        		'SIZE'          => '32',
        		'ROWS'          => '1',
        		'MIN_LENGTH'    => '3',
        		'MAX_LENGTH'    => '64',
        		'REGEXP'        => '',
				),
    		'EDIT_FORM_LABEL'   => array(
        		'ru'    => 'Имя композитора',
    		),
    		'LIST_COLUMN_LABEL' => array(
        		'ru'    => 'Имя композитора',
    		),
    		'LIST_FILTER_LABEL' => array(
        		'ru'    => 'Имя композитора',
			),
    		'ERROR_MESSAGE'     => array(
        		'ru'    => 'Ошибка при заполнении пользовательского свойства <Имя композитора>',
			),
    		'HELP_MESSAGE'      => array(
        		'ru'    => 'Фамилия, имя композитора или название группы/коллектива',
    		),
		);
		$nfield = $userTypeEntity->Add($userTypeData);
		
		/////////////////////////////////////////////////////
		$userTypeData = array(
    		'ENTITY_ID'			=> 'HLBLOCK_'.$hlMusicID,
    		'FIELD_NAME'        => 'UF_AUTHOR_ID',
    		'USER_TYPE_ID'      => 'hlblock',
			'XML_ID'            => '',
			'SORT'              => 500,
			'MULTIPLE'          => 'N',
    		'MANDATORY'         => 'Y',
    		'SHOW_FILTER'       => 'N',
    		'SHOW_IN_LIST'      => '',
    		'EDIT_IN_LIST'      => '',
    		'IS_SEARCHABLE'     => 'N',
    		'SETTINGS'          => array(
        		'HLBLOCK_ID' => $hlAuthorID,
        		'HLFIELD_ID' => $nfield,
				),
    		'EDIT_FORM_LABEL'   => array(
        		'ru'    => 'Композитор',
    		),
    		'LIST_COLUMN_LABEL' => array(
        		'ru'    => 'Композитор',
    		),
    		'LIST_FILTER_LABEL' => array(
        		'ru'    => 'Композитор',
			),
    		'ERROR_MESSAGE'     => array(
        		'ru'    => 'Ошибка при заполнении пользовательского свойства <Композитор>',
			),
    		'HELP_MESSAGE'      => array(
        		'ru'    => 'Композитор данного музыкального произведения',
    		),
		);
		$userTypeEntity->Add($userTypeData);
				
		$userTypeData = array(
    		'ENTITY_ID'			=> 'HLBLOCK_'.$hlMusicID,
    		'FIELD_NAME'        => 'UF_NAME',
    		'USER_TYPE_ID'      => 'string',
			'XML_ID'            => 'XML_ID_NAME',
			'SORT'              => 500,
			'MULTIPLE'          => 'N',
    		'MANDATORY'         => 'Y',
    		'SHOW_FILTER'       => 'N',
    		'SHOW_IN_LIST'      => '',
    		'EDIT_IN_LIST'      => '',
    		'IS_SEARCHABLE'     => 'Y',
    		'SETTINGS'          => array(
        		'DEFAULT_VALUE' => '',
        		'SIZE'          => '32',
        		'ROWS'          => '1',
        		'MIN_LENGTH'    => '3',
        		'MAX_LENGTH'    => '64',
        		'REGEXP'        => '',
				),
    		'EDIT_FORM_LABEL'   => array(
        		'ru'    => 'Название композиции',
    		),
    		'LIST_COLUMN_LABEL' => array(
        		'ru'    => 'Название композиции',
    		),
    		'LIST_FILTER_LABEL' => array(
        		'ru'    => 'Название композиции',
			),
    		'ERROR_MESSAGE'     => array(
        		'ru'    => 'Ошибка при заполнении пользовательского свойства <Название композиции>',
			),
    		'HELP_MESSAGE'      => array(
        		'ru'    => 'Название композиции (музыкального произведения или песни)',
    		),
		);
		$userTypeEntity->Add($userTypeData);
		
		$userTypeData = array(
    		'ENTITY_ID'			=> 'HLBLOCK_'.$hlMusicID,
    		'FIELD_NAME'        => 'UF_DURATION',
    		'USER_TYPE_ID'      => 'integer',
			'XML_ID'            => 'XML_ID_DURATION',
			'SORT'              => 500,
			'MULTIPLE'          => 'N',
    		'MANDATORY'         => 'N',
    		'SHOW_FILTER'       => 'N',
    		'SHOW_IN_LIST'      => '',
    		'EDIT_IN_LIST'      => '',
    		'IS_SEARCHABLE'     => 'N',
    		'EDIT_FORM_LABEL'   => array(
        		'ru'    => 'Длительность (сек.)',
    		),
    		'LIST_COLUMN_LABEL' => array(
        		'ru'    => 'Длительность',
    		),
    		'LIST_FILTER_LABEL' => array(
        		'ru'    => 'Длительность',
			),
    		'ERROR_MESSAGE'     => array(
        		'ru'    => 'Ошибка при заполнении пользовательского свойства <Длительность>',
			),
    		'HELP_MESSAGE'      => array(
        		'ru'    => 'Длительность композиции в секундах',
    		),
		);
		$userTypeEntity->Add($userTypeData);
		
		// если произошла ошибка выведем её
		if(!$highLoadBlockId){
    		var_dump($result->getErrorMessages());
		}
		
		Bitrix\Main\Loader::registerAutoLoadClasses('netihlmusic', 
			array(
				'netihlmusic\AuthorsTable' => 'lib/authors.php',
				'\netihlmusic\AuthorsTable' => 'lib/authors.php',
				'netihlmusic\MusicTable' => 'lib/music.php',
				'\netihlmusic\MusicTable' => 'lib/music.php',
				)
			);
		return true;
	}

	function UnInstallDB()
	{
		$highLoadBlockId = COption::GetOptionString('netihlmusic','MUSIC_HLBLOCK_ID');
		$result = HLBT::delete($highLoadBlockId);
		
		$highLoadBlockId = COption::GetOptionString('netihlmusic','AUTHOR_HLBLOCK_ID');
		$result = HLBT::delete($highLoadBlockId);

		return true;
	}
	
	function InstallFiles()
	{
		if($_ENV['COMPUTERNAME']!='BX')
		{
			CopyDirFiles($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/netihlmusic/install/components', $_SERVER['DOCUMENT_ROOT'].'/bitrix/components', true, true);
			CopyDirFiles($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/netihlmusic/install/css', $_SERVER['DOCUMENT_ROOT'].'/bitrix/css', true, true);
		}
		return true;
	}

	function UnInstallFiles()
	{
		
		DeleteDirFilesEx('/bitrix/components/neti/hlmusic');
		DeleteDirFilesEx('/bitrix/components/neti/hlmusic.list');
		return true;
	}
	
	function DoInstall()
	{
		global $DB, $APPLICATION, $step;
		
		if (!IsModuleInstalled('netihlmusic'))
		{
			RegisterModule('netihlmusic');
			COption::SetOptionString('netihlmusic', 'GROUP_DEFAULT_RIGHT', 'W');
			
			$this->InstallDB();
			$this->InstallFiles();
		}
	}

	function DoUninstall()
	{
		global $APPLICATION, $DB;
		
		if (IsModuleInstalled('netihlmusic'))
		{
			$this->UnInstallFiles();
			$this->UnInstallDB();
			
			COption::RemoveOption('netihlmusic');
			UnRegisterModule('netihlmusic');
		}
	}

	function GetModuleRightList()
	{
		$arr = array(
			'reference_id' => array('D', 'R', 'W', 'Y'),
			'reference' => array(
					'[D] '.'Доступ закрыт',
					'[R] '.'Чтение данных',
					'[W] '.'Создание/изменение данных',
					'[Y] '.'Удаление данных',
				)
			);
		return $arr;
	}
	
}
?>