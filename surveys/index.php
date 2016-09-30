<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Опросы");?>

<div id="content">
	<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "eshop_adapt", array(
			"START_FROM" => "1",
			"PATH" => "",
			"SITE_ID" => "-"
		),
		false,
		Array('HIDE_ICONS' => 'Y')
	);?>
	<div class="content_left">
		<!-- Vertical menu -->
		<?$APPLICATION->IncludeComponent("bitrix:menu", "tree_vertical", array(
			"ROOT_MENU_TYPE" => "vert_about",
			"MENU_CACHE_TYPE" => "A",
			"MENU_CACHE_TIME" => "36000000",
			"MENU_CACHE_USE_GROUPS" => "Y",
			"MENU_CACHE_GET_VARS" => array(),
			"MAX_LEVEL" => "2",
			"CHILD_MENU_TYPE" => "podmenu",
			"USE_EXT" => "N",
			"ALLOW_MULTI_SELECT" => "N"
			),
			false
		);
		?>
		<?include ($_SERVER["DOCUMENT_ROOT"].SITE_DIR."sidebar.php");?>
	</div>
	<div class="content_right">		
		<h1>Опросы</h1>
		<div class="clear"></div>
		<div class="include_area_page"> 
			
			<?
			global $USER;
			if($USER->IsAdmin()){			
				?><h3 class="vote-title">Русская версия</h3><?
				
				$list = GetVoteList("", array(), "s1");
				while($list_res = $list->GetNext()){
					?><h3 class="vote-title"><?=$list_res["TITLE"]?></h3><?
					
					$APPLICATION->IncludeComponent(
					"bitrix:voting.result",
					"",
					Array(
						"VOTE_ID" => $list_res["ID"],
						"VOTE_ALL_RESULTS" => "Y",
						"CACHE_TYPE" => "A",
						"CACHE_TIME" => "1200",
						"CACHE_NOTES" => "",
						//"QUESTION_DIAGRAM_1" => "histogram",
						//"QUESTION_DIAGRAM_2" => "histogram"
					)
					);
				}
								
				?><h3 class="vote-title">Английская версия</h3><?
				$list = GetVoteList("", array(), "s2");
				while($list_res = $list->GetNext()){
					?><h3 class="vote-title"><?=$list_res["TITLE"]?></h3><?
					
					$APPLICATION->IncludeComponent(
					"bitrix:voting.result",
					"",
					Array(
						"VOTE_ID" => $list_res["ID"],
						"VOTE_ALL_RESULTS" => "Y",
						"CACHE_TYPE" => "A",
						"CACHE_TIME" => "1200",
						"CACHE_NOTES" => "",
						//"QUESTION_DIAGRAM_1" => "histogram",
						//"QUESTION_DIAGRAM_2" => "histogram"
					)
					);
				}				
			
			}else{
				echo "Страница для администратора";
			}
			?>
		</div>
		
	</div>
	<div class="clear"></div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>