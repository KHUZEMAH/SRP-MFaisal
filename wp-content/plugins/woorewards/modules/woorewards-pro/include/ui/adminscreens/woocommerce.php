<?php
namespace LWS\WOOREWARDS\PRO\Ui\AdminScreens;
// don't call the file directly
if (!defined('ABSPATH')) exit();

class WooCommerce
{
	static function getTab(&$page)
	{
		$legacy = \LWS\WOOREWARDS\Conveniences::instance()->isLegacyShown('4.7.0');
		$tab = array(
			'id'	=> 'wc_settings',
			'title'	=>  __("WooCommerce", 'woorewards-pro'),
			'icon'	=> 'lws-icon-cart-2',
			'vertnav' => true,
			'groups' => array(
				'myaccountlrview'           => self::getGroupMyAccountLoyalty($legacy),
				'cart'                      => $page['tabs']['woocommerce']['groups']['cart'],
				'checkout'                  => $page['tabs']['woocommerce']['groups']['checkout'],
				'productpointspreview'      => self::getGroupProductPointsPreview(),
				'shoppointspreview'         => self::getGroupShopPointsPreview(),
				'orderpoints'               => self::getGroupOrderPoints(),
				'myaccountbadgesview'       => self::getGroupMyAccountBadges($legacy),
				'myaccountachievementsview' => self::getGroupMyAccountAchievements($legacy),
			),
		);
		return $tab;
	}

	/** @see getGroupMyAccountLoyalty  legacy mode*/
	protected static function getLoyaltyLegacyFields()
	{
		return array(
			array(
				'id'    => 'lws_woorewards_wc_my_account_mode',
				'title' => __("Display Mode", 'woorewards-pro'),
				'type'  => 'box',
				'extra' => array(
					'class'   => 'lws_switch',
					'id'      => 'lws_woorewards_wc_my_account_mode',
					'default' => 'on',
					'data'    => array(
						'left'       => __("Custom Page", 'woorewards-pro'),
						'right'      => __("Prebuilt Page", 'woorewards-pro'),
						'colorleft'  => '#425981',
						'colorright' => '#5279b1',
					),
				)
			),
			array(
				'id'    => 'lws_woorewards_wc_my_account_endpont_loyalty',
				'title' => __("Display the Loyalty and Rewards tab.", 'woorewards-pro'),
				'type'  => 'box',
				'extra' => array(
					'class'   => 'lws_checkbox',
					'default' => 'on'
				),
				'require' => array('selector' => '#lws_woorewards_wc_my_account_mode', 'value' => 'on')
			),
			array(
				'id'    => 'lws_woorewards_wc_my_account_lar_label',
				'title' => __("Loyalty and Rewards Tab Title", 'woorewards-pro'),
				'type'  => 'text',
				'extra' => array(
					'size'        => '50',
					'placeholder' => __('Loyalty and Rewards', 'woorewards-pro'),
					'wpml'        => "WooRewards - My Account - Loyalty and Rewards Tab Title",
				),
				'require' => array('selector' => '#lws_woorewards_wc_my_account_mode', 'value' => 'on')
			),
			array(
				'id'    => 'lws_woorewards_wc_my_account_endpoint_slug',
				'title' => __("Endpoint Slug", 'woorewards-pro'),
				'type'  => 'text',
				'extra' => array(
					'size'        => '50',
					'placeholder' => 'lws_woorewards',
				),
				'require' => array('selector' => '#lws_woorewards_wc_my_account_mode', 'value' => 'on')
			),
			array(
				'id'    => 'lws_woorewards_wc_my_account_lar_options',
				'title' => __("Elements to display", 'woorewards-pro'),
				'type'  => 'checkgrid', // radiogrid is specific to the wizard
				'extra' => array(
					'source' => array(
						array('value' => 'coupons', 'active' => 'yes', 'label' => __("Available Coupons", 'woorewards-pro')),
						array('value' => 'rewards', 'active' => 'yes', 'label' => __("Unlockable Rewards", 'woorewards-pro')),
						array('value' => 'systems', 'active' => 'yes', 'label' => __("Points and rewards systems Details", 'woorewards-pro')),
						array('value' => 'history', 'active' => 'yes', 'label' => __("Customer Points History", 'woorewards-pro')),
						array('value' => 'sponsoremail', 'active' => '', 'label' => __("Sponsorship Mailing", 'woorewards-pro')),
						array('value' => 'sponsorlink', 'active' => '', 'label' => __("Referral Link", 'woorewards-pro')),
					),
					'dragndrop' => 'yes',
					'help' => sprintf('%s<br/><strong>%s</strong>',
						__("Select the elements you want to display on the loyalty and rewards tab.", 'woorewards-pro'),
						__("You can rearrange the elements in the order you want by using drag and drop.", 'woorewards-pro')
					),
				),
				'require' => array('selector' => '#lws_woorewards_wc_my_account_mode', 'value' => 'on')
			),
			array(
				'id'    => 'lws_woorewards_wc_my_account_systems_list',
				'title' => __("Points and rewards systems", 'woorewards-pro'),
				'type'  => 'lacchecklist',
				'extra' => array(
					'ajax' => 'lws_woorewards_pool_list',
					'help' => __("Select the points and rewards systems you want to display", 'woorewards-pro'),
				),
				'require' => array('selector' => '#lws_woorewards_wc_my_account_mode', 'value' => 'on')
			),
			'expanded_display' => array(
				'id'    => 'lws_woorewards_wc_myaccount_expanded',
				'title' => __("Expanded display", 'woorewards-pro'),
				'type'  => 'box',
				'extra' => array(
					'class' => 'lws_checkbox',
					'help'  => __("Disables the accordion feature on the endpoint and expands all sections", 'woorewards-pro'),
				),
				'require' => array('selector' => '#lws_woorewards_wc_my_account_mode', 'value' => 'on')
			),
			'leveling_bar' => array(
				'id'    => 'lws_woorewards_wc_myaccount_levelbars',
				'title' => __("Leveling Progress Bar", 'woorewards-pro'),
				'type'  => 'box',
				'extra' => array(
					'class' => 'lws_checkbox',
					'help'  => __("Displays a 'Current Progress' bar for leveling systems", 'woorewards-pro'),
				),
				'require' => array('selector' => '#lws_woorewards_wc_my_account_mode', 'value' => 'on')
			),
			array(
				'id'    => 'lws_wre_myaccount_lar_view',
				'type'  => 'themer',
				'extra' => array(
					'template' => 'wc_loyalty_and_rewards',
					'css'      => LWS_WOOREWARDS_PRO_CSS . '/loyalty-and-rewards.css',
					'prefix'   => '--wr-lar-'
				),
				'require' => array('selector' => '#lws_woorewards_wc_my_account_mode', 'value' => 'on')
			)
		);
	}

	/** @see getGroupMyAccountBadges legacy mode */
	protected static function getBadgesLegacyFields()
	{
		return array(
			array(
				'id'    => 'lws_woorewards_wc_badges_account_mode',
				'title' => __("Display Mode", 'woorewards-pro'),
				'type'  => 'box',
				'extra' => array(
					'class'   => 'lws_switch',
					'id'      => 'lws_woorewards_wc_badges_account_mode',
					'default' => 'on',
					'data'    => array(
						'left'       => __("Custom Page", 'woorewards-pro'),
						'right'      => __("Prebuilt Page", 'woorewards-pro'),
						'colorleft'  => '#425981',
						'colorright' => '#5279b1',
					),
				)
			),
			array(
				'id'    => 'lws_woorewards_wc_my_account_endpoint_badges',
				'title' => __("Display the Badges tab.", 'woorewards-pro'),
				'type'  => 'box',
				'extra' => array(
					'class'   => 'lws_checkbox',
					'default' => 'on'
				),
				'require' => array(
					'selector' => '#lws_woorewards_wc_badges_account_mode', 'value' => 'on'
				)
			),
			array(
				'id'    => 'lws_woorewards_wc_my_account_badges_label',
				'title' => __("Badges Tab Title", 'woorewards-pro'),
				'type'  => 'text',
				'extra' => array(
					'size'        => '50',
					'placeholder' => __('My Badges', 'woorewards-pro'),
					'wpml'        => "WooRewards - My Account - Badges Tab Title",
				),
				'require' => array(
					'selector' => '#lws_woorewards_wc_badges_account_mode', 'value' => 'on'
				)

			),
			array(
				'id'    => 'lws_woorewards_wc_badges_endpoint_slug',
				'title' => __("Endpoint Slug", 'woorewards-pro'),
				'type'  => 'text',
				'extra' => array(
					'size'        => '50',
					'placeholder' => 'lws_badges',
				),
				'require' => array(
					'selector' => '#lws_woorewards_wc_badges_account_mode', 'value' => 'on'
				)
			),
			array(
				'id'    => 'lws_wre_myaccount_badges_view',
				'type'  => 'themer',
				'extra' => array(
					'template' => 'wc_badges_endpoint',
					'css'      => LWS_WOOREWARDS_PRO_CSS . '/badges-endpoint.css',
					'prefix'   => '--wr-badges-'
				),
				'require' => array(
					'selector' => '#lws_woorewards_wc_badges_account_mode', 'value' => 'on'
				)
			)
		);
	}

	/** @see getGroupMyAccountAchievements legacy mode */
	protected static function getAchievementsLegacyFields()
	{
		return array(
			array(
				'id'    => 'lws_woorewards_wc_achievements_account_mode',
				'title' => __("Display Mode", 'woorewards-pro'),
				'type'  => 'box',
				'extra' => array(
					'class'   => 'lws_switch',
					'id'      => 'lws_woorewards_wc_achievements_account_mode',
					'default' => 'on',
					'data'    => array(
						'left'       => __("Custom Page", 'woorewards-pro'),
						'right'      => __("Prebuilt Page", 'woorewards-pro'),
						'colorleft'  => '#425981',
						'colorright' => '#5279b1',
					),
				),
			),
			array(
				'id'    => 'lws_woorewards_wc_my_account_endpoint_achievements',
				'title' => __("Display the Achievements tab.", 'woorewards-pro'),
				'type'  => 'box',
				'extra' => array(
					'class'   => 'lws_checkbox',
					'default' => 'on'
				),
				'require' => array(
					'selector' => '#lws_woorewards_wc_achievements_account_mode', 'value' => 'on'
				)
			),
			array(
				'id'    => 'lws_woorewards_wc_my_account_achievements_label',
				'title' => __("Achievements Tab Title", 'woorewards-pro'),
				'type'  => 'text',
				'extra' => array(
					'size'        => '50',
					'placeholder' => __('Achievements', 'woorewards-pro'),
					'wpml'        => "WooRewards - My Account - Achievements Tab Title",
				),
				'require' => array(
					'selector' => '#lws_woorewards_wc_achievements_account_mode', 'value' => 'on'
				)
			),
			array(
				'id'    => 'lws_woorewards_wc_achievements_endpoint_slug',
				'title' => __("Endpoint Slug", 'woorewards-pro'),
				'type'  => 'text',
				'extra' => array(
					'size'        => '50',
					'placeholder' => 'lws_achievements',
				),
				'require' => array(
					'selector' => '#lws_woorewards_wc_achievements_account_mode', 'value' => 'on'
				)
			),
			array(
				'id'    => 'lws_wre_myaccount_achievements_view',
				'type'  => 'themer',
				'extra' => array(
					'template' => 'wc_achievements_endpoint',
					'css'      => LWS_WOOREWARDS_PRO_CSS . '/achievements-endpoint.css',
					'prefix'   => '--wr-achievements-'
				),
				'require' => array(
					'selector' => '#lws_woorewards_wc_achievements_account_mode', 'value' => 'on'
				)
			)
		);
	}

	protected static function getGroupMyAccountLoyalty($legacy)
	{
		$group = array(
			'id'     => 'myaccountlarview',
			'icon'   => 'lws-icon-users',
			'title'  => __("My Account - Loyalty", 'woorewards-pro'),
			'text'   => __("Show to the customer all loyalty and rewards information in a dedicated 'Loyalty and Rewards' Tab inside WooCommerce's My Account.", 'woorewards-pro'),
			'extra'  => array('doclink' => 'https://plugins.longwatchstudio.com/docs/woorewards-4/woocommerce-integration/my-account/'),
			'fields' => array(),
		);

		if ($legacy) {
			$group['fields'] = self::getLoyaltyLegacyFields();
			foreach (\LWS\WOOREWARDS\PRO\Ui\Endpoints\Loyalty::getAdminFields() as $index => $field) {
				$field['require'] = array('selector' => '#lws_woorewards_wc_my_account_mode', 'value' => '');
				$group['fields'][$index] = $field;
			}
		} else {
			$group['fields'] = \LWS\WOOREWARDS\PRO\Ui\Endpoints\Loyalty::getAdminFields();
		}
		return $group;
	}

	protected static function getGroupMyAccountBadges($legacy)
	{
		$group = array(
			'id' => 'myaccountbadgesview',
			'icon'	=> 'lws-icon-cockade',
			'title' => __("My Account - Badges", 'woorewards-pro'),
			'text' => __("Show to the customer all badges he owns in a 'Badges' Tab inside WooCommerce's My Account.", 'woorewards-pro'),
			'extra'    => array('doclink' => 'https://plugins.longwatchstudio.com/docs/woorewards-4/woocommerce-integration/my-account/'),
		);

		if ($legacy) {
			$group['fields'] = self::getBadgesLegacyFields();
			foreach (\LWS\WOOREWARDS\PRO\Ui\Endpoints\Badges::getAdminFields() as $index => $field) {
				$field['require'] = array('selector' => '#lws_woorewards_wc_badges_account_mode', 'value' => '');
				$group['fields'][$index] = $field;
			}
		} else {
			$group['fields'] = \LWS\WOOREWARDS\PRO\Ui\Endpoints\Badges::getAdminFields();
		}
		return $group;
	}

	protected static function getGroupMyAccountAchievements($legacy)
	{
		$group = array(
			'id'    => 'myaccountachievementsview',
			'icon'	=> 'lws-icon-trophy',
			'title' => __("My Account - Achievements", 'woorewards-pro'),
			'text'  => __("Show to the customer all possible achievements in a 'Achievements' Tab inside WooCommerce's My Account.", 'woorewards-pro'),
			'extra' => array('doclink' => 'https://plugins.longwatchstudio.com/docs/woorewards-4/woocommerce-integration/my-account/'),
		);

		if ($legacy) {
			$group['fields'] = self::getAchievementsLegacyFields();
			foreach (\LWS\WOOREWARDS\PRO\Ui\Endpoints\Achievements::getAdminFields() as $index => $field) {
				$field['require'] = array('selector' => '#lws_woorewards_wc_achievements_account_mode', 'value' => '');
				$group['fields'][$index] = $field;
			}
		} else {
			$group['fields'] = \LWS\WOOREWARDS\PRO\Ui\Endpoints\Achievements::getAdminFields();
		}
		return $group;
	}

	protected static function getGroupProductPointsPreview()
	{
		return array(
			'id' => 'productpointspreview',
			'icon'	=> 'lws-icon-barcode',
			'title' => __("Product Page Preview", 'woorewards-pro'),
			'text' => __("Shows points that a customer could earn purchasing a given product. That block stay hidden if the product produces no points.", 'woorewards-pro'),
			'extra'    => array('doclink' => 'https://plugins.longwatchstudio.com/docs/woorewards-4/woocommerce-integration/product-earned-points/'),
			'fields' => array(
				array(
					'id' => 'lws_woorewards_product_potential_position',
					'title' => __("Location", 'woorewards-pro'),
					'type'  => 'lacselect',
					'extra' => array(
						'maxwidth' => '400px',
						'default'  => 'not_displayed',
						'mode'     => 'select',
						'notnull'  => true,
						'source'   => array(
							array('value' => 'not_displayed', 'label' => __("Not displayed at all", 'woorewards-pro')),
							array('value' => 'before_summary', 'label' => __("Before product summary", 'woorewards-pro')),
							array('value' => 'inside_summary', 'label' => __("Inside product summary", 'woorewards-pro')),
							array('value' => 'after_form', 'label' => __("After product form", 'woorewards-pro')),
							array('value' => 'after_summary', 'label' => __("After product summary", 'woorewards-pro')),
						)
					)
				),
				array(
					'id' => 'lws_woorewards_ppp_unlogged_text',
					'title' => __("Text for unlogged customers", 'woorewards-pro'),
					'type' => 'text',
					'extra' => array(
						'size' => '50',
						'wpml' => "WooRewards - Product Points Preview - Unlogged Text",
						'tooltips' => __("Fill this if you want to show a text for unlogged customers", 'woorewards-pro'),
					)
				),
				array(
					'id' => 'lws_woorewards_ppp_show_unlogged',
					'title' => __("Show for unlogged customers", 'woorewards-pro'),
					'type' => 'box',
					'extra' => array(
						'default' => 'on',
						'class' => 'lws_checkbox',
						'tooltips' => __("Check this option if you want to show potentially earned points to unlogged customers", 'woorewards-pro'),
					)
				),
				array(
					'id' => 'lws_woorewards_product_potential_pool',
					'title' => __("Points and rewards systems", 'woorewards-pro'),
					'type' => 'lacchecklist',
					'extra' => array(
						'ajax' => 'lws_woorewards_pool_list',
						'tooltips' => __("If you select several systems, they will be displayed separately, one after the other.", 'woorewards-pro'),
					)
				),
				array(
					'id' => 'lws_wre_product_points_preview',
					'type' => 'stygen',
					'extra' => array(
						'purpose' => 'filter',
						'template' => 'productpointspreview',
						'html' => false,
						'css' => LWS_WOOREWARDS_PRO_CSS . '/templates/productpointspreview.css',
						'subids' => array(
							'lws_woorewards_label_ppp' => "WooRewards - Product Points Preview - Title",
						)
					)
				)
			)
		);
	}

	protected static function getGroupShopPointsPreview()
	{
		return array(
			'id' => 'shoppointspreview',
			'icon'	=> 'lws-icon-shopping-tag',
			'title' => __("Shop Page Preview", 'woorewards-pro'),
			'text' => __("Shows points that a customer could earn purchasing products on a products list page. That block stay hidden if customers can't earn points with products.", 'woorewards-pro'),
			//'extra'    => array('doclink' => 'https://plugins.longwatchstudio.com/docs/woorewards-4/woocommerce-integration/product-earned-points/'),
			'fields' => array(
				array(
					'id' => 'lws_woorewards_product_loop_points_preview',
					'title' => __("Enable", 'woorewards-pro'),
					'type' => 'box',
					'extra' => array(
						'default' => '',
						'class' => 'lws_checkbox',
						'tooltips' => __("In Shop page, points preview is appended for each item in the loop. Warning ! It can be a heavy process if your lists shows many products.", 'woorewards-pro'),
					)
				),
				array(
					'id' => 'lws_woorewards_product_loop_points_preview_pattern',
					'title' => __("Pattern", 'woorewards-pro'),
					'type' => 'text',
					'extra' => array(
						'placeholder' => __("Earn [points] in [system]", 'woorewards-pro'),
						'tooltips' => sprintf(
							__('In the preview text, shortcodes %1$s and %2$s will be replaced by the points amount and Points and Rewards System title.', 'woorewards-pro'),
							'<b>[points]</b>',
							'<b>[system]</b>'
						),
						'wpml' => "WooRewards - Product loop - Points Preview pattern",
					)
				),
				array(
					'id' => 'lws_woorewards_product_loop_preview_pools',
					'title' => __("Points and rewards systems", 'woorewards-pro'),
					'type' => 'lacchecklist',
					'extra' => array(
						'ajax' => 'lws_woorewards_pool_list',
						'tooltips' => __("If you select several systems, they will be displayed separately, one after another.", 'woorewards-pro'),
					)
				),
			)
		);
	}

	protected static function getGroupOrderPoints()
	{
		return array(
			'id' => 'orderpoints',
			'icon'	=> 'lws-icon-letter',
			'title' => __("Order Email Points Information", 'woorewards-pro'),
			'text' => array(
				array('join' => '<br/>',
					__("Set a message for customers when they place a new order", 'woorewards-pro'),
					__("Use the following options to display specific information on the email :", 'woorewards-pro'),
				),
				array('tag' => 'ul',
					array('[wr_wc_order_points] : ', __("displays all information about points earned in the current points and rewards system.", 'woorewards-pro')),
					array('[order_points] : ', __("displays the points earned for this order in the current points and rewards systems.", 'woorewards-pro')),
					array('[points_name] : ', __("displays the name of the points in the current points and rewards systems.", 'woorewards-pro')),
					array('[system_name] : ', __("displays the title of the current points and rewards systems.", 'woorewards-pro')),
					array('[points_balance] : ', __("displays the user's points balance in the current points and rewards systems.", 'woorewards-pro')),
				),
				array('tag' => 'strong',
					__("If multiple points and rewards systems gave points with the order, the text will be repeated for each system.", 'woorewards-pro')
				),
			),
			'extra'    => array('doclink' => 'https://plugins.longwatchstudio.com/docs/woorewards-4/woocommerce-integration/new-order-email/'),
			'fields' => array(
				array(
					'id' => 'lws_woorewards_wc_new_order_enable',
					'title' => __("Enable Email Message", 'woorewards-pro'),
					'type' => 'box',
					'extra' => array(
						'default' => '',
						'class' => 'lws_checkbox',
						'tooltips' => __("Check this option if you want to show a message in new order emails", 'woorewards-pro'),
					)
				),
				array(
					'id' => 'lws_woorewards_wc_thanks_order_enable',
					'title' => __("Enable Thanks Page Message", 'woorewards-pro'),
					'type' => 'box',
					'extra' => array(
						'default' => '',
						'class' => 'lws_checkbox',
						'tooltips' => __("Check this option if you want to show a message in the Thank you page after Order validation", 'woorewards-pro'),
					)
				),
				array(
					'id' => 'lws_woorewards_wc_details_order_enable',
					'title' => __("Enable Order Details Message", 'woorewards-pro'),
					'type' => 'box',
					'extra' => array(
						'default' => '',
						'class' => 'lws_checkbox',
						'tooltips' => __("Check this option if you want to show a message in the Order details, in Customer My Account page", 'woorewards-pro'),
					)
				),
				array(
					'id' => 'lws_woorewards_wc_new_order_pools',
					'title' => __("Points and rewards systems", 'woorewards-pro'),
					'type' => 'lacchecklist',
					'extra' => array(
						'ajax' => 'lws_woorewards_pool_list',
						'tooltips' => __("If you select several systems, they will be displayed separately, one after the other when using the shortcode.", 'woorewards-pro'),
					)
				),
				array(
					'id' => 'lws_woorewards_wc_new_order_content',
					'type' => 'wpeditor',
					'title' => __("Email text", 'woorewards-pro'),
					'extra' => array(
						'editor_height' => 30,
						'default' => __("With this order, you will earn [wr_wc_order_points]", 'woorewards-pro'),
						'wpml'    => "WooRewards - New Order Email Message - Earning Points",
					)
				),
			)
		);
	}
}
