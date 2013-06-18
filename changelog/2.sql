use bbs;
delete from bbs_forum_thread where tid not in (select tid from bbs_forum_post);
alter table bbs.bbs_forum_thread add pushstate int default 0;
alter table bbs_forum_forum add pushsection char(20);
update `bbs_forum_forum` set pushsection='bbs_org_yuxie' where name= '南燕羽协';
update `bbs_forum_forum` set pushsection='bbs_org_paixie' where name= '南燕排协';
update `bbs_forum_forum` set pushsection='bbs_org_chexie' where name= '大学城车协';
update `bbs_forum_forum` set pushsection='bbs_org_xinxie' where name= '南燕信息协会';
update `bbs_forum_forum` set pushsection='bbs_org_jianxie' where name= '南燕健身协会';
update `bbs_forum_forum` set pushsection='bbs_org_taixie' where name= '南燕台协';
update `bbs_forum_forum` set pushsection='bbs_org_nanyan' where name= '南燕新闻社';
update `bbs_forum_forum` set pushsection='bbs_org_zuxie' where name= '南燕足协';
update `bbs_forum_forum` set pushsection='bbs_cam_ershou' where name= '二手市场';
update `bbs_forum_forum` set pushsection='bbs_cam_dushu' where name= '读书会';
update `bbs_forum_forum` set pushsection='bbs_dpt_huann' where name= '环能学院';
update `bbs_forum_forum` set pushsection='bbs_dpt_huaxue' where name= '化学学院';
update `bbs_forum_forum` set pushsection='bbs_dpt_huifeng' where name= '汇丰学院';
update `bbs_forum_forum` set pushsection='bbs_dpt_xinxi' where name= '信息学院';
update `bbs_forum_forum` set pushsection='bbs_cam_laoxiang' where name= '老乡会';
update `bbs_forum_forum` set pushsection='bbs_dpt_renwen' where name= '人文学院';
update `bbs_forum_forum` set pushsection='bbs_dpt_school' where name= '全校通知';
update `bbs_forum_forum` set pushsection='bbs_cam_tgou' where name= '来团购吧';
alter table bbs_forum_access add allowpush tinyint(1) NOT NULL default '0'; #可以推送吗？
create table bbs_forum_threadfollower( 
		`tid` mediumint(8) unsigned NOT NULL default '0',
		`follower` varchar(15) NOT NULL default '',
		`followerid` mediumint(8) unsigned NOT NULL default '0', 
		PRIMARY KEY  (`tid`,`followerid`)
		)ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

