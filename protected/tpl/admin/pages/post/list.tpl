<table>
	<tbody>
		<tr>
			<th>#</th>
			<th>Media</th>
			<th>Title</th>
			<th>Text</th>
			<th>Created</th>
			<th>Updated</th>
		</tr>
		<?php
			foreach ($posts as $post):
				switch ($post["media_type_id"]) {
					case 2:
						$media = $post["media_path"];
						break;
					case 3:
						$media = $post["media_path"];
						break;
					case 4:
						$media = $post["media_path"];
						break;
					default:
						$media = '';
						break;
				}
				$media = strlen($media)>0?$mediaBaseURL.'/'.preg_replace('/^(.*?)\.(png|jpg|gif)$/su','$1-thumb.gif',$media):'';
		?>
		<tr>
			<td><?=$post['id'];?></td>
			<td><?=strlen($media)>0?"<img src=\"{$media}\">":'<span class="table_empty_value">(not set)</span>';?></td>
			<td><?=strlen($post['title'])>0?$post['title']:'<span class="table_empty_value">(not set)</span>';?></td>
			<td><?=strlen($post['text'])>0?$post['text']:'<span class="table_empty_value">(not set)</span>';?>
			<td><?=strlen($post['created'])>0?$post['created']:'<span class="table_empty_value">(not set)</span>';?></td>
			<td><?=strlen($post['upd'])>0&&$post['upd']!=$post['created']?$post['created']:'<span class="table_empty_value">(not set)</span>';?></td>
		</tr>
		<?php
			endforeach;
		?>
		<tr>
			<th>#</th>
			<th>Media</th>
			<th>Title</th>
			<th>Text</th>
			<th>Created</th>
			<th>Updated</th>
		</tr>
	</tbody>
</table>
