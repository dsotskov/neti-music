<?
CJSCore::Init('jquery');
$this->addExternalCSS($templateFolder.'/netihlmusic.css');
$this->addExternalJS($templateFolder.'/forms.js');
$APPLICATION->AddChainItem('Список композиторов','');
?>

<div style="margin-bottom: 15px;">
	<a href="<?=$arResult['NEW_AUTHOR_URI']?>" class="btn btn-default"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <span class="glyphicon glyphicon-user" aria-hidden="true"></span> <span class="hidden-sm hidden-xs">Добавить композитора</span></a>
</div>

<table class="table table-striped">
<thead>
	<tr>
		<th class="netihlmusic-operation-col">#</th>
		<th>Композитор</th>
	</tr>
</thead>
<tbody>
<? foreach ($arResult['rows'] as $row): ?>
	<tr class="netihlmusic-list-item">
		<td class="netihlmusic-operation-col">
			<a href="<?=$row['EDIT_URI']?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
			<a href="<?=$componentPath?>/component.ajax.php" class="netihlmusic-button" data-operation="author-delete" data-id="<?=$row['ID']?>" data-name="<?=$row['UF_NAME']?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
		</td>
		<td><a href="<?=$arResult['AUTHOR_FILTER_URI']?><?=$row['ID']?>"><?=$row['UF_NAME']?></a></td>
	</tr>
<? endforeach; ?>
</tbody>
</table>