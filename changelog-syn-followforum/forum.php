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
	'followforum','unfollowforum','unfollowallforum','relatekw','relatethread','rss','topicadmin','trade','viewthread','tag','collection','guide'
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
//if(!PDB::$connected){ 
//	echo "<hr>PDB::disconnected<hr>";
//}
//C::t('push_forum_forum')->test();//->update($fid, array('fup' => '0', 'type' => 'forum'));

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

function update_rss_remote($username,$password,$str_forums){
  $r=request_remote('user.do','followforums',array('bbs-password'=>"i_am_bbs",'username'=>$username,'password'=>$password,'forums'=>$str_forums));
  //echo "update_rss_remote:".$r."<hr>";
  try{
	$r=json_decode($r);
	if(empty($r)) return false;
	if($r->state=='success') return true;
	else return false;
  }
  catch(exception $e){
	return false;
  }
}
function fetch_rss_remote($username,$password,$str_forums){
  $r=request_remote('user.do','forumsfollowed',array('bbs-password'=>"i_am_bbs",'username'=>$username,'password'=>$password));
  //echo "update_rss_remote:".$r."<hr>";
  try{
	$r=json_decode($r);
	if(empty($r)) return 'false';
	if($r->state=='success') return $r->info;
	else return 'false';
  }
  catch(exception $e){
	return 'false';
  }
}
function unfollow_forum_remote($uid,$uname,$pwd,$fid){
  $bbscategory=C::t('forum_forum')->fetch_pushsection_by_fid($fid);
  if(empty($bbscategory)) return false;
//  $forums=C::t('forum_rss')->fetch_forums($uid);
  $str_forums="";
  $old_forums=fetch_rss_remote($uname,$pwd);
  if($old_forums=="false") return false;
  $forumarr=explode(";",$old_forums);
  $first=1;
  foreach($forumarr as $forum){
	//////////////////////
	if($forum=='null'||$forum=='') continue;
	if($forum!=$bbscategory) {
	  if(!$first) {$str_forums.=";".$forum;}
	  else {$str_forums.=$forum;$first=0;}
	}
  }
  return (update_rss_remote($uname,$pwd,$str_forums));
}
function unfollow_all_forum_remote($uid,$uname,$pwd){
  return update_rss_remote($uname,$pwd,"");
}
function follow_forum_remote($uid,$uname,$pwd,$fid){
  $bbscategory=C::t('forum_forum')->fetch_pushsection_by_fid($fid);
  if(empty($bbscategory)) return false;
//  $forums=C::t('forum_rss')->fetch_forums($uid);
  $str_forums="";
  $old_forums=fetch_rss_remote($uname,$pwd);
  if($old_forums=="false") return false;
  $forumarr=explode(";",$old_forums);
  $str_forums.=$bbscategory;
  foreach($forumarr as $forum){
	if($forum=='null'||$forum=='') continue;
	if($forum!=$bbscategory) $str_forums.=";".$forum;
  }
  //echo "follow_forum_remote:forums:$str_forums<br/>";
  return update_rss_remote($uname,$pwd,$str_forums);
}
/////对于有效用户
if($_G['member']['uid']!=0){
  //////跟随主题
  if($mod=='followthread'&&isset($_G['tid'])){
	//echo "followthread...";
	C::t('forum_threadfollower')->follow_thread($_G['tid'],$_G['member']['uid'],$_G['member']['username']);
  }else if($mod=='unfollowthread'&&isset($_G['tid'])){
	C::t('forum_threadfollower')->unfollow_thread($_G['tid'],$_G['member']['uid']);
  }
  //////收听版面
  else if($mod=='followforum'&&isset($_G['fid'])){
	if(follow_forum_remote($_G['member']['uid'],$_G['member']['username'],$_G['member']['password'],$_G['fid']))
	  C::t('forum_rss')->follow_forum($_G['member']['uid'],$_G['fid']);
  }
  else if($mod=='unfollowforum'&&isset($_G['fid'])){
	if(unfollow_forum_remote($_G['member']['uid'],$_G['member']['username'],$_G['member']['password'],$_G['fid']))
	  C::t('forum_rss')->unfollow_forum($_G['member']['uid'],$_G['fid']);
  }
  else if($mod=='unfollowallforum'){
	if(unfollow_all_forum_remote($_G['member']['uid'],$_G['member']['username'],$_G['member']['password'],$_G['fid']))
	  C::t('forum_rss')->unfollow_forum($_G['member']['uid']);
  }else {
	//	echo "login:<br/>";
	//	print_r($_GET['username']);
	//	print_r($_GET['password']);
	//	require DISCUZ_ROOT.'./source/class/class_member.php';
	//	require DISCUZ_ROOT.'./source/function/function_member.php';
	//	$ctl_obj = new logging_ctl();
	//	$ctl_obj->setting = $_G['setting'];
	//	$ctl_obj->on_login();
	//	C::app()->init();
	//	$_G['member']['accessmasks']=1;
	//	loadforum();
	//	echo "<br/>";	
  }
}	
if(in_array($mod,array('followthread','unfollowthread'))) $mod='viewthread';
if(in_array($mod,array('followforum','unfollowforum','unfollowallforum'))) $mod='index';

//echo "forum:";			print_r($_G['forum']);
//echo "<br/>member:";print_r($_G['member']);
set_rssauth();
runhooks();

$navtitle = str_replace('{bbname}', $_G['setting']['bbname'], $_G['setting']['seotitle']['forum']);
require DISCUZ_ROOT.'./source/module/forum/forum_'.$mod.'.php';
//echo "out of forum.php</hr>";
?>
