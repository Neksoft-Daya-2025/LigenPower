<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

$configFile = __DIR__ . '/../config/news-events.json';
$uploadDir = __DIR__ . '/../uploads/news-events';

function newsResponse($success, $message = '', $extra = [], $status = 200) {
    http_response_code($status); echo json_encode(array_merge(['success'=>$success,'message'=>$message], $extra), JSON_UNESCAPED_SLASHES); exit;
}
function newsLoad($file) {
    if (!file_exists($file)) return [];
    $data = json_decode(file_get_contents($file), true);
    return is_array($data) && isset($data['items']) && is_array($data['items']) ? $data['items'] : [];
}
function newsSave($file, $items) {
    $dir = dirname($file); if (!is_dir($dir) && !mkdir($dir, 0755, true)) return false;
    return file_put_contents($file, json_encode(['items'=>array_values($items),'updated_at'=>date('c')], JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES), LOCK_EX) !== false;
}
function newsText($value, $max = 500) {
    $value = trim((string)$value); return function_exists('mb_substr') ? mb_substr($value,0,$max) : substr($value,0,$max);
}

$items = newsLoad($configFile);
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $admin = isset($_GET['admin']) && $_GET['admin'] === '1';
    if (!$admin) $items = array_values(array_filter($items, function($item){ return !empty($item['published']); }));
    usort($items, function($a,$b){ return strcmp($b['date'] ?? '', $a['date'] ?? ''); });
    newsResponse(true, '', ['items'=>$items]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = newsText($_POST['id'] ?? '', 80); $title = newsText($_POST['title'] ?? '', 220);
    $type = strtolower(newsText($_POST['type'] ?? 'news', 10)); $type = $type === 'event' ? 'event' : 'news';
    $date = newsText($_POST['date'] ?? date('Y-m-d'), 10); $location = newsText($_POST['location'] ?? '', 120);
    $excerpt = newsText($_POST['excerpt'] ?? '', 700); $articleUrl = newsText($_POST['article_url'] ?? '', 500);
    if ($articleUrl !== '' && !preg_match('#^(https?://|/|\./|\.\./)#i', $articleUrl) && preg_match('/^[a-z0-9.-]+\.[a-z]{2,}(\/.*)?$/i', $articleUrl)) {
        $articleUrl = 'https://' . $articleUrl;
    }
    $published = ($_POST['published'] ?? '1') === '1';
    if ($title === '') newsResponse(false, 'Title is required.', [], 422);
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) newsResponse(false, 'A valid date is required.', [], 422);
    $index=-1; foreach($items as $i=>$item) if(($item['id']??'')===$id && $id!==''){ $index=$i; break; }
    $existing=$index>=0?$items[$index]:null; $imageUrl=$existing['image']??'';
    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $file=$_FILES['image']; if($file['error']!==UPLOAD_ERR_OK) newsResponse(false,'Image upload failed.',[],400);
        if($file['size']>5*1024*1024) newsResponse(false,'Image must be 5 MB or smaller.',[],413);
        $finfo=finfo_open(FILEINFO_MIME_TYPE); $mime=finfo_file($finfo,$file['tmp_name']); finfo_close($finfo);
        $extensions=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];
        if(!isset($extensions[$mime])) newsResponse(false,'Use a JPG, PNG or WebP image.',[],415);
        if(!is_dir($uploadDir) && !mkdir($uploadDir,0755,true)) newsResponse(false,'Could not create image directory.',[],500);
        $name='news-'.date('Ymd-His').'-'.bin2hex(random_bytes(3)).'.'.$extensions[$mime];
        if(!move_uploaded_file($file['tmp_name'],$uploadDir.'/'.$name)) newsResponse(false,'Could not save image.',[],500);
        if($existing && !empty($existing['image']) && strpos($existing['image'],'uploads/news-events/')===0){ $old=basename($existing['image']); if(file_exists($uploadDir.'/'.$old)) @unlink($uploadDir.'/'.$old); }
        $imageUrl='uploads/news-events/'.$name;
    }
    if($imageUrl==='') newsResponse(false,'Please upload a featured image.',[],422);
    $now=date('c'); $record=['id'=>$existing['id']??('ne-'.time().'-'.bin2hex(random_bytes(3))),'type'=>$type,'title'=>$title,'date'=>$date,
        'location'=>$location,'excerpt'=>$excerpt,'article_url'=>$articleUrl,'image'=>$imageUrl,'published'=>$published,
        'created_at'=>$existing['created_at']??$now,'updated_at'=>$now];
    if($index>=0)$items[$index]=$record;else$items[]=$record;
    if(!newsSave($configFile,$items)) newsResponse(false,'Could not save News & Events catalogue.',[],500);
    newsResponse(true,$index>=0?'Item updated.':'Item published.',['item'=>$record]);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data=json_decode(file_get_contents('php://input'),true); $id=newsText($data['id']??'',80); if($id==='')newsResponse(false,'Item ID is required.',[],422);
    $deleted=null;$remaining=[];foreach($items as $item){if(($item['id']??'')===$id)$deleted=$item;else$remaining[]=$item;}
    if(!$deleted)newsResponse(false,'Item not found.',[],404); if(!newsSave($configFile,$remaining))newsResponse(false,'Could not update catalogue.',[],500);
    if(!empty($deleted['image'])&&strpos($deleted['image'],'uploads/news-events/')===0){$file=basename($deleted['image']);if(file_exists($uploadDir.'/'.$file))@unlink($uploadDir.'/'.$file);}
    newsResponse(true,'Item deleted.');
}
newsResponse(false,'Method not allowed.',[],405);
