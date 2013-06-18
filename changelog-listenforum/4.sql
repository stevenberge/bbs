use bbs;
#--CREATE TABLE `bbs_ucenter_members` (
#--  `uid` mediumint(8) unsigned NOT NULL auto_increment,
#--  `username` char(15) NOT NULL default '',
#--  `password` char(32) NOT NULL default '',
#--  `email` char(32) NOT NULL default '',
#--  `myid` char(30) NOT NULL default '',
#--  `myidkey` char(16) NOT NULL default '',
#--  `regip` char(15) NOT NULL default '',
#--  `regdate` int(10) unsigned NOT NULL default '0',
#--  `lastloginip` int(10) NOT NULL default '0',
#--  `lastlogintime` int(10) unsigned NOT NULL default '0',
#--  `salt` char(6) NOT NULL,
#--  `secques` char(8) NOT NULL default '',
#--  PRIMARY KEY  (`uid`),
#--  UNIQUE KEY `username` (`username`),
#--  KEY `email` (`email`)
#--) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=6 ;

CREATE TABLE `bbs_forum_rss` (
  `fid` mediumint(8) unsigned NOT NULL ,
  `name` char(50) NOT NULL default '',
  `pushsection` char(20) default NULL,
  `uid` mediumint(8) unsigned NOT NULL ,
  PRIMARY KEY  (`fid`,`uid`),
	foreign key (fid) references bbs_forum_forum(fid),
	foreign key (uid) references bbs_ucenter_members(uid)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=81 ;

