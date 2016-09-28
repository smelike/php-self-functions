<?php

class Security
{

	public static $_bkey = "bJXsdl#YiLcBvVm4"; // bJXsdl#YiLcBvVm4

	public function __construct()
	{
		$nas = new Nas();
		//echo "34r534234";
		//var_dump($nas);
	}

	public static function encrypt($input)
	{

		//$key = hex2bin(self::$_skey);
		$key = self::$_bkey;
		$size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
		$input = hex2bin($input); // 二进制数据
		$input = Security::pkcs5_pad($input, $size);
		$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
		$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
		mcrypt_generic_init($td, $key, $iv);
		$data = mcrypt_generic($td, $input);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		$data = base64_encode($data);

		return $data;
	}

	private static function pkcs5_pad($text, $blocksize)
	{
		$pad = $blocksize - (strlen($text) % $blocksize);
		return $text . str_repeat(chr($pad), $pad);
	}
	public static function decrypt($sStr)
	{

		$sStr = hex2bin($sStr);
		$sKey = self::$_bkey;
		$decrypted = mcrypt_decrypt(
			MCRYPT_RIJNDAEL_128,
			$sKey,
			base64_decode($sStr),
			MCRYPT_MODE_ECB
		);

		$decrypted_hex = bin2hex($decrypted);
		$complement = substr($decrypted_hex, strlen($decrypted_hex) - 2, 2);
		if (ord($complement) < strlen($decrypted_hex)) {
			$decrypted_hex = substr($decrypted_hex, 0, -1 * ord($complement));
		}
		return $decrypted_hex;
	}
}
