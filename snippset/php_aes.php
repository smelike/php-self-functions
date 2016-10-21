<?php


class Security
{

	public static $_key = '1234567890123456';
	public static $_skey = '1234567890abcdef1234567890abcdef';

	public static function encrypt($input)
	{

		$key = hex2bin(self::$_skey);
		$input = hex2bin($input);
		$size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
		//$input = Security::pkcs5_pad($input, $size);
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

		return $text . str_repeat('0d', $pad);
	}

	public static function decrypt($sStr)
	{

		//echo "until_data:--";
		$sStr = hex2bin($sStr);
		//var_dump($sStr);
		$sKey = hex2bin(self::$_skey);
		$decrypted = mcrypt_decrypt(
			MCRYPT_RIJNDAEL_128,
			$sKey,
			base64_decode($sStr),
			MCRYPT_MODE_ECB
		);

		$decrypted_hex = bin2hex($decrypted);
		$complement = substr($decrypted_hex, strlen($decrypted_hex) - 2, 2);

		return str_replace($complement, '', $decrypted_hex);
	}

}

?>
