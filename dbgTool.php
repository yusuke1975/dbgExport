<?php

/* *** for Debug function *** */
function dbgDisp($val=null, $title=null, $dispCnt = TRUE){
	echo dbgSet($val, $title, $dispCnt);
}

function dbgSet($val=null, $title=null, $dispCnt = TRUE){
	
$date = new DateTime();
$time = microtime();
$time_list = explode(' ',$time);
$time_micro = explode('.',$time_list[0]);
$date_str = $date->format('Y-m-d H:i:s:u').substr($time_micro[1],0,3);
if(!defined('STIMESTAMP')){
	define('STIMESTAMP', $date_str);
}

	$tmpStr = "<hr />";
	$tmpStr .= "****************************<br />";
	$tmpStr .= "****** debug infomation [".STIMESTAMP."]******<br />";
	$tmpStr .= "****************************<br /><br />";
	
	$traceCnt = count(debug_backtrace());
	
	$tmpStr .= "---- back trace RecentCount[".$traceCnt."]-----<br />";
	
	$cntAry = 0;
	
	if($dispCnt)
	{
		if($dispCnt == TRUE){
			$dispCnt = $traceCnt;
		}
				
		foreach(array_reverse(debug_backtrace()) as $tmpAry){
	//		$tmpStr .= print_r($tmpAry, 1);

			if($cntAry > $dispCnt && !is_null($dispCnt)){
				break;
			}

			if(isset($tmpAry['file']) && isset($tmpAry['line'])){
				$tmpStr .= "[".substr("0".$cntAry, -2)."] LINE:[".substr("000".$tmpAry['line'], -4)."]". $tmpAry['file']."<br />";
			}else{
				$tmpStr .= "[".substr("0".$cntAry, -2)."]"."unknown file...<br />";
				if(isset($tmpAry['class'])){
					$tmpStr .= " => CLASS: [".$tmpAry['class']."]<br />";
				}
				if(isset($tmpAry['function'])){
					$tmpStr .= " => FUNCTION: [".$tmpAry['function']."]<br />";
				}
			}
			$cntAry++;
		}
	}

	$tmpStr .= "<br />------------- dump ".$title."-------------<br />";

	if(!is_null($val)){
		if(!is_null($title)){
			$title = "[ ".$title." ]";
		}
		$tmpStr .= "<pre>";
		$tmpStr .= print_r($val, 1);
		$tmpStr .= "</pre>";
	}
	$tmpStr .= "<hr />";
	
	return $tmpStr;
}

function dbgLog($val=null, $title=null, $dispCnt = TRUE){
	$fp = fopen('/tmp/_log/app'.date("Ymd").'.log', 'a+');
	fwrite($fp,  "----------- ".date("Y-m-d H:i:s")." ---------"."\n");
	fwrite($fp,  str_replace('<hr />',"\n"."------------------------". "\n",str_replace('<br />',"\n",dbgSet($val, $title, $dispCnt))));
	fclose($fp);
	
}

function dbgDump($val=null, $title=null, $dispCnt = TRUE){
	echo  "----------- ".date("Y-m-d H:i:s")." ---------"."\n";
	echo str_replace('<hr />',"\n"."------------------------". "\n",str_replace('<br />',"\n",dbgSet($val, $title, $dispCnt)));
}


function dbgTextarea($val=null, $title=null, $dispCnt = TRUE, $rows = 10, $cols = 50){
	echo "<textarea rows='10' cols='50>'";
	echo dbgDump($val, $title, $dispCnt);
	echo "</textarea>";
	echo "<hr />";
}
