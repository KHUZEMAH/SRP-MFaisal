<?php
namespace LWS\WOOREWARDS\Events;

// don't call the file directly
if( !defined( 'ABSPATH' ) ) exit();

/** Earn point the first time a customer complete an order. */
class FirstOrder extends \LWS\WOOREWARDS\Abstracts\Event
{
	protected $eventPriority = 100;

	function getInformation()
	{
		return array_merge(parent::getInformation(), array(
			'icon'  => 'lws-icon-shop',
			'short' => __("The customer will receive points when placing his first order.", 'woorewards-lite'),
			'help'  => __("Triggered only for registered customers", 'woorewards-lite'),
		));
	}

	public function getDisplayType()
	{
		return _x("Place a first order", "getDisplayType", 'woorewards-lite');
	}

	function getData()
	{
		$prefix = $this->getDataKeyPrefix();
		$data = parent::getData();
		$data[$prefix.'event_priority'] = $this->getEventPriority();
		return $data;
	}

	function getForm($context='editlist')
	{
		$prefix = $this->getDataKeyPrefix();
		$form = parent::getForm($context);

		// just hidden since we do not want to reset the value on save
		$noPri = (\get_option('lws_woorewards_show_loading_order_and_priority') ? '' : ' style="display: none;"');
		$label = __("Priority", 'woorewards-lite');
		$tooltip = __("Customer orders will run by ascending priority value.", 'woorewards-lite');
		$str = <<<EOT
		<div class='field-help'{$noPri}>$tooltip</div>
		<div class='lws-$context-opt-title label'{$noPri}>$label<div class='bt-field-help'>?</div></div>
		<div class='lws-$context-opt-input value'{$noPri}>
			<input type='text' id='{$prefix}event_priority' name='{$prefix}event_priority' placeholder='10' size='5' />
		</div>
EOT;

		$phb0 = $this->getFieldsetPlaceholder(false, 0);
		$form = str_replace($phb0, $str.$phb0, $form);

		return $form;
	}

	function submit($form=array(), $source='editlist')
	{
		$prefix = $this->getDataKeyPrefix();
		$values = \apply_filters('lws_adminpanel_arg_parse', array(
			'post'     => ($source == 'post'),
			'values'   => $form,
			'format'   => array(
				$prefix.'event_priority'   => 'd',
			),
			'defaults' => array(
				$prefix.'event_priority'   => $this->getEventPriority(),
			),
			'labels'   => array(
				$prefix.'event_priority'   => __("Event Priority", 'woorewards-lite'),
			)
		));
		if( !(isset($values['valid']) && $values['valid']) )
			return isset($values['error']) ? $values['error'] : false;

		$valid = parent::submit($form, $source);
		if( $valid === true )
		{
			$this->setEventPriority  ($values['values'][$prefix.'event_priority']);
		}
		return $valid;
	}

	protected function _fromPost(\WP_Post $post)
	{
		$this->setEventPriority($this->getSinglePostMeta($post->ID, 'wre_event_priority', $this->getEventPriority()));
		return $this;
	}

	protected function _save($id)
	{
		\update_post_meta($id, 'wre_event_priority', $this->getEventPriority());
		return $this;
	}

	function getEventPriority()
	{
		return \intval($this->eventPriority);
	}

	public function setEventPriority($priority)
	{
		$this->eventPriority = \intval($priority);
		return $this;
	}

	protected function _install()
	{
		\add_filter('lws_woorewards_wc_order_done_'.$this->getPoolName(), array($this, 'orderDone'), $this->getEventPriority());
	}

	function orderDone($order)
	{
		$userId = \LWS\Adminpanel\Tools\Conveniences::getCustomerId(false, $order->order);
		if (!$userId)
			return $order;

		if (\LWS\WOOREWARDS\Conveniences::getOrderCount($userId, $order->order_id, 'event') > 0)
			return $order;

		if( $points = \apply_filters('trigger_'.$this->getType(), 1, $this, $order->order) )
		{
			$reason = \LWS\WOOREWARDS\Core\Trace::byOrder($order->order)
				->setProvider($order->order->get_customer_id('edit'))
				->setReason(array("First customer order #%s", $order->order->get_order_number()), 'woorewards-lite');

			$this->addPoint(array(
					'user'  => $userId,
					'order' => $order->order,
				), $reason, $points);
		}
		return $order;
	}

	/**	@deprecated user \LWS\WOOREWARDS\Conveniences::getOrderCount() instead */
	protected function getOrderCount($user, $exceptOrderId = false)
	{
		return \LWS\WOOREWARDS\Conveniences::getOrderCount($user, $exceptOrderId, 'event');
	}

	/**	Event categories, used to filter out events from pool options.
	 *	@return array with category_id => category_label. */
	public function getCategories()
	{
		return array_merge(parent::getCategories(), array(
			'woocommerce' => __("WooCommerce", 'woorewards-lite'),
			'order' => __("Order", 'woorewards-lite')
		));
	}

	/** Never call, only to have poedit/wpml able to extract the sentance. */
	private function poeditDeclare()
	{
		__("First customer order #%s", 'woorewards-lite');
	}
}
