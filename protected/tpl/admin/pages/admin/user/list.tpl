<form action="/admin/users/" method="POST">
	<p>
		<input type="text" name="name" placeholder="Name" value="<?=isset($formData['name'])?$formData['name']:'';?>">
	</p>
	<p>
		<input type="text" name="email" placeholder="Email" value="<?=isset($formData['name'])?$formData['name']:'';?>">
	</p>
	<p>
		<select name="role">
			<option value="-1" disabled<?=!isset($formData['role'])||!intval($formData['role'])>0?' selected':'';?>>Select user role</option>
			<option value="1"<?=isset($formData['role'])&&!intval($formData['role'])==1?' selected':'';?>>Administrator</option>
			<option value="2"<?=isset($formData['role'])&&!intval($formData['role'])==2?' selected':'';?>>Moderator</option>
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
			<th>Email</th>
			<th>Role</th>
			<th>Status</th>
		</tr>
		<?php foreach ($users as $user): ?>
		<tr>
			<td><?=$user['id'];?></td>
			<td><?=$user['name'];?></td>
			<td><?=$user['email'];?></td>
			<td><?=$user['role'];?></td>
			<td><?=intval($user['status'])!=1?'<span style="color:#800;font-weight:bold;">Not activated</span>':'<span style="color:#080;font-weight:bold;">Active</span>';?></td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Email</th>
			<th>Role</th>
			<th>Status</th>
		</tr>
	</tbody>
</table>