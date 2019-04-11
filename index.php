<?php
use infrajs\load\Load;
use infrajs\ans\Ans;
use infrajs\config\Config;


$path = Ans::GET('path','string','');
$path = '/'.$path;

$conf = Config::get('seo');
$data = Load::loadJSON('-excel/get/group/SEO/?src='.$conf['src']);
$list = [];
if ($data) {
	foreach ($data['data']['data'] as $v) {
		if(empty($v['Адрес'])) continue;
		$list[$v['Адрес']] = $v;
		$list[$v['Адрес']]['external'] = $conf['common'];
		unset($list[$v['Адрес']]['Адрес']);
	}
}

if (isset($list[$path])) {
	return Ans::ans($list[$path]);
} else {
	if (!isset($list['/'])) {
		$list['/'] = array('external' => $conf['common']);
	}
	return Ans::ans($list['/']);
}

