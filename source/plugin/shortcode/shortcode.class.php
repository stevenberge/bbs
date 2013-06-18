<?php
/**
 *      本程序由 缑城依然 开发
 *      若要二次开发或用于商业用途的，需要经过 缑城依然 同意。
 *      版权：宁海百姓网http://www.nhbxw.com
 *      2012-01-01
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class plugin_shortcode{
        var $identifier = 'shortcode';
	var $config=array();
	function  plugin_shortcode() {
		global $_G;
		$this->config = $_G['cache']['plugin']['shortcode'];
		$fids=(array)unserialize($this->config['fids']);
		$fids=empty($fids) || in_array('',$fids) ? array() : $fids;
		$this->config['fids']=$fids;
	}
        function global_cpnav_extra2(){
                global $_G;
		$pic = $_G['cache']['plugin']['shortcode']['pic'];
                include template('shortcode:insert');
                return $return;
	}
}
class plugin_shortcode_forum extends plugin_shortcode{
	function viewthread_bottom_output(){
		global $_G,$postlist;
		if(!in_array($_G['fid'],$this->config['fids']) || empty($_G['forum_thread']['attachment'])) return '';
		$search = "/\<a href\=\"forum\.php\?mod=attachment([^\"]+)\"/i";
		$replace = "<a onclick=\"javascript: showWindow('attach','plugin.php?id=shortcode&action=attach\\1');return false;\" href=\"#\"";
		foreach($postlist as $pid => $post) {
			$postlist[$pid]['message'] = preg_replace($search, $replace, $post['message']);
			$postlist[$pid]['attachlist'] = preg_replace($search, $replace, $post['attachlist']);
		}
	}
}
class plugin_shortcode_portal extends plugin_shortcode{
	function view_shortcode_output(){
		global $content;
		$search = "/\<a href\=\"forum\.php\?mod=attachment([^\"]+)\"/i";
		$replace = "<a onclick=\"javascript: showWindow('attach','plugin.php?id=shortcode&action=attach\\1');return false;\" href=\"#\"";
		$content['content'] = preg_replace($search, $replace, $content['content']);
	}
}
?>


