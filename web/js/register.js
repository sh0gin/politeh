$(() => {
    const clear = () => {
        $(".registerform-passport_another")
            .find(".invalid-feedback")
            .html("");
        $("#registerform-passport_another").removeClass("is-invalid");
        $("#registerform-passport_another").removeClass("is-valid");
    }

    $("#registerform-passport_type_id").on('change', function () {
        $("#register-form").yiiActiveForm(
            'validateAttribute',
            'registerform-passport_expire'
        );
        // console.log($(this).val());
        // console.log($(this).val() === "4");
        if ($(this).val() === "4") {
            $("#register-form").yiiActiveForm(
                'remove',
                'registerform-passport_another'
            );
            clear();
            $('#register-form').yiiActiveForm('add',
                {
                    id: "registerform-passport_another",
                    name: "passport_another",
                    container: ".field-registerform-passport_another",
                    input: "#registerform-passport_another",
                    error: ".invalid-feedback",
                    validate: function (attribute, value, messages, deferred, $form) { yii.validation.required(value, messages, { "message": "Необходимо заполнить «Напишите название своего документа»." }); }
                });
            $(".field-registerform-passport_another").removeClass("d-none");
            $('#register-form').yiiActiveForm(
                'validateAttribute',
                'registerform-passport_another'
            );
        } else {
            $("#register-form").yiiActiveForm(
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
                            }); 
                        }
                });

            clear();
            $(".field-registerform-passport_another").addClass("d-none");
        }
    })

})