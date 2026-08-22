<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>New Order Placed</title>
</head>

<body style="margin:0; padding:0; background:#f4f6f8; font-family:Arial, Helvetica, sans-serif; color:#333;">

<table width="100%" cellpadding="0" cellspacing="0" border="0"
       style="background:#f4f6f8; padding:30px 15px;">

    <tr>
        <td align="center">

            <table width="600" cellpadding="0" cellspacing="0" border="0"
                   style="width:100%; max-width:600px; background:#ffffff; border-radius:10px; overflow:hidden;">

                <!-- Header -->
                <tr>
                    <td style="background:#1f2937; padding:25px 30px; text-align:center;">

                        <h1 style="margin:0; color:#ffffff; font-size:24px;">
                            New Order Placed
                        </h1>

                        <p style="margin:8px 0 0; color:#d1d5db; font-size:13px;">
                            A new order has been received
                        </p>

                    </td>
                </tr>

                <!-- Order Date -->
                <tr>
                    <td style="padding:20px 30px 10px;">

                        <p style="margin:0; font-size:14px; color:#6b7280;">
                            Order Date:
                            <strong style="color:#333;">
                                <?= date('d M Y, h:i A') ?>
                            </strong>
                        </p>
                        <p style="margin:0 0 5px;font-size:14px;color:#4b5563;" >Order Number: <?=(!empty($order['order_number']) ? $order['order_number'] : '');?>
                        <p style="margin:0 0 5px;font-size:14px;color:#4b5563;" >Subtotal : <?=(!empty($order['sub_total']) ? $order['sub_total'] : '');?>
                        <p style="margin:0 0 5px;font-size:14px;color:#4b5563;" >tasx : <?=(!empty($order['tax']) ? $order['tax'] : '');?>
                        <p style="margin:0 0 5px;font-size:14px;color:#4b5563;" >shipping Charge : <?=(!empty($order['shipping_charge']) ? $order['shipping_charge'] : '');?>
                        <p style="margin:0 0 5px;font-size:14px;color:#4b5563;" >Total : <?=(!empty($order['total_amount']) ? $order['total_amount'] : '');?>
                    </td>
                </tr>


                <!-- Products -->
                <tr>
                    <td style="padding:10px 30px 20px;">

                        <h3 style="
                            margin:0 0 15px;
                            font-size:18px;
                            color:#111827;
                        ">
                            Order Items
                        </h3>


                        <?php if (!empty($order_items)): ?>

                            <?php foreach ($order_items as $items): ?>

                                <?php
                                $quantity = isset($items['qty'])? (int)$items['qty']: 1;

                                $price = isset($items['price'])? (float)$items['price']: 0;
                                $total = $price * $quantity;
                                ?>

                                <!-- Product Card -->
                                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                       style="
                                            border:1px solid #e5e7eb;
                                            border-radius:8px;
                                            margin-bottom:15px;
                                            overflow:hidden;
                                       ">

                                    <tr>

                                        <!-- Product Image -->
                                        <td width="130"
                                            valign="top"
                                            style="padding:12px;">

                                            <?php if (!empty($items['product_image'])): ?>

                                                <img
                                                    src="<?= validImg($items['product_image']) ?>"
                                                    alt="<?= esc($items['product_title']) ?>"
                                                    width="110"
                                                    style="
                                                        width:110px;
                                                        height:110px;
                                                        object-fit:cover;
                                                        display:block;
                                                        border-radius:7px;
                                                        border:1px solid #e5e7eb;
                                                    "
                                                >

                                            <?php else: ?>

                                                <div style="
                                                    width:110px;
                                                    height:110px;
                                                    background:#f3f4f6;
                                                    border-radius:7px;
                                                    text-align:center;
                                                    line-height:110px;
                                                    color:#9ca3af;
                                                    font-size:12px;
                                                ">
                                                    No Image
                                                </div>

                                            <?php endif; ?>

                                        </td>


                                        <!-- Product Information -->
                                        <td valign="top"
                                            style="padding:12px 12px 12px 0;">

                                            <!-- Product Title -->
                                            <h2 style="
                                                margin:0 0 7px;
                                                font-size:17px;
                                                line-height:1.4;
                                                color:#111827;
                                            ">
                                                <?= esc($items['product_title']) ?>
                                            </h2>


                                            <!-- Description -->
                                            <?php if (!empty($items['short_description'])): ?>

                                                <p style="
                                                    margin:0 0 10px;
                                                    font-size:13px;
                                                    line-height:1.5;
                                                    color:#6b7280;
                                                ">
                                                    <?= esc($items['short_description']) ?>
                                                </p>

                                            <?php endif; ?>


                                            <!-- Price -->
                                            <p style="
                                                margin:0 0 5px;
                                                font-size:14px;
                                                color:#4b5563;
                                            ">
                                                Price:
                                                <strong style="color:#16a34a;">
                                                    RS: <?= number_format($price, 2) ?>
                                                </strong>
                                            </p>


                                            <!-- Quantity -->
                                            <p style="
                                                margin:0 0 5px;
                                                font-size:14px;
                                                color:#4b5563;
                                            ">
                                                Quantity:
                                                <strong style="color:#111827;">
                                                    <?= $quantity ?>
                                                </strong>
                                            </p>


                                            <!-- Product Total -->
                                            <p style="
                                                margin:0;
                                                font-size:15px;
                                                color:#111827;
                                                font-weight:bold;
                                            ">
                                                Total:
                                                <span style="color:#16a34a;">
                                                    RS:<?= number_format($total, 2) ?>
                                                </span>
                                            </p>

                                        </td>

                                    </tr>

                                </table>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <p style="
                                margin:0;
                                padding:20px;
                                background:#f9fafb;
                                text-align:center;
                                color:#6b7280;
                            ">
                                No products found.
                            </p>

                        <?php endif; ?>

                    </td>
                </tr>


                <!-- Customer Details -->
                <tr>
                    <td style="padding:0 30px 25px;">

                        <h3 style="
                            margin:0 0 15px;
                            font-size:18px;
                            color:#111827;
                        ">
                            Customer Details
                        </h3>


                        <table width="100%" cellpadding="0" cellspacing="0" border="0"
                               style="
                                    background:#f9fafb;
                                    border-radius:8px;
                               ">

                            <!-- Name -->
                            <tr>

                                <td style="
                                    padding:12px 15px;
                                    width:100px;
                                    font-size:14px;
                                    color:#6b7280;
                                ">
                                    Name
                                </td>

                                <td style="
                                    padding:12px 15px;
                                    font-size:14px;
                                    color:#111827;
                                    font-weight:bold;
                                ">
                                    <?= esc($shippingAddress['name'] ?? '') ?>
                                </td>

                            </tr>


                            <!-- Email -->
                            <tr>

                                <td style="
                                    padding:12px 15px;
                                    font-size:14px;
                                    color:#6b7280;
                                ">
                                    Email
                                </td>

                                <td style="
                                    padding:12px 15px;
                                    font-size:14px;
                                ">

                                    <a href="mailto:<?= esc($shippingAddress['email'] ?? '') ?>"
                                       style="
                                            color:#2563eb;
                                            text-decoration:none;
                                       ">
                                        <?= esc($shippingAddress['email'] ?? '') ?>
                                    </a>

                                </td>

                            </tr>


                            <!-- Phone -->
                            <tr>

                                <td style="
                                    padding:12px 15px;
                                    font-size:14px;
                                    color:#6b7280;
                                ">
                                    Phone
                                </td>

                                <td style="
                                    padding:12px 15px;
                                    font-size:14px;
                                ">

                                    <a href="tel:<?= esc($shippingAddress['phone'] ?? '') ?>"
                                       style="
                                            color:#2563eb;
                                            text-decoration:none;
                                       ">
                                        <?= esc($shippingAddress['phone'] ?? '') ?>
                                    </a>

                                </td>

                            </tr>

                        </table>

                    </td>
                </tr>


                <!-- Shipping Address -->
                <tr>
                    <td style="padding:0 30px 30px;">

                        <h3 style="
                            margin:0 0 10px;
                            font-size:18px;
                            color:#111827;
                        ">
                            Shipping Address
                        </h3>


                        <div style="
                            background:#f9fafb;
                            border-left:4px solid #2563eb;
                            padding:15px;
                            border-radius:4px;
                        ">

                            <p style="
                                margin:0;
                                font-size:14px;
                                line-height:1.7;
                                color:#4b5563;
                            ">

                                <!-- <?= nl2br(esc($shippingAddress['address'] ?? '')) ?> city ,state,pincode,country -->
                                Address : <?= $shippingAddress['address'] ?><br>
                                City : <?= $shippingAddress['city'] ?><br>
                                State : <?= $shippingAddress['state'] ?><br>
                                Pincode : <?= $shippingAddress['post'] ?><br>
                                Country : <?= $shippingAddress['country'] ?>

                            </p>

                        </div>

                    </td>
                </tr>


                <!-- Footer -->
                <tr>

                    <td style="
                        background:#f9fafb;
                        padding:20px 30px;
                        text-align:center;
                    ">

                        <p style="
                            margin:0;
                            font-size:12px;
                            color:#9ca3af;
                        ">
                            This is an automated new order notification.
                        </p>

                    </td>

                </tr>

            </table>

        </td>
    </tr>

</table>

</body>
</html>
```
