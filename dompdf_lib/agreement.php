<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
//$APPLICATION->SetTitle("Договор оформлен");

if(isset($_SESSION['agreement']) && isset($_GET['DOWNLOAD'])){

    $html='<html><head><meta http-equiv="content-type" content="text/html; charset=utf-8" /></head><body>';
    $html=$html.'
<style>
    #agree_content{
        line-height: 10px;
        font-family: DejaVu Sans;
    }
    #agree_content h1{
        float: none;
        text-align: center;
        font: bold 12px/18px Arial;
        margin: 0;
    }
    table{
        border-right: 1px solid black;
    }
    table td{
        font-size: 10px;
        padding: 0 2px;
        border: 1px solid black;
        border-top: 0;
        border-right: 0;
        vertical-align: top;
        border-collapse: collapse;
    }
    .b{
        font-weight: bold;
    }
    .black{
        color: #000000;
    }
    .white{
        color: #ffffff;
    }
    .bgblack{
        background: #555555;
    }
</style>';
    $html=$html.'
<div id="agree_content">
    <h1>ДОГОВОР<br/> ПОСТАВКИ СВЕТОТЕХНИЧЕСКОЙ ПРОДУКЦИИ<br/> № ____ от '.date('Y').'г.<br/> ОСОБЫЕ УСЛОВИЯ</h1>
    <table  cellpadding="0" cellspacing="0" style="background: #C9C9C9; font-family: sans;border-top: 1px solid black;">
        <tr>
            <td class="b black" style="width: 48%;">ПОСТАВЩИК</td>
            <td></td>
            <td class="b black" style="width: 48%;">ПОКУПАТЕЛЬ</td>
        </tr>
        <tr>
            <td><span class="b black">Общество с ограниченной ответственностью «Торговая компания «Аргос-Трейд»</span>, в лице  Генерального директора Соколова Сергея Юрьевича, действующего на основании Устава.</td>
            <td></td>
            <td><span class="b black">'.$_SESSION['agreement']['jur_form_full'].' «'.$_SESSION['agreement']['jur'].'»</span>, в лице '.$_SESSION['agreement']['pos'].' '.$_SESSION['agreement']['fio'].', действующего на основании '.$_SESSION['agreement']['fund'].'</td>
        </tr>
    </table>
    <table  cellpadding="0" cellspacing="0" style="width: 100%">
        <tr>
            <td class="b white bgblack" style="background: #555555; color: #ffffff;">А-1 ПРЕДМЕТ ДОГОВОРА</td>
        </tr>
        <tr>
            <td>
                ■ Поставщик обязуется поставить Покупателю, а Покупатель принять и оплатить светотехническую продукцию (товар/продукцию) на условиях, в ассортименте и количестве, определенным настоящим Договором.<br />
                ■ Окончательный ассортимент и количество фактически поставленной по настоящему договору светотехнической продукции определяется по данным подписанных сторонами товарных накладных (форма ТОРГ-12).
            </td>
        </tr>
    </table>
    <table  cellpadding="0" cellspacing="0">
        <tr>
            <td class="b white bgblack" style="background: #555555; color: #ffffff;">А-2 ЦЕНА ДОГОВОРА</td>
        </tr>
        <tr>
            <td>
                Цена светотехнической продукции, поставляемой в рамках настоящего Договора, определяется на основании действующего на момент совершения заказа прайс-листа Поставщика, размещенного на официальном сайте ООО «ТК «Аргос-Трейд» (http://www.argos-trade.com/), с учетом действующих скидок, рекламных акций, специальных предложений и указывается в соответствующем счете, выставляемым Поставщиком в момент заказа продукции. Цены, указанные в счете на предварительную оплату действительны в течение двух дней от даты выставления счета.
            </td>
        </tr>
    </table>
    <table  cellpadding="0" cellspacing="0">
        <tr>
            <td class="b white bgblack" style="background: #555555; color: #ffffff;">А-3 ПОРЯДОК ОПЛАТЫ</td>
        </tr>
        <tr>
            <td>
                Если иное не установлено счетом, оплата светотехнической продукции, поставляемой в рамках настоящего Договора, осуществляется в российских рублях простым банковским переводом на расчетный счет Поставщика, в размере 100% предоплаты от общей стоимости каждой конкретной поставки товара, определенной в соответствующем счете.
                Стороны установили, что в рамках настоящего Договора законные проценты на сумму долга за период пользования денежными средствами по любому денежному обязательству каждой из Сторон, предусмотренные ст.317.1 Гражданского кодекса РФ, не начисляются и не подлежат к уплате противоположной Стороне по Договору.
            </td>
        </tr>
    </table>

    <table  cellpadding="0" cellspacing="0">
        <tr>
            <td class="b white bgblack" style="background: #555555; color: #ffffff;">А-4 УСЛОВИЯ ПОСТАВКИ</td>
        </tr>
        <tr>
            <td>
                ■ Поставка по настоящему Договору осуществляется на условиях самовывоза, либо путем отгрузки продукции транспортом, предусмотренным настоящим Договором поставки.<br />
                ■  Срок поставки продукции согласовывается и указывается Сторонами в счете, выставляемом Поставщиком.<br />
                ■ Датой поставки продукции на условия самовывоза Покупателем со склада Поставщика является дата, указанная в накладной Покупателем о получении груза. Датой поставки продукции на условиях отгрузки установленным транспортом в адрес Покупателя является дата передачи груза первому перевозчику.<br />
                ■ Право собственности и риск случайной гибели продукции переходит к Покупателю с момента передачи продукции Покупателю или первому перевозчику.<br />
                ■ Адрес склада Поставщика: Россия, г. Санкт-Петербург, ул. Предпортовая дом 6 корп.6;
            </td>
        </tr>
    </table>

    <table  cellpadding="0" cellspacing="0" style="width: 100%;">
        <tr>
            <td colspan="6" class="b white bgblack" style="background: #555555; color: #ffffff;">А-5 ВИД ТРАНСПОРТА</td>
        </tr>
        <tr>
            <td>V</td>
            <td>Автомобильный</td>
            <td>V</td>
            <td>Железнодорожный</td>
            <td>V</td>
            <td>Авиатранспорт</td>
        </tr>
    </table>
    <table  cellpadding="0" cellspacing="0">
        <tr>
            <td class="b white bgblack" style="background: #555555; color: #ffffff;">А-6 ИНОЕ</td>
        </tr>
        <tr>
            <td>
                ■ Покупатель обязуется обеспечить возврат товарной накладной (экземпляра Поставщика) с отметкой о получении Товара, заверенной подписью полномочного лица Покупателя (с указанием наименования должности лица, принимающего Товар и с расшифровкой подписи), при этом Покупатель обязуется в срок, не превышающий 10 (десяти) календарных дней, предоставить Поставщику посредством электронной почты документ, подтверждающий надлежащее исполнение обязательств установленных настоящим пунктом Договора (почтовая квитанция, курьерская расписка и т.п.). В случае неисполнения обязанности установленной настоящим пунктом, Поставщик вправе приостановить все поставки продукции по настоящему Договору.<br />
                ■ Все споры и разногласия между сторонами по настоящему договору будут решаться путем переговоров. В случае невозможности разрешения спора, он передается на рассмотрение Арбитражного суда города Санкт-Петербурга и Ленинградской области. Соблюдение претензионного порядка является обязательным для Сторон.<br />
                ■ Качество продукции должно соответствовать требованиям (ГОСТ, ТУ или другим), применяемым изготовителем продукции при изготовлении продукции и подтверждаться сертификатом качества/соответствия, копию которого Поставщик предоставляет Покупателю с первой партией продукции. Гарантийный срок и условия выполнения Поставщиком гарантийных обязательств определяется в соответствии с паспортом изделия, передаваемым Покупателю вместе с поставляемой продукцией.<br />
                ■ В случае возникновения гарантийного случая Покупатель/Грузополучатель обязуется письменно уведомить Поставщика о выявленных недостатках/неисправности в течение 5 (пяти) рабочих дней с момента обнаружения. При этом к указанному в настоящем пункте уведомлению в обязательном порядке прикладывается фотофиксация выявленных недостатков/неисправностей.
            </td>
        </tr>
        <tr>
            <td class="b white bgblack" style="background: #555555; color: #ffffff;">А-7 СРОК ДЕЙСТВИЯ ДОГОВОРА</td>
        </tr>
        <tr>
            <td>
                Настоящий договор заключен на неопределенный срок. Каждая из сторон вправе отказаться от настоящего договора, письменно предупредив об этом другую сторону за 10 календарных дней.
            </td>
        </tr>
        <tr>
            <td class="b white bgblack" style="background: #555555; color: #ffffff;">А-8 АДРЕСА И РЕКВИЗИТЫ СТОРОН:</td>
        </tr>
    </table>
    <table  cellpadding="0" cellspacing="0" style="width: 100%;">
        <tr>
            <td style="width: 50%"><span class="b">ПОСТАВЩИК:</span><br/>
                <span class="b">ООО «ТК «Аргос-Трейд»</span><br/>
                Адрес местонахождения: 196240 г. Санкт-Петербург, ул. Предпортовая, д.6, лит.Е<br/>
                Почтовый адрес: 192236 г. Санкт-Петербург, а/я 57.<br/>
                Телефон: (812) 458-55-63, 458-55-64<br/>
                ИНН 4725484010<br/>
                КПП 781001001<br/>
                ОГРН 1134725001366 <br/>
                Р/с 40702810655100000470  <br/>
                в СЕВЕРО-ЗАПАДНЫЙ БАНК ПАО «СБЕРБАНК РОССИИ» г.СПб<br/>
                К/с 30101810500000000653<br/>
                БИК 044030653<br/>
                E-mail:	artkun@argo-s.net
            </td>
            <td><span class="b">ПОКУПАТЕЛЬ:</span><br/>
                <span class="b">' . $_SESSION['agreement']['jur_form'] . ' «'.$_SESSION['agreement']['jur'].'»</span><br/>
                Юр.адрес: '.$_SESSION['agreement']['juraddr'].'<br/>
                Почт.адрес: '.$_SESSION['agreement']['factaddr'].'<br/>
                Телефон: '.$_SESSION['agreement']['phone'].'<br/>
                ИНН '.$_SESSION['agreement']['inn'].'<br/>
                КПП '.$_SESSION['agreement']['kpp'].'<br/>
                ОГРН  '.$_SESSION['agreement']['ogrn'].'<br/>
                Р/с   '.$_SESSION['agreement']['rs'].'<br/>
                в '.$_SESSION['agreement']['bank'].'<br/>
                К/с '.$_SESSION['agreement']['ks'].'<br/>
                БИК '.$_SESSION['agreement']['bik'].'<br/>
                E-mail: '.$_SESSION['agreement']['mail'].'<br/>
            </td>
        </tr>
        <tr>
            <td style="padding-top: 20px;">
                Генеральный директор<br/> ____________________ /Соколов С.Ю./<br/><br/>
                М.П.
            </td>
            <td style="padding-top: 20px;">
                '.$_SESSION['agreement']['pos_imenit'].'<br/> ____________________ /'.$_SESSION['agreement']['fio_imenit'].'/<br/><br/>
                М.П.
            </td>
        </tr>
    </table>
</div>';
    $html=$html.'</body></html>';

//print_r($_SESSION);
//print $html;

    require_once("dompdf/dompdf_config.inc.php");

    try {

        $dompdf = new DOMPDF();
        $dompdf->set_paper(array(0,0,595.28,841.89));//="A4"
        $dompdf->load_html($html);
        $dompdf->render();
        $dompdf->stream("agreement.pdf");


        unset($_SESSION['agreement']);

    } catch (Exception $e) {

        print $e->getMessage();

    }



}else{
    echo 'Произошла ошибка сохранения сессии или не передан необходимый параметр, попробуйте ещё раз';
}
?> 