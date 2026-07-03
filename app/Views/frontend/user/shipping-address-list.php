<?php
$html ='';
if(!$isLogin){
    //$html.= '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal"> Login to Add Address </button><br><p>User not logged in</p>';
    if($data){
        $html.= '<h3 class="mb-2 mt-3">Delivery Address</h3>';
        foreach($data as $address){
           $html.= ' 
            <div class="card mt-2">
                <div class="card-body ">
                <div class="d-flex align-items-center justify-content-between gap-2">
                    <div>
                        <span class="dltbtn"onclick="removeAddress(\''.encryptor($address['id']).'\')"><i class="fa fa-trash"></i></span>
                    </div>
                    <div>
                        <input type="radio" name="address_id" onclick="isDefault(this)" style="width: 20px; margin-right: 10px;" class="mr-2  addressRadio" value="'.encryptor($address['id']).'" '.($address['is_default'] == 1 ? 'checked' : '').' >
                    </div>
                </div>
                <p>'.$address['full_name'].','.$address['address_line1'].','.$address['city'].','.$address['state'].','.$address['postal_code'].','.$address['country'].'</p>
                <p>'.(!empty($address['country_code']) ? '+'. $address['country_code'] : '').$address['phone'].'</p>
            </div></div>';
        }
    }else{
       // $html.= '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNewAddressModal"> Add to Address </button><br><p>No address found</p>';
    }
}else{
    if(count($data) > 0){
        $html.= '<h3 class="mb-2 mt-3">Delivery Address</h3>';
        foreach($data as $address){
           $html.= ' 
            <div class="card mt-2">
                <div class="card-body ">
                    <div class="d-flex align-items-center justify-content-between gap-2">
                        <div>
                            <span class="dltbtn"onclick="removeAddress(\''.encryptor($address['id']).'\')"><i class="fa fa-trash"></i></span>
                        </div>
                        <div>
                            <input type="radio" name="address_id" onclick="isDefault(this)" style="width: 20px; margin-right: 10px;" class="mr-2  addressRadio" value="'.encryptor($address['id']).'" '.($address['is_default'] == 1 ? 'checked' : '').' >
                        </div>
                    </div>
                    <p>'.$address['full_name'].','.$address['address_line1'].','.$address['city'].','.$address['state'].','.$address['postal_code'].','.$address['country'].'</p>
                    <p>'.(!empty($address['country_code']) ? '+'. $address['country_code'] : '').$address['phone'].'</p>
                </div>
            </div>';
        }
        $html.= '<button type="button" class="btn d-none btn-primary mt-2" data-toggle="modal" data-target="#addNewAddressModal"> Add to Address </button>';
    }else{
        $html.= '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNewAddressModal"> Add to Address </button><br><p>No address found</p>';
    }
}
echo $html;
?>