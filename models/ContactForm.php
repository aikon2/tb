<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\base\ErrorException;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model {

    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            // name, email, subject and body are required
            ['name', 'required', 'message' => 'Введите Ваше имя'],
            ['email', 'required', 'message' => 'Введите Ваш адрес электронной почты'],
            ['body', 'required', 'message' => 'Необходимо написать сообщение'],       
            ['subject','default','value'=>'Нет темы'],
            // email has to be a valid email address
            ['email', 'email', 'message' => 'Адрес электронной почты введен некорректно'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
    public function contact($email,$contact) {
        if ($this->validate()) {

            try {
                Yii::$app->mailer->compose()
                        ->setTo($contact)
                        ->setFrom($email)
                        ->setSubject('Обратная связь')
                        ->setTextBody(
                                'Сообщение от: '.$this->name."\n".
                                'Обратный адрес: '.$this->email."\n".
                                'Тема: '.$this->subject."\n".
                                "Сообщение:\n".$this->body
                                )
                        ->send();
            } catch (ErrorException $e) {
                Yii::warning("Сообщение не отправлено".
                        'Сообщение от: '.$this->name."\n".
                                'Обратный адрес: '.$this->email."\n".
                                'Тема: '.$this->subject."\n".
                                "Сообщение:\n".$this->body);
                return false;
            }


            return true;
        }
        return false;
    }

}
