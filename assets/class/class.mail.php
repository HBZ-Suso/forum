<?php


class Mail
{
    public function __construct ($data, $text)
    {
        $this->data = $data;
        $this->text = $text;
        require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/php/PHPMailer.php";
    }

    /**
     * 
     * send mail - the function which does all the stuff
     * PHPMailer is available on Github
     * @param string email
     * @param string content
     * @param string subject
     * @return string
    */
    public function sendMail ($email, $content, $subject, $userId) {
        
       //sending emails
        $phpmail = new PHPMailer(); //true sets error handling on
	    $phpmail->setFrom("noreply@hbz.suso.schulen.konstanz.de", "HBZ-Forum");
        $phpmail->Sender = "noreply@hbz.suso.schulen.konstanz.de"; //Bounce Adresse
        $phpmail->CharSet = "UTF-8";
		$phpmail->isHTML(); //legt das Email Format fest
		$phpmail->AddAddress($email); //Hier kommt die Empfänger Adresse rein
		$phpmail->Subject = $subject; 
        $user_data = $this->data->get_user_by_id($userId);
        $fillers = array(
            "{Ip}" => $_SERVER["REMOTE_ADDR"], 
            "{userName}" => $user_data["userName"], 
            "{userMail}" => $user_data["userMail"],
            "{userPhone}" => $user_data["userPhone"],
            "{userDescription}" => $user_data["userDescription"],
            "{userEmployment}" => $user_data["userEmployment"]
        );
        $content_filled = str_replace(array_keys($fillers), array_values($fillers), $content);
        $phpmail->Body = $content_filled;

        			
        if (!$phpmail->Send()) {
            $send = $phpmail->ErrorInfo; //for more arror handling opportunities you might want to do some research
        } else {
            $send = true;
        }
        return $send; 
    }


    public function send_mail ($cause, $userId="null")
    {
        if ($userId === "null") {
            $userId = $_SESSION["userId"];
        }

        switch ($cause)
        {
            case "passwordchanged":
                $this->sendMail($this->data->get_user_by_id($userId)["userMail"], $this->text->mail("mail-password-change-subject", "mail-password-change"), $this->text->get("mail-password-change-subject"), $userId);
                break;
            case "linked":
                $this->sendMail($this->data->get_user_by_id($userId)["userMail"], $this->text->mail("mail-link-subject", "mail-link"), $this->text->get("mail-link-subject"), $userId);
                break;
            case "verified":
                $this->sendMail($this->data->get_user_by_id($userId)["userMail"], $this->text->mail("mail-verified-subject", "mail-verified"), $this->text->get("mail-verified-subject"), $userId);
                break;
            case "locked":
                $this->sendMail($this->data->get_user_by_id($userId)["userMail"], $this->text->mail("mail-locked-subject", "mail-locked"), $this->text->get("mail-locked-subject"), $userId);
                break;
            case "resetpassword":
                $new_password = $this->data->get_random_password(10);
                $this->data->add_password_change($userId, $_SERVER['REMOTE_ADDR']);
                $this->data->change_user_column_by_id_and_name($userId, "userPassword", password_hash($new_password, PASSWORD_DEFAULT));
                $this->sendMail($this->data->get_user_by_id($userId)["userMail"], str_replace("{Pwd}", $new_password, $this->text->mail("mail-reset-password-subject", "mail-reset-password")), $this->text->get("mail-reset-password-subject"), $userId);
                break;
            case "createdaccount":
                $this->sendMail($this->data->get_user_by_id($userId)["userMail"], $this->text->mail("mail-created-account-subject", "mail-created-account"), $this->text->get("mail-created-account-subject"), $userId);
                break;
        }
    }


    public function notify ($userId, $Type, $Link, $Description) {
        $type_dictionary = [
            "passwordchanged" => 6,
            "linked" => 7,
            "verified" => 8,
            "locked" => 9,
            "resetpassword" => 10
        ];
        if (array_key_exists($Type, $type_dictionary)) {$Type = $type_dictionary[$Type];}
        $this->data->createNotification($userId, $Type, $Link, $Description);

        //$Type = intval($Type);

        try {
            if (intval($this->data->get_user_notification_setting($userId)) === 2) {
                $this->sendMail($this->data->get_user_by_id($userId)["userMail"], $this->text->generate_mail_html($this->get_notification_title($Type), $Description), $this->get_notification_title($Type), $userId);
            } else if (intval($this->data->get_user_notification_setting($userId)) === 1) {
                if ($Type === 6 || $Type === 7 || $Type === 8 || $Type === 9 || $Type === 10 || $Type === 11 || $Type === 12 || $Type === 13 || $Type === 14 || $Type === 15 || $Type === 16) {
                    $this->sendMail($this->data->get_user_by_id($userId)["userMail"], $this->text->generate_mail_html($this->get_notification_title($Type), $Description), $this->get_notification_title($Type), $userId);
                }
            } else {
                if ($Type === 6 || $Type === 10 || $Type === 13 || $Type === 7) {
                    $this->sendMail($this->data->get_user_by_id($userId)["userMail"], $this->text->generate_mail_html($this->get_notification_title($Type), $Description), $this->get_notification_title($Type), $userId);
                }
            }
        } catch (Error $e) {
            echo $e->getMessage();
        } finally {

        }
        
        // Example:  $mail->notify($_SESSION["userId"], 0, "Link", '"Nathan Zumbusch" liked "Das Kopfrechenprojekt"');
    }


    public function get_notification_title ($type) {
        switch ($type) {
            case 0:
                $title = $this->text->get("v2-notification-title-article-liked");
                break;
            case 1:
                $title = $this->text->get("v2-notification-title-profile-liked");
                break;
            case 2:
                $title = $this->text->get("v2-notification-title-article-commented");
                break;
            case 3:
                $title = $this->text->get("v2-notification-title-profile-commented");
                break;
            case 4:
                $title = $this->text->get("v2-notification-title-profile-posted");
                break;
            case 5:
                $title = $this->text->get("v2-notification-title-settings-changed");
                break;
            case 6:
                $title = $this->text->get("v2-notification-title-password-changed");
                break;
            case 7:
                $title = $this->text->get("v2-notification-title-account-linked");
                break;
            case 8:
                $title = $this->text->get("v2-notification-title-account-verified");
                break;
            case 9:
                $title = $this->text->get("v2-notification-title-account-locked");
                break;
            case 10:
                $title = $this->text->get("v2-notification-title-password-reset");
                break;
            case 11:
                $title = $this->text->get("v2-notification-title-article-published");
                break;
            case 12:
                $title = $this->text->get("v2-notification-title-account-unlocked");
                break;
            case 13:
                $title = $this->text->get("v2-notification-title-account-created");
                break;
            case 14:
                $title = $this->text->get("v2-notification-title-report-sent");
                break;
            case 15:
                $title = $this->text->get("v2-notification-title-article-deleted");
                break;
            case 16:
                $title = $this->text->get("v2-notification-title-article-pinned");
                break;
            case 17:
                $title = $this->text->get("v2-notification-title-message-received");
                break;
            default:
                return;
        }
        return $title;
    }
    
    
    
    public function convert_description_placeholder ($text) {
        foreach([
            "liked",
            "commented",
            "commentedProfile",
            "posted",
            "settingschanged",
            "passwordchanged",
            "verified",
            "locked",
            "locked",
            "unlocked",
            "passwordreset",
            "publishedarticle1",
            "publishedarticle2",
            "accountcreated",
            "reportsent",
            "articledeleted",
            "notification",
            "public",
            "pinned",
            "messaged"
        ] as $value) {
            $text = str_replace("{{" + $value + "}}", $this->text->get("v2-notification-placeholder-" + $value), $text);
        }
        return $text;
    }
}
