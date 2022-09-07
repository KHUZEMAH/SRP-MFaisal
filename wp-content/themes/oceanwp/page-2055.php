<?php get_header();

// if ( !is_user_logged_in() ) {
//     wp_redirect( get_permalink( 1854 ) );
// }
?>
<section class="add-testimonail">
  <div class="container">
    <div>
          <br>
          <?php if( "yes" == $_GET['success'] ){ //if(isset($_SESSION["successtestimonialMsg"]) && $_SESSION["successtestimonialMsg"]!=''){?>
          <div class="alert-success-text" role="alert">
              <strong>Thank you for your review. We are glad that you had a great experience with us!</strong>
              <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button> -->
          </div>
        <?php }
        //unset ($_SESSION["successtestimonialMsg"]);
        //if ( is_user_logged_in() ) {
        ?>
        <form id="testnomial-form" method="POST">
          <?php if ( !is_user_logged_in() ) { ?>
            <input type="text" placeholder="First Name*" name="first_name" id="first_name" required="required"><br><br>
            <input type="text" placeholder="Last Name*" name="last_name" id="last_name" required="required"><br><br>
          <?php }?>
          <textarea placeholder="Your Testimonial*" name="testimonial" id="testimonial" required="required"></textarea>
            <?php if ( !is_user_logged_in() ) { ?>
          <p>Thank you for your support. While we require your first and last names to be entered for security reasons, we want you to know that we respect your privacy and anonymity so only your first name will be used if this testimonial is posted publicly.</p>
          <?php }?>
          <input id="testnomial-submit" class="btn-white" type="submit" value="Add Testimonial">
          <a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>" class="btn-white">View Your Membership Account</a>
          <input type="hidden" name="action" value="save">
          <input type="hidden" name="post_type" value="testimonial">
        </form>

      <?php //}else{ ?>
        <!-- <p style="text-align: center; margin:20px">You must be logged-in to add testimonial.</p> -->
      <?php //} ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>
<script>
  jQuery(document).ready(function(){
    setTimeout(function(){jQuery('.alert-success-text').hide(); }, 4000);
  })
</script>