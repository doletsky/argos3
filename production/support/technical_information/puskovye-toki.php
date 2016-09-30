<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Пусковые токи");
?> 
<div id="content"> <?$APPLICATION->IncludeComponent(
	"bitrix:breadcrumb",
	"eshop_adapt",
	Array(
		"START_FROM" => "1",
		"PATH" => "",
		"SITE_ID" => "-"
	),
false,
Array(
	'HIDE_ICONS' => 'Y'
)
);?> 	 
  <div class="content_left"> 		 <?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"tree_vertical",
	Array(
		"ROOT_MENU_TYPE" => "vert_production",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "36000000",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(),
		"MAX_LEVEL" => "2",
		"CHILD_MENU_TYPE" => "podmenu",
		"USE_EXT" => "N",
		"ALLOW_MULTI_SELECT" => "N"
	)
);?> <?include ($_SERVER["DOCUMENT_ROOT"].SITE_DIR."sidebar.php");?> </div>
 	 
  <div class="content_right"> 
    <h1 align="center">Пусковые токи источников питания ООО Аргос-Элеткрон.</h1>
   
    <div class="clear"></div>
   
    <p>Эта информация должна упростить задачу выбора автоматического выключателя (MCB), защищающего линию питания группы светодиодных источников света.</p>
   
    <p>Стандартный автоматический выключатель состоит из двух механизмов, вызывающих размыкание цепи: тепловой размыкатель и электромагнитный размыкатель. Тепловой размыкатель обеспечивает защиту от долговременных превышений номинальных токов (до нескольких крат) и его номинал учитывается при расчете долговременной мощности. Электромагнитный размыкатель призван обеспечить защиту цепей от токов короткого замыкания, отличается высоким быстродействием и высокими порогами срабатывания. Так выключатель с характеристикой &ldquo;B&rdquo; начинает срабатывать при превышении током номинальных значений в 3 &ndash; 5 раз, а выключатель с характеристикой “C” – начиная с 5 – 10 крат.</p>
   
    <p> </p>
   
    <p>Большинство источников питания светодиодных источников света во входных цепях имеют накопительный конденсатор, который заряжается при подключении источника к сети. Этот процесс сопровождается большими токами потребления в сети питания и может вызывать ложное срабатывание электромагнитного расцепителя автоматического выключателя, когда &laquo;пусковые токи&raquo; группы источников превысят порог чувствительности. В связи с этим, многие производители источников питания приводят данные о максимальном количестве своих изделий, которые можно подключить к сети питания через автоматические выключатели с различными номинальными токами и характеристиками электромагнитного расцепителя. Источники питания производства ООО Аргос-Электрон, приведенные в данной таблице, отличаются в своей конструкции отсутствием во входных цепях накопительных конденсаторов больших емкостей и <b>не вызывают срабатывания электромагнитного расцепителя</b>. Для выбора автоматического выключателя достаточно учесть долговременную потребляемую мощность, то есть рассчитать ток в цепи питания из потребляемой мощности и напряжения сети и выбрать ближайший больший номинал автомата. При этом, если источники питания нагружены не полностью (50&mdash;100%), это можно учитывать при расчете таким же прямым пересчетом мощности в ток.</p>
   
    <p> </p>
   
    <p> </p>
   
    <p> </p>
   
    <p align="center">Количество полностью нагруженных источников питания, подключаемых на один автоматический выключатель.</p>
   
    <p align="center"> 
      <br />
     </p>
   
    <table class="table"> 
      <tbody> 
        <tr> <td rowspan="2"> 
            <p align="center">Тип ИПС</p>
           </td> <td rowspan="2"> 
            <p align="center">Выходная мощность, Вт</p>
           </td> <td colspan="3"> 
            <p align="center">Автомат типа В, </p>
           
            <p align="center">нагрузка драйверов 100%</p>
           </td> <td colspan="3"> 
            <p align="center">Автомат типа C, </p>
           
            <p align="center">нагрузка драйверов 100%</p>
           </td> </tr>
       
        <tr> <td> 
            <p align="center">B6А</p>
           </td> <td> 
            <p align="center">B10А</p>
           </td> <td> 
            <p align="center">B16А</p>
           </td> <td> 
            <p align="center">C6А</p>
           </td> <td> 
            <p align="center">C10А</p>
           </td> <td> 
            <p align="center">C16А</p>
           </td> </tr>
       
        <tr> <td rowspan="5"> 
            <p align="center">ОФИС</p>
           </td> <td> 
            <p align="center">30</p>
           </td> <td> 
            <p align="center">35</p>
           </td> <td> 
            <p align="center">59</p>
           </td> <td> 
            <p align="center">94</p>
           </td> <td> 
            <p align="center">35</p>
           </td> <td> 
            <p align="center">59</p>
           </td> <td> 
            <p align="center">94</p>
           </td> </tr>
       
        <tr> <td> 
            <p align="center">35</p>
           </td> <td> 
            <p align="center">30</p>
           </td> <td> 
            <p align="center">50</p>
           </td> <td> 
            <p align="center">81</p>
           </td> <td> 
            <p align="center">30</p>
           </td> <td> 
            <p align="center">50</p>
           </td> <td> 
            <p align="center">81</p>
           </td> </tr>
       
        <tr> <td> 
            <p align="center">39</p>
           </td> <td> 
            <p align="center">27</p>
           </td> <td> 
            <p align="center">45</p>
           </td> <td> 
            <p align="center">73</p>
           </td> <td> 
            <p align="center">27</p>
           </td> <td> 
            <p align="center">45</p>
           </td> <td> 
            <p align="center">73</p>
           </td> </tr>
       
        <tr> <td> 
            <p align="center">50</p>
           </td> <td> 
            <p align="center">21</p>
           </td> <td> 
            <p align="center">36</p>
           </td> <td> 
            <p align="center">57</p>
           </td> <td> 
            <p align="center">21</p>
           </td> <td> 
            <p align="center">36</p>
           </td> <td> 
            <p align="center">57</p>
           </td> </tr>
       
        <tr> <td> 
            <p align="center">60</p>
           </td> <td> 
            <p align="center">18</p>
           </td> <td> 
            <p align="center">30</p>
           </td> <td> 
            <p align="center">48</p>
           </td> <td> 
            <p align="center">18</p>
           </td> <td> 
            <p align="center">30</p>
           </td> <td> 
            <p align="center">48</p>
           </td> </tr>
       
        <tr> <td rowspan="5"> 
            <p align="center">IP20</p>
           </td> <td> 
            <p align="center">30</p>
           </td> <td> 
            <p align="center">36</p>
           </td> <td> 
            <p align="center">60</p>
           </td> <td> 
            <p align="center">96</p>
           </td> <td> 
            <p align="center">36</p>
           </td> <td> 
            <p align="center">60</p>
           </td> <td> 
            <p align="center">96</p>
           </td> </tr>
       
        <tr> <td> 
            <p align="center">35</p>
           </td> <td> 
            <p align="center">30</p>
           </td> <td> 
            <p align="center">51</p>
           </td> <td> 
            <p align="center">82</p>
           </td> <td> 
            <p align="center">30</p>
           </td> <td> 
            <p align="center">51</p>
           </td> <td> 
            <p align="center">82</p>
           </td> </tr>
       
        <tr> <td> 
            <p align="center">40</p>
           </td> <td> 
            <p align="center">27</p>
           </td> <td> 
            <p align="center">45</p>
           </td> <td> 
            <p align="center">72</p>
           </td> <td> 
            <p align="center">27</p>
           </td> <td> 
            <p align="center">45</p>
           </td> <td> 
            <p align="center">72</p>
           </td> </tr>
       
        <tr> <td> 
            <p align="center">50</p>
           </td> <td> 
            <p align="center">21</p>
           </td> <td> 
            <p align="center">36</p>
           </td> <td> 
            <p align="center">58</p>
           </td> <td> 
            <p align="center">21</p>
           </td> <td> 
            <p align="center">36</p>
           </td> <td> 
            <p align="center">58</p>
           </td> </tr>
       
        <tr> <td> 
            <p align="center">60</p>
           </td> <td> 
            <p align="center">18</p>
           </td> <td> 
            <p align="center">30</p>
           </td> <td> 
            <p align="center">48</p>
           </td> <td> 
            <p align="center">18</p>
           </td> <td> 
            <p align="center">30</p>
           </td> <td> 
            <p align="center">48</p>
           </td> </tr>
       </tbody>
     </table>
   
    <p> </p>
   
    <p> </p>
   
    <p> </p>
   
    <table class="table"> 
      <tbody> 
        <tr> <td rowspan="2"> 
            <p align="center">Выходная мощность, Вт</p>
           </td> <td colspan="3"> 
            <p align="center">Автомат типа В, </p>
           
            <p align="center">нагрузка драйверов 100%</p>
           </td> <td colspan="3"> 
            <p align="center">Автомат типа C, </p>
           
            <p align="center">нагрузка драйверов 100%</p>
           </td> </tr>
       
        <tr> <td> 
            <p align="center">B6А</p>
           </td> <td> 
            <p align="center">B10А</p>
           </td> <td> 
            <p align="center">B16А</p>
           </td> <td> 
            <p align="center">C6А</p>
           </td> <td> 
            <p align="center">C10А</p>
           </td> <td> 
            <p align="center">C16А</p>
           </td> </tr>
       
        <tr> <td> 
            <p align="center">35</p>
           </td> <td> 
            <p align="center">30</p>
           </td> <td> 
            <p align="center">51</p>
           </td> <td> 
            <p align="center">82</p>
           </td> <td> 
            <p align="center">30</p>
           </td> <td> 
            <p align="center">51</p>
           </td> <td> 
            <p align="center">82</p>
           </td> </tr>
       
        <tr> <td> 
            <p align="center">40</p>
           </td> <td> 
            <p align="center">27</p>
           </td> <td> 
            <p align="center">45</p>
           </td> <td> 
            <p align="center">72</p>
           </td> <td> 
            <p align="center">27</p>
           </td> <td> 
            <p align="center">45</p>
           </td> <td> 
            <p align="center">72</p>
           </td> </tr>
       
        <tr> <td> 
            <p align="center">50</p>
           </td> <td> 
            <p align="center">21</p>
           </td> <td> 
            <p align="center">36</p>
           </td> <td> 
            <p align="center">58</p>
           </td> <td> 
            <p align="center">21</p>
           </td> <td> 
            <p align="center">36</p>
           </td> <td> 
            <p align="center">58</p>
           </td> </tr>
       
        <tr> <td> 
            <p align="center">60</p>
           </td> <td> 
            <p align="center">18</p>
           </td> <td> 
            <p align="center">30</p>
           </td> <td> 
            <p align="center">48</p>
           </td> <td> 
            <p align="center">18</p>
           </td> <td> 
            <p align="center">30</p>
           </td> <td> 
            <p align="center">48</p>
           </td> </tr>
       
        <tr> <td> 
            <p align="center">50</p>
           </td> <td> 
            <p align="center">21</p>
           </td> <td> 
            <p align="center">36</p>
           </td> <td> 
            <p align="center">58</p>
           </td> <td> 
            <p align="center">21</p>
           </td> <td> 
            <p align="center">36</p>
           </td> <td> 
            <p align="center">58</p>
           </td> </tr>
       
        <tr> <td> 
            <p align="center">60</p>
           </td> <td> 
            <p align="center">18</p>
           </td> <td> 
            <p align="center">30</p>
           </td> <td> 
            <p align="center">48</p>
           </td> <td> 
            <p align="center">18</p>
           </td> <td> 
            <p align="center">30</p>
           </td> <td> 
            <p align="center">48</p>
           </td> </tr>
       
        <tr> <td> 
            <p align="center">80</p>
           </td> <td> 
            <p align="center">13</p>
           </td> <td> 
            <p align="center">22</p>
           </td> <td> 
            <p align="center">36</p>
           </td> <td> 
            <p align="center">13</p>
           </td> <td> 
            <p align="center">22</p>
           </td> <td> 
            <p align="center">36</p>
           </td> </tr>
       
        <tr> <td> 
            <p align="center">100</p>
           </td> <td> 
            <p align="center">11</p>
           </td> <td> 
            <p align="center">18</p>
           </td> <td> 
            <p align="center">29</p>
           </td> <td> 
            <p align="center">11</p>
           </td> <td> 
            <p align="center">18</p>
           </td> <td> 
            <p align="center">29</p>
           </td> </tr>
       
        <tr> <td> 
            <p align="center">120</p>
           </td> <td> 
            <p align="center">9</p>
           </td> <td> 
            <p align="center">15</p>
           </td> <td> 
            <p align="center">24</p>
           </td> <td> 
            <p align="center">9</p>
           </td> <td> 
            <p align="center">15</p>
           </td> <td> 
            <p align="center">24</p>
           </td> </tr>
       
        <tr> <td> 
            <p align="center">160</p>
           </td> <td> 
            <p align="center">7</p>
           </td> <td> 
            <p align="center">11</p>
           </td> <td> 
            <p align="center">18</p>
           </td> <td> 
            <p align="center">7</p>
           </td> <td> 
            <p align="center">11</p>
           </td> <td> 
            <p align="center">18</p>
           </td> </tr>
       
        <tr> <td> 
            <p align="center">200</p>
           </td> <td> 
            <p align="center">5</p>
           </td> <td> 
            <p align="center">9</p>
           </td> <td> 
            <p align="center">15</p>
           </td> <td> 
            <p align="center">5</p>
           </td> <td> 
            <p align="center">9</p>
           </td> <td> 
            <p align="center">15</p>
           </td> </tr>
       </tbody>
     </table>
   
    <p> </p>
   
    <p> 
      <br />
     </p>
   
    <p> 
      <br />
     </p>
   
    <p>Таблица приведена для сети питания 230В &plusmn;10% и полной нагрузке на источниках питания. Если напряжение сети ниже 207В, необходимо произвести пересчет с учетом возрастающих токов потребления. Например: в таблице на автомат В6А можно подключить 21 драйвер 50Вт в исполнении IP67, при питании от сети 190В количество уменьшится до 20 штук. При этом, если эти источники будут нагружены на 50%, их количество может быть удвоено.</p>
   </div>
 </div>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>