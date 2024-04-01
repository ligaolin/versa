<?php

namespace App\utils\Utils;

class Http {
    static function Send($url,$data=[],$head=[],$method='POST',$sslCert='',$sslKey=''){
        $curl = curl_init();
        $headArr = [];
        foreach($head as $k => $v){
            $headArr[] = implode(': ',[$k,$v]);
        }
        if($method=='GET'){
            $url .= '?'. http_build_query($data);
            $data = [];
        }
        
        $curlArr = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => is_object($data)||is_array($data)?json_encode($data):$data,
            CURLOPT_HTTPHEADER => $headArr,
        ];
        if($sslCert) {
            $curlArr[CURLOPT_SSLCERTTYPE] = 'PEM';
            $curlArr[CURLOPT_SSLCERT] = $sslCert;
        }
        if($sslKey) {
            $curlArr[CURLOPT_SSLKEYTYPE] = 'PEM';
            $curlArr[CURLOPT_SSLKEY] = $sslKey;
        }

        curl_setopt_array($curl, $curlArr);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) throw new \Exception($err);
        return $response;
    }
}