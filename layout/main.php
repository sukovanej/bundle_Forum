<?php foreach(bundle_ForumSection::getList() as $section): if(count($section->getForums()) > 0): ?>
<table class="forum_table">
	<tr>
		<td colspan="4" class="section"><?= $section->Title ?></td>
	</tr>
	<tr>
		<th>Fóra</th>
		<th>Počet příspěvků</th>
		<th>Nejnovější vlákno</th>
		<th>Moderátor fóra</th>
	</tr>
	<?php foreach($section->getForums() as $forum): ?>
	<tr>
		<td>
			<a class="forum_title" href="?forum=<?= $forum->ID ?>"><?= $forum->Title ?></a> <br />
			<small><?= $forum->Description ?></small>
		</td>
		<td width="130"><?= count($forum->getThreads()) ?></td>
		<td>
			<?php 
				if(count($forum->getThreads()) > 0) { 
					$thread = $forum->getThreads()[0];
					echo '<a href="?forum=' . $forum->ID . '&thread=' . $thread->ID . '">' . $thread->Title . '</a> - <em>' . $thread->Datetime . '</em>'; 
				}
			?>
		</td>
		<td><em><?= (new Bundle\User($forum->Moderator))->Username ?></em></td>
	</tr>
	<?php endforeach; ?>
</table>
<?php endif; endforeach; ?>
