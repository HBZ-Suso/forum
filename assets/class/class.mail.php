<?php


class Mail
{
    public function __construct ()
    {
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
    public function sendMail ($email,$content,$subject) {
        
       //sending emails
        $phpmail = new PHPMailer(); //true sets error handling on
	    $phpmail->setFrom("noreply@hbz.suso.schulen.konstanz.de", "HBZ-Forum");
        $phpmail->Sender = "noreply@hbz.suso.schulen.konstanz.de"; //Bounce Adresse
        $phpmail->CharSet = "UTF-8";
		$phpmail->isHTML(); //legt das Email Format fest
		$phpmail->AddAddress($email); //Hier kommt die Empfänger Adresse rein
		$phpmail->Subject = $subject; 
        $phpmail->Body = $content;

        			
        if (!$phpmail->Send()) {
            $send = $phpmail->ErrorInfo; //for more arror handling opportunities you might want to do some research
        } else {
            $send = "success!";
        }
        return $send; 
    }


    public function notify ($cause, $data, $text, $userId="null")
    {
        if ($userId === "null") {
            $userId = $_SESSION["userId"];
        }

        switch ($cause)
        {
            case "passwordchanged":
                $this->sendMail($data->get_user_by_id($userId)["userMail"], $text->mail("mail-password-change-subject", "mail-password-change"), $text->get("mail-password-change-subject"));
                break;
            case "linked":
                $this->sendMail($data->get_user_by_id($userId)["userMail"], $text->mail("mail-link-subject", "mail-link"), $text->get("mail-link-subject"));
                break;
            case "verified":
                $this->sendMail($data->get_user_by_id($userId)["userMail"], $text->mail("mail-verified-subject", "mail-verified"), $text->get("mail-verified-subject"));
                break;
            case "locked":
                $this->sendMail($data->get_user_by_id($userId)["userMail"], $text->mail("mail-locked-subject", "mail-locked"), $text->get("mail-locked-subject"));
                break;
            case "resetpassword":
                $new_password = $data->get_random_password(10);
                $data->add_password_change($userId, $_SERVER['REMOTE_ADDR']);
                $data->change_user_column_by_id_and_name($userId, "userPassword", password_hash($new_password, PASSWORD_DEFAULT));
                $this->sendMail($data->get_user_by_id($userId)["userMail"], str_replace("{Pwd}", $new_password, $text->mail("mail-reset-password-subject", "mail-reset-password")), $text->get("mail-reset-password-subject"));
                break;
        }
    }
}
