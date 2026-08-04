<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

$file = __DIR__ . '/../config/faqs.json';
function faqReply($success,$message='',$extra=[],$status=200){http_response_code($status);echo json_encode(array_merge(['success'=>$success,'message'=>$message],$extra),JSON_UNESCAPED_SLASHES);exit;}
function faqLoad($file){if(!file_exists($file))return[];$data=json_decode(file_get_contents($file),true);return is_array($data)&&isset($data['faqs'])&&is_array($data['faqs'])?$data['faqs']:[];}
function faqSave($file,$items){$dir=dirname($file);if(!is_dir($dir)&&!mkdir($dir,0755,true))return false;return file_put_contents($file,json_encode(['faqs'=>array_values($items),'updated_at'=>date('c')],JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES),LOCK_EX)!==false;}
function faqText($value,$max=2000){$value=trim((string)$value);return function_exists('mb_substr')?mb_substr($value,0,$max):substr($value,0,$max);}
$items=faqLoad($file);
if($_SERVER['REQUEST_METHOD']==='GET'){
    $admin=isset($_GET['admin'])&&$_GET['admin']==='1';if(!$admin)$items=array_values(array_filter($items,function($x){return!empty($x['published']);}));
    usort($items,function($a,$b){$order=((int)($a['sort_order']??0))-((int)($b['sort_order']??0));return $order!==0?$order:strcmp($a['question']??'',$b['question']??'');});faqReply(true,'',['faqs'=>$items]);
}
if($_SERVER['REQUEST_METHOD']==='POST'){
    $raw=file_get_contents('php://input');$data=json_decode($raw,true);if(!is_array($data))faqReply(false,'Invalid request.',[],400);
    $id=faqText($data['id']??'',80);$question=faqText($data['question']??'',300);$answer=faqText($data['answer']??'',3000);$category=faqText($data['category']??'General',80);
    $order=max(0,(int)($data['sort_order']??0));$published=!isset($data['published'])||$data['published']===true||$data['published']==='1';
    if($question==='')faqReply(false,'Question is required.',[],422);if($answer==='')faqReply(false,'Answer is required.',[],422);
    $index=-1;foreach($items as $i=>$item)if(($item['id']??'')===$id&&$id!==''){$index=$i;break;}$existing=$index>=0?$items[$index]:null;$now=date('c');
    $record=['id'=>$existing['id']??('faq-'.time().'-'.bin2hex(random_bytes(3))),'category'=>$category,'question'=>$question,'answer'=>$answer,'sort_order'=>$order,'published'=>$published,'created_at'=>$existing['created_at']??$now,'updated_at'=>$now];
    if($index>=0)$items[$index]=$record;else$items[]=$record;if(!faqSave($file,$items))faqReply(false,'Could not save FAQ.',[],500);faqReply(true,$index>=0?'FAQ updated.':'FAQ added.',['faq'=>$record]);
}
if($_SERVER['REQUEST_METHOD']==='DELETE'){
    $data=json_decode(file_get_contents('php://input'),true);$id=faqText($data['id']??'',80);$found=false;$remaining=[];foreach($items as $item){if(($item['id']??'')===$id)$found=true;else$remaining[]=$item;}
    if(!$found)faqReply(false,'FAQ not found.',[],404);if(!faqSave($file,$remaining))faqReply(false,'Could not delete FAQ.',[],500);faqReply(true,'FAQ deleted.');
}
faqReply(false,'Method not allowed.',[],405);
