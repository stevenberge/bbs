use bbs;
create table bbs_forum_threadfollower( 
		`tid` mediumint(8) unsigned NOT NULL default '0',
		`follower` varchar(15) NOT NULL default '',
		`followerid` mediumint(8) unsigned NOT NULL default '0', 
		PRIMARY KEY  (`tid`,`followerid`)
		)ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;
