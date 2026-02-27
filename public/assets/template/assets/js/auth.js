function nextStep(step) {
    document.querySelectorAll('.step').forEach(el => el.classList.add('hidden'));
    document.getElementById(`step${step}`).classList.remove('hidden');
}

function prevStep(step) {
    document.querySelectorAll('.step').forEach(el => el.classList.add('hidden'));
    document.getElementById(`step${step}`).classList.remove('hidden');
}

$('#registerForm').on('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    $.ajax({
        url: App.getSiteurl() + '/register',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.success) {
                window.location.href = response.url;
            } else {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                if (response.errors) {
                    $.each(response.errors, function (field, msg) {
                        $('#' + field).addClass('is-invalid');
                        $('#' + field + 'Error').text(msg.replaceAll('_', ' '));
                    })
                }
            }
        }
    });
})

$('#loginForm').on('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    $('#loginBtn').prop('disabled', true).html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
    );

    $.ajax({
        url: App.getSiteurl() + '/user-login',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                window.location.href = response.url;
            } else {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                if (response.errors) {
                    $.each(response.errors, function (field, msg) {
                        $('#' + field).addClass('is-invalid');
                        $('#' + field + 'Error').text(msg.replaceAll('_', ' '));
                    })
                }
            }
        }
    });
})
