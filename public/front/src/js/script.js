document.addEventListener("DOMContentLoaded",(function(){const e=document.querySelector(".cookies-section"),s=document.querySelector(".cookies-btn");e&&s&&("true"===localStorage.getItem("cookiesConsent")&&e.classList.add("hide"),s.addEventListener("click",(function(){e.classList.add("hide"),localStorage.setItem("cookiesConsent","true")})));const i=document.querySelector(".header-top-section"),t=document.querySelector(".close-welcome-text");i&&t&&("true"===localStorage.getItem("headerClosed")&&i.classList.add("hide"),t.addEventListener("click",(function(){i.classList.add("hide"),closeNotification(),localStorage.setItem("headerClosed","true")})))})),$(document).ready((function(){$(".pdf-logo-icon").owlCarousel({nav:!0,margin:10,navText:['<img class="img-fluid" src="./front/src/images/slider-left-arrow.svg" width="8" height="12" alt="arrow"/>','<img class="img-fluid" src="./front/src/images/slider-right-arrow.svg" width="8" height="12" alt="arrow"/>'],loop:!0,autoplay:!0,responsiveClass:!0,responsive:{0:{items:2},600:{items:4},1e3:{items:6}}})})),$(".banner-carousel, .testimonial-carousel").owlCarousel({nav:!1,navText:!1,margin:0,loop:!0,autoplay:!0,autoplayTimeout: 7000,responsive:{0:{items:1},480:{items:1},768:{items:1}}}),$(document).ready((function(){$(".desktop_screen .shop-box-icon-carousel").owlCarousel({nav:!0,navText:['<img class="img-fluid" src="./front/src/images/slider-left-arrow.svg" width="8" height="12" alt="arrow"/>','<img class="img-fluid" src="./front/src/images/slider-right-arrow.svg" width="8" height="12" alt="arrow"/>'],margin:10,loop:!0,autoplay:!0,responsiveClass:!0,responsive:{0:{items:3},480:{items:3},768:{items:4},1e3:{items:6}}})})),$(document).ready((function(){$(".mobile_screen .shop-box-icon-carousel").owlCarousel({nav:!0,navText:['<img class="img-fluid" src="./front/src/images/slider-left-arrow.svg" width="8" height="12" alt="arrow"/>','<img class="img-fluid" src="./front/src/images/slider-right-arrow.svg" width="8" height="12" alt="arrow"  id="show-more"/>'],margin:0,loop:!0,autoplay:!0,responsiveClass:!0,responsive:{0:{items:3},480:{items:3},768:{items:4},1e3:{items:6}}})})),$(document).ready((function(){$("#show-more").on("click",(function(){$("#initial-items").addClass("hidden"),$("#all-items").removeClass("hidden"),$("#all-items").owlCarousel({loop:!0,margin:0,nav:!0,navText:['<img class="img-fluid" src="./front/src/images/slider-left-arrow.svg" width="8" height="12" alt="arrow"/>','<img class="img-fluid" src="./front/src/images/slider-right-arrow.svg" width="8" height="12" alt="arrow" />'],lazyLoad:!0,responsive:{0:{items:3},600:{items:5},1e3:{items:8}}})}))})),$(document).ready((function(){$(".product-logo-icon-carousel").owlCarousel({nav:!0,margin:10,navText:['<img class="img-fluid" src="./front/src/images/slider-left-arrow.svg" width="8" height="12" alt="arrow"/>','<img class="img-fluid" src="./front/src/images/slider-right-arrow.svg" width="8" height="12" alt="arrow"/>'],loop:!0,autoplay:!1,responsiveClass:!0,responsive:{0:{items:4},375:{items:4},480:{items:4},768:{items:2},1e3:{items:8}}})})),$(document).ready((function(){$(".product-carousel").owlCarousel({nav:!0,margin:10,navText:['<img class="img-fluid" src="https://jeweljagat.com/front/src/images/slider-left-arrow.svg" width="8" height="12" alt="arrow"/>','<img class="img-fluid" src="https://jeweljagat.com/front/src/images/slider-right-arrow.svg" width="8" height="12" alt="arrow"/>'],loop:!0,autoplay:!0,responsiveClass:!0,responsive:{0:{items:2},375:{items:2},600:{items:2},768:{items:3},1e3:{items:4}}})})),window.onscroll=function(){myFunction()};var header=document.getElementById("myHeader"),sticky=header.offsetTop;function myFunction(){window.pageYOffset>sticky?header.classList.add("sticky"):header.classList.remove("sticky")}function openForm(e,s){var i,t,o;for(t=document.querySelectorAll(".tabcontent, .tabcontent_popup"),i=0;i<t.length;i++)t[i].style.display="none";for(o=document.querySelectorAll(".tablinks, .tablinks_popup"),i=0;i<o.length;i++)o[i].classList.remove("active");document.getElementById(s).style.display="block",e.currentTarget.classList.add("active")}$(".testimonial-carousel").owlCarousel({nav:!0,margin:0,navText:['<img class="img-fluid" src="./front/src/images/slider-left-arrow.svg" width="8" height="12" alt="arrow"/>','<img class="img-fluid" src="./front/src/images/slider-right-arrow.svg" width="8" height="12" alt="arrow"/>'],loop:!0,autoplay:!0,responsive:{0:{items:1},480:{items:1},768:{items:1}}}),$(window).scroll((function(){$(this).scrollTop()>100?$("#back-top").fadeIn():$("#back-top").fadeOut()})),$("#back-top").click((function(){return $("html, body").animate({scrollTop:0},800),!1})),$(document).ready((function(){$("#specialize-tab li:first-child").addClass("active_li"),$("#specialize-tab li").click((function(){$("#specialize-tab li.active_li").removeClass("active_li"),$(this).addClass("active_li")}))}));

if (!localStorage.getItem("headerClosed")) {
      openNotification();
}else{
      closeNotification();
}

$('.close-welcome-text').on('click', function() {
    closeNotification();
});

function openNotification() {
    $('.header-top-section').removeClass('d-none');
    if(display_pg == 1){
        $('.banner-slider-section').addClass('header-note');
        $('.margin-top-head').addClass('header-note');
    }

  }
function closeNotification(){
    $('.header-top-section').addClass('d-none');
      $('.margin-top-head').removeClass('header-note');
      $('.banner-slider-section').removeClass('header-note');
      $('.margin-top-head').removeClass('header-note');
}
  var display_status = $('#daily_status_display').val();
  
  if (display_status == 'home') {
    if ($(location).prop('href') == BASE_URL) {
        if (!localStorage.getItem("popupShown")) {
            setTimeout(function () {
                openPopupModel();
            }, 3000);
        }
    }
  } else {
    console.log(localStorage);
    if (!localStorage.getItem("popupShown")) {
      
        setTimeout(function () {
            openPopupModel();
        }, 3000);
    }
  }
  
  function openPopupModel() {
      $("#myPopupModelOverlay").show();
  }
function closePopupModel() {
      $("#myPopupModelOverlay").hide();
      localStorage.setItem("popupShown", "true");
}
function copypromocode(code) {
    if (code) {
        // Copy the code to the clipboard
        navigator.clipboard.writeText(code).then(function() {
            // Show success message with SweetAlert
            Swal.fire({
                icon: 'success',
                title: 'Promo Code Copied!',
                text: 'Your promo code "' + code + '" has been copied to the clipboard.',
                showConfirmButton: false,
                timer: 1500
            });
        }).catch(function(error) {
            console.error('Failed to copy text: ', error);
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: 'No promo code available to copy.',
            showConfirmButton: false,
            timer: 1500
        });
    }
}
function sharepromocode(code_id)
{
  $.ajax({
    url: getpromocodedata,
    type: 'POST',
    data: {
        'code_id': code_id,
    },
    success: function (response) {
      if(response.status == 1)
      {
        $('#share_p_code').text(response.promocode.code);
        $('#share_p_title').text(response.promocode.title);
        $('#share_p_description').text(response.promocode.description);
        $('#share_p_valid_till').html(response.promocode.string_one);
        $('#share_p_discount').html(response.promocode.string);
        var encoded_message = encodeURIComponent(response.promocode.share_message);
        var p_w_url = 'https://api.whatsapp.com/send?text=' + response.promocode.share_message;
        var p_f_url = 'https://www.facebook.com/sharer/sharer.php?u=' +  response.promocode.share_message;
        var p_t_url = 'https://twitter.com/intent/tweet?text=' +  encoded_message;
        var p_i_url = 'https://www.instagram.com/';
        $('.p_whatsapp_share').attr('onclick', "window.open('"+p_w_url+"', '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400')");
        $('.p_facebook_share').attr('onclick', "window.open('"+p_f_url+"', '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400')");
        $('.p_twitter_share').attr('onclick', "window.open('"+p_t_url+"', '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400')");
        $('.p_insta_share').attr('onclick', "window.open('"+p_i_url+"', '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400')");
        $('#all-promocodes-popup').modal('hide');
        $('#share_promocode_popup').modal('show');
      }else{
        Swal.fire({
          icon: 'error',
          title: 'Oops!',
          text: response.message,
          showConfirmButton: false,
          timer: 1500
      });
      }
    }
});
}

$('#reg_country').on('change', function () { 
    var country = this.value;
      $("#reg_state").html('');
      $.ajax({
        url: get_state_route,
        type: "POST",
        data: {
          country: country,
          _token: send_token
        },
        dataType: 'json',
        success: function(result) {
          $('#reg_state').html('<option value="">Select State</option>');
          $.each(result.state, function(key, value) {
            $("#reg_state").append('<option value="' + value.id + '">' + value.name + '</option>');
          });
        }
      }); 
});
$('#reg_state').on('change', function () { 
    var state = this.value;
      $("#reg_city").html('');
      $.ajax({
        url: get_city_route,
        type: "POST",
        data: {
          state: state,
          _token: send_token
        },
        dataType: 'json',
        success: function(result) {
          $('#reg_city').html('<option value="">Select City</option>');
          $.each(result.city, function(key, value) {
            $("#reg_city").append('<option value="' + value.id + '">' + value.name + '</option>');
          });
        }
      }); 
});