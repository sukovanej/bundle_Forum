<h2>Přidat sekci</h2>
<?php
	$formSection = new HForm("section_form");
	$formSection
		->addItem(
			(new HFormItem("section_title", HFormItem::TYPE_TEXT))
				->setLabel("Název sekce")
			)
		->addItem(
			(new HFormItem("section_submit", HFormItem::TYPE_SUBMIT))
				->setValue("Odeslat")
			)
		->onSubmit(
			function($obj) {
				bundle_ForumSection::Create($obj->Items["section_title"]->Value);
				Admin::Message("Sekce úspěšně vytvořena");
			}
		);
	$formSection->render();
?>
<h2>Přidat Forum</h2>
<?php
	if (count(bundle_ForumSection::getList()) > 0) {
		$formForum = new HForm("forum_form");
		
		$section_select = new HFormItem("forum_section", HFormItem::TYPE_SELECT);
		$section_select
			->setLabel("Nadřazená sekce");
		
		foreach(bundle_ForumSection::getList() as $item)
			$section_select->addSubItem(
				(new HFormItem($item->ID, HFormItem::TYPE_OPTION))
					->setValue($item->Title)
			);
		
		$users_select = new HFormItem("forum_user", HFormItem::TYPE_SELECT);
		$users_select
			->setLabel("Moderátor");
		
		foreach(Bundle\User::GetList() as $user)
			$users_select->addSubItem(
				(new HFormItem($user->ID, HFormItem::TYPE_OPTION))
					->setValue($user->Username)
			);
		
		$formForum
			->addItem(
				(new HFormItem("forum_title", HFormItem::TYPE_TEXT))
					->setLabel("Název fóra")
				)
			->addItem($section_select)
			->addItem($users_select)
			->addItem(
				(new HFormItem("forum_description", HFormItem::TYPE_TEXTAREA))
					->setAttribute("placeholder", "Popis fóra..")
					->setAttribute("rows", 3)
					->setAttribute("cols", 50)
					->setLabel("Popis fóra")
				)
			->addItem(
				(new HFormItem("forum_allow", HFormItem::TYPE_CHECKBOX))
					->setLabel("Povolit pro všechny")
				)
			->addItem(
				(new HFormItem("forum_submit", HFormItem::TYPE_SUBMIT))
					->setValue("Odeslat")
				)
			->onSubmit(
				function($obj) {
					$title = $obj->Items["forum_title"]->Value;
					$section = $obj->Items["forum_section"]->Value;
					$moderator = $obj->Items["forum_user"]->Value;
					$description = $obj->Items["forum_description"]->Value;
					$allow = $obj->Items["forum_allow"]->Value;
					
					bundle_Forum_DB::Create($title, $section, $moderator, $description, $allow);
					Admin::Message("Sekce úspěšně vytvořena");
				}
			);
		$formForum->render();
	}
	
	$table = new HDataTable(DB_PREFIX . "forum_sections", 
		array(
			"<a href='./forum?forum={ID}'>{Title}</a>" => "Sekce"
		)
	);
	
	$table->render();
	
	$section_table = new HDataTable(DB_PREFIX . "forums", 
		array(
			"<a href='./forum?forum={ID}'>{Title}</a>" => "Forum"
		)
	);
	
	$section_table->render();
?>
