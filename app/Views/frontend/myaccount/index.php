<?= view('frontend/inc/header') ?>

   <!-- Breadcumb Section Start -->
      <div class="breadcumb-section">
         <div
            class="breadcumb-container-wrapper"
            data-bg-src="<?=base_url('public/assets/template/');?>assets/img/breadcumb-bg.png"
         >
            <div class="shape1">
               <img
                  src="<?=base_url('public/assets/template/');?>assets/img/breadcumb-shape1_1.png"
                  alt="shape"
               />
            </div>
            <div class="shape2">
               <img
                  src="<?=base_url('public/assets/template/');?>assets/img/breadcumb-shape1_2.png"
                  alt="shape"
               />
            </div>
            <div class="shape3">
               <img
                  src="<?=base_url('public/assets/template/');?>assets/img/breadcumb-shape1_3.png"
                  alt="shape"
               />
            </div>
            <div class="shape4">
               <img
                  src="<?=base_url('public/assets/template/');?>assets/img/breadcumb-shape1_4.png"
                  alt="shape"
               />
            </div>
            <div class="container">
               <ul class="breadcumb-wrapper">
                  <li>
                     <a href="<?=base_url();?>"
                        ><i class="fa-sharp fa-light fa-house"></i
                     ></a>
                  </li>
                  <li><i class="fa-solid fa-chevron-right"></i></li>
                  <li>Home</li>
                  <li><i class="fa-solid fa-chevron-right"></i></li>
                  <li>User Dashboard</li>
               </ul>
            </div>
         </div>
      </div>

      <!-- Dashboard Section Start -->
      <div class="dashboard-section section-padding fix">
         <div class="container">
            <div class="row">
               <div class="col-xl-3">
                  <div class="dashboard-navigation-sidebar">
                     <h3>Navigation</h3>
                     <div>
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                           <button class="nav-link active" id="v-pills-dashboard-tab" data-bs-toggle="pill" data-bs-target="#v-pills-dashboard" type="button" role="tab" aria-controls="v-pills-dashboard" aria-selected="true">
                              <i class="fa-sharp fa-solid fa-grid-2"></i
                              >Dashboard
                           </button>

                           <button class="nav-link" id="v-pills-order-history-tab" data-bs-toggle="pill" data-bs-target="#v-pills-order-history" type="button" role="tab" aria-controls="v-pills-order-history" aria-selected="false">
                              <i class="fa-solid fa-sync"></i>Order History
                           </button>

                           <button class="nav-link d-none" id="v-pills-order-details-tab" data-bs-toggle="pill" data-bs-target="#v-pills-order-details" type="button" role="tab" aria-controls="v-pills-order-details" aria-selected="false">
                              <i class="fa-solid fa-list"></i>Order Details
                           </button>

                           <button class="nav-link" id="v-pills-wishlist-tab" data-bs-toggle="pill" data-bs-target="#v-pills-wishlist" type="button" role="tab" aria-controls="v-pills-wishlist" aria-selected="false">
                              <i class="fa-light fa-heart"></i>Wishlist
                           </button>

                           <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                              <i class="fa-regular fa-gear"></i>Settings
                           </button>

                           <button class="nav-link" >
                            <a href="<?=base_url('user-logout')?>">
                              <i class="fa-solid fa-sign-out-alt"></i>Log Out
                            </a>
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-9 mt-4 mt-xl-0">
                  <div class="tab-content" id="v-pills-tabContent">
                     <div
                        class="tab-pane fade show active"
                        id="v-pills-dashboard"
                        role="tabpanel"
                        aria-labelledby="v-pills-dashboard-tab"
                        tabindex="0"
                     >
                        <div class="dashboard-wrapper">
                           <div class="dashboard-top">
                              <div class="row">
                                 <div class="col-xl-7 col-md-6">
                                    <div class="dashboard-profile">
                                       <div class="thumb">
                                         <?=  '<span>'.ucfirst(substr($userData->name,0,1)).'</span>' ?>
                                       </div>
                                       <h3><?= $userData->name ?? 'Guest' ?></h3>
                                       <p>Customer</p>
                                       <a href="#">Edit Profile</a>
                                    </div>
                                 </div>
                                 <div class="col-xl-5 col-md-6 mt-4 mt-md-0">
                                    <div class="dashboard-profile-info">
                                       <h6>Billing Address [is default]</h6>
                                       <h5><?= $defaultSHippingAddress->full_name ?? '' ?></h5>
                                       <a href="#" class="address"
                                          ><?= $defaultSHippingAddress->address_line1 ?? '' ?></a
                                       >
                                       <a
                                          href="mailto:<?=$userData->email?>"
                                          class="email"
                                          ><?=$userData->email?></a
                                       >
                                       <a href="tel:<?=$defaultSHippingAddress->phone ?? ''?>" class="phone"
                                          ><?=$defaultSHippingAddress->phone ?? ''?></a
                                       >
                                       <button class="edit">
                                          Edit Address
                                       </button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="order-history">
                              <div class="header">
                                 <h2>Recent Order History</h2>
                                 <a href="#" class="view-all">View All</a>
                              </div>
                              <table>
                                 <thead>
                                    <tr>
                                       <th>ORDER ID</th>
                                       <th>DATE</th>
                                       <th>TOTAL</th>
                                       <th>STATUS</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                    if(!empty($recentOrders)){
                                        foreach($recentOrders as $order){
                                            ?>
                                    <tr>
                                       <td>#<?= $order['order_number'] ?></td>
                                       <td><?= date('d-m-Y',strtotime($order['created_at'])) ?></td>
                                       <td><?= money_format_custom($order['total_amount']) ?> (<?= ($order['total_items'] > 1 ? $order['total_items'] . ' Products' : $order['total_items'] . ' Product') ?> )</td>
                                       <td>
                                          <span class="status <?= ($order['status'] == 'delivered' ? 'completed' : ($order['status'] == 'confirmed' ? 'on-the-way' : ($order['status'] == 'pending' ? 'processing' : 'processing'))) ?>"
                                             ><?= strtoupper($order['status']) ?></span
                                          >
                                          <a href="#">View Details</a>
                                       </td>
                                    </tr>
                                    <?php
                                        }
                                    }
                                   ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                     <div
                        class="tab-pane fade"
                        id="v-pills-order-history"
                        role="tabpanel"
                        aria-labelledby="v-pills-order-history-tab"
                        tabindex="0"
                     >
                        <div class="order-history2">
                           <div class="header">
                              <h2>Order History</h2>
                           </div>
                           <table>
                              <thead>
                                 <tr>
                                    <th>ORDER ID</th>
                                    <th>DATE</th>
                                    <th>TOTAL</th>
                                    <th>STATUS</th>
                                 </tr>
                              </thead>
                              <tbody>
                                   <?php
                                    if(!empty($orders)){
                                        foreach($orders as $order){
                                            ?>
                                    <tr>
                                       <td>#<?= $order['order_number'] ?></td>
                                       <td><?= date('d-m-Y',strtotime($order['created_at'])) ?></td>
                                       <td><?= money_format_custom($order['total_amount']) ?> (<?= ($order['total_items'] > 1 ? $order['total_items'] . ' Products' : $order['total_items'] . ' Product') ?> )</td>
                                       <td>
                                          <span class="status <?= ($order['status'] == 'delivered' ? 'completed' : ($order['status'] == 'confirmed' ? 'on-the-way' : ($order['status'] == 'pending' ? 'processing' : 'processing'))) ?>"
                                             ><?= strtoupper($order['status']) ?></span
                                          >
                                          <a href="#">View Details</a>
                                       </td>
                                    </tr>
                                    <?php
                                        }
                                    }
                                   ?>

                                 <!-- Add more rows as necessary -->
                              </tbody>
                           </table>
                           <div class="pagination">
                              <a href="#" class="prev"
                                 ><i class="fa-solid fa-chevron-left"></i
                              ></a>
                              <a href="#" class="page active">01</a>
                              <a href="#" class="page">02</a>
                              <a href="#" class="page">03</a>
                              <a href="#" class="page">04</a>
                              <a href="#" class="next"
                                 ><i class="fa-solid fa-chevron-right"></i
                              ></a>
                           </div>
                        </div>
                     </div>
                     <div
                        class="tab-pane fade"
                        id="v-pills-order-details"
                        role="tabpanel"
                        aria-labelledby="v-pills-order-details-tab"
                        tabindex="0"
                     >
                        <div class="order-details">
                           <div class="header">
                              <h2>
                                 Order Details
                                 <span>• April 24, 2021 • 3 Products</span>
                              </h2>
                              <a href="#" class="back-to-list">Back to List</a>
                           </div>
                           <div class="details-wrapper">
                              <div class="address-section">
                                 <div class="box">
                                    <h4>Billing Address</h4>
                                    <div class="content">
                                       <h5>Dainne Russell</h5>
                                       <p>
                                          4140 Parker Rd. Allentown, New Mexico
                                          31134
                                       </p>
                                       <p>
                                          Email:
                                          <a
                                             href="mailto:dainne.russell@gmail.com"
                                             >dainne.russell@gmail.com</a
                                          >
                                       </p>
                                       <p>
                                          Phone:
                                          <a href="tel:435346543r">
                                             (671) 555–0110</a
                                          >
                                       </p>
                                    </div>
                                 </div>
                                 <div class="box">
                                    <h4>Shipping Address</h4>
                                    <div class="content">
                                       <h5>Dainne Russell</h5>
                                       <p>
                                          4140 Parker Rd. Allentown, New Mexico
                                          31134
                                       </p>
                                       <p>
                                          Email:
                                          <a
                                             href="mailto:dainne.russell@gmail.com"
                                             >dainne.russell@gmail.com</a
                                          >
                                       </p>
                                       <p>
                                          Phone:
                                          <a href="tel:435346543r">
                                             (671) 555–0110</a
                                          >
                                       </p>
                                    </div>
                                 </div>
                              </div>
                              <div class="summary-section">
                                 <h5>Order Summary</h5>
                                 <p><strong>Order ID:</strong> #4152</p>
                                 <p><strong>Payment Method:</strong> Paypal</p>
                                 <p><strong>Subtotal:</strong> $365.00</p>
                                 <p><strong>Discount:</strong> 20%</p>
                                 <p><strong>Shipping:</strong> Free</p>
                                 <p>
                                    <strong>Total:</strong>
                                    <span class="total-amount">$84.00</span>
                                 </p>
                              </div>
                           </div>
                           <div class="progress-bar">
                              <div class="step completed">
                                 <i class="fa-solid fa-check"></i>
                                 <span>Order Received</span>
                              </div>
                              <div class="step active">
                                 <span class="circle">02</span>
                                 <span>Processing</span>
                              </div>
                              <div class="step">
                                 <span class="circle">03</span>
                                 <span>On the Way</span>
                              </div>
                              <div class="step">
                                 <span class="circle">04</span>
                                 <span>Delivered</span>
                              </div>
                           </div>
                           <div class="product-table">
                              <table>
                                 <thead>
                                    <tr>
                                       <th>PRODUCT</th>
                                       <th>PRICE</th>
                                       <th>QUANTITY</th>
                                       <th>SUBTOTAL</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td>
                                          <img
                                             src="assets/images/dashboard/dashboard-order-product1.png"
                                             alt="Product"
                                          />
                                          High-Neck puff jacket
                                       </td>
                                       <td>$14.00</td>
                                       <td>x5</td>
                                       <td>$70.00</td>
                                    </tr>
                                    <tr>
                                       <td>
                                          <img
                                             src="assets/images/dashboard/dashboard-order-product2.png"
                                             alt="Product"
                                          />
                                          flowy dress that often
                                       </td>
                                       <td>$14.00</td>
                                       <td>x2</td>
                                       <td>$28.00</td>
                                    </tr>
                                    <tr>
                                       <td>
                                          <img
                                             src="assets/images/dashboard/dashboard-order-product3.png"
                                             alt="Product"
                                          />
                                          close-fitting dress
                                       </td>
                                       <td>$26.70</td>
                                       <td>x10</td>
                                       <td>$267.00</td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                     <div
                        class="tab-pane fade"
                        id="v-pills-wishlist"
                        role="tabpanel"
                        aria-labelledby="v-pills-wishlist-tab"
                        tabindex="0"
                     >
                        <!-- Wishlist Section Start -->
                        <div class="wishlist-wrapper fix bg-white">
                           <div class="container">
                              <form action="#" class="woocommerce-cart-form">
                                 <table class="wishlist_table">
                                    <thead>
                                       <tr>
                                          <th class="cart-col-image">
                                             Product
                                          </th>
                                          <th class="cart-col-price">Price</th>
                                          <th class="cart-col-total">
                                             Sub total
                                          </th>
                                          <th class="cart-col-stock">Stock</th>
                                       </tr>
                                    </thead>
                                    <tbody class="d-none">
                                       <tr class="cart_item">
                                          <td class="product" data-title="Product">
                                             <button>
                                                <i class="fa-solid fa-xmark"></i>
                                             </button>
                                             <a class="cartimage" href="shop-details.html"><img width="91" height="91" src="assets/images/cart/cart-thumb1_1.jpg" alt="Image" /></a>
                                             shorter dress above
                                          </td>
                                          <td data-title="Price">
                                             <span class="amount"><bdi><span>$</span>30.00</bdi></span>
                                          </td>
                                          <td data-title="Total">
                                             <span class="amount"><bdi><span>$</span>20.00</bdi></span>
                                          </td>
                                          <td data-title="stock">
                                             <a href="#" class="stock">In stock</a>
                                          </td>
                                       </tr>
                                       <tr class="cart_item">
                                          <td class="product" data-title="Product">
                                             <button>
                                                <i class="fa-solid fa-xmark"></i>
                                             </button>
                                             <a class="cartimage" href="shop-details.html"><img width="91" height="91" src="assets/images/cart/cart-thumb1_2.jpg" alt="Image" /></a>
                                             close-fitting dress
                                          </td>
                                          <td data-title="Price">
                                             <span class="amount"><bdi><span>$</span>50.00</bdi></span>
                                          </td>
                                          <td data-title="Total">
                                             <span class="amount"><bdi><span>$</span>60.00</bdi></span>
                                          </td>
                                          <td data-title="stock">
                                             <a href="#" class="stock_out">out of stock</a>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </form>
                           </div>
                        </div>
                     </div>
                     <div
                        class="tab-pane fade"
                        id="v-pills-settings"
                        role="tabpanel"
                        aria-labelledby="v-pills-settings-tab"
                        tabindex="0"
                     >
                        <div class="container">
                           <!-- Account Settings -->
                           <div class="account-settings">
                              <h4 class="section-title">Account Settings</h4>
                              <div class="form-wrapper">
                                 <div class="row">
                                    <div class="col-md-8">
                                       <form  id="myForm"  class="contact-form-items">
                                          <div class="row g-3">
                                             <div class="col-md-6">
                                                <label for="firstName" class="form-label" > Name</label>
                                                <input type="hidden" name="userId" value="<?=$userData->id ;?>" />
                                                <input type="text" value="<?=$userData->name ?>" class="form-control" id="name" name="name" placeholder="<?=$userData->name ;?>"/>
                                             </div>
                                            
                                             <div class="col-md-12">
                                                <label for="email" class="form-label" >Email</label>
                                                <input type="email" name="email" value="<?=$userData->email ?>" class="form-control" readonly />
                                             </div>
                                             <div class="col-md-12">
                                                <label for="phoneNumber"   class="form-label" >Phone Number</label>
                                                <input type="tel" name="phone" value="<?=$userData->phone;?>" class="form-control" id="phone" placeholder="" />
                                                <div class="invalid-feedback" id="phoneError"></div>
                                             </div>
                                          </div>
                                          <button
                                             type="submit" id="loginBtn" class="theme-btn mt-3" >
                                             Save Changes
                                          </button>
                                       </form>
                                    </div>
                          
                                 </div>
                              </div>
                           </div>

                           <!-- Billing Address -->
                           <div class="billing-address mt-4 d-none">
                              <h4 class="section-title">Billing Address</h4>
                              <div class="form-wrapper">
                                 <div class="row mb-4">
                                    <form class="row g-3">
                                       <div class="col-md-6">
                                          <label for="billingFirstName" class="form-label">First Name</label>
                                          <input type="text" class="form-control" id="billingFirstName" placeholder="Dianne" />
                                       </div>
                                       <div class="col-md-6">
                                          <label for="billingLastName" class="form-label">Last Name</label>
                                          <input type="text" class="form-control" id="billingLastName" placeholder="Dianne" />
                                       </div>
                                       <div class="col-md-6">
                                          <label for="companyName" class="form-label">Company Name (optional)</label>
                                          <input type="text" class="form-control" id="companyName" placeholder="Zakirsoft" />
                                       </div>
                                       <div class="col-md-6">
                                          <label for="streetAddress" class="form-label">Street Address</label>
                                          <input type="text" class="form-control" id="streetAddress" placeholder="Zakirsoft" />
                                       </div>
                                       <div class="col-md-6">
                                          <label for="city" class="form-label">City</label>
                                          <input type="text" class="form-control" id="city" placeholder="Zakirsoft" />
                                       </div>
                                       <div class="col-md-6">
                                          <label for="state" class="form-label">State</label>
                                          <input type="text" class="form-control" id="state" placeholder="Zakirsoft" />
                                       </div>
                                       <div class="col-md-4">
                                          <label for="country" class="form-label">Country/Region</label>
                                          <select id="country" class="form-select">
                                             <option selected>United States</option>
                                             <option>Canada</option>
                                             <option>Other</option>
                                          </select>
                                       </div>
                                       <div class="col-md-4">
                                          <label for="state" class="form-label">State</label>
                                          <select
                                             id="state"
                                             class="form-select"
                                          >
                                             <option selected>United States</option>
                                             <option>Canada</option>
                                             <option>Other</option>
                                          </select>
                                       </div>
                                       <div class="col-md-4">
                                          <label for="country" class="form-label">Country/Region</label>
                                          <select id="country" class="form-select">
                                             <option selected>United States</option>
                                             <option>Canada</option>
                                             <option>Other</option>
                                          </select>
                                       </div>
                                       <div class="col-md-4">
                                          <label for="state" class="form-label">State</label>
                                          <select id="state" class="form-select">
                                             <option selected>
                                                Washington DC
                                             </option>
                                             <option>California</option>
                                             <option>New York</option>
                                          </select>
                                       </div>
                                       <div class="col-md-4">
                                          <label for="zipCode" class="form-label">Zip Code</label>
                                          <input type="text" class="form-control" id="zipCode" placeholder="20033" />
                                       </div>
                                       <div class="col-md-6">
                                          <label for="billingEmail" class="form-label">Email</label>
                                          <input type="email" class="form-control" id="billingEmail" placeholder="dianne.russell@gmail.com" />
                                       </div>
                                       <div class="col-md-6">
                                          <label for="billingPhone" class="form-label">Phone</label>
                                          <input type="tel" class="form-control" id="billingPhone" placeholder="(603) 805-0123" />
                                       </div>
                                       <div class="col-12">
                                          <button type="submit" class="theme-btn mt-3">Save Changes</button>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                           </div>

                           <!-- Change Password -->
                           <div class="change-password mt-4">
                              <h4 class="section-title">Change Password</h4>
                              <div class="form-wrapper">
                                 <form id="changePasswordForm" class="row g-3">
                                    <div class="col-md-4">
                                       <label for="currentPassword" class="form-label">Current Password</label>
                                       <input type="password" name="currentPassword" class="form-control" id="currentPassword" placeholder="Password" />
                                       <div id="currentPasswordError" class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-4">
                                       <label for="newPassword" class="form-label">New Password</label>
                                       <input type="password" name="newPassword" class="form-control" id="newPassword" placeholder="Password" />
                                       <div id="newPasswordError" class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-4">
                                       <label for="confirmPassword" class="form-label">Confirm Password</label>
                                       <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" placeholder="Password" />
                                       <div id="confirmPasswordError" class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12">
                                       <button type="submit" class="theme-btn mt-3" id="changePasswordBtn">Change Password</button>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="v-pills-logout" role="tabpanel" aria-labelledby="v-pills-logout-tab" tabindex="0"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>

<?= view('frontend/inc/footerLink') ?>
<script>


    $(document).on('submit', '#myForm', function (e) {
        e.preventDefault();
         $('#loginBtn').prop('disabled', true).html(
         '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Login...'
      );
        const formData = new FormData(this);
         $('.is-invalid').removeClass('is-invalid');
         $('.invalid-feedback').text('');

        $.ajax({
            url: "<?=base_url('account-update')?>",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {

                if (response.success) {
                  $('#loginBtn').prop('disabled', false).html('Login');
                   toastr.success(response.message);
                } else {
                    if (response.errors) {

                        $.each(response.errors, function (field, msg) {
                            $('#' + field).addClass('is-invalid');
                            $('#' + field + 'Error').text(msg.replaceAll('_', ' '));

                        });

                    }

                }
                $('#loginBtn').prop('disabled', false).html('Login');

            }
        });

    });

    $(document).on('submit', '#changePasswordForm', function (e) {
        e.preventDefault();
         $('#changePasswordBtn').prop('disabled', true).html(
         '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Login...'
      );
        const formData = new FormData(this);
         $('.is-invalid').removeClass('is-invalid');
         $('.invalid-feedback').text('');

        $.ajax({
            url: "<?=base_url('change-password')?>",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {

                if (response.success) {
                  $('#changePasswordBtn').prop('disabled', false).html('Login');
                   toastr.success(response.message);
                   $('#changePasswordForm')[0].reset();
                } else {
                    if (response.errors) {

                        $.each(response.errors, function (field, msg) {
                            $('#' + field).addClass('is-invalid');
                            $('#' + field + 'Error').text(msg.replaceAll('_', ' '));

                        });

                    }

                }
                $('#changePasswordBtn').prop('disabled', false).html('Login');

            }
        });

    });


</script>
