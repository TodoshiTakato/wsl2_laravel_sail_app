jQuery( document ).ready(function( $ ) {

	"use strict";

        $(function() {
            $( "#tabs" ).tabs();
        });


        // Page loading animation

        $("#preloader").animate({
            'opacity': '0'
        }, 600, function(){
            setTimeout(function(){
                $("#preloader").css("visibility", "hidden").fadeOut();
            }, 300);
        });


        $(window).scroll(function() {
          var scroll = $(window).scrollTop();
          var box = $('.header-text').height();
          var header = $('header').height();

          if (scroll >= box - header) {
            $("header").addClass("background-header");
          } else {
            $("header").removeClass("background-header");
          }
        });
        if ($('.owl-clients').length) {
            $('.owl-clients').owlCarousel({
                loop: true,
                nav: false,
                dots: true,
                items: 1,
                margin: 30,
                autoplay: false,
                smartSpeed: 700,
                autoplayTimeout: 6000,
                responsive: {
                    0: {
                        items: 1,
                        margin: 0
                    },
                    460: {
                        items: 1,
                        margin: 0
                    },
                    576: {
                        items: 3,
                        margin: 20
                    },
                    992: {
                        items: 5,
                        margin: 30
                    }
                }
            });
        }
		if ($('.owl-testimonials').length) {
            $('.owl-testimonials').owlCarousel({
                loop: true,
                nav: false,
                dots: true,
                items: 1,
                margin: 30,
                autoplay: false,
                smartSpeed: 700,
                autoplayTimeout: 6000,
                responsive: {
                    0: {
                        items: 1,
                        margin: 0
                    },
                    460: {
                        items: 1,
                        margin: 0
                    },
                    576: {
                        items: 2,
                        margin: 20
                    },
                    992: {
                        items: 2,
                        margin: 30
                    }
                }
            });
        }
        if ($('.owl-banner').length) {
            $('.owl-banner').owlCarousel({
                loop: true,
                nav: false,
                dots: true,
                items: 1,
                margin: 0,
                autoplay: false,
                smartSpeed: 700,
                autoplayTimeout: 6000,
                responsive: {
                    0: {
                        items: 1,
                        margin: 0
                    },
                    460: {
                        items: 1,
                        margin: 0
                    },
                    576: {
                        items: 1,
                        margin: 20
                    },
                    992: {
                        items: 1,
                        margin: 30
                    }
                }
            });
        }

        $(".Modern-Slider").slick({
            autoplay:true,
            autoplaySpeed:10000,
            speed:600,
            slidesToShow:1,
            slidesToScroll:1,
            pauseOnHover:false,
            dots:true,
            pauseOnDotsHover:true,
            cssEase:'linear',
           // fade:true,
            draggable:false,
            prevArrow:'<button class="PrevArrow"></button>',
            nextArrow:'<button class="NextArrow"></button>',
        });

        $('.filters ul li').click(function(){
        $('.filters ul li').removeClass('active');
        $(this).addClass('active');

          var data = $(this).attr('data-filter');
          $grid.isotope({
            filter: data
          })
        });

        var $grid = $(".grid").isotope({
          itemSelector: ".all",
          percentPosition: true,
          masonry: {
            columnWidth: ".all"
          }
        })
        $('.accordion > li:eq(0) a').addClass('active').next().slideDown();

        $('.accordion a').click(function(j) {
            var dropDown = $(this).closest('li').find('.content');

            $(this).closest('.accordion').find('.content').not(dropDown).slideUp();

            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            } else {
                $(this).closest('.accordion').find('a.active').removeClass('active');
                $(this).addClass('active');
            }

            dropDown.stop(false, true).slideToggle();

            j.preventDefault();
        });

});
// document.getElementById("demo").innerHTML = routes.shop.products+"/";
// document.getElementById("demo").innerHTML = routes.shop.cart.clear_cart;
$(document).ready(function () {
    cartload();

    $(document).on("click", "#add_to_cart_btn", function(event) {
        event.preventDefault();
        let add_to_cart_btn = $(this);
        let product_id = add_to_cart_btn.closest("#product_data").find("#product_id").val();
        $.ajaxSetup( { headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") } });
        $.ajax({
            url: routes.shop.products+"/"+product_id,
            method: "POST",
            success: function (response) {

                if (response["item_quantity"] == 1) {
                    let buttons = add_to_cart_btn.closest(".buttons");
                    buttons.html("");
                    buttons.append($(
                        '<div class="d-flex justify-content-between item">' +
                        '<button class="btn btn-primary btn-vsm disabled"> ' +
                        '<i class="fas fa-shopping-cart fa-1x"></i>' +
                        'Уже в корзине(<div id="qty" class="d-inline">' + response["item_quantity"] + ' штук</div>)' +
                        '</button>' +
                        '<div id="product_data">' +
                        '<input type="hidden" id="product_id" value="' + product_id + '">' +
                        '<button id="add_another_one_btn" class="btn btn-success btn-vsm">' +
                        '<i class="fas fa-plus-square"></i>' +
                        '</button>' +
                        '</div>' +
                        '<div id="product_data">' +
                        '<input type="hidden" id="product_id" value="' + product_id + '">' +
                        '<button id="subtract_one_from_cart_btn" class="btn btn-danger btn-vsm">' +
                        '<i class="fas fa-minus-square"></i>' +
                        '</button>' +
                        '</div>' +
                        '<div id="product_data">' +
                        '<input type="hidden" id="product_id" value="' + product_id + '">' +
                        '<button id="remove_from_cart_btn" class="btn btn-danger btn-vsm">' +
                        '<i class="fas fa-shopping-cart fa-1x"></i>' +
                        '</button>' +
                        '</div>' +
                        '</div>'
                    ));
                } else {
                    let disabled_button_quantity_indicator = add_to_cart_btn.find("#qty");
                    disabled_button_quantity_indicator.val(response["item_quantity"]);
                }

                cartload();
                alertify.success(response.status);
            },
        });
    });

    $(document).on("click", "#remove_from_cart_btn", function(event) {
        event.preventDefault();
        let remove_from_cart_btn = $(this);
        let product_id = $(this).closest('#product_data').find("#product_id").val();
        $.ajaxSetup( { headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") } });
        $.ajax({
            url: routes.shop.products+"/"+product_id,
            method: "DELETE",
            success: function (response) {
                let buttons = remove_from_cart_btn.closest(".buttons");
                buttons.html("");
                buttons.append($(
                    '<div id="product_data">' +
                    '<input type="hidden" id="product_id" value="' + product_id +'">' +
                    '<button id="add_to_cart_btn" class="btn btn-success">' +
                    '<i class="fas fa-cart-plus fa-1x"></i> Добавить в корзину' +
                    '</button>' +
                    '</div>'
                ));

                cartload();
                alertify.success(response.status);
            },
        });
    });

    $(document).on("click", "#add_another_one_btn", function(event) {
        event.preventDefault();
        let add_another_one_btn = $(this);
        let product_id = $(this).closest("#product_data").find('#product_id').val();
        $.ajaxSetup( { headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") } });
        $.ajax({
            url: routes.shop.products+"/"+product_id,
            method: "POST",
            success: function (response) {
                let item_qty = add_another_one_btn.closest('.item').find('#qty');
                item_qty.html(response["item_quantity"]+" штук");

                cartload();
                alertify.success(response.status);
            }
        });
    });

    $(document).on("click", "#subtract_one_from_cart_btn", function(event) {
        event.preventDefault();
        let subtract_one_from_cart_btn = $(this);
        let product_id = $(this).closest("#product_data").find("#product_id").val();
        $.ajaxSetup( { headers: {"X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") } });
        $.ajax({
            url: routes.shop.products+"/"+product_id,
            method: "PUT",
            success: function (response) {
                let buttons = subtract_one_from_cart_btn.closest(".buttons");
                let item_qty = subtract_one_from_cart_btn.closest(".item").find("#qty");
                if(response["delete"]) {
                    buttons.html('');
                    buttons.append($(
                        '<div id="product_data">' +
                        '<input type="hidden" id="product_id" value="' + product_id +'">' +
                        '<button id="add_to_cart_btn" class="btn btn-success">' +
                        '<i class="fas fa-cart-plus fa-1x"></i> Добавить в корзину' +
                        '</button>' +
                        '</div>'
                    ));
                }
                else {
                    item_qty.html(response["item_quantity"]+" штук");
                }

                cartload();
                alertify.success(response.status);
            }
        });
    });

    $(document).on("click", "#clear_cart", function(event) {
        event.preventDefault();
        let cart = $(this).closest(".container");
        $.ajaxSetup( { headers: {"X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") } });
        $.ajax({
            url: routes.shop.cart.clear_cart,
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                cart.html(
                    '<div class="row">' +
                        '<div class="col-md-12 mycard py-5 text-center">' +
                        '<div class="mycards">' +
                        '<h4>Your cart is currently empty.</h4>' +
                    '<a href="' + routes.shop.products + '" class="btn btn-upper btn-primary outer-left-xs mt-5">Continue Shopping</a>' +
                    '</div>' +
                    '</div>' +
                    '</div>'
                );
                alertify.success(response.status);
                // window.location.reload();
            }
        });
    });

    $(document).on("change", "#quantity", function(event) {
        event.preventDefault();
        let quantity = $(this).val();
        let product_id = $(this).closest("#cart_item_row").find("#product_id").val();
        let item_price = $(this).closest("#cart_item_row").find("#item_price");
        let subtotal_price = $("#subtotal_price");
        let grand_price = $("#grand_price");
        $.ajaxSetup( { headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") } });
        $.ajax({
            url: routes.shop.cart.cart+"/update/" + product_id,
            type: "PUT",
            contentType: "application/json; charset=UTF-8",
            dataType: "json",
            data: JSON.stringify({ "quantity": quantity }),
            success: function (response) {
                // item_price.html(number_format(response["item_price"], 2, ',', ' ')+" UZS");
                // subtotal_price.html(number_format(response["total"], 2, ',', ' ')+" UZS");
                // grand_price.html(number_format(response["total"], 2, ',', ' ')+" UZS");
                item_price.html(response["item_price"]);
                subtotal_price.html(response["total"]);
                grand_price.html(response["total"]);
                alertify.success(response.status);
            }
        });
    });

    $(document).on("click", "#delete_from_cart_btn", function(event) {
        event.preventDefault();
        let cart_item_row = $(this).closest("#cart_item_row");
        let product_id = cart_item_row.find("#product_id").val();
        let subtotal_price = $("#subtotal_price");
        let grand_price = $("#grand_price");
        $.ajaxSetup( { headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") } });
        $.ajax({
            url: routes.shop.products+"/"+product_id,
            type: "DELETE",
            contentType: "application/json; charset=utf-8",
            // dataType: "json",
            success: function (response) {
                cart_item_row.remove();
                subtotal_price.html(response["total"]);
                grand_price.html(response["total"]);
                alertify.success(response.status);
            }
        });
    });

    function cartload() {
        $.ajaxSetup( { headers: {"X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") } });
        $.ajax({
            url: routes.shop.cart.load_cart_data,
            method: "GET",
            success: function (response) {
                let counter = $(".basket-item-count");
                counter.html("");
                counter.append($(
                    '<span class="badge badge-pill badge-danger">(' +
                    response["totalcart"] +
                    ")</span>"));
            }
        });
    }

    // Nurlan got this from github or stackoverflow
    function number_format(number, decimals, decPoint, thousandsSep) {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
        const n = !isFinite(+number) ? 0 : +number
        const prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
        const sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
        const dec = (typeof decPoint === 'undefined') ? '.' : decPoint
        let s = ''
        const toFixedFix = function (n, prec) {
            if (('' + n).indexOf('e') === -1) {
                return +(Math.round(n + 'e+' + prec) + 'e-' + prec)
            } else {
                const arr = ('' + n).split('e')
                let sig = ''
                if (+arr[1] + prec > 0) {
                    sig = '+'
                }
                return (+(Math.round(+arr[0] + 'e' + sig + (+arr[1] + prec)) + 'e-' + prec)).toFixed(prec)
            }
        }
        // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec).toString() : '' + Math.round(n)).split('.')
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || ''
            s[1] += new Array(prec - s[1].length + 1).join('0')
        }
        return s.join(dec)
    }



});
