<?php $thread = new bundle_ForumThread($parser->thread); ?>
<h3>
	Vlákno :: <strong><?= $thread->Title ?></strong>
	<?php if((new bundle_Forum_DB($parser->forum))->Moderator == Bundle\User::CurrentUser()->ID || Bundle\User::CurrentUser()->Role == 0): ?>
		&rarr; <a class="red" href="?delete=thread&data=<?= $thread->ID ?>">Odstranit</a>
	<?php endif; ?>
</h3>

<script>
	$(document).ready(function() {
		$(".quote").click(function() {
			var oEditor = CKEDITOR.instances.editor;
			var value = "<blockquote><p><strong>" + $("#post_author_" + $(this).attr("data")).text() 
				+ "</strong> napsal:</p>" + $("#post_content_" + $(this).attr("data")).html() + "</blockquote>";
			oEditor.insertHtml(value);
		});
	});
</script>

<?php
	$formCreate = new HForm("create_thread");
		
	$formCreate
		->addItem(
			(new HFormItem("text", HFormItem::TYPE_TEXTAREA, HFormItem::REQUIRE_ON))
				->setAttribute("id", "editor")
				->setLabel("Text příspěvku")
			)
		->addItem(
			(new HFormItem("forum_submit", HFormItem::TYPE_SUBMIT))
				->setValue("Vytvořit příspěvek")
				
			)
		->onSubmit(
			function($obj) {
				$parser = new Bundle\GetParser();
				$author = Bundle\User::CurrentUser()->ID;
				$content = $obj->Items["text"]->Value;
				
				bundle_ForumPost::Create($author, $parser->thread, $content);
				header("location: ?forum=" . $parser->forum . "&thread=" . $parser->thread);
			}
		)
		->onError(
			function($type, $item, $obj) {
				if ($type == HForm::ERROR_REQUIRE)
					echo '
					<script>
						$(document).ready(function() {
							$("html, body").animate({
								scrollTop: $(".error_p").offset().top
							}, 200);
						});
					</script>
					';
					echo('<div class="panel error_p">Musíte vyplnit pole <strong>' . $item->Label . '</strong>.</div>');
			}
		);
?>

<?php foreach($thread->getPosts() as $post): ?>
	<?php $author = new Bundle\User($post->Author); ?>
	<div>
		<table class="post"> 
			<tr>
				<td class="post_author_td">
					<span class="post_author" id="post_author_<?= $post->ID ?>"><a href="uzivatelske-ucty?user=<?= $author->Username ?>"><?= $author->Username ?></a></span>
					<img src="<?= $author->Photo ?>" class="post_author_photo" />
					<span class="author_role"><?= $author->RoleString ?></span>
					
					<span class="prizes" title="<?= count(bundle_ForumPost::GetByAuthor($author->ID)) ?> příspěvků">
					<?php for($i = 1; $i <= log(count(bundle_ForumPost::GetByAuthor($author->ID)), 10) + 1; $i++): ?>
						<img src="<?= HPackage::GetPath("bundle_Forum") ?>/img/prize.png" />
					<?php endfor; ?>
					</span>
					
					<span class="datetime"><?= $post->Datetime ?></span>
				</td>
				<td class="content" id="post_content_<?= $post->ID ?>"><?= $post->Content ?></td>
			</tr>
			<tr>
				<td colspan="2" class="post_info">
					<?php if((new bundle_Forum_DB($parser->forum))->Moderator == Bundle\User::CurrentUser()->ID || Bundle\User::CurrentUser()->Role == 0): ?>
						<a class="red" href="?delete=post&data=<?= $post->ID ?>">Odstranit</a>
					<?php endif; ?>
					<a data="<?= $post->ID ?>" class="quote">Citovat</a>
				</td>
			</tr>
		</table>
	</div>
<?php endforeach; ?>

<h3>Přidat nový příspěvek</h3>

<?php $formCreate->render(); ?>

<style>
	table {width:100%; background-color:#f9f9f9; padding:10px; border:1px solid #ddd;}
	table tr td {padding:5px;}
</style>
<script type="text/javascript" src="<?= HPackage::getPath("ckeditor") ?>/ckeditor/ckeditor.js"></script>

<script>
	CKEDITOR.replace( 'editor', {
		toolbar: [
			{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
			{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
		]
	});
</script>

