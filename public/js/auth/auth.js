function recaptchaDataCallbackRegister(response){  $("#hiddenInputRecaptchaRegister").val(response); }
function recaptchaExpireCallbackRegister(){  $("#hiddenInputRecaptchaRegister").val(""); }
function recaptchaDataCallbackLogin(response){  $("#hiddenInputRecaptchaLogin").val(response); }
function recaptchaExpireCallbackLogin(){  $("#hiddenInputRecaptchaLogin").val(""); }

$(document).ready(function () {
    $(".login_button").on("click",function(){
        $("#registerModal").modal("hide");
        $("#loginModal").modal("show");
    });

    $(".register_button").on("click",function(){
        $("#loginModal").modal("hide");
        $("#registerModal").modal("show");
    });

    jQuery.validator.addMethod("noSpace", function(value, element) {
        return this.optional(element) || value.trim().length != 0;
    }, "Spaces are not allowed");
    var timer = 0;
    $("#registration_form").validate({
        ignore:".ignore", // for not ignoring hidden input fields of recaptcha
        errorInputClass: "is-invalid",
        errorLabelClass: "invalid-feedback",
        validClass:"is-valid",
        onkeyup: function(element, event, force) {
            // Avoid revalidate the field when pressing one of the following keys
            // Shift       => 16(x)    End         => 35    Right arrow => 39    AltGr key   => 225
            // Ctrl        => 17(x)    Home        => 36    Down arrow  => 40
            // Alt         => 18    Left arrow  => 37    Insert      => 45(x)
            // Caps lock   => 20    Up arrow    => 38    Num lock    => 144

            let excludedKeys = [
                18, 20, 35, 36, 37,
                38, 39, 40,144, 225
            ], rules = $(element).rules();

            clearTimeout(timer);

            if (rules.remote && typeof(force) === "undefined") {
                timer = setTimeout(function() {
                    $.validator.defaults.onkeyup.apply(this, [element, event, true]);  // reapply self
                }.bind(this), 2000);
                return;
            }

            if (event.which === 9 && this.elementValue(element) === "" || $.inArray(event.keyCode, excludedKeys) !== -1) {
                return; // 9 - TAB
            } else if (element.name in this.submitted || element.name in this.invalid) {
                this.element(element);
            }
        },
        rules:{
            first_name:{
                required:true,
                minlength:2,
                maxlength:100,
                noSpace: true
            },
            last_name:{
                required:true,
                minlength:2,
                maxlength:100
            },
            username:{
                required:true,
                maxlength:100,
                remote: {
                    url: $("#username").data("href"),
                    type: "POST",
                }
            },
            email:{
                required:true,
                email:true,
                maxlength:255,
                remote: {
                    url: $("#email").data("href"),
                    type: "POST",
                }
            },
            password:{
                required:true,
                minlength:8,
                maxlength:255
            },
            password_confirmation:{
                required:true,
                minlength:8,
                maxlength:255,
                equalTo:"#password"
            },
            terms:{
                required: true,
            },
            grecaptcha:{
                required: true,
            },
        },
        messages: {
            first_name: {
                required:"Please enter first name"
            },
            last_name: {
                required:"Please enter last name"
            },
            username:{
                required: "We need your username to register you",
                remote: "Username is already in use. Try with different username or <a href='"+
                    $("#registration_form").data("login-href") +
                    "'> Sign in </a>"
            },
            email: {
                required: "We need your email address to contact you",
                email: "Your email address must be in the format of name@domain.com",
                remote: "Email is already in use. Try with different email or <a href='"+
                    $("#registration_form").data("login-href") +
                    "'> Sign in </a>"
            },
            password:{
                required: "Enter your password"
            },
            password_confirmation:{
                required: "Confirm your password",
                equalTo: "The given passwords don't match"
            },
            terms: "Please accept our terms and conditions",
            grecaptcha: "Check reCaptcha"
        },
        errorPlacement:function(error,element){
            if (element.attr("name")==="terms") {
                error.appendTo($("#terms_error"));
            } else if (element.attr("name")==="grecaptcha"){
                error.appendTo($("#RegisterRecaptchaErrorDiv"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler:function(form){
            $.LoadingOverlay("show");
            form.submit();
        }
    });

    var register_validator=$('#modal_registration_form').validate({
        ignore:".ignore",
        errorInputClass: "is-invalid",
        errorLabelClass: "invalid-feedback",
        validClass:"is-valid",
        onkeyup: function(element, event, force) {
            // Avoid revalidate the field when pressing one of the following keys
            // Shift       => 16(x)    End         => 35    Right arrow => 39    AltGr key   => 225
            // Ctrl        => 17(x)    Home        => 36    Down arrow  => 40
            // Alt         => 18    Left arrow  => 37    Insert      => 45(x)
            // Caps lock   => 20    Up arrow    => 38    Num lock    => 144

            let excludedKeys = [
                18, 20, 35, 36, 37,
                38, 39, 40,144, 225
            ], rules = $(element).rules();

            clearTimeout(timer);

            if (rules.remote && typeof(force) === "undefined") {
                timer = setTimeout(function() {
                    $.validator.defaults.onkeyup.apply(this, [element, event, true]);  // reapply self
                }.bind(this), 2000);
                return;
            }

            if (event.which === 9 && this.elementValue(element) === "" || $.inArray(event.keyCode, excludedKeys) !== -1) {
                return; // 9 - TAB
            } else if (element.name in this.submitted || element.name in this.invalid) {
                this.element(element);
            }
        },
        rules:{
            first_name:{
                required:true,
                minlength:2,
                maxlength:100,
                noSpace: true
            },
            last_name:{
                required:true,
                minlength:2,
                maxlength:100
            },
            username:{
                required:true,
                maxlength:100,
                remote: {
                    url: $("#username").data("href"),
                    type: "POST",
                }
            },
            email:{
                required:true,
                email:true,
                maxlength:255,
                remote: {
                    url: $("#email").data("href"),
                    type: "POST",
                }
            },
            password:{
                required:true,
                minlength:8,
                maxlength:255
            },
            password_confirmation:{
                required:true,
                minlength:8,
                maxlength:255,
                equalTo:"#password"
            },
            terms:{
                required: true,
            },
            grecaptcha:{
                required: true,
            },
        },
        messages: {
            first_name: {
                required:"Please enter first name"
            },
            last_name: {
                required:"Please enter last name"
            },
            username:{
                required: "We need your username to register you",
                remote: "Username is already in use. Try with different username or <a href='"+
                    $("#modal_registration_form").data("login-href") +
                    "'> Sign in </a>"
            },
            email: {
                required: "We need your email address to contact you",
                email: "Your email address must be in the format of name@domain.com",
                remote: "Email is already in use. Try with different email or <a href='"+
                    $("#modal_registration_form").data("login-href") +
                    "'> Sign in </a>"
            },
            password:{
                required: "Enter your password"
            },
            password_confirmation:{
                required: "Confirm your password",
                equalTo: "The given passwords don't match"
            },
            terms: "Please accept our terms and conditions",
            grecaptcha: "Check reCaptcha"
        },
        errorPlacement:function(error,element){
            if(element.attr("name")==="terms"){
                error.appendTo($('#terms_error'));
            }
            else if(element.attr("name")==="grecaptcha"){
                error.appendTo($('#RegisterRecaptchaErrorDiv'));
            }
            else{
                error.insertAfter(element);
            }
        },
        submitHandler:function(form){
            $.LoadingOverlay("show");
            //form.submit();
            var formData = new FormData(form);
            $.ajax({
                url: "{{route('check_email_unique')}}",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    alertify.success(data.message);
                    form.reset();
                    register_validator.resetForm();
                    grecaptcha.reset(1);
                    $("#hiddenInputRecaptchaRegister").val("");
                    $.LoadingOverlay("hide");
                    setTimeout(function(){
                        window.location.href=data.redirect_url;
                    },2000);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $.LoadingOverlay("hide");
                    var response=jqXHR.responseJSON;
                    var status=jqXHR.status;
                    form.reset();
                    register_validator.resetForm();
                    grecaptcha.reset(1);
                    $("#hiddenInputRecaptchaRegister").val("");
                    if(status=="422"){
                        //console.log(response.errors,'response.errors');
                        for (const property in response.errors) {
                            alertify.success(response.errors[property][0]);
                        }
                    } else if (status=="400") {
                        alertify.success(response.message);
                    } else {
                        alertify.success("Internal server error.");
                    }
                }
            });
        }
    });

    $("#login_form").validate({
        ignore: ".ignore",
        errorInputClass: "is-invalid",
        errorLabelClass: "invalid-feedback",
        validClass: "is-valid",
        rules:{
            username:{
                required:true,
                maxlength:100
            },
            password:{
                required:true,
                minlength:8,
                maxlength:255
            },
            grecaptcha: {
                required:true
            }
        },
        messages: {
            username: {
                required: "Username or E-mail is required"
            },
            password:{
                required: "Enter your password"
            },
            grecaptcha: "Check reCaptcha"
        },
        errorPlacement: function(error,element){
            if ( element.attr("name")==="grecaptcha" ) {
                error.appendTo($("#LoginRecaptchaErrorDiv"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form){
            // $.LoadingOverlay("show");
            form.submit();
        }
    });

    var login_validator=$("#modal_login_form").validate({
        ignore:".ignore",
        errorInputClass: "is-invalid",
        errorLabelClass: "invalid-feedback",
        validClass: "is-valid",
        rules:{
            username:{
                required:true,
                maxlength:100
            },
            password:{
                required:true,
                minlength:8,
                maxlength:255
            },
            grecaptcha: {
                required:true
            }
        },
        messages: {
            username: {
                required: "Username is required"
            },
            password:{
                required: "Enter your password"
            },
            grecaptcha: "Check reCaptcha"
        },
        errorPlacement:function(error,element){
            if(element.attr("name")==="grecaptcha"){
                error.appendTo($("#LoginRecaptchaErrorDiv"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler:function(form){
            $.LoadingOverlay("show");
            //form.submit();
            var formData = new FormData(form);
            $.ajax({
                url: "{{route('ajaxLogin')}}",
                type: "POST",
                data:formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    alertify.success(data.message);
                    form.reset();
                    login_validator.resetForm();
                    grecaptcha.reset(0);
                    $('#hiddenRecaptchaLogin').val('');
                    $.LoadingOverlay("hide");
                    setTimeout(function(){
                        window.location.href=data.redirect_url;
                    },2000);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $.LoadingOverlay("hide");
                    var response=jqXHR.responseJSON;
                    var status=jqXHR.status;
                    form.reset();
                    login_validator.resetForm();
                    if ( status=="422" ) {
                        //console.log(response.errors,'response.errors');
                        for (const property in response.errors) {
                            alertify.error(response.errors[property][0]);
                        }
                    } else if (status=="400") {
                        alertify.error(response.errors);
                    } else {
                        alertify.error("Internal server error.");
                    }
                    grecaptcha.reset(0);
                    $("#hiddenInputRecaptchaLogin").val("");
                }
            });
        }
    });
});
