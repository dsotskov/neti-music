<?php

$arResult = array(
	'result' => FALSE,
	'error'	 => 'Неизвестная ошибка',
	);


require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
if (!CModule::IncludeModule('netihlmusic'))
{
	$arResult = array(
		'result' => FALSE,
		'error'	 => 'Не подключен модуль netihlmusic',
		);
	echo json_encode($arResult);
	exit;
}

$mode = $_REQUEST['operation'];
$ID = $_REQUEST['ID'];

if ($mode == 'author')
{
	$data = array(
		'UF_NAME' => $_REQUEST['UF_NAME'],
	);
	
	if (empty($ID))
	{
		$result = Neti_AuthorsTable::add($data);
	}
	else
	{
		$result = Neti_AuthorsTable::update($ID, $data);
	}
	
	if($result->isSuccess())
	{
		$arResult['result'] = TRUE;
	}
	else
	{
		$errors = $result->getErrors();    
	    foreach ($errors as $error)
	    {
	    	$arResult['error'] = $error->GetMessage();
	    }
	}
}
elseif ($mode == 'music')
{
	$data = array(
		'UF_NAME' => $_REQUEST['UF_NAME'],
		'UF_DURATION' => @intval($_REQUEST['UF_DURATION']),
		'UF_AUTHOR_ID' => @intval($_REQUEST['UF_AUTHOR_ID']),
	);
	if (empty($data['UF_AUTHOR_ID'])) unset($data['UF_AUTHOR_ID']);
	
	if (empty($ID))
	{
		$result = Neti_MusicTable::add($data);
	}
	else
	{
		$result = Neti_MusicTable::update($ID, $data);
	}
	
	if($result->isSuccess())
	{
		$arResult['result'] = TRUE;
	}
	else
	{
		$errors = $result->getErrors();    
	    foreach ($errors as $error)
	    {
	    	$arResult['error'] = $error->GetMessage();
	    }
	}
}
elseif ($mode == 'author-delete')
{
	if (!empty($ID))
	{
		$result = Neti_AuthorsTable::delete($ID);
		if($result->isSuccess())
		{
			$arResult['result'] = TRUE;
		}
		else
		{
			$errors = $result->getErrors();    
		    foreach ($errors as $error)
		    {
		    	$arResult['error'] = $error->GetMessage();
		    }
		}
	}	
}
elseif ($mode == 'music-delete')
{
	if (!empty($ID))
	{
		$result = Neti_MusicTable::delete($ID);
		if($result->isSuccess())
		{
			$arResult['result'] = TRUE;
		}
		else
		{
			$errors = $result->getErrors();    
		    foreach ($errors as $error)
		    {
		    	$arResult['error'] = $error->GetMessage();
		    }
		}
	}
}

echo json_encode($arResult);
?>