<?php
use infrajs\load\Load;
use infrajs\ans\Ans;
use infrajs\rest\Rest;

echo $val;
	exit;
return Rest::get(function($val){
	
	$val = '/'.$val;

	$data = Load::loadJSON('-excel/get/group/SEO/?src=~pages/Параметры.xlsx');
	$list = [];
	foreach ($data['data']['data'] as $v) {
		if(empty($v['Адрес'])) continue;
		$list[$v['Адрес']] = $v;
		$list[$v['Адрес']]['external'] = '~pages/page.json';
		unset($list[$v['Адрес']]['Адрес']);
	}

	if (isset($list[$val])) {
		return Ans::ans($list[$val]);
	} else {
		return Ans::ans($list['/']);
	}
})

