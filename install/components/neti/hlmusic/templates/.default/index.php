<?
CJSCore::Init('jquery');
$this->addExternalCSS($templateFolder.'/netihlmusic.css');
$this->addExternalJS($templateFolder.'/forms.js');
?>

<div style="margin-bottom: 15px;">
	<a href="<?=$arResult['NEW_AUTHOR_URI']?>" class="btn btn-default"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <span class="glyphicon glyphicon-user" aria-hidden="true"></span> <span class="hidden-sm hidden-xs">Добавить композитора</span></a>
	<a href="<?=$arResult['NEW_MUSIC_URI']?>" class="btn btn-default"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <span class="glyphicon glyphicon-music" aria-hidden="true"></span> <span class="hidden-sm hidden-xs">Добавить композицию</span></a>
	<a href="<?=$arResult['AUTHORS_URI']?>" class="btn btn-default"><span class="glyphicon glyphicon-list" aria-hidden="true"></span> <span class="hidden-sm hidden-xs">Список композиторов</span></a>
</div>

<div class="row">
	<div class="col-sm-6">
		<div>Сортировка списка:</div>
		<ul style="list-style-type: none;">
			<? foreach ($arResult['SORT_DATA'] as $sortname => $row): ?>
				<? if ($row['ACTIVE']): ?>
					<li><b><?=$row['NAME']?></b></li>
				<? else: ?>
					<li><a href="<?=$arResult['SEF_FOLDER']?>?sort=<?=$sortname?>"><?=$row['NAME']?></a></li>
				<? endif; ?>
			<? endforeach; ?>
		</ul>
	</div>
	<div class="col-sm-6">
		<div>Показаны композиции автора:</div>
		<?if (!empty($arResult['FILTER_DATA'])):?>
			<div><b><?=$arResult['FILTER_DATA']?></b> <a href="<?=$arResult['SEF_FOLDER']?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></div>
		<? else: ?>
			<div><i>- по всем композиторам -</i></div>
		<? endif; ?>
	</div>
</div>

<hr/>

<div class="row">

<? foreach ($arResult['rows'] as $row): ?>
	<?
		$Duration = $row['UF_DURATION'];
		if ($arParams['DURATION_TYPE'] == 'min')
		{
			$mins = floor($Duration / 60);
			$secs = $Duration - ($mins * 60);
			$Duration = $mins . ' мин.' . $secs . ' сек.';
		}
		else
		{
			$Duration .= ' сек.';
		}
	?>
	<div class="col-sm-6 col-md-4 netihlmusic-list-item">
		<div class="netihlmusic-block">
			<div class="music"><span class="glyphicon glyphicon-music" aria-hidden="true"></span> <?=$row['UF_NAME']?></div>
			<div class="author"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?=$row['AUTHORNAME']?> <a href="<?=$arResult['AUTHOR_FILTER_URI']?><?=$row['UF_AUTHOR_ID']?>"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span></a></div>
			<div class="duration"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> <?=$Duration?></div>
			<div class="edit-block">
				<a href="<?=$row['EDIT_URI']?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
				<a href="<?=$componentPath?>/component.ajax.php" class="netihlmusic-button" data-operation="music-delete" data-id="<?=$row['ID']?>" data-name="<?=$row['UF_NAME']?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
			</div>
		</div>
	</div>
<? endforeach; ?>
	
</div>

<?php

?>