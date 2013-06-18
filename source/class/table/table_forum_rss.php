<?php
/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: table_forum_post.php 30707 2012-06-13 03:40:15Z liulanbo $
 */
if(!defined('IN_DISCUZ')) {
  exit('Access Denied');
}
class table_forum_rss extends discuz_table
{
  //	public function __construct() {
  //		$this->_table = 'forum_threadfollower';
  //		parent::__construct();
  //	}
  public function __construct() {
	$this->_table = 'forum_rss';
	$this->_pk    = 'fid uid';
	$this->_pre_cache_key = 'forum_rss_';
	parent::__construct();
  }
  //	public function fetch_all_by_tid($tid, $start=0, $limit=50) {
  //				$query = 'SELECT * FROM bbs.bbs_forum_threadfollower WHERE tid='.$tid.DB::limit($start, $limit);
  //				return DB::fetch_all($query);
  //	}
  //	public function fetch_all_by_fid($fid){
  //		$fid = intval($fid);
  //		//		if($tid && ($data = $this->fetch_cache($tid)) === false) {
  //		$parameter = array('forum_rss', $fid);
  //		$data = DB::fetch_all("SELECT uid FROM %t WHERE fid=%d", $parameter);
  //		//		}
  //		return $data;
  //	}
  public function fetch_all_by_uid_fid($uid,$fid,$tableid = 0) {
	$uid = intval($uid);
	$fid = intval($fid);
	$data = array();
	//	if($tid && ($data = $this->fetch_cache($tid)) === false) {
	$parameter = array($this->_table, $uid, $fid);
	$data = DB::fetch_all("SELECT * FROM %t WHERE uid=%d and fid=%d", $parameter);
	//	}
	return $data;
  }
  public function fetch_all_by_uid($uid){
	$uid = intval($uid);
	$data = array();
	$parameter = array($this->_table, $uid);
	$data = DB::fetch_all("SELECT fid,pushsection,name FROM %t WHERE uid=%d",$parameter);
	return $data;
  }
  public function follow_forum($uid,$fid,$return_insert_id = false, $replace = false, $silent = false) {
	//echo "follow_forum<br/>";
	$data=self::fetch_all_by_uid_fid($uid,$fid);
	if(empty($data)){
	  $data = DB::fetch_all("SELECT name,pushsection FROM ".DB::table('forum_forum')." WHERE fid=".$fid);
	  //print_r ($data);
	  //			if(empty($data[0])
	  //					return "no such forum";
	  //			$para=array($this->_table,$uid,$fid,$data[0]['name'],$data[0]['pushsection']);
	  //			return DB::update("insert into %t('uid','fid','name','pushsection') values(%d,%d,%s,%s)",$para);
	  try{
		DB::insert($this->_table, array('uid'=>$uid,'fid'=>$fid,
			  'name'=>$data[0]['name'],'pushsection'=>$data[0]['pushsection']));
		//echo "insert succeed";
	  }catch (Exception $e){
		//echo "insert fail";
	  }
	}
	//echo "already follow";
  }
  public function unfollow_forum($uid, $fid=-1){
	if($fid==-1){///////全部取消收听
	  DB::delete($this->_table, array('uid'=>$uid),null,false);
	  return;
	}
	$data=self::fetch_all_by_uid_fid($uid,$fid);
	if(!empty($data))
	  DB::delete($this->_table, array('uid'=>$uid,'fid'=>$fid),null,false);
	return;
  }
  public function fetch_forums($uid){
	$data=self::fetch_all_by_uid($uid);
	if(!empty($data))
	{
	  $sections=array();
	  foreach($data as $d){/////donot write like $d as $data
		$sections[]=$d['pushsection'];
	  }
	  //	echo "sections:";
	  //			print_r($sections);
	  //	echo "data:";
	  //			print_r($data);
	  return $sections;
	}
	return null;
  }
}
?>
