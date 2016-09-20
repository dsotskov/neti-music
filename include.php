<?php

if(!CModule::IncludeModule('highloadblock'))
	return false;

$arClasses = array(
	'Neti_AuthorsTable' => 'classes/general/authors.php',
	'Neti_MusicTable' => 'classes/general/music.php',
	);
CModule::AddAutoloadClasses('netihlmusic', $arClasses);

?>