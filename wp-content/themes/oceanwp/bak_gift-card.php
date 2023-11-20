<?php /* Template Name: Gift Card Template */

if(!isset($_SESSION)) 
{ 
    session_start(); 
}
  
get_header(); 

?>
<style>
   .page-template-gift-card{
   position: relative;
   color: #ffffff;
   background-color: #000;
   }
   .promo-wrap h2{
      margin-bottom: 25px;
      border-bottom: 1px solid #2a2a2a;
      color: #fff;
      font-size: 40px;
   }
   .promo-wrap ul{
     margin: 15px 0 25px 0;
   }
   .promo-wrap ul li{
      list-style-type:none;
      margin-bottom:5px;
      color: #D1CCCC;
      font-size:18px;
   }
   .page-template-gift-card .promo-custom:before{content: none;}
   #pmpro_message1,#pmpro_message2{
    color: #fff;
    margin-top: 15px;
    font-size: 16px;
    padding: 0 0 0 15px;
    border-left: 2px solid red;
   }
   .pmpro_gift-text h3,.pmpro_gift-text p{
   color: #ffffff;
   margin-bottom: 5px;
   }
   .pmpro_gift-text h3{font-size: 25px;}
   .pmpro_gift-text p{font-size: 16px;}
   .pmpro_gift{color: #ffffff;}
   .pmpro_gift input[type="text"]{max-width: 40%;color: #ffffff;}
   .gift-item{
   cursor:pointer;
   padding: 10px 20px;
   margin-bottom: 10px;
   border: 1px solid #2a2a2a;
   transition: all 0.4s ease-in-out;
   }
   .gift-item:hover{
      border: 1px solid #ccc;
   }
   .gift-item.error{
      border: 1px solid red;
   }
   .gift-item.success{
      border: 2px solid #0070c9;
   }
   .gift-item-active{
   padding:15px;
   border: 1px solid #2a2a2a;
   transition:all 0.4s ease-in-out;
   }
   .gift-from-elements{
   min-width: 400px;
   padding-bottom: 30px; 
   }
   @media (max-width: 767px){
      .promo-wrap ul li{font-size:14px;text-align:left;}
      .promo-wrap h2{font-size:30px;}
   .gift-from-elements{
   min-width: 100%;
   text-align:left;
   padding-bottom: 30px; 
   }
   .pmpro_gift-text h3 {
   font-size: 22px;
   }
   .form-check-inline{
   justify-content: center;
   margin-bottom:20px;
   }
   .pmpro_gift{text-align:left;}
   .pmpro_gift input[type="text"] {
   max-width: 100%;
   color: #ffffff;
   margin-bottom: 10px;
   }
   }
   .gift-from-elements textarea{
   min-height: 90px;
   }
   .gift-from-elements h4{
   color: #ffffff;
   font-size: 20px;
   margin-bottom: 5px;
   }
   .pmpro_gift input[type="button"],.gift-from-elements input[type="submit"]{
   background-color: #fff !important;
   color:#000;
   }
   .pmpro_gift input[type="button"]:hover,.gift-from-elements input[type="submit"]{
   background-color: #fff  !important;
   color:#000;
   }
   .form-check-inline {
   display: -ms-flexbox;
   display: flex;
   -ms-flex-align: center;
   align-items: center;
   padding-left: 0;
   }
   [type="radio"]:checked,
   [type="radio"]:not(:checked) {
   position: absolute;
   left: -9999px;
   }
   [type="radio"]:checked + label,
   [type="radio"]:not(:checked) + label {
   position: relative;
   padding-left: 28px;
   cursor: pointer;
   line-height: 20px;
   display: inline-block;
   color: #fff;
   }
   [type="radio"]:checked + label:before,
   [type="radio"]:not(:checked) + label:before {
   content: '';
   position: absolute;
   left: 0;
   top: 0;
   width: 20px;
   height: 20px;
   border: none;
   border-radius: 100%;
   background: #fff;
   }
   [type="radio"]:checked + label:after,
   [type="radio"]:not(:checked) + label:after {
   content: '';
   width: 20px;
   height: 20px;
   background: #fff;
   position: absolute;
   top: 0;
   left: 0;
   border-radius: 100%;
   -webkit-transition: all 0.2s ease;
   transition: all 0.2s ease;
   }
   [type="radio"]:checked + label:before {
   content: '';
   width: 12px;
   height: 12px;
   background: #dd3333;
   position: absolute;
   top: 4px;
   left: 4px;
   z-index: 2;
   border-radius: 100%;
   -webkit-transition: all 0.2s ease;
   transition: all 0.2s ease;
   }
   [type="radio"]:not(:checked) + label:after {
   opacity: 0;
   -webkit-transform: scale(0);
   transform: scale(0);
   }
   [type="radio"]:checked + label:after {
   opacity: 1;
   -webkit-transform: scale(1);
   transform: scale(1);
   }
   .page-header{display:none;}
</style>
<div>
   <img src="https://www.slowrisepizza.com/wp-content/uploads/2020/12/temp-cover.jpg" style="width:100%;" alt="">
   <form id="giftcard-form" method="POST" class="promo-custom pmpro_form">
      <div class="container">
         <div class="promo-wrap">
            <div class="row">
               <div class="col-md-7">
                  <h2><?php the_title(); ?></h2>
                  <?php 
                   the_content();
                  ?>
                 
                  <div class="pmpro_gift-text">
                     <?php 
                        global $wpdb, $pmpro_msg, $pmpro_msgt, $current_user;
                        
                        $pmpro_levels = pmpro_getAllLevels(false, true);
                        $pmpro_level_order = pmpro_getOption('level_order');
                        
                        if(!empty($pmpro_level_order))
                        {
                          $order = explode(',',$pmpro_level_order);
                        
                          //reorder array
                          $reordered_levels = array();
                          foreach($order as $level_id) {
                            foreach($pmpro_levels as $key=>$level) {
                              if($level_id == $level->id)
                                $reordered_levels[] = $pmpro_levels[$key];
                            }
                          }
                        
                          $pmpro_levels = $reordered_levels;
                        }
                        
                        $pmpro_levels = apply_filters("pmpro_levels_array", $pmpro_levels);
                        
                        if($pmpro_msg)
                        {
                        ?>
                     <div class="<?php echo pmpro_get_element_class( 'pmpro_message ' . $pmpro_msgt, $pmpro_msgt ); ?>"><?php echo $pmpro_msg?></div>
                     <?php
                        }
                        ?>
                     <div>
                        <?php 
                           $count = 0;
                           foreach($pmpro_levels as $level)
                           {
                             if(isset($current_user->membership_level->ID))
                               $current_level = ($current_user->membership_level->ID == $level->id);
                             else
                               $current_level = false;
                           ?>
                        <div class="gift-item" data-name="<?php echo $level->initial_payment; ?>" id="level_select_<?php echo $level->id; ?>" onclick="setValue('<?php echo $level->initial_payment; ?>', '<?php echo $level->id;?>', '<?php echo $level->name;?>');" value="">
                           <div class="row align-items-center">
                             <!-- <div class="col-md-1">
                                 <div class="form-check-inline">
                                    <input type="radio" name="level_select" data-name="<?php echo $level->initial_payment; ?>" id="level_select_<?php echo $level->id; ?>" onclick="setValue('<?php echo $level->initial_payment; ?>', '<?php echo $level->id;?>', '<?php echo $level->name;?>');if(this.checked){this.value='<?php echo $level->id; ?>';}" value="" required>   
                                    <label for="level_select_<?php echo $level->id; ?>"></label>
                                 </div>
                              </div> -->
                              <div class="col-md-12">
                                 <h3><?php echo $current_level ? "{$level->name}" : $level->name?></h3>
                                 <p> <?php 
                                    if(pmpro_isLevelFree($level))
                                      $cost_text = "<p>" . __("Free", 'paid-memberships-pro' ) . "</p>";
                                    else
                                      $cost_text = pmpro_getLevelCost($level, true, true); 
                                        $expiration_text = pmpro_getLevelExpiration($level);
                                    if(!empty($cost_text) && !empty($expiration_text)){
                                      $without_now = str_replace("now.",'',$cost_text);
                                      echo $without_now;
                                      }
                                        ?>
                                 </p>
                                
                                <?php if($level->id==1){ ?>
                                  <p><?php the_field('giftcard_level_1'); ?></p>
                                <?php }elseif($level->id==2){ ?>
                                  <p><?php the_field('giftcard_level_2'); ?></p>
                                <?php }elseif($level->id==3){ ?>
                                  <p><?php the_field('giftcard_level_3'); ?></p>
                                <?php }?>

                              </div>
                           </div>
                        </div>
                        <?php
                           }
                           ?>
                     </div>
                     <div class="pmpro_gift">
                        <label for="coupon_code">Have Discount Code?</label>
                        <input type="text" name="coupon_code" id="coupon_code" value="">
                        <input type="button" name="apply_coupon_code" id="apply_coupon_code" value="Apply">
                        <div id="pmpro_message1"></div>
                        <div id="pmpro_message2"></div>
                     </div>
                  </div>
               </div>
               <div class="col-md-5">
                  <div class="checkout-fields gift-from-elements">
                     <h4>Gift to</h4>
                     <div class="pmpro_checkout-field">
                        <label for="gift_to_name">Name*</label>
                        <input id="gift_to_name" name="gift_to_name" type="text" class="input pmpro_required" size="30" required="">
                     </div>
                     <div class="pmpro_checkout-field">
                        <label for="gift_to_email">Email*</label>
                        <input id="gift_to_email" name="gift_to_email" type="email" class="input pmpro_required" size="30" required="" value="">
                     </div>
                     <h4>Gift from</h4>
                     <div class="pmpro_checkout-field">
                        <label for="gift_from_name">Name*</label>
                        <input id="gift_from_name" name="gift_from_name" type="text" class="input pmpro_required" size="30" required="" value="">
                     </div>
                     <div class="pmpro_checkout-field">
                        <label for="gift_from_email">Email*</label>
                        <input id="gift_from_email" name="gift_from_email" type="email" class="input pmpro_required" size="30" required="" value="">
                     </div>
                     <div class="pmpro_checkout-field">
                        <label for="gift_message">Gift Message</label>
                        <textarea id="gift_message" name="gift_message" class="input pmpro_required"></textarea>
                     </div>
                     <input type="button" name="" value="Submit" onclick="formSubmit();" class="btn-white">
                     <input type="hidden" name="action" value="save">
                     <input type="hidden" name="post_name" value="giftcard">
                     <input type="hidden" name="level" id="level" value="">
                     <input type="hidden" name="level_name" id="level_name" value="">
                     <input type="hidden" name="final_value" id="final_value" value="">
                  </div>
               </div>
            </div>
         </div>
      </div>
   </form>
</div>
<?php get_footer(); ?>
<script type="text/javascript">
    function validateEmail(email) {
     const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
     return re.test(email);
    }  
    jQuery('.gift-item').click(function(){
      jQuery('.gift-item').removeClass("error");
      jQuery(this).toggleClass('success').siblings().removeClass('success');
    });

   function setValue(val, level, level_name){
     jQuery("#level").val(level);
     jQuery("#level_name").val(level_name);
     jQuery("#final_value").val(val);
     jQuery('#pmpro_message2').html('<b>Final Price:</b> ' + parseInt(val).toFixed(2));
   }
   
   jQuery('#apply_coupon_code').click(function() {
     var code = jQuery('#coupon_code').val();
     var level_id = jQuery('#level').val();
   
     //if(jQuery("input[name='level_select']").is(':checked')) { 
     if (jQuery(".gift-item").hasClass("success")) {

       if(code)
       {
           //hide any previous message
           jQuery('.pmpro_discount_code_msg').hide();
   
           //disable the apply button
           //jQuery('#apply_coupon_code').attr('disabled', 'disabled');
   
           jQuery.ajax({
               url: "<?php echo admin_url( 'admin-ajax.php' ); ?>", type:'GET',timeout: 5000,
               dataType: 'html',
               data: "action=applydiscountcode&code=" + code + "&level=" + level_id + "&msgfield=pmpro_message",
               error: function(xml){
                   alert('Error applying discount code [1]');
   
                   //enable apply button
                   //jQuery('#apply_coupon_code').removeAttr('disabled');
               },
               success: function(responseHTML){
                   if (responseHTML == 'error')
                   {
                       alert('Error applying discount code [2]');
                   }
                   else
                   {
                       jQuery('#pmpro_message1').html(responseHTML);
                       var a = responseHTML;
                       if(a.substring(a.indexOf('{'), a.lastIndexOf('};') + 1)){
                         var obj =JSON.parse(a.substring(a.indexOf('{'), a.lastIndexOf('};') + 1));
                         jQuery('#pmpro_message2').html('<b>Final Price:</b> ' + parseInt(obj.initial_payment).toFixed(2));  
                         jQuery("#final_value").val(parseInt(obj.initial_payment).toFixed(2));                        
                       }else{
                         //jQuery("#final_value").val( jQuery('input[name="level_select"]:checked').attr("data-name") );
                         jQuery("#final_value").val( val );
                       }
   
                   }
   
                   //enable invite button
                   //jQuery('#apply_coupon_code').removeAttr('disabled');
               }
           });
       }
       else{
         alert("Please enter discount code.");  
       }
   
     }else{ 
       alert("Please select Membership Level."); 
     }
   
     
   });
     
   function formSubmit() {

    var gift_to_name = jQuery('#gift_to_name').val().trim();
    var gift_to_email = jQuery('#gift_to_email').val().trim();
    var gift_from_name = jQuery('#gift_from_name').val().trim();
    var gift_from_email = jQuery('#gift_from_email').val().trim();  

    var level = jQuery("#level").val();
    var level_name = jQuery("#level_name").val();
    var final_value = jQuery("#final_value").val(); 

    if (jQuery(".gift-item").hasClass("success")) {
      if(gift_to_name==''){
          alert('Please enter gift receiver name.');
          return false;
      } else if(gift_to_email==''){
          alert('Please enter gift receiver email.');
          return false;
      } else if(gift_from_name==''){
          alert('Please enter gift sender name.');
          return false;
      } else if(gift_from_email==''){
          alert('Please enter gift sender email.');
          return false;
      } else {

        if (!validateEmail(gift_to_email)){
          alert('Please enter valid gift receiver email.');
        } else if (!validateEmail(gift_from_email)){
          alert('Please enter valid sender receiver email.');
        } else if (gift_to_email == gift_from_email){
          alert('Please enter different email of sender and receiver.');
        } else {
          jQuery("#giftcard-form").submit();

          dataLayer.push({
            'event': 'GiftPizzaClassCheckoutClick',
            'ecommerce': {
              'checkout': {
              'actionField': {'step': 3, 'list': 'Gift Pizza Class'},
              'products': [{
                'name': level_name,              
                'id': level,
                'price': final_value
               }]
               }
            }
          });  
        }    
      }
    }else{
      jQuery('.gift-item').addClass("error");
      alert('Please select Membership Level.');
    }

   }

</script>