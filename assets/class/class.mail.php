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


    public function notify ($cause, $userId="null")
    {
        if ($userId === "null") {
            $userId = $_SESSION["userId"];
        }

        switch ($cause)
        {
            case "passwordchanged":
                $this->sendMail($this->data->get_user_by_id($userId)["userMail"], $this->text->mail("mail-password-change-subject", "mail-password-change"), $text->get("mail-password-change-subject"), $userId);
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
}
