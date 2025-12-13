<?php
/**
 *  获取UTF8格式的字符串的子串.
 *
 * @param string $sourcestr 源字符串
 * @param int	$startstr  开始字串子串
 * @param int	$cutlength 子串长度
 *
 * @return string
 */
function tpure_SubStrStartUTF8($sourcestr, $startstr, $cutlength)
{
	global $zbp;
	if (function_exists('mb_substr') && function_exists('mb_internal_encoding') && function_exists('mb_stripos')) {
		mb_internal_encoding('UTF-8');

		return mb_substr($sourcestr, mb_stripos($sourcestr, $startstr), $cutlength);
	}
	if (function_exists('iconv_substr') && function_exists('iconv_set_encoding') && function_exists('iconv_strpos')) {
		iconv_set_encoding("internal_encoding", "UTF-8");
		iconv_set_encoding("output_encoding", "UTF-8");

		return iconv_substr($sourcestr, iconv_strpos($sourcestr, $startstr), $cutlength);
	}
	$returnstr = '';
	$i = stripos($sourcestr, $startstr);
	$n = 0;
	$str_length = strlen($sourcestr);
	while (($n < $cutlength) and ($i <= $str_length)) {
		$temp_str = substr($sourcestr, $i, 1);
		$ascnum = ord($temp_str);
		if ($ascnum >= 224) {
			$returnstr = $returnstr . substr($sourcestr, $i, 3);
			$i = $i + 3;
			$n++;
		} elseif ($ascnum >= 192) {
			$returnstr = $returnstr . substr($sourcestr, $i, 2);
			$i = $i + 2;
			$n++;
		} elseif ($ascnum >= 65 && $ascnum <= 90) {
			$returnstr = $returnstr . substr($sourcestr, $i, 1);
			$i = $i + 1;
			$n++;
		} else {
			$returnstr = $returnstr . substr($sourcestr, $i, 1);
			$i = $i + 1;
			$n = $n + 0.5;
		}
	}
	if ($str_length > $cutlength) {
		$returnstr = $returnstr;
	}

	return $returnstr;
}
