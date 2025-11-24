<?php

namespace app\models;

use Yii;
use yii\base\Model;

class RegisterForm extends Model
{
    public $rememberMe = true;

    private $_user = false;

    public $name;
    public $surname;
    public $patronymic;
    public $email;
    public $phone;
    public $passport_type_id;
    public $passport_another;
    public $passport_expire;
    public $passport_number;
    public $password;
    public $password_repeat;
    public $rules;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'patronymic', 'email', 'phone', 'passport_type_id', 'passport_expire', 'passport_number', 'password'], 'required'],
            ['passport_another', 'string', 'max' => 255],
            [['name', 'surname', 'patronymic'], 'match', 'pattern' => '/(?=.*[-])[а-яa-z]/', 'message' => 'Должно содеражать латиницу или кириллицу и тире'],
            ['email', 'email'],
            ['phone', 'match', 'pattern' => '/^\+\d{11}$/', 'message' => 'Введите номер телефона: + в начале и 11 цифр'],
            ['password', 'match', 'pattern' => '/(?=.*[a-zA-Z])(?=.*[0-9])[0-9a-zA-Z!@#$%^&*]{6,20}/', 'message' => 'Пароль должен содержать литинский буквы и цифры, а также быть от 6 до 20 символов.'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            ['rules', 'required', 'requiredValue' => 1, 'message' => 'Необходимо дать согласие на обработку персональных данных'],
            ['passport_expire', 'date', 'format' => 'php:Y-m-d'],
            [
                'passport_expire',
                'compare',
                'compareValue' => date('Y-m-d'),
                'operator' => '>=',
                'message' => 'Дата должна быть не раньше: ' . date("d.m.Y"),
            ],
            [
                'passport_expire',
                'compare',
                'compareValue' => date('Y-m-d', strtotime('+190 days')),
                'operator' => '>=',
                'message' => 'Срок действия пароля должен быть не менее 190 дней от текущей даты.',
                'when' => function ($model) {
                    return $model->passport_type_id != 1;
                },
                'whenClient' => "(attribute, value) => $('#registerform-passport_type_id').val() != '' && $('#registerform-passport_type_id').val() != '1'",
            ]
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'email' => 'Электронная почта',
            'phone' => 'Телефон',
            'password' => 'Пароль',
            'role' => 'Статус в системе',
            'passport_type_id' => 'Документ для проезда',
            'passport_another' => 'Напишите название своего документа',
            'passport_expire' => 'До какой даты действует документ',
            'passport_number' => 'Номер документа',
            'password_repeat' => 'Повторите пароль',
            'auth_key' => 'Auth Key',
            'rules' => 'Согласие на обработку персональный данных',
        ];
    }
}
