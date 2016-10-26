<?php
	/*@author gaochao
	create at 2016.10.25*/

	
	//header("Content-Type: text/html;charset=utf-8"); 
	// error_reporting(E_ALL ^ E_DEPRECATED);
	// echo "hehe";exit;
	$link=mysql_connect('121.42.136.52','one','redhatredhat') or die("无法连接到数据库");//连接到数据库
	$db_exist=mysql_select_db('ca');
	// $select="select * from ca";
	// $result=mysql_query($select);
	// echo $result;exit;
	// if(!$db_exist)
	// {
	// 	$create_d="create database zerto";
	// 	mysql_query($create_d);
	// 	mysql_select_db('zerto');
	// 	$create_t="create table users
	// 	(id int not null auto_increment,
	// 	 PRIMARY KEY(id),
	// 	 name varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
	// 	 email varchar(32) not null,
	// 	 company varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
	// 	 company_type varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
	// 	 phone char(11),
	// 	 job_title varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
	// 	 province varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
	// 	 infrastructure varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci
	// 	 )";
	// 	mysql_query($create_t);
	// }
	//获取post的数据
	$name = $_POST['name'];
	$email = $_POST['email'];
	$company = $_POST['company'];
	// $company_type = $_POST['company'];
	$phone = $_POST['phone'];
	$job = $_POST['job'];
	// $province = $_POST['province'];
	// $infrastructure = $_POST['infrastructure'];
	$question1=$_POST['question1'];
	$question2=$_POST['question2'];
	$question3_1=$_POST['question3_1'];
	$question3_2=$_POST['question3_2'];
	$question3_3=$_POST['question3_3'];
	$question3_4=$_POST['question3_4'];
	$question3_5=$_POST['question3_5'];
	$question3_6=$_POST['question3_6'];
	$question3_7=$_POST['question3_7'];
	// $question3_1=$_POST['question3_1'];
	$question4=$_POST['question4'];
	$question5=$_POST['question5'];
	$question6=$_POST['question6'];
	$question7=$_POST['question7'];
	if($question1=='' || $question2=='' || $question3_1=='' || $question3_2=='' || $question3_3=='' || $question3_4=='' || $question3_5=='' || $question3_6=='' || $question3_7=='' || $question4=='' || $question5=='' || $question6=='' || $question7=='')
	{
		echo json_encode(array('status'=>'error','msg'=>'please fill the form completely'));
		exit;
	}

	//验证
	if(trim($name) && trim($email) && trim($company) && trim($phone) && trim($job) && trim($question1) && trim($question2) && trim($question3_1) && trim($question3_2) && trim($question3_3) && trim($question3_4) && trim($question3_5) && trim($question3_6) && trim($question3_7) && trim($question4) && trim($question5) && trim($question6) && trim($question7)){
		if(!preg_match("/^1[34578]{1}\d{9}$/",$phone)){  
		    echo json_encode(array('status'=>'error','msg'=>'your format of phone is wrong'));
		    exit;
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){  
		    echo json_encode(array('status'=>'error','msg'=>'your format of email is wrong"'));  
		    exit;
		}
	}else{
		echo json_encode(array('status'=>'error','msg'=>'please fill the form completely'));
		exit;
	}
	//检查手机号、邮箱是否存在
	$has_phone = mysql_query("select * from ca where phone='$phone'");
	if(mysql_num_rows($has_phone)){
		echo json_encode(array('status'=>'error','msg'=>'the phone number is registered'));
		exit;
	}
	$has_email = mysql_query("select * from ca where email='$email'");
	if(mysql_num_rows($has_email)){
		echo json_encode(array('status'=>'error','msg'=>'the emailbox is registered'));
		exit;
	}
	//存入数据库
	mysql_query('set names utf8;'); 

	$insert = "insert into ca(id,name,company,job,phone,email,question1,question2,question3_1,question3_2,question3_3,question3_4,question3_5,question3_6,question3_7,question4,question5,question6,question7) values(NULL,'$name','$company','$job','$phone','$email','$question1','$question2','$question3_1','$question3_2','$question3_3','$question3_4','$question3_5','$question3_6','$question3_7','$question4','$question5','$question6','$question7')";
echo $insert;
	mysql_query($insert);

	if(mysql_affected_rows()<=0){
		echo json_encode(array('status'=>'error','msg'=>'add data errorly'));
		exit;
	}
	mysql_close($link);
	echo json_encode(array("status"=>"success","msg"=>"add data successfully"));
?>