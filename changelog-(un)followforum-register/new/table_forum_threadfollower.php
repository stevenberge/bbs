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
class table_forum_threadfollower extends discuz_table
{
	//	public function __construct() {
	//		$this->_table = 'forum_threadfollower';
	//		parent::__construct();
	//	}
	public function __construct() {
		$this->_table = 'forum_threadfollower';
		$this->_pk    = 'tid followerid';
		$this->_pre_cache_key = 'forum_threadfollower_';
		parent::__construct();
	}
	//	public function fetch_all_by_tid($tid, $start=0, $limit=50) {
	//				$query = 'SELECT * FROM bbs.bbs_forum_threadfollower WHERE tid='.$tid.DB::limit($start, $limit);
	//				return DB::fetch_all($query);
	//	}
	public function fetch_all_by_tid($tid){
		$tid = intval($tid);
		//		if($tid && ($data = $this->fetch_cache($tid)) === false) {
		$parameter = array('forum_threadfollower', $tid);
		$data = DB::fetch_all("SELECT * FROM %t WHERE tid=%d", $parameter);
		//		}
		return $data;
	}
	public function fetch_all_by_tid_followerid($tid,$followerid,$tableid = 0) {
		$tid = intval($tid);
		$followerid = intval($followerid);
		$data = array();
		//		if($tid && ($data = $this->fetch_cache($tid)) === false) {
		$parameter = array($this->_table, $tid, $followerid);
		$data = DB::fetch_all("SELECT * FROM %t WHERE tid=%d and followerid=%d", $parameter);
		//		}
		return $data;
	}
	public function follow_thread($tid,$followerid,$follower, $return_insert_id = false, $replace = false, $silent = false) {
		$data=self::fetch_all_by_tid_followerid($tid,$followerid);
		if(empty($data))
			return DB::insert($this->_table, array('tid'=>$tid,'followerid'=>$followerid, 'follower'=>$follower)); 
		return;
	}
	public function unfollow_thread($tid, $followerid){
		$data=self::fetch_all_by_tid_followerid($tid,$followerid);
		if(!empty($data))
			DB::delete($this->_table, array('tid'=>$tid,'followerid'=>$followerid),null,false);
		return;
	}
	public function change($tid,$followerid,$follower){
		$data=self::fetch_all_by_tid($tid);
		if(empty($data)){
			self::follow_thread($tid,$followerid,$follower);
		}
		else{
			self::unfollow_thread($tid,$followerid);
		}
	}
}
?>
