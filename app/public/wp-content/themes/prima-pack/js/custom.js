jQuery(document).ready(function ($) {
    $('html').css('overflow', 'hidden');
    Swal.fire({
        title: 'Select Your Country',
        allowOutsideClick: false,
        allowEscapeKey: false,
        backdrop: 'rgb(0 0 0 / 87%)',
        input: 'radio',
        inputOptions: {
            'US' : 'US',
            'Canada' : 'Canada'
        },
        inputValidator: (value) => {
            if (!value) {
                return 'You need to choose something!'
            }
        },
        confirmButtonText: 'Submit',
        confirmButtonColor: '#FA7B47',
        showLoaderOnConfirm: true,
        focusConfirm: false,
        inputAutoFocus: false,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: frontendajax.ajaxurl,
                type: 'POST',
                dataType: 'JSON',
                data: 'action=set_country&nonce='+frontendajax.nonce+'&country='+result.value,
                success: (data) => {
                    if(data.status == 'success'){
                        let currentURL = window.location.href+'?popcount=1';
                        window.location.replace(currentURL);
                    }
                }
            });
        }
    });
});