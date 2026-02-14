document.addEventListener('click', async (e) => {
    /* ================= ADD TO CART ================= */
    if (e.target.closest('.add-to-cart')) {

        const btn = e.target.closest('.add-to-cart');
        const productId = btn.dataset.id;
        let qty = parseInt(document.getElementById('quantity')?.value) || 1;

        const response = await fetch(App.getSiteurl() + "cart/add", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify({
                product_id: productId,
                qty: qty
            })
        });

        const data = await response.json();

        if (data.status) {
            toastr.success(data.message);
            document.getElementById('cartCount').innerText = data.cartCount;
            cartNotification();
        } else {
            toastr.error(data.message);
        }
    }

    /* ================= REMOVE FROM CART ================= */
    if (e.target.closest('.remove-from-cart')) {

        const btn = e.target.closest('.remove-from-cart');
        const productId = btn.dataset.id;

        const response = await fetch(App.getSiteurl() + "cart/remove", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify({
                product_id: productId
            })
        });

        const data = await response.json();

        if (data.status) {
            toastr.success(data.message);

            // remove item from UI
            document.querySelector(`.cart-item[data-id="${productId}"]`)?.remove();

            document.getElementById('cartCount').innerText = data.cartCount;
            cartNotification();
        } else {
            toastr.error(data.message);
        }
    }

});

cartNotification();
function cartNotification() {
    fetch(App.getSiteurl() + "cart/getCart", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.res) {
                $('#menuCart').html(data.res);
            }
        });
}

