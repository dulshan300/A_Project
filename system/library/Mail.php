<?php

class Mail {

    public static function sent_text_mail($to, $subject, $message, $from = "", $rpl_to = "") {
        if (self::is_email($to)) {
            if (!empty($from) && !self::is_email($from)) {
                return false;
            }
            if (!empty($rpl_to) && !self::is_email($rpl_to)) {
                return false;
            }
            $headers = 'From: ' . $from . "\r\n" .
                    'Reply-To: ' . $from . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

            return mail($to, $subject, $message, $headers);
        }
    }

    public static function sent_html_mail($to, $subject, $message, $from = "", $rpl_to = "") {
        if (self::is_email($to)) {
            if (!empty($from) && !self::is_email($from)) {
                return false;
            }
            if (!empty($rpl_to) && !self::is_email($rpl_to)) {
                return false;
            }
            
            $headers = "From: " . strip_tags($from) . "\r\n";
            $headers .= "Reply-To: " . strip_tags($from) . "\r\n";           
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            return mail($to, $subject, $message, $headers);
        } else {
            return 0;
        }
    }

    public static function is_email($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

}

