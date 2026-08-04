<?php 
namespace App\Controllers;
use App\Models\UserModel;

class Auth extends BaseController {

    public function index() {
        return view('amossys/index');
    }

    public function csrf()
{
    $data =  $this->response->setJSON([
        'csrfName' => csrf_token(),
        'csrfHash' => csrf_hash()
    ]);
    
}

public function save_data(){
    $data = $this->request->getJSON(true); // true = return as array
 // print_r($data);exit;
    $p_date         = $data['p_date'] ?? null;
    if($p_date <= date('Y-m-d')){
    $serial_num     = $data['serial_num'] ?? null;
    $bill_num       = $data['bill_num'] ?? null;
    $seller_name    = $data['seller_name'] ?? null;
    $customer_name  = $data['customer_name'] ?? null;
    $customer_email = $data['customer_email'] ?? null;
    $customer_phone = $data['customer_phone'] ?? null;
    $pincode        = $data['pincode'] ?? null;
    $image_base64   = $data['image_base64'] ?? null;

    $paylod = array(
        "serial_no" => $serial_num,
        "customerName" => $customer_name,
        "email" => $customer_email,
        "phoneNumber" => $customer_phone,
        "sellerName" => $seller_name,
        "pinCode" => $pincode,
        "purchaseDate" => $p_date,
        "billNumber" => $bill_num,
        "file-upload"=> $image_base64
    );
    $paylod_data = json_encode($paylod);
    $ch = curl_init();
    // old_url = https://dev-floweazy-amosys-staging-22047831.dev.odoo.com/register/warranty
    // curl_setopt($ch, CURLOPT_URL, 'https://dev-floweazy-amosys-staging-24651060.dev.odoo.com/register/warranty');
    curl_setopt($ch, CURLOPT_URL, 'https://dev-floweazy-amosys.odoo.com/register/warranty');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $paylod_data);
     
    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Cookie: session_id=fJ5N1pneOTtiwh46l0NNZJCHaFEw5rufGUigukVbz2T_leI5oziEM2suSQ1nvXJCUwUxxWFEj72gBw_cXFB2';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    $result_decode = json_decode($result);
    $status = $result_decode->result->status;
    $message = $result_decode->result->message;
    $res['status'] = $status;
    $res['message'] = $message;
    echo json_encode($res);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);exit;
    }
    curl_close($ch);
    }else{
        $res['status'] = 'error';
        $res['message'] = 'Futute Date is Not Allowed';
        echo json_encode($res);
    }
    }
}
