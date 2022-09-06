<?php
	class Cypher{


		// Store the cipher method
		private  $ciphering = "AES-128-CTR";
		  
		// Use OpenSSl Encryption method
		//private  $iv_length = openssl_cipher_iv_length($ciphering);
		private  $options = 0;
		  
		// Non-NULL Initialization Vector for encryption
		private  $encryption_iv = '1234567891011121';

		private $decryption_iv = '1234567891011121';
		  
		// Store the encryption key
		private  $encryption_key = "NRRUQuestionair";

		//public $simple_string = "Welcome to GeeksforGeeks\n";

		private  $decryption_key = "NRRUQuestionair";

		public  function encrypt($rawString){
			$iv_length = openssl_cipher_iv_length($this->ciphering);
			$encryption = openssl_encrypt($rawString, $this->ciphering,
            $this->encryption_key, $this->options, $this->encryption_iv);
            return $encryption;
		}

		public  function decrypt($encryptString){
			$decryption=openssl_decrypt ($encryptString, $this->ciphering, 
        	$this->decryption_key, $this->options, $this->decryption_iv);
        	return $decryption; 

		}

	}
?>