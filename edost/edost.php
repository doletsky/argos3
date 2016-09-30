<?
/*
== ���������� POST ������� ========================================

�� ���������� ��������� � POST ������� ������������ ������ ��������.
��������� ��������� � ���� ������� (���������: �������� �������� (�������� ������) - ���������� ���� �������� - ���� �������� � ������).

��������� ��������� � POST �������:
1. edost_to_city - ����� ��� ������, ���� ��������� ��������� ������� (�������� �� ������� ����� � ��������� windows-1251)
2. edost_weight - ��� � ��
3. edost_strah - ����� ��� ��������� � ������
4. edost_length - ����� ������� (����� �� ���������)
5. edost_width - ������ ������� (����� �� ���������)
6. edost_height - ������ ������� (����� �� ���������)
7. edost_zip - �������� ������ (����� �� ���������)

===================================================================
*/


//== ��������� ����� ������ =======================================
//	ini_set("display_errors","0");
//	ini_set("display_startup_errors","0");

$strJavaScriptPickPoint  = '<script type="text/javascript" src="http://www.pickpoint.ru/select/postamat.js"></script>';

$strJavaScript  = <<<EOT
<script language=javascript>

function EdostPickPoint(rz) {
	document.getElementById("edost_select_pickpoint").innerHTML='<br>������ ��������: '+rz['name']+', '+rz['id']+', '+rz['address'];
}

function edost_deliveryclick() {
	var arr = new Array();
	arr = document.getElementsByName("edost_delivery");

	for (var i = 0; i < arr.length; i++) {
		var obj = document.getElementsByName("edost_delivery").item(i);

		if (obj.checked == true) {
			//obj.value;
			var rez = obj.value.split('|');
			var s='';
			if ( ( rez[4] != -1 )) s='<br> ��������� �������� ��� ���������� �������: '+rez[4]+' ���., ������� ��� ���������: '+rez[5]+' ���.';
			document.getElementById("edost_select_delivery").innerHTML='������ �����: '+rez[0]+' ('+rez[1]+'), ��� ������: '+obj.id+', ���-�� ����: '+rez[2]+', ����: '+rez[3]+' ���.'+s;
			document.getElementById("edost_select_pickpoint").innerHTML='';
			break;
		}
	}
}

</script>
EOT;

require("edost_class.php"); //����������� ������ edost


//== ������ �������� ==============================================
	$edost_calc = new edost_class (); //�������� ������ edost

	$edost_calc -> SetSiteWin(); //����� ���������� � ��������� win
	$r = $edost_calc -> edost_calc_post(); //����� ������� �������� �� ���������� ��������� � POST �������

	//echo "<br><pre>".print_r($r, true)."</pre>";

	$st = '';
	$st = '<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">';
	$flPickPoint=false;

//	��������� ��������� � ������ r:
//	1. r['stat'] - ��� ���������� �������
//	2. r['qty_company'] - ���������� �������
//		������ �� ������� ������ (N):
//		3. r['id'.N] - ��� ������
//		4. r['price'.N] - ���� �������� � ������
//		5. r['day'.N] - ���������� ���� ��������
//		6. r['starh'.N] - ��� ����������� (1 - ���������� �� ����������, 0 - ���������� ��� ���������)
//		7. r['company'.N] - �������� ��������
//		8. r['name'.N] - �������� ������

//== ����� ����������� ============================================

	//echo "<br><pre>".print_r($r['warning'], true)."</pre>";

	$warning_name = array(
		1 => '��������� ��������� � ��������� �������� �� ����������!',
		2 => '� ����� ������� ��� ��������� ��������� � ��������� ��������!',
		);


	if ( isset($r['warning']) && count($r['warning'])>0 ) {
		foreach($r['warning'] as $n)
			$st .= "<b>��������������:</b> {$warning_name[$n]}<br><br>";
	}

	if ( $r['qty_company']==0 ) {
		switch($r['stat']) {
			// ���� ������ �� �������� ������� �� ������ edost
			case 2:		$st = "������ � ������� ������������"; break;
			case 3:		$st = "�� ������ ������ �������� (������ ��� �������������)"; break;
			case 4:		$st = "�� ������ ������� ���������"; break;
			case 5:		$st = "�� ������ ����� ��� ������"; break;
			case 6:		$st = "���������� ������ ������� ��������"; break;
			case 7:		$st = "�� ������ �������� �������� � ���������� ��������"; break;
			case 8:		$st = "������ ������� �� ��������"; break;
			case 9:		$st = "�������� ����� �������� �� ����"; break;
			case 11:	$st = "�� ������ ���"; break;
			case 12:	$st = "�� ������ ������ �������� (������ ��� �������������)"; break;
			case 14:	$st = "��������� ������� �� ��������� ��������� ������ �� ������"; break;
			case 15:	$st = "�� ������ ����� ��������"; break;
			case 16:	$st = "��� �������� ���� �� ������������ ����������� ��������� ������ ��������"; break;
			// ���� ������ �� ������ edost_class
			case 10:	$st = "�� ������ ������ XML"; break;
			default:	$st = "� ������ ����� �������������� ������ �������� �� ��������������";
		};
	}
	else {

/*
		$st =
// �������
	'<table align="center" width="700" cellpadding="0" cellspacing="0" border="1" bordercolor="#D0D0D0">
		<tr height="15">
			<td width="30%" align="center">������ ��������</td>
			<td width="30%" align="center">��� �����������</td>
			<td width="15%" align="center">���� ��������</td>
			<td align="center">���������</td>
		</tr>';

		for ($i=1; $i<=$r['qty_company']; $i++) {
			if ($r['name'.$i]=='') $q='&nbsp;'; else $q=$r['name'.$i];
				$st = $st.
		'<tr height="15">'.
			'<td align="center">'.$r['company'.$i].'</td>'.
			'<td width="20%" align="center">'.$q.'</td>'.
			'<td align="center">'.$r['day'.$i].'</td>'.
			'<td align="center">'.$r['price'.$i].'</td>'.
// ��������� �������� � ��������� ��������� �������� ��� ���������� �������
//			'<td align="center">'.$r['price'.$i].' ('.$r['pricecash'.$i].') - ('.$r['transfer'.$i].')</td>'.
		'</tr>';
			}

		$st = $st.
	'</table>';

		$st = $st.'<br><br><br>';
*/

		$st .=
// ������� � �������
	'<table align="center" width="700" cellpadding="0" cellspacing="0" border="1" bordercolor="#D0D0D0" style="font: normal 14px/14px Arial;">
		<tr height="15"><td>
			<table align="center" width="700" cellpadding="0" cellspacing="0" border="0" bordercolor="#D0D0D0"><tr>
				<td width="25"></td>
				<td width="70"></td>
				<td width="35%">������ ��������</td>
				<td width="20%" align="center">��� �����������</td>
				<td width="15%" align="center">���� ��������</td>
				<td align="center">���������</td>
			</tr></table>
		</td></tr>';

		$office = '';
		for ($i=1; $i<=$r['qty_company']; $i++) {
			if ($r['name'.$i]=='') $q=''; else $q=' ('.$r['name'.$i].')';

			if ( isset($r['office'.$i]) && isset($r['office'.$i][0]['name']) ) {
				$office .= '<table align="center" width="700" cellpadding="0" cellspacing="0" border="0" bordercolor="#D0D0D0">
				<tr><td style="padding-top: 10px;"><b>'.$r['company'.$i].'</b>:<td></tr>';
				//echo "<br><pre>".print_r($r['office'.$i], true)."</pre>";
				for ($h = 0; $h < count($r['office'.$i]); $h++) {
					//echo '<br>'.$i.' = '.$r['office'.$i][$h]['name'];

					if ( isset($r['office'.$i][$h]['name']) ) {

						$office .= '<tr><td style="padding-top: 10px;">����� ������ '.'<b>'.$r['office'.$i][$h]['name'].'</b>';

						if (isset($r['office'.$i][$h]['id']))
							$office .= ' (<a href="http://www.edost.ru/office.php?c='.$r['office'.$i][$h]['id'].'" target="_blank" style="cursor: pointer; text-decoration: none;" >�������� �� �����</a>)';

                	    $office .= '<br>';

						if (isset($r['office'.$i][$h]['code'])) $office .= '���: '.$r['office'.$i][$h]['code'].', ';
						if (isset($r['office'.$i][$h]['address'])) $office .= '�����: '.$r['office'.$i][$h]['address'].', <br>';
						if (isset($r['office'.$i][$h]['tel'])) $office .= '�������: '.$r['office'.$i][$h]['tel'].', ';
						if (isset($r['office'.$i][$h]['schedule'])) $office .= '����: '.$r['office'.$i][$h]['schedule'].' ';
						$office .= '<td></tr>';
					}

				}
				$office .= '</table>';
			}

				if ($r['id'.$i] == 29) {
					$flPickPoint=true;
					$refPickPoint = '<br><a style="font-family: Arial; font-size: 10pt; color: rgb(222, 0, 0); text-decoration: none;" href="#" id="EdostPickPointRef1" onclick="PickPoint.open(EdostPickPoint, {city:\''.$r['pickpointmap'.$i].'\', ids:null});">������� �������� ��� ����� ������</a>';
				}
				else {
					$refPickPoint = '';
				}

				$for_label = $r['id'.$i].'-'.$r['strah'.$i];
				$st .=
		'<tr height="40"><td>
			<table align="center" width="700" cellpadding="0" cellspacing="0" border="0" bordercolor="#D0D0D0"><tr>'.

				'<td height="40" width="25" align="center"> <input type="radio" id="'.$for_label.'" name="edost_delivery" value="'.$r['company'.$i].'|'.$r['name'.$i].'|'.$r['day'.$i].'|'.$r['price'.$i].'|'.$r['pricecash'.$i].'|'.$r['transfer'.$i].'" onclick="edost_deliveryclick();"> </td>'.
				'<td width="70"><label for="'.$for_label.'"><img src="delivery_img/'.$r['id'.$i].'.gif" width="60" height="32" border="0"></label> </td>'.
				'<td width="35%">'.$r['company'.$i].$refPickPoint.'</td>'.
				'<td width="20%" align="center">'.$r['name'.$i].'</td>'.
				'<td width="15%" align="center">'.$r['day'.$i].'</td>'.
				'<td align="center"><p class="c2"><b>'.$r['price'.$i].' ���.</b></p></td>'.

			'</tr></table>
		</td></tr>';
		}


		$st .=
	'</table>';

		$st .= $office;

		$st .=
	'<table align="center" width="700" cellpadding="0" cellspacing="0" border="0" bordercolor="#D0D0D0" style="font: normal 14px/14px Arial;"> 
		<tr height="15"><td>
			<br><span id="edost_select_delivery"></span>
			<br><span id="edost_select_pickpoint"></span>
		</td></tr>
	</table>';

	}

	if (!$flPickPoint) $strJavaScriptPickPoint = ''; //���� ��� ������ PickPoint, �� �� ���������� JavaScript

	//$st = $edost_calc -> decode($strJavaScriptPickPoint.$strJavaScript.$st); // ������������ ��������� � ��������� �������� (���� ��������� � �� ������ ��������� - ������� ��� ������)

	echo $st;

?>