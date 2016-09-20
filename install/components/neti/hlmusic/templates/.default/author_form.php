<?
CJSCore::Init('jquery');
$this->addExternalJS($templateFolder.'/forms.js');
$APPLICATION->AddChainItem('Добавление/изменение композитора','');
?>

<form action="<?=$componentPath?>/component.ajax.php" method="POST" class="netihlmusic-form">
	<div class="alert alert-danger alert-dismissable" style="display: none;"></div>
	<input type="hidden" name="ID" value="<?=$arResult['FORM_FIELD_DATA']['ID']?>">
	<input type="hidden" name="operation" value="author">
	<input type="hidden" name="SEF_FOLDER" value="<?=$arResult['AUTHORS_URI']?>">
	<div class="form-group">
		<label for="UF_NAME"><?=$arResult['FORM_FIELD_NAMES']['UF_NAME']['EDIT_FORM_LABEL']?></label>
		<input type="text" name="UF_NAME" class="form-control" value="<?=$arResult['FORM_FIELD_DATA']['UF_NAME']?>">
		<small><?=$arResult['FORM_FIELD_NAMES']['UF_NAME']['HELP_MESSAGE']?></small>
	</div>
	<button type="submit" class="btn btn-default">Сохранить</button>
</form>