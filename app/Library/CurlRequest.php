<?php
namespace App\Library; use Illuminate\Support\Facades\Log; class CurlRequest { private static function curl($spddf3f5, $sp701759 = 0, $spa99fc2 = '', $sp697dbb = array(), $spb43dc2 = 5, &$sp620f5b = false) { if (!isset($sp697dbb['Accept'])) { $sp697dbb['Accept'] = '*/*'; } if (!isset($sp697dbb['Referer'])) { $sp697dbb['Referer'] = $spddf3f5; } if (!isset($sp697dbb['Content-Type'])) { $sp697dbb['Content-Type'] = 'application/x-www-form-urlencoded'; } if (!isset($sp697dbb['User-Agent'])) { $sp697dbb['User-Agent'] = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36'; } if ($sp620f5b !== false) { $sp697dbb['Cookie'] = $sp620f5b; } $sp330405 = array(); foreach ($sp697dbb as $sp665b4f => $sp2aacb2) { $sp330405[] = $sp665b4f . ': ' . $sp2aacb2; } $sp330405[] = 'Expect:'; $spa9fd67 = curl_init(); curl_setopt($spa9fd67, CURLOPT_URL, $spddf3f5); curl_setopt($spa9fd67, CURLOPT_SSL_VERIFYPEER, true); curl_setopt($spa9fd67, CURLOPT_SSL_VERIFYHOST, 2); curl_setopt($spa9fd67, CURLOPT_FOLLOWLOCATION, true); curl_setopt($spa9fd67, CURLOPT_MAXREDIRS, 3); if ($sp701759 == 1) { curl_setopt($spa9fd67, CURLOPT_CUSTOMREQUEST, 'POST'); curl_setopt($spa9fd67, CURLOPT_POST, 1); if ($spa99fc2 !== '') { curl_setopt($spa9fd67, CURLOPT_POSTFIELDS, $spa99fc2); curl_setopt($spa9fd67, CURLOPT_POSTREDIR, 3); } } if (defined('MY_PROXY')) { $sp554d3f = MY_PROXY; $sp0e1f77 = CURLPROXY_HTTP; if (strpos($sp554d3f, 'http://') || strpos($sp554d3f, 'https://')) { $sp554d3f = str_replace('http://', $sp554d3f, $sp554d3f); $sp554d3f = str_replace('https://', $sp554d3f, $sp554d3f); $sp0e1f77 = CURLPROXY_HTTP; } elseif (strpos($sp554d3f, 'socks4://')) { $sp554d3f = str_replace('socks4://', $sp554d3f, $sp554d3f); $sp0e1f77 = CURLPROXY_SOCKS4; } elseif (strpos($sp554d3f, 'socks4a://')) { $sp554d3f = str_replace('socks4a://', $sp554d3f, $sp554d3f); $sp0e1f77 = CURLPROXY_SOCKS4A; } elseif (strpos($sp554d3f, 'socks5://')) { $sp554d3f = str_replace('socks5://', $sp554d3f, $sp554d3f); $sp0e1f77 = CURLPROXY_SOCKS5_HOSTNAME; } curl_setopt($spa9fd67, CURLOPT_PROXY, $sp554d3f); curl_setopt($spa9fd67, CURLOPT_PROXYTYPE, $sp0e1f77); if (defined('MY_PROXY_PASS')) { curl_setopt($spa9fd67, CURLOPT_PROXYUSERPWD, MY_PROXY_PASS); } } curl_setopt($spa9fd67, CURLOPT_TIMEOUT, $spb43dc2); curl_setopt($spa9fd67, CURLOPT_CONNECTTIMEOUT, $spb43dc2); curl_setopt($spa9fd67, CURLOPT_RETURNTRANSFER, 1); curl_setopt($spa9fd67, CURLOPT_HEADER, 1); curl_setopt($spa9fd67, CURLOPT_HTTPHEADER, $sp330405); $spf16c1a = curl_exec($spa9fd67); $sp69396e = curl_getinfo($spa9fd67, CURLINFO_HEADER_SIZE); $sp24d031 = substr($spf16c1a, 0, $sp69396e); $sp7337bd = substr($spf16c1a, $sp69396e); curl_close($spa9fd67); if ($sp620f5b !== false) { $sp697dbb = explode('
', $sp24d031); $sp78c6a2 = ''; foreach ($sp697dbb as $sp24d031) { if (strpos($sp24d031, 'Set-Cookie') !== false) { if (strpos($sp24d031, ';') !== false) { $sp78c6a2 = $sp78c6a2 . trim(Helper::str_between($sp24d031, 'Set-Cookie:', ';')) . ';'; } else { $sp78c6a2 = $sp78c6a2 . trim(str_replace('Set-Cookie:', '', $sp24d031)) . ';'; } } } $sp620f5b = self::combineCookie($sp620f5b, $sp78c6a2); } return $sp7337bd; } public static function get($spddf3f5, $sp697dbb = array(), $spb43dc2 = 5, &$sp620f5b = false) { return self::curl($spddf3f5, 0, '', $sp697dbb, $spb43dc2, $sp620f5b); } public static function post($spddf3f5, $spa99fc2 = '', $sp697dbb = array(), $spb43dc2 = 5, &$sp620f5b = false) { return self::curl($spddf3f5, 1, $spa99fc2, $sp697dbb, $spb43dc2, $sp620f5b); } public static function combineCookie($sp5fd1b4, $sp49fe0d) { $spf6089a = explode(';', $sp5fd1b4); $sp20f4af = explode(';', $sp49fe0d); foreach ($spf6089a as $sp8723dc) { if (self::cookieIsExists($sp20f4af, self::cookieGetName($sp8723dc)) == false) { array_push($sp20f4af, $sp8723dc); } } $sp31cad8 = ''; foreach ($sp20f4af as $sp8723dc) { if (substr($sp8723dc, -8, 8) != '=deleted' && strlen($sp8723dc) > 1) { $sp31cad8 .= $sp8723dc . '; '; } } return substr($sp31cad8, 0, strlen($sp31cad8) - 2); } public static function cookieGetName($sp1e61a3) { $spf5edea = strpos($sp1e61a3, '='); return substr($sp1e61a3, 0, $spf5edea); } public static function cookieGetValue($sp1e61a3) { $spf5edea = strpos($sp1e61a3, '='); $spa846c8 = substr($sp1e61a3, $spf5edea + 1, strlen($sp1e61a3) - $spf5edea); return $spa846c8; } public static function cookieGet($sp620f5b, $sp104c39, $sp98ec33 = false) { $sp620f5b = str_replace(' ', '', $sp620f5b); if (substr($sp620f5b, -1, 1) != ';') { $sp620f5b = ';' . $sp620f5b . ';'; } else { $sp620f5b = ';' . $sp620f5b; } $spda03ca = Helper::str_between($sp620f5b, ';' . $sp104c39 . '=', ';'); if (!$sp98ec33 || $spda03ca == '') { return $spda03ca; } else { return $sp104c39 . '=' . $spda03ca; } } private static function cookieIsExists($spd64748, $sp572747) { foreach ($spd64748 as $sp8723dc) { if (self::cookieGetName($sp8723dc) == $sp572747) { return true; } } return false; } function test() { $spa846c8 = self::combineCookie('a=1;b=2;c=3', 'c=5'); var_dump($spa846c8); } }