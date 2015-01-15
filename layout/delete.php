<?php $user = Bundle\User::CurrentUser(); ?>	
<?php
	if ($parser->delete == "post")
		$moderator = (new bundle_ForumPost($parser->data))->getThread()->getForum()->Moderator;
	else if ($parser->delete == "thread")
		$moderator = (new bundle_ForumThread($parser->data))->getForum()->Moderator;
?>
<?php if ($user->Role == 0 || $user->ID == $moderator): ?>
	<?php 
		if ($parser->delete == "post") {
			$obj = (new bundle_ForumPost($parser->data));
			$thread = $obj->getThread();
			$post = $obj;
		} else if ($parser->delete == "thread") {
			$obj = (new bundle_ForumThread($parser->data));
			$thread = $obj;
			$post = $obj->getPosts()[0];
		}
		
		if (isset($_POST["delete"])) {
			$obj->Delete();
			header("location: ?forum=" . $thread->getForum()->ID);
		}
	?>
	
	<style>
		.content {background-color:#eee; padding:5px; border:1px solid #ddd;}
	</style>
	<h3>Smazat příspěvek/vlákno</h3> 
	<div class="content">
		<?= $post->Content ?>
	</div>
	<br />
	<form method="POST"><input type="submit" name="delete" value="Odstranit příspěvek/vlákno"></form>
<?php else: ?>
	<h3 class="red">K tomuto nemáte oprávnění</h3>
<?php endif; ?>
