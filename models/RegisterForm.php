<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class RegisterForm extends Model
{
    public $username;
    public $password;
    public $confirmPassword;
    public $firstname;
    public $lastname;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password', 'confirmPassword'], 'required'],
            ['username', 'email'],
            [['password'], 'compare', 'compareAttribute'=>'confirmPassword', 'operator'=>'==']
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Email đăng nhập',
            'password' => 'Mật khẩu',
            'comfirmPassword' => 'Nhập lại mật khẩu',
            'firstname' => 'Tên',
            'lastname' => 'Họ'
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function register()
    {
        if ($this->validate()) {
            // create new user
            // create new user info
            // add user role is member
            return true;
        } else {
            return false;
        }
    }
}
