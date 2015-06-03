<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use app\models\Users;
use app\models\UserInfo;
use app\models\UserRole;
use app\models\Roles;

/**
 * LoginForm is the model behind the login form.
 */
class RegisterForm extends Model
{
    public $username;
    public $password;
    public $confirmPassword;
    public $first_name;
    public $last_name;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password', 'confirmPassword'], 'required'],
            [['first_name', 'last_name'], 'string', 'max' => 50],
            ['username', 'email'],
            [['confirmPassword'], 'compare', 'compareAttribute'=>'password', 'operator'=>'==']
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
            'first_name' => 'Tên',
            'last_name' => 'Họ'
        ];
    }


    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function register()
    {
        if ($this->validate()) {
            try
            {

                // create new user
                $user = new Users();
                $user->account = $this->username;
                $user->password = sha1($this->password);
                $user->record_status = 1;
                if($user->save())
                {
                    $user = Users::find()
                        ->where(['account' => $this->username])
                        ->one();
                    $userInfo = new UserInfo();

                    $userInfo->account_id = $user->id;
                    $userInfo->first_name = $this->first_name;
                    $userInfo->last_name = $this->last_name;
                    $userInfo->save();

                    $memberRole = Roles::find()->where(['name' => 'Member'])->one();

                    $userRole = new UserRole();
                    $userRole->user_id = $user->id;
                    $userRole->role_id = $memberRole->id;
                    $userRole->save();
                    return true;
                }else{
                    return false;
                }

            }catch (Exception $ex)
            {
                return $ex;
            }


            // create new user info
            // add user role is member
            return true;
        } else {
            return false;
        }
    }
}
