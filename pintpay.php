<?php

class PintPay {

	private $api_key, $api_secret;
	
	
	public function setAPI($api){
	    if( empty( $api ) ) exit("API Key must be provided");
	    
	    
		$this->api_key = $api;
		
	}

	public function setSecret($secret){
	    if( empty( $secret ) ) exit("API Key must be provided");
	    
	    
		$this->api_secret = $secret;
		
	}
	
    public function subscriptions($secret = FALSE){
    
        if($secret === FALSE)
            return $this->request("/subscriptions");
        else
            return $this->subscription($secret);
    
    }
    
    public function subscription($secret){
        if(empty($secret)) return null;
        
        return $this->request("/subscriptions/".$secret);
    
    }

    public function subscriptionCancel($secret){
        if(empty($secret)) return null;
        
        return $this->request("/subscriptions/".$secret."/cancel", "PUT");
        
    }
    
    
    
    private function request($req, $type = FALSE){
        if( empty( $req ) ) return false;
        
        $url = "https://www.pintpay.com/api/1";
    
        $request_url = $url.$req.'?api_key='.$this->api_key.'&api_secret='.$this->api_secret;

        $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $request_url);
        curl_setopt($ch, CURLOPT_HEADER, 0); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        
        if($type !=== FALSE && strtoupper($type) == "PUT"){
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($ch, CURLOPT_INFILESIZE, 0);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_PUT, 1); 
        }

        $content = curl_exec($ch);
                
        curl_close($ch);

        return json_decode($content);

	}
}



