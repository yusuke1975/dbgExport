<?php

/* *** for Debug function *** */
function dbgDisp($val=null, $title=null, $dispCnt = TRUE){
	echo dbgSet($val, $title, $dispCnt);
}

function dbgSet($val=null, $title=null, $dispCnt = TRUE){
	
	
	
	$tmpStr = "<hr />";
	$tmpStr .= "****************************<br />";
	$tmpStr .= "****** debug infomation ******<br />";
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

			if($cntAry > $dispCnt && !is_null($dispCnt)){
				break;
			}

			if(isset($tmpAry['file']) && isset($tmpAry['line'])){
				$tmpStr .= "[".substr("0".$cntAry, -2)."] LINE:[".substr("000".$tmpAry['line'], -4)."]".$tmpAry['file']."<br />";
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
