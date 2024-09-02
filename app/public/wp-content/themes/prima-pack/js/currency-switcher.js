jQuery(document).ready(function ($) {
    var userCountry = getCookie('user_country');
    $('.select-currency').val(userCountry);

    $('.select-currency').change(function () {
        var dropdownId = $(this).attr('id');
        var selectedCurrency = $(this).val();
        if (selectedCurrency === userCountry) {
            return;
        }
        var currentURL = window.location.href;
        if (currentURL.includes('?popcount=1')) {
            currentURL = currentURL.replace(/(\?popcount=1|\?popcount=1%3Fpopcount%3D1)/, '');
        }
        $.ajax({
            url: currencySwitcher.ajaxurl,
            type: 'POST',
            dataType: 'JSON',
            data: {
                action: 'currency_switcher',
                nonce: currencySwitcher.nonce,
                currency: selectedCurrency
            },
            success: function (data) {
                if (data.status === 'success') {
                    if (!currentURL.includes('?popcount=1')) {
                        currentURL += '?popcount=1';
                    }
                    window.location.replace(currentURL);
                }
            }
        });
    });

    function getCookie(name) {
        var value = "; " + document.cookie;
        var parts = value.split("; " + name + "=");
        if (parts.length === 2) return parts.pop().split(";").shift();
    }
});
