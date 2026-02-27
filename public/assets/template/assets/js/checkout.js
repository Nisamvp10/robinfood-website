shippingAddress();

function shippingAddress() {
    let address = $('#shippingAddress');
    address.html();
    $.ajax({
        url: App.getSiteurl() + 'shipping-address',
        method: 'POST',
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
            address.html(response.result);
        }

    })
}


$('#addShippingAddressForm').on('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    let webForm = $('#addShippingAddressForm');
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('#loginBtn').prop('disabled', true).html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
    );

    $.ajax({
        url: App.getSiteurl() + 'user/add-shipping-address',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
            if (response.status) {
                webForm[0].reset();
                $('#loginBtn').prop('disabled', false).html('Save Address');
                shippingAddress();
            } else {
                $('#loginBtn').prop('disabled', false).html('Save Address');
                if (response.login === false) {
                    $('#addNewAddressModal').css('display', 'none');
                    $('#loginModal').modal('show');
                }
                else if (response.errors) {
                    $.each(response.errors, function (field, msg) {
                        $('#' + field).addClass('is-invalid');
                        $('#' + field + 'Error').text(msg.replaceAll('_', ' '));
                    })
                }

            }
        }
    });
})

document.addEventListener('click', async (e) => {
    if (e.target.classList.contains('checkoutBtn')) {
        //FIRST CHECK IS LOGIN OR NOT
        const isLogin = await fetch(App.getSiteurl() + '/isLogin');
        const res = await isLogin.json();
        let btn = $('.checkoutBtn');
        btn.prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Placing Order...'
        );
        if (res.status) {
            //window.location.href = App.getSiteurl() + '/checkout';
            //check any address select or not
            const address = $('input[name="address_id"]:checked').val();
            if (address) {
                //place order
                $.ajax({
                    url: App.getSiteurl() + 'place-order',
                    method: 'POST',
                    data: { address_id: address },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message);
                            btn.prop('disabled', false).html('Place Order');
                            mycart();
                            // window.location.href = response.url;
                        } else {
                            toastr.error(response.message);
                            btn.prop('disabled', false).html('Place Order');
                        }
                    }
                })
            } else {
                toastr.error('Please select address');
                btn.prop('disabled', false).html('Place Order');
            }

        } else {
            $('#loginModal').modal('show');

            btn.prop('disabled', false).html('Place Order');
        }
    }

    if (e.target.classList.contains('applyCoupon')) {
        const couponCode = $('.couponcodeInput').val();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').empty();
        let btn = $('.applyCoupon');
        btn.prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Applying...'
        );
        if (couponCode) {
            $.ajax({
                url: App.getSiteurl() + 'apply-coupon',
                method: 'POST',
                data: { coupon_code: couponCode },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                        mycart();
                    } else {
                        if (response.errors) {
                            $.each(response.errors, function (field, msg) {
                                $('#' + field).addClass('is-invalid');
                                $('#' + field + 'Error').text(msg.replaceAll('_', ' '));
                            })
                        }
                        if (response.message) {
                            toastr.error(response.message);
                        }
                    }
                    btn.prop('disabled', false).html('Apply');
                }
            })
        } else {
            toastr.error('Please enter coupon code');
            btn.prop('disabled', false).html('Apply');
        }
    }
})



function isDefault(e) {
    if (e.checked) {
        $.ajax({
            url: App.getSiteurl() + 'set-default-address',
            method: 'POST',
            data: { address_id: e.value },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            }
        })
    }
}
