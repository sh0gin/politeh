$(() => {
    const clear = () => {
        $(".registerform-passport_another")
            .find(".invalid-feedback")
            .html("");
        $("#registerform-passport_another").removeClass("is-invalid");
        $("#registerform-passport_another").removeClass("is-valid");
    } 
    // функция 
    // 1) для очищения блока invalid feedback от html 
    // 2) Из инпута passport_anotehr удаляем любой класс изменяющий цвет


    $("#registerform-passport_type_id").on('change', function () {

        // ловим изменения в registerform-passport_type_id

        $("#register-form").yiiActiveForm(
            'validateAttribute',
            'registerform-passport_expire'
        );

        // включаем валидацию на passport_expire по id input'a

        if ($(this).val() === "4") { // если выбор "Другого документа"
            $("#register-form").yiiActiveForm( // удаляем валидацию registerform-passport another
                'remove',
                'registerform-passport_another'
            );
            clear(); // очищаем passport_another полностью от цвета и ошибок
            $('#register-form').yiiActiveForm('add',
                {
                    id: "registerform-passport_another",
                    name: "passport_another",
                    container: ".field-registerform-passport_another",
                    input: "#registerform-passport_another",
                    error: ".invalid-feedback",
                    validate: function (attribute, value, messages, deferred, $form) 
                    { yii.validation.required(value, messages, 
                        { "message": "Необходимо заполнить «Напишите название своего документа»." }); }
                }); // добавляем правило валидации
            $(".field-registerform-passport_another").removeClass("d-none"); // выводим поле
            $('#register-form').yiiActiveForm( // добавляем валидацию с yii
                'validateAttribute',
                'registerform-passport_another'
            );
        } else { // всё что угодно кроме "Другого документа"
            $("#register-form").yiiActiveForm( // удаляем валидацию поля passport_another
                'remove',
                'registerform-passport_another'
            );

            $("#register-form").yiiActiveForm("add",
                {
                    id: "registerform-passport_another",
                    name: "passport_another",
                    container: ".field-registerform-passport_another",
                    input: "#registerform-passport_another",
                    error: ".invalid-feedback",
                    validate: function (attribute, value, messages, deferred, $form) {
                        yii.validation.string(value, messages, 
                            { "message": "Необходимо заполнить «Напишите название своего документа».",
                                max: 255,
                                tooLong: "Значение 'Другой документ' должно быть строкой.",
                                skiponEmpty: 1,
                            });  // добавляем правило валидации
                        }
                });

            clear(); // чистим инпут
            $(".field-registerform-passport_another").addClass("d-none"); // добавляем класс
        }
    })

})