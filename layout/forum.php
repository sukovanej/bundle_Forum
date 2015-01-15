<?php 
	$forum = new bundle_Forum_DB($parser->forum);
	$pager = 0;
	$in_page = 15;
	
	if (isset($parser->pager))
		$pager = $parser->pager;
?>
<table class="forum_table">
	<tr>
		<td colspan="4" class="section"><?= $forum->Title ?></td>
	</tr>
	<tr>
		<th>Vlákno</th>
		<th>Počet příspěvků</th>
		<th>Autor</th>
	</tr>
	<?php foreach(array_slice($forum->getThreads(), $pager * $in_page, $in_page) as $thread): ?>
	<tr>
		<td width="500">
			<a class="forum_title" href="?forum=<?= $forum->ID ?>&thread=<?= $thread->ID ?>"><?= $thread->Title ?></a> <br />
			<small>Poslední příspěvek <?= array_reverse($thread->getPosts())[0]->Datetime ?></small>
		</td>
		<td width="130"><?= count($thread->getPosts()) ?></td>
		<td><em><?= (new Bundle\User($thread->Author))->Username ?></em></td>
	</tr>
	<?php endforeach; ?>
</table>

<div class="pager">
	<?php for($i = 0; $i < count($forum->getThreads()) / $in_page; $i++): ?>
		<?php
			if ((isset($parser->pager) && $parser->pager == $i) || $i == 0)
				$selected = "selected_pager";
			else
				$selected = null;
		?>
		<a class="<?= $selected ?>" href="?forum=<?= $forum->ID ?>&pager=<?= $i ?>"><?= $i + 1 ?></a>
	<?php endfor;?>
</div>
