<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail {

    protected int $debug;
    protected string $host;
    protected int $port;
    protected string $user;
    protected string $pass;
    protected string $from;
    protected string $to;
    protected int $imap_port;

    function __construct() {
        $this->debug = SMTP_DEBUG;
        $this->host = SMTP_HOST;
        $this->port = SMTP_PORT;
        $this->user = SMTP_USER;
        $this->pass = SMTP_PASS;
        $this->from = SMTP_FROM;
        $this->to = SMTP_TO;
        $this->imap_port = IMAP_PORT;
    }

    function sendMessage() {

        require_once "PHPMailer/Exception.php";
        require_once "PHPMailer/PHPMailer.php";
        require_once "PHPMailer/SMTP.php";

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = $this->debug;
        $mail->Host = $this->host;
        $mail->Port = $this->port;
        $mail->SMTPAutoTLS = false;
        $mail->SMTPSecure = false;
        $mail->SMTPAuth = true;
        $mail->Username = $this->user;
        $mail->Password = $this->pass;
        $mail->setFrom($this->from);
        $mail->addAddress($this->to);
        $mail->Subject = "need mirror";
        $mail->msgHTML("need mirror");

        if(!$mail->send()){
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent successfully!";
        }
    }

    function checkMessages() {
        $imap_obj = imap_open("{" . $this->host . ":" . $this->imap_port ."}", $this->user, $this->pass);
        $imap_check = imap_check($imap_obj);
        if ($imap_check->Nmsgs > 0) {
            $messages = imap_fetch_overview($imap_obj,"1:{$imap_check->Nmsgs}",0);
            foreach ($messages as $message) {
                $message_no = $message->msgno;
                $message_body = trim(quoted_printable_decode(imap_fetchbody($imap_obj, $message_no, 2)));
                preg_match('/<a href="(?P<url>.+?)" target="_blank" /', $message_body, $match);
                if (count($match) > 0) {
                    $content = file_get_contents(__DIR__ . "/mirrors.txt");
                    if (!str_contains($content, $match["url"])) {
                        $file = fopen(__DIR__ . "/mirrors.txt", "a");
                        fwrite($file, date('d-m-Y H:i:s') . "|" . $match["url"] . PHP_EOL);
                        fclose($file);
                        (new Telegram())->sendMessage("<b>" . PR_NAME . ": Добавлено новое зеркало!</b>" . PHP_EOL . $match["url"]);
                        echo PR_NAME . ": Добавлено новое зеркало!" . PHP_EOL . $match["url"];
                    } else {
                        echo PR_NAME . ": Пропуск " . $match["url"];
                    }
                }
                imap_delete($imap_obj, $message_no);
            }
            imap_expunge($imap_obj);
        } else {
            echo "Нет новых сообщений";
        }
        imap_close($imap_obj);
    }

}