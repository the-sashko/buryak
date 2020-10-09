<form action="/admin/sections/" method="POST">
	<p>
		<input type="text" name="title" placeholder="Title" value="<?=isset($formData['title'])?$formData['title']:'';?>">
	</p>
	<p>
		<input type="text" name="name" placeholder="Name" value="<?=isset($formData['name'])?$formData['name']:'';?>">
	</p>
	<p>
		<input type="text" name="desription" placeholder="Desription" value="<?=isset($formData['description'])?$formData['description']:'';?>">
	</p>
	<p>
		<input type="text" name="default_user_name" placeholder="User name (by default)" value="<?=isset($formData['default_user_name'])?$formData['default_user_name']:'';?>">
	</p>
	<p>
		<input type="text" name="age_restriction" placeholder="Age restriction" value="<?=isset($formData['age_restriction'])?$formData['age_restriction']:'';?>">
	</p>
	<p>
		<input type="text" name="sort" placeholder="Sort" value="<?=isset($formData['sort'])?$formData['sort']:'0';?>">
	</p>
	<p>
		<select name="status_id">
			<option value="-1" disabled<?=!isset($formData['status_id'])||!intval($formData['status_id'])>0?' selected':'';?>>Select status</option>
			<?php foreach($statuses as $status): ?>
			<option value="<?=$status['id'];?>"<?=isset($formData['role'])&&!intval($formData['role'])==$status['id']?' selected':'';?>><?=$status['title'];?></option>
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
			<th>Name</th>
			<th>Title</th>
			<th>Status</th>
			<th>Sort</th>
		</tr>
		<?php foreach ($sections as $section): ?>
		<tr>
			<td><?=$section['id'];?></td>
			<td>/<?=$section['name'];?>/</td>
			<td><?=$section['title'];?></td>
				<?php
					switch (intval($section['status_id'])) {
						case 1:
							$status = '<span style="color:#080;font-weight:bold;">Active</span>';
							break;
						case 2:
							$status = '<span style="color:#880;font-weight:bold;">Hidden</span>';
							break;
						case 3:
							$status = '<span style="color:#800;font-weight:bold;">Closed</span>';
							break;
						default:
							$status = '<span style="color:#888;font-weight:bold;">Unknown</span>';
							break;
				}
				?>
			<td><?=$status;?></td>
			<td><?=$section['sort'];?></td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Title</th>
			<th>Status</th>
			<th>Sort</th>
		</tr>
	</tbody>
</table>
