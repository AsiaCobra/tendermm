<?php
if (!defined('ABSPATH')) {
    exit;
}


if (!class_exists('Clockwork')) {
    require_once plugin_dir_path(__DIR__) . 'gateways/clockwork/wordpress/class-clockwork-plugin.php';
}


if (!class_exists('Melipayamak\MelipayamakApi')) {
    require_once plugin_dir_path(__DIR__) . 'gateways/melipayamak/autoload.php';
}

require_once plugin_dir_path(__DIR__) . 'Twilio/autoload.php';


if (!class_exists('ComposerAutoloaderInit90fceaf4b778149483bc47bcb466a797')) {
    require_once plugin_dir_path(__DIR__) . 'gateways/alibaba/autoload.php';
}


if (!class_exists('AdnSms\AdnSmsNotification')) {
    require_once plugin_dir_path(__DIR__) . 'gateways/AdnSms/AdnSmsNotification.php';
}
if (!function_exists('Aws\parse_ini_file')) {
    require_once plugin_dir_path(__DIR__) . 'gateways/aws/aws-autoloader.php';
}


require_once plugin_dir_path(__DIR__) . 'libphonenumber/autoload.php';


use AdnSms\AdnSmsNotification;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use Aws\Exception\AwsException;
use Aws\Sns\SnsClient;
use Melipayamak\MelipayamakApi;
use Twilio\Rest\Client;


if (function_exists('digit_send_message')) {
    return;
}
function digit_whatsapp_message($countrycode, $mobile, $otp, $dig_messagetemplate, $testCall)
{


    $whatsapp_gateway = get_option('digit_whatsapp_gateway', -1);
    $prefix = 'whatsapp';
    switch ($whatsapp_gateway) {
        case 2:
            $whatsapp = get_option('digit_' . $prefix . 'twilio');
            $whatsappno = $whatsapp['whatsappnumber'];
            $sid = $whatsapp['account_sid'];
            $token = $whatsapp['auth_token'];

            try {
                $client = new Client($sid, $token);
                $result = $client->messages->create(
                    "whatsapp:" . $countrycode . $mobile,
                    array(
                        'From' => "whatsapp:" . $whatsappno,
                        'Body' => $dig_messagetemplate
                    )
                );
            } catch (Exception $e) {
                if ($testCall) {
                    return $e->getMessage();
                }

                return false;
            }

            if ($testCall) {
                return $result;
            }

            return true;
        default:
            return false;
    }
}

function digit_send_message($digit_gateway, $countrycode, $mobile, $otp, $dig_messagetemplate, $testCall = false, $whatsapp = false)
{

    $option_slug = 'digit';
    $gateway_id = $digit_gateway;
    $messagetemplate = $dig_messagetemplate;

    if (!$testCall) {
        $debug = apply_filters('digits_debug', false);
        if ($debug) {
            return true;
        }
    }

    if (str_replace('+', '', $countrycode) == '242') {
        if (substr($mobile, 0, 1) != '0') {
            $mobile = '0' . $mobile;
        }
    }

    if ($whatsapp) {
        return digit_whatsapp_message($countrycode, $mobile, $otp, $dig_messagetemplate, $testCall);
    }

    switch ($digit_gateway) {
        case 2:


            $tiwilioapicred = get_option('digit_twilio_api');


            $twiliosenderid = $tiwilioapicred['twiliosenderid'];


            $sid = $tiwilioapicred['twiliosid'];
            $token = $tiwilioapicred['twiliotoken'];


            try {
                $client = new Client($sid, $token);
                $result = $client->messages->create(
                    $countrycode . $mobile,
                    array(
                        'From' => $twiliosenderid,
                        'Body' => $dig_messagetemplate
                    )
                );
            } catch (Exception $e) {
                if ($testCall) {
                    return $e->getMessage();
                }

                return false;
            }

            if ($testCall) {
                return $result;
            }

            return true;
        case 3:

            $msg91apicred = get_option('digit_msg91_api');


            $authKey = $msg91apicred['msg91authkey'];
            $senderId = $msg91apicred['msg91senderid'];
            $msg91route = $msg91apicred['msg91route'];

            if (empty($msg91route)) {
                $msg91route = 2;
            }
            $message = urlencode($dig_messagetemplate);

            if ($msg91route == 1) {


                $postData = array(
                    'authkey' => $authKey,
                    'mobile' => str_replace("+", "", $countrycode) . $mobile,
                    'message' => $message,
                    'sender' => $senderId,
                    'otp' => $otp,
                    'otp_expiry' => 10
                );


                $url = "https://control.msg91.com/api/sendotp.php?" . http_build_query($postData);
                $ch = curl_init();
                curl_setopt_array($ch, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => 'GET'

                ));
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                $result = curl_exec($ch);


                if ($testCall) {
                    return $result;
                }

                if (curl_errno($ch)) {

                    if ($testCall) {
                        return "curl error:" . curl_errno($ch);
                    }

                    return false;
                }

                curl_close($ch);

            } else {


                $postData = array(
                    'authkey' => $authKey,
                    'mobiles' => str_replace("+", "", $countrycode) . $mobile,
                    'message' => $message,
                    'sender' => $senderId,
                    'route' => 4,
                    'country' => 0
                );


                $url = "https://control.msg91.com/api/sendhttp.php";
                $ch = curl_init();
                curl_setopt_array($ch, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $postData

                ));
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                $result = curl_exec($ch);


                if (curl_errno($ch)) {
                    if ($testCall) {
                        return "curl error:" . curl_errno($ch);
                    }

                    return false;
                }
                curl_close($ch);

                if ($testCall) {
                    return $result;
                }

                return true;
            }

            return true;

        case 4:
            $apikey = get_option('digit_yunpianapi');

            $data = array('text' => $dig_messagetemplate, 'apikey' => $apikey, 'mobile' => $countrycode . $mobile);


            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept:text/plain;charset=utf-8',
                'Content-Type:application/x-www-form-urlencoded',
                'charset=utf-8'
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            curl_setopt($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            $result = curl_exec($ch);


            if (curl_errno($ch)) {
                if ($testCall) {
                    return "curl error:" . curl_errno($ch);
                }

                return false;
            }
            curl_close($ch);

            if ($testCall) {
                return $result;
            }

            if ($result === false) {
                return false;
            }

            return true;
        case 5:

            $clickatell = get_option('digit_clickatell');

            $apikey = $clickatell['api_key'];
            $from = $clickatell['from'];


            $toarray = array();
            $toarray[] = $countrycode . $mobile;

            $cs_array = array();
            $cs_array['content'] = $dig_messagetemplate;
            if (!empty($from)) {
                $cs_array['from'] = $from;
            }
            $data = $cs_array;
            $data['to'] = $toarray;
            $data_string = json_encode($data);


            $ch = curl_init();


            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: ' . $apikey,

            ));


            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

            curl_setopt($ch, CURLOPT_URL, 'https://platform.clickatell.com/messages');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            $result = curl_exec($ch);


            if (curl_errno($ch)) {
                if ($testCall) {
                    return "curl error:" . curl_errno($ch);
                }

                return false;
            }
            curl_close($ch);

            if ($testCall) {
                return $result;
            }

            if ($result === false) {
                return false;
            }


            return true;
        case 6:
            $clicksend = get_option('digit_clicksend');
            $username = $clicksend['apiusername'];
            $apikey = $clicksend['apikey'];
            $from = $clicksend['from'];


            $data = array();
            $message = array();
            $message[0] = array(
                'body' => $dig_messagetemplate,
                'from' => $from,
                'to' => $countrycode . $mobile
            );
            $data['messages'] = $message;

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode("$username:$apikey")
            ));

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            curl_setopt($ch, CURLOPT_URL, 'https://rest.clicksend.com/v3/sms/send');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            $result = curl_exec($ch);


            if (curl_errno($ch)) {
                if ($testCall) {
                    return "curl error:" . curl_errno($ch);
                }

                return false;
            }
            curl_close($ch);

            if ($result === false) {
                return false;
            }

            if ($testCall) {
                return $result;
            }

            return true;
        case 7:

            try {


                $clockwork = get_option('digit_clockwork');


                $clockworkapi = $clockwork['clockworkapi'];
                $from = $clockwork['from'];


                $clockwork = new WordPressClockwork($clockworkapi);

                // Setup and send a message
                $message = array(
                    'from' => $from,
                    'to' => str_replace("+", "", $countrycode) . $mobile,
                    'message' => $dig_messagetemplate
                );
                $result = $clockwork->send($message);

                // Check if the send was successful
                if ($result['success']) {

                    if ($testCall) {
                        return $result;
                    }

                    return true;

                } else {
                    return false;
                }
            } catch (ClockworkException $e) {
                if ($testCall) {
                    return $e->getMessage();
                }

                return false;

            }
        case 8:

            $messagebird = get_option('digit_messagebird');
            $accesskey = $messagebird['accesskey'];
            $originator = $messagebird['originator'];
            $data = array(
                'body' => $dig_messagetemplate,
                'originator' => $originator,
                'recipients' => str_replace("+", "", $countrycode) . $mobile
            );


            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: AccessKey ' . $accesskey
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            curl_setopt($ch, CURLOPT_URL, 'https://rest.messagebird.com/messages?access_key=' . $accesskey);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            $result = curl_exec($ch);
            curl_close($ch);

            if (curl_errno($ch)) {
                if ($testCall) {
                    return "curl error:" . curl_errno($ch);
                }

                return false;
            }

            if ($testCall) {
                return $result;
            }

            if ($result === false) {
                return false;
            }

            return true;

        case 9:
            $mobily = get_option('digit_mobily_ws');

            $mobily_mobile = $mobily['mobile'];
            $password = $mobily['password'];
            $sender = $mobily['sender'];

            $data = array(
                'msg' => convertToUnicode($dig_messagetemplate),
                'mobile' => $mobily_mobile,
                'password' => $password,
                'sender' => $sender,
                'applicationType' => '68',
                'numbers' => str_replace("+", "", $countrycode) . $mobile
            );


            $ch = curl_init();

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            curl_setopt($ch, CURLOPT_URL, 'http://mobily.ws/api/msgSend.php?' . http_build_query($data));
            $result = curl_exec($ch);


            if (curl_errno($ch)) {
                if ($testCall) {
                    return "curl error:" . curl_errno($ch);
                }

                return false;
            }
            curl_close($ch);

            if ($testCall) {
                return $result;
            }

            if ($result === false) {
                return false;
            }

            return true;
        case 10:
            $nexmo = get_option('digit_nexmo');
            $from = $nexmo['from'];
            $apikey = $nexmo['api_key'];
            $apisecret = $nexmo['api_secret'];

            $data = array(
                'text' => $dig_messagetemplate,
                'to' => $countrycode . $mobile,
                'from' => $from,
                'type' => 'unicode',
                'api_key' => $apikey,
                'api_secret' => $apisecret
            );


            $ch = curl_init();


            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            curl_setopt($ch, CURLOPT_URL, 'https://rest.nexmo.com/sms/json');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            $result = curl_exec($ch);


            if (curl_errno($ch)) {
                if ($testCall) {
                    return "curl error:" . curl_errno($ch);
                }

                return false;
            }
            curl_close($ch);

            if ($testCall) {
                return $result;
            }

            if ($result === false) {
                return false;
            }

            return true;
        case 11:
            $pilvo = get_option('digit_plivo');
            if (empty($pilvo) || !$pilvo) {
                $pilvo = get_option('digit_pilvo');
            }
            $authid = $pilvo['auth_id'];
            $authtoken = $pilvo['auth_token'];
            $sender_id = $pilvo['sender_id'];

            $data = array(
                'text' => $dig_messagetemplate,
                'src' => $sender_id,
                'dst' => $countrycode . $mobile,
            );


            $ch = curl_init();

            curl_setopt($ch, CURLOPT_USERPWD, $authid . ":" . $authtoken);

            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            curl_setopt($ch, CURLOPT_URL, 'https://api.plivo.com/v1/Account/' . $authid . '/Message/');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            $result = curl_exec($ch);


            if (curl_errno($ch)) {
                if ($testCall) {
                    return "curl error:" . curl_errno($ch);
                }

                return false;
            }
            curl_close($ch);

            if ($testCall) {
                return $result;
            }

            if ($result === false) {
                return false;
            }

            return true;
        case 12:

            $smsapi = get_option('digit_smsapi');
            $token = $smsapi['token'];
            $from = $smsapi['from'];
            $params = array(
                'to' => str_replace("+", "", $countrycode) . $mobile,
                'from' => $from,
                'message' => $dig_messagetemplate,
            );

            $url = 'https://api.smsapi.com/sms.do';
            $c = curl_init();
            curl_setopt($c, CURLOPT_URL, $url);
            curl_setopt($c, CURLOPT_POST, true);
            curl_setopt($c, CURLOPT_POSTFIELDS, $params);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($c, CURLOPT_HTTPHEADER, array(
                "Authorization: Bearer $token"
            ));

            $content = curl_exec($c);
            $http_status = curl_getinfo($c, CURLINFO_HTTP_CODE);


            if ($testCall) {
                return $content;
            }

            if (curl_errno($c)) {
                if ($testCall) {
                    return "curl error:" . curl_errno($c);
                }

                return false;
            }

            curl_close($c);

            if ($http_status != 200) {
                return false;
            }

            return true;
        case 13:
            return true;
        case 14:
            $unifonic = get_option('digit_unifonic');
            $app_sid = $unifonic['appsid'];
            $sender_id = $unifonic['senderid'];

            $params = 'AppSid=' . $app_sid . '&Recipient=' . str_replace("+", "", $countrycode) . $mobile . '&Body=' . $dig_messagetemplate;
            if (!empty($sender_id)) {
                $params = $params . "&SenderID=" . $sender_id;
            }


            $c = curl_init();
            curl_setopt($c, CURLOPT_URL, "http://api.unifonic.com/rest/Messages/Send");
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($c, CURLOPT_HEADER, false);
            curl_setopt($c, CURLOPT_POST, true);
            curl_setopt($c, CURLOPT_POSTFIELDS, $params);


            curl_setopt($c, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
            $result = curl_exec($c);


            if ($testCall) {
                return $result;
            }
            if (curl_errno($c)) {
                if ($testCall) {
                    return "curl error:" . curl_errno($c);
                }

                return false;
            }

            curl_close($c);

            if ($result === false) {
                return false;
            }

            return true;
        case 15:

            $kaleyra = get_option('digit_kaleyra');
            $api_key = $kaleyra['api_key'];
            $sender_id = $kaleyra['sender_id'];
            $curl = curl_init();


            $url = "http://api-alerts.solutionsinfini.com/v4/?method=sms&sender=" . $sender_id . "&to=" . str_replace("+", "", $countrycode) . $mobile . "&message=" . urlencode($dig_messagetemplate) . "&api_key=" . $api_key;

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
            ));
            $result = curl_exec($curl);

            if (curl_errno($curl)) {
                $result = curl_error($curl);
                if (!$testCall) {
                    return false;
                }
            }
            curl_close($curl);


            if ($testCall) {
                return $result;
            }

            return true;
        case 16:
            $melipayamak = get_option('digit_melipayamak');

            $username = $melipayamak['username'];
            $password = $melipayamak['password'];
            $from = $melipayamak['from'];
            $api = new MelipayamakApi($username, $password);
            $sms = $api->sms();
            $to = '0' . $mobile;
            $result = $sms->send($to, $from, $dig_messagetemplate);
            if ($testCall) {
                return $result;
            }

            return true;

        case 17:
            $textlocal = get_option('digit_textlocal');
            $apiKey = $textlocal['api_key'];
            $sender = $textlocal['sender'];


            $apiKey = urlencode($apiKey);
            $sender = urlencode($sender);
            $message = rawurlencode($dig_messagetemplate);
            $numbers = str_replace("+", "", $countrycode) . $mobile;


            $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);


            $ch = curl_init('https://api.textlocal.in/send/');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);


            if (curl_errno($ch)) {
                $result = curl_error($ch);
                if (!$testCall) {
                    return false;
                }
            }


            curl_close($ch);

            if ($testCall) {
                return $result;
            }


            return true;
        case 18:

            $alibaba = get_option('digit_alibaba');
            $access_key = $alibaba['access_key'];
            $access_secret = $alibaba['access_secret'];
            $from = $alibaba['from'];

            $number = str_replace("+", "", $countrycode) . $mobile;

            try {
                AlibabaCloud::accessKeyClient($access_key, $access_secret)
                    ->regionId('ap-southeast-1')
                    ->asDefaultClient();

                $result = AlibabaCloud::rpc()
                    ->product('Dysmsapi')
                    ->host('dysmsapi.ap-southeast-1.aliyuncs.com')
                    ->version('2018-05-01')
                    ->action('SendMessageToGlobe')
                    ->method('POST')
                    ->options([
                        'query' => [
                            "To" => $number,
                            "From" => $from,
                            "Message" => $dig_messagetemplate,
                        ],
                    ])
                    ->request();

            } catch (ClientException $e) {
                if ($testCall) {
                    return $e->getErrorMessage();
                }

                return false;
            } catch (ServerException $e) {
                if ($testCall) {
                    return $e->getErrorMessage();
                }

                return false;
            } catch (Exception $e) {
                if ($testCall) {
                    return $e->getErrorMessage();
                }

                return false;
            }
            if ($testCall) {
                return $result;
            }

            return true;
        case 33:
            $alibaba = get_option('digit_alibaba_go_china');
            $access_key = $alibaba['access_key'];
            $access_secret = $alibaba['access_secret'];
            $from = $alibaba['from'];
            $template_code = $alibaba['templatecode'];
            $smsupextendcode = $alibaba['smsupextendcode'];

            $template_param = json_encode(array('otp' => $otp));

            $number = str_replace("+", "", $countrycode) . $mobile;

            try {
                AlibabaCloud::accessKeyClient($access_key, $access_secret)
                    ->regionId('ap-southeast-1')
                    ->asDefaultClient();

                $result = AlibabaCloud::rpc()
                    ->product('Dysmsapi')
                    ->host('dysmsapi.ap-southeast-1.aliyuncs.com')
                    ->version('2018-05-01')
                    ->action('SendMessageWithTemplate')
                    ->method('POST')
                    ->options([
                        'query' => [
                            "TemplateCode" => $template_code,
                            "TemplateParam" => $template_param,
                            "SmsUpExtendCode" => $smsupextendcode,
                            "To" => $number,
                            "From" => $from,
                            "Message" => $dig_messagetemplate,
                        ],
                    ])
                    ->request();

            } catch (ClientException $e) {
                if ($testCall) {
                    return $e->getErrorMessage();
                }

                return false;
            } catch (ServerException $e) {
                if ($testCall) {
                    return $e->getErrorMessage();
                }

                return false;
            } catch (Exception $e) {
                if ($testCall) {
                    return $e->getErrorMessage();
                }

                return false;
            }
            if ($testCall) {
                return $result;
            }

            return true;
        case 19:
            $adnsms = get_option('digit_adnsms');
            $api_key = $adnsms['api_key'];
            $api_secret = $adnsms['api_secret'];
            $requestType = 'OTP';
            $messageType = 'UNICODE';
            $number = str_replace("+", "", $countrycode) . $mobile;

            $sms = new AdnSmsNotification($api_key, $api_secret);
            $result = $sms->sendSms($requestType, $dig_messagetemplate, $number, $messageType);
            if ($testCall) {
                return $result;
            }

            return true;
        case 20:
            $netgsm = get_option('digit_netgsm');
            $username = $netgsm['username'];
            $password = $netgsm['password'];
            $from = $netgsm['from'];
            $phone = str_replace("+", "", $countrycode) . $mobile;
            $request_url = 'https://api.netgsm.com.tr/sms/send/otp';
            $xml = array(
                'body' => '<?xml version="1.0"?>
                                <mainbody>
                                    <header>
                                        <usercode>' . $username . '</usercode>
                                        <password>' . $password . '</password>
                                        <msgheader>' . $from . '</msgheader>
                                    </header>
                                    <body>
                                        <msg><![CDATA[' . $dig_messagetemplate . ']]></msg>
                                        <no>' . $phone . '</no>
                                    </body>
                                </mainbody>'
            );
            $result = wp_remote_post($request_url, $xml);
            if ($testCall) {
                return $result;
            }

            return true;
        case 21:
            $smsc = get_option('digit_smsc_ru');
            $login = $smsc['login'];
            $psw = $smsc['password'];
            $sender = $smsc['sender'];
            $phone = $countrycode . $mobile;

            $data = array(
                'mes' => $dig_messagetemplate,
                'sender' => $sender,
                'login' => $login,
                'psw' => $psw,
                'phones' => $phone
            );


            $ch = curl_init();

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_URL, 'https://smsc.ru/sys/send.php?' . http_build_query($data));
            $result = curl_exec($ch);


            curl_close($ch);

            if ($result === false) {
                return false;
            }

            if ($testCall) {
                return $result;
            }

            return true;

        case 22:
            $targetSms = get_option('digit_targetsms');
            $login = $targetSms['login'];
            $pwd = $targetSms['password'];
            $sender = $targetSms['sender'];

            $phone = str_replace("+", "", $countrycode) . $mobile;
            
            $src = '<?xml version="1.0" encoding="utf-8"?>
<request><security><login value="' . $login . '" /><password value="' . $pwd . '" /></security>
<message><sender>' . $sender . '</sender><text>' . $dig_messagetemplate . '</text><abonent phone="' . $phone . '" /></message></request>';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: text/xml; charset=utf-8'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CRLF, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $src);
            curl_setopt($ch, CURLOPT_URL, 'https://sms.targetsms.ru/xml/');
            $result = curl_exec($ch);
            curl_close($ch);

            if ($result === false) {
                return false;
            }

            if ($testCall) {
                return $result;
            }

            return true;
        case 23:
            $ghasedak = get_option('digit_ghasedak');

            $api_key = $ghasedak['api_key'];

            $headers = array(
                'apikey:' . $api_key,
                'Accept: application/json',
                'Content-Type: application/x-www-form-urlencoded',
                'charset: utf-8'
            );

            $params = array(
                "receptor" => $mobile,
                "message" => $dig_messagetemplate
            );


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CRLF, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_URL, 'http://api.ghasedak.io/v2/sms/send/simple');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

            $result = curl_exec($ch);
            curl_close($ch);

            if ($result === false) {
                return false;
            }

            if ($testCall) {
                return $result;
            }


            return true;
        case 24:
            $farapayamak = get_option('digit_farapayamak');
            $username = $farapayamak['username'];
            $password = $farapayamak['password'];
            $from = $farapayamak['sender'];

            $phone = str_replace("+", "", $countrycode) . $mobile;

            $params = array(
                "UserName" => $username,
                "PassWord" => $password,
                "From" => $from,
                "To" => $phone,
                "Text" => $dig_messagetemplate,
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=utf-8'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CRLF, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            curl_setopt($ch, CURLOPT_URL, 'http://api.payamak-panel.com/post/Send.asmx');
            $result = curl_exec($ch);
            curl_close($ch);

            if ($result === false) {
                return false;
            }

            if ($testCall) {
                return $result;
            }

            return true;
        case 25:
            $sns = get_option('digit_amazon_sns');


            try {
                $SnSclient = new SnsClient([
                    'region' => $sns['region'],
                    'version' => 'latest',
                    'credentials' => [
                        'key' => $sns['access_key'],
                        'secret' => $sns['access_secret'],
                    ],
                ]);
                $result = $SnSclient->publish([
                    'Message' => $dig_messagetemplate,
                    'PhoneNumber' => $countrycode . $mobile,
                    'MessageAttributes' => [
                        'AWS.SNS.SMS.SenderID' => [
                            'DataType' => 'String',
                            'StringValue' => $sns['sender_id'],
                        ],
                        'AWS.SNS.SMS.SMSType' => [
                            'DataType' => 'String',
                            'StringValue' => 'Transactional',
                        ]
                    ],
                ]);
                if ($testCall) {
                    return $result;
                } else {
                    return true;
                }
            } catch (AwsException $e) {
                if ($testCall) {
                    return $e->getMessage();
                } else {
                    return false;
                }
            }

            return true;

        case 26:
            $africastalking = get_option('digit_africastalking');

            $username = $africastalking['username'];
            $api_key = $africastalking['api_key'];
            $from = $africastalking['from'];

            $headers = array(
                'apikey:' . $api_key,
                'Accept: application/json',
                'Content-Type: application/x-www-form-urlencoded',
                'Accept' => 'application/json'
            );

            $params = array(
                "username" => $username,
                "to" => $countrycode . $mobile,
                "message" => $dig_messagetemplate,
                "from" => $from,
            );


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CRLF, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_URL, 'https://api.africastalking.com/version1/messaging');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

            $result = curl_exec($ch);
            curl_close($ch);

            if ($result === false) {
                return false;
            }

            if ($testCall) {
                return $result;
            }


            return true;
        case 27:
            /*$cm      = get_option( 'digit_cm' );
            $api_key = $cm['api_key'];
            $from    = $cm['from'];


            if ( $result === false ) {
                return false;
            }

            if ( $testCall ) {
                return $result;
            }

            return true;*/
        case 28:
            $alfa_cell = get_option('digit_alfa_cell');

            $api_key = $alfa_cell['api_key'];
            $sender = $alfa_cell['sender'];

            $data = array(
                'msg' => convertToUnicode($dig_messagetemplate),
                'apiKey' => $api_key,
                'sender' => $sender,
                'applicationType' => '68',
                'numbers' => str_replace("+", "", $countrycode) . $mobile
            );


            $ch = curl_init();

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            curl_setopt($ch, CURLOPT_URL, 'https://www.alfa-cell.com/api/msgSend.php?' . http_build_query($data));
            $result = curl_exec($ch);


            if (curl_errno($ch)) {
                if ($testCall) {
                    return "curl error:" . curl_errno($ch);
                }

                return false;
            }
            curl_close($ch);

            if ($testCall) {
                return $result;
            }

            if ($result === false) {
                return false;
            }

            return true;

        case 29:
            $apicred = get_option('digit_ibulksms');

            $authKey = $apicred['auth_key'];
            $senderId = $apicred['sender'];


            $message = urlencode($dig_messagetemplate);


            $postData = array(
                'authkey' => $authKey,
                'mobiles' => str_replace("+", "", $countrycode) . $mobile,
                'message' => $message,
                'sender' => $senderId,
                'route' => 4,
                'country' => 0
            );


            $url = "https://manage.ibulksms.in/api/sendhttp.php";
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $postData

            ));
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $result = curl_exec($ch);


            if (curl_errno($ch)) {
                if ($testCall) {
                    return "curl error:" . curl_errno($ch);
                }

                return false;
            }
            curl_close($ch);

            if ($testCall) {
                return $result;
            }

            return true;
        case 30:
            $pinpoint = get_option('digit_amazon_pinpoint');
            $app_id = $pinpoint['app_id'];
            $from = $pinpoint['sender_id'];


            try {
                $pinpointClient = new Aws\Pinpoint\PinpointClient([
                    'region' => $pinpoint['region'],
                    'version' => 'latest',
                    'credentials' => [
                        'key' => $pinpoint['access_key'],
                        'secret' => $pinpoint['access_secret'],
                    ],
                ]);
                $result = $pinpointClient->sendMessages([
                    'ApplicationId' => $app_id, // REQUIRED
                    'MessageRequest' => [ // REQUIRED
                        'Addresses' => [
                            $countrycode . $mobile => [
                                'ChannelType' => 'SMS',
                            ],
                        ],
                        'MessageConfiguration' => [ // REQUIRED
                            'SMSMessage' => [
                                'Body' => $dig_messagetemplate,
                                'MessageType' => 'TRANSACTIONAL',
                                'SenderId' => $from,
                            ],
                        ]
                    ],
                ]);
                if ($testCall) {
                    return $result;
                } else {
                    return true;
                }
            } catch (AwsException $e) {
                if ($testCall) {
                    return $e->getMessage();
                } else {
                    return false;
                }
            }

            return true;
        case 31:
            $sendinblue = get_option('digit_sendinblue');

            $api_key = $sendinblue['api_key'];
            $sender = $sendinblue['sender'];

            $headers = array(
                'api-key:' . $api_key,
                'accept: application/json',
                'Content-Type: application/json',
                'charset: utf-8'
            );

            $params = array(
                "sender" => $sender,
                "recipient" => $countrycode . $mobile,
                "content" => $dig_messagetemplate,
                "type" => "transactional"
            );


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CRLF, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_URL, 'https://api.sendinblue.com/v3/transactionalSMS/sms');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

            $result = curl_exec($ch);
            curl_close($ch);

            if ($result === false) {
                return false;
            }

            if ($testCall) {
                return $result;
            }


            return true;
        case 32:
            $infobip = get_option('digit_infobip');

            $api_key = $infobip['api_key'];
            $base_url = $infobip['base_url'];
            $from = $infobip['from'];

            $curl = curl_init();

            $fields = array(
                'from' => $from,
                'to' => str_replace("+", "", $countrycode) . $mobile,
                'text' => $dig_messagetemplate,
            );
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://" . $base_url . "/sms/2/text/single",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($fields),
                CURLOPT_HTTPHEADER => array(
                    "accept: application/json",
                    "authorization: App " . $api_key,
                    "content-type: application/json"
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            if ($testCall) {
                return $response;
            }

            if ($response === false) {
                return false;
            }

            return true;
        case 900:
            $gateway = get_option('digit_custom_gateway');
            $url = $gateway['gateway_url'];
            $http_method = $gateway['http_method'];
            $send_body_data = $gateway['send_body_data'];
            $http_headers = explode(',', $gateway['http_header']);

            $attrs = $gateway['gateway_attributes'];

            $sender_id = $gateway['sender_id'];

            $number_type = $gateway['phone_number'];


            if ($number_type == 1) {
                $to = $countrycode . $mobile;
            } else if ($number_type == 2) {
                $to = str_replace("+", "", $countrycode) . $mobile;
            } else {
                $to = $mobile;
            }


            $attrs = str_replace(array("\r", "\n"), '', $attrs);
            $attrs = explode(',', $attrs);

            $data = array();
            foreach ($attrs as $attr) {
                $params = explode(':', $attr);
                if (empty($params)) continue;

                $params = explode(':', $attr, 2);
                if (empty($params)) continue;
                $attr_value = '';
                if (isset($params[1]))
                    $attr_value = str_replace(array('{to}', '{sender_id}', '{message}'), array($to, $sender_id, $dig_messagetemplate), $params[1]);

                $data[trim($params[0])] = trim($attr_value);
            }

            $ch = curl_init();

            if (strtolower($http_method) == 'get') {
                $url = $url . '?' . http_build_query($data);
            } else {
                if ($send_body_data == 1) {
                    $data = json_encode($data);
                }
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }

            if (!empty($http_headers)) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, $http_headers);
            }


            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $http_method);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


            $response = curl_exec($ch);

            curl_close($ch);

            if ($testCall) {
                return $response;
            }

            if ($response === false) {
                return false;
            }

            return true;

        case 38:
            $gateway_fields = get_option($option_slug . '_spryng');

            require_once plugin_dir_path(__DIR__) . 'gateways/spryng.php';

            return \SMSGateway\Spryng::sendSMS(
                $gateway_fields, $countrycode . $mobile, $messagetemplate, $testCall
            );

        case 40:
            $gateway_fields = get_option($option_slug . '_bandwidth');

            require_once plugin_dir_path(__DIR__) . 'gateways/bandwidth.php';

            return \SMSGateway\Bandwidth::sendSMS(
                $gateway_fields, $countrycode . $mobile, $messagetemplate, $testCall
            );
        case 68:
            $gateway_fields = get_option($option_slug . '_esendex');

            require_once plugin_dir_path(__DIR__) . 'gateways/esendex.php';

            return \SMSGateway\Esendex::sendSMS(
                $gateway_fields, $countrycode . $mobile, $messagetemplate, $testCall
            );
        case 71:
            $gateway_fields = get_option($option_slug . '_fortytwo');

            require_once plugin_dir_path(__DIR__) . 'gateways/fortytwo.php';

            return \SMSGateway\FortyTwo::sendSMS(
                $gateway_fields, $countrycode . $mobile, $messagetemplate, $testCall
            );
        case 89:
            $gateway_fields = get_option($option_slug . '_unisender');

            require_once plugin_dir_path(__DIR__) . 'gateways/unisender.php';

            return \SMSGateway\Unisender::sendSMS(
                $gateway_fields, $countrycode . $mobile, $messagetemplate, $testCall
            );
        case 97:
            $gateway_fields = get_option($option_slug . '_sinch');

            require_once plugin_dir_path(__DIR__) . 'gateways/sinch.php';

            return \SMSGateway\Sinch::sendSMS(
                $gateway_fields, $countrycode . $mobile, $messagetemplate, $testCall
            );
        case 101:
            $gateway_fields = get_option($option_slug . '_wavy');

            require_once plugin_dir_path(__DIR__) . 'gateways/wavy.php';

            return \SMSGateway\Wavy::sendSMS(
                $gateway_fields, $countrycode . $mobile, $messagetemplate, $testCall
            );
        case 109:
            $gateway_fields = get_option($option_slug . '_openmarket');

            require_once plugin_dir_path(__DIR__) . 'gateways/openmarket.php';

            return \SMSGateway\OpenMarket::sendSMS(
                $gateway_fields, $countrycode . $mobile, $messagetemplate, $testCall
            );
        case 123:
            $gateway_fields = get_option($option_slug . '_46elks');

            require_once plugin_dir_path(__DIR__) . 'gateways/fortysixelks.php';

            return \SMSGateway\FortySixElks::sendSMS(
                $gateway_fields, $countrycode . $mobile, $messagetemplate, $testCall
            );


        default:
            return apply_filters('unitedover_send_sms', false, $option_slug, $gateway_id, $countrycode, $mobile, $messagetemplate, $testCall);
    }


}

