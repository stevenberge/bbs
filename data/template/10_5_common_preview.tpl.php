<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="data/cache/style_<?php echo $_GET['styleid'];?>_common.css?<?php echo VERHASH;?>" />
<style type="text/css">
body { padding: 10px; }
.premsg { padding: 5px; background-color: <?php echo $_G['style']['commonbg'];?>; }
.xst { font-family: <?php echo $_G['style']['threadtitlefont'];?>; font-size: <?php echo $_G['style']['threadtitlefontsize'];?>; }
#ft { padding: 10px; text-align: center; }
</style>
</head>
<body>

<div id="hd" class="mbm">
<div class="hdc cl">
<h2><?php echo $_G['style']['boardlogo'];?></h2>
<div id="um">
<div class="avt y"><?php echo avatar($_G['member'],small);?></div>
<p><strong><a href="#"><?php echo $_G['member']['username'];?></a></strong><span class="xg1"> <a href="#">����</a></span><span class="pipe">|</span><a href="#">��Ϣ</a></p>
<p>����<span class="pipe">|</span>�û���</p>
</div>
</div>
<div id="nv">
<ul>
<li><a href="#"><?php echo $_G['setting']['navs']['1']['navname'];?><span>Home</span></a></li>
<li><a href="#"><?php echo $_G['setting']['navs']['2']['navname'];?><span>BBS</span></a></li>
<li><a href="#"><?php echo $_G['setting']['navs']['3']['navname'];?><span>Group</span></a></li>
<li><a href="#"><?php echo $_G['setting']['navs']['4']['navname'];?><span>Space</span></a></li>
</ul>
</div>
</div>

<div class="bm">
<div class="bm_h cl">
<h2>��ͷ</h2>
</div>
<div class="bm_c">
<div class="premsg"><a href="javascript:;" class="xi2">Crossday Discuz! Board</a> ����ϵͳ(��� <stong class="xw1 xi1">Discuz!</stong>)��һ������ PHP �� MySQL �������������ݿ⹹���ĸ�Ч��վ���������</div>
<table class="dt">
<tr>
<td class="xs0">SMALL FONT</td>
<td><a href="javascript:;">��������</a></td>
<td><a href="javascript:;" class="xi2">��������</a></td>
</tr>
<tr>
<td>��ͨ�ı�</td>
<td class="xg2">�е��ı�</td>
<td class="xg1">ǳɫ����</td>
</tr>
<tr class="bw0_all">
<td colspan="3" class="xst">�����б�����</td>
</tr>
</table>
</div>
</div>

<div id="ft">
��Ȩ��ҳ����Ϣ
</div>

</body>
</html>