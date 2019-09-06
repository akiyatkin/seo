<?php
use infrajs\load\Load;
use infrajs\ans\Ans;
use infrajs\config\Config;
use infrajs\template\Template;
use infrajs\controller\Crumb;
use infrajs\event\Event;
use infrajs\layer\seojson\Seojson;


$path = Ans::GET('path','string','');
$path = '/'.$path;

$conf = Config::get('seo');
$data = Load::loadJSON('-excel/get/group/SEO/?src='.$conf['src']);
$list = [];

$is = false;
Event::handler('Controller.oninit', function () use(&$is){
	$is = true;
});
if (!$is) Crumb::change($path);
$crumb = Crumb::getInstance();
$layer = array('crumb' => $crumb);

if (!empty($data['data']['data'])) {
	foreach ($data['data']['data'] as $item) {
		if (empty($item['Адрес'])) continue;
		$adr = Template::parse([$item['Адрес']], $layer);		
		//if (isset($list[$adr])) continue;
		$list[$adr] = $item;
		if ($conf['common']) $list[$adr]['external'] = $conf['common'];
		//unset($list[$adr]['Адрес']);
	}
}

if (isset($list[$path])) {

	$item = $list[$path];
	if (!empty($item['jsontpl'])) {
		$item['json'] = Template::parse([$item['jsontpl']], $layer);
	}

	if (!empty($item['json'])) {
		$item['data'] = Load::loadJSON($item['json']);
		if (empty($item['dataroot'])) $item['dataroot'] = null;
		foreach(['description','keywords','title','image_src'] as $prop) {
			if (empty($item[$prop])) continue;
			$item[$prop] = Template::parse([$item[$prop]], $item['data'], null, $item['dataroot']);	
		}
		if (!empty($item['image_src'])) $item['image_src'] = Seojson::getSite().'/'.$item['image_src'];
	}
	//echo '<pre>';
	//print_r($item);
	//exit;
	return Ans::ans($item);
	
	

	
} else {
	if (!isset($list['/'])) {
		$list['/'] = array('auto' => true);
		if ($conf['common']) $list['/']['external'] = $conf['common'];
	}
	return Ans::ans($list['/']);
}

