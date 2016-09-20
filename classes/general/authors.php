<?php

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

$a_hlblock_id = COption::GetOptionString('netihlmusic','AUTHOR_HLBLOCK_ID');	
$a_hlblock = HL\HighloadBlockTable::getById($a_hlblock_id)->fetch();
$a_entity = HL\HighloadBlockTable::compileEntity($a_hlblock);

class Neti_AuthorsTable extends \AuthorsTable
{
    public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array('primary' => true, 'autocomplete' => true)),
            new Entity\StringField('UF_NAME', array('required' => true)),
        );
    }
    
}


?>