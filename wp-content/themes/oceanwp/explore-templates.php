<?php /* Template Name: Explore Template */
   if(!isset($_SESSION)) 
   { 
       session_start(); 
   }
   
   get_header(); 
   
   ?>
   
 
<style>
   .page-template-explore-templates{
   position: relative;
   color: #ffffff;
   background-color: #000;
   }
   .pr-0{padding-right:0;}
   .text-right{text-align: right;}
   .explor-boxes{
      color:#D1CCCC;
      font-size:18px;
   }
   .explor-boxes p strong{color:#fff;}
   .explor-boxes h2{
      margin-bottom: 25px;
    border-bottom: 1px solid #2a2a2a;
    color: #fff;
    font-size: 40px;
   }
   .explor-boxes p{margin-bottom: 5px;}
   .explore-wrap{
   padding: 40px 0;
   }
   .expoler-item {
   display: inline-block;
   width: 100%;
   background: #191c21;
   text-align: center;
   padding: 20px;
   margin-bottom:15px;
   border-radius: 4px;
   border: 1px solid #272c33;
   transition:all 0.4s ease-in-out;
   }
   .expoler-item:hover{
   border-color: #fff;
   }
   .expoler-item h3, .expoler-item p{ 
   color: #ffffff;
   font-size: 18px;
   font-weight: 300;
   margin-bottom: 5px;
   }
   .hr{
   border-color: #272c33;
   }
   ul.tabs{
   margin: 0px;
   padding: 0px;
   list-style: none;
   }
   ul.tabs li{
   background: #191c21;
   color: #fff;
   display: inline-block;
   padding: 12px 25px;
   cursor: pointer;
   border-radius: 10px 10px 0 0;
   font-size:18px;
   }
   ul.tabs li.current{
   background: #fff;
   color: #000;
   }
   .tab-content{
   display: none;
   animation: fadein .9s;
   background: #000;
   color:#fff;
   padding:20px 0;
   border-radius:5px;
   border-top: 1px solid #272c33;
   }
   @keyframes fadein {
    from {
        opacity:0;
        -webkit-transform: translateY(30px);
         -moz-transform: translateY(30px);
            -ms-transform: translateY(30px);
            -o-transform: translateY(30px);
               transform: translateY(30px);
    }
    to {
        opacity:1;
        -webkit-transform: translateY(0);
         -moz-transform: translateY(0);
            -ms-transform: translateY(0);
            -o-transform: translateY(0);
               transform: translateY(0);
    }
}
   .tab-content.current{
     display: inherit;
   }
   .custom-select{
   max-width: 300px;
   float: right;
   margin-bottom: 5px;
   color: #fff;
   background-color:#000;
   border: 1px solid #272c33;
   }
   .custom-selec option{
   background-color:#000;
   }
   
     .loading-section {
  position: fixed;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.98);
  z-index: 999;
   color: #fff;
}
/*====Start Line Pulse Out=======*/
.line-scale-pulse-out {
  position: fixed;
  top: 5%;
  left: 50%;
}

@-webkit-keyframes line-scale-pulse-out {
  0% {
    -webkit-transform: scaley(1);
            transform: scaley(1); }
  50% {
    -webkit-transform: scaley(0.4);
            transform: scaley(0.4); }
  100% {
    -webkit-transform: scaley(1);
            transform: scaley(1); } }

@keyframes line-scale-pulse-out {
  0% {
    -webkit-transform: scaley(1);
            transform: scaley(1); }
  50% {
    -webkit-transform: scaley(0.4);
            transform: scaley(0.4); }
  100% {
    -webkit-transform: scaley(1);
            transform: scaley(1); } }

.line-scale-pulse-out > div {
  background-color: #fff;
  width: 7px;
  height: 50px;
  border-radius: 2px;
  margin: 2px;
  -webkit-animation-fill-mode: both;
          animation-fill-mode: both;
  display: inline-block;
  -webkit-animation: line-scale-pulse-out 0.9s -0.6s infinite cubic-bezier(0.85, 0.25, 0.37, 0.85);
          animation: line-scale-pulse-out 0.9s -0.6s infinite cubic-bezier(0.85, 0.25, 0.37, 0.85); }
  .line-scale-pulse-out > div:nth-child(2), .line-scale-pulse-out > div:nth-child(4) {
    -webkit-animation-delay: -0.4s !important;
            animation-delay: -0.4s !important; }
  .line-scale-pulse-out > div:nth-child(1), .line-scale-pulse-out > div:nth-child(5) {
    -webkit-animation-delay: -0.2s !important;
            animation-delay: -0.2s !important; }

@-webkit-keyframes line-scale-pulse-out-rapid {
  0% {
    -webkit-transform: scaley(1);
            transform: scaley(1); }
  80% {
    -webkit-transform: scaley(0.3);
            transform: scaley(0.3); }
  90% {
    -webkit-transform: scaley(1);
            transform: scaley(1); } }

@keyframes line-scale-pulse-out-rapid {
  0% {
    -webkit-transform: scaley(1);
            transform: scaley(1); }
  80% {
    -webkit-transform: scaley(0.3);
            transform: scaley(0.3); }
  90% {
    -webkit-transform: scaley(1);
            transform: scaley(1); } }

.line-scale-pulse-out-rapid > div {
  background-color: #fff;
  width: 4px;
  height: 35px;
  border-radius: 2px;
  margin: 2px;
  -webkit-animation-fill-mode: both;
          animation-fill-mode: both;
  display: inline-block;
  vertical-align: middle;
  -webkit-animation: line-scale-pulse-out-rapid 0.9s -0.5s infinite cubic-bezier(0.11, 0.49, 0.38, 0.78);
          animation: line-scale-pulse-out-rapid 0.9s -0.5s infinite cubic-bezier(0.11, 0.49, 0.38, 0.78); }
  .line-scale-pulse-out-rapid > div:nth-child(2), .line-scale-pulse-out-rapid > div:nth-child(4) {
    -webkit-animation-delay: -0.25s !important;
            animation-delay: -0.25s !important; }
  .line-scale-pulse-out-rapid > div:nth-child(1), .line-scale-pulse-out-rapid > div:nth-child(5) {
    -webkit-animation-delay: 0s !important;
            animation-delay: 0s !important; }


/*===== End Line Pulse Out=====*/

/*==== Start Preloader-one ====*/
.preloader-one {
  position: relative;
  top: 30%;
  left: 50%;

}
.preloader-one span {
  position: absolute;
  display: block;
  bottom: 0;
  width: 9px;
  height: 5px;
  border-radius: 5px;
  background: #f1f1f1;
  -webkit-animation: preloader 2s infinite ease-in-out;
          animation: preloader 2s infinite ease-in-out;
}
.preloader-one span:nth-child(2) {
  left: 11px;
  -webkit-animation-delay: 200ms;
          animation-delay: 200ms;
}
.preloader-one span:nth-child(3) {
  left: 22px;
  -webkit-animation-delay: 400ms;
          animation-delay: 400ms;
}
.preloader-one span:nth-child(4) {
  left: 33px;
  -webkit-animation-delay: 600ms;
          animation-delay: 600ms;
}
.preloader-one span:nth-child(5) {
  left: 44px;
  -webkit-animation-delay: 800ms;
          animation-delay: 800ms;
}
.preloader-one span:nth-child(6) {
  left: 55px;
  -webkit-animation-delay: 1000ms;
          animation-delay: 1000ms;
}

@-webkit-keyframes preloader-one {
  0% {
    height: 5px;
    -webkit-transform: translateY(0);
            transform: translateY(0);
    background: #f1f1f1;
  }
  25% {
    height: 30px;
    -webkit-transform: translateY(15px);
            transform: translateY(15px);
    background: red;
  }
  50%,100% {
    height: 5px;
    -webkit-transform: translateY(0);
            transform: translateY(0);
    background: #f1f1f1;
  }
}

@keyframes preloader {
  0% {
    height: 5px;
    -webkit-transform: translateY(0);
            transform: translateY(0);
    background: #f1f1f1;
  }
  25% {
    height: 30px;
    -webkit-transform: translateY(15px);
            transform: translateY(15px);
    background: red;
  }
  50%,100% {
    height: 5px;
    -webkit-transform: translateY(0);
            transform: translateY(0);
    background: #f1f1f1;
  }
}
/*==== Start Preloader end ====*/


/*==== Start Preloader-two ====*/
.ajax-spinner-bars {
  position:fixed;
  width:35px;
  height:35px;
  left:52%;
  top:50%;
}
.ajax-spinner-bars > div {
	position: absolute;
	width: 2px;
	height: 8px;
	background-color: #fff;
	opacity: 0.05;
  animation: fadeit 0.8s linear infinite;
}
.ajax-spinner-bars > .bar-1 {
  transform: rotate(0deg) translate(0, -12px);
  animation-delay:0.05s;
}
.ajax-spinner-bars > .bar-2 {
  transform: rotate(22.5deg) translate(0, -12px);
  animation-delay:0.1s;
}
.ajax-spinner-bars > .bar-3 {
  transform: rotate(45deg) translate(0, -12px);
  animation-delay:0.15s;
}
.ajax-spinner-bars > .bar-4 {
  transform: rotate(67.5deg) translate(0, -12px);
  animation-delay:0.2s;
}
.ajax-spinner-bars > .bar-5 {
  transform: rotate(90deg) translate(0, -12px);
  animation-delay:0.25s;
}
.ajax-spinner-bars > .bar-6 {
  transform: rotate(112.5deg) translate(0, -12px);
  animation-delay:0.3s;
}
.ajax-spinner-bars > .bar-7 {
  transform: rotate(135deg) translate(0, -12px);
  animation-delay:0.35s;
}
.ajax-spinner-bars > .bar-8 {
  transform: rotate(157.5deg) translate(0, -12px);
  animation-delay:0.4s;
}
.ajax-spinner-bars > .bar-9 {
  transform: rotate(180deg) translate(0, -12px);
  animation-delay:0.45s;
}
.ajax-spinner-bars > .bar-10 {
  transform: rotate(202.5deg) translate(0, -12px);
  animation-delay:0.5s;
}
.ajax-spinner-bars > .bar-11 {
  transform: rotate(225deg) translate(0, -12px);
  animation-delay:0.55s;
}
.ajax-spinner-bars > .bar-12 {
  transform: rotate(247.5deg) translate(0, -12px);
  animation-delay:0.6s;
}
.ajax-spinner-bars> .bar-13 {
  transform: rotate(270deg) translate(0, -12px);
  animation-delay:0.65s;
}
.ajax-spinner-bars > .bar-14 {
  transform: rotate(292.5deg) translate(0, -12px);
  animation-delay:0.7s;
}
.ajax-spinner-bars > .bar-15 {
  transform: rotate(315deg) translate(0, -12px);
  animation-delay:0.75s;
}
.ajax-spinner-bars> .bar-16 {
  transform: rotate(337.5deg) translate(0, -12px);
  animation-delay:0.8s;
}
@keyframes fadeit{
	0%{ opacity:1; }
	100%{ opacity:0;}
}

/*==== End Preloader-two ====*/



/*===== Start Window Loader ======== */
@keyframes animation_bloc1 {
  0% {
    opacity: 0.1;
  }
  12.5% {
    opacity: 1;
  }
  25% {
    opacity: .1;
  }
  100% {
    opacity: 0.1;
  }
}
@-webkit-keyframes animation_bloc1 /*Safari and Chrome*/ {
  0% {
    opacity: 0.1;
  }
  12.5% {
    opacity: 1;
  }
  25% {
    opacity: .1;
  }
  100% {
    opacity: 0.1;
  }
}
@keyframes animation_bloc2 {
  0% {
    opacity: 0.1;
  }
  25% {
    opacity: 0.1;
  }
  37.5% {
    opacity: 1;
  }
  50% {
    opacity: .1;
  }
  100% {
    opacity: 0.1;
  }
}
@-webkit-keyframes animation_bloc2 /*Safari and Chrome*/ {
  0% {
    opacity: 0.1;
  }
  25% {
    opacity: 0.1;
  }
  37.5% {
    opacity: 1;
  }
  50% {
    opacity: .1;
  }
  100% {
    opacity: 0.1;
  }
}
@keyframes animation_bloc3 {
  0% {
    opacity: 0.1;
  }
  50% {
    opacity: 0.1;
  }
  62.5% {
    opacity: 1;
  }
  75% {
    opacity: .1;
  }
  100% {
    opacity: 0.1;
  }
}
@-webkit-keyframes animation_bloc3 /*Safari and Chrome*/ {
  0% {
    opacity: 0.1;
  }
  50% {
    opacity: 0.1;
  }
  62.5% {
    opacity: 1;
  }
  75% {
    opacity: .1;
  }
  100% {
    opacity: 0.1;
  }
}
@keyframes animation_bloc4 {
  0% {
    opacity: 0.1;
  }
  75% {
    opacity: 0.1;
  }
  87.5% {
    opacity: 1;
  }
  100% {
    opacity: 0.1;
  }
}
@-webkit-keyframes animation_bloc4 /*Safari and Chrome*/ {
  0% {
    opacity: 0.1;
  }
  75% {
    opacity: 0.1;
  }
  87.5% {
    opacity: 1;
  }
  100% {
    opacity: 0.1;
  }
}
.loader1 {
  position: absolute;
  top: 50px;
  left: 50px;
}

.bloc_general {
  background: #ecf0f1;
  width: 50px;
  height: 50px;
  position: absolute;
  opacity: 0.1;
}

.bloc1 {
  top: 0px;
  left: 0px;
  -webkit-animation: animation_bloc1 2.5s 0s infinite ease-in;
  animation: animation_bloc1 2.5s 0s infinite ease-in;
}

.bloc2 {
  top: 0px;
  left: 60px;
  -webkit-animation: animation_bloc2 2.5s 0s infinite ease-in;
  animation: animation_bloc2 2.5s 0s infinite ease-in;
}

.bloc3 {
  top: 60px;
  left: 60px;
  -webkit-animation: animation_bloc3 2.5s 0s infinite ease-in;
  animation: animation_bloc3 2.5s 0s infinite ease-in;
}

.bloc4 {
  top: 60px;
  left: 0px;
  -webkit-animation: animation_bloc4 2.5s 0s infinite ease-in;
  animation: animation_bloc4 2.5s 0s infinite ease-in;
}

/*FIN Loader 1 */
/*Debut loader 2 */
@-webkit-keyframes animation_rond1 /*Safari and Chrome*/ {
  0% {
    opacity: 0.1;
    -webkit-transform: rotate(0deg);
  }
  12.5% {
    opacity: 1;
    -webkit-transform: rotate(180deg);
  }
  25% {
    opacity: .1;
    -webkit-transform: rotate(360deg);
  }
  100% {
    opacity: 0.1;
    -webkit-transform: rotate(360deg);
  }
}
@keyframes animation_rond1 {
  0% {
    opacity: 0.1;
    transform: rotate(0deg);
  }
  12.5% {
    opacity: 1;
    transform: rotate(180deg);
  }
  25% {
    opacity: .1;
    transform: rotate(360deg);
  }
  100% {
    opacity: 0.1;
    transform: rotate(360deg);
  }
}
@-webkit-keyframes animation_rond2 /*Safari and Chrome*/ {
  0% {
    opacity: 0.1;
    -webkit-transform: rotate(0deg);
  }
  25% {
    opacity: 0.1;
    -webkit-transform: rotate(0deg);
  }
  37.5% {
    opacity: 1;
    -webkit-transform: rotate(180deg);
  }
  50% {
    opacity: .1;
    -webkit-transform: rotate(360deg);
  }
  100% {
    opacity: 0.1;
    -webkit-transform: rotate(360deg);
  }
}
@keyframes animation_rond2 {
  0% {
    opacity: 0.1;
    transform: rotate(0deg);
  }
  25% {
    opacity: 0.1;
    transform: rotate(0deg);
  }
  37.5% {
    opacity: 1;
    transform: rotate(180deg);
  }
  50% {
    opacity: .1;
    transform: rotate(360deg);
  }
  100% {
    opacity: 0.1;
    transform: rotate(360deg);
  }
}
@-webkit-keyframes animation_rond3 /*Safari and Chrome*/ {
  0% {
    opacity: 0.1;
    -webkit-transform: rotate(0deg);
  }
  50% {
    opacity: 0.1;
    -webkit-transform: rotate(0deg);
  }
  62.5% {
    opacity: 1;
    -webkit-transform: rotate(180deg);
  }
  75% {
    opacity: .1;
    -webkit-transform: rotate(360deg);
  }
  100% {
    opacity: 0.1;
    -webkit-transform: rotate(360deg);
  }
}
@keyframes animation_rond3 {
  0% {
    opacity: 0.1;
    transform: rotate(0deg);
  }
  50% {
    opacity: 0.1;
    transform: rotate(0deg);
  }
  62.5% {
    opacity: 1;
    transform: rotate(180deg);
  }
  75% {
    opacity: .1;
    transform: rotate(360deg);
  }
  100% {
    opacity: 0.1;
    transform: rotate(360deg);
  }
}
@-webkit-keyframes animation_rond4 /*Safari and Chrome*/ {
  0% {
    opacity: 0.1;
    -webkit-transform: rotate(0deg);
  }
  75% {
    opacity: 0.1;
    -webkit-transform: rotate(0deg);
  }
  87.5% {
    opacity: 1;
    -webkit-transform: rotate(180deg);
  }
  100% {
    opacity: 0.1;
    -webkit-transform: rotate(360deg);
  }
}
@keyframes animation_rond4 {
  0% {
    opacity: 0.1;
    transform: rotate(0deg);
  }
  75% {
    opacity: 0.1;
    transform: rotate(0deg);
  }
  87.5% {
    opacity: 1;
    transform: rotate(180deg);
  }
  100% {
    opacity: 0.1;
    transform: rotate(360deg);
  }
}
.loader2 {
  position: absolute;
  top: 50px;
  left: 500px;
}

.rond_general {
  background: #ecf0f1;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  position: absolute;
  opacity: 0.1;
  top: 25px;
  left: 25px;
}

.rond1 {
  -webkit-transform-origin: 0 0;
  transform-origin: 0 0;
  -webkit-animation: animation_rond1 2.5s 0s infinite linear;
  animation: animation_rond1 2.5s 0s infinite linear;
}

.rond2 {
  -webkit-transform-origin: 100% 0;
  transform-origin: 100% 0;
  -webkit-animation: animation_rond2 2.5s 0s infinite linear;
  animation: animation_rond2 2.5s 0s infinite linear;
}

.rond3 {
  -webkit-transform-origin: 100% 100%;
  transform-origin: 100% 100%;
  -webkit-animation: animation_rond3 2.5s 0s infinite linear;
  animation: animation_rond3 2.5s 0s infinite linear;
}

.rond4 {
  -webkit-transform-origin: 0 100%;
  transform-origin: 0 100%;
  -webkit-animation: animation_rond4 2.5s 0s infinite linear;
  animation: animation_rond4 2.5s 0s infinite linear;
}

/* Fin Loader 2 */
/*================end window loader====== */

</style>

<div class="explore-wrap">
	<div class="container">
		<div class="explor-boxes">
			<div class="row align-items-center">
				<div class="col-md-6">
				   
				    <ul class="tabs">
						
						<?php
						global $wp;
						$current_url =  home_url( $wp->request );
						$current_tab = substr($current_url, strrpos($current_url, '/') + 1);
						$current='';
						if(isset($current_tab) && $current_tab =='giftaclass'){$current = $current_tab; } 
						?>	
            <h3 style="color: #ffffff; margin: 0!important;">On-demand Classes</h3>
						<li class="tab-link <?php if(!$current){echo 'current';} ?>" id="tab-odc" data-tab="tab-1" style="display: none;">On-demand Classes</li>
						
				    </ul>
				</div>
				<div class="col-md-3 text-right pr-0">Filter Class List</div>
				<div class="col-md-3">
					
					<?php 
					$all_cats = get_terms( ['taxonomy' => 'product_cat', 'hide_empty' => true] );	  
					?>

					<!-- ************************** FILTER DROPDOWN ************************* -->

					<form action="" method="POST">
						<select class="custom-select" name="category">
							<option value="">All Classes</option>
							<?php
							foreach ( $all_cats as $cat ) { ?>
								<option value="<?php echo $cat->slug; ?>" ><?php echo $cat->name; ?></option>
							<?php } ?>
						</select>
					</form>
				   
				   <!-- ************************** FILTER DROPDOWN END ************************* -->
				   
				</div>
			</div>
		 

		 
			<div id="tab-1" class="tab-content <?php if(!$current){echo 'current';} ?>">
			
				<p style="visibility: hidden;"><strong><?php the_field('video_on-demand_classes_title'); ?></strong></p>
				<p><?php the_field('video_on-demand_classes_text'); ?></p><br>
            
				<!-- ==== Start Preloader-one ==== -->
				<div class='preloader-one loadingDiv' id="loadingDiv">
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
				</div>
				<!-- ==== End Preloader-one ==== -->
				
				<div class="row" id="onDemandRow">
				
					<?php
					
						$query = new WC_Product_Query( array(
							'limit' => -1,
							'orderby' => 'date',
							'order' => 'ASC',
              'status' => 'publish'
						));
						
						$products = $query->get_products();
						foreach($products as $product){
							$product_id   	=   $product->get_id();
							$product_name   =   $product->get_name();
							$product_price  =   $product->get_price();
							$product_price_with_symbol = wc_price( $product_price, $args );
							$product_url    =   get_permalink( $product->get_id() );
							$categories 			= $product->get_categories();
							
							if(!$categories){
								continue;	
							}
							
							
					?>
					
						<div class="col-md-3" id="onDemandClass-<?php echo $product_id;?>" data-price_with_symbol="<?php echo strip_tags($product_price_with_symbol);?>" >
							<a href="<?php echo $product_url; ?>" class="expoler-item">
								<h3><?php echo $product_name; ?></h3>
								<p><strong><?php echo $product->get_price_html(); ?></strong></p>
							</a>
						</div>

					<?php	
						}
					?>
				
				</div>
			</div>
        	
		</div>
	</div>
</div>


<?php get_footer(); ?>



<script>
	// script moved in footer
	/*jQuery(document).ready(function(){
		jQuery('ul.tabs li').click(function(){
			var tab_id = jQuery(this).attr('data-tab');
	   
			jQuery('ul.tabs li').removeClass('current');
			jQuery('.tab-content').removeClass('current');
	   
			jQuery(this).addClass('current');
			jQuery("#"+tab_id).addClass('current');
			setGTMRecords();
		})   
   })*/
   
	function getProductsData(currentTab,catSlug){
	   
		var data = {
			'action': 'getProductsData',
			'catSlug': catSlug,
		};
		
		var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
		jQuery.post(ajaxurl, data, function (response) {
			
			producsData = JSON.parse(response);
			
			if(currentTab == 'ondemand'){
				
				for (let i = 0; i < producsData.length; i++){
					
					jQuery('#onDemandRow').append('<div class="col-md-3" id="onDemandClass-'+producsData[i].product_id+'"><a href="'+producsData[i].product_url+'" class="expoler-item"><h3>'+producsData[i].product_name+'</h3><p> <strong>'+producsData[i].product_price+'</strong></p></a></div>');	
				}	
			}
		});
	}
   
	jQuery(document).ready(function(){
	   
	   // ajax loader
		var $loading = jQuery('.loadingDiv').hide();
		jQuery(document)
        .ajaxStart(function () {
            $loading.show();
        })
        .ajaxStop(function () {
            $loading.hide();
        });
	   
		jQuery('.custom-select').change(function() {
			
			jQuery("#giftRow div.col-md-3").remove();
			jQuery("#onDemandRow div.col-md-3").remove();
			
			var catSlug = this.value;
			getProductsData(currentTab='ondemand',catSlug);
		});   
   });
</script>