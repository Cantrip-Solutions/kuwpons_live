<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use View;
class Helper
{

    public static function discountOff($originalPrice, $sellingPrice)
    {
    	$diff = $originalPrice - $sellingPrice;
    	$percentOff = (($diff / $originalPrice) * 100);
    	return round($percentOff);
    }

    public static function sendMail($data)
    {
      $message = View::make($data['view'], $data);
      $from = 'no-reply@kuwpons.com';

      $headers = "From: Kuwpons <$from>\r\n";
      $headers .= "Reply-To: support@kuwpons.com\r\n";
      $headers .= "Return-Path: <$from>\r\n";

      // $headers = "From:<$from>\n";
      // // $headers = "From: Kuwpons no-reply@kuwpons.com\r\n";
      // $headers .= "X-Priority: 2\nX-MSmail-Priority: high";
      // $headers .= "Reply-to: support@kuwpons.com";
      
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: text/html; charset=iso 8859-1";

      // if (mail('dipankar.cantripsolutions@gmail.com', $data['subject'], $message, $headers)) {
      if (mail($data['to'], $data['subject'], $message, $headers, "-f$from")) {
          return true;
      } else {
          return false;
      }
    }

    public static function sendSMS($phoneSMS, $text)
    {
    	$username = 'kuwpons';
        $password = 'test1234';
        
        $msisdn = $phoneSMS;
        /*
        * Please see the FAQ regarding HTTPS (port 443) and HTTP (port 80/5567)
        */
        $url = 'https://bulksms.vsms.net/eapi/submission/send_sms/2/2.0';

        $seven_bit_msg = $text;

        $post_body = self::seven_bit_sms( $username, $password, $seven_bit_msg, $msisdn );
        $result = self::send_message( $post_body, $url );
        // if( $result['success'] ) {
        //   $message = self::print_ln( self::formatted_server_response( $result ) );
        // }
        // else {
        //   $message = self::print_ln( self::formatted_server_response( $result ) );
        // }
    	// return $message;
    }

    public static function print_ln($content) {
      if (isset($_SERVER["SERVER_NAME"])) {
        print $content."<br />";
      }
      else {
        print $content."\n";
      }
    }

    public static function seven_bit_sms ( $username, $password, $message, $msisdn ) {
      $post_fields = array (
      'username' => $username,
      'password' => $password,
      'message'  => $message,
      'msisdn'   => $msisdn,
      'allow_concat_text_sms' => 0, # Change to 1 to enable long messages
      'concat_text_sms_max_parts' => 2
      );

      return self::make_post_body($post_fields);
    }

    public static function make_post_body($post_fields) {
      $stop_dup_id = self::make_stop_dup_id();
      if ($stop_dup_id > 0) {
        $post_fields['stop_dup_id'] = self::make_stop_dup_id();
      }
      $post_body = '';
      foreach( $post_fields as $key => $value ) {
        $post_body .= urlencode( $key ).'='.urlencode( $value ).'&';
      }
      $post_body = rtrim( $post_body,'&' );

      return $post_body;
    }

    public static function make_stop_dup_id() {
      return 0;
    }

    public static function send_message ( $post_body, $url ) {
      /*
      * Do not supply $post_fields directly as an argument to CURLOPT_POSTFIELDS,
      * despite what the PHP documentation suggests: cUrl will turn it into in a
      * multipart formpost, which is not supported:
      */

      $ch = curl_init( );
      curl_setopt ( $ch, CURLOPT_URL, $url );
      curl_setopt ( $ch, CURLOPT_POST, 1 );
      curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
      curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_body );
      // Allowing cUrl funtions 20 second to execute
      curl_setopt ( $ch, CURLOPT_TIMEOUT, 20 );
      // Waiting 20 seconds while trying to connect
      curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 20 );

      $response_string = curl_exec( $ch );
      $curl_info = curl_getinfo( $ch );

      $sms_result = array();
      $sms_result['success'] = 0;
      $sms_result['details'] = '';
      $sms_result['transient_error'] = 0;
      $sms_result['http_status_code'] = $curl_info['http_code'];
      $sms_result['api_status_code'] = '';
      $sms_result['api_message'] = '';
      $sms_result['api_batch_id'] = '';

      if ( $response_string == FALSE ) {
        $sms_result['details'] .= "cURL error: " . curl_error( $ch ) . "\n";
      } elseif ( $curl_info[ 'http_code' ] != 200 ) {
        $sms_result['transient_error'] = 1;
        $sms_result['details'] .= "Error: non-200 HTTP status code: " . $curl_info[ 'http_code' ] . "\n";
      }
      else {
        $sms_result['details'] .= "Response from server: $response_string\n";
        $api_result = explode( '|', $response_string );
        $status_code = $api_result[0];
        $sms_result['api_status_code'] = $status_code;
        $sms_result['api_message'] = $api_result[1];
        if ( count( $api_result ) != 3 ) {
          $sms_result['details'] .= "Error: could not parse valid return data from server.\n" . count( $api_result );
        } else {
          if ($status_code == '0') {
            $sms_result['success'] = 1;
            $sms_result['api_batch_id'] = $api_result[2];
            $sms_result['details'] .= "Message sent - batch ID $api_result[2]\n";
          }
          else if ($status_code == '1') {
            # Success: scheduled for later sending.
            $sms_result['success'] = 1;
            $sms_result['api_batch_id'] = $api_result[2];
          }
          else {
            $sms_result['details'] .= "Error sending: status code [$api_result[0]] description [$api_result[1]]\n";
          }





        }
      }
      curl_close( $ch );

      return $sms_result;
    }

    public static function formatted_server_response( $result ) {
      $this_result = "";

      if ($result['success']) {
        $this_result .= "Success: batch ID " .$result['api_batch_id']. "API message: ".$result['api_message']. "\nFull details " .$result['details'];
      }
      else {
        $this_result .= "Fatal error: HTTP status " .$result['http_status_code']. ", API status " .$result['api_status_code']. " API message " .$result['api_message']. " full details " .$result['details'];

        if ($result['transient_error']) {
          $this_result .=  "This is a transient error - you should retry it in a production environment";
        }
      }
      return $this_result;
    }
}