<?php
function detect(){
		$browsers = array ("IE","OPERA","MOZILLA","NETSCAPE","FIREFOX","SAFARI");
		$oses = array ("WIN","MAC","LINUX");
		$output['browser'] = "OTHER";
		$output['os'] = "OTHER";
		
	foreach( $browsers as $browser ){
		$s = strpos( strtoupper($_SERVER['HTTP_USER_AGENT']), $browser );
		$f = $s + strlen($browser);
		$version = substr($_SERVER['HTTP_USER_AGENT'], $f, 5);
		$version = preg_replace('/[^0-9,.]/','',$version);
		if( $s ){
			$output['browser'] = $browser;
			$output['version'] = $version;
		}
	}
    foreach( $oses as $os ){
		if( eregi($os,strtoupper($_SERVER['HTTP_USER_AGENT'])) ) $output['os'] = $os;
	}
	return $output;
}
?>
