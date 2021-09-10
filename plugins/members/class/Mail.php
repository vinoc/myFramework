<?php
//kd

class Mail
{
    private $_addressRecipient;
    private $_adressSender;
    private $_message;
    private $_subject;

    public function __construct($data)
    {
        if (isset($data)) {
            $this->hydrate($data);
        }
    }

    public function hydrate(array $data){
        $this->_adressSender = 'hello@cheezpa.com';
        try{
            $this->setMessage($data['message']);
            $this->setAddressRecipient($data['recipient']);
            $this->setSubject($data['subject']);
        }
        catch(Exception $e){
            echo 'erreur : ',  $e->getMessage(), "\n";
        }
    }

    public function setAddressRecipient($addressRecipient): void
    {
        $this->_addressRecipient = htmlspecialchars($addressRecipient);
    }

    public function setMessage($message): void
    {
        $this->_message = $message;
    }

    public function setSubject($subject): void
    {
        $this->_subject = $subject;
    }

    public function sendMail(){
        $to =$this->_addressRecipient;
        $subject = $this->_subject;
        $message = $this->_message;

        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=utf-8';

        $headers[] = 'To: <'.$this->_addressRecipient.'>';
        $headers[] = 'From: BluePoint <hello@cheezpa.com>';

        if(STATE_DEV=='prod') {
            mail($to, $subject, $message, implode("\r\n", $headers));
        }
    }
}