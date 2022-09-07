<?php
if ( !defined('ABSPATH') ) {
    /** Set up WordPress environment */
    require_once("../../../wp-load.php");
}

add_action('admin_init','enqueue_admin_scripts');
function enqueue_admin_scripts(){
        wp_enqueue_style('bootstrap-css' , get_template_directory_uri() . '/css/bootstrap.css' );
        wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js' ,false, NULL, true );
    }
?>

<?php
$user_template_data = get_option('gift_card_user_email_temp');
$admin_template_data = get_option('gift_card_admin_email_temp');
$super_admin_template_data = get_option('gift_card_super_admin_email_temp');

//var_dump($user_template_data);

?>
<div class="container-fluid">
    <h2>Gift Card Email Templates</h2>

    <div  id="message" style="margin-bottom: 8px; color: #0a55a0; font-weight: bolder; font-size: 20px;" class="text-center"></div>

    <div class="form-group">
        <select id="e_templates" name="e_templates">
            <option value="">-- Select Template --</option>
            <option value="user">Receiver Email Template</option>
            <option value="admin">Sender Email Template</option>
            <option value="super_admin">Admin Email Template</option>
        </select>
    </div>


    <div class="row">
        <div class="col-md-12">

            <form id="user_template_form_test" class="form-inline text-center" action="/action_page.php">
                <div class="form-group">
                    <label for="email">Send a test email to:</label>
                    <input type="email" name="test_mail" class="form-control" id="user_test_email" required>
                </div>
                <button id="submit_user_test_email" class="btn btn-primary"> Send Email </button>
            </form>

            <form id="user_template_form">
                <div class="form-group">
                    <label for="user_email_subject">Subject</label>
                    <input type="text" name="user_email_subject" value="<?php if ($user_template_data){echo $user_template_data[0];} ?>" class="form-control" id="user_email_subject" required/>
                </div>
                <div class="form-group">
                    <label for="user_email_body">Body</label>
                    <textarea class="form-control" id="user_email_body" rows="15" required><?php if ($user_template_data){echo $user_template_data[1];} ?></textarea>
                </div>
                <button id="submit_user_temp" class="btn btn-primary"> Update </button>

                <table class="form-table">
                    <tr>
                        <th scope="row" valign="top"></th>
                        <td>
                            <h3><?php _e('Variable Reference', 'pmproet');?></h3>

                            <div id="template_reference" style="overflow:scroll;height:250px;width:800px;;">
                                <table class="widefat striped">

                                    <tr>
                                        <td>!!to_name!!</td>
                                        <td><?php _e('Gift Receiver Name', 'pmproet');?></td>
                                    </tr>
                                    <tr>
                                        <td>!!to_email!!</td>
                                        <td><?php _e('Gift Receiver Email', 'pmproet');?></td>
                                    </tr>
                                    <tr>
                                        <td>!!from_name!!</td>
                                        <td><?php _e('Gift Sender Name', 'pmproet');?></td>
                                    </tr>
                                    <tr>
                                        <td>!!from_email!!</td>
                                        <td><?php _e('Gift Sender Email', 'pmproet');?></td>
                                    </tr>
                                    <tr>
                                        <td>!!level_name!!</td>
                                        <td><?php _e('Gift Level Name', 'pmproet');?></td>
                                    </tr>
                                    <tr>
                                        <td>!!gift_messsage!!</td>
                                        <td><?php _e('Gift Message', 'pmproet');?></td>
                                    </tr>
                                    <tr>
                                        <td>!!access_url!!</td>
                                        <td><?php _e('Access URL', 'pmproet');?></td>
                                    </tr>
                                    <tr>
                                        <td>!!transaction_amount!!</td>
                                        <td><?php _e('Transaction Amount', 'pmproet');?></td>
                                    </tr>
                                    <tr>
                                        <td>!!invoice_number!!</td>
                                        <td><?php _e('Invoice Number', 'pmproet');?></td>
                                    </tr>
                                    <tr>
                                        <td>!!discount_code!!</td>
                                        <td><?php _e('Discount Code', 'pmproet');?></td>
                                    </tr>

                                </table>
                            </div>
                        </td>
                    </tr>
                </table>

            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <form id="admin_template_form_test" class="form-inline text-center" action="/action_page.php">
                <div class="form-group">
                    <label for="email">Send a test email to:</label>
                    <input type="email" name="test_mail" class="form-control" id="admin_test_email" required>
                </div>
                <button id="submit_admin_test_email" class="btn btn-primary"> Send Email </button>
            </form>

            <form id="admin_template_form">
                <div class="form-group">
                    <label for="admin_email_subject">Subject</label>
                    <input type="text" name="admin_email_subject" value="<?php if ($admin_template_data){echo $admin_template_data[0];} ?>" class="form-control" id="admin_email_subject" required/>
                </div>
                <div class="form-group">
                    <label for="admin_email_body">Body</label>
                    <textarea class="form-control" id="admin_email_body" rows="15" required><?php if ($admin_template_data){echo $admin_template_data[1];} ?></textarea>
                </div>
                <button id="submit_admin_temp" class="btn btn-primary"> Update </button>

                <table class="form-table">
                    <tr>
                        <th scope="row" valign="top"></th>
                        <td>
                            <h3><?php _e('Variable Reference', 'pmproet');?></h3>

                            <div id="template_reference" style="overflow:scroll;height:250px;width:800px;;">
                                <table class="widefat striped">

                                    <tr>
                                        <td>!!to_name!!</td>
                                        <td><?php _e('Gift Receiver Name', 'pmproet');?></td>
                                    </tr>
                                    <tr>
                                        <td>!!to_email!!</td>
                                        <td><?php _e('Gift Receiver Email', 'pmproet');?></td>
                                    </tr>
                                    <tr>
                                        <td>!!from_name!!</td>
                                        <td><?php _e('Gift Sender Name', 'pmproet');?></td>
                                    </tr>
                                    <tr>
                                        <td>!!from_email!!</td>
                                        <td><?php _e('Gift Sender Email', 'pmproet');?></td>
                                    </tr>
                                    <tr>
                                        <td>!!level_name!!</td>
                                        <td><?php _e('Gift Level Name', 'pmproet');?></td>
                                    </tr>
                                    <tr>
                                        <td>!!gift_messsage!!</td>
                                        <td><?php _e('Gift Message', 'pmproet');?></td>
                                    </tr>
                                    <tr>
                                        <td>!!access_url!!</td>
                                        <td><?php _e('Access URL', 'pmproet');?></td>
                                    </tr>
                                    <tr>
                                        <td>!!transaction_amount!!</td>
                                        <td><?php _e('Transaction Amount', 'pmproet');?></td>
                                    </tr>
                                    <tr>
                                        <td>!!invoice_number!!</td>
                                        <td><?php _e('Invoice Number', 'pmproet');?></td>
                                    </tr>
                                    <tr>
                                        <td>!!discount_code!!</td>
                                        <td><?php _e('Discount Code', 'pmproet');?></td>
                                    </tr>

                                </table>
                            </div>
                        </td>
                    </tr>
                </table>

            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <form id="super_admin_template_form_test" class="form-inline text-center" action="/action_page.php">
                <div class="form-group">
                    <label for="email">Send a test email to:</label>
                    <input type="email" name="test_mail" class="form-control" id="super_admin_test_email" required>
                </div>
                <button id="submit_super_admin_test_email" class="btn btn-primary"> Send Email </button>
            </form>

            <form id="super_admin_template_form">
                <div class="form-group">
                    <label for="super_admin_email_subject">Subject</label>
                    <input type="text" name="super_admin_email_subject" value="<?php if ($super_admin_template_data){echo $super_admin_template_data[0];} ?>" class="form-control" id="super_admin_email_subject" required/>
                </div>
                <div class="form-group">
                    <label for="super_admin_email_body">Body</label>
                    <textarea class="form-control" id="super_admin_email_body" rows="15" required><?php if ($super_admin_template_data){echo $super_admin_template_data[1];} ?></textarea>
                </div>
                <button id="submit_super_admin_temp" class="btn btn-primary"> Update </button>

                <table class="form-table">
                    <tr>
                        <th scope="row" valign="top"></th>
                        <td>
                            <h3><?php _e('Variable Reference', 'pmproet');?></h3>

                            <div id="template_reference" style="overflow:scroll;height:250px;width:800px;;">
                                <table class="widefat striped">

                                    <tr>
                                        <td>!!to_name!!</td>
                                        <td><?php _e('Gift Receiver Name', 'pmproet');?></td>
                                    </tr>
                                    <tr>
                                        <td>!!to_email!!</td>
                                        <td><?php _e('Gift Receiver Email', 'pmproet');?></td>
                                    </tr>
                                    <tr>
                                        <td>!!from_name!!</td>
                                        <td><?php _e('Gift Sender Name', 'pmproet');?></td>
                                    </tr>
                                    <tr>
                                        <td>!!from_email!!</td>
                                        <td><?php _e('Gift Sender Email', 'pmproet');?></td>
                                    </tr>
                                    <tr>
                                        <td>!!level_name!!</td>
                                        <td><?php _e('Gift Level Name', 'pmproet');?></td>
                                    </tr>
                                    <tr>
                                        <td>!!gift_messsage!!</td>
                                        <td><?php _e('Gift Message', 'pmproet');?></td>
                                    </tr>
                                    <tr>
                                        <td>!!access_url!!</td>
                                        <td><?php _e('Access URL', 'pmproet');?></td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>

            </form>
        </div>
    </div>

</div>

<script>
    jQuery(document).ready(function(){
        jQuery("form").hide();

        jQuery('#submit_user_temp').on( 'click', function (e){

            jQuery('#message').text('');

            var subject = jQuery('#user_email_subject').val();
            var body = jQuery('#user_email_body').val();

            if (subject !== '' && body !== ''){
                e.preventDefault();
                var data = {
                    'action': 'update_gift_card_email_template',
                    'subject': subject,
                    'body': body,
                    'template': 'gift_card_user_email_temp',
                };
                var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
                jQuery.post(ajaxurl, data, function (response) {
                    if (response){
                        jQuery('#message').text('Email template has been updated');
                        jQuery('#message').fadeIn('slow');
                        setTimeout(function() {
                            jQuery('#message').fadeOut('slow');
                        }, 5000); // <-- time in milliseconds
                    }
                });
            }



        });

        jQuery('#submit_admin_temp').on( 'click', function (e){

            jQuery('#message').text('');

            var subject = jQuery('#admin_email_subject').val();
            var body = jQuery('#admin_email_body').val();

            if (subject !== '' && body !== ''){
                e.preventDefault();
                var data = {
                    'action': 'update_gift_card_email_template',
                    'subject': subject,
                    'body': body,
                    'template': 'gift_card_admin_email_temp',
                };
                var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
                jQuery.post(ajaxurl, data, function (response) {
                    if (response){
                        jQuery('#message').text('Email template has been updated');
                        jQuery('#message').fadeIn('slow');
                        setTimeout(function() {
                            jQuery('#message').fadeOut('slow');
                        }, 5000); // <-- time in milliseconds
                    }
                });
            }

        });

        jQuery('#submit_super_admin_temp').on( 'click', function (e){

            jQuery('#message').text('');

            var subject = jQuery('#super_admin_email_subject').val();
            var body = jQuery('#super_admin_email_body').val();

            if (subject !== '' && body !== ''){
                e.preventDefault();
                var data = {
                    'action': 'update_gift_card_email_template',
                    'subject': subject,
                    'body': body,
                    'template': 'gift_card_super_admin_email_temp',
                };
                var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
                jQuery.post(ajaxurl, data, function (response) {
                    if (response){
                        jQuery('#message').text('Email template has been updated');
                        jQuery('#message').fadeIn('slow');
                        setTimeout(function() {
                            jQuery('#message').fadeOut('slow');
                        }, 5000); // <-- time in milliseconds
                    }
                });
            }

        });

        // test email sending
        jQuery('#submit_user_test_email').on( 'click', function (e){

            jQuery('#message').text('');

            var to_email = jQuery('#user_test_email').val();
            var subject = jQuery('#user_email_subject').val();
            var body = jQuery('#user_email_body').val();

            if (to_email !== '' && subject !== '' && body !== ''){
                e.preventDefault();
                var data = {
                    'action': 'send_test_gift_card_email',
                    'to': to_email,
                    'subject': subject,
                    'body': body,
                };
                var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
                jQuery.post(ajaxurl, data, function (response) {
                    if (response){
                        jQuery('#message').text('Test email has been sent');
                        jQuery('#message').fadeIn('slow');
                        setTimeout(function() {
                            jQuery('#message').fadeOut('slow');
                        }, 5000); // <-- time in milliseconds
                    }
                });
            }
        });

        jQuery('#submit_admin_test_email').on( 'click', function (e){

            jQuery('#message').text('');

            var to_email = jQuery('#admin_test_email').val();
            var subject = jQuery('#admin_email_subject').val();
            var body = jQuery('#admin_email_body').val();

            if (to_email !== '' && subject !== '' && body !== ''){
                e.preventDefault();
                var data = {
                    'action': 'send_test_gift_card_email',
                    'to': to_email,
                    'subject': subject,
                    'body': body,
                };
                var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
                jQuery.post(ajaxurl, data, function (response) {
                    if (response){
                        jQuery('#message').text('Test email has been sent');
                        jQuery('#message').fadeIn('slow');
                        setTimeout(function() {
                            jQuery('#message').fadeOut('slow');
                        }, 5000); // <-- time in milliseconds
                    }
                });
            }
        });

        jQuery('#submit_super_admin_test_email').on( 'click', function (e){

            jQuery('#message').text('');

            var to_email = jQuery('#super_admin_test_email').val();
            var subject = jQuery('#super_admin_email_subject').val();
            var body = jQuery('#super_admin_email_body').val();

            if (to_email !== '' && subject !== '' && body !== ''){
                e.preventDefault();
                var data = {
                    'action': 'send_test_gift_card_email',
                    'to': to_email,
                    'subject': subject,
                    'body': body,
                };
                var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
                jQuery.post(ajaxurl, data, function (response) {
                    if (response){
                        jQuery('#message').text('Test email has been sent');
                        jQuery('#message').fadeIn('slow');
                        setTimeout(function() {
                            jQuery('#message').fadeOut('slow');
                        }, 5000); // <-- time in milliseconds
                    }
                });
            }
        });

    });

    jQuery("#e_templates").change(function(){
        stateChange(jQuery(this).val());
    });

    function stateChange(stateValue){
        jQuery("form").hide();
        if (stateValue == "super_admin"){
            jQuery("#super_admin_template_form").show();
            jQuery("#super_admin_template_form_test").show();
            jQuery("#admin_template_form").hide();
            jQuery("#admin_template_form_test").hide();
            jQuery("#user_template_form").hide();
            jQuery("#user_template_form_test").hide();
        }

        if (stateValue == "admin"){
            jQuery("#admin_template_form").show();
            jQuery("#admin_template_form_test").show();
            jQuery("#super_admin_template_form").hide();
            jQuery("#super_admin_template_form_test").hide();
            jQuery("#user_template_form").hide();
            jQuery("#user_template_form_test").hide();
        }

        if (stateValue == "user"){
            jQuery("#user_template_form").show();
            jQuery("#user_template_form_test").show();
            jQuery("#super_admin_template_form").hide();
            jQuery("#super_admin_template_form_test").hide();
            jQuery("#admin_template_form").hide();
            jQuery("#admin_template_form_test").hide();
        }
    }
</script>