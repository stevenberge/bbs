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
class class_qrcode{
        private $data;
        public function text($text){  //creating text qr code
                $this->data = $text;
        }
        public function link($url){  //creating code with link mtadata
                if (preg_match('/^http:\/\//', $url) || preg_match('/^https:\/\//', $url)){
                        $this->data = $url;
                }
                else{
                        $this->data = "<a href=http://".$url.">http://".$url."</a>";
                }
        }
        public function bookmark($title, $url){  //creating code with bookmark metadata
                $this->data = "MEBKM:TITLE:".$title.";URL:".$url.";;";
        }
        public function email($email, $subject, $message){  //creating code with email metadata
                $this->data = "MATMSG:TO:".$email.";SUB:".$subject.";BODY:".$message.";;";
        } 
        public function sms($phone, $text){  //creating code with sms metadata
                $this->data = "SMSTO:".$phone.":".$text;
        }
        public function mms($phone, $text){  //creating code with mms metadata
                $this->data = "MMSTO:".$phone.":".$text;
        }
        public function vcard($name, $phone,$email,$title,$url,$org,$address,$note){  //creating code with vcard metadata
                $this->data = "BEGIN:VCARD\nVERSION:3.0\nFN:".$name."\nTEL:".$phone."\nEMAIL:".$email."\nTITLE:".$title."\nURL:".$url."\nORG:".$org."\nADR:".$address."\nNOTE:".$note."\nEND:VCARD";
        }
        public function get_image($size = '200', $EC_level = 'L', $margin = '0'){  //getting image
                $this->data = urlencode(mb_convert_encoding($this->data,'utf-8','gb2312')); //gb2312->utf-8
                if(function_exists('curl_init')){
                        $ch = curl_init();                        
                        curl_setopt($ch, CURLOPT_URL, 'http://chart.apis.google.com/chart');
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, 'chs='.$size.'x'.$size.'&cht=qr&chld='.$EC_level.'|'.$margin.'&chl='.$this->data);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_HEADER, false);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                        $response = curl_exec($ch);
                        curl_close($ch);
                }else{
                        $geturl = 'http://chart.apis.google.com/chart?chs='.$size.'x'.$size.'&cht=qr&choe=UTF-8&chld='.$EC_level.'|'.$margin.'&chl='.$this->data;
                        $ctx = stream_context_create(array('http' => array('timeout' => 30 )));
                        $response = file_get_contents($geturl, 0,$ctx);
                }
                return $response;
        }        
        public function get_link($size = '200', $EC_level = 'L', $margin = '0'){  //getting link for image
                $this->data = urlencode(mb_convert_encoding($this->data,'utf-8','gb2312')); //gb2312->utf-8
                return 'http://chart.apis.google.com/chart?chs='.$size.'x'.$size.'&cht=qr&choe=UTF-8&chld='.$EC_level.'|'.$margin.'&chl='.$this->data;
        }
        public function back_link($long_url){  //back link for image
                $long_url = explode("&", $long_url);
                foreach($long_url as $key=>$value){
		        $value=explode('=', $value);
                        $long_url[$key] = $value[1];
   	        }
                unset($value);
                list($size) = explode("x",$long_url[0]);
                list($EC_level,$margin) = explode("|",mb_convert_encoding(urldecode($long_url[3]),'gb2312','utf-8'));
                $text = mb_convert_encoding(urldecode($long_url[4]),'gb2312','utf-8');                
                $back = array($size,$EC_level,$text);
                return $back;
        }        
        public function download_image($file){  //forsing image download
                header('Content-Description:File Transfer');
                header('Content-Type:image/jpeg');
                header('Content-Disposition:attachment;filename=QRcode.jpg');
                header('Content-Transfer-Encoding:binary');
                header('Expires:0');
                header('Cache-Control:must-revalidate, post-check=0, pre-check=0');
                header('Pragma:public');
                header('Content-Length:'.strlen($file));
                ob_clean();
                flush();
                echo $file;                
        }
}
?>
