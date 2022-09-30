$(document).ready(function () {
    alertify.set("notifier","position","top-right");

    $(".login_button").on("click",function(){
        $("#registerModal").modal("hide");
        $("#loginModal").modal("show");
    });

    $(".register_button").on("click",function(){
        $("#loginModal").modal("hide");
        $("#registerModal").modal("show");
    });

    function recaptchaDataCallbackRegister(response){  $("#hiddenInputRecaptchaRegister").val(response); }
    function recaptchaExpireCallbackRegister(){  $("#hiddenInputRecaptchaRegister").val(""); }
    function recaptchaDataCallbackLogin(response){  $("#hiddenRecaptchaLogin").val(response); }
    function recaptchaExpireCallbackLogin(){  $("#hiddenRecaptchaLogin").val(""); }

    jQuery.validator.addMethod("noSpace", function(value, element) {
        return this.optional(element) || value.trim().length != 0;
    }, "Spaces are not allowed");
    var timer = 0;
    $("#registration_form").validate({
        ignore:".ignore", // for not ignoring hidden input fields of recaptcha
        errorInputClass: "text-danger",
        errorLabelClass: "invalid-feedback",
        validClass:"bg-success",
        onkeyup: function(element, event, force) {
            // Avoid revalidate the field when pressing one of the following keys
            // Shift       => 16    End         => 35    Right arrow => 39    AltGr key   => 225
            // Ctrl        => 17    Home        => 36    Down arrow  => 40
            // Alt         => 18    Left arrow  => 37    Insert      => 45
            // Caps lock   => 20    Up arrow    => 38    Num lock    => 144

            let excludedKeys = [
                17, 18, 20, 35, 36, 37,
                38, 39, 40, 45, 144, 225
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
                    headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") },
                    url: $("#username").data("href"),
                    type: "POST",
                }
            },
            email:{
                required:true,
                email:true,
                maxlength:255,
                remote: {
                    headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") },
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
                required:true,
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
                remote:"Username already in use. Try with different username"
            },
            email: {
                required: "We need your email address to contact you",
                email: "Your email address must be in the format of name@domain.com",
                remote: "Email already in use. Try with different email"
            },
            password:{
                required:"Enter your password"
            },
            password_confirmation:{
                required: "Confirm your password",
                equalTo: "The given passwords doesn't match"
            },
            terms: "Please accept our terms and conditions",
            grecaptcha: "Captcha field is required"
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
        errorClass:"invalid",
        validClass:'success',
        rules:{
            first_name:{
                required:true,
                minlength:2,
                maxlength:100
            },
            last_name:{
                required:true,
                minlength:2,
                maxlength:100
            },
            email:{
                required:true,
                email:true,
                remote: {
                    headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") },
                    url: "{{route('check_email_unique')}}",
                    type: "POST",
                    data: {
                        email: function() {
                            return $( "#register_email" ).val();
                        },
                        '_token':$('meta[name="csrf-token"]').attr('content')
                    }
                }
            },
            password:{
                required:true,
                minlength:6,
                maxlength:100
            },
            confirm_password:{
                required:true,
                equalTo:'#register_password'
            },
            terms:"required",
            grecaptcha:"required"
        },
        messages: {
            first_name: {
                required:"Please enter first name"
            },
            last_name: {
                required:"Please enter last name"
            },
            email: {
                required: "We need your email address to contact you",
                email: "Your email address must be in the format of name@domain.com",
                remote:"Email already in use. Try with different email"
            },
            password:{
                required:"Enter your password"
            },
            confirm_password:{
                required:"Need to confirm your password"
            },
            terms:"Please accept our terms and conditions",
            grecaptcha:"Captcha field is required"
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
            $.ajaxSetup( { headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") } });
            $.ajax({
                url: "{{route('check_email_unique')}}",
                type: "POST",
                data:formData,
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
        ignore:".ignore",
        errorClass:"invalid",
        validClass:"success",
        rules:{
            email:{
                required:true,
                email:true,
            },
            password:{
                required:true,
                minlength:6,
                maxlength:100
            },
            grecaptcha:"required"
        },
        messages: {
            email: {
                required: "Email is required",
                email: "Your email address must be in the format of name@domain.com",
            },
            password:{
                required:"Enter your password"
            },
            grecaptcha:"Captcha field is required"
        },
        errorPlacement:function(error,element){
            if(element.attr("name")==="grecaptcha"){
                error.appendTo($('#LoginRecaptchaErrorDiv'));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler:function(form){
            $.LoadingOverlay("show");
            form.submit();
        }
    });

    var login_validator=$("#modal_login_form").validate({
        ignore:".ignore",
        errorClass:"invalid",
        validClass:"success",
        rules:{
            email:{
                required:true,
                email:true,
            },
            password:{
                required:true,
                minlength:6,
                maxlength:100
            },
            grecaptcha:"required"
        },
        messages: {
            email: {
                required: "Email is required",
                email: "Your email address must be in the format of name@domain.com",
            },
            password:{
                required:"Enter your password"
            },
            grecaptcha:"Captcha field is required"
        },
        errorPlacement:function(error,element){
            if(element.attr("name")==="grecaptcha"){
                error.appendTo($("#hiddenRecaptchaLoginError"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler:function(form){
            $.LoadingOverlay("show");
            //form.submit();
            var formData = new FormData(form);
            $.ajaxSetup( { headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") } });
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
                    if(status=="422"){
                        //console.log(response.errors,'response.errors');
                        for (const property in response.errors) {
                            toastr.error(response.errors[property][0], "Error", {timeOut: 5000})
                        }
                    } else if (status=="400") {
                        toastr.error(response.message, "Error", {timeOut: 5000});
                    } else {
                        toastr.error("Internal server error.", "Error", {timeOut: 5000})
                    }
                    grecaptcha.reset(0);
                    $("#hiddenRecaptchaLogin").val("");
                }
            });
        }
    });
});
