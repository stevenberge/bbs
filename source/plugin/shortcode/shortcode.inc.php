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
include_once DISCUZ_ROOT.'./source/plugin/shortcode/class_qrcode.php';
include_once DISCUZ_ROOT.'./source/plugin/shortcode/class_check.php';

$config = $_G['cache']['plugin']['shortcode'];
$uuid = !empty($config['uuid']) ? "?uid=".$config['uuid'] : '';
$jiathis = lang('plugin/shortcode','jiathis',array('uuid' => $uuid));

$navtitle = lang('plugin/shortcode', 'shortcode');
$diy = lang('plugin/shortcode', 'diy');

$actionarr = array('index', 'bookmark', 'email', 'ms', 'vcard','short','long', 'page', 'attach');
$action = in_array($_G['gp_action'], $actionarr) ? $_G['gp_action'] : 'index';
$view = $_G['gp_view'];
$size = '120';
$EC_level = 'L';
$qr = new class_qrcode();
$ch = new class_check();
$config['shortads'] = nl2br($nhbxw['shortads']);

if(!$_G['uid'] && !$config['guest']){ //判断用户及游客开关
        showmessage('to_login', 'member.php?mod=logging&action=login', array(), array('showmsg' => true, 'login' => 1));
}

if($action == 'page'){  //页面二维码 
        $this_url = $_SERVER['HTTP_REFERER'];
        $qr->link($this_url);        
        $long_url = $qr->get_link($size,$EC_level); 
        $short_url = shortenGoogleUrl($this_url);
        $config['pageads'] = nl2br($config['pageads']);
        include template('shortcode:float');        
}elseif($action == 'attach'){  //附件二维码
        $_G['gp_aid']=$_G['gp_aid']?$_G['gp_aid']:$_G['gp_amp;aid'];
        @list($aid) = explode('|', base64_decode($_G['gp_aid']));
        $this_url = $_G['siteurl'].'forum.php?mod=attachment&aid='.$_G['gp_aid'];
        $qr->link($this_url);
        $long_url = $qr->get_link($size,$EC_level); 
        $short_url = shortenGoogleUrl($this_url);
        $tableid = DB::result_first("SELECT tableid FROM ".DB::table('forum_attachment')." WHERE aid='$aid'");
        $attach = DB::fetch_first("SELECT filename FROM ".DB::table('forum_attachment_'.$tableid)." WHERE aid='$aid'");
        $config['attachads'] = nl2br($nhbxw['attachads']);
        include template('shortcode:float');
}elseif($action == 'index'){ //文本内容   
        if(!empty($view)){//分享浏览页
                $short_url = 'http://goo.gl/'.$view;
                $long_url = expandGoogleUrl($short_url);
                $back = $qr->back_link($long_url);
                $size = $back[0];
                $EC_level = $back[1];
                $texter = $back[2];
                $text_cut = cutstr(DeleteHtml($texter), 70, '...');
                $summary = $text_cut;
                $tqqtitle = lang('plugin/shortcode', 'tqqtitle');
                $sharetitle = $_G[setting][bbname].$navtitle.' - '.lang('plugin/shortcode', 'text');
                
        }else{  //生成页  
                $texter = $diy;
                $url_this = 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI'];//当前页URL
                $qr->link($url_this);                                
                $long_url = $qr->get_link($size,$EC_level); 
                $short_url = shortenGoogleUrl($long_url);
                $share = $_G['siteurl'].'plugin.php?id=shortcode';//本插件URL
                $summary = lang('plugin/shortcode', 'summary');
                $tqqtitle = lang('plugin/shortcode', 'dtqqtitle');
                $sharetitle = $_G[setting][bbname].' - '.$navtitle;
                if(submitcheck('codesubmit')) {  //检查是否提交
                        $texter = trim(dhtmlspecialchars($_G['gp_text']));
                        $text = $texter == $diy ? null : $texter;
                        if(empty($text)){  //检查输入内容
                                echo '<script type="text/javascript">'; 
                                echo 'parent.document.getElementById(\'code\').innerHTML=\'<img src="source/plugin/shortcode/images/sorry.gif" />\';'; 
                                echo 'parent.document.getElementById(\'vct\').innerHTML=\''.lang('plugin/shortcode', 'error_tips').'\';';
                                echo 'parent.document.getElementById(\'short\').innerHTML=\'<p class=rq>'.lang('plugin/shortcode', 'error_empty').'</p>\';';
                                echo 'parent.document.getElementById(\'down\').style.display=\'none\';';
                                echo '</script>';                                  
                        }elseif(!$ch->islen($text)){  //检查内容长度
                                echo '<script type="text/javascript">'; 
                                echo 'parent.document.getElementById(\'code\').innerHTML=\'<img src="source/plugin/shortcode/images/sorry.gif" />\';'; 
                                echo 'parent.document.getElementById(\'vct\').innerHTML=\''.lang('plugin/shortcode', 'error_tips').'\';';
                                echo 'parent.document.getElementById(\'short\').innerHTML=\'<p class=rq>'.lang('plugin/shortcode', 'error_len').'</p>\';';
                                echo 'parent.document.getElementById(\'down\').style.display=\'none\';';
                                echo '</script>';   
                        }else{
                                $text_cut = cutstr(DeleteHtml($text), 70, '...');
                                $qr->text($text);
                                $size = $_G['gp_size'];
                                $EC_level = $_G['gp_EC_level'];       
                                if($_G['gp_command'] == 'down'){  //下载二维码
                                        $file = $qr->get_image($size,$EC_level);
                                        $qr->download_image($file);        
                                }else{  //生成二维码
                                        $long_url = $qr->get_link($size,$EC_level); 
                                        $short_url = shortenGoogleUrl($long_url);
                                        $view = substr($short_url,14);
                                        $share = $_G['siteurl'].'plugin.php?id=shortcode&action='.$action.'&view='.$view;
                                        $summary = $text_cut;
                                        $tqqtitle = lang('plugin/shortcode', 'tqqtitle');
                                        $sharetitle = $_G[setting][bbname].' - '.$navtitle.' - '.lang('plugin/shortcode', 'text');
                                        $copyfunc = "javascript:this.select();setCopy(this.value, \'".lang('plugin/shortcode', 'success_tips')."\');";
                                        $short = '<input type="text" class="px vm" onclick="'.$copyfunc.'"  style="width:150px;" readonly="readonly" tabIndex="1" value="'.$short_url.'" />';
                                        $code = '<img src="'.$long_url.'" style="border: 1px solid #FFF;padding:5px;"/>'
                                                .'<p style="color:#FEFEE9"><strong>'.lang('plugin/shortcode', 'text').'</strong></p><p>'.$text_cut.'</p>';
                                        echo '<script type="text/javascript">';
                                        echo 'window.parent.frames.showPrompt(\'\', \'\', \'<span>'.lang('plugin/shortcode', 'success_made').'</span>\', 2000);';
                                        echo 'parent.document.getElementById(\'vct\').innerHTML=\''.lang('plugin/shortcode', 'tips').'\';'; 
                                        echo 'parent.document.getElementById(\'down\').style.display=\'\';';                     
                                        echo 'parent.document.getElementById(\'code\').innerHTML=\''.$code.'\';'; 
                                        echo 'parent.document.getElementById(\'short\').innerHTML=\''.$short.'\';';                                        
                                        echo '</script>';        
                                }
                        }
                        $sharecode = 'var jiathis_config={data_track_clickback:true,url:"'.$share.'",summary:"'.$summary.'", title:"'.$sharetitle.'#'.$tqqtitle.'#", pic:"'.$short_url.'",appkey:{"tqq":"'.$config['tqq'].'"},hideMore:false}'; 
                        echo "<script>window.onload=function(){ var script=parent.document.createElement('script'); script.type='text/javascript';  script.text='".$sharecode."';  var sharecode=parent.document.getElementsByTagName('head')[0]; sharecode.appendChild(script);};</script>"; 
                        exit(0);
                }
        }
        include template('shortcode:shortcode');
}elseif($action == 'bookmark'){ //网络书签   
        if(!empty($view)){//分享浏览页
                $short_url = 'http://goo.gl/'.$view;
                $long_url = expandGoogleUrl($short_url);
                $back = $qr->back_link($long_url);
                $size = $back[0];
                $EC_level = $back[1];
                $value = explode(";",ltrim(strstr($back[2],':'),':'));
                $title = ltrim(strstr($value[0],':'),':');
                $url = ltrim(strstr($value[1],':'),':');
                $text_cut = $title.'<br/>'.$url;
                $summary = $title.' | '.$url;
                $tqqtitle = lang('plugin/shortcode', 'tqqtitle');
                $sharetitle = $_G[setting][bbname].$navtitle.' - '.lang('plugin/shortcode', 'bookmark');
                
        }else{  //生成页  
                $texter = $diy;
                $url_this = 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI'];//当前页URL
                $qr->link($url_this);                                
                $long_url = $qr->get_link($size,$EC_level); 
                $short_url = shortenGoogleUrl($long_url);
                $share = $_G['siteurl'].'plugin.php?id=shortcode';//本插件URL
                $summary = lang('plugin/shortcode', 'summary');
                $tqqtitle = lang('plugin/shortcode', 'dtqqtitle');
                $sharetitle = $_G[setting][bbname].' - '.$navtitle;
                if(submitcheck('codesubmit')) {  //检查是否提交
                        $title = trim($_G['gp_title']);
                        $url = trim($_G['gp_url']);
                        if(empty($title) || empty($url)){  //检查输入内容
                                echo '<script type="text/javascript">'; 
                                echo 'parent.document.getElementById(\'code\').innerHTML=\'<img src="source/plugin/shortcode/images/sorry.gif" />\';'; 
                                echo 'parent.document.getElementById(\'vct\').innerHTML=\''.lang('plugin/shortcode', 'error_tips').'\';';
                                echo 'parent.document.getElementById(\'short\').innerHTML=\'<p class=rq>'.lang('plugin/shortcode', 'error_empty').'</p>\';';
                                echo 'parent.document.getElementById(\'down\').style.display=\'none\';';
                                echo '</script>';                                  
                        }elseif(!$ch->isname($title)){  //检查名称
                                echo '<script type="text/javascript">'; 
                                echo 'parent.document.getElementById(\'code\').innerHTML=\'<img src="source/plugin/shortcode/images/sorry.gif" />\';'; 
                                echo 'parent.document.getElementById(\'vct\').innerHTML=\''.lang('plugin/shortcode', 'error_tips').'\';';
                                echo 'parent.document.getElementById(\'short\').innerHTML=\'<p class=rq>'.lang('plugin/shortcode', 'error_name').'</p>\';';
                                echo 'parent.document.getElementById(\'down\').style.display=\'none\';';
                                echo '</script>';   
                        }elseif(!$ch->isurl($url)){  //检查URL
                                echo '<script type="text/javascript">'; 
                                echo 'parent.document.getElementById(\'code\').innerHTML=\'<img src="source/plugin/shortcode/images/sorry.gif" />\';'; 
                                echo 'parent.document.getElementById(\'vct\').innerHTML=\''.lang('plugin/shortcode', 'error_tips').'\';';
                                echo 'parent.document.getElementById(\'short\').innerHTML=\'<p class=rq>'.lang('plugin/shortcode', 'error_url').'</p>\';';
                                echo 'parent.document.getElementById(\'down\').style.display=\'none\';';
                                echo '</script>';   
                        }else{
                                $text_cut = $title.'<br/>'.$url;
                                $qr->bookmark($title,$url);
                                $size = $_G['gp_size'];
                                $EC_level = $_G['gp_EC_level'];       
                                if($_G['gp_command'] == 'down'){  //下载二维码
                                        $file = $qr->get_image($size,$EC_level);
                                        $qr->download_image($file);        
                                }else{  //生成二维码
                                        $long_url = $qr->get_link($size,$EC_level); 
                                        $short_url = shortenGoogleUrl($long_url);
                                        $view = substr($short_url,14);
                                        $share = $_G['siteurl'].'plugin.php?id=shortcode&action='.$action.'&view='.$view;
                                        $summary = $title.' | '.$url;
                                        $tqqtitle = lang('plugin/shortcode', 'tqqtitle');
                                        $sharetitle = $_G[setting][bbname].' - '.$navtitle.' - '.lang('plugin/shortcode', 'bookmark');
                                        $copyfunc = "javascript:this.select();setCopy(this.value, \'".lang('plugin/shortcode', 'success_tips')."\');";
                                        $short = '<input type="text" class="px vm" onclick="'.$copyfunc.'"  style="width:150px;" readonly="readonly" tabIndex="1" value="'.$short_url.'" />';
                                        $code = '<img src="'.$long_url.'" style="border: 1px solid #FFF;padding:5px;"/>'
                                                .'<p style="color:#FEFEE9"><strong>'.lang('plugin/shortcode', 'bookmark').'</strong></p><p>'.$text_cut.'</p>';
                                        echo '<script type="text/javascript">';
                                        echo 'window.parent.frames.showPrompt(\'\', \'\', \'<span>'.lang('plugin/shortcode', 'success_made').'</span>\', 2000);';
                                        echo 'parent.document.getElementById(\'vct\').innerHTML=\''.lang('plugin/shortcode', 'tips').'\';'; 
                                        echo 'parent.document.getElementById(\'down\').style.display=\'\';';                     
                                        echo 'parent.document.getElementById(\'code\').innerHTML=\''.$code.'\';'; 
                                        echo 'parent.document.getElementById(\'short\').innerHTML=\''.$short.'\';';                                        
                                        echo '</script>';        
                                }
                        }
                        $sharecode = 'var jiathis_config={data_track_clickback:true,url:"'.$share.'",summary:"'.$summary.'", title:"'.$sharetitle.'#'.$tqqtitle.'#", pic:"'.$short_url.'",appkey:{"tqq":"'.$config['tqq'].'"},hideMore:false}'; 
                        echo "<script>window.onload=function(){ var script=parent.document.createElement('script'); script.type='text/javascript';  script.text='".$sharecode."';  var sharecode=parent.document.getElementsByTagName('head')[0]; sharecode.appendChild(script);};</script>"; 
                        exit(0);
                }
        }
        include template('shortcode:shortcode');
}elseif($action == 'email'){ //电子邮件   
        if(!empty($view)){//分享浏览页
                $short_url = 'http://goo.gl/'.$view;
                $long_url = expandGoogleUrl($short_url);
                $back = $qr->back_link($long_url);
                $size = $back[0];
                $EC_level = $back[1];
                $value = explode(";",ltrim(strstr($back[2],':'),':'));
                $email = ltrim(strstr($value[0],':'),':');
                $subject = ltrim(strstr($value[1],':'),':');
                $message = ltrim(strstr($value[2],':'),':');
                $text_cut = $email.'<br/>'.$subject.'<br/>'.$message;
                $summary = $email.' | '.$subject.' | '.$message;
                $tqqtitle = lang('plugin/shortcode', 'tqqtitle');
                $sharetitle = $_G[setting][bbname].$navtitle.' - '.lang('plugin/shortcode', 'email');
                
        }else{  //生成页  
                $texter = $diy;
                $url_this = 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI'];//当前页URL
                $qr->link($url_this);                                
                $long_url = $qr->get_link($size,$EC_level); 
                $short_url = shortenGoogleUrl($long_url);
                $share = $_G['siteurl'].'plugin.php?id=shortcode';//本插件URL
                $summary = lang('plugin/shortcode', 'summary');
                $tqqtitle = lang('plugin/shortcode', 'dtqqtitle');
                $sharetitle = $_G[setting][bbname].' - '.$navtitle;
                if(submitcheck('codesubmit')) {  //检查是否提交
                        $email = trim($_G['gp_email']);
                        $subject = trim($_G['gp_subject']);
                        $message = trim($_G['gp_message']);
                        if(empty($email) || empty($subject) || empty($message)){  //检查输入内容
                                echo '<script type="text/javascript">'; 
                                echo 'parent.document.getElementById(\'code\').innerHTML=\'<img src="source/plugin/shortcode/images/sorry.gif" />\';'; 
                                echo 'parent.document.getElementById(\'vct\').innerHTML=\''.lang('plugin/shortcode', 'error_tips').'\';';
                                echo 'parent.document.getElementById(\'short\').innerHTML=\'<p class=rq>'.lang('plugin/shortcode', 'error_empty').'</p>\';';
                                echo 'parent.document.getElementById(\'down\').style.display=\'none\';';
                                echo '</script>';                                  
                        }elseif(!$ch->isemail($email)){  //检查邮件
                                echo '<script type="text/javascript">'; 
                                echo 'parent.document.getElementById(\'code\').innerHTML=\'<img src="source/plugin/shortcode/images/sorry.gif" />\';'; 
                                echo 'parent.document.getElementById(\'vct\').innerHTML=\''.lang('plugin/shortcode', 'error_tips').'\';';
                                echo 'parent.document.getElementById(\'short\').innerHTML=\'<p class=rq>'.lang('plugin/shortcode', 'error_email').'</p>\';';
                                echo 'parent.document.getElementById(\'down\').style.display=\'none\';';
                                echo '</script>';   
                        }else{
                                $text_cut = $email.'<br/>'.$subject.'<br/>'.$message;
                                $qr->email($email,$subject,$message);
                                $size = $_G['gp_size'];
                                $EC_level = $_G['gp_EC_level'];       
                                if($_G['gp_command'] == 'down'){  //下载二维码
                                        $file = $qr->get_image($size,$EC_level);
                                        $qr->download_image($file);        
                                }else{  //生成二维码
                                        $long_url = $qr->get_link($size,$EC_level); 
                                        $short_url = shortenGoogleUrl($long_url);
                                        $view = substr($short_url,14);
                                        $share = $_G['siteurl'].'plugin.php?id=shortcode&action='.$action.'&view='.$view;
                                        $summary = $email.' | '.$subject.' | '.$message;
                                        $tqqtitle = lang('plugin/shortcode', 'tqqtitle');
                                        $sharetitle = $_G[setting][bbname].' - '.$navtitle.' - '.lang('plugin/shortcode', 'email');
                                        $copyfunc = "javascript:this.select();setCopy(this.value, \'".lang('plugin/shortcode', 'success_tips')."\');";
                                        $short = '<input type="text" class="px vm" onclick="'.$copyfunc.'"  style="width:150px;" readonly="readonly" tabIndex="1" value="'.$short_url.'" />';
                                        $code = '<img src="'.$long_url.'" style="border: 1px solid #FFF;padding:5px;"/>'
                                                .'<p style="color:#FEFEE9"><strong>'.lang('plugin/shortcode', 'email').'</strong></p><p>'.$text_cut.'</p>';
                                        echo '<script type="text/javascript">';
                                        echo 'window.parent.frames.showPrompt(\'\', \'\', \'<span>'.lang('plugin/shortcode', 'success_made').'</span>\', 2000);';
                                        echo 'parent.document.getElementById(\'vct\').innerHTML=\''.lang('plugin/shortcode', 'tips').'\';'; 
                                        echo 'parent.document.getElementById(\'down\').style.display=\'\';';                     
                                        echo 'parent.document.getElementById(\'code\').innerHTML=\''.$code.'\';'; 
                                        echo 'parent.document.getElementById(\'short\').innerHTML=\''.$short.'\';';                                        
                                        echo '</script>';        
                                }
                        }
                        $sharecode = 'var jiathis_config={data_track_clickback:true,url:"'.$share.'",summary:"'.$summary.'", title:"'.$sharetitle.'#'.$tqqtitle.'#", pic:"'.$short_url.'",appkey:{"tqq":"'.$config['tqq'].'"},hideMore:false}'; 
                        echo "<script>window.onload=function(){ var script=parent.document.createElement('script'); script.type='text/javascript';  script.text='".$sharecode."';  var sharecode=parent.document.getElementsByTagName('head')[0]; sharecode.appendChild(script);};</script>"; 
                        exit(0);
                }
        }
        include template('shortcode:shortcode');
}elseif($action == 'ms'){ //短信&彩信   
        if(!empty($view)){//分享浏览页
                $short_url = 'http://goo.gl/'.$view;
                $long_url = expandGoogleUrl($short_url);
                $back = $qr->back_link($long_url);
                $size = $back[0];
                $EC_level = $back[1];
                $value = explode(":",$back[2]);
                $mstype = substr($value[0],0,3); 
                $phone = $value[1];
                $text = $value[2];
                $text_cut = $phone.'<br/>'.$text;
                $summary = $phone.' | '.$text;
                $tqqtitle = lang('plugin/shortcode', 'tqqtitle');
                $sharetitle = $_G[setting][bbname].$navtitle.' - '.lang('plugin/shortcode', 'ms');
                
        }else{  //生成页  
                $texter = $diy;
                $mstype = 'SMS';
                $url_this = 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI'];//当前页URL
                $qr->link($url_this);                                
                $long_url = $qr->get_link($size,$EC_level); 
                $short_url = shortenGoogleUrl($long_url);
                $share = $_G['siteurl'].'plugin.php?id=shortcode';//本插件URL
                $summary = lang('plugin/shortcode', 'summary');
                $tqqtitle = lang('plugin/shortcode', 'dtqqtitle');
                $sharetitle = $_G[setting][bbname].' - '.$navtitle;
                if(submitcheck('codesubmit')) {  //检查是否提交
                        $phone = trim($_G['gp_phone']);
                        $text = trim($_G['gp_text']);
                        $mstype = trim($_G['gp_mstype']);
                        if(empty($phone) || empty($text)){  //检查输入内容
                                echo '<script type="text/javascript">'; 
                                echo 'parent.document.getElementById(\'code\').innerHTML=\'<img src="source/plugin/shortcode/images/sorry.gif" />\';'; 
                                echo 'parent.document.getElementById(\'vct\').innerHTML=\''.lang('plugin/shortcode', 'error_tips').'\';';
                                echo 'parent.document.getElementById(\'short\').innerHTML=\'<p class=rq>'.lang('plugin/shortcode', 'error_empty').'</p>\';';
                                echo 'parent.document.getElementById(\'down\').style.display=\'none\';';
                                echo '</script>';                                  
                        }elseif(!$ch->isphone($phone) && !$ch->ismobile($phone)){  //检查号码
                                echo '<script type="text/javascript">'; 
                                echo 'parent.document.getElementById(\'code\').innerHTML=\'<img src="source/plugin/shortcode/images/sorry.gif" />\';'; 
                                echo 'parent.document.getElementById(\'vct\').innerHTML=\''.lang('plugin/shortcode', 'error_tips').'\';';
                                echo 'parent.document.getElementById(\'short\').innerHTML=\'<p class=rq>'.lang('plugin/shortcode', 'error_phone').'</p>\';';
                                echo 'parent.document.getElementById(\'down\').style.display=\'none\';';
                                echo '</script>';   
                        }else{
                                $text_cut = $phone.'<br/>'.$text;
                                if($mstype == "SMS"){     
                                        $qr->sms($phone,$text);
                                }else{
                                        $qr->mms($phone,$text);
                                }        
                                $size = $_G['gp_size'];
                                $EC_level = $_G['gp_EC_level'];       
                                if($_G['gp_command'] == 'down'){  //下载二维码
                                        $file = $qr->get_image($size,$EC_level);
                                        $qr->download_image($file);        
                                }else{  //生成二维码
                                        $long_url = $qr->get_link($size,$EC_level); 
                                        $short_url = shortenGoogleUrl($long_url);
                                        $view = substr($short_url,14);
                                        $share = $_G['siteurl'].'plugin.php?id=shortcode&action='.$action.'&view='.$view;
                                        $summary = $phone.' | '.$text;
                                        $tqqtitle = lang('plugin/shortcode', 'tqqtitle');
                                        $sharetitle = $_G[setting][bbname].' - '.$navtitle.' - '.lang('plugin/shortcode', 'ms');
                                        $copyfunc = "javascript:this.select();setCopy(this.value, \'".lang('plugin/shortcode', 'success_tips')."\');";
                                        $short = '<input type="text" class="px vm" onclick="'.$copyfunc.'"  style="width:150px;" readonly="readonly" tabIndex="1" value="'.$short_url.'" />';
                                        $code = '<img src="'.$long_url.'" style="border: 1px solid #FFF;padding:5px;"/>'
                                                .'<p style="color:#FEFEE9"><strong>'.lang('plugin/shortcode', 'ms').'</strong></p><p>'.$text_cut.'</p>';
                                        echo '<script type="text/javascript">';
                                        echo 'window.parent.frames.showPrompt(\'\', \'\', \'<span>'.lang('plugin/shortcode', 'success_made').'</span>\', 2000);';
                                        echo 'parent.document.getElementById(\'vct\').innerHTML=\''.lang('plugin/shortcode', 'tips').'\';'; 
                                        echo 'parent.document.getElementById(\'down\').style.display=\'\';';                     
                                        echo 'parent.document.getElementById(\'code\').innerHTML=\''.$code.'\';'; 
                                        echo 'parent.document.getElementById(\'short\').innerHTML=\''.$short.'\';';                                        
                                        echo '</script>';        
                                }
                        }
                        $sharecode = 'var jiathis_config={data_track_clickback:true,url:"'.$share.'",summary:"'.$summary.'", title:"'.$sharetitle.'#'.$tqqtitle.'#", pic:"'.$short_url.'",appkey:{"tqq":"'.$config['tqq'].'"},hideMore:false}'; 
                        echo "<script>window.onload=function(){ var script=parent.document.createElement('script'); script.type='text/javascript';  script.text='".$sharecode."';  var sharecode=parent.document.getElementsByTagName('head')[0]; sharecode.appendChild(script);};</script>"; 
                        exit(0);
                }
        }
        include template('shortcode:shortcode');
}elseif($action == 'vcard'){ //联系人   
        if(!empty($view)){  //分享浏览页
                $short_url = 'http://goo.gl/'.$view;
                $long_url = expandGoogleUrl($short_url);
                $back = $qr->back_link($long_url);
                $size = $back[0];
                $EC_level = $back[1];
                $value = explode("\n",$back[2]);
                $name = ltrim(strstr($value[2],':'),':');
                $phone = ltrim(strstr($value[3],':'),':');
                $email = ltrim(strstr($value[4],':'),':');
                $title = ltrim(strstr($value[5],':'),':');
                $url = ltrim(strstr($value[6],':'),':');
                $org = ltrim(strstr($value[7],':'),':');
                $address = ltrim(strstr($value[8],':'),':');
                $note = ltrim(strstr($value[9],':'),':');
                $text_cut = $name.'<br/>'.$phone.'<br/>'.$email;
                $summary = $name.' | '.$phone.' | '.$email.' | '.$title.' | '.$url.' | '.$org.' | '.$address.' | '.$note;
                $tqqtitle = lang('plugin/shortcode', 'tqqtitle');
                $sharetitle = $_G[setting][bbname].$navtitle.' - '.lang('plugin/shortcode', 'vcard');
                
        }else{  //生成页  
                $texter = $diy;
                $url_this = 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI'];//当前页URL
                $qr->link($url_this);                                
                $long_url = $qr->get_link($size,$EC_level); 
                $short_url = shortenGoogleUrl($long_url);
                $share = $_G['siteurl'].'plugin.php?id=shortcode';//本插件URL
                $summary = lang('plugin/shortcode', 'summary');
                $tqqtitle = lang('plugin/shortcode', 'dtqqtitle');
                $sharetitle = $_G[setting][bbname].' - '.$navtitle;
                if(submitcheck('codesubmit')) {  //检查是否提交
                        $name = trim($_G['gp_name']);
                        $phone = trim($_G['gp_phone']);
                        $title = trim($_G['gp_title']);
                        $email = trim($_G['gp_email']);
                        $url = trim($_G['gp_url']);
                        $org = trim($_G['gp_org']);
                        $address = trim($_G['gp_address']);
                        $note = trim($_G['gp_note']);
                        if(empty($name) || empty($phone)){  //检查输入内容
                                echo '<script type="text/javascript">'; 
                                echo 'parent.document.getElementById(\'code\').innerHTML=\'<img src="source/plugin/shortcode/images/sorry.gif" />\';'; 
                                echo 'parent.document.getElementById(\'vct\').innerHTML=\''.lang('plugin/shortcode', 'error_tips').'\';';
                                echo 'parent.document.getElementById(\'short\').innerHTML=\'<p class=rq>'.lang('plugin/shortcode', 'error_empty').'</p>\';';
                                echo 'parent.document.getElementById(\'down\').style.display=\'none\';';
                                echo '</script>';                                  
                        }elseif(!$ch->isname($name)){  //检查姓名
                                echo '<script type="text/javascript">'; 
                                echo 'parent.document.getElementById(\'code\').innerHTML=\'<img src="source/plugin/shortcode/images/sorry.gif" />\';'; 
                                echo 'parent.document.getElementById(\'vct\').innerHTML=\''.lang('plugin/shortcode', 'error_tips').'\';';
                                echo 'parent.document.getElementById(\'short\').innerHTML=\'<p class=rq>'.lang('plugin/shortcode', 'error_name').'</p>\';';
                                echo 'parent.document.getElementById(\'down\').style.display=\'none\';';
                                echo '</script>';   
                        }elseif(!$ch->isphone($phone) && !$ch->ismobile($phone)){  //检查电话
                                echo '<script type="text/javascript">'; 
                                echo 'parent.document.getElementById(\'code\').innerHTML=\'<img src="source/plugin/shortcode/images/sorry.gif" />\';'; 
                                echo 'parent.document.getElementById(\'vct\').innerHTML=\''.lang('plugin/shortcode', 'error_tips').'\';';
                                echo 'parent.document.getElementById(\'short\').innerHTML=\'<p class=rq>'.lang('plugin/shortcode', 'error_phone').'</p>\';';
                                echo 'parent.document.getElementById(\'down\').style.display=\'none\';';
                                echo '</script>';   
                        }elseif(!empty($email) && !$ch->isemail($email)){  //检查邮件
                                echo '<script type="text/javascript">'; 
                                echo 'parent.document.getElementById(\'code\').innerHTML=\'<img src="source/plugin/shortcode/images/sorry.gif" />\';'; 
                                echo 'parent.document.getElementById(\'vct\').innerHTML=\''.lang('plugin/shortcode', 'error_tips').'\';';
                                echo 'parent.document.getElementById(\'short\').innerHTML=\'<p class=rq>'.lang('plugin/shortcode', 'error_email').'</p>\';';
                                echo 'parent.document.getElementById(\'down\').style.display=\'none\';';
                                echo '</script>';   
                        }elseif(!empty($url) && !$ch->isurl($url)){  //检查网址
                                echo '<script type="text/javascript">'; 
                                echo 'parent.document.getElementById(\'code\').innerHTML=\'<img src="source/plugin/shortcode/images/sorry.gif" />\';'; 
                                echo 'parent.document.getElementById(\'vct\').innerHTML=\''.lang('plugin/shortcode', 'error_tips').'\';';
                                echo 'parent.document.getElementById(\'short\').innerHTML=\'<p class=rq>'.lang('plugin/shortcode', 'error_url').'</p>\';';
                                echo 'parent.document.getElementById(\'down\').style.display=\'none\';';
                                echo '</script>';   
                        }else{
                                $text_cut = $name.'<br/>'.$phone.'<br/>'.$email;
                                $qr->vcard($name, $phone,$email,$title,$url,$org,$address,$note);
                                $size = $_G['gp_size'];
                                $EC_level = $_G['gp_EC_level'];       
                                if($_G['gp_command'] == 'down'){  //下载二维码
                                        $file = $qr->get_image($size,$EC_level);
                                        $qr->download_image($file);        
                                }else{  //生成二维码
                                        $long_url = $qr->get_link($size,$EC_level); 
                                        $short_url = shortenGoogleUrl($long_url);
                                        $view = substr($short_url,14);
                                        $share = $_G['siteurl'].'plugin.php?id=shortcode&action='.$action.'&view='.$view;
                                        $summary = $name.' | '.$phone.' | '.$email.' | '.$title.' | '.$url.' | '.$org.' | '.$address.' | '.$note;
                                        $tqqtitle = lang('plugin/shortcode', 'tqqtitle');
                                        $sharetitle = $_G[setting][bbname].' - '.$navtitle.' - '.lang('plugin/shortcode', 'vcard');
                                        $copyfunc = "javascript:this.select();setCopy(this.value, \'".lang('plugin/shortcode', 'success_tips')."\');";
                                        $short = '<input type="text" class="px vm" onclick="'.$copyfunc.'"  style="width:150px;" readonly="readonly" tabIndex="1" value="'.$short_url.'" />';
                                        $code = '<img src="'.$long_url.'" style="border: 1px solid #FFF;padding:5px;"/>'
                                                .'<p style="color:#FEFEE9"><strong>'.lang('plugin/shortcode', 'vcard').'</strong></p><p>'.$text_cut.'</p>';
                                        echo '<script type="text/javascript">';
                                        echo 'window.parent.frames.showPrompt(\'\', \'\', \'<span>'.lang('plugin/shortcode', 'success_made').'</span>\', 2000);';
                                        echo 'parent.document.getElementById(\'vct\').innerHTML=\''.lang('plugin/shortcode', 'tips').'\';'; 
                                        echo 'parent.document.getElementById(\'down\').style.display=\'\';';                     
                                        echo 'parent.document.getElementById(\'code\').innerHTML=\''.$code.'\';'; 
                                        echo 'parent.document.getElementById(\'short\').innerHTML=\''.$short.'\';';                                        
                                        echo '</script>';        
                                }
                        }
                        $sharecode = 'var jiathis_config={data_track_clickback:true,url:"'.$share.'",summary:"'.$summary.'", title:"'.$sharetitle.'#'.$tqqtitle.'#", pic:"'.$short_url.'",appkey:{"tqq":"'.$config['tqq'].'"},hideMore:false}'; 
                        echo "<script>window.onload=function(){ var script=parent.document.createElement('script'); script.type='text/javascript';  script.text='".$sharecode."';  var sharecode=parent.document.getElementsByTagName('head')[0]; sharecode.appendChild(script);};</script>"; 
                        exit(0);
                }
        }
        include template('shortcode:shortcode');
}elseif($action == 'short'){
        $url_this = 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI'];//当前页URL
        $qr->link($url_this);                                
        $long_url = $qr->get_link($size,$EC_level); 
        $short_url = shortenGoogleUrl($long_url);
        $share = $_G['siteurl'].'plugin.php?id=shortcode&action=short';//本插件URL
        $summary = lang('plugin/shortcode', 'summary');
        $tqqtitle = lang('plugin/shortcode', 'dtqqtitle');
        $sharetitle = $_G[setting][bbname].' - '.$navtitle.' - '.lang('plugin/shortcode', 'short');
        if(submitcheck('codesubmit')) {  //检查是否提交
                $long_url_s = trim($_G['gp_long_url_s']);
                if(empty($long_url_s)){  //检查输入内容
                        echo '<script type="text/javascript">'; 
                        echo 'parent.document.getElementById(\'code\').innerHTML=\'<img src="source/plugin/shortcode/images/sorry.gif" />\';'; 
                        echo 'parent.document.getElementById(\'vct\').innerHTML=\''.lang('plugin/shortcode', 'error_tips').'\';';
                        echo 'parent.document.getElementById(\'short\').innerHTML=\'<p class=rq>'.lang('plugin/shortcode', 'error_empty').'</p>\';';
                        echo 'parent.document.getElementById(\'short_s\').innerHTML=\'<input type="text" class="px vm" value="'.$short_url_s.'" readonly="readonly" tabIndex="1" />\';';
                        echo '</script>';                                  
                }elseif(!$ch->isurl($long_url_s)){  //检查地址
                        echo '<script type="text/javascript">'; 
                        echo 'parent.document.getElementById(\'code\').innerHTML=\'<img src="source/plugin/shortcode/images/sorry.gif" />\';'; 
                        echo 'parent.document.getElementById(\'vct\').innerHTML=\''.lang('plugin/shortcode', 'error_tips').'\';';
                        echo 'parent.document.getElementById(\'short\').innerHTML=\'<p class=rq>'.lang('plugin/shortcode', 'error_url').'</p>\';';
                        echo 'parent.document.getElementById(\'short_s\').innerHTML=\'<input type="text" class="px vm" value="'.$short_url_s.'" readonly="readonly" tabIndex="1" />\';';
                        echo '</script>';   
                }else{
                        $text_cut = $url_this;
                        $short_url_s = shortenGoogleUrl($long_url_s);
                        $copyfunc_s = "javascript:this.select();setCopy(this.value, \'".lang('plugin/shortcode', 'success_tips_s')."\');";
                        $short_s = '<input type="text" class="px vm" onclick="'.$copyfunc_s.'" readonly="readonly" tabIndex="1" value="'.$short_url_s.'" />';
                        $copyfunc = "javascript:this.select();setCopy(this.value, \'".lang('plugin/shortcode', 'success_tips')."\');";
                        $short = '<input type="text" class="px vm" onclick="'.$copyfunc.'"  style="width:150px;" readonly="readonly" tabIndex="1" value="'.$short_url.'" />';
                        $code = '<img src="'.$long_url.'" style="border: 1px solid #FFF;padding:5px;"/>'
                                .'<p style="color:#FEFEE9"><strong>'.lang('plugin/shortcode', 'short').'</strong></p><p>'.$text_cut.'</p>';
                        echo '<script type="text/javascript">';
                        echo 'window.parent.frames.showPrompt(\'\', \'\', \'<span>'.lang('plugin/shortcode', 'success_made_s').'</span>\', 2000);';
                        echo 'parent.document.getElementById(\'vct\').innerHTML=\''.lang('plugin/shortcode', 'tips').'\';';                     
                        echo 'parent.document.getElementById(\'code\').innerHTML=\''.$code.'\';'; 
                        echo 'parent.document.getElementById(\'short\').innerHTML=\''.$short.'\';';  
                        echo 'parent.document.getElementById(\'short_s\').innerHTML=\''.$short_s.'\';';                                       
                        echo '</script>';                       
                 }
                 exit(0);        
        }
        include template('shortcode:shortcode');
}elseif($action == 'long'){
        $url_this = 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI'];//当前页URL
        $qr->link($url_this);                                
        $long_url = $qr->get_link($size,$EC_level); 
        $short_url = shortenGoogleUrl($long_url);
        $share = $_G['siteurl'].'plugin.php?id=shortcode&action=long';//本插件URL
        $summary = lang('plugin/shortcode', 'summary');
        $tqqtitle = lang('plugin/shortcode', 'dtqqtitle');
        $sharetitle = $_G[setting][bbname].' - '.$navtitle.' - '.lang('plugin/shortcode', 'long');
        if(submitcheck('codesubmit')) {  //检查是否提交
                $short_url_l = trim($_G['gp_short_url_l']);
                if(empty($short_url_l)){  //检查输入内容
                        echo '<script type="text/javascript">'; 
                        echo 'parent.document.getElementById(\'code\').innerHTML=\'<img src="source/plugin/shortcode/images/sorry.gif" />\';'; 
                        echo 'parent.document.getElementById(\'vct\').innerHTML=\''.lang('plugin/shortcode', 'error_tips').'\';';
                        echo 'parent.document.getElementById(\'short\').innerHTML=\'<p class=rq>'.lang('plugin/shortcode', 'error_empty').'</p>\';';
                        echo 'parent.document.getElementById(\'long_l\').innerHTML=\'<textarea type="text" class="pt" rows="6" cols="40" readonly="readonly" tabIndex="1" >'.$long_url_l.'</textarea>\';';
                        echo '</script>';                                  
                }elseif(!$ch->isurl($short_url_l)){  //检查地址
                        echo '<script type="text/javascript">'; 
                        echo 'parent.document.getElementById(\'code\').innerHTML=\'<img src="source/plugin/shortcode/images/sorry.gif" />\';'; 
                        echo 'parent.document.getElementById(\'vct\').innerHTML=\''.lang('plugin/shortcode', 'error_tips').'\';';
                        echo 'parent.document.getElementById(\'short\').innerHTML=\'<p class=rq>'.lang('plugin/shortcode', 'error_url').'</p>\';';
                        echo 'parent.document.getElementById(\'long_l\').innerHTML=\'<textarea type="text" class="pt" rows="6" cols="40" readonly="readonly" tabIndex="1" >'.$long_url_l.'</textarea>\';';
                        echo '</script>';   
                }else{
                        $text_cut = $url_this;
                        $long_url_l = expandGoogleUrl($short_url_l);
                        $copyfunc_l = "javascript:this.select();setCopy(this.value, \'".lang('plugin/shortcode', 'success_tips_l')."\');";
                        $long_l = '<textarea type="text" class="pt" rows="6" cols="40" onclick="'.$copyfunc_l.'" readonly="readonly" tabIndex="1">'.$long_url_l.'</textarea>';
                        $copyfunc = "javascript:this.select();setCopy(this.value, \'".lang('plugin/shortcode', 'success_tips')."\');";
                        $short = '<input type="text" class="px vm" onclick="'.$copyfunc.'"  style="width:150px;" readonly="readonly" tabIndex="1" value="'.$short_url.'" />';
                        $code = '<img src="'.$long_url.'" style="border: 1px solid #FFF;padding:5px;"/>'
                                .'<p style="color:#FEFEE9"><strong>'.lang('plugin/shortcode', 'short').'</strong></p><p>'.$text_cut.'</p>';
                        echo '<script type="text/javascript">';
                        echo 'window.parent.frames.showPrompt(\'\', \'\', \'<span>'.lang('plugin/shortcode', 'success_made_l').'</span>\', 2000);';
                        echo 'parent.document.getElementById(\'vct\').innerHTML=\''.lang('plugin/shortcode', 'tips').'\';';                     
                        echo 'parent.document.getElementById(\'code\').innerHTML=\''.$code.'\';'; 
                        echo 'parent.document.getElementById(\'short\').innerHTML=\''.$short.'\';';  
                        echo 'parent.document.getElementById(\'long_l\').innerHTML=\''.$long_l.'\';';                                       
                        echo '</script>';                       
                 }
                 exit(0);        
        }
        include template('shortcode:shortcode');
}
function DeleteHtml($str) {  //过滤回车空格
        $str = trim($str); 
        $str = strip_tags($str,""); 
        $str = ereg_replace("\t","",$str); 
        $str = ereg_replace("\r\n","",$str); 
        $str = ereg_replace("\r","",$str); 
        $str = ereg_replace("\n","",$str); 
        $str = ereg_replace(" "," ",$str); 
        return trim($str); 
}
function shortenGoogleUrl($long_url){  //生成短地址
        $apiKey = $config['apikey']; //Get API key from : http://code.google.com/apis/console/ 
        $postData = !empty($apiKey) ? array('longUrl' => $long_url, 'key' => $apiKey) : array('longUrl' => $long_url); 
        $jsonData = json_encode($postData); 
        if(function_exists('curl_init')){
                $curlObj = curl_init(); 
                curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url'); 
                curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1); 
                curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0); 
                curl_setopt($curlObj, CURLOPT_HEADER, 0); 
                curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json')); 
                curl_setopt($curlObj, CURLOPT_POST, 1); 
                curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData); 
                $response = curl_exec($curlObj); 
                curl_close($curlObj); 
        }else{
                $geturl = 'https://www.googleapis.com/urlshortener/v1/url';
                $context = array('http'=>array('method'=>'post','header'=>'Accept-language:en\r\n'
                        .'Content-type:application/json\r\n'
                        .'Content-Length:'.strlen($jsonData).'\r\n',
                        'timeout' => 30 ,'content'=>$jsonData));
                $ctx = stream_context_create($context);
                $response = file_get_contents($geturl, 0,$ctx);
        }
        $json = json_decode($response); 
        return $json->id; 
}  
function expandGoogleUrl($short_url){  //还原长地址
        if(function_exists('curl_init')){
        $curlObj = curl_init(); 
        curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url?shortUrl='.$short_url); 
        curl_setopt($curlObj, CURLOPT_HEADER, 0); 
        curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0); 
        $response = curl_exec($curlObj); 
        curl_close($curlObj);
        }else{
                $geturl = 'https://www.googleapis.com/urlshortener/v1/url?shortUrl='.$short_url;
                $context = array('http'=>array('timeout' => 30 ));
                $ctx = stream_context_create($context);
                $response = file_get_contents($geturl, 0,$ctx);
        } 
        $json = json_decode($response); 
        return $json->longUrl; 
} 
?>