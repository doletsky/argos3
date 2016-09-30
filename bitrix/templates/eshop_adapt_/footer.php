<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
		</div><!-- //workarea_wrap-->
		</div></div><!-- //footer_bot_1 footer_bot_2-->
		<div id="footer" >			
			<div class="footer_inner">
				<div class="footer_col col_1">
					<div class="text"><?=GetMessage("ADDRESS_1")?></div>
					<div class="text"><?=GetMessage("ADDRESS_2")?></div>
				</div>
				<div class="footer_col col_2">
					<div class="text"><?=GetMessage("PHONE_1")?></div>
					<div class="text"><?=GetMessage("PHONE_2")?></div>
				</div>
				<div class="footer_col col_3">

				</div>
				<div class="clear"></div>
				<div class="copyright">© <?=date('Y')?> <?=GetMessage("ARGOS_TRADE")?>
					<?/*<a target="_blank" href="http://vsl-studio.ru/"><?=GetMessage("DEVELOPED_IN")?></a>*/?>
				</div>
			</div>
		</div>
		
		<?//Окно при закрытии страниц сайта?>
		<?/*<div id="modal_w_body">
			<div id="modal_w_wrap"></div>
			<div id="exit_site_win" class="modal_w">
				<div class="close">X</div>
				<div class="title">При закрытии сайта все заказы в корзине будут не сохранены.</div>
				<a class="order" href="<?=SITE_DIR?>personal/cart/">Оформить заказ</a>
				<a href="javascript:void(0)" class="close_win">Продолжить покупки</a>
				<div class="clear"></div>
				<a href="javascript:void(0)" onclick="parent.self.close(); return false" id="close_site">Закрыть сайт компании «Аргос-Трейд»</a>
				<div class="clear"></div>
			</div>
		</div>*/?>
		
		<?//Окно Поделиться?>
		<div id="modal_w_body">
			<div id="modal_w_wrap"></div>
			<div id="share_win" class="modal_w">
				<div class="close">X</div>
				<div class="title"><?=GetMessage("SHARE_LINK")?></div>
				<form id="share_form">
					<input type="text" name="share_email" id="share_email" value="E-mail" />
					<input type="submit" value="<?=GetMessage("SHARE_SUBMIT")?>" />
					<div id="share_err"></div>
				</form>
			</div>
		</div>
		
		<?/*<div id="modal_w_body">
			<div id="modal_w_wrap"></div>
			<div id="feedback_win" class="modal_w">
				<div class="close">X</div>
				<div class="title"><?=GetMessage("FEEDBACK_TITLE")?></div>
				<form id="feedback_form">
					<input type="text" name="feedback_name" id="feedback_name" value="<?=GetMessage("FEEDBACK_NAME")?>" />
					<input type="text" name="feedback_phone" id="feedback_phone" value="<?=GetMessage("FEEDBACK_PHONE")?>" />
					<input type="text" name="feedback_email" id="feedback_email" value="E-mail" />
					<textarea id="feedback_mess"></textarea>
					<input type="submit" value="<?=GetMessage("FEEDBACK_SUBMIT")?>" />
					<div id="feedback_err"></div>
				</form>
			</div>
		</div>
	</div>*/?>
<!-- //wrap -->


<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter28715076 = new Ya.Metrika({
                    id:28715076,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/28715076" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>