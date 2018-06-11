<?php

/* Модуль "Корпоративный органайзер поздравлений". Разработчик - Зимин Д.В., СПБ ИВЦ, отдел "ИНФОРМ" */

include "config.php"; 
$dbconn = odbc_connect($pg_main_name, $pg_main_username, $pg_main_password);


    
session_start();
           
if(!isset($_GET['menuitem'])) {
	$_GET['menuitem']=0;
        $hideMenu1 = true;
}
	   
if(!isset($_GET['page'])) {
	$_GET['page']=0;	       
}
	    
	    
if(!isset($_GET['sort'])) {
	$_GET['sort']='date';
}
	        
if(!isset($_SESSION['userid']) &&
	      ($_GET['menuitem']==1 || $_GET['menuitem'] > 4)){
		    Header("Location: index.php");
}
	    
$pagesText="";


		
/////////////////////////////////////////////

$prazdniki1["1"] = array("date"=>"01-01-".date("Y"), "comment"=>"", "name"=>"Новый год");
$prazdniki1["2"] = array("date"=>"23-02-".date("Y"), "comment"=>"", "name"=>"День защитника Отечества");
$prazdniki1["3"] = array("date"=>"08-03-".date("Y"), "comment"=>"", "name"=>"Международный женский день");
$prazdniki1["4"] = array("date"=>"01-05-".date("Y"), "comment"=>"", "name"=>"Праздник весны и труда");
$prazdniki1["5"] = array("date"=>"09-05-".date("Y"), "comment"=>"", "name"=>"День победы советского народа в ВОВ");
$prazdniki1["6"] = array("date"=>"12-06-".date("Y"), "comment"=>"", "name"=>"День России");
$prazdniki1["7"] = array("date"=>date('d-m-Y', strtotime('first sun of aug')), "comment"=>"первое воскресенье августа", "name"=>"День железнодорожника");
$prazdniki1["8"] = array("date"=>"01-10-".date("Y"), "comment"=>"", "name"=>"День компании");
$prazdniki1["9"] = array("date"=>"04-11-".date("Y"), "comment"=>"", "name"=>"День народного единства");
$prazdniki1["10"] = array("date"=>"12-12-".date("Y"), "comment"=>"", "name"=>"День Конституции РФ");

$prazdniki2["1"] = array("date"=>"12-01-".date("Y"), "comment"=>"", "name"=>"День работника прокуратуры РФ");
$prazdniki2["2"] = array("date"=>"13-01-".date("Y"), "comment"=>"", "name"=>"День российской печати");
$prazdniki2["3"] = array("date"=>"25-01-".date("Y"), "comment"=>"", "name"=>"День российского студенчества (Татьянин день)");
$prazdniki2["4"] = array("date"=>"26-01-".date("Y"), "comment"=>"", "name"=>"Международный день таможенника");
$prazdniki2["5"] = array("date"=>"27-01-".date("Y"), "comment"=>"", "name"=>"День снятия блокады Ленинграда ");
$prazdniki2["6"] = array("date"=>"08-02-".date("Y"), "comment"=>"", "name"=>"День российской науки");
$prazdniki2["7"] = array("date"=>"18-02-".date("Y"), "comment"=>"", "name"=>"День транспортной полиции");
$prazdniki2["8"] = array("date"=>date('d-m-Y', strtotime('third sun of mar')), "comment"=>"третье воскресенье марта", "name"=>"День работников торговли, бытового обслуживания населения и ЖКХ");
$prazdniki2["9"] = array("date"=>"27-03-".date("Y"), "comment"=>"", "name"=>"День Внутренних войск МВД РФ");
$prazdniki2["10"] = array("date"=>"12-04-".date("Y"), "comment"=>"", "name"=>"День космонавтики");
$prazdniki2["11"] = array("date"=>"30-04-".date("Y"), "comment"=>"", "name"=>"День пожарной охраны РФ");
$prazdniki2["12"] = array("date"=>"07-05-".date("Y"), "comment"=>"", "name"=>"День радио, праздник работников всех отраслей связи");
$prazdniki2["13"] = array("date"=>"18-05-".date("Y"), "comment"=>"", "name"=>"Международный день музеев");
$prazdniki2["14"] = array("date"=>"24-05-".date("Y"), "comment"=>"", "name"=>"День кадровика");
$prazdniki2["15"] = array("date"=>"27-05-".date("Y"), "comment"=>"", "name"=>"Общероссийский день библиотек");
$prazdniki2["16"] = array("date"=>"05-06-".date("Y"), "comment"=>"", "name"=>"День эколога");
$prazdniki2["17"] = array("date"=>"08-06-".date("Y"), "comment"=>"", "name"=>"День социального работника");
$prazdniki2["18"] = array("date"=>date('d-m-Y', strtotime('third sun of jun')), "comment"=>"третье воскресенье июня", "name"=>"День медицинского работника");
$prazdniki2["19"] = array("date"=>"27-06-".date("Y"), "comment"=>"", "name"=>"День молодежи в России");
$prazdniki2["20"] = array("date"=>"03-07-".date("Y"), "comment"=>"", "name"=>"Праздник ГАИ (ГИБДД МВД РФ)");
$prazdniki2["21"] = array("date"=>"08-07-".date("Y"), "comment"=>"", "name"=>"День семьи, любви и верности");
$prazdniki2["22"] = array("date"=>date('d-m-Y', strtotime('second sun of jul')), "comment"=>"второе воскресенье июля", "name"=>"День российской почты");
$prazdniki2["23"] = array("date"=>"01-08-".date("Y"), "comment"=>"", "name"=>"День рождения Ленинградской области");
$prazdniki2["24"] = array("date"=>"06-08-".date("Y"), "comment"=>"", "name"=>"День Железнодорождных войск РФ");
$prazdniki2["25"] = array("date"=>date('d-m-Y', strtotime('second sat of aug')), "comment"=>"вторая суббота августа", "name"=>"День физкультурника");
$prazdniki2["26"] = array("date"=>date('d-m-Y', strtotime('second sun of aug')), "comment"=>"второе воскресенье августа", "name"=>"День строителя");
$prazdniki2["27"] = array("date"=>"22-08-".date("Y"), "comment"=>"", "name"=>"День государственного флага РФ");
$prazdniki2["28"] = array("date"=>"01-09-".date("Y"), "comment"=>"", "name"=>"День знаний");
$prazdniki2["29"] = array("date"=>"01-10-".date("Y"), "comment"=>"", "name"=>"День пожилых людей");
$prazdniki2["30"] = array("date"=>"05-10-".date("Y"), "comment"=>"", "name"=>"День учителя");
$prazdniki2["31"] = array("date"=>"25-10-".date("Y"), "comment"=>"", "name"=>"День таможенника");
$prazdniki2["32"] = array("date"=>date('d-m-Y', strtotime('last sun of oct')), "comment"=>"последнее воскресенье октября", "name"=>"День работников автомобильного транспорта");
$prazdniki2["33"] = array("date"=>"10-11-".date("Y"), "comment"=>"", "name"=>"День сотрудника органов внутренних дел РФ");
$prazdniki2["34"] = array("date"=>"21-11-".date("Y"), "comment"=>"", "name"=>"День работника налоговых органов РФ");
$prazdniki2["35"] = array("date"=>date('d-m-Y', strtotime('last sun of nov')), "comment"=>"последнее воскресенье ноября", "name"=>"День Матери");
$prazdniki2["36"] = array("date"=>"03-12-".date("Y"), "comment"=>"", "name"=>"День Юриста");
$prazdniki2["37"] = array("date"=>date('d-m-Y', strtotime('third sun of dec')), "comment"=>"третье воскресенье декабря", "name"=>"День энергетика");
$prazdniki2["38"] = array("date"=>"20-12-".date("Y"), "comment"=>"", "name"=>"День работников органов безопасности");

$vse_prazdniki["1"] = array("date"=>"01-01-".date("Y"), "comment"=>"", "name"=>"Новый год");
$vse_prazdniki["2"] = array("date"=>"12-01-".date("Y"), "comment"=>"", "name"=>"День работника прокуратуры РФ");
$vse_prazdniki["3"] = array("date"=>"13-01-".date("Y"), "comment"=>"", "name"=>"День российской печати");
$vse_prazdniki["4"] = array("date"=>"25-01-".date("Y"), "comment"=>"", "name"=>"День российского студенчества (Татьянин день)");
$vse_prazdniki["5"] = array("date"=>"26-01-".date("Y"), "comment"=>"", "name"=>"Международный день таможенника");
$vse_prazdniki["6"] = array("date"=>"27-01-".date("Y"), "comment"=>"", "name"=>"День снятия блокады Ленинграда ");
$vse_prazdniki["7"] = array("date"=>"08-02-".date("Y"), "comment"=>"", "name"=>"День российской науки");
$vse_prazdniki["8"] = array("date"=>"18-02-".date("Y"), "comment"=>"", "name"=>"День транспортной полиции");
$vse_prazdniki["9"] = array("date"=>"23-02-".date("Y"), "comment"=>"", "name"=>"День защитника Отечества");
$vse_prazdniki["10"] = array("date"=>"08-03-".date("Y"), "comment"=>"", "name"=>"Международный женский день");
$vse_prazdniki["11"] = array("date"=>date('d-m-Y', strtotime('third sun of mar')), "comment"=>"третье воскресенье марта", "name"=>"День работников торговли, бытового обслуживания населения и ЖКХ");
$vse_prazdniki["12"] = array("date"=>"27-03-".date("Y"), "comment"=>"", "name"=>"День Внутренних войск МВД РФ");
$vse_prazdniki["13"] = array("date"=>"12-04-".date("Y"), "comment"=>"", "name"=>"День космонавтики");
$vse_prazdniki["14"] = array("date"=>"30-04-".date("Y"), "comment"=>"", "name"=>"День пожарной охраны РФ");
$vse_prazdniki["15"] = array("date"=>"01-05-".date("Y"), "comment"=>"", "name"=>"Праздник весны и труда");
$vse_prazdniki["16"] = array("date"=>"07-05-".date("Y"), "comment"=>"", "name"=>"День радио, праздник работников всех отраслей связи");
$vse_prazdniki["17"] = array("date"=>"09-05-".date("Y"), "comment"=>"", "name"=>"День победы советского народа в ВОВ");
$vse_prazdniki["18"] = array("date"=>"18-05-".date("Y"), "comment"=>"", "name"=>"Международный день музеев");
$vse_prazdniki["19"] = array("date"=>"24-05-".date("Y"), "comment"=>"", "name"=>"День кадровика");
$vse_prazdniki["20"] = array("date"=>"27-05-".date("Y"), "comment"=>"", "name"=>"Общероссийский день библиотек");
$vse_prazdniki["21"] = array("date"=>"05-06-".date("Y"), "comment"=>"", "name"=>"День эколога");
$vse_prazdniki["22"] = array("date"=>"08-06-".date("Y"), "comment"=>"", "name"=>"День социального работника");
$vse_prazdniki["23"] = array("date"=>"12-06-".date("Y"), "comment"=>"", "name"=>"День России");
$vse_prazdniki["24"] = array("date"=>date('d-m-Y', strtotime('third sun of jun')), "comment"=>"третье воскресенье июня", "name"=>"День медицинского работника");
$vse_prazdniki["25"] = array("date"=>"27-06-".date("Y"), "comment"=>"", "name"=>"День молодежи в России");
$vse_prazdniki["26"] = array("date"=>"03-07-".date("Y"), "comment"=>"", "name"=>"Праздник ГАИ (ГИБДД МВД РФ)");
$vse_prazdniki["27"] = array("date"=>"08-07-".date("Y"), "comment"=>"", "name"=>"День семьи, любви и верности");
$vse_prazdniki["28"] = array("date"=>date('d-m-Y', strtotime('second sun of jul')), "comment"=>"второе воскресенье июля", "name"=>"День российской почты");
$vse_prazdniki["29"] = array("date"=>date('d-m-Y', strtotime('first sun of aug')), "comment"=>"первое воскресенье августа", "name"=>"День железнодорожника");
$vse_prazdniki["30"] = array("date"=>"01-08-".date("Y"), "comment"=>"", "name"=>"День рождения Ленинградской области");
$vse_prazdniki["31"] = array("date"=>"06-08-".date("Y"), "comment"=>"", "name"=>"День Железнодорождных войск РФ");
$vse_prazdniki["32"] = array("date"=>date('d-m-Y', strtotime('second sat of aug')), "comment"=>"вторая суббота августа", "name"=>"День физкультурника");
$vse_prazdniki["33"] = array("date"=>date('d-m-Y', strtotime('second sun of aug')), "comment"=>"второе воскресенье августа", "name"=>"День строителя");
$vse_prazdniki["34"] = array("date"=>"22-08-".date("Y"), "comment"=>"", "name"=>"День государственного флага РФ");
$vse_prazdniki["35"] = array("date"=>"01-09-".date("Y"), "comment"=>"", "name"=>"День знаний");
$vse_prazdniki["36"] = array("date"=>"01-10-".date("Y"), "comment"=>"", "name"=>"День компании");
$vse_prazdniki["37"] = array("date"=>"01-10-".date("Y"), "comment"=>"", "name"=>"День пожилых людей");
$vse_prazdniki["38"] = array("date"=>"05-10-".date("Y"), "comment"=>"", "name"=>"День учителя");
$vse_prazdniki["39"] = array("date"=>"25-10-".date("Y"), "comment"=>"", "name"=>"День таможенника");
$vse_prazdniki["40"] = array("date"=>date('d-m-Y', strtotime('last sun of oct')), "comment"=>"последнее воскресенье октября", "name"=>"День работников автомобильного транспорта");
$vse_prazdniki["41"] = array("date"=>"04-11-".date("Y"), "comment"=>"", "name"=>"День народного единства");
$vse_prazdniki["42"] = array("date"=>"10-11-".date("Y"), "comment"=>"", "name"=>"День сотрудника органов внутренних дел РФ");
$vse_prazdniki["43"] = array("date"=>"21-11-".date("Y"), "comment"=>"", "name"=>"День работника налоговых органов РФ");
$vse_prazdniki["44"] = array("date"=>date('d-m-Y', strtotime('last sun of nov')), "comment"=>"последнее воскресенье ноября", "name"=>"День Матери");
$vse_prazdniki["45"] = array("date"=>"03-12-".date("Y"), "comment"=>"", "name"=>"День Юриста");
$vse_prazdniki["46"] = array("date"=>"12-12-".date("Y"), "comment"=>"", "name"=>"День Конституции РФ");
$vse_prazdniki["47"] = array("date"=>date('d-m-Y', strtotime('third sun of dec')), "comment"=>"третье воскресенье декабря", "name"=>"День энергетика");
$vse_prazdniki["48"] = array("date"=>"20-12-".date("Y"), "comment"=>"", "name"=>"День работников органов безопасности");

/////////////////////////////////////////
?>

<!DOCTYPE html>
<html lang="ru">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <link rel="icon" href="/favicon.ico" type="image/x-icon">
   <link rel="SHORTCUT ICON" href="/favicon.ico" type="image/x-icon">
   <link rel="stylesheet" type="text/css" href="styles.css">
   <link rel="stylesheet" type="text/css" href="jquery.datepick.css">
   
   <title>Корпоративный органайзер поздравлений</title>
   <script type="text/javascript" src="jquery.js"></script>
   <script type="text/javascript" src="jquery.datepick.js"></script>
   <script type="text/javascript" src="jquery.datepick-ru.js"></script>
   <script type="text/javascript" src="scripts.js"></script>
   
   <script type="text/javascript" src="jquery.mousewheel.js"></script>
	<script type="text/javascript" src="jquery.fancybox.js"></script>
	<link rel="stylesheet" type="text/css" href="jquery.fancybox.css" media="screen" />
                                        
    <!--[if lte IE 8]> 
       <link rel="stylesheet" type="text/css" href="styles-ie.css">
   <![endif]-->
  
</head>
<body>
    <div id="confirmDeleteWindow">
    </div>
    <div id="main">
        <div id="container">
	 <div id="calendar1" class="calendar"></div>
		  <div id="closeCalendar1" class="closeCalendar"></div>
   		  <div id="calendar2" class="calendar"></div>
		  <div id="closeCalendar2" class="closeCalendar"></div>
           <div id="header">   
           </div>
            <div id="pageContent">	        
		  <?php
		  if(isset($_SESSION['userid']) && isset($_SESSION['username'])) {
		     echo'
		     <div id="loginLinkDiv">
		     <nobr>
		     <span id="yourLogin">Вы вошли как <b><i>'.$_SESSION['info'].'</i></b>
		     &nbsp;&nbsp;&nbsp;
		     <a id="logout" href="#" style="color:rgb(100,100,100);text-decoration:underline;">Выход</a></span>
		     </nobr>';
		  }
		  else {
		     echo'<div id="loginLinkDiv" style="left:818px;">
		     <a id="loginLink" href="#">Вход в личный кабинет</a>';
		  }
		  ?>
		</div>
		<div id="loginDiv">
		    Логин:<br>
	        	<input id="loginField" type="text" style="padding-left:5px;width:145px;border:1px solid rgb(150,150,150);"><br><br>
		    Пароль:<br>
		    <input id="passField" type="password" style="padding-left:5px;width:145px; border:1px solid rgb(150,150,150);"><br><br>
	            <input id="loginButton" type="button" value="Войти">&nbsp;&nbsp;&nbsp;&nbsp;
     	            <input id="cancelLogin" type="button" value="Отмена"><br><br>
		     <span id="loginResult"></span>

		</div>
	       <div id="today">
	       <marquee scrollamount="2">
	       <b>
	       <?php
	        $today=date('d-m-Y');
	  
		if(strtotime($today) > strtotime('20-12-'.date("Y"))){
		  echo 'Ближайший праздник: Новый год (1 января)';
		}
		else{
		  foreach ($vse_prazdniki as $num => $info)
		  {
			     if( strtotime($info["date"]) == strtotime($today)){
				echo 'Сегодня '.$info['name'];
				 break;
			     }
			     else {
				if( strtotime($info["date"]) > strtotime($today)){
				       echo 'Ближайший праздник: '.$info['name'].' ('.$info['date'].')';
				      break;
				}
			     }
			     
		  }
		}
	       ?>
	       </b>
	       </marquee>
	       </div>
               <div id="menu">
		   <?php
                    if(isset($_GET['menuitem'])){
		        if(isset($_SESSION['userid'])){
			   if($_GET['menuitem'] == 1 && !$hideMenu1){
				 echo'<span class="menuitem0 opened">Поздравления<br>c Днем Рождения</span>';
				 echo'<ul class="menuitem0 visibleMenu">';
				 
			   }
			   else{
				 echo'<span class="menuitem0">Поздравления<br>c Днем Рождения</span>';			   
				 echo'<ul class="menuitem0">';
			   }
			
		     
		    ?>
                  
                   
		  Выберите диапазон дат:<br><br>
		   <form action="index.php" method="get">
		      От <input name="startdate" id="dateField1" type="text" size="10" class="dateField"
		      <?php
		      if(isset($_GET['startdate'])){
			    echo 'value="'.$_GET['startdate'];
		      } else {
			    echo 'value="'.date('d-m-Y');
		      }
		      ?>
		      ">
		      <img id="calendarButton1" alt="Popup" src="images/calendar.gif"><br><br>
		      До
		      <input name="enddate" id="dateField2" type="text" size="10" class="dateField"
		      <?php
		      if(isset($_GET['enddate'])){
			    echo 'value="'.$_GET['enddate'];
		      } else {
			    echo 'value="'.date('d-m-Y', time() + (7 * 24 * 60 * 60));
		      }
		      ?>
		      ">
		      <img id="calendarButton2" alt="Popup" src="images/calendar.gif"><br><br>
		       
		       <input type="radio"	 								   
				checked="on" name="pozdr" value="all">Все поздравления<br><br>
		      <input type="radio"
			       <?php if (isset($_GET['pozdr']) && $_GET['pozdr']=='my')
					echo' checked="on" ';
			       ?>
			       name="pozdr" value="my">Мои поздравления<br><br>							 
		       <input type="hidden" name="menuitem" value="1">
		       <input type="hidden" name="sort" value="<?=$_GET['sort']?>">
		      
		      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Показать">
                  </form>
   
                  </ul>
                  <br><br>
		  <?php
		  if($_GET['menuitem'] == 8 || $_GET['menuitem'] == 9){
			echo'<span class="menuitem8 opened">Поздравления<br>c общими праздниками</span>';
			echo'<ul class="menuitem8 visibleMenu">';
						   
		  }
		  else{
			echo'<span class="menuitem8">Поздравления<br>c общими праздниками</span>';			   
			echo'<ul class="menuitem8">';
		  }
					  
				       
		  ?>
				    	     
		  <li><a href="index.php?menuitem=8">Все поздравления</a></li>
		  <li><a href="index.php?menuitem=9">Мои поздравления</a></li>
   
                  </ul>
                  <br><br>
		  <?php
			}
		    }
                    if(isset($_GET['menuitem'])){
			      echo'<span  onclick="location.href=\'index.php?menuitem=2\';" class="menuitem1 noSubitems">Государственные, профессиональные и праздники компании</span><br><br>';
			      echo'<ul class="menuitem1">';
		     }
		    ?>
                                                                                         
                  </ul>  
		  <?php
                    if(isset($_GET['menuitem'])){
			      echo'<span  onclick="location.href=\'index.php?menuitem=3\';"  class="menuitem2  noSubitems">Макеты открыток</span><br><br>';			   
			      echo'<ul class="menuitem2">';
		     }
		    ?>							                                       
		     
                  </ul>
		  <?php
                    if(isset($_GET['menuitem'])){
			      echo'<span  onclick="location.href=\'index.php?menuitem=4\';"  class="menuitem4  noSubitems">Нормативные документы</span><br><br>';			   
			      echo'<ul class="menuitem4">';
		     }
		    ?>						     
                                   
                  </ul>
		  <?php
			if(isset($_SESSION['username'])){
			    if($_SESSION['access_type']=='superuser'){
			        echo'<br><br><p style="color:rgb(27,68,88);font-size:15px;">Администрирование:</p>
				<span  onclick="location.href=\'index.php?menuitem=5\';"  class="menuitem5  noSubitems">Управление пользователями</span><br><br>';			   
				echo'<ul class="menuitem5"> </ul>';
			        echo'<span  onclick="location.href=\'index.php?menuitem=6\';"  class="menuitem6  noSubitems">Редактирование списка поздравляемых</span><br><br>';			   
				echo'<ul class="menuitem6"> </ul>';
			    }elseif($_SESSION['access_type']=='priority_user'){
			        echo'<span  onclick="location.href=\'index.php?menuitem=6\';"  class="menuitem6  noSubitems">Редактирование списка поздравляемых</span><br><br>';			   
				echo'<ul class="menuitem6"> </ul>';
			    }
			      echo'<span  onclick="location.href=\'index.php?menuitem=12\';">Изменить свой пароль</span><br><br>';			   
                        }
		  ?>
		  
               </div>
                <div id="gallery">
                   <?php
                    if(isset($_GET['menuitem'])){
		     	if($_GET['menuitem']==1 && isset($_SESSION['username'])){
			     if($_GET['pozdr']=='all'){
				if(strtotime($_GET['startdate']) > strtotime($_GET['enddate'])){
				    $temp = $_GET['startdate'];
				    $_GET['startdate'] = $_GET['enddate'];
				    $_GET['enddate'] = $temp;
				}
				$isDifferentYears=false;
				$startYear=(int)substr($_GET['startdate'],strlen($_GET['startdate'])-4,4);
				$endYear=(int)substr($_GET['enddate'],strlen($_GET['enddate'])-4,4);
				if($endYear > $startYear){
				  $isDifferentYears=true;
				}
			        echo'<span id="title">Список всех поздравлений<br>';
				
				if(isset($_GET['startdate']) && isset($_GET['enddate']))
				    echo 'за период с '.$_GET['startdate'].' по '.$_GET['enddate'];
				
				echo'</span><br><br>';
				?>
				  <img src="images/search.png" style="z-index:20;position:relative;top:7px;">
			  
				<input id="searchSotrFio3" name="searchSotrFio" type="text" value="Введите фамилию" style="position:relative;left:-7px;width:150px;z-index:15;
				border:1px solid rgb(100,100,100);padding-left:6px;" class="greyText">
				   <input id="searchSotr3" type="submit" value="Найти" style="position:relative;left:-5px;width:65px;">
				   
				<br><br>
				
				<?php
			        if(!isset($_GET['searchSotrFio'])){?>			      
				  <span style="position:absolute;top:90px;left:380px;">Сортировать по:&nbsp;&nbsp;
				  <a href="index.php?startdate=<?=$_GET['startdate']?>&enddate=<?=$_GET['enddate']?>&pozdr=all&menuitem=1&sort=fio" class="sortByFIO" style="color:rgb(27,68,88);text-decoration:underline;">ФИО</a>&nbsp;&nbsp;&nbsp;&nbsp;
				  <a href="index.php?startdate=<?=$_GET['startdate']?>&enddate=<?=$_GET['enddate']?>&pozdr=all&menuitem=1&sort=date" class="sortByDate" style="color:rgb(27,68,88);text-decoration:underline;">Дате рождения</a></span>
			       
				<?php
				if($isDifferentYears){
				  $query = 'SELECT count(*) as total FROM pozdravleniya.sotrudniki
				  WHERE (TO_DATE(TO_CHAR(birthday, \'DD-MM\'), \'DD-MM\') BETWEEN TO_DATE(\''.$_GET['startdate'].'\', \'DD-MM\') AND TO_DATE(\'31-12\', \'DD-MM\'))
				  or (TO_DATE(TO_CHAR(birthday, \'DD-MM\'), \'DD-MM\') BETWEEN TO_DATE(\'01-01\', \'DD-MM\') AND TO_DATE(\''.$_GET['enddate'].'\', \'DD-MM\'))';
				}
				else{
				  $query = 'SELECT count(*) as total FROM pozdravleniya.sotrudniki
				  WHERE TO_DATE(TO_CHAR(birthday, \'DD-MM\'), \'DD-MM\') BETWEEN TO_DATE(\''.$_GET['startdate'].'\', \'DD-MM\') AND TO_DATE(\''.$_GET['enddate'].'\', \'DD-MM\')';
				}
				$result = odbc_exec($dbconn, $query);
				
			        while($rec = odbc_fetch_array($result)){
				    $total = $rec['total'];
				    if($total=='0'){
				       echo'<b>Список поздравлений пуст.</b><br><br><br><br><br><br><br><br><br><br>';
				    }
				    else{				      
					        $pagesText = '<span style="float:right;">';
						if($_GET[page]!=0){
						   $pagesText .= '<a style="color:rgb(27,68,88);font-weight:bold;" href="http://'.$_SERVER['HTTP_HOST'].str_replace('&page='.$_GET['page'], '', $_SERVER['REQUEST_URI']).'&page='.($_GET['page']-1).'">&lt;&lt; Пред.</a>&nbsp;&nbsp;&nbsp;';
						}
						$pagesText .= '<i>Страница
						<input class="newPage" type="text" style="
						border:1px solid #000;width:20px;height:17px;padding-top:2px;text-align:center;" 
						value="'.($_GET['page']+1).'">&nbsp;<input class="goToPage" type="button" value="Перейти"
						data-maxpages="'.ceil($rec['total']/20).'" data-url="http://'.$_SERVER['HTTP_HOST'].str_replace('&page='.$_GET['page'], '', $_SERVER['REQUEST_URI']).'">
						
						из '.ceil($rec['total']/20).'</i>';
						if($_GET[page] < ceil($rec['total']/20)-1){
						   $pagesText .= '&nbsp;&nbsp;&nbsp;<a style="color:rgb(27,68,88);font-weight:bold;" href="http://'.$_SERVER['HTTP_HOST'].str_replace('&page='.$_GET['page'], '', $_SERVER['REQUEST_URI']).'&page='.($_GET['page']+1).'">След. &gt;&gt;</a>';
						}
						$pagesText .='</span><br><br><br>';
					        echo $pagesText;				    
				    }
				}
                                odbc_free_result($result);
				if($isDifferentYears){
				  if($_GET['sort']=='fio'){
				  $query = 'SELECT to_char(birthday ,\'MM-DD\')as birth_for_order, to_char(birthday ,\'DD-MM-YYYY\') as birth,id,fio,doljnost,telephone,adres,prazd_gosud_i_kompanii,prof_prazdniki FROM pozdravleniya.sotrudniki			      
				  WHERE (TO_DATE(TO_CHAR(birthday, \'DD-MM\'), \'DD-MM\') BETWEEN TO_DATE(\''.$_GET['startdate'].'\', \'DD-MM\') AND TO_DATE(\'31-12\', \'DD-MM\'))
				  or (TO_DATE(TO_CHAR(birthday, \'DD-MM\'), \'DD-MM\') BETWEEN TO_DATE(\'01-01\', \'DD-MM\') AND TO_DATE(\''.$_GET['enddate'].'\', \'DD-MM\'))
				  order by fio limit 20 offset '.$_GET['page']*20;
				  }
				  elseif($_GET['sort']=='date'){
				    $query = 'SELECT to_char(birthday ,\'MM-DD\')as birth_for_order, to_char(birthday ,\'DD-MM-YYYY\') as birth,id,fio,doljnost,telephone,adres,prazd_gosud_i_kompanii,prof_prazdniki FROM pozdravleniya.sotrudniki			      
				    WHERE (TO_DATE(TO_CHAR(birthday, \'DD-MM\'), \'DD-MM\') BETWEEN TO_DATE(\''.$_GET['startdate'].'\', \'DD-MM\') AND TO_DATE(\'31-12\', \'DD-MM\'))
				    or (TO_DATE(TO_CHAR(birthday, \'DD-MM\'), \'DD-MM\') BETWEEN TO_DATE(\'01-01\', \'DD-MM\') AND TO_DATE(\''.$_GET['enddate'].'\', \'DD-MM\'))
				    order by birth_for_order,fio limit 20 offset '.$_GET['page']*20;
				  }
				}
				else{
				  if($_GET['sort']=='fio'){
				  $query = 'SELECT to_char(birthday ,\'MM-DD\')as birth_for_order, to_char(birthday ,\'DD-MM-YYYY\') as birth,id,fio,doljnost,telephone,adres,prazd_gosud_i_kompanii,prof_prazdniki FROM pozdravleniya.sotrudniki			      
				  WHERE TO_DATE(TO_CHAR(birthday, \'DD-MM\'), \'DD-MM\') BETWEEN TO_DATE(\''.$_GET['startdate'].'\', \'DD-MM\') AND TO_DATE(\''.$_GET['enddate'].'\', \'DD-MM\')
				  order by fio limit 20 offset '.$_GET['page']*20;
				  }
				  elseif($_GET['sort']=='date'){
				    $query = 'SELECT to_char(birthday ,\'MM-DD\')as birth_for_order, to_char(birthday ,\'DD-MM-YYYY\') as birth,id,fio,doljnost,telephone,adres,prazd_gosud_i_kompanii,prof_prazdniki FROM pozdravleniya.sotrudniki			      
				    WHERE TO_DATE(TO_CHAR(birthday, \'DD-MM\'), \'DD-MM\') BETWEEN TO_DATE(\''.$_GET['startdate'].'\', \'DD-MM\') AND TO_DATE(\''.$_GET['enddate'].'\', \'DD-MM\')
				    order by birth_for_order,fio limit 20 offset '.$_GET['page']*20;
				  }
				}
				
			      }
			      else{
				  if($isDifferentYears){
				    $query = 'SELECT to_char(birthday ,\'DD-MM-YYYY\') as birth,id,fio,doljnost,telephone,adres,prazd_gosud_i_kompanii,prof_prazdniki FROM pozdravleniya.sotrudniki
				    WHERE ((TO_DATE(TO_CHAR(birthday, \'DD-MM\'), \'DD-MM\') BETWEEN TO_DATE(\''.$_GET['startdate'].'\', \'DD-MM\') AND TO_DATE(\'31-12\', \'DD-MM\'))
				    or (TO_DATE(TO_CHAR(birthday, \'DD-MM\'), \'DD-MM\') BETWEEN TO_DATE(\'01-01\', \'DD-MM\') AND TO_DATE(\''.$_GET['enddate'].'\', \'DD-MM\')))
				    and substring(lower(fio) from lower(\''.$_GET['searchSotrFio'].'\')) is not null';				    
				  }
				  else{
				     $query = 'SELECT to_char(birthday ,\'DD-MM-YYYY\') as birth,id,fio,doljnost,telephone,adres,prazd_gosud_i_kompanii,prof_prazdniki FROM pozdravleniya.sotrudniki
				    WHERE TO_DATE(TO_CHAR(birthday, \'DD-MM\'), \'DD-MM\') BETWEEN TO_DATE(\''.$_GET['startdate'].'\', \'DD-MM\') AND TO_DATE(\''.$_GET['enddate'].'\', \'DD-MM\')
				    and substring(lower(fio) from lower(\''.$_GET['searchSotrFio'].'\')) is not null';
				  }
				   
				  }
				  
				   $result = odbc_exec($dbconn, $query);
					  if (odbc_fetch_array($result)=="") {
					     echo'<br><br><i>Поздравлений не найдено!</i><br><br><br><br>';
					  }
					  else{
					      $result = odbc_exec($dbconn, $query);
				      
					      $query2 = 'select id_sotrudnika from pozdravleniya.moi_pozdravleniya where userid='.$_SESSION['userid'];
					      $result2 = odbc_exec($dbconn, $query2);
					      
					      echo'
					      <table class="tbl" cellspacing="0" cellpadding="0" style="border:1px solid rgb(27,68,88);width:650px;table-layout:fixed;">
					      <tr>
					      <td style="border:1px solid rgb(27,68,88);overflow:hidden;width:80px;"><b>ФИО</b></td>
					      <td style="border:1px solid rgb(27,68,88);overflow:hidden;width:120px;"><b>Должность</b></td>
					      <td style="border:1px solid rgb(27,68,88);overflow:hidden;width:80px;"><b>Дата Рождения</b></td>
					      <td style="border:1px solid rgb(27,68,88);overflow:hidden;width:120px;"><b>Адрес, телефон</b></td>
					      <td style="border:1px solid rgb(27,68,88);overflow:hidden;width:20px;"></td>
					      </tr>';
					      while($rec = odbc_fetch_array($result)){
						     
						 echo '<tr>
						 <td style="border:1px solid rgb(27,68,88);overflow:hidden;">'.$rec["fio"].'</td>
						  <td style="border:1px solid rgb(27,68,88);overflow:hidden;">'.$rec["doljnost"].'</td>
						  <td style="border:1px solid rgb(27,68,88);overflow:hidden;">'.$rec["birth"].'</td>
						  <td style="border:1px solid rgb(27,68,88);overflow:hidden;">'.$rec["adres"].',<br>тел. '.$rec["telephone"].'</td>
						 ';
						 
						  $isAlreadyAdded = false;
						  
						  $result2 = odbc_exec($dbconn, $query2);
						  while($rec2 = odbc_fetch_array($result2)){
						     if($rec['id'] == $rec2['id_sotrudnika']){
							$isAlreadyAdded = true;
						     }
						  }
						  			
						  if($isAlreadyAdded){
						       echo'<td class="alreadyAdded" style="border:1px solid rgb(27,68,88);overflow:hidden;">
						       <img src="images/add.png" title="Добавить в мои поздравления"
						       class="buttonAdd" data-id="'.$rec['id'].'" style="display:none;cursor:pointer;">
						       <img src="images/delete.png" title="Удалить из моих поздравлений"
							class="buttonDel" data-id="'.$rec['id'].'"
							data-fio="'.$rec['fio'].'" style="cursor:pointer;">						       </td>
						       </tr>';
						  }
						  else{
						       echo'<td style="border:1px solid rgb(27,68,88);overflow:hidden;">
						       <img src="images/add.png" title="Добавить в мои поздравления"
						       class="buttonAdd" data-id="'.$rec['id'].'" style="cursor:pointer;">
						       <img src="images/delete.png" title="Удалить из моих поздравлений"
							class="buttonDel" data-id="'.$rec['id'].'"
							data-fio="'.$rec['fio'].'" style="display:none;cursor:pointer;">
							</td>
						       </tr>';
						     
						  }
					  
					      }
					      odbc_free_result($result);
					  
					      echo'</table><br><br>';
					      echo $pagesText;				    

				}
			     }
			     elseif($_GET['pozdr']=='my'){
				 if(strtotime($_GET['startdate']) > strtotime($_GET['enddate'])){
				    $temp = $_GET['startdate'];
				    $_GET['startdate'] = $_GET['enddate'];
				    $_GET['enddate'] = $temp;
				}
				$isDifferentYears=false;
				$startYear=(int)substr($_GET['startdate'],strlen($_GET['startdate'])-4,4);
				$endYear=(int)substr($_GET['enddate'],strlen($_GET['enddate'])-4,4);
				if($endYear > $startYear){
				    $isDifferentYears=true;
				}
			        echo'<span id="title">Список моих поздравлений<br>за период с '.$_GET['startdate'].' по '.$_GET['enddate'].'</span><br><br>';
				?>
				    <img src="images/search.png" style="z-index:20;
				 position:relative;top:7px;">
			     
				 <input id="searchSotrFio4" name="searchSotrFio" type="text" value="Введите фамилию" style="position:relative;left:-7px;width:150px;z-index:15;
				 border:1px solid rgb(100,100,100);padding-left:6px;" class="greyText">
				    <input id="searchSotr4" type="submit" value="Найти" style="position:relative;left:-5px;width:65px;">
				    
				 <br><br>
				  
				<?php
				if(!isset($_GET['searchSotrFio'])){ ?>
				  <span style="position:absolute;top:90px;left:380px;">Сортировать по:&nbsp;&nbsp;
				<a href="index.php?startdate=<?=$_GET['startdate']?>&enddate=<?=$_GET['enddate']?>&pozdr=my&menuitem=1&sort=fio" class="sortByFIO" style="color:rgb(27,68,88);text-decoration:underline;">ФИО</a>&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="index.php?startdate=<?=$_GET['startdate']?>&enddate=<?=$_GET['enddate']?>&pozdr=my&menuitem=1&sort=date" class="sortByDate" style="color:rgb(27,68,88);text-decoration:underline;">Дате рождения</a></span>
			      

				<?php
				if($isDifferentYears){
				  $query = 'SELECT count(*) as total FROM pozdravleniya.sotrudniki
				  WHERE (TO_DATE(TO_CHAR(birthday, \'DD-MM\'), \'DD-MM\') BETWEEN TO_DATE(\''.$_GET['startdate'].'\', \'DD-MM\') AND TO_DATE(\'31-12\', \'DD-MM\'))
				    or (TO_DATE(TO_CHAR(birthday, \'DD-MM\'), \'DD-MM\') BETWEEN TO_DATE(\'01-01\', \'DD-MM\') AND TO_DATE(\''.$_GET['enddate'].'\', \'DD-MM\'))
				  and
				  id in (select id_sotrudnika from pozdravleniya.moi_pozdravleniya where userid='.$_SESSION['userid'].')';  
				}
				else{
				  $query = 'SELECT count(*) as total FROM pozdravleniya.sotrudniki
				    WHERE TO_DATE(TO_CHAR(birthday, \'DD-MM\'), \'DD-MM\') BETWEEN TO_DATE(\''.$_GET['startdate'].'\', \'DD-MM\') AND TO_DATE(\''.$_GET['enddate'].'\', \'DD-MM\')
				    and
				  id in (select id_sotrudnika from pozdravleniya.moi_pozdravleniya where userid='.$_SESSION['userid'].')';
				}
				
				$result = odbc_exec($dbconn, $query);
			        while($rec = odbc_fetch_array($result)){
				    $total = $rec['total'];

				    if($total=='0'){
				       
				    }
				    else{				      
					       $pagesText = '<span style="float:right;">';
						if($_GET[page]!=0){
						   $pagesText .= '<a style="color:rgb(27,68,88);font-weight:bold;" href="http://'.$_SERVER['HTTP_HOST'].str_replace('&page='.$_GET['page'], '', $_SERVER['REQUEST_URI']).'&page='.($_GET['page']-1).'">&lt;&lt; Пред.</a>&nbsp;&nbsp;&nbsp;';
						}
						$pagesText .= '<i>Страница
						<input class="newPage" type="text" style="
						border:1px solid #000;width:20px;height:17px;padding-top:2px;text-align:center;" 
						value="'.($_GET['page']+1).'">&nbsp;<input class="goToPage" type="button" value="Перейти"
						data-maxpages="'.ceil($rec['total']/20).'" data-url="http://'.$_SERVER['HTTP_HOST'].str_replace('&page='.$_GET['page'], '', $_SERVER['REQUEST_URI']).'">
						
						из '.ceil($rec['total']/20).'</i>';
						if($_GET[page] < ceil($rec['total']/20)-1){
						   $pagesText .= '&nbsp;&nbsp;&nbsp;<a style="color:rgb(27,68,88);font-weight:bold;" href="http://'.$_SERVER['HTTP_HOST'].str_replace('&page='.$_GET['page'], '', $_SERVER['REQUEST_URI']).'&page='.($_GET['page']+1).'">След. &gt;&gt;</a>';
						}
						$pagesText .='</span><br><br><br>';
					        echo $pagesText;	
				    }
				}
                                odbc_free_result($result);
				
				if($_GET['sort']=='fio'){
				  if($isDifferentYears){
				    $query = 'SELECT to_char(birthday ,\'MM-DD\')as birth_for_order, to_char(birthday ,\'DD-MM-YYYY\') as birth,id,fio,doljnost,telephone,adres,prazd_gosud_i_kompanii,prof_prazdniki FROM pozdravleniya.sotrudniki
				    WHERE (TO_DATE(TO_CHAR(birthday, \'DD-MM\'), \'DD-MM\') BETWEEN TO_DATE(\''.$_GET['startdate'].'\', \'DD-MM\') AND TO_DATE(\'31-12\', \'DD-MM\'))
				    or (TO_DATE(TO_CHAR(birthday, \'DD-MM\'), \'DD-MM\') BETWEEN TO_DATE(\'01-01\', \'DD-MM\') AND TO_DATE(\''.$_GET['enddate'].'\', \'DD-MM\'))
				    and
				    id in (select id_sotrudnika from pozdravleniya.moi_pozdravleniya where userid='.$_SESSION['userid'].')
				    order by fio limit 20 offset '.$_GET['page']*20;
				  }
				  else{
				    $query = 'SELECT to_char(birthday ,\'MM-DD\')as birth_for_order, to_char(birthday ,\'DD-MM-YYYY\') as birth,id,fio,doljnost,telephone,adres,prazd_gosud_i_kompanii,prof_prazdniki FROM pozdravleniya.sotrudniki
				    WHERE TO_DATE(TO_CHAR(birthday, \'DD-MM\'), \'DD-MM\') BETWEEN TO_DATE(\''.$_GET['startdate'].'\', \'DD-MM\') AND TO_DATE(\''.$_GET['enddate'].'\', \'DD-MM\')
				    and
				    id in (select id_sotrudnika from pozdravleniya.moi_pozdravleniya where userid='.$_SESSION['userid'].')
				    order by fio limit 20 offset '.$_GET['page']*20;
				  }
				  
				   
				
				}
				elseif($_GET['sort']=='date'){
				   if($isDifferentYears){
				    $query = 'SELECT to_char(birthday ,\'MM-DD\')as birth_for_order, to_char(birthday ,\'DD-MM-YYYY\') as birth,id,fio,doljnost,telephone,adres,prazd_gosud_i_kompanii,prof_prazdniki FROM pozdravleniya.sotrudniki
				    WHERE (TO_DATE(TO_CHAR(birthday, \'DD-MM\'), \'DD-MM\') BETWEEN TO_DATE(\''.$_GET['startdate'].'\', \'DD-MM\') AND TO_DATE(\'31-12\', \'DD-MM\'))
				    or (TO_DATE(TO_CHAR(birthday, \'DD-MM\'), \'DD-MM\') BETWEEN TO_DATE(\'01-01\', \'DD-MM\') AND TO_DATE(\''.$_GET['enddate'].'\', \'DD-MM\'))
				    and
				    id in (select id_sotrudnika from pozdravleniya.moi_pozdravleniya where userid='.$_SESSION['userid'].')
				    order by birth_for_order,fio limit 20 offset '.$_GET['page']*20;
				  }
				  else{
				    $query = 'SELECT to_char(birthday ,\'MM-DD\')as birth_for_order, to_char(birthday ,\'DD-MM-YYYY\') as birth,id,fio,doljnost,telephone,adres,prazd_gosud_i_kompanii,prof_prazdniki FROM pozdravleniya.sotrudniki
				    WHERE TO_DATE(TO_CHAR(birthday, \'DD-MM\'), \'DD-MM\') BETWEEN TO_DATE(\''.$_GET['startdate'].'\', \'DD-MM\') AND TO_DATE(\''.$_GET['enddate'].'\', \'DD-MM\')
				    and
				    id in (select id_sotrudnika from pozdravleniya.moi_pozdravleniya where userid='.$_SESSION['userid'].')
				    order by birth_for_order,fio limit 20 offset '.$_GET['page']*20;
				  }
				   
				    
				}
				}
				else{
				  if($isDifferentYears){
				     $query = 'SELECT to_char(birthday ,\'DD-MM-YYYY\') as birth,id,fio,doljnost,telephone,adres,prazd_gosud_i_kompanii,prof_prazdniki FROM pozdravleniya.sotrudniki
				    WHERE ((TO_DATE(TO_CHAR(birthday, \'DD-MM\'), \'DD-MM\') BETWEEN TO_DATE(\''.$_GET['startdate'].'\', \'DD-MM\') AND TO_DATE(\'31-12\', \'DD-MM\'))
				    or (TO_DATE(TO_CHAR(birthday, \'DD-MM\'), \'DD-MM\') BETWEEN TO_DATE(\'01-01\', \'DD-MM\') AND TO_DATE(\''.$_GET['enddate'].'\', \'DD-MM\')))
				    and
				    id in (select id_sotrudnika from pozdravleniya.moi_pozdravleniya where userid='.$_SESSION['userid'].')
				    and substring(lower(fio) from lower(\''.$_GET['searchSotrFio'].'\')) is not null';
				  }
				  else{
				     $query = 'SELECT to_char(birthday ,\'DD-MM-YYYY\') as birth,id,fio,doljnost,telephone,adres,prazd_gosud_i_kompanii,prof_prazdniki FROM pozdravleniya.sotrudniki
				    WHERE TO_DATE(TO_CHAR(birthday, \'DD-MM\'), \'DD-MM\') BETWEEN TO_DATE(\''.$_GET['startdate'].'\', \'DD-MM\') AND TO_DATE(\''.$_GET['enddate'].'\', \'DD-MM\')
				    and
				    id in (select id_sotrudnika from pozdravleniya.moi_pozdravleniya where userid='.$_SESSION['userid'].')
				    and substring(lower(fio) from lower(\''.$_GET['searchSotrFio'].'\')) is not null';
				  }
				   
				  }
				
				 $result = odbc_exec($dbconn, $query);
					  if (odbc_fetch_array($result)=="") {
					     echo'<br><br><i>Поздравлений не найдено!</i><br><br><br><br>';
					  }
					  else{
					     $result = odbc_exec($dbconn, $query);
                            
				     echo'
				<table class="tbl" cellspacing="0" cellpadding="0" style="border:1px solid rgb(27,68,88);width:650px;table-layout:fixed;">
			        <tr>
				<td style="border:1px solid rgb(27,68,88);overflow:hidden;width:80px;"><b>ФИО</b></td>
				<td style="border:1px solid rgb(27,68,88);overflow:hidden;width:120px;"><b>Должность</b></td>
				<td style="border:1px solid rgb(27,68,88);overflow:hidden;width:80px;"><b>Дата Рождения</b></td>
				<td style="border:1px solid rgb(27,68,88);overflow:hidden;width:120px;"><b>Адрес, телефон</b></td>
				<td style="border:1px solid rgb(27,68,88);overflow:hidden;width:20px;"></td>
				</tr>';
                                while($rec = odbc_fetch_array($result)){
 				   echo '<tr>
				   <td style="border:1px solid rgb(27,68,88);overflow:hidden;">'.$rec["fio"].'</td>
				    <td style="border:1px solid rgb(27,68,88);overflow:hidden;">'.$rec["doljnost"].'</td>
				    <td style="border:1px solid rgb(27,68,88);overflow:hidden;">'.$rec["birth"].'</td>
				    <td style="border:1px solid rgb(27,68,88);overflow:hidden;">'.$rec["adres"].',<br>тел. '.$rec["telephone"].'</td>
				   ';

				       echo'<td style="border:1px solid rgb(27,68,88);overflow:hidden;">
				       <img src="images/delete.png" title="Удалить из моих поздравлений"
				       class="buttonDelete" data-id="'.$rec['id'].'"
				       data-fio="'.$rec['fio'].'" 
				       style="cursor:pointer;">
				       </td></tr>';
                            
                                }
                                odbc_free_result($result);
                            
                                echo'</table><br><br>';
				  echo $pagesText;	

				}
			     }

			    
			}
			elseif($_GET['menuitem']==2){
                            echo'<span id="title">Список государственных праздников и праздников компании</span><br><br><center><table  cellspacing="0" style="border:1px solid rgb(27,68,88);"><tr><td style="border:1px solid rgb(27,68,88);padding:5px;"><b>Дата</b></td><td style="border:1px solid rgb(27,68,88);padding:5px;"><b>Название</b></td><td style="border:1px solid rgb(27,68,88);padding:5px;"><b>Примечание </b></td></tr>';
			    
			    foreach ($prazdniki1 as $num => $info)
			      {
				   echo  '<tr><td style="border:1px solid rgb(27,68,88);padding:5px;">'.$info["date"].'</td><td style="border:1px solid rgb(27,68,88);padding:5px;width:350px;">'.$info["name"].'</td><td style="border:1px solid rgb(27,68,88);padding:5px;">'.$info["comment"].'</td></tr>';
			      }
			    
			    echo'</table></center><br><br><span id="title">Список профессиональных праздников </span><br><br><center><table cellspacing="0" style="border:1px solid rgb(27,68,88);"><tr><td style="border:1px solid rgb(27,68,88);padding:5px;"><b>Дата</b></td><td style="border:1px solid rgb(27,68,88);padding:5px;"><b>Название</b></td><td style="border:1px solid rgb(27,68,88);padding:5px;"><b>Примечание </b></td></tr>';
			    
			      foreach ($prazdniki2 as $num => $info)
			      {
				   echo  '<tr><td style="border:1px solid rgb(27,68,88);padding:5px;">'.$info["date"].'</td><td style="border:1px solid rgb(27,68,88);padding:5px;width:350px;">'.$info["name"].'</td><td style="border:1px solid rgb(27,68,88);padding:5px;">'.$info["comment"].'</td></tr>';
			      }
			      
			      echo'</table></center><br><br><br><br>';
			}
                        elseif($_GET['menuitem']==3){?>
                            <span id="title">Макеты открыток</span><br><br>							
			      <center>
				<table>
				  <tr>
				     <td><a rel="gallery1" class="imagegallery" href="images/maket101.jpg">
					  <img class="thumb" src="images/maket101_thumb.jpg"></a>
				    <br><br><a href="download.php?file=pdf/Otkrytka_210x210_1.pdf">Скачать открытку</a>				    
				    </td>
				      <td><a rel="gallery1" class="imagegallery" href="images/maket102.jpg">
					  <img class="thumb" src="images/maket102_thumb.jpg"></a>
				    <br><br><a href="download.php?file=pdf/Otkrytka_210x210_2.pdf">Скачать открытку</a>

				    </td>
				   </tr>
				  <tr>
				     <td><a rel="gallery1" class="imagegallery" href="images/maket103.jpg">
					  <img class="thumb" src="images/maket103_thumb.jpg"></a>
				    <br><br><a href="download.php?file=pdf/Otkrytka_210x210_3.pdf">Скачать открытку</a>				    
				    </td>
				      <td><a rel="gallery1" class="imagegallery" href="images/maket104.jpg">
					  <img class="thumb" src="images/maket104_thumb.jpg"></a>
				    <br><br><a href="download.php?file=pdf/Otkrytka_210x210_4.pdf">Скачать открытку</a>

				    </td>
				   </tr>				  
				<tr>
				     <td><a rel="gallery1" class="imagegallery" href="images/maket28.jpg">
					  <img class="thumb" src="images/maket28_thumb.jpg"></a>
				    <br><br><a href="download.php?file=images/maket28.jpg">Скачать открытку</a>				    
				    </td>
				    
				   </tr>
				<tr>
				     <td><a rel="gallery1" class="imagegallery" href="images/maket27.jpg">
					  <img class="thumb" src="images/maket27_thumb.jpg"></a>
				    <br><br><a href="download.php?file=images/maket27.jpg">Скачать открытку</a>				    
				    </td>
				      <td><a rel="gallery1" class="imagegallery" href="images/maket26.jpg">
					  <img class="thumb" src="images/maket26_thumb.jpg"></a>
				    <br><br><a href="download.php?file=images/maket26.jpg">Скачать открытку</a>

				    </td>
				   </tr>
				<tr>
				     <td><a rel="gallery1" class="imagegallery" href="images/maket24.jpg">
					  <img class="thumb" src="images/maket24_thumb.jpg"></a>
				    <br><br><a href="download.php?file=images/maket24.jpg">Скачать открытку</a>				    
				    </td>
				      <td><a rel="gallery1" class="imagegallery" href="images/maket25.jpg">
					  <img class="thumb" src="images/maket25_thumb.jpg"></a>
				    <br><br><a href="download.php?file=images/maket25.jpg">Скачать открытку</a>

				    </td>
				   </tr>			   
				  <tr>
				     <td><a rel="gallery1" class="imagegallery" href="images/maket23.jpg">
					  <img class="thumb" src="images/maket23_thumb.jpg"></a>
				    <br><br><a href="download.php?file=images/maket23.jpg">Скачать открытку</a>				    
				    </td>
				      <td><a rel="gallery1" class="imagegallery" href="images/maket6.jpg">
					  <img class="thumb" src="images/maket6_thumb.jpg"></a>
				    <br><br><a href="download.php?file=images/maket6.jpg">Скачать открытку</a>

				    </td>
				   </tr>
		
				  <tr>
				     <td><a rel="gallery1" class="imagegallery" href="images/maket15.jpg">
					  <img class="thumb" src="images/maket15_thumb.jpg"></a>
				    <br><br><a href="download.php?file=images/maket15.jpg">Скачать открытку</a>				    
				    </td>
				    <td><a rel="gallery1" class="imagegallery" href="images/maket16.jpg">
					  <img class="thumb" src="images/maket16_thumb.jpg"></a>
				    <br><br><a href="download.php?file=images/maket16.jpg">Скачать открытку</a>				    
				    </td>
				 </tr>
				   <tr>
				     <td><a rel="gallery1" class="imagegallery" href="images/maket14.jpg">
					  <img class="thumb" src="images/maket14_thumb.jpg"></a>
				    <br><br><a href="download.php?file=images/maket14.jpg">Скачать открытку</a>				    
				    </td>
				    <td><a rel="gallery1" class="imagegallery" href="images/maket13.jpg">
					  <img class="thumb" src="images/maket13_thumb.jpg"></a>
				    <br><br><a href="download.php?file=images/maket13.jpg">Скачать открытку</a>				    
				    </td>
				 </tr>
				  <tr>
				    <td><a rel="gallery1" class="imagegallery" href="images/maket12.jpg">
					  <img class="thumb" src="images/maket12_thumb.jpg"></a>
				    <br><br><a href="download.php?file=images/maket12.jpg">Скачать открытку</a>				    
				    </td>
				    <td><a rel="gallery1" class="imagegallery" href="images/maket11.jpg">
					  <img class="thumb" src="images/maket11_thumb.jpg"></a>
				    <br><br><a href="download.php?file=images/maket11.jpg">Скачать открытку</a>				    
				    </td>
				 </tr>
				   <tr>
				    <td><a rel="gallery1" class="imagegallery" href="images/maket9.jpg">
					  <img class="thumb" src="images/maket9_thumb.jpg"></a>
				    <br><br><a href="download.php?file=images/maket9.jpg">Скачать открытку</a>

				    </td>
				     <td><a rel="gallery1" class="imagegallery" href="images/maket10.jpg">
					  <img class="thumb" src="images/maket10_thumb.jpg"></a>
				    <br><br><a href="download.php?file=images/maket10.jpg">Скачать открытку</a>
					  
				    </td>
				 </tr>				   				  				  				 
				  <tr>
				    <td><a rel="gallery1" class="imagegallery" href="images/maket8.jpg">
					  <img class="thumb" src="images/maket8_thumb.jpg"></a>
				    <br><br><a href="download.php?file=images/maket8.jpg">Скачать открытку</a>

				    </td>
				    <td><a rel="gallery1" class="imagegallery" href="images/maket5.jpg"> 
					  <img class="thumb" src="images/maket5_thumb.jpg"></a>
				    <br><br><a href="download.php?file=images/maket5.jpg">Скачать открытку</a>
					  
				    </td>
				 </tr>
				 <tr>
				    <td><a rel="gallery1" class="imagegallery" href="images/maket1.jpg">
					  <img class="thumb" src="images/maket1_thumb.jpg"></a>
				    <br><br><a href="download.php?file=images/maket1.jpg">Скачать открытку</a>

				    </td>
				     <td><a rel="gallery1" class="imagegallery" href="images/maket2.jpg">
					  <img class="thumb" src="images/maket2_thumb.jpg"></a>
				    <br><br><a href="download.php?file=images/maket2.jpg">Скачать открытку</a>
					  
				    </td>
				 </tr>
				  <tr>
				    <td><a rel="gallery1" class="imagegallery" href="images/maket3.jpg">
					  <img class="thumb" src="images/maket3_thumb.jpg"></a>
				    <br><br><a href="download.php?file=images/maket3.jpg">Скачать открытку</a>
					  
				    </td>
				     <td><a rel="gallery1" class="imagegallery" href="images/maket4.jpg">
					  <img class="thumb" src="images/maket4_thumb.jpg"></a>
				    <br><br><a href="download.php?file=images/maket4.jpg">Скачать открытку</a>
					  
				    </td>
				 </tr>
				 
				 </table>
				 <br><br><br><br><br><br><br><br><br><br><br>
				    <br><br><br><br><br><br><br><br><br><br><br><br><br>
			     </center>
				<?php
				}elseif($_GET['menuitem']==4){?>
                                    <span id="title">Нормативные документы</span><br><br><br><br>
				    &nbsp;&nbsp;<a class="pdfLink" href="instr.docx" target="_blank">Инструкция по работе с Органайзером поздравлений»</a><br>					      			      
				    <img src="images/pdf.png" style="border:none;padding:5px;">&nbsp;<a class="pdfLink" href="pdf/holidays.pdf" target="_blank">Календарь праздников России</a><br>
				    <img src="images/pdf.png" style="border:none;padding:5px;">&nbsp;<a class="pdfLink" href="pdf/trud_kodex_rf.pdf" target="_blank">Трудовой кодекс РФ</a><br>
				    <img src="images/pdf.png" style="border:none;padding:5px;">&nbsp;<a class="pdfLink" href="pdf/o_personalnyh_dannyh.pdf" target="_blank">Федеральный закон от 27.07.2006 N 152-Ф3 О персональных данных</a><br>
				    <img src="images/pdf.png" style="border:none;padding:5px;">&nbsp;<a class="pdfLink" href="pdf/delovaya_etika.pdf" target="_blank">Кодекс деловой этики ОАО РЖД</a><br>
				    <img src="images/pdf.png" style="border:none;padding:5px;">&nbsp;<a class="pdfLink" href="pdf/povedenie_na_ojd.pdf" target="_blank">Поведение на ОЖД (распоряжение от 28.09.2012 784р)</a><br>
																											   
                       <?php
				    }
				    elseif($_GET['menuitem']==5 && isset($_SESSION['username']) && $_SESSION['access_type']=='superuser'){?>
				    <span id="title">Управление пользователями</span><br>					 
     					<center>
				        <img id="searchImg" src="images/search.png" style="z-index:20;
					    position:relative;top:7px;">
					    <input id="searchUserFio" name="searchUserFio" type="text" value="Введите фамилию" style="position:relative;left:-7px;width:150px;z-index:15;
					    border:1px solid rgb(100,100,100);padding-left:6px;" class="greyText">
					       <input id="searchUser" type="submit" value="Найти" style="position:relative;left:-5px;width:65px;">
					     <br><br>  
					<hr>
					
					<a id="addUserLink" style="color:rgb(27,68,88);">Зарегистрировать нового пользователя</a><br><br>
					</center>	  
				       <?php
				       if(isset($_GET['added'])) { 
					  echo '<center>
					  <b class="added">Пользователь успешно добавлен.</b>
					  </center>
					  <br><br>';
				        }
					elseif(isset($_GET['changed'])) { 
					  echo '<center>
					  <b class="added">Данные о пользователе успешно изменены.</b>
					  </center>
					  <br><br>';
				        } 
					?>
					
					<form id="addUserForm" action="saveUser.php" method="post">
					   Логин:<br>
					   <input id="set_login" name="login" type="text" style="width:200px;"><br>
					   <br>Пароль:<br>
					   <input id="set_pass" name="pass" type="text" style="width:200px;"><br>
					   <br>E-Mail для уведомления:<br>
					   <input id="set_email" name="email" type="text" style="width:200px;"><br>
					   <br>Доп. информация:<br>
					   <textarea name="info" style="width:200px;height:50px;"></textarea><br>
					   <br>Права доступа:<br>
					   <select name="access_type">
					      <option selected="true" value="user">Обычный пользователь</option>
					      <option value="priority_user">Пользователь с доступом к списку поздравляемых</option>
      					      <option value="superuser">Администратор</option>
					   </select>
					 <br> <br><input id="sendEmail" name="sendEmail" type="checkbox" value="yes">Отправить уведомление на E-Mail?
						<br><br>
					   <div id="uvedoml" name="uvedoml" style="display:none;text-align:left;
					   border:1px solid rgb(27,68,88);padding:10px;position:relative;
					   left:30px;width:560px;">
					     <b>На адрес <span class="uv" id="uv_email"></span>
					     будет отправлено следующее уведомление:</b><br><br>
					    Здравствуйте!<br>
					   Вы подключены к Органайзеру поздравлений.
					    <br>
					   Ваш логин: <span class="uv" id="uv_log"></span><br> 
					   Пароль: <span  class="uv" id="uv_pass"></span><br>
					   </div>
					   <br>
					   
					   <input id="saveUser" type="submit" value="Сохранить">	
					   <br><br><br><br>		
					</form>
			      
				<?php
					if(!isset($_GET['searchUserFio'])){
						  $query = 'SELECT * FROM pozdravleniya.users order by id';
					}
					else{
						  $query = 'SELECT * FROM pozdravleniya.users			      
						      where substring(lower(info) from lower(\''.$_GET['searchUserFio'].'\')) is not null';
					}
					$result = odbc_exec($dbconn, $query);
					echo'<table  cellspacing="0" style="border:1px solid rgb(27,68,88);"><tr><td style="border:1px solid rgb(27,68,88);padding:5px;"><b>Дата регистрации</b></td><td style="border:1px solid rgb(27,68,88);padding:5px;"><b>Логин</b></td><td style="border:1px solid rgb(27,68,88);padding:5px;"><b>Пароль</b></td>
					<td style="border:1px solid rgb(27,68,88);padding:5px;"><b>Доп. информация</b></td><td style="border:1px solid rgb(27,68,88);padding:5px;"><b>Права доступа</b></td>
					<td style="border:1px solid rgb(27,68,88);padding:5px;"><b>Удалить /<br>изменить</b></td>
					</tr>';
					while($rec = odbc_fetch_array($result)){
					   echo '<tr>';
					   
					   if($rec['access_type']=='priority_user') $rec['access_type']='Доступ к списку поздравляемых';
					   elseif($rec['access_type']=='superuser') $rec['access_type']='Администратор';
					   elseif($rec['access_type']=='user') $rec['access_type']='Обычный пользователь';
					   
					   echo '<td style="border:1px solid rgb(27,68,88);padding:5px;">'.$rec["registration_date"].'</td><td style="border:1px solid rgb(27,68,88);padding:5px;">'.$rec["name"].'</td><td style="border:1px solid rgb(27,68,88);padding:5px;">'.$rec["password"].'</td><td style="border:1px solid rgb(27,68,88);padding:5px;">'.$rec["info"].'</td>
					   <td style="border:1px solid rgb(27,68,88);padding:5px;">'.$rec["access_type"].'</td>
					   <td style="border:1px solid rgb(27,68,88);padding:5px;">
					   <img src="images/delete.png" title="Удалить" class="buttonDeleteUser" data-id="'.$rec['id'].'"  data-name="'.$rec['name'].'" style="cursor:pointer;">
					   &nbsp;&nbsp;<img src="images/edit.png" title="Изменить" class="buttonEditUser" data-id="'.$rec['id'].'" style="cursor:pointer;">
					    </td></tr>';
	
				    
					}
					odbc_free_result($result);
				    
					echo'</table><br><br>';
				    ?>
				<br>																							   
			      <?php
				    }
				    elseif($_GET['menuitem']==6 && isset($_SESSION['username'])){?>
					<span id="title">Редактирование списка поздравляемых</span><br><br>
					<a href="index.php?menuitem=7&page=<?=$_GET['page']?>" style="color:rgb(27,68,88);">Добавить в список новых сотрудников</a>
					<img src="images/search.png" style="z-index:20;
					position:relative;left:150px;top:7px;">
				    
					<input id="searchSotrFio" name="searchSotrFio" type="text" value="Введите фамилию" style="position:relative;left:141px;width:150px;z-index:15;
					border:1px solid rgb(100,100,100);padding-left:6px;" class="greyText">
					   <input id="searchSotr" type="submit" value="Найти" style="position:relative;left:137px;width:65px;">
					   
					<br><br>
					
					<?php
					if(isset($_GET['onlytemp'])){
					    echo'<a href="index.php?menuitem=6" style="color:rgb(27,68,88);">&lt;&lt; Вернуться к общему списку</a>
					    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					    &nbsp;&nbsp;&nbsp;&nbsp;
					    <img src="images/Excel-icon.png" style="position:relative;top:5px;">&nbsp;
					    <a href="excelexport.php?temp" style="color:rgb(27,68,88);" target="_blank">Экспорт в Excel</a>';  
					}
					elseif(isset($_GET['only_nach_dor'])){
					    echo'<a href="index.php?menuitem=6" style="color:rgb(27,68,88);">&lt;&lt; Вернуться к общему списку</a>
					    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					    &nbsp;&nbsp;&nbsp;&nbsp;
					    <img src="images/Excel-icon.png" style="position:relative;top:5px;">&nbsp;
					    <a href="excelexport.php?nach_dor" style="color:rgb(27,68,88);" target="_blank">Экспорт в Excel</a>';  
					}
					elseif(isset($_GET['only_archive'])){
					    echo'<a href="index.php?menuitem=6" style="color:rgb(27,68,88);">&lt;&lt; Вернуться к общему списку</a>
					    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					    &nbsp;&nbsp;&nbsp;&nbsp;
					    <img src="images/Excel-icon.png" style="position:relative;top:5px;">&nbsp;
					    <a href="excelexport.php?archive" style="color:rgb(27,68,88);" target="_blank">Экспорт в Excel</a>';  
					}
					else{					 	    		    
					    echo'Показать:&nbsp;&nbsp;<a href="index.php?menuitem=6&onlytemp" style="color:rgb(27,68,88);
					    position:relative;top:6px;
					    "><img src="images/metka.png" title="Временные"></a>
					    &nbsp;&nbsp;&nbsp;
					    <a href="index.php?menuitem=6&only_nach_dor" style="color:rgb(27,68,88);
					    position:relative;top:6px;
					    "><img src="images/checkbox-icon.png" title="Поздравляемые от имени начальника Октябрьской железной дороги"></a>
					    &nbsp;&nbsp;&nbsp;
					     <a href="index.php?menuitem=6&only_archive" style="color:rgb(27,68,88);
					     position:relative;top:6px;
					    "><img src="images/recycle.png" title="Архивные"></a>'; 
					    
					}
					
					if(!isset($_GET['searchSotrFio'])){
					  if(isset($_GET['onlytemp']))
					      $query = 'SELECT count(*) as total FROM pozdravleniya.sotrudniki where vremenniy=\'yes\'';
					  elseif(isset($_GET['only_nach_dor']))
					      $query = 'SELECT count(*) as total FROM pozdravleniya.sotrudniki where pozdravl_ot_imeni_nachal_dorogi=\'yes\'';
					  elseif(isset($_GET['only_archive']))
					      $query = 'SELECT count(*) as total FROM pozdravleniya.sotrudniki where archive=\'yes\'';    
					  else
					      $query = 'SELECT count(*) as total FROM pozdravleniya.sotrudniki';
					  $result = odbc_exec($dbconn, $query);
					  while($rec = odbc_fetch_array($result)){
					      
						$pagesText = '<span style="float:right;">';
						if($_GET[page]!=0){
						   $pagesText .= '<a style="color:rgb(27,68,88);font-weight:bold;" href="http://'.$_SERVER['HTTP_HOST'].str_replace('&page='.$_GET['page'], '', $_SERVER['REQUEST_URI']).'&page='.($_GET['page']-1).'">&lt;&lt; Пред.</a>&nbsp;&nbsp;&nbsp;';
						}
						$pagesText .= '<i>Стр.
						<input class="newPage" type="text" style="
						border:1px solid #000;width:20px;height:17px;padding-top:2px;text-align:center;" 
						value="'.($_GET['page']+1).'">&nbsp;<input class="goToPage" type="button" value="Перейти"
						data-maxpages="'.ceil($rec['total']/20).'" data-url="http://'.$_SERVER['HTTP_HOST'].str_replace('&page='.$_GET['page'], '', $_SERVER['REQUEST_URI']).'">
						
						из '.ceil($rec['total']/20).'</i>';
						if($_GET[page] < ceil($rec['total']/20)-1){
						   $pagesText .= '&nbsp;&nbsp;&nbsp;<a style="color:rgb(27,68,88);font-weight:bold;" href="http://'.$_SERVER['HTTP_HOST'].str_replace('&page='.$_GET['page'], '', $_SERVER['REQUEST_URI']).'&page='.($_GET['page']+1).'">След. &gt;&gt;</a>';
						}
						$pagesText .='</span><br><br><br>';
					        echo $pagesText;
					  }
					  odbc_free_result($result);	
					
				          if(isset($_GET['onlytemp'])){
					         $query = 'SELECT to_char(birthday ,\'MM-DD\') as birth_for_order, to_char(birthday ,\'DD-MM-YYYY\') as birth,id,fio,doljnost,telephone,vremenniy,pozdravl_ot_imeni_nachal_dorogi,archive FROM pozdravleniya.sotrudniki					  
					         where vremenniy=\'yes\' order by birth_for_order, fio limit 20 offset '.$_GET['page']*20;
					  }
					   elseif(isset($_GET['only_nach_dor'])){
					         $query = 'SELECT to_char(birthday ,\'MM-DD\') as birth_for_order, to_char(birthday ,\'DD-MM-YYYY\') as birth,id,fio,doljnost,telephone,vremenniy,pozdravl_ot_imeni_nachal_dorogi,archive FROM pozdravleniya.sotrudniki					  
					         where pozdravl_ot_imeni_nachal_dorogi=\'yes\' order by birth_for_order, fio limit 20 offset '.$_GET['page']*20;
					  }
					   elseif(isset($_GET['only_archive'])){
					         $query = 'SELECT to_char(birthday ,\'MM-DD\') as birth_for_order, to_char(birthday ,\'DD-MM-YYYY\') as birth,id,fio,doljnost,telephone,vremenniy,pozdravl_ot_imeni_nachal_dorogi,archive FROM pozdravleniya.sotrudniki					  
					         where archive=\'yes\' order by birth_for_order, fio limit 20 offset '.$_GET['page']*20;
					  }
					  else{
					    	 $query = 'SELECT to_char(birthday ,\'MM-DD\') as birth_for_order, to_char(birthday ,\'DD-MM-YYYY\') as birth,id,fio,doljnost,telephone,vremenniy,pozdravl_ot_imeni_nachal_dorogi,archive FROM pozdravleniya.sotrudniki					  
					         order by birth_for_order, fio limit 20 offset '.$_GET['page']*20;
					  }
					}
					else{
					    $query = 'SELECT to_char(birthday ,\'DD-MM-YYYY\')
				            as birth,id,fio,doljnost,telephone FROM pozdravleniya.sotrudniki
					    where substring(lower(fio) from lower(\''.$_GET['searchSotrFio'].'\')) is not null';
					}
					  
					$result = odbc_exec($dbconn, $query);
					if (odbc_fetch_array($result)=="") {
					     echo'<br><br><i>Ни одного сотрудника не найдено!</i><br><br><br><br>';
					}
					else{
					     $result = odbc_exec($dbconn, $query);
					     
					     $query2 = 'select id_sotrudnika from pozdravleniya.moi_pozdravleniya where userid='.$_SESSION['userid'];
					      $result2 = odbc_exec($dbconn, $query2);
					      
					     echo'<center><table  id="sotrTable" cellspacing="0" style="border:1px solid rgb(27,68,88);"><tr><td style="border:1px solid rgb(27,68,88);padding:5px;"><b>ФИО</b></td><td style="border:1px solid rgb(27,68,88);padding:5px;"><b>Должность</b></td><td style="border:1px solid rgb(27,68,88);padding:5px;"><b>Дата Рождения</b></td>
					     <td style="border:1px solid rgb(27,68,88);padding:5px;"><b>Телефон</b></td><td style="border:1px solid rgb(27,68,88);padding:5px;"><b>Удалить / изменить</b></td></tr>';
					     while($rec = odbc_fetch_array($result)){
					        $isTemp=$rec['vremenniy'];
						$isNachDor=$rec['pozdravl_ot_imeni_nachal_dorogi'];
						$isArchive=$rec['archive'];
						
					      	echo '<tr>';
						echo '<td style="';
						if($isNachDor=='yes'){
						  echo'background:rgb(255,158,158);';
						}
						echo 'border:1px solid rgb(27,68,88);padding:5px;">'.$rec["fio"].'</td><td style="border:1px solid rgb(27,68,88);padding:5px;">'.$rec["doljnost"].'</td><td style="border:1px solid rgb(27,68,88);padding:5px;">'.$rec["birth"].'</td><td style="border:1px solid rgb(27,68,88);padding:5px;">'.$rec["telephone"].'</td>';
						
					            $isAlreadyAdded = false;
						    $result2 = odbc_exec($dbconn, $query2);
						    while($rec2 = odbc_fetch_array($result2)){
						       if($rec['id'] == $rec2['id_sotrudnika']){
							  $isAlreadyAdded = true;
						       }
						    }
						    if($isAlreadyAdded){
						       echo'<td class="alreadyAdded" style="border:1px solid rgb(27,68,88);padding:5px;"><img src="images/delete.png" title="Удалить" class="buttonDeleteFromDB" data-id="'.$rec['id'].'"  data-fio="'.$rec['fio'].'" style="cursor:pointer;">
						       &nbsp;&nbsp;<img src="images/edit.png" title="Изменить" class="buttonEdit" data-page="'.$_GET['page'].'" data-id="'.$rec['id'].'" style="cursor:pointer;">';
						       
						       if(!isset($_GET['onlytemp'])){
							   if($isTemp != 'yes')
						               echo'<br><img src="images/metka.png" title="Отметить сотрудника как временного" class="buttonSetTemp"  data-id="'.$rec['id'].'" style="cursor:pointer;">';
						       }
						       else{
							   echo'<br><img src="images/iskluch.png" title="Исключить из списка временных" class="buttonUnsetTemp"  data-id="'.$rec['id'].'" style="cursor:pointer;">';
						       }
						       
						        if(!isset($_GET['only_nach_dor'])){
							   if($isNachDor != 'yes')
						               echo'
							       &nbsp;&nbsp;<img src="images/checkbox-icon.png" title="Поздравлять от имени начальника дороги" class="buttonSetNachDor"  data-id="'.$rec['id'].'" style="cursor:pointer;">
							       ';
						       }
						       else{
							      echo'&nbsp;&nbsp;&nbsp;<img src="images/iskluch.png" title="Исключить из списка поздравляемых от имени начальника дороги" class="buttonUnsetNachDor"  data-id="'.$rec['id'].'" style="cursor:pointer;">';							   
						       }
						       
						        if(!isset($_GET['only_archive'])){
							   if($isArchive != 'yes')
						               echo'<br><img src="images/recycle.png" title="Отметить сотрудника как архивного" class="buttonSetArchive"  data-id="'.$rec['id'].'" style="cursor:pointer;"></td></tr>';
						       }
						       else{
							   echo'<br><img src="images/iskluch.png" title="Исключить из списка архивных" class="buttonUnsetArchive"  data-id="'.$rec['id'].'" style="cursor:pointer;"></td></tr>';
						       }
	     
						    }
						    else{
						       echo'<td style="border:1px solid rgb(27,68,88);padding:5px;"><img src="images/delete.png" title="Удалить" class="buttonDeleteFromDB" data-id="'.$rec['id'].'"  data-fio="'.$rec['fio'].'" style="cursor:pointer;">
						       &nbsp;&nbsp;<img src="images/edit.png" title="Изменить" class="buttonEdit"  data-page="'.$_GET['page'].'" data-id="'.$rec['id'].'" style="cursor:pointer;">';
						       
						       if(!isset($_GET['onlytemp'])){
							   if($isTemp != 'yes')
						               echo'<br><img src="images/metka.png" title="Отметить сотрудника как временного" class="buttonSetTemp"  data-id="'.$rec['id'].'" style="cursor:pointer;">';
						       }
						       else{
							   echo'<br><img src="images/iskluch.png" title="Исключить из списка временных" class="buttonUnsetTemp"  data-id="'.$rec['id'].'" style="cursor:pointer;">';
						       }
						       
						       if(!isset($_GET['only_nach_dor'])){
							   if($isNachDor != 'yes')
						               echo'
							       &nbsp;&nbsp;<img src="images/checkbox-icon.png" title="Поздравлять от имени начальника дороги" class="buttonSetNachDor"  data-id="'.$rec['id'].'" style="cursor:pointer;">
							       ';
						       }
						       else{
							      echo'&nbsp;&nbsp;&nbsp;<img src="images/iskluch.png" title="Исключить из списка поздравляемых от имени начальника дороги" class="buttonUnsetNachDor"  data-id="'.$rec['id'].'" style="cursor:pointer;">';							   
						       }
						       
						       if(!isset($_GET['only_archive'])){
							   if($isArchive != 'yes')
						               echo'<br><img src="images/recycle.png" title="Отметить сотрудника как архивного" class="buttonSetArchive"  data-id="'.$rec['id'].'" style="cursor:pointer;"></td></tr>';
						       }
						       else{
							   echo'<br><img src="images/iskluch.png" title="Исключить из списка архивных" class="buttonUnsetArchive"  data-id="'.$rec['id'].'" style="cursor:pointer;"></td></tr>';
						       }
						       
						    }						    					      					 
					     }
					     odbc_free_result($result);
					 
					     echo'</table></center><br><br>';
					     echo $pagesText;

					  }
				    ?>
				<br>
				
				 <?php
				    }
				    elseif($_GET['menuitem']==7 && isset($_SESSION['username'])){?>
				    <span id="title">Добавление нового сотрудника</span><br><br>
					   <?php
					     if(isset($_GET['added'])){
						echo '<b>Данные о новом сотруднике успешно добавлены.</b><br><br>';
					     }
					  ?>
					<a href="index.php?menuitem=6&page=<?=$_REQUEST['page']?>" style="color:rgb(27,68,88);">Вернуться к списку сотрудников</a><br><br>
					<center>
					<form id="addSotrudForm" action="saveNewSotr.php" method="post">						     
											     
					  ФИО:<br>
					  <input name="fio" id="fio" type="text" style="width:400px;"><br><br>
					  Должность:<br>
					  <input name="doljnost" type="text" style="width:400px;"><br><br>
					  Дата рождения (в формате ДД-ММ-ГГГГ):<br>
					  <input name="birthday" id="birthday" type="text" style="width:400px;"><br><br>
					  Адрес предприятия:<br>
					  <input name="adres" type="text" style="width:400px;"><br><br>
					  Телефон:<br>
					  <input name="telephone" type="text" style="width:400px;"><br><br>
					  Факс:<br>
					  <input name="fax" type="text" style="width:400px;"><br><br>
					  Ответственный за поздравления:<br>
					  <input name="otvetstven" type="text" style="width:400px;"><br><br>
					  Праздники государственные и Компании:<br>
					  <input name="prazd_gosud_i_kompanii" type="text" style="width:400px;"><br><br>
					  Профессиональные праздники:<br>
					  <input name="prof_prazdniki" type="text" style="width:400px;"><br><br>
					  Вид деятельности руководителя:<br>
					  <input name="vid_deyatelnosti" type="text" style="width:400px;"><br>	<br>
					  <input type="hidden" name="page" value="<?=$_REQUEST['page']?>">
					  </form>
     		  			  <button id="saveNewSotr">Сохранить</button>
					  <br>
				       </center>
				<br>																							   
                       <?php }
		       elseif($_GET['menuitem']==8 && isset($_SESSION['username'])){
				
			      echo'<span id="title">Список всех поздравлений с общими праздниками</span><br><br>';
			      ?>
				
			      <img src="images/search.png" style="z-index:20;position:relative;top:7px;">
			  
			      <input id="searchSotrFio2" name="searchSotrFio" type="text" value="Введите фамилию" style="position:relative;left:-7px;width:150px;z-index:15;
			      border:1px solid rgb(100,100,100);padding-left:6px;" class="greyText">
			      <input id="searchSotr2" type="submit" value="Найти" style="position:relative;left:-5px;width:65px;">
				 
				
			      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			      <input id="searchPoPrazdnName" type="text" value="По наименованию праздника" style="
			      position:relative;left:-7px;width:210px;z-index:15;
			      border:1px solid rgb(100,100,100);padding-left:6px;" class="greyText">
			      <input id="searchPoPrazdnSubm" type="submit" value="Найти" style="position:relative;left:-5px;width:65px;">
				 
				 
			      <br><br>
				    
			      <?php
			      	if(isset($_GET['searchByHoliday'])){
				$query = 'SELECT count(*) as total FROM pozdravleniya.sotrudniki			      
					    where substring(lower(prazd_gosud_i_kompanii) from lower(\''.$_GET['searchByHoliday'].'\')) is not null
					    or substring(lower(prof_prazdniki) from lower(\''.$_GET['searchByHoliday'].'\')) is not null';
					
				$result = odbc_exec($dbconn, $query);
			        while($rec = odbc_fetch_array($result)){
				    $total = $rec['total'];

				    if($total=='0'){
				    }
				    else{
				
						$pagesText = '<span style="float:right;">';
						if($_GET[page]!=0){
						   $pagesText .= '<a style="color:rgb(27,68,88);font-weight:bold;" href="http://'.$_SERVER['HTTP_HOST'].str_replace('&page='.$_GET['page'], '', $_SERVER['REQUEST_URI']).'&page='.($_GET['page']-1).'">&lt;&lt; Пред.</a>&nbsp;&nbsp;&nbsp;';
						}
						$pagesText .= '<i>Страница
						<input class="newPage" type="text" style="
						border:1px solid #000;width:20px;height:17px;padding-top:2px;text-align:center;" 
						value="'.($_GET['page']+1).'">&nbsp;<input class="goToPage" type="button" value="Перейти"
						data-maxpages="'.ceil($rec['total']/20).'" data-url="http://'.$_SERVER['HTTP_HOST'].str_replace('&page='.$_GET['page'], '', $_SERVER['REQUEST_URI']).'">			
						из '.ceil($rec['total']/20).'</i>';
						if($_GET[page] < ceil($rec['total']/20)-1){
						   $pagesText .= '&nbsp;&nbsp;&nbsp;<a style="color:rgb(27,68,88);font-weight:bold;" href="http://'.$_SERVER['HTTP_HOST'].str_replace('&page='.$_GET['page'], '', $_SERVER['REQUEST_URI']).'&page='.($_GET['page']+1).'">След. &gt;&gt;</a>';
						}
						$pagesText .='</span><br><br><br>';
					        echo $pagesText;
				    }
				}
                                odbc_free_result($result);
				
			       $query = 'SELECT id,fio,doljnost,telephone,adres,prazd_gosud_i_kompanii,prof_prazdniki
			       FROM pozdravleniya.sotrudniki
			       where substring(lower(prazd_gosud_i_kompanii) from lower(\''.$_GET['searchByHoliday'].'\')) is not null
				or substring(lower(prof_prazdniki) from lower(\''.$_GET['searchByHoliday'].'\')) is not null
				order by fio limit 20 offset '.$_GET['page']*20;
			      }
			      elseif(!isset($_GET['searchSotrFio'])){

				$query = 'SELECT count(*) as total FROM pozdravleniya.sotrudniki';
				$result = odbc_exec($dbconn, $query);
			        while($rec = odbc_fetch_array($result)){
				    $total = $rec['total'];

				    if($total=='0'){
					  echo'<b>Список поздравлений пуст.</b><br><br><br><br><br><br><br><br><br><br>';
				    }
				    else{
			
						$pagesText = '<span style="float:right;">';
						if($_GET[page]!=0){
						   $pagesText .= '<a style="color:rgb(27,68,88);font-weight:bold;" href="http://'.$_SERVER['HTTP_HOST'].str_replace('&page='.$_GET['page'], '', $_SERVER['REQUEST_URI']).'&page='.($_GET['page']-1).'">&lt;&lt; Пред.</a>&nbsp;&nbsp;&nbsp;';
						}
						$pagesText .= '<i>Страница
						<input class="newPage" type="text" style="
						border:1px solid #000;width:20px;height:17px;padding-top:2px;text-align:center;" 
						value="'.($_GET['page']+1).'">&nbsp;<input class="goToPage" type="button" value="Перейти"
						data-maxpages="'.ceil($rec['total']/20).'" data-url="http://'.$_SERVER['HTTP_HOST'].str_replace('&page='.$_GET['page'], '', $_SERVER['REQUEST_URI']).'">
						
						из '.ceil($rec['total']/20).'</i>';
						if($_GET[page] < ceil($rec['total']/20)-1){
						   $pagesText .= '&nbsp;&nbsp;&nbsp;<a style="color:rgb(27,68,88);font-weight:bold;" href="http://'.$_SERVER['HTTP_HOST'].str_replace('&page='.$_GET['page'], '', $_SERVER['REQUEST_URI']).'&page='.($_GET['page']+1).'">След. &gt;&gt;</a>';
						}
						$pagesText .='</span><br><br><br>';
					        echo $pagesText;
				    }
				}
                                odbc_free_result($result);
				
			       $query = 'SELECT id,fio,doljnost,telephone,adres,prazd_gosud_i_kompanii,prof_prazdniki FROM pozdravleniya.sotrudniki			      
				order by fio limit 20 offset '.$_GET['page']*20;
			      }
			      else{
					    $query = 'SELECT id,fio,doljnost,telephone,adres,prazd_gosud_i_kompanii,prof_prazdniki FROM pozdravleniya.sotrudniki			      
					    where substring(lower(fio) from lower(\''.$_GET['searchSotrFio'].'\')) is not null';
			      }
				
				
			      $result = odbc_exec($dbconn, $query);
					  if (odbc_fetch_array($result)=="") {
					     echo'<br><br><i>Поздравлений не найдено!</i><br><br><br><br>';
					  }
					  else{
						$result = odbc_exec($dbconn, $query);
					
						$query2 = 'select id_sotrudnika from pozdravleniya.moi_pozdravleniya where userid='.$_SESSION['userid'];
						$result2 = odbc_exec($dbconn, $query2);
						
						echo'
						<table class="tbl" cellspacing="0" cellpadding="0" style="border:1px solid rgb(27,68,88);width:650px;table-layout:fixed;">
						<tr>
						<td style="border:1px solid rgb(27,68,88);overflow:hidden;width:80px;"><b>ФИО</b></td>
						<td style="border:1px solid rgb(27,68,88);overflow:hidden;width:80px;"><b>Должность</b></td>
						<td style="border:1px solid rgb(27,68,88);overflow:hidden;width:120px;"><b>Адрес, телефон</b></td>
						<td style="border:1px solid rgb(27,68,88);overflow:hidden;width:80px;"><b>Праздники госуд. и компании</b></td>
						<td style="border:1px solid rgb(27,68,88);overflow:hidden;width:80px;"><b>Проф. праздники</b></td>
						<td style="border:1px solid rgb(27,68,88);overflow:hidden;width:20px;"></td>
						</tr>';
						while($rec = odbc_fetch_array($result)){
						    echo '<tr>
						    <td style="border:1px solid rgb(27,68,88);overflow:hidden;">'.$rec["fio"].'</td>
						     <td style="border:1px solid rgb(27,68,88);overflow:hidden;">'.$rec["doljnost"].'</td>
						     <td style="border:1px solid rgb(27,68,88);overflow:hidden;">'.$rec["adres"].',<br>тел. '.$rec["telephone"].'</td>
						     <td style="border:1px solid rgb(27,68,88);overflow:hidden;">'.$rec["prazd_gosud_i_kompanii"].'</td>
						     <td style="border:1px solid rgb(27,68,88);overflow:hidden;">'.$rec["prof_prazdniki"].'</td>
						    ';
						   
		
		
						    $isAlreadyAdded = false;
						    $result2 = odbc_exec($dbconn, $query2);
						    while($rec2 = odbc_fetch_array($result2)){
						       if($rec['id'] == $rec2['id_sotrudnika']){
							  $isAlreadyAdded = true;
						       }
						    }
						    if($isAlreadyAdded){
						       echo'<td class="alreadyAdded" style="border:1px solid rgb(27,68,88);overflow:hidden;">
						       <img src="images/add.png" title="Добавить в мои поздравления"
						       class="buttonAdd" data-id="'.$rec['id'].'" style="display:none;cursor:pointer;">
						       <img src="images/delete.png" title="Удалить из моих поздравлений"
							class="buttonDel" data-id="'.$rec['id'].'"
							data-fio="'.$rec['fio'].'" style="cursor:pointer;">						       </td>
						       </tr>';
						    }
						    else{
						       echo'<td style="border:1px solid rgb(27,68,88);overflow:hidden;">
						       <img src="images/add.png" title="Добавить в мои поздравления"
						       class="buttonAdd" data-id="'.$rec['id'].'" style="cursor:pointer;">
						       <img src="images/delete.png" title="Удалить из моих поздравлений"
							class="buttonDel" data-id="'.$rec['id'].'"
							data-fio="'.$rec['fio'].'" style="display:none;cursor:pointer;">
							</td>
						       </tr>';
						     
						    }
					    
						}
						odbc_free_result($result);
					    
						echo'</table><br><br>';
						echo $pagesText;

					  }
				
		  
                        }
			elseif($_GET['menuitem']==9 && isset($_SESSION['username'])){
			        echo'<span id="title">Список моих поздравлений с общими праздниками</span><br><br>';
				?>
				
				  <img src="images/search.png" style="z-index:20;position:relative;top:7px;">
			  
				  <input id="searchSotrFio5" name="searchSotrFio" type="text" value="Введите фамилию" style="position:relative;left:-7px;width:150px;z-index:15;
				  border:1px solid rgb(100,100,100);padding-left:6px;" class="greyText">
				  <input id="searchSotr5" type="submit" value="Найти" style="position:relative;left:-5px;width:65px;">
				 
				  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				  <input id="searchPoPrazdnName2" type="text" value="По наименованию праздника" style="
				  position:relative;left:-7px;width:210px;z-index:15;
				  border:1px solid rgb(100,100,100);padding-left:6px;" class="greyText">
				  <input id="searchPoPrazdnSubm2" type="submit" value="Найти" style="position:relative;left:-5px;width:65px;">
      			          <br><br>
				    
				  <?php
				  if(isset($_GET['searchByHoliday'])){
					  $query = 'SELECT count(*) as total FROM pozdravleniya.sotrudniki			      
					    where (substring(lower(prazd_gosud_i_kompanii) from lower(\''.$_GET['searchByHoliday'].'\')) is not null
					    or substring(lower(prof_prazdniki) from lower(\''.$_GET['searchByHoliday'].'\')) is not null)
					    and id in (select id_sotrudnika from pozdravleniya.moi_pozdravleniya where userid='.$_SESSION['userid'].')';
					
				  $result = odbc_exec($dbconn, $query);
				  while($rec = odbc_fetch_array($result)){
				      $total = $rec['total'];
    
				      if($total=='0'){
				      }
				      else{
						$pagesText = '<span style="float:right;">';
						if($_GET[page]!=0){
						   $pagesText .= '<a style="color:rgb(27,68,88);font-weight:bold;" href="http://'.$_SERVER['HTTP_HOST'].str_replace('&page='.$_GET['page'], '', $_SERVER['REQUEST_URI']).'&page='.($_GET['page']-1).'">&lt;&lt; Пред.</a>&nbsp;&nbsp;&nbsp;';
						}
						$pagesText .= '<i>Страница
						<input class="newPage" type="text" style="
						border:1px solid #000;width:20px;height:17px;padding-top:2px;text-align:center;" 
						value="'.($_GET['page']+1).'">&nbsp;<input class="goToPage" type="button" value="Перейти"
						data-maxpages="'.ceil($rec['total']/20).'" data-url="http://'.$_SERVER['HTTP_HOST'].str_replace('&page='.$_GET['page'], '', $_SERVER['REQUEST_URI']).'">
						из '.ceil($rec['total']/20).'</i>';
						if($_GET[page] < ceil($rec['total']/20)-1){
						   $pagesText .= '&nbsp;&nbsp;&nbsp;<a style="color:rgb(27,68,88);font-weight:bold;" href="http://'.$_SERVER['HTTP_HOST'].str_replace('&page='.$_GET['page'], '', $_SERVER['REQUEST_URI']).'&page='.($_GET['page']+1).'">След. &gt;&gt;</a>';
						}
						$pagesText .='</span><br><br><br>';
					        echo $pagesText;
				    }
				}
                                odbc_free_result($result);
				
				$query = 'SELECT id,fio,doljnost,telephone,adres,prazd_gosud_i_kompanii,prof_prazdniki
				FROM pozdravleniya.sotrudniki
				where (substring(lower(prazd_gosud_i_kompanii) from lower(\''.$_GET['searchByHoliday'].'\')) is not null
				 or substring(lower(prof_prazdniki) from lower(\''.$_GET['searchByHoliday'].'\')) is not null)
				 and id in (select id_sotrudnika from pozdravleniya.moi_pozdravleniya where userid='.$_SESSION['userid'].')
				 order by fio limit 20 offset '.$_GET['page']*20;
			      }
			      elseif(!isset($_GET['searchSotrFio'])){
				$query = 'SELECT count(*) as total FROM pozdravleniya.sotrudniki
				WHERE 				
				id in (select id_sotrudnika from pozdravleniya.moi_pozdravleniya where userid='.$_SESSION['userid'].')';
				$result = odbc_exec($dbconn, $query);
			        while($rec = odbc_fetch_array($result)){
				    $total = $rec['total'];

				    if($total=='0'){
					  echo'<b>Список поздравлений пуст.</b><br><br><br><br><br><br><br><br><br><br>';
				    }
				    else{
						$pagesText = '<span style="float:right;">';
						if($_GET[page]!=0){
						   $pagesText .= '<a style="color:rgb(27,68,88);font-weight:bold;" href="http://'.$_SERVER['HTTP_HOST'].str_replace('&page='.$_GET['page'], '', $_SERVER['REQUEST_URI']).'&page='.($_GET['page']-1).'">&lt;&lt; Пред.</a>&nbsp;&nbsp;&nbsp;';
						}
						$pagesText .= '<i>Страница
						<input class="newPage" type="text" style="
						border:1px solid #000;width:20px;height:17px;padding-top:2px;text-align:center;" 
						value="'.($_GET['page']+1).'">&nbsp;<input class="goToPage" type="button" value="Перейти"
						data-maxpages="'.ceil($rec['total']/20).'" data-url="http://'.$_SERVER['HTTP_HOST'].str_replace('&page='.$_GET['page'], '', $_SERVER['REQUEST_URI']).'">
						из '.ceil($rec['total']/20).'</i>';
						if($_GET[page] < ceil($rec['total']/20)-1){
						   $pagesText .= '&nbsp;&nbsp;&nbsp;<a style="color:rgb(27,68,88);font-weight:bold;" href="http://'.$_SERVER['HTTP_HOST'].str_replace('&page='.$_GET['page'], '', $_SERVER['REQUEST_URI']).'&page='.($_GET['page']+1).'">След. &gt;&gt;</a>';
						}
						$pagesText .='</span><br><br><br>';
					        echo $pagesText;
				    }
				}
                                odbc_free_result($result);
				$query = 'SELECT to_char(birthday ,\'MM-DD\')as birth_for_order, id,fio,doljnost,telephone,adres,prazd_gosud_i_kompanii,prof_prazdniki FROM pozdravleniya.sotrudniki
				WHERE 				
				id in (select id_sotrudnika from pozdravleniya.moi_pozdravleniya where userid='.$_SESSION['userid'].')
				order by fio limit 20 offset '.$_GET['page']*20;
			    }
			    else{
				$query = 'SELECT id,fio,doljnost,telephone,adres,prazd_gosud_i_kompanii,prof_prazdniki FROM pozdravleniya.sotrudniki
				WHERE 				
				id in (select id_sotrudnika from pozdravleniya.moi_pozdravleniya where userid='.$_SESSION['userid'].')
				and substring(lower(fio) from lower(\''.$_GET['searchSotrFio'].'\')) is not null';
			    }
			      	      
			    $result = odbc_exec($dbconn, $query);
			    if (odbc_fetch_array($result)=="") {
				echo'<br><br><i>Поздравлений не найдено!</i><br><br><br><br>';
			    }
			    else{     
				$result = odbc_exec($dbconn, $query);
				echo'
				<table class="tbl" cellspacing="0" cellpadding="0" style="border:1px solid rgb(27,68,88);width:650px;table-layout:fixed;">
			        <tr>
				<td style="border:1px solid rgb(27,68,88);overflow:hidden;width:80px;"><b>ФИО</b></td>
				<td style="border:1px solid rgb(27,68,88);overflow:hidden;width:80px;"><b>Должность</b></td>
				<td style="border:1px solid rgb(27,68,88);overflow:hidden;width:80px;"><b>Адрес, телефон</b></td>
				<td style="border:1px solid rgb(27,68,88);overflow:hidden;width:120px;"><b>Праздники госуд. и компании</b></td>
				<td style="border:1px solid rgb(27,68,88);overflow:hidden;width:80px;"><b>Проф. праздники</b></td>
				<td style="border:1px solid rgb(27,68,88);overflow:hidden;width:20px;"></td>
				</tr>';
                                while($rec = odbc_fetch_array($result)){
 				    echo '<tr>
				    <td style="border:1px solid rgb(27,68,88);overflow:hidden;">'.$rec["fio"].'</td>
				    <td style="border:1px solid rgb(27,68,88);overflow:hidden;">'.$rec["doljnost"].'</td>
				    <td style="border:1px solid rgb(27,68,88);overflow:hidden;">'.$rec["adres"].',<br>тел. '.$rec["telephone"].'</td>
				    <td style="border:1px solid rgb(27,68,88);overflow:hidden;">'.$rec["prazd_gosud_i_kompanii"].'</td>
				    <td style="border:1px solid rgb(27,68,88);overflow:hidden;">'.$rec["prof_prazdniki"].'</td>
				    <td style="border:1px solid rgb(27,68,88);overflow:hidden;">
				    <img src="images/delete.png" title="Удалить из моих поздравлений"
				    class="buttonDelete" data-id="'.$rec['id'].'"
				    data-fio="'.$rec['fio'].'" style="cursor:pointer;">
				    </td></tr>';
                            
                                }
                                odbc_free_result($result);
                                echo'</table><br><br>';
				echo $pagesText;
			    }
                        }
			elseif($_GET['menuitem']==10 && isset($_SESSION['username'])){?>
			   <span id="title">Изменение данных сотрудника</span><br><br>
			   <?php
			      if(isset($_GET['changed'])){
				 echo '<b>Данные о сотруднике успешно изменены.</b><br><br>';
			      }
			   ?>
			      <a href="index.php?menuitem=6&page=<?=$_REQUEST['page']?>" style="color:rgb(27,68,88);">Вернуться к списку сотрудников</a><br><br>
			      <?php
			      $query = 'SELECT to_char(birthday ,\'DD-MM-YYYY\') as birth, *
					FROM pozdravleniya.sotrudniki
					WHERE id='.$_GET['id'];
			      $result = odbc_exec($dbconn, $query);
	                      while($rec = odbc_fetch_array($result)){
			      ?>												     												     
					<center>
					<form id="changeSotrudForm" action="saveChangedSotr.php" method="post">
					  ФИО:<br>
					  <input id="fio" name="fio" type="text" style="width:400px;" value='<?=$rec['fio']?>'><br><br>
					  Должность:<br>
					  <input name="doljnost" type="text" style="width:400px;" value='<?=$rec['doljnost']?>'><br><br>
					  Дата рождения (в формате ДД-ММ-ГГГГ):<br>
					  <input id="birthday" name="birthday" type="text" style="width:400px;" value='<?=$rec['birth']?>'><br><br>
					  Адрес предприятия:<br>
					  <input name="adres" type="text" style="width:400px;" value='<?=$rec['adres']?>'><br><br>
					  Телефон:<br>
					  <input name="telephone" type="text" style="width:400px;" value='<?=$rec['telephone']?>'><br><br>
					  Факс:<br>
					  <input name="fax" type="text" style="width:400px;" value='<?=$rec['fax']?>'><br><br>
					  Ответственный за поздравления:<br>
					  <input name="otvetstven" type="text" style="width:400px;" value='<?=$rec['otvetstven']?>'><br><br>
					  Праздники государственные и Компании:<br>
					  <input name="prazd_gosud_i_kompanii" type="text" style="width:400px;" value='<?=$rec['prazd_gosud_i_kompanii']?>'><br><br>
					  Профессиональные праздники:<br>
					  <input name="prof_prazdniki" type="text" style="width:400px;" value='<?=$rec['prof_prazdniki']?>'><br><br>
					  Вид деятельности руководителя:<br>
					  <input name="vid_deyatelnosti" type="text" style="width:400px;" value='<?=$rec['vid_deyatelnosti']?>'><br>	<br>
					  <input type="hidden" name="idSotr" value="<?=$_GET['id']?>">
				          <input type="hidden" name="page" value="<?=$_REQUEST['page']?>">
					  </form>
					  <button id="saveChangedSotr">Сохранить</button>
					  <br>
				       </center>
				<br>	
			<?php
			       }
                            odbc_free_result($result);
			}
			elseif($_GET['menuitem']==11 && isset($_SESSION['username'])&& $_SESSION['access_type']=='superuser'){
			    $query = 'select * from pozdravleniya.users where id=\''.$_GET['id'].'\'';
			    $result = odbc_exec($dbconn, $query);
                            while($rec = odbc_fetch_array($result)){
			  ?>
				      <span id="title">Редактировать данные пользователя</span><br>
     					<center>
					<form id="modifyUserForm" action="saveModifiedUser.php" method="post">
					   <br>Логин:<br>
					   <input   id="set_login" value="<?=$rec['name']?>"  name="login" type="text" style="width:300px;"><br>
					   <br>Пароль:<br>
					   <input id="set_pass" value="<?=$rec['password']?>"  name="pass" type="text" style="width:300px;"><br>
					   <br>E-Mail:<br>
					   <input  id="set_email" value="<?=$rec['email']?>" id="set_email" name="email" type="text" style="width:300px;"><br>
					   <br>Доп. информация:<br>
					   <textarea name="info" style="width:300px;height:50px;"><?=$rec['info']?></textarea><br>
					   <br>Права доступа:<br>
					   <select name="access_type">
					    <?php
					      if($rec['access_type']=='user')
					         echo'<option selected="true" value="user">Обычный пользователь</option>
					         <option value="priority_user">Пользователь с доступом к списку поздравляемых</option>
						 <option value="superuser">Администратор</option>';
					      elseif($rec['access_type']=='priority_user')
					         echo'<option value="user">Обычный пользователь</option>
					         <option  selected="true" value="priority_user">Пользователь с доступом к списку поздравляемых</option>
						 <option value="superuser">Администратор</option>';
					      elseif($rec['access_type']=='superuser')
					         echo'<option selected="true" value="user">Обычный пользователь</option>
					         <option value="priority_user">Пользователь с доступом к списку поздравляемых</option>
						 <option  selected="true" value="superuser">Администратор</option>';
					    ?>
					   </select>
					    <br> <br><input id="sendEmail" name="sendEmail" type="checkbox" value="yes">Отправить уведомление на E-Mail?
						<br><br>
					   <div id="uvedoml" name="uvedoml" style="display:none;text-align:left;
					   border:1px solid rgb(27,68,88);padding:10px;position:relative;
					   left:30px;width:560px;">
					     <b>На адрес <span class="uv" id="uv_email"></span>
					     будет отправлено следующее уведомление:</b><br><br>
					     Здравствуйте!<br>
					     Вы подключены к Органайзеру поздравлений</span>
					     <br>
					      Ваш логин: <span class="uv" id="uv_log"></span><br> 
					      Пароль: <span  class="uv" id="uv_pass"></span><br>
					      </div>
					      <input type="hidden" name="id" value="<?=$_GET['id']?>">
										  <br><br>
					   <input id="saveUser" type="submit" value="Сохранить">
					  &nbsp;&nbsp;
					  <input type="button" value="Отмена" onclick="history.go(-1);">	
					</form>					
					</center>
					<br><br><br><br><br><br><br><br><br><br><br><br>
			<?php
			   }
			}
			
			elseif($_GET['menuitem']==12 && isset($_SESSION['username'])){
			    $query = 'select * from pozdravleniya.users where id=\''.$_SESSION['userid'].'\'';
			    $result = odbc_exec($dbconn, $query);
                            while($rec = odbc_fetch_array($result)){
			            echo'<span id="title">Изменить пароль</span><br>';	
				    if(isset($_GET['changed'])) { 
					  echo '<center>
					  <b>Ваш пароль успешно изменен.</b>
					  </center>
					  <br><br>';
				        }
					?>
					
     					<center>
					<form id="changePassForm" action="changePass.php" method="post">
					   <br>Ваш текущий пароль:
					   <?=$rec['password']?><br><br>
					  <br>Введите новый пароль:<br>
					   <input id="new_pass"  name="new_pass" type="text" style="width:300px;"><br>																	      
					   <input type="hidden" name="id" value="<?=$_SESSION['userid']?>">
										  <br><br>
					   <input type="submit" value="Сохранить">
					  &nbsp;&nbsp;
					  <input type="button" value="Отмена" onclick="history.go(-1);">	
					</form>					
					</center>
					<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
					<br><br><br><br><br><br><br><br><br>								      
			<?php }
			}
			elseif($_GET['menuitem']==0){                      
          echo '<br><br><center><img class="thumb" src="images/mainpage.png" ></center>
             <br><br>';

       }    
   }
   ?>
</div>
</div>
</div>
</div>
</body>
</html>

<?php  
    odbc_close($dbconn);
?>
