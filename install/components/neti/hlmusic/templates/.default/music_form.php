<?
CJSCore::Init('jquery');
$this->addExternalJS($templateFolder.'/forms.js');
$APPLICATION->AddChainItem('Добавление/изменение композиции','');
?>

<form action="<?=$componentPath?>/component.ajax.php" method="POST" class="netihlmusic-form">
	<div class="alert alert-danger alert-dismissable" style="display: none;"></div>
	<input type="hidden" name="ID" value="<?=$arResult['FORM_FIELD_DATA']['ID']?>">
	<input type="hidden" name="operation" value="music">
	<input type="hidden" name="SEF_FOLDER" value="<?=$arResult['SEF_FOLDER']?>">
	<div class="form-group">
		<label for="UF_NAME"><?=$arResult['FORM_FIELD_NAMES']['UF_NAME']['EDIT_FORM_LABEL']?></label>
		<input type="text" name="UF_NAME" class="form-control" value="<?=$arResult['FORM_FIELD_DATA']['UF_NAME']?>">
		<small><?=$arResult['FORM_FIELD_NAMES']['UF_NAME']['HELP_MESSAGE']?></small>
	</div>
	<div class="form-group">
		<label for="UF_AUTHOR_ID"><?=$arResult['FORM_FIELD_NAMES']['UF_AUTHOR_ID']['EDIT_FORM_LABEL']?></label>
		<select name="UF_AUTHOR_ID" class="form-control">
			<? foreach ($arResult['authors_rows'] as $row): ?>
				<?
				if ($arResult['FORM_FIELD_DATA']['UF_AUTHOR_ID'] == $row['ID'])
					$fselected = 'selected';
				else
					$fselected = '';
				?>
				<option value="<?=$row['ID']?>" <?=$fselected?>><?=$row['UF_NAME']?></option>
			<? endforeach; ?>
		</select>
		<small><?=$arResult['FORM_FIELD_NAMES']['UF_AUTHOR_ID']['HELP_MESSAGE']?></small>
	</div>
	<div class="form-group">
		<label for="UF_DURATION"><?=$arResult['FORM_FIELD_NAMES']['UF_DURATION']['EDIT_FORM_LABEL']?></label>
		<input type="text" name="UF_DURATION" class="form-control" value="<?=$arResult['FORM_FIELD_DATA']['UF_DURATION']?>">
		<small><?=$arResult['FORM_FIELD_NAMES']['UF_DURATION']['HELP_MESSAGE']?></small>
	</div>
	<button type="submit" class="btn btn-default">Сохранить</button>
</form>