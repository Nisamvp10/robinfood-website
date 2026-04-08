<?php
$html ='';
if(!$isLogin){
    $html.= '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal"> Login to Add Address </button><br><p>User not logged in</p>';
}else{
    if(count($data) > 0){
        foreach($data as $address){
           $html.= '
            <div class="card mt-2"><div class="card-body"><input type="radio" name="address_id" onclick="isDefault(this)" class="mr-2 addressRadio" value="'.encryptor($address['id']).'" '.($address['is_default'] == 1 ? 'checked' : '').' >
            <p>'.$address['full_name'].','.$address['phone'].','.$address['address_line1'].','.$address['city'].','.$address['state'].','.$address['postal_code'].','.$address['country'].'</p></div></div>';
        }
    }else{
        $html.= '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNewAddressModal"> Add to Address </button><br><p>No address found</p>';
    }
}
echo $html;
?>