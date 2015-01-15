<?php if (Bundle\User::IsLogged()): ?>
	<h3>Přidat Forum</h3>
	<style>
		table {width:100%; background-color:#f9f9f9; padding:10px; border:1px solid #ddd;}
		table tr td {padding:5px;}
	</style>
	<script type="text/javascript" src="<?= HPackage::getPath("ckeditor") ?>/ckeditor/ckeditor.js"></script>
	<?php
		if (count(bundle_Forum_DB::getList()) > 0) {
			$formForum = new HForm("create_thread");
			
			$forum_select = new HFormItem("forum", HFormItem::TYPE_SELECT);
			$forum_select
				->setLabel("Forum");
			
			foreach(bundle_Forum_DB::getList() as $item)
				$forum_select->addSubItem(
					(new HFormItem($item->ID, HFormItem::TYPE_OPTION))
						->setValue($item->Title)
				);
			
			$formForum
				->addItem(
					(new HFormItem("title", HFormItem::TYPE_TEXT, HFormItem::REQUIRE_ON))
						->setLabel("Název vlákna")
						->setAttribute("style", "width:75%")
					)
				->addItem($forum_select)
				->addItem(
					(new HFormItem("text", HFormItem::TYPE_TEXTAREA, HFormItem::REQUIRE_ON))
						->setAttribute("placeholder", "Popis fóra..")
						->setAttribute("rows", 3)
						->setAttribute("cols", 50)
						->setAttribute("id", "editor")
						->setLabel("Obsah")
					)
				->addItem(
					(new HFormItem("forum_submit", HFormItem::TYPE_SUBMIT))
						->setValue("Vytvořit")
					)
				->onSubmit(
					function($obj) {
						$title = $obj->Items["title"]->Value;
						$forum = $obj->Items["forum"]->Value;
						$author = Bundle\User::CurrentUser()->ID;
						$content = $obj->Items["text"]->Value;
						
						$thread = bundle_ForumThread::Create($title, $author, $forum, 0);
						bundle_ForumPost::Create($author, $thread, $content);
						
						echo('<div class="panel done_p">Nové vlákno (' . $title . ') vytvořeno.</div>');
						header("location: ?forum=" . $forum . "&thread=" . $thread);
					})
				->onError(
					function($type, $item, $obj) {
						if ($type == HForm::ERROR_REQUIRE)
							echo('<div class="panel error_p">Musíte vyplnit pole <strong>' . $item->Label . '</strong>.</div>');
					}
				);
			$formForum->render();
		}
	?>
	<script>
		CKEDITOR.replace( 'editor', {
			toolbar: [
				{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
				{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
			]
		});
	</script>
<?php else: ?>
	<h3 class="red">Nejste přihlášen, pro vytváření nových vláken se musíte přihlásit.</h3>
<?php endif; ?>
