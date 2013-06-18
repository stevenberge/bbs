<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: forum.php 29133 2012-03-27 08:04:24Z liulanbo $
 */

define('APPTYPEID', 2);
define('CURSCRIPT', 'forum');
//echo "<hr>forum.php<br/>";

require './source/class/class_core.php';
require './source/function/function_forum.php';
//////////添加mod需要修改这里
$modarray = array('ajax','announcement','attachment','forumdisplay',
		'group','image','index','medal','misc','modcp','notice','post','redirect','followthread','unfollowthread',
		'followforum','unfollowforum','relatekw','relatethread','rss','topicadmin','trade','viewthread','tag','collection','guide'
		);

$modcachelist = array(
		'index'		=> array('announcements', 'onlinelist', 'forumlinks',
			'heats', 'historyposts', 'onlinerecord', 'userstats', 'diytemplatenameforum'),
		'forumdisplay'	=> array('smilies', 'announcements_forum', 'globalstick', 'forums',
			'onlinelist', 'forumstick', 'threadtable_info', 'threadtableids', 'stamps', 'diytemplatenameforum'),
		'viewthread'	=> array('smilies', 'smileytypes', 'forums', 'usergroups',
			'stamps', 'bbcodes', 'smilies',	'custominfo', 'groupicon', 'stamps',
			'threadtableids', 'threadtable_info', 'posttable_info', 'diytemplatenameforum'),
		'redirect'	=> array('threadtableids', 'threadtable_info', 'posttable_info'),
		'post'		=> array('bbcodes_display', 'bbcodes', 'smileycodes', 'smilies', 'smileytypes',
			'domainwhitelist', 'albumcategory'),
		'space'		=> array('fields_required', 'fields_optional', 'custominfo'),
		'group'		=> array('grouptype', 'diytemplatenamegroup'),
		);
$mod = !in_array(C::app()->var['mod'], $modarray) ? 'index' : C::app()->var['mod'];
//echo "mod:".$mod."<br/>";

define('CURMODULE', $mod);
$cachelist = array();
if(isset($modcachelist[CURMODULE])) {
	$cachelist = $modcachelist[CURMODULE];
}
if(C::app()->var['mod'] == 'group') {
	$_G['basescript'] = 'group';
}
C::app()->cachelist = $cachelist;
C::app()->init();
$_G['member']['accessmasks']=1;
loadforum();

/////对于有效用户
if($_G['member']['uid']!=0){
	//////跟随主题
	if($mod=='followthread'&&isset($_G['tid'])){
		C::t('forum_threadfollower')->followthread($_G['tid'],$_G['member']['uid'],$_G['member']['username']);
	}else if($mod=='unfollowthread'&&isset($_G['tid'])){
		C::t('forum_threadfollower')->unfollowthread($_G['tid'],$_G['member']['uid']);
	}
	//////收听版面
	else if($mod=='followforum'&&isset($_G['fid'])){
		C::t('forum_rss')->followforum($_G['member']['uid'],$_G['fid']);
	}
	else if($mod=='unfollowforum'&&isset($_G['fid'])){
		C::t('forum_rss')->unfollowforum($_G['member']['uid'],$_G['fid']);
	}
}
if(in_array($mod,array('followthread','unfollowthread'))) $mod='viewthread';
if(in_array($mod,array('followforum','unfollowforum'))) $mod='index';

//echo "forum:";			print_r($_G['forum']);
//echo "<br/>member:";print_r($_G['member']);
set_rssauth();
runhooks();

$navtitle = str_replace('{bbname}', $_G['setting']['bbname'], $_G['setting']['seotitle']['forum']);
require DISCUZ_ROOT.'./source/module/forum/forum_'.$mod.'.php';
//echo "out of forum.php</hr>";
?>
