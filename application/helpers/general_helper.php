<?php
require "vendor/autoload.php";


function discord_alert($message)
{
    $url = "https://discord.com/api/webhooks/854804426798399528/-nw0zLwxyHtsifKYNpM3f7nZaDiutMK4oAFZo7cYA0Zb6BHB0ndF8hoXxx2KXOU35FLR";
    $headers = ['Content-Type: application/json; charset=utf-8'];
    $POST = ['username' => 'GestoAmigo', 'content' => $message];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($POST));
    $response = curl_exec($ch);

    return $response;
}

function xss_clean($data)
{
    // Fix &entity\n;
    $data = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);
    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
    $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
    $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

    // Remove any attribute starting with "on" or xmlns
    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

    // Remove javascript: and vbscript: protocols
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

    // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

    // Remove namespaced elements (we do not need them)
    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

    do {
        // Remove really unwanted tags
        $old_data = $data;
        $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
    } while ($old_data !== $data);

    // we are done...
    return $data;
}


if (!function_exists('dump')) {
    function dump($var, $label = 'Dump', $echo = true)
    {

        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
        $output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left;">' . $label . ' => ' . $output . '</pre>';

        if ($echo == true) {
            echo $output;
        } else {
        }
    }
}

function printJSON($response, $statusCode = 200)
{
    $ci = &get_instance();
    $ci->output->set_status_header($statusCode);
    $ci->output->set_content_type('application/json', 'utf-8');
    $ci->output->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
}

function format_error($errors)
{
    $error_formated = '';
    foreach ($errors as $error) {
        $error_formated .= $error . '<br>';
    }
    return $error_formated;
}

function mes_numero($numero)
{
    $meses = array(
        '01' => 'Janeiro',
        '02' => 'Fevereiro',
        '03' => 'Março',
        '04' => 'Abril',
        '05' => 'Maio',
        '06' => 'Junho',
        '07' => 'Julho',
        '08' => 'Agosto',
        '09' => 'Setembro',
        '10' => 'Outubro',
        '11' => 'Novembro',
        '12' => 'Dezembro',
    );
    return $meses[$numero];
}

function is_mobile()
{
    require_once 'application/libraries/Mobile_Detect.php';
    $detect = new Mobile_Detect;
    return $detect->isMobile();
}

function loggedInUser($redirect = true)
{
    $ci = &get_instance();
    $ci->load->library('ion_auth');
    if (!$ci->ion_auth->logged_in()) {
        if ($redirect) {
            redirect(base_url('auth/login'));
        } else {
            return false;
        }
    } else {
        return $ci->ion_auth->user()->row();
    }
}

if (!function_exists('encrypt')) {
    function encrypt($mensagem)
    {

        return $mensagem;
        return base64_encode($mensagem);
    }}

if (!function_exists('decrypt')) {
    function decrypt($mensagem, $a_chave_do_usuario = 'nicolebrasil')
    {
        return $mensagem;
        return base64_decode($mensagem);
    }}

if (!function_exists('filter_data')) {
    function filter_data($data)
    {
        $data = strip_tags($data);
        $data = trim($data);
        return $data;
    }
}

if (!function_exists('set_redirect')) {
    function set_redirect($url)
    {
        echo '<META http-equiv="refresh" content="5;URL=' . $url . '"> ';
    }
}

if (!function_exists('script_alert')) {
    function script_alert($msg)
    {
        echo '<script>alert("' . $msg . '");</script>';
    }
}

if (!function_exists('download')) {
    function download($file_source, $file_target)
    {
        $rh = fopen($file_source, 'rb');
        $wh = fopen($file_target, 'w+b');
        if (!$rh || !$wh) {
            return false;
        }

        while (!feof($rh)) {
            if (fwrite($wh, fread($rh, 4096)) === false) {
                return false;
            }
            echo ' ';
            flush();
        }

        fclose($rh);
        fclose($wh);

        return true;
    }
}

if (!function_exists('containsWord')) {
    function containsWord($str, $word)
    {
        return !!preg_match('#\\b' . preg_quote($word, '#') . '\\b#i', $str);
    }
}

if (!function_exists('customSearch')) {
    function customSearch($keyword, $arrayToSearch)
    {
        foreach ($arrayToSearch as $key => $arrayItem) {
            if (stristr($arrayItem, $keyword)) {
                return $key;
            }
        }
    }
}

if (!function_exists('random')) {
    function random($length)
    {
        $string = "";
        $chars = "abcdefghijklmanopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size = strlen($chars);
        for ($i = 0; $i < $length; $i++) {
            $string .= $chars[md5(rand(0, $size - 1))];
        }
        return $string;
    }
}

if (!function_exists('random_string')) {
    function random_string($length)
    {
        $string = "";
        $chars = "abcdefghijklmanopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size = strlen($chars);
        for ($i = 0; $i < $length; $i++) {
            $string .= $chars[rand(0, $size - 1)];
        }
        return $string;
    }
}

if (!function_exists('textile_sanitize')) {
    function textile_sanitize($string)
    {
        $whitelist = '/[^a-zA-Z0-9Ð°-ÑÐ-Ð¯Ã©Ã¼Ñ€Ñ‚Ñ…Ñ†Ñ‡ÑˆÑ‰ÑŠÑ‹ÑÑŽÑŒÐÑƒÑ„Ò \.\*\+\\n|#;:!"%@{} _-]/';
        return preg_replace($whitelist, '', $string);
    }
}

if (!function_exists('strong_md5')) {
    function strong_md5()
    {
        $makeitstronger = time() + (7 * 24 * 60 * 60);
        $makeitstronger = md5(md5($makeitstronger));
        return $makeitstronger;
    }
}

if (!function_exists('adsense')) {
    function adsense()
    {
        echo '   <div style="display: table;margin-right: auto;margin-left: auto;">
          <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
          <!-- teste -->
          <ins class="adsbygoogle"
               style="display:inline-block;width:728px;height:90px"
               data-ad-client="ca-pub-7873246719169304"
               data-ad-slot="6670787500"></ins>
          <script>
          (adsbygoogle = window.adsbygoogle || []).push({});
          </script>
          </div>';
    }
}

if (!function_exists('escape')) {
    function escape($string)
    {
        return textile_sanitize($string);
    }
}

if (!function_exists('array2Html')) {
    function array2Html($data)
    {
        $return = '';
        foreach ($data as $key => $value) {
            $return .= "<tr><td>" . $key . "</td>";
            if (is_array($value) || is_object($value)) {
                $return .= "<td>" . array2Html($value) . "  </td>";
            } else {
                $return .= "<td>" . $value . "</td></tr>";
            }
        }
        return $return;
    }
}

if (!function_exists('pretty_json')) {
    function pretty_json($json, $ret = "\n", $ind = "\t")
    {

        $beauty_json = '';
        $quote_state = false;
        $level = 0;

        $json_length = strlen($json);

        for ($i = 0; $i < $json_length; $i++) {

            $pre = '';
            $suf = '';

            switch ($json[$i]) {
                case '"':
                    $quote_state = !$quote_state;
                    break;

                case '[':
                    $level++;
                    break;

                case ']':
                    $level--;
                    $pre = $ret;
                    $pre .= str_repeat($ind, $level);
                    break;

                case '{':

                    if ($i - 1 >= 0 && $json[$i - 1] != ',') {
                        $pre = $ret;
                        $pre .= str_repeat($ind, $level);
                    }

                    $level++;
                    $suf = $ret;
                    $suf .= str_repeat($ind, $level);
                    break;

                case ':':
                    $suf = ' ';
                    break;

                case ',':

                    if (!$quote_state) {
                        $suf = $ret;
                        $suf .= str_repeat($ind, $level);
                    }
                    break;

                case '}':
                    $level--;

                case ']':
                    $pre = $ret;
                    $pre .= str_repeat($ind, $level);
                    break;

            }

            $beauty_json .= $pre . $json[$i] . $suf;

        }

        return $beauty_json;

    }
}
if (!function_exists('do_debug')) {
    function do_debug($data, $level = true)
    {
        echo '<pre><code>';
        if ($level) {
            var_dump($data);
        } else {
            print_r($data);
        }
        echo '</code></pre>';
    }

    if (!function_exists('validate_recaptcha')) {
        function validate_recaptcha()
        {

            $vetParametros = array(
                "secret" => "6LfIs70aAAAAAJ6lv6Ec3un3QtCeuLMFqdGbhMA2",
                "response" => $_POST["g-recaptcha-response"],
                "remoteip" => $_SERVER["REMOTE_ADDR"],
            );

            $curlReCaptcha = curl_init();
            curl_setopt($curlReCaptcha, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
            curl_setopt($curlReCaptcha, CURLOPT_POST, true);
            curl_setopt($curlReCaptcha, CURLOPT_POSTFIELDS, http_build_query($vetParametros));
            curl_setopt($curlReCaptcha, CURLOPT_RETURNTRANSFER, true);
            $vetResposta = json_decode(curl_exec($curlReCaptcha), true);
            curl_close($curlReCaptcha);

            if ($vetResposta["success"]) {
                return array('success' => true);
            } else {
                $errors = array();
                foreach ($vetResposta["error-codes"] as $strErro) {
                    $errors[] = ['tab' => $strTab, 'strErro' => $strErro];
                }
                return array('success' => false, 'errors' => $errors);
            }
        }
    }

    if (!function_exists('aws_upload')) {
        function aws_upload()
        {
            require 'vendor/autoload.php';

            $bucket = 'development.centroavante.com.br';
            $keyname = 'HU/9qkioyZpRXeDFr/ugrGChGAHeBV4/fH8M2ul/';

            $s3 = new S3Client([
                'version' => 'latest',
                'region' => 'us-east-1',
            ]);

            try {
                // Upload data.
                $result = $s3->putObject([
                    'Bucket' => $bucket,
                    'Key' => $keyname,
                    'Body' => 'Hello, world!',
                    'ACL' => 'public-read',
                ]);

                // Print the URL to the object.
                echo $result['ObjectURL'] . PHP_EOL;
            } catch (S3Exception $e) {
                echo $e->getMessage() . PHP_EOL;
            }
        }
    }

    function is_data_passed($date)
    {
        $now = date("Y/m/d H:i:s");
        if (strtotime($date) > strtotime($now)) {
            return true;
        }
    }

    function slugify($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

}