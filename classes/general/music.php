<?php
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

$m_hlblock_id = COption::GetOptionString('netihlmusic','MUSIC_HLBLOCK_ID');	
$m_hlblock = HL\HighloadBlockTable::getById($m_hlblock_id)->fetch();
$m_entity = HL\HighloadBlockTable::compileEntity($m_hlblock);

class Neti_MusicTable extends \MusicTable
{
    public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array('primary' => true, 'autocomplete' => true)),
            new Entity\StringField('UF_NAME', array('required' => true)),
            new Entity\IntegerField('UF_DURATION'),
            new Entity\IntegerField('UF_AUTHOR_ID'),
            new Entity\ReferenceField(
                'AUTHOR',
                '\Neti_AuthorsTable',
                array('=this.UF_AUTHOR_ID' => 'ref.ID'),
                array('join_type' => 'LEFT')
            ),
        );
    }
    
}

?>