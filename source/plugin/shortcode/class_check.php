<?php
/**
 *      �������� �ó���Ȼ ����
 *      ��Ҫ���ο�����������ҵ��;�ģ���Ҫ���� �ó���Ȼ ͬ�⡣
 *      ��Ȩ������������http://www.nhbxw.com
 *      2012-01-01
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class class_check{
        function islen($str){  //��֤����
                return (strlen($str) <= 450)?true:false;
        }
        function isemail($str){  //��֤�ʼ���ַ
                return (preg_match('/^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,4}$/',$str))?true:false;
        }
        function isphone($str){  //��֤�绰����
                return (preg_match("/^((\(\d{3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}$/",$str))?true:false;
        }
        function iszip($str){  //��֤�ʱ�
                return (preg_match("/^[1-9]\d{5}$/",$str))?true:false;
        }
        function isurl($str){  //��֤url��ַ
                return (preg_match("/^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/",$str))?true:false;
        }
        function isName($str){  //��֤��Ӣ����
                return (preg_match('/^[a-zA-z '.chr(0xa1).'-'.chr(0xff).']{3,160}$/',$str))?true:false;
        }
        function ismobile($str){  //��֤�ֻ�����
                return (preg_match("/^((\(\d{2,3}\))|(\d{3}\-))?13\d{9}$/",$str))?true:false;
        }
}
?>