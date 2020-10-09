<form action="/admin/cron/" method="POST">
	<p>
		<select name="action">
			<option value="-1" disabled<?=!isset($formData['action'])||!intval($formData['action'])>0?' selected':'';?>>Select cron action</option>
			<?php foreach($cronActions as $cronAction): ?>
			<option value="<?=$cronAction;?>"<?=isset($formData['action'])&&$formData['action']==$cronAction?' selected':'';?>><?=$cronAction;?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p>
		<input type="text" name="value" placeholder="Frequency value" value="<?=isset($formData['value'])&&$formData['value']>0?$formData['value']:'';?>">
	</p>
	<p>
		<select name="type">
			<option value="-1" disabled<?=!isset($formData['type'])||!intval($formData['type'])>0?' selected':'';?>>Select frequency type</option>
			<?php foreach($cronTypes as $cronType): ?>
			<option value="<?=$cronType['id'];?>"<?=isset($formData['type'])&&$formData['type']==$cronType['id']?' selected':'';?>><?=$cronType['title'];?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p>
		<input type="submit" value="Create" class="form_btn">
	</p>
</form>
<table>
	<tbody>
		<tr>
			<th>#</th>
			<th>Action</th>
			<th>Frequency</th>
			<th>Next run</th>
		</tr>
		<?php foreach ($cronJobs as $cronJob): ?>
		<tr>
			<td><?=$cronJob['id'];?></td>
			<td><?=$cronJob['action'];?></td>
			<td><?=$cronJob['time_value'].' '.$cronJob['type_title'];?></td>
			<td><?=date('d.m.Y H:i',$cronJob['next_exec']);?></td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<th>#</th>
			<th>Action</th>
			<th>Frequency</th>
			<th>Next run</th>
		</tr>
	</tbody>
</table>
