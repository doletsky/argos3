<?
include($_SERVER["DOCUMENT_ROOT"]."/include/tcpdf/tcpdf.php");

$header = '<html><body>';
$content = "";
	$content = $content.'<h1>Рекламация</h1><p>';
	if($organization!==''){
		$content = $content.'Организация: '.$organization.'<br/>';
	}
	if($city!==''){
		$content = $content.'Город : '.$city.'<br/>';
	}
	if($contact!==''){
		$content = $content.'Контактное лицо : '.$contact.'<br/>';
	}
	if($mail!==''){
		$content = $content.'Почта : '.$mail.'<br/>';
	}
	if($phone!==''){
		$content = $content.'Телефон : '.$phone.'<br/>';
	}
	if($date!==''){
		$content = $content.'Дата покупки : '.$date.'<br/>';
	}
	if($num_date!==''){
		$content = $content.'Номер и дата сопроводительного документа : '.$num_date.'<br/>';
	}
	$content = $content.'</p>';
	$content = $content.'<h3>Товары:</h3><p>';
	//foreach($arRes['data'] as $k=>$v){
		$content = $content.'Наименование: '.$v['item_name'].'<br/>';
		$content = $content.'Последние цифры спецификации: '.$v['last_num'].'<br/>';
		$content = $content.'Номер партии: '.$v['issue_num'].'<br/>';
		$content = $content.'Количество с дефектом: '.$v['def_num'].'<br/>';
		$content = $content.'Количество всего: '.$v['all_num'].'<br/>';
		if($v['first_on']=='on'){
			$content = $content.'Не работает при первом включении: Да<br/>';
		}
		if($v['stop_after']=='on'){
			$content = $content.'Перестал работать через: '.$v['stop_days'].' дней<br/>';
		}
		$content = $content.'Описание дефекта: '.$v['def_desc'].'<br/>';
		$content = $content.'Возможные причины: '.$v['def_cause'].'<br/>';
		$content = $content.'Момент обнаружения: '.$v['def_moment'].'<br/><br/>';
		$content = $content.'Файлы: ';
		//foreach($arRes['files'][$k] as $file){
			$content = $content.'<br/>'.$file;
		//}
		$content = $content.'</p>';
		$content = $content.'<p>';
	//}
	$content = $content.'</p>';
	$content = $content.'<h4>Дополнительные файлы:</h4>';
	$content = $content.'<p>';
	/*foreach($arRes['files']['dop'] as $k=>$dopfiles){
		foreach($dopfiles as $dopfile){
			$content = $content.' '.$dopfile.'<br/>';
		}
	}*/
	$content = $content.'</p>';
$footer = '</body></html>';
//echo $content;
//$content = iconv("cp1251", "utf8", $content);
//echo $content;
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetMargins(20, 30, 20);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('dejavusans');
$pdf->AddPage();
$pdf->writeHTML($content, true, false, true, false, '');
$pdf->Output($_SERVER["DOCUMENT_ROOT"]. "/_system/test.pdf", "F");
?>