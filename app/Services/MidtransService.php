<?php
namespace App\Services;
use Illuminate\Support\Facades\Log;

class MidtransService {
    protected string $riplabsKey;
    protected string $riplabsUrl;
    protected string $snapJsUrl;
    protected string $clientKey;
    protected string $callbackKey;
    public function __construct() {
        $this->riplabsKey = config('services.midtrans.riplabs_key','');
        $this->riplabsUrl = config('services.midtrans.riplabs_snaptoken_url','');
        $this->snapJsUrl  = config('services.midtrans.snap_js_url','https://app.sandbox.midtrans.com/snap/snap.js');
        $this->clientKey  = config('services.midtrans.client_key','');
        $this->callbackKey= config('services.midtrans.callback_key','');
    }
    public function getSnapToken(array $data): array {
        try {
            $curl=curl_init();
            curl_setopt_array($curl,[CURLOPT_URL=>$this->riplabsUrl,CURLOPT_RETURNTRANSFER=>true,CURLOPT_TIMEOUT=>30,CURLOPT_FOLLOWLOCATION=>true,CURLOPT_CUSTOMREQUEST=>'POST',CURLOPT_POSTFIELDS=>['key'=>$this->riplabsKey,'order_id'=>$data['order_id'],'total_harga'=>$data['total_harga'],'nama'=>$data['nama'],'email'=>$data['email'],'notelp'=>$data['notelp']??'0','namaproduk'=>$data['namaproduk']]]);
            $resp=curl_exec($curl);$err=curl_error($curl);curl_close($curl);
            if($resp===false) return['status'=>false,'message'=>'cURL: '.$err];
            return json_decode($resp,true)??['status'=>false,'message'=>'Invalid response'];
        } catch(\Exception $e){Log::error('Midtrans: '.$e->getMessage());return['status'=>false,'message'=>$e->getMessage()];}
    }
    public function getSnapJsUrl(): string { return $this->snapJsUrl; }
    public function getClientKey(): string { return $this->clientKey; }
    public function verifyCallbackKey(string $key): bool { return $key===$this->callbackKey; }
}
