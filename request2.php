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
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}


function getHeaders($url):string{
    $html = getContents($url);
    $matches = [];
    $data_text = "## " . parse_url($url, PHP_URL_HOST) . "\n\n";
    preg_match_all("/(<([h1-4]+)[^>]*>)(.*?)(<\/\\2>)/", $html, $matches, PREG_OFFSET_CAPTURE);
/*    preg_match_all("/<h[1-3]([^>]*>| ?>)[^<]+<\/h[1-3]>/", $html, $matches, PREG_OFFSET_CAPTURE);*/
    foreach ($matches[0] as $item){
        $pqs = phpQuery::newDocument($item[0]);
        $res = $pqs->find('h1,h2,h3,h4');
        $text = $pqs->text();
        $tag = $res->get(0)->tagName;
        if (strlen($text) !== 0) {
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
    return $data_text;
}
foreach ($urls as $item){
    $text_result .= getHeaders($item);
}
$res['text'] = $text_result;
echo json_encode($res);