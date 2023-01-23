<?php
require_once "phpQuery.php";
ini_set('max_execution_time', 900);
$json = file_get_contents('php://input');
$obj = json_decode($json, true);
$urls = $obj['arr'];
$counter = $obj['counter'];
$res = [];
$text_result = "# !!!\n\n";

class OneHeaderTwo
{
    public $name;
    public $text;
    public function __construct($name, $text){
        $this->name = $name;
        $this->text = trim(strip_tags($text));
    }
}

function getContents($url){
    $headers = array(
        'cache-control: max-age=0',
        'upgrade-insecure-requests: 1',
        'user-agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36',
        'sec-fetch-user: ?1',
        'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
        'x-compress: null',
        'sec-fetch-site: none',
        'sec-fetch-mode: navigate',
//        'accept-encoding: deflate, br',
        'accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($ch);
    if (curl_errno($ch)) {
        return false;
    }
//    if( ! $output = curl_exec($ch))
//    {
////        trigger_error(curl_error($ch));
//        $output = "<h1>" . curl_error($ch) . "</h1>";
//    }
    curl_close($ch);
    return $output;
}
function convertEncoding($str) {
    return iconv(mb_detect_encoding($str), "UTF-8", $str);
}

function getHeaders($url){
    $html = getContents($url);
    $matches = [];
    $data = [];
    $result = [];
    if ($html !== false){
        $data_text = "## " . parse_url($url, PHP_URL_HOST) . "\n\n";
        preg_match_all("/(<([h1-4]+)[^>]*>)(.*?)(<\/\\2>)/", $html, $matches, PREG_OFFSET_CAPTURE);
        /*    preg_match_all("/<h[1-3]([^>]*>| ?>)[^<]+<\/h[1-3]>/", $html, $matches, PREG_OFFSET_CAPTURE);*/
        foreach ($matches[0] as $item){
            $pqs = phpQuery::newDocument($item[0]);
            $res = $pqs->find('h1,h2,h3,h4');
            $text = $pqs->text();
            $text = convertEncoding($text);
            $tag = $res->get(0)->tagName;
            if (strlen($text) !== 0) {
                $data[] = new OneHeaderTwo($tag, $text);
                switch ($tag){
                    case 'h1':
                    case 'h2':
                        $data_text .= "### <$tag> $text\n\n";
                        break;
                    case 'h3':
                        $data_text .= "- <$tag> $text\n\n";
                        break;
                    case 'h4':
                        $data_text .= "    - <$tag> $text\n\n";
                        break;
                }
            }
        }
        $data_text = convertEncoding($data_text);
        $result['text'] = $data_text;
        $result['data'] = $data;
    } else {
        $result['text'] = false;
        $result['data'] = false;
    }

    return $result;
}

foreach ($urls as $item){
    $res_data = getHeaders($item);
    $text_result .= $res_data['text'];
    $itemHeaders = $res_data['data'];
    $res['data_json'][parse_url($item, PHP_URL_HOST)][] = $itemHeaders;
}
$res['text'] = $text_result;


echo json_encode($res);