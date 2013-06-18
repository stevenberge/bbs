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
class class_check{
        function islen($str){  //验证长度
                return (strlen($str) <= 450)?true:false;
        }
        function isemail($str){  //验证邮件地址
                return (preg_match('/^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,4}$/',$str))?true:false;
        }
        function isphone($str){  //验证电话号码
                return (preg_match("/^((\(\d{3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}$/",$str))?true:false;
        }
        function iszip($str){  //验证邮编
                return (preg_match("/^[1-9]\d{5}$/",$str))?true:false;
        }
        function isurl($str){  //验证url地址
                return (preg_match("/^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/",$str))?true:false;
        }
        function isName($str){  //验证中英文名
                return (preg_match('/^[a-zA-z '.chr(0xa1).'-'.chr(0xff).']{3,160}$/',$str))?true:false;
        }
        function ismobile($str){  //验证手机号码
                return (preg_match("/^((\(\d{2,3}\))|(\d{3}\-))?13\d{9}$/",$str))?true:false;
        }
}
?>