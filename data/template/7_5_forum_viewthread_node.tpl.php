<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); 
0
|| checktplrefresh('./template/daren2_123/forum/viewthread_node.htm', './template/default/forum/viewthread_node_body.htm', 1371479389, '5', './data/template/7_5_forum_viewthread_node.tpl.php', './template/daren2_123', 'forum/viewthread_node')
;?>
<?php $needhiddenreply = ($hiddenreplies && $_G['uid'] != $post['authorid'] && $_G['uid'] != $_G['forum_thread']['authorid'] && !$post['first'] && !$_G['forum']['ismoderator']);?><?php
$authorverifys = <<<EOF



EOF;
 if($_G['setting']['verify']['enabled']) { if(is_array($_G['setting']['verify'])) foreach($_G['setting']['verify'] as $vid => $verify) { if($verify['available'] && $verify['showicon']) { 
$authorverifys .= <<<EOF


<a href="home.php?mod=spacecp&amp;ac=profile&amp;op=verify&amp;vid={$vid}" target="_blank">


EOF;
 if($post['verify'.$vid] == 1) { if(!empty($verify['icon'])) { 
$authorverifys .= <<<EOF
<img src="{$verify['icon']}" class="vm" alt="{$verify['title']}" title="{$verify['title']}" />
EOF;
 } else { 
$authorverifys .= <<<EOF
{$verify['title']}
EOF;
 } } elseif(!empty($verify['unverifyicon'])) { 
$authorverifys .= <<<EOF


<img src="{$verify['unverifyicon']}" class="vm" alt="{$verify['title']}" title="{$verify['title']}" />


EOF;
 } 
$authorverifys .= <<<EOF
</a>&nbsp;


EOF;
 } } } 
$authorverifys .= <<<EOF



EOF;
?>

<?php if($post['first'] &&  $_G['forum_threadstamp']) { ?>

<div id="threadstamp"><img src="<?php echo STATICURL;?>image/stamp/<?php echo $_G['forum_threadstamp']['url'];?>" title="<?php echo $_G['forum_threadstamp']['text'];?>" /></div>

<?php } if(empty($post['deleted'])) { ?>

<table id="pid<?php echo $post['pid'];?>" summary="pid<?php echo $post['pid'];?>" cellspacing="0" cellpadding="0">

<tr>



<td class="plc">

<div class="pi">

<?php if(!IS_ROBOT) { if(!$postcount && !$_G['forum_thread']['archiveid'] && $post['first'] ) { ?>

<div id="fj" class="y">

<label class="z">电梯直达</label>

<input type="text" class="px p_fre z" size="2" onkeyup="$('fj_btn').href='forum.php?mod=redirect&ptid=<?php echo $_G['tid'];?>&authorid=<?php echo $_GET['authorid'];?>&postno='+this.value" onkeydown="if(event.keyCode==13) {window.location=$('fj_btn').href;return false;}" title="跳转到指定楼层" />

<a href="javascript:;" id="fj_btn" class="z" title="跳转到指定楼层"><img src="<?php echo IMGDIR;?>/fj_btn.png" alt="跳转到指定楼层" class="vm" /></a>

</div>

<?php } if($post['warned']) { ?>

<a href="forum.php?mod=misc&amp;action=viewwarning&amp;tid=<?php echo $_G['tid'];?>&amp;uid=<?php echo $post['authorid'];?>" title="受到警告" class="y" onclick="showWindow('viewwarning', this.href)"><img src="<?php echo IMGDIR;?>/warning.gif" alt="受到警告" /></a>

<?php } ?>

<strong>

<a href="<?php if($post['first']) { ?>forum.php?mod=viewthread&tid=<?php echo $_G['tid'];?><?php echo $fromuid;?><?php } else { ?>forum.php?mod=redirect&goto=findpost&ptid=<?php echo $_G['tid'];?>&pid=<?php echo $post['pid'];?><?php echo $fromuid;?><?php } ?>" title="您的朋友访问此链接后，您将获得相应的积分奖励" id="postnum<?php echo $post['pid'];?>" onclick="setCopy(this.href, '帖子地址复制成功');return false;"><?php if(!empty($postno[$post['number']])) { ?><?php echo $postno[$post['number']];?><?php } else { ?><em><?php echo $post['number'];?></em><?php echo $postno['0'];?><?php } ?></a>

</strong>

<?php } ?>

<div class="pti">

<div class="pdbt">

<?php if(!$post['first'] && $post['rewardfloor']) { ?>

<label class="pdbts pdbts_1">

<a href="forum.php?mod=viewthread&amp;tid=<?php echo $post['tid'];?>&amp;checkrush=1" rel="nofollow" title="查看抢中楼层" class="v">恭喜</a>

<a href="forum.php?mod=viewthread&amp;tid=<?php echo $post['tid'];?>&amp;checkrush=1" rel="nofollow" title="查看抢中楼层" class="b">抢中本楼</a>

</label>

<?php } if(!$post['first'] && $_G['forum_thread']['special'] == 5) { ?>

<label class="pdbts pdbts_<?php echo intval($post['stand']); ?>">

<?php if($post['stand'] == 1) { ?><a class="v" href="forum.php?mod=viewthread&amp;tid=<?php echo $_G['tid'];?>&amp;extra=<?php echo $_GET['extra'];?>&amp;filter=debate&amp;stand=1" title="只看正方">正方</a>

<?php } elseif($post['stand'] == 2) { ?><a class="v" href="forum.php?mod=viewthread&amp;tid=<?php echo $_G['tid'];?>&amp;extra=<?php echo $_GET['extra'];?>&amp;filter=debate&amp;stand=2" title="只看反方">反方</a>

<?php } else { ?><a href="forum.php?mod=viewthread&amp;tid=<?php echo $_G['tid'];?>&amp;extra=<?php echo $_GET['extra'];?>&amp;filter=debate&amp;stand=0" title="只看中立">中立</a><?php } if($post['stand']) { ?>

<a class="b" href="forum.php?mod=misc&amp;action=debatevote&amp;tid=<?php echo $_G['tid'];?>&amp;pid=<?php echo $post['pid'];?>" id="voterdebate_<?php echo $post['pid'];?>" onclick="ajaxmenu(this);doane(event);">支持 <?php echo $post['voters'];?></a>

<?php } ?>

</label>

<?php } ?>

</div>

<div class="authi">

<?php if(!$post['anonymous'] && $_G['cache']['groupicon'][$post['groupid']]) { ?>

<img class="authicn vm" id="authicon<?php echo $post['pid'];?>" src="<?php echo $_G['cache']['groupicon'][$post['groupid']];?>" />

<?php } else { ?>

<img class="authicn vm" id="authicon<?php echo $post['pid'];?>" src="<?php echo $_G['cache']['groupicon']['0'];?>" />

<?php } if($post['authorid'] && !$post['anonymous']) { if(!$_G['setting']['authoronleft']) { ?><a href="home.php?mod=space&amp;uid=<?php echo $post['authorid'];?>" target="_blank" class="xi2"><?php echo $post['author'];?></a><?php } ?>

<em id="authorposton<?php echo $post['pid'];?>">发表于 <?php echo $post['dateline'];?></em>

<?php if($post['status'] & 8) { ?>

<span class="xg1"><?php if($_G['setting']['mobile']['mobilecomefrom']) { ?><?php echo $_G['setting']['mobile']['mobilecomefrom'];?><?php } else { ?>来自手机<?php } ?></span>

<?php } if($post['invisible'] == 0) { if(!IS_ROBOT && !$_GET['authorid'] && !$_G['forum_thread']['archiveid']) { ?>

<span class="pipe">|</span><a href="forum.php?mod=viewthread&amp;tid=<?php echo $post['tid'];?>&amp;page=<?php echo $page;?>&amp;authorid=<?php echo $post['authorid'];?>" rel="nofollow">只看该作者</a>

<?php } elseif(!$_G['forum_thread']['archiveid']) { ?>

<span class="pipe">|</span><a href="forum.php?mod=viewthread&amp;tid=<?php echo $post['tid'];?>&amp;page=<?php echo $page;?>" rel="nofollow">显示全部楼层</a>

<?php } } } elseif(getstatus($post['status'], 5)) { if(!$_G['setting']['authoronleft']) { ?><a href="javascript:;" class="xi2"><?php echo $post['author'];?></a><?php } ?>

&nbsp;<em id="authorposton<?php echo $post['pid'];?>">发表于 <?php echo $post['dateline'];?></em>

<?php } elseif($post['authorid'] && $post['username'] && $post['anonymous'] || !$post['authorid'] && !$post['username']) { ?>

<?php echo $_G['setting']['anonymoustext'];?>&nbsp;

<em id="authorposton<?php echo $post['pid'];?>">发表于 <?php echo $post['dateline'];?></em>

<?php } if(!IS_ROBOT && !$_G['forum_thread']['archiveid'] && $post['first'] ) { if(!$rushreply) { if($ordertype != 1) { ?>

<span class="pipe">|</span><a href="forum.php?mod=viewthread&amp;tid=<?php echo $_G['tid'];?>&amp;extra=<?php echo $_GET['extra'];?>&amp;ordertype=1">倒序浏览</a>

<?php } else { ?>

<span class="pipe">|</span><a href="forum.php?mod=viewthread&amp;tid=<?php echo $_G['tid'];?>&amp;extra=<?php echo $_GET['extra'];?>&amp;ordertype=2">正序浏览</a>

<?php } } if($thread['authorid'] == $_G['uid']) { ?>

<span class="pipe">|</span>

<?php if($replynotice == 1) { ?>

<a id="replynotice" href="forum.php?mod=misc&amp;action=replynotice&amp;op=ignore&amp;tid=<?php echo $_G['tid'];?>" status="1" onclick="ajaxmenu(this, 3000, 0, 0, '43', function () {replyNotice();});return false;">取消回复通知</a>

<?php } else { ?>

<a id="replynotice" href="forum.php?mod=misc&amp;action=replynotice&amp;op=receive&amp;tid=<?php echo $_G['tid'];?>" status="0" onclick="ajaxmenu(this, 3000, 0, 0, '43', function () {replyNotice();});return false;">接收回复通知</a>

<?php } } } ?>

<?php if(!empty($_G['setting']['pluginhooks']['viewthread_postheader'][$postcount])) echo $_G['setting']['pluginhooks']['viewthread_postheader'][$postcount];?>

</div>

</div>

</div><?php $ad_a_pr=adshow("thread/a_pr/3/$postcount");?><div class="pct"><?php echo adshow("thread/a_pt/2/$postcount");?><?php if(!$_G['inajax']) { if(empty($ad_a_pr_css)) { ?>

<style type="text/css">.pcb{margin-right:0}</style><?php $ad_a_pr_css=1;?><?php } } if(!$post['first'] && $post['replycredit'] > 0) { ?>

<div class="cm">

<h3 class="psth xs1">

回帖奖励 <span class="xw1 xs2 xi1">+<?php echo $post['replycredit'];?></span> <?php echo $_G['setting']['extcredits'][$_G['forum_thread']['replycredit_rule']['extcreditstype']]['unit'];?><?php echo $_G['setting']['extcredits'][$_G['forum_thread']['replycredit_rule']['extcreditstype']]['title'];?>

</h3>

</div>

<?php } ?><div class="pcb">
<?php if(!$_G['forum']['ismoderator'] && $_G['setting']['bannedmessages'] & 1 && (($post['authorid'] && !$post['username']) || ($_G['thread']['digest'] == 0 && ($post['groupid'] == 4 || $post['groupid'] == 5 || $post['memberstatus'] == '-1')))) { ?>
<div class="locked">提示: <em>作者被禁止或删除 内容自动屏蔽</em></div>
<?php } elseif(!$_G['forum']['ismoderator'] && $post['status'] & 1) { ?>
<div class="locked">提示: <em>该帖被管理员或版主屏蔽</em></div>
<?php } elseif($needhiddenreply) { ?>
<div class="locked">此帖仅作者可见</div>
<?php } elseif($post['first'] && $_G['forum_threadpay']) { include template('forum/viewthread_pay'); } else { if(!$post['first'] && !empty($post['subject'])) { ?>
<h2><?php echo $post['subject'];?></h2>
<?php } ?>
<?php if(!empty($_G['setting']['pluginhooks']['viewthread_posttop'][$postcount])) echo $_G['setting']['pluginhooks']['viewthread_posttop'][$postcount];?>
<?php if($_G['setting']['bannedmessages'] & 1 && (($post['authorid'] && !$post['username']) || ($_G['thread']['digest'] == 0 && ($post['groupid'] == 4 || $post['groupid'] == 5 || $post['memberstatus'] == '-1')))) { ?>
<div class="locked">提示: <em>作者被禁止或删除 内容自动屏蔽，只有管理员或有管理权限的成员可见</em></div>
<?php } elseif($post['status'] & 1) { ?>
<div class="locked">提示: <em>该帖被管理员或版主屏蔽，只有管理员或有管理权限的成员可见</em></div>
<?php } if(!$post['first'] && $hiddenreplies && $_G['forum']['ismoderator']) { ?>
<div class="locked">此帖仅作者可见</div>
<?php } if($post['first']) { if($_G['forum_thread']['price'] > 0 && $_G['forum_thread']['special'] == 0) { ?>
<div class="locked"><em class="y"><a href="forum.php?mod=misc&amp;action=viewpayments&amp;tid=<?php echo $_G['tid'];?>" onclick="showWindow('pay', this.href)">记录</a></em>付费主题, 价格: <strong><?php echo $_G['forum_thread']['price'];?> <?php echo $_G['setting']['extcredits'][$_G['setting']['creditstransextra']['1']]['unit'];?><?php echo $_G['setting']['extcredits'][$_G['setting']['creditstransextra']['1']]['title'];?> </strong></div>
<?php } if($threadsort && $threadsortshow) { if($threadsortshow['typetemplate']) { ?>
<?php echo $threadsortshow['typetemplate'];?>
<?php } elseif($threadsortshow['optionlist']) { ?>
<div class="typeoption">
<?php if($threadsortshow['optionlist'] == 'expire') { ?>
该信息已经过期
<?php } else { ?>
<table summary="分类信息" cellpadding="0" cellspacing="0" class="cgtl mbm">
<caption><?php echo $_G['forum']['threadsorts']['types'][$_G['forum_thread']['sortid']];?></caption>
<tbody><?php if(is_array($threadsortshow['optionlist'])) foreach($threadsortshow['optionlist'] as $option) { if($option['type'] != 'info') { ?>
<tr>
<th><?php echo $option['title'];?>:</th>
<td><?php if($option['value'] || ($option['type'] == 'number' && $option['value'] !== '')) { ?><?php echo $option['value'];?> <?php echo $option['unit'];?><?php } else { ?>-<?php } ?></td>
</tr>
<?php } } ?>
</tbody>
</table>
<?php } ?>
</div>
<?php } } } ?>
<div class="<?php if(!$_G['forum_thread']['special']) { ?>t_fsz<?php } else { ?>pcbs<?php } ?>">
<?php if($post['first']) { if(!$_G['forum_thread']['special']) { ?>
<table cellspacing="0" cellpadding="0"><tr><td class="t_f" id="postmessage_<?php echo $post['pid'];?>">
<?php if(!$_G['inajax']) { if($ad_a_pr) { ?>
<?php echo $ad_a_pr;?>
<?php } } ?>
<?php echo $post['message'];?></td></tr></table>
<?php } elseif($_G['forum_thread']['special'] == 1) { include template('forum/viewthread_poll'); } elseif($_G['forum_thread']['special'] == 2) { include template('forum/viewthread_trade'); } elseif($_G['forum_thread']['special'] == 3) { include template('forum/viewthread_reward'); } elseif($_G['forum_thread']['special'] == 4) { include template('forum/viewthread_activity'); } elseif($_G['forum_thread']['special'] == 5) { include template('forum/viewthread_debate'); } elseif($_G['forum_thread']['special'] == 127) { ?>
<?php echo $threadplughtml;?>
<table cellspacing="0" cellpadding="0"><tr><td class="t_f" id="postmessage_<?php echo $post['pid'];?>"><?php echo $post['message'];?></td></tr></table>
<?php } } else { ?>
<table cellspacing="0" cellpadding="0"><tr><td class="t_f" id="postmessage_<?php echo $post['pid'];?>">
<?php if(!$_G['inajax']) { if($ad_a_pr) { ?>
<?php echo $ad_a_pr;?>
<?php } } if($post['invisible'] != '-2' || $_G['forum']['ismoderator']) { ?><?php echo $post['message'];?><?php } else { ?><span class="xg1">待审核</span><?php } ?></td></tr></table>
<?php } if($post['attachment']) { ?>
<div class="attach_nopermission">
<div>
<h3>本帖子中包含更多资源</h3>
<p><?php if($_G['uid']) { ?>您所在的用户组无法下载或查看附件<?php } elseif($_G['connectguest']) { ?>您需要 <a href="member.php?mod=connect" class="xi2">完善帐号信息</a> 或 <a href="member.php?mod=connect&amp;ac=bind" class="xi2">绑定已有帐号</a> 后才可以下载或查看<?php } else { ?>您需要 <a href="member.php?mod=logging&amp;action=login" onclick="showWindow('login', this.href);return false;">登录</a> 才可以下载或查看，没有帐号？<a href="member.php?mod=<?php echo $_G['setting']['regname'];?>" title="注册帐号"><?php echo $_G['setting']['reglinkname'];?></a> <?php if(!empty($_G['setting']['pluginhooks']['global_login_text'])) echo $_G['setting']['pluginhooks']['global_login_text'];?><?php } ?></p>
</div>
</div>
<?php } elseif($post['imagelist'] || $post['attachlist']) { ?>
<div class="pattl">
<?php if($post['imagelist'] && $_G['setting']['imagelistthumb'] && $post['imagelistcount'] >= $_G['setting']['imagelistthumb']) { if(!isset($imagelistkey)) { ?><?php $imagelistkey = rawurlencode(dsign($_G[tid].'|100|100'))?><script type="text/javascript" reload="1">var imagelistkey = '<?php echo $imagelistkey;?>';</script>
<?php } ?><?php $post['imagelistthumb'] = true;?><div class="bbda cl mtw mbm pbm">
<strong>更多图片</strong>
<a href="javascript:;" onclick="attachimglst('<?php echo $post['pid'];?>', 0)" class="xi2 attl_g">小图</a>
<a href="javascript:;" onclick="attachimglst('<?php echo $post['pid'];?>', 1, <?php echo intval($_G['setting']['lazyload']); ?>)" class="xi2 attl_m">大图</a>
</div>
<div id="imagelist_<?php echo $post['pid'];?>" class="cl" style="display:none"><?php echo showattach($post, 1); ?></div>
<div id="imagelistthumb_<?php echo $post['pid'];?>" class="pattl_c cl"><img src="<?php echo IMGDIR;?>/loading.gif" width="16" height="16" class="vm" /> 组图打开中，请稍候......</div>
<?php } else { echo showattach($post, 1); } if($post['attachlist']) { echo showattach($post); } ?>
</div>
<?php } ?>
</div>
<?php if($post['first'] && $sticklist) { ?>
<div>
<h3 class="psth xs1">回帖推荐</h3><?php if(is_array($sticklist)) foreach($sticklist as $rpost) { ?><div class="pstl xs1">
<?php if($rpost['authorid'] && !$rpost['anonymous']) { ?>
<div class="psta"><a href="home.php?mod=space&amp;uid=<?php echo $rpost['authorid'];?>" c="1"><?php echo $rpost['avatar'];?></a></div>
<div class="psti">
<p>
<a href="home.php?mod=space&amp;uid=<?php echo $rpost['authorid'];?>" class="xi2 xw1"><?php echo $rpost['author'];?></a> <a href="javascript:;" onclick="window.open('forum.php?mod=redirect&goto=findpost&ptid=<?php echo $rpost['tid'];?>&pid=<?php echo $rpost['pid'];?>')" class="xi2">查看楼层</a>
<?php if($_G['group']['allowstickreply'] || $_G['forum_thread']['authorid'] == $_G['uid']) { ?>&nbsp;<a href="javascript:;" onclick="modaction('stickreply', <?php echo $rpost['pid'];?>, '&undo=yes')" class="xi2">解除置顶</a><?php } ?>
</p>
<div class="mtn"><?php echo $rpost['message'];?></div>
</div>
<?php } else { ?>
<div class="psti">
<p>
<?php if(!$rpost['authorid']) { ?>
<a href="javascript:;"><?php echo $_G['setting']['anonymoustext'];?> <em><?php echo $rpost['useip'];?></em></a>
<?php } elseif($rpost['authorid'] && $rpost['anonymous']) { if($_G['forum']['ismoderator']) { ?><a href="home.php?mod=space&amp;uid=<?php echo $rpost['authorid'];?>" target="_blank"><?php echo $_G['setting']['anonymoustext'];?></a><?php } else { ?><?php echo $_G['setting']['anonymoustext'];?><?php } } else { ?>
<?php echo $rpost['author'];?> <em>该用户已被删除</em>
<?php } ?>
 <a href="javascript:;" onclick="window.open('forum.php?mod=redirect&goto=findpost&ptid=<?php echo $rpost['tid'];?>&pid=<?php echo $rpost['pid'];?>')" class="xi2">查看楼层</a>
 <?php if($_G['group']['allowstickreply'] || $_G['forum_thread']['authorid'] == $_G['uid']) { ?>&nbsp;<a href="javascript:;" onclick="modaction('stickreply', <?php echo $rpost['pid'];?>, '&undo=yes')" class="xi2">解除置顶</a><?php } ?>
</p>
<div class="mtn"><?php echo $rpost['message'];?></div>
</div>
<?php } ?>
</div>
<?php } ?>
</div>
<?php } ?>
<div id="comment_<?php echo $post['pid'];?>" class="cm">
<?php if($_G['setting']['commentnumber'] && !empty($comments[$post['pid']])) { ?>
<h3 class="psth xs1">点评</h3>
<?php if($totalcomment[$post['pid']]) { ?><div class="pstl"><?php echo $totalcomment[$post['pid']];?></div><?php } if(is_array($comments[$post['pid']])) foreach($comments[$post['pid']] as $comment) { ?><div class="pstl xs1">
<div class="psta"><a href="home.php?mod=space&amp;uid=<?php echo $comment['authorid'];?>" c="1"><?php echo $comment['avatar'];?></a></div>
<div class="psti">
<?php if($comment['authorid']) { ?>
<a href="home.php?mod=space&amp;uid=<?php echo $comment['authorid'];?>" class="xi2 xw1"><?php echo $comment['author'];?></a>
<?php } else { ?>
游客
<?php } ?>
&nbsp;<?php echo $comment['comment'];?>&nbsp;
<?php if($comment['rpid']) { ?>
<a href="forum.php?mod=redirect&amp;goto=findpost&amp;pid=<?php echo $comment['rpid'];?>&amp;ptid=<?php echo $_G['tid'];?>" class="xi2">详情</a>
<a href="forum.php?mod=post&amp;action=reply&amp;fid=<?php echo $_G['fid'];?>&amp;tid=<?php echo $_G['tid'];?>&amp;repquote=<?php echo $comment['rpid'];?>&amp;extra=<?php echo $_GET['extra'];?>&amp;page=<?php echo $page;?><?php if($_GET['from']) { ?>&amp;from=<?php echo $_GET['from'];?><?php } ?>" class="xi2" onclick="showWindow('reply', this.href)">回复</a>
<?php } ?>
<span class="xg1">
发表于 <?php echo dgmdate($comment[dateline], 'u');?><?php if($comment['useip'] && $_G['group']['allowviewip']) { ?>&nbsp;IP:<?php echo $comment['useip'];?><?php } if($_G['forum']['ismoderator'] && $_G['group']['allowdelpost']) { ?>&nbsp;<a href="javascript:;" onclick="modaction('delcomment', <?php echo $comment['id'];?>)">删除</a><?php } ?>
</span>
</div>
</div>
<?php } if($commentcount[$post['pid']] > $_G['setting']['commentnumber']) { ?><div class="pgs mbm cl"><div class="pg"><a href="javascript:;" class="nxt" onclick="ajaxget('forum.php?mod=misc&action=commentmore&tid=<?php echo $post['tid'];?>&pid=<?php echo $post['pid'];?>&page=2', 'comment_<?php echo $post['pid'];?>')">下一页</a></div></div><?php } } ?>
</div>
<?php if(!empty($_G['setting']['pluginhooks']['viewthread_postbottom'][$postcount])) echo $_G['setting']['pluginhooks']['viewthread_postbottom'][$postcount];?>
<?php if(!empty($post['ratelog'])) { ?>
<dl id="ratelog_<?php echo $post['pid'];?>" class="rate<?php if(!empty($_G['cookie']['ratecollapse'])) { ?> rate_collapse<?php } ?>">
<?php if($_G['setting']['ratelogon']) { ?>
<dd style="margin:0">
<?php } else { ?>
<dt>
<?php if(!empty($postlist[$post['pid']]['totalrate'])) { ?>
<strong><a href="forum.php?mod=misc&amp;action=viewratings&amp;tid=<?php echo $_G['tid'];?>&amp;pid=<?php echo $post['pid'];?>" onclick="showWindow('viewratings', this.href)" title="已有<?php echo count($postlist[$post['pid']]['totalrate']);; ?>人评分, 查看全部评分"><?php echo count($postlist[$post['pid']]['totalrate']);; ?></a></strong>
<p><a href="forum.php?mod=misc&amp;action=viewratings&amp;tid=<?php echo $_G['tid'];?>&amp;pid=<?php echo $post['pid'];?>" onclick="showWindow('viewratings', this.href)">查看全部评分</a></p>
<?php } ?>
</dt>
<dd>
<?php } ?>
<div id="post_rate_<?php echo $post['pid'];?>"></div>
<?php if($_G['setting']['ratelogon']) { ?>
<table class="ratl">
<tr>
<th class="xw1" width="120"><a href="forum.php?mod=misc&amp;action=viewratings&amp;tid=<?php echo $_G['tid'];?>&amp;pid=<?php echo $post['pid'];?>" onclick="showWindow('viewratings', this.href)" title="查看全部评分">已有 <span class="xi1"><?php echo count($postlist[$post['pid']]['totalrate']);; ?></span> 人评分</a></th><?php if(is_array($post['ratelogextcredits'])) foreach($post['ratelogextcredits'] as $id => $score) { ?><th width="50"><i><?php echo $_G['setting']['extcredits'][$id]['title'];?></i></th>
<?php } ?>
<th>
<a href="javascript:;" onclick="toggleRatelogCollapse('ratelog_<?php echo $post['pid'];?>', this);" class="y xi2 op"><?php if(!empty($_G['cookie']['ratecollapse'])) { ?>展开<?php } else { ?>收起<?php } ?></a>
<i>理由</i>
</th>
</tr>
<tbody class="ratl_l"><?php if(is_array($post['ratelog'])) foreach($post['ratelog'] as $uid => $ratelog) { ?><tr id="rate_<?php echo $post['pid'];?>_<?php echo $uid;?>">
<td>
<a href="home.php?mod=space&amp;uid=<?php echo $uid;?>" target="_blank"><?php echo avatar($uid, 'small');; ?></a> <a href="home.php?mod=space&amp;uid=<?php echo $uid;?>" target="_blank"><?php echo $ratelog['username'];?></a>
</td><?php if(is_array($post['ratelogextcredits'])) foreach($post['ratelogextcredits'] as $id => $score) { if($ratelog['score'][$id] > 0) { ?>
<td class="xi1"> + <?php echo $ratelog['score'][$id];?></td>
<?php } else { ?>
<td class="xg1"><?php echo $ratelog['score'][$id];?></td>
<?php } } ?>
<td class="xg1"><?php echo $ratelog['reason'];?></td>
</tr>
<?php } ?>
</tbody>
</table>
<p class="ratc">
总评分:&nbsp;<?php if(is_array($post['ratelogextcredits'])) foreach($post['ratelogextcredits'] as $id => $score) { if($score > 0) { ?>
<span class="xi1"><?php echo $_G['setting']['extcredits'][$id]['title'];?> + <?php echo $score;?></span>&nbsp;
<?php } else { ?>
<span class="xg1"><?php echo $_G['setting']['extcredits'][$id]['title'];?> <?php echo $score;?></span>&nbsp;
<?php } } ?>
&nbsp;<a href="forum.php?mod=misc&amp;action=viewratings&amp;tid=<?php echo $_G['tid'];?>&amp;pid=<?php echo $post['pid'];?>" onclick="showWindow('viewratings', this.href)" title="查看全部评分" class="xi2">查看全部评分</a>
</p>
<?php } else { ?>
<ul class="cl"><?php if(is_array($post['ratelog'])) foreach($post['ratelog'] as $uid => $ratelog) { ?><li>
<p id="rate_<?php echo $post['pid'];?>_<?php echo $uid;?>" onmouseover="showTip(this)" tip="<strong><?php echo $ratelog['reason'];?></strong>&nbsp;<?php if(is_array($ratelog['score'])) foreach($ratelog['score'] as $id => $score) { if($score > 0) { ?>
<em class='xi1'><?php echo $_G['setting']['extcredits'][$id]['title'];?> + <?php echo $score;?> <?php echo $_G['setting']['extcredits'][$id]['unit'];?></em>
<?php } else { ?>
<span><?php echo $_G['setting']['extcredits'][$id]['title'];?> <?php echo $score;?> <?php echo $_G['setting']['extcredits'][$id]['unit'];?></span>
<?php } } ?>" class="mtn mbn"><a href="home.php?mod=space&amp;uid=<?php echo $uid;?>" target="_blank" class="avt"><?php echo avatar($uid, 'small');; ?></a></p>
<p><a href="home.php?mod=space&amp;uid=<?php echo $uid;?>" target="_blank"><?php echo $ratelog['username'];?></a></p>
</li>
<?php } ?>
</ul>
<?php } ?>
</dd>
</dl>
<?php } else { ?>
<div id="post_rate_div_<?php echo $post['pid'];?>"></div>
<?php } } ?>
</div></div>



<?php if(helper_access::check_module('collection') && !$_G['forum']['disablecollect']) { if($post['relatecollection']) { ?>

<div class="cm">

<h3 class="psth xs1">本帖被以下淘专辑推荐:</h3>

<ul class="mbw xl xl2 cl"><?php if(is_array($post['relatecollection'])) foreach($post['relatecollection'] as $var) { ?><li>&middot; <a href="forum.php?mod=collection&amp;action=view&amp;ctid=<?php echo $var['ctid'];?>" title="<?php echo $var['name'];?>" target="_blank" class="xi2 xw1"><?php echo $var['name'];?></a><span class="pipe">|</span><span class="xg1">主题: <?php echo $var['threadnum'];?>, 订阅: <?php echo $var['follownum'];?></span></li>

<?php } if($post['releatcollectionmore']) { ?>

<li>&middot; <a href="forum.php?mod=collection&amp;tid=<?php echo $_G['tid'];?>" target="_blank" class="xi2 xw1">更多</a></li>

<?php } ?>

</ul>

</div>

<?php if($post['sourcecollection']['ctid']) { ?>

<div>

您是从淘专辑 <a href="forum.php?mod=collection&amp;action=view&amp;ctid=<?php echo $post['sourcecollection']['ctid'];?>" target="_blank" class="xi2"><?php echo $post['sourcecollection']['name'];?></a> 访问到本帖的，欢迎对专辑打分：

<form action="forum.php?mod=collection&amp;action=comment&amp;ctid=<?php echo $ctid;?>&amp;tid=<?php echo $_G['tid'];?>" method="POST" class="ptm pbm cl">

<input type="hidden" name="ratescore" id="ratescore" />

<span class="clct_ratestar">

<span class="btn">

<a href="javascript:;" onmouseover="rateStarHover('clct_ratestar_star',1)" onmouseout="rateStarHover('clct_ratestar_star',0)" onclick="rateStarSet('clct_ratestar_star',1,'ratescore')">1</a>

<a href="javascript:;" onmouseover="rateStarHover('clct_ratestar_star',2)" onmouseout="rateStarHover('clct_ratestar_star',0)" onclick="rateStarSet('clct_ratestar_star',2,'ratescore')">2</a>

<a href="javascript:;" onmouseover="rateStarHover('clct_ratestar_star',3)" onmouseout="rateStarHover('clct_ratestar_star',0)" onclick="rateStarSet('clct_ratestar_star',3,'ratescore')">3</a>

<a href="javascript:;" onmouseover="rateStarHover('clct_ratestar_star',4)" onmouseout="rateStarHover('clct_ratestar_star',0)" onclick="rateStarSet('clct_ratestar_star',4,'ratescore')">4</a>

<a href="javascript:;" onmouseover="rateStarHover('clct_ratestar_star',5)" onmouseout="rateStarHover('clct_ratestar_star',0)" onclick="rateStarSet('clct_ratestar_star',5,'ratescore')">5</a>

</span>

<span id="clct_ratestar_star" class="star star<?php echo $memberrate;?>"></span>

</span>

&nbsp;<button type="submit" value="submit" class="pn"><span>评分</span></button>

</form>

</div>

<?php } } } if($post['first'] && ($post['tags'] || $relatedkeywords)) { ?>

<div class="ptg mbm">

<?php if($post['tags']) { ?><?php $tagi = 0;?><?php if(is_array($post['tags'])) foreach($post['tags'] as $var) { if($tagi) { ?>, <?php } ?><a title="<?php echo $var['1'];?>" href="misc.php?mod=tag&amp;id=<?php echo $var['0'];?>" target="_blank"><?php echo $var['1'];?></a><?php $tagi++;?><?php } } if($relatedkeywords) { ?><span><?php echo $relatedkeywords;?></span><?php } ?>

</div>

<?php } ?>

</td>  <td class="pls" rowspan="2">

<?php echo $post['newpostanchor'];?> <?php echo $post['lastpostanchor'];?>

<?php if($post['authorid'] && $post['username'] && !$post['anonymous']) { if($_G['setting']['authoronleft']) { ?>

<div class="pi">

<div class="authi"><a href="home.php?mod=space&amp;uid=<?php echo $post['authorid'];?>" target="_blank" class="xw1"><?php echo $post['author'];?></a></div>

</div>

<?php } ?>

<div class="p_pop blk bui" id="userinfo<?php echo $post['pid'];?>" style="display: none; <?php if($_G['setting']['authoronleft']) { ?>margin-top: -11px;<?php } ?>">

<div class="m y">

<div id="userinfo<?php echo $post['pid'];?>_ma"></div>

<?php if(!empty($_G['setting']['pluginhooks']['viewthread_profileside'][$postcount])) echo $_G['setting']['pluginhooks']['viewthread_profileside'][$postcount];?>

</div>

<div class="i y">

<div>

<strong><a href="home.php?mod=space&amp;uid=<?php echo $post['authorid'];?>" target="_blank" class="xi2"><?php echo $post['author'];?></a></strong>

<?php if($_G['setting']['vtonlinestatus'] && $post['authorid']) { if(($_G['setting']['vtonlinestatus'] == 2 && $_G['forum_onlineauthors'][$post['authorid']]) || ($_G['setting']['vtonlinestatus'] == 1 && (TIMESTAMP - $post['lastactivity'] <= 10800) && !$post['authorinvisible'])) { ?>

<em>当前在线</em>

<?php } else { ?>

<em>当前离线</em>

<?php } } ?>

</div>

<dl class="cl"><?php echo $post['custominfo']['menu'];?></dl>

<div class="imicn">

<?php if($post['qq'] ) { ?><a href="http://wpa.qq.com/msgrd?V=1&amp;Uin=<?php echo $post['qq'];?>&amp;Site=<?php echo $_G['setting']['bbname'];?>&amp;Menu=yes" target="_blank" title="QQ"><img src="<?php echo IMGDIR;?>/qq.gif" alt="QQ" /></a><?php } if($post['qq']) { ?><a href="http://<?php echo $post['qq'];?>.qzone.qq.com/" target="_blank" title="QQ空间"><img src="/static/image/common/qzone.gif" alt="欢迎光临<?php echo $post['username'];?>的QQ空间" /></a><?php } if($post['icq'] ) { ?><a href="http://wwp.icq.com/scripts/search.dll?to=<?php echo $post['icq'];?>" target="_blank" title="ICQ"><img src="<?php echo IMGDIR;?>/icq.gif" alt="ICQ" /></a><?php } if($post['yahoo'] ) { ?><a href="http://edit.yahoo.com/config/send_webmesg?.target=<?php echo $post['yahoo'];?>&amp;.src=pg" target="_blank" title="Yahoo"><img src="<?php echo IMGDIR;?>/yahoo.gif" alt="Yahoo!"  /></a><?php } if($post['taobao'] ) { ?><a href="javascript:;" onclick="window.open('http://amos.im.alisoft.com/msg.aw?v=2&uid='+encodeURIComponent('<?php echo $post['taobaoas'];?>')+'&site=cntaobao&s=2&charset=utf-8')" title="阿里旺旺"><img src="<?php echo IMGDIR;?>/taobao.gif" alt="阿里旺旺" /></a><?php } if($post['site'] ) { ?><a href="<?php echo $post['site'];?>" target="_blank" title="查看个人网站"><img src="<?php echo IMGDIR;?>/forumlink.gif" alt="查看个人网站" /></a><?php } ?>

<a href="home.php?mod=space&amp;uid=<?php echo $post['authorid'];?>&amp;do=profile" target="_blank" title="查看详细资料"><img src="<?php echo IMGDIR;?>/userinfo.gif" alt="查看详细资料" /></a>

<?php if(!empty($_G['setting']['pluginhooks']['viewthread_imicons'][$postcount])) echo $_G['setting']['pluginhooks']['viewthread_imicons'][$postcount];?>

<?php if($_G['setting']['magicstatus']) { if(!empty($_G['setting']['magics']['showip'])) { ?>

<a href="home.php?mod=magic&amp;mid=showip&amp;idtype=user&amp;id=<?php echo rawurlencode($post['author']); ?>" id="a_showip_li_<?php echo $post['pid'];?>" class="xi2" onclick="showWindow(this.id, this.href)"><img src="<?php echo STATICURL;?>/image/magic/showip.small.gif" alt="" /> <?php echo $_G['setting']['magics']['showip'];?></a>

<?php } if(!empty($_G['setting']['magics']['checkonline']) && $post['authorid'] != $_G['uid']) { ?>

<a href="home.php?mod=magic&amp;mid=checkonline&amp;idtype=user&amp;id=<?php echo rawurlencode($post['author']); ?>" id="a_repent_<?php echo $post['pid'];?>" class="xi2" onclick="showWindow(this.id, this.href)"><img src="<?php echo STATICURL;?>/image/magic/checkonline.small.gif" alt="" /> <?php echo $_G['setting']['magics']['checkonline'];?></a>

<?php } ?>

<?php if(!empty($_G['setting']['pluginhooks']['viewthread_magic_user'][$postcount])) echo $_G['setting']['pluginhooks']['viewthread_magic_user'][$postcount];?>

<?php } ?>

</div>

<div id="avatarfeed"><span id="threadsortswait"></span></div>

</div>

</div>

<?php } if($post['authorid'] && $post['username'] && !$post['anonymous']) { ?>

<div>

<?php if($_G['setting']['bannedmessages'] & 2 && ($post['memberstatus'] == '-1' || ($post['authorid'] && !$post['username']) || ($post['groupid'] == 4 || $post['groupid'] == 5) || ($post['status'] & 1))) { ?>

<div class="avatar">头像被屏蔽</div>

<?php } elseif($post['avatar'] && $showavatars) { if($post['mobiletype']) { ?>

<div class="mobile-type mobile-type-<?php echo $post['mobiletype'];?>">

<a href="misc.php?mod=mobile" tip="该帖通过手机客户端发布" onmouseover="showTip(this)"></a>

</div>

<?php } ?>

<div class="avatar" onmouseover="showauthor(this, 'userinfo<?php echo $post['pid'];?>')"><a href="home.php?mod=space&amp;uid=<?php echo $post['authorid'];?>" target="_blank"><?php echo $post['avatar'];?></a></div>

<?php } ?>

<div class="tns xg2">

<table cellspacing="0" cellpadding="0">

<th><p><a href="home.php?mod=space&amp;uid=<?php echo $post['authorid'];?>&amp;do=thread&amp;view=me&amp;from=space" class="xi2"><?php echo dnumber($post['threads']); ?></a></p>主题</th>

<th>

<?php if(helper_access::check_module('follow')) { ?>

<p><a href="home.php?mod=follow&amp;do=follower&amp;uid=<?php echo $post['authorid'];?>" class="xi2"><?php echo dnumber($post['follower']); ?></a></p>听众

<?php } else { ?>

<p><a href="home.php?mod=space&amp;uid=<?php echo $post['authorid'];?>&amp;do=friend&amp;view=me" class="xi2"><?php echo dnumber($post['friends']); ?></a></p>好友

<?php } ?>

</th>

<td><p><a href="home.php?mod=space&amp;uid=<?php echo $post['authorid'];?>&amp;do=profile" class="xi2"><?php echo dnumber($post['credits']); ?></a></p>积分</td>

</table>

</div>

<?php if(!empty($_G['setting']['pluginhooks']['viewthread_avatar'][$postcount])) echo $_G['setting']['pluginhooks']['viewthread_avatar'][$postcount];?>

<?php if($post['groupicon']) { ?><p><a href="home.php?mod=spacecp&amp;ac=usergroup&amp;gid=<?php echo $post['groupid'];?>" target="_blank"><?php echo $post['groupicon'];?></a></p><?php } ?>

<p><em><a href="home.php?mod=spacecp&amp;ac=usergroup&amp;gid=<?php echo $post['groupid'];?>" target="_blank"><?php echo $post['authortitle'];?></a></em></p>

<?php if($post['customstatus']) { ?><p class="xg1"><?php echo $post['customstatus'];?></p><?php } ?>

</div>

<p<?php if($post['upgradecredit'] !== false) { ?> id="g_up<?php echo $post['pid'];?>" onmouseover="showMenu({'ctrlid':this.id, 'pos':'12!'});"<?php } ?>><?php showstars($post['stars']);?></p>

<?php if($post['upgradecredit'] !== false) { ?>

<div id="g_up<?php echo $post['pid'];?>_menu" class="tip tip_4" style="display: none;">

<div class="tip_horn"></div>

<div class="tip_c"><?php echo $post['authortitle'];?>, 积分 <?php echo $post['credits'];?>, 距离下一级还需 <?php echo $post['upgradecredit'];?> 积分</div>

</div>

<?php } ?>

<?php if(!empty($_G['setting']['pluginhooks']['viewthread_sidetop'][$postcount])) echo $_G['setting']['pluginhooks']['viewthread_sidetop'][$postcount];?>

<?php if($post['custominfo']['left']) { ?><dl class="pil cl"><?php echo $post['custominfo']['left'];?></dl><?php } if($post['medals']) { ?>

<p class="md_ctrl">

<a href="home.php?mod=medal"><?php if(is_array($post['medals'])) foreach($post['medals'] as $medal) { ?><img id="md_<?php echo $post['pid'];?>_<?php echo $medal['medalid'];?>" src="<?php echo STATICURL;?>image/common/<?php echo $medal['image'];?>" alt="<?php echo $medal['name'];?>" title="" onmouseover="showMenu({'ctrlid':this.id, 'menuid':'md_<?php echo $medal['medalid'];?>_menu', 'pos':'11!'});" />

<?php } ?>

</a>

</p>

<?php } ?>

<div style="margin-left:20px;"><?php echo $authorverifys;?></div>

<?php if($post['authorid'] != $_G['uid']) { ?>

<ul class="xl xl2 o cl">

<?php if(helper_access::check_module('follow')) { ?>

<li class="addflw">

<a href="home.php?mod=spacecp&amp;ac=follow&amp;op=add&amp;hash=<?php echo FORMHASH;?>&amp;fuid=<?php echo $post['authorid'];?>" id="followmod_<?php echo $post['authorid'];?>" title="收听TA" class="xi2" onclick="showWindow('followmod', this.href, 'get', 0);">收听TA</a>

</li>

<?php } ?>

<li class="pm2"><a href="home.php?mod=spacecp&amp;ac=pm&amp;op=showmsg&amp;handlekey=showmsg_<?php echo $post['authorid'];?>&amp;touid=<?php echo $post['authorid'];?>&amp;pmid=0&amp;daterange=2&amp;pid=<?php echo $post['pid'];?>&amp;tid=<?php echo $post['tid'];?>" onclick="showWindow('sendpm', this.href);" title="发消息" class="xi2">发消息</a></li>

</ul>

<?php } ?>

<?php if(!empty($_G['setting']['pluginhooks']['viewthread_sidebottom'][$postcount])) echo $_G['setting']['pluginhooks']['viewthread_sidebottom'][$postcount];?>

<?php } elseif(getstatus($post['status'], 5)) { if($_G['setting']['authoronleft']) { ?>

<div class="pi">

<div class="authi"><a href="javascript:;" class="xw1"><?php echo $post['author'];?></a></div>

</div>

<?php } if($showavatars) { ?>

<div>

<div class="avatar"><a href="javascript:;"><?php echo $post['avatar'];?></a></div>

</div>

<?php } } else { ?>

<div class="pi">

<?php if(!$post['authorid']) { ?>

<a href="javascript:;"><?php echo $_G['setting']['anonymoustext'];?> <em><?php echo $post['useip'];?></em></a>

<?php } elseif($post['authorid'] && $post['username'] && $post['anonymous']) { if($_G['forum']['ismoderator']) { ?><a href="home.php?mod=space&amp;uid=<?php echo $post['authorid'];?>" target="_blank"><?php echo $_G['setting']['anonymoustext'];?></a><?php } else { ?><?php echo $_G['setting']['anonymoustext'];?><?php } } else { ?>

<?php echo $post['author'];?> <em>该用户已被删除</em>

<?php } ?>

</div>

<?php } if(($_G['group']['allowedituser'] || $_G['group']['allowbanuser'] || ($_G['forum']['ismoderator'] && $_G['group']['allowviewip'])) && !getstatus($post['status'], 5)) { ?>

<p class="cp_pls cl">

<?php if($_G['forum']['ismoderator'] && $_G['group']['allowviewip']) { ?>

<a href="forum.php?mod=topicadmin&amp;action=getip&amp;fid=<?php echo $_G['fid'];?>&amp;tid=<?php echo $_G['tid'];?>&amp;pid=<?php echo $post['pid'];?><?php if($_G['forum_auditstatuson']) { ?>&amp;modthreadkey=<?php echo $_GET['modthreadkey'];?><?php } ?>" onclick="ajaxmenu(this, 0, 0, 2);doane(event)">IP</a>

<?php } if($_G['group']['allowedituser']) { ?>

<a href="<?php if($_G['adminid'] == 1) { ?>admin.php?frames=yes&action=members&operation=search&uid=<?php echo $post['authorid'];?>&submit=yes<?php } else { ?>forum.php?mod=modcp&action=member&op=edit&uid=<?php echo $post['authorid'];?><?php } ?>" target="_blank">编辑</a>

<?php } if($_G['group']['allowbanuser']) { if($_G['adminid'] == 1) { ?>

<a href="admin.php?action=members&amp;operation=ban&amp;username=<?php echo $post['usernameenc'];?>&amp;frames=yes" target="_blank">禁止</a>

<?php } else { ?>

<a href="forum.php?mod=modcp&amp;action=member&amp;op=ban&amp;uid=<?php echo $post['authorid'];?>" target="_blank">禁止</a>

<?php } } ?>

<a href="forum.php?mod=modcp&amp;action=thread&amp;op=post&amp;do=search&amp;searchsubmit=1&amp;users=<?php echo $post['usernameenc'];?>" target="_blank">帖子</a>

<?php if($_G['adminid'] == 1) { ?>

<a href="forum.php?mod=ajax&amp;action=quickclear&amp;uid=<?php echo $post['authorid'];?>" onclick="showWindow('qclear_<?php echo $post['authorid'];?>', this.href, 'get', 0)">清理</a>

<?php } ?>

</p>

<?php } ?>

</td></tr>

<tr><td class="plc plm">

<?php if($locations[$post['pid']]) { ?>

<div class="mobile-location"><?php echo $locations[$post['pid']]['location'];?></div>

<?php } if(!IS_ROBOT && $post['first'] && !$_G['forum_thread']['archiveid']) { if(!empty($lastmod['modaction'])) { ?><div class="modact"><a href="forum.php?mod=misc&amp;action=viewthreadmod&amp;tid=<?php echo $_G['tid'];?>" title="帖子模式" onclick="showWindow('viewthreadmod', this.href)"><?php if($lastmod['modactiontype'] == 'REB') { ?>本主题由 <?php echo $lastmod['modusername'];?> 于 <?php echo $lastmod['moddateline'];?> <?php echo $lastmod['modaction'];?>到 <?php echo $lastmod['reason'];?><?php } else { ?>本主题由 <?php echo $lastmod['modusername'];?> 于 <?php echo $lastmod['moddateline'];?> <?php echo $lastmod['modaction'];?><?php } ?></a></div><?php } ?>

<?php if(!empty($_G['setting']['pluginhooks']['viewthread_modaction'])) echo $_G['setting']['pluginhooks']['viewthread_modaction'];?>



<?php if($post['invisible'] == 0) { ?>

<div id="p_btn" class="mtw mbmm cl">

<?php if(!empty($_G['setting']['pluginhooks']['viewthread_share_method'])) { ?>

<div class="tshare cl">

<strong>分享到:</strong>

<?php if(!empty($_G['setting']['pluginhooks']['viewthread_share_method'])) echo $_G['setting']['pluginhooks']['viewthread_share_method'];?>

</div>

<?php } if(!$post['anonymous'] && helper_access::check_module('follow')) { ?>

<a href="home.php?mod=spacecp&amp;ac=follow&amp;op=relay&amp;tid=<?php echo $_G['tid'];?>&amp;from=forum" id="k_relay" onclick="showWindow(this.id, this.href, 'get', 0);" onmouseover="this.title = $('relaynumber').innerHTML + ' 人转播'"><i><img src="<?php echo IMGDIR;?>/rt.png" alt="转播" />转播<span id="relaynumber"><?php echo $_G['forum_thread']['relay'];?></span></i></a>

<?php } if(!$_G['forum']['disablecollect'] && helper_access::check_module('collection')) { ?>

<a href="forum.php?mod=collection&amp;action=edit&amp;op=addthread&amp;tid=<?php echo $_G['tid'];?>" id="k_collect" onclick="showWindow(this.id, this.href);return false;" onmouseover="this.title = $('collectionnumber').innerHTML + ' 人淘帖'"><i><img src="<?php echo IMGDIR;?>/collection.png" alt="分享" />淘帖<span id="collectionnumber"><?php echo $post['releatcollectionnum'];?></span></i></a>

<?php } if(helper_access::check_module('share')) { ?>

<a href="home.php?mod=spacecp&amp;ac=share&amp;type=thread&amp;id=<?php echo $_G['tid'];?>" id="k_share" onclick="showWindow(this.id, this.href, 'get', 0);" onmouseover="this.title = $('sharenumber').innerHTML + ' 人分享'"><i><img src="<?php echo IMGDIR;?>/oshr.png" alt="分享" />分享<span id="sharenumber"><?php echo $_G['forum_thread']['sharetimes'];?></span></i></a>

<?php } ?>

<a href="home.php?mod=spacecp&amp;ac=favorite&amp;type=thread&amp;id=<?php echo $_G['tid'];?>" id="k_favorite" onclick="showWindow(this.id, this.href, 'get', 0);" onmouseover="this.title = $('favoritenumber').innerHTML + ' 人收藏'"><i><img src="<?php echo IMGDIR;?>/fav.gif" alt="收藏" />收藏<span id="favoritenumber"><?php echo $_G['forum_thread']['favtimes'];?></span></i></a>

<?php if(($_G['group']['allowrecommend'] || !$_G['uid']) && $_G['setting']['recommendthread']['status']) { if(!empty($_G['setting']['recommendthread']['addtext'])) { ?>

<a id="recommend_add" href="forum.php?mod=misc&amp;action=recommend&amp;do=add&amp;tid=<?php echo $_G['tid'];?>" <?php if($_G['uid']) { ?>onclick="ajaxmenu(this, 3000, 1, 0, '43', 'recommendupdate(<?php echo $_G['group']['allowrecommend'];?>)');return false;"<?php } else { ?> onclick="showWindow('login', this.href)"<?php } ?> onmouseover="this.title = $('recommendv_add').innerHTML + ' 人<?php echo $_G['setting']['recommendthread']['addtext'];?>'"><i><img src="<?php echo IMGDIR;?>/rec_add.gif" alt="<?php echo $_G['setting']['recommendthread']['addtext'];?>" /><?php echo $_G['setting']['recommendthread']['addtext'];?><span id="recommendv_add"><?php echo $_G['forum_thread']['recommend_add'];?></span></i></a>

<?php } if(!empty($_G['setting']['recommendthread']['subtracttext'])) { ?>

<a id="recommend_subtract" href="forum.php?mod=misc&amp;action=recommend&amp;do=subtract&amp;tid=<?php echo $_G['tid'];?>" <?php if($_G['uid']) { ?>onclick="ajaxmenu(this, 3000, 1, 0, '43', 'recommendupdate(-<?php echo $_G['group']['allowrecommend'];?>)');return false;"<?php } else { ?> onclick="showWindow('login', this.href)"<?php } ?> onmouseover="this.title = $('recommendv_subtract').innerHTML + ' 人<?php echo $_G['setting']['recommendthread']['subtracttext'];?>'"><i><img src="<?php echo IMGDIR;?>/rec_subtract.gif" alt="<?php echo $_G['setting']['recommendthread']['subtracttext'];?>" /><?php echo $_G['setting']['recommendthread']['subtracttext'];?><span id="recommendv_subtract"><?php echo $_G['forum_thread']['recommend_sub'];?></span></i></a>

<?php } } if($_G['group']['raterange'] && $post['authorid']) { ?>

<a href="javascript:;" id="ak_rate" onclick="showWindow('rate', 'forum.php?mod=misc&action=rate&tid=<?php echo $_G['tid'];?>&pid=<?php echo $post['pid'];?>', 'get', -1);return false;" title="<?php echo count($postlist[$post['pid']]['totalrate']);; ?> 人评分"><i><img src="<?php echo IMGDIR;?>/agree.gif" alt="评分" />评分</i></a>

<?php } ?>

<?php if(!empty($_G['setting']['pluginhooks']['viewthread_useraction'])) echo $_G['setting']['pluginhooks']['viewthread_useraction'];?>

</div>

<?php } } if($post['relateitem']) { ?>

<div class="mtw mbw">

<h3 class="pbm mbm bbda">相关帖子</h3>

<ul class="xl xl2 cl"><?php if(is_array($post['relateitem'])) foreach($post['relateitem'] as $var) { ?><li>&#8226; <a href="forum.php?mod=viewthread&amp;tid=<?php echo $var['tid'];?>" title="<?php echo $var['subject'];?>" target="_blank"><?php echo $var['subject'];?></a></li>

<?php } ?>

</ul>

</div>

<?php } if($post['signature'] && ($_G['setting']['bannedmessages'] & 4 && ($post['memberstatus'] == '-1' || ($post['authorid'] && !$post['username']) || ($post['groupid'] == 4 || $post['groupid'] == 5) || ($post['status'] & 1)))) { ?>

<div class="sign">签名被屏蔽</div>

<?php } elseif($post['signature'] && !$post['anonymous'] && $showsignatures) { ?>

<div class="sign" style="max-height:<?php echo $_G['setting']['maxsigrows'];?>px;maxHeightIE:<?php echo $_G['setting']['maxsigrows'];?>px;"><?php echo $post['signature'];?></div>

<?php } ?>

<?php if(!empty($_G['setting']['pluginhooks']['viewthread_postsightmlafter'][$postcount])) echo $_G['setting']['pluginhooks']['viewthread_postsightmlafter'][$postcount];?><?php echo adshow("thread/a_pb/1/$postcount");?></td>

</tr>

<?php if(!$_G['forum_thread']['archiveid']) { ?>

<tr>



<td class="plc">

<div class="po">

<?php if(!$post['first'] && $modmenu['post']) { ?>

<span class="y">

<label for="manage<?php echo $post['pid'];?>">

<input type="checkbox" id="manage<?php echo $post['pid'];?>" class="pc" <?php if(!empty($modclick)) { ?>checked="checked" <?php } ?>onclick="pidchecked(this);modclick(this, <?php echo $post['pid'];?>)" value="<?php echo $post['pid'];?>" autocomplete="off" />

管理

</label>

</span>

<?php } ?>

<div class="pob cl">

<em>

<?php if($post['invisible'] == 0) { if($allowpostreply && $post['allowcomment'] && (!$thread['closed'] || $_G['forum']['ismoderator'])) { ?><a class="cmmnt" href="forum.php?mod=misc&amp;action=comment&amp;tid=<?php echo $post['tid'];?>&amp;pid=<?php echo $post['pid'];?>&amp;extra=<?php echo $_GET['extra'];?>&amp;page=<?php echo $page;?><?php if($_G['forum_thread']['special'] == 127) { ?>&amp;special=<?php echo $specialextra;?><?php } ?>" onclick="showWindow('comment', this.href, 'get', 0)">点评</a><?php } if((!$_G['uid'] || $allowpostreply) && !$needhiddenreply) { if($post['first']) { ?>

<a class="fastre" href="forum.php?mod=post&amp;action=reply&amp;fid=<?php echo $_G['fid'];?>&amp;tid=<?php echo $_G['tid'];?>&amp;reppost=<?php echo $post['pid'];?>&amp;extra=<?php echo $_GET['extra'];?>&amp;page=<?php echo $page;?>" onclick="showWindow('reply', this.href)">回复</a>

<?php } else { ?>

<a class="fastre" href="forum.php?mod=post&amp;action=reply&amp;fid=<?php echo $_G['fid'];?>&amp;tid=<?php echo $_G['tid'];?>&amp;repquote=<?php echo $post['pid'];?>&amp;extra=<?php echo $_GET['extra'];?>&amp;page=<?php echo $page;?>" onclick="showWindow('reply', this.href)">回复</a>

<?php } } } if((($_G['forum']['ismoderator'] && $_G['group']['alloweditpost'] && (!in_array($post['adminid'], array(1, 2, 3)) || $_G['adminid'] <= $post['adminid'])) || ($_G['forum']['alloweditpost'] && $_G['uid'] && ($post['authorid'] == $_G['uid'] && $_G['forum_thread']['closed'] == 0) && !(!$alloweditpost_status && $edittimelimit && TIMESTAMP - $post['dbdateline'] > $edittimelimit)))) { ?>

<a class="editp" href="forum.php?mod=post&amp;action=edit&amp;fid=<?php echo $_G['fid'];?>&amp;tid=<?php echo $_G['tid'];?>&amp;pid=<?php echo $post['pid'];?><?php if(!empty($_GET['modthreadkey'])) { ?>&amp;modthreadkey=<?php echo $_GET['modthreadkey'];?><?php } ?>&amp;page=<?php echo $page;?>"><?php if($_G['forum_thread']['special'] == 2 && !$post['message']) { ?>添加柜台介绍<?php } else { ?>编辑</a><?php } } elseif($_G['uid'] && $post['authorid'] == $_G['uid'] && $_G['setting']['postappend']) { ?>

<a class="appendp" href="forum.php?mod=misc&amp;action=postappend&amp;tid=<?php echo $post['tid'];?>&amp;pid=<?php echo $post['pid'];?>&amp;extra=<?php echo $_GET['extra'];?>&amp;page=<?php echo $page;?>" onClick="showWindow('postappend', this.href, 'get', 0)">补充</a>

<?php } if($post['first'] && $post['invisible'] == -3) { ?>

<a class="psave" href="forum.php?mod=misc&amp;action=pubsave&amp;tid=<?php echo $_G['tid'];?>">发表</a>

<?php } if($post['invisible'] == -2 && !$post['first']) { ?>

<span class="xg1">(待审核)</span>

<?php } if($post['first'] && $allowblockrecommend) { ?><a class="push" href="javascript:;" onclick="modaction('recommend', '<?php echo $_G['forum_firstpid'];?>', 'op=recommend&idtype=<?php if($_G['forum_thread']['isgroup']) { ?>gtid<?php } else { ?>tid<?php } ?>&id=<?php echo $_G['tid'];?>&pid=<?php echo $post['pid'];?>', 'portal.php?mod=portalcp&ac=portalblock')">推送</a><?php } ?>

<?php if(!empty($_G['setting']['pluginhooks']['viewthread_postfooter'][$postcount])) echo $_G['setting']['pluginhooks']['viewthread_postfooter'][$postcount];?>

</em>



<p>

<?php if($post['invisible'] == 0) { if($_G['setting']['magicstatus']) { ?>

<a href="javascript:;" id="mgc_post_<?php echo $post['pid'];?>" onmouseover="showMenu(this.id)" class="showmenu">使用道具</a>

<?php } if($_G['forum_thread']['special'] == 3 && ($_G['forum']['ismoderator'] && (!$_G['setting']['rewardexpiration'] || $_G['setting']['rewardexpiration'] > 0 && ($_G['timestamp'] - $_G['forum_thread']['dateline']) / 86400 > $_G['setting']['rewardexpiration']) || $_G['forum_thread']['authorid'] == $_G['uid']) && $post['authorid'] != $_G['forum_thread']['authorid'] && $post['first'] == 0 && $_G['uid'] != $post['authorid'] && $_G['forum_thread']['price'] > 0) { ?>

<a href="javascript:;" onclick="setanswer(<?php echo $post['pid'];?>, '<?php echo $_GET['from'];?>')">最佳答案</a>

<?php } if(!$post['first'] && $_G['group']['raterange'] && $post['authorid']) { ?>

<a href="javascript:;" onclick="showWindow('rate', 'forum.php?mod=misc&action=rate&tid=<?php echo $_G['tid'];?>&pid=<?php echo $post['pid'];?>', 'get', -1);return false;">评分</a>

<?php } if(!empty($postlist[$post['pid']]['totalrate']) && $_G['forum']['ismoderator']) { ?>

<a href="forum.php?mod=misc&amp;action=removerate&amp;tid=<?php echo $_G['tid'];?>&amp;pid=<?php echo $post['pid'];?>&amp;page=<?php echo $page;?>" onclick="showWindow('rate', this.href, 'get', -1)">撤销评分</a>

<?php } if($post['authorid'] != $_G['uid']) { ?>

<a href="javascript:;" onclick="showWindow('miscreport<?php echo $post['pid'];?>', 'misc.php?mod=report&rtype=post&rid=<?php echo $post['pid'];?>&tid=<?php echo $_G['tid'];?>&fid=<?php echo $_G['fid'];?>', 'get', -1);return false;">举报</a>

<?php } } ?>

<?php if(!empty($_G['setting']['pluginhooks']['viewthread_postaction'][$postcount])) echo $_G['setting']['pluginhooks']['viewthread_postaction'][$postcount];?>

</p>



<?php if($_G['setting']['magicstatus']) { ?>

<ul id="mgc_post_<?php echo $post['pid'];?>_menu" class="p_pop mgcmn" style="display: none;">

<?php if($post['first']) { if(!empty($_G['setting']['magics']['bump'])) { ?>

<li><a href="home.php?mod=magic&amp;mid=bump&amp;idtype=tid&amp;id=<?php echo $_G['tid'];?>" id="a_bump" onclick="showWindow(this.id, this.href)"><img src="<?php echo STATICURL;?>image/magic/bump.small.gif" /><?php echo $_G['setting']['magics']['bump'];?></a></li>

<?php } if(!empty($_G['setting']['magics']['stick'])) { ?>

<li><a href="home.php?mod=magic&amp;mid=stick&amp;idtype=tid&amp;id=<?php echo $_G['tid'];?>" id="a_stick" onclick="showWindow(this.id, this.href)"><img src="<?php echo STATICURL;?>image/magic/stick.small.gif" /><?php echo $_G['setting']['magics']['stick'];?></a></li>

<?php } if(!empty($_G['setting']['magics']['close'])) { ?>

<li><a href="home.php?mod=magic&amp;mid=close&amp;idtype=tid&amp;id=<?php echo $_G['tid'];?>" id="a_stick" onclick="showWindow(this.id, this.href)"><img src="<?php echo STATICURL;?>image/magic/close.small.gif" /><?php echo $_G['setting']['magics']['close'];?></a></li>

<?php } if(!empty($_G['setting']['magics']['open'])) { ?>

<li><a href="home.php?mod=magic&amp;mid=open&amp;idtype=tid&amp;id=<?php echo $_G['tid'];?>" id="a_stick" onclick="showWindow(this.id, this.href)"><img src="<?php echo STATICURL;?>image/magic/open.small.gif" /><?php echo $_G['setting']['magics']['open'];?></a></li>

<?php } if(!empty($_G['setting']['magics']['highlight'])) { ?>

<li><a href="home.php?mod=magic&amp;mid=highlight&amp;idtype=tid&amp;id=<?php echo $_G['tid'];?>" id="a_stick" onclick="showWindow(this.id, this.href)"><img src="<?php echo STATICURL;?>image/magic/highlight.small.gif" /><?php echo $_G['setting']['magics']['highlight'];?></a></li>

<?php } if(!empty($_G['setting']['magics']['sofa'])) { ?>

<li><a href="home.php?mod=magic&amp;mid=sofa&amp;idtype=tid&amp;id=<?php echo $_G['tid'];?>" id="a_stick" onclick="showWindow(this.id, this.href)"><img src="<?php echo STATICURL;?>image/magic/sofa.small.gif" /><?php echo $_G['setting']['magics']['sofa'];?></a></li>

<?php } if(!empty($_G['setting']['magics']['jack'])) { ?>

<li><a href="home.php?mod=magic&amp;mid=jack&amp;idtype=tid&amp;id=<?php echo $_G['tid'];?>" id="a_jack" onclick="showWindow(this.id, this.href)"><img src="<?php echo STATICURL;?>image/magic/jack.small.gif" /><?php echo $_G['setting']['magics']['jack'];?></a></li>

<?php } ?>

<?php if(!empty($_G['setting']['pluginhooks']['viewthread_magic_thread'])) echo $_G['setting']['pluginhooks']['viewthread_magic_thread'];?>

<?php } if(!empty($_G['setting']['magics']['repent']) && $post['authorid'] == $_G['uid'] && !$rushreply) { ?>

<li><a href="home.php?mod=magic&amp;mid=repent&amp;idtype=pid&amp;id=<?php echo $post['pid'];?>:<?php echo $_G['tid'];?>" id="a_repent_<?php echo $post['pid'];?>" onclick="showWindow(this.id, this.href)"><img src="<?php echo STATICURL;?>image/magic/bump.small.gif" /><?php echo $_G['setting']['magics']['repent'];?></a></li>

<?php } if(!empty($_G['setting']['magics']['anonymouspost']) && $post['authorid'] == $_G['uid']) { ?>

<li><a href="home.php?mod=magic&amp;mid=anonymouspost&amp;idtype=pid&amp;id=<?php echo $post['pid'];?>:<?php echo $_G['tid'];?>" id="a_anonymouspost_<?php echo $post['pid'];?>" onclick="showWindow(this.id, this.href)"><img src="<?php echo STATICURL;?>image/magic/anonymouspost.small.gif" /><?php echo $_G['setting']['magics']['anonymouspost'];?></a><li>

<?php } if(!empty($_G['setting']['magics']['namepost'])) { ?>

<li><a href="home.php?mod=magic&amp;mid=namepost&amp;idtype=pid&amp;id=<?php echo $post['pid'];?>:<?php echo $_G['tid'];?>" id="a_namepost_<?php echo $post['pid'];?>" onclick="showWindow(this.id, this.href)"><img src="<?php echo STATICURL;?>image/magic/namepost.small.gif" /><?php echo $_G['setting']['magics']['namepost'];?></a><li>

<?php } ?>

<?php if(!empty($_G['setting']['pluginhooks']['viewthread_magic_post'][$postcount])) echo $_G['setting']['pluginhooks']['viewthread_magic_post'][$postcount];?>

</ul>

<script type="text/javascript" reload="1">checkmgcmn('post_<?php echo $post['pid'];?>')</script>

<?php } ?>

</div>

</div>

</td><td class="pls"></td>

</tr>

<?php } ?>

<tr class="ad">



<td class="plc">

<?php if($post['first'] && $_G['forum_thread']['special'] == 5 && $_G['forum_thread']['displayorder'] >= 0) { ?>

<ul class="ttp cl">

<li style="display:inline;margin-left:12px"><strong class="bw0 bg0_all">按立场筛选: </strong></li>

<li<?php if(!isset($_GET['stand'])) { ?> class="xw1 a"<?php } ?>><a href="forum.php?mod=viewthread&amp;tid=<?php echo $_G['tid'];?>&amp;extra=<?php echo $_GET['extra'];?>" hidefocus="true">全部</a></li>

<li<?php if($_GET['stand'] == 1) { ?> class="xw1 a"<?php } ?>><a href="forum.php?mod=viewthread&amp;tid=<?php echo $_G['tid'];?>&amp;extra=<?php echo $_GET['extra'];?>&amp;stand=1" hidefocus="true">正方</a></li>

<li<?php if($_GET['stand'] == 2) { ?> class="xw1 a"<?php } ?>><a href="forum.php?mod=viewthread&amp;tid=<?php echo $_G['tid'];?>&amp;extra=<?php echo $_GET['extra'];?>&amp;stand=2" hidefocus="true">反方</a></li>

<li<?php if(isset($_GET['stand']) && $_GET['stand'] == 0) { ?> class="xw1 a"<?php } ?>><a href="forum.php?mod=viewthread&amp;tid=<?php echo $_G['tid'];?>&amp;extra=<?php echo $_GET['extra'];?>&amp;stand=0" hidefocus="true">中立</a></li>

</ul>

<?php } if($_G['forum_thread']['replies']) { ?><?php echo adshow("interthread/a_p/$postcount");?><?php } ?>

</td>

</tr>

</table>

<?php if(!empty($aimgs[$post['pid']])) { ?>

<script type="text/javascript" reload="1">

aimgcount[<?php echo $post['pid'];?>] = [<?php echo dimplode($aimgs[$post['pid']]);; ?>];

attachimggroup(<?php echo $post['pid'];?>);

<?php if(empty($_G['setting']['lazyload'])) { if(!$post['imagelistthumb']) { ?>

attachimgshow(<?php echo $post['pid'];?>);

<?php } else { ?>

attachimgshow(<?php echo $post['pid'];?>, 1);

<?php } } ?>

var aimgfid = 0;

<?php if($_G['forum']['picstyle'] && ($_G['forum']['ismoderator'] || $_G['uid'] == $_G['thread']['authorid'])) { ?>

aimgfid = <?php echo $_G['fid'];?>;

<?php } if($post['imagelistthumb']) { ?>

attachimglstshow(<?php echo $post['pid'];?>, <?php echo intval($_G['setting']['lazyload']); ?>, aimgfid, '<?php echo $_G['setting']['showexif'];?>');

<?php } ?>

</script>

<?php } } else { ?>

<table id="pid<?php echo $post['pid'];?>" summary="pid<?php echo $post['pid'];?>" cellspacing="0" cellpadding="0">

<tbody>

<tr>

<td class="pls"></td>

<td class="plc">

<div class="pi">

<strong><a><?php if(!empty($postno[$post['number']])) { ?><?php echo $postno[$post['number']];?><?php } else { ?><em><?php echo $post['number'];?></em><?php echo $postno['0'];?><?php } ?></a></strong>

</div>

<div class="pct">无效楼层，该帖已经被删除</div>

</td>

</tr>

<tr class="ad"><td class="pls"></td><td class="plc"></td></tr>

</tbody>

</table>

<?php } ?>

<?php if(!empty($_G['setting']['pluginhooks']['viewthread_endline'][$postcount])) echo $_G['setting']['pluginhooks']['viewthread_endline'][$postcount];?>