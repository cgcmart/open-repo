<?php
namespace Opencart\Admin\Controller\Extension\Open929\Shipping;
class Ups extends \Opencart\System\Engine\Controller {
	public function index(): void {
		$this->load->language('extension/open929/shipping/ups');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping')
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/open929/shipping/ups', 'user_token=' . $this->session->data['user_token'])
		];

		$data['save'] = $this->url->link('extension/open929/shipping/ups|save', 'user_token=' . $this->session->data['user_token']);

		$data['back'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping');

		if (isset($this->request->post['shipping_ups_key'])) {
			$data['shipping_ups_key'] = $this->request->post['shipping_ups_key'];
		} else {
			$data['shipping_ups_key'] = $this->config->get('shipping_ups_key');
		}

		if (isset($this->request->post['shipping_ups_username'])) {
			$data['shipping_ups_username'] = $this->request->post['shipping_ups_username'];
		} else {
			$data['shipping_ups_username'] = $this->config->get('shipping_ups_username');
		}

		if (isset($this->request->post['shipping_ups_password'])) {
			$data['shipping_ups_password'] = $this->request->post['shipping_ups_password'];
		} else {
			$data['shipping_ups_password'] = $this->config->get('shipping_ups_password');
		}

		if (isset($this->request->post['shipping_ups_pickup'])) {
			$data['shipping_ups_pickup'] = $this->request->post['shipping_ups_pickup'];
		} else {
			$data['shipping_ups_pickup'] = $this->config->get('shipping_ups_pickup');
		}

		$data['pickups'] = [];

		$data['pickups'][] = [
			'value' => '01',
			'text'  => $this->language->get('text_daily_pickup')
		];

		$data['pickups'][] = [
			'value' => '03',
			'text'  => $this->language->get('text_customer_counter')
		];

		$data['pickups'][] = [
			'value' => '06',
			'text'  => $this->language->get('text_one_time_pickup')
		];

		$data['pickups'][] = [
			'value' => '07',
			'text'  => $this->language->get('text_on_call_air_pickup')
		];

		$data['pickups'][] = [
			'value' => '19',
			'text'  => $this->language->get('text_letter_center')
		];

		$data['pickups'][] = [
			'value' => '20',
			'text'  => $this->language->get('text_air_service_center')
		];

		if (isset($this->request->post['shipping_ups_packaging'])) {
			$data['shipping_ups_packaging'] = $this->request->post['shipping_ups_packaging'];
		} else {
			$data['shipping_ups_packaging'] = $this->config->get('shipping_ups_packaging');
		}

		$data['packages'] = [];

		$data['packages'][] = [
			'value' => '02',
			'text'  => $this->language->get('text_package')
		];

		$data['packages'][] = [
			'value' => '01',
			'text'  => $this->language->get('text_ups_letter')
		];

		$data['packages'][] = [
			'value' => '03',
			'text'  => $this->language->get('text_ups_tube')
		];

		$data['packages'][] = [
			'value' => '04',
			'text'  => $this->language->get('text_ups_pak')
		];

		$data['packages'][] = [
			'value' => '21',
			'text'  => $this->language->get('text_ups_express_box')
		];

		$data['packages'][] = [
			'value' => '24',
			'text'  => $this->language->get('text_ups_25kg_box')
		];

		$data['packages'][] = [
			'value' => '25',
			'text'  => $this->language->get('text_ups_10kg_box')
		];

		if (isset($this->request->post['shipping_ups_classification'])) {
			$data['shipping_ups_classification'] = $this->request->post['shipping_ups_classification'];
		} else {
			$data['shipping_ups_classification'] = $this->config->get('shipping_ups_classification');
		}

		$data['classifications'][] = [
			'value' => '00',
			'text'  => $this->language->get('text_ups_class_00')
		];

		$data['classifications'][] = [
			'value' => '01',
			'text'  => $this->language->get('text_ups_class_01')
		];

		$data['classifications'][] = [
			'value' => '04',
			'text'  => $this->language->get('text_ups_class_04')
		];

		$data['classifications'][] = [
			'value' => '05',
			'text'  => $this->language->get('text_ups_class_05')
		];

		$data['classifications'][] = [
			'value' => '06',
			'text'  => $this->language->get('text_ups_class_06')
		];

		$data['classifications'][] = [
			'value' => '53',
			'text'  => $this->language->get('text_ups_class_53')
		];

		if (isset($this->request->post['shipping_ups_origin'])) {
			$data['shipping_ups_origin'] = $this->request->post['shipping_ups_origin'];
		} else {
			$data['shipping_ups_origin'] = $this->config->get('shipping_ups_origin');
		}

		$data['origins'] = [];

		$data['origins'][] = [
			'value' => 'US',
			'text'  => $this->language->get('text_us')
		];

		$data['origins'][] = [
			'value' => 'CA',
			'text'  => $this->language->get('text_ca')
		];

		$data['origins'][] = [
			'value' => 'EU',
			'text'  => $this->language->get('text_eu')
		];

		$data['origins'][] = [
			'value' => 'PR',
			'text'  => $this->language->get('text_pr')
		];

		$data['origins'][] = [
			'value' => 'MX',
			'text'  => $this->language->get('text_mx')
		];

		$data['origins'][] = [
			'value' => 'other',
			'text'  => $this->language->get('text_other')
		];

		if (isset($this->request->post['shipping_ups_shippernumber'])) {
			$data['shipping_ups_shippernumber'] = $this->request->post['shipping_ups_shippernumber'];
		} else {
			$data['shipping_ups_shippernumber'] = $this->config->get('shipping_ups_shippernumber');
		}

		if (isset($this->request->post['shipping_ups_use_negotiated_rates'])) {
			$data['shipping_ups_use_negotiated_rates'] = $this->request->post['shipping_ups_use_negotiated_rates'];
		} else {
			$data['shipping_ups_use_negotiated_rates'] = $this->config->get('shipping_ups_use_negotiated_rates');
		}

		if (isset($this->request->post['shipping_ups_city'])) {
			$data['shipping_ups_city'] = $this->request->post['shipping_ups_city'];
		} else {
			$data['shipping_ups_city'] = $this->config->get('shipping_ups_city');
		}

		if (isset($this->request->post['shipping_ups_state'])) {
			$data['shipping_ups_state'] = $this->request->post['shipping_ups_state'];
		} else {
			$data['shipping_ups_state'] = $this->config->get('shipping_ups_state');
		}

		if (isset($this->request->post['shipping_ups_country'])) {
			$data['shipping_ups_country'] = $this->request->post['shipping_ups_country'];
		} else {
			$data['shipping_ups_country'] = $this->config->get('shipping_ups_country');
		}

		if (isset($this->request->post['shipping_ups_postcode'])) {
			$data['shipping_ups_postcode'] = $this->request->post['shipping_ups_postcode'];
		} else {
			$data['shipping_ups_postcode'] = $this->config->get('shipping_ups_postcode');
		}

		if (isset($this->request->post['shipping_ups_test'])) {
			$data['shipping_ups_test'] = $this->request->post['shipping_ups_test'];
		} else {
			$data['shipping_ups_test'] = $this->config->get('shipping_ups_test');
		}

		if (isset($this->request->post['shipping_ups_quote_type'])) {
			$data['shipping_ups_quote_type'] = $this->request->post['shipping_ups_quote_type'];
		} else {
			$data['shipping_ups_quote_type'] = $this->config->get('shipping_ups_quote_type');
		}

		$data['quote_types'] = [];

		$data['quote_types'][] = [
			'value' => 'residential',
			'text'  => $this->language->get('text_residential')
		];

		$data['quote_types'][] = [
			'value' => 'commercial',
			'text'  => $this->language->get('text_commercial')
		];

		// US
		if (isset($this->request->post['shipping_ups_us_01'])) {
			$data['shipping_ups_us_01'] = $this->request->post['shipping_ups_us_01'];
		} else {
			$data['shipping_ups_us_01'] = $this->config->get('shipping_ups_us_01');
		}

		if (isset($this->request->post['shipping_ups_us_02'])) {
			$data['shipping_ups_us_02'] = $this->request->post['shipping_ups_us_02'];
		} else {
			$data['shipping_ups_us_02'] = $this->config->get('shipping_ups_us_02');
		}

		if (isset($this->request->post['shipping_ups_us_03'])) {
			$data['shipping_ups_us_03'] = $this->request->post['shipping_ups_us_03'];
		} else {
			$data['shipping_ups_us_03'] = $this->config->get('shipping_ups_us_03');
		}

		if (isset($this->request->post['shipping_ups_us_07'])) {
			$data['shipping_ups_us_07'] = $this->request->post['shipping_ups_us_07'];
		} else {
			$data['shipping_ups_us_07'] = $this->config->get('shipping_ups_us_07');
		}

		if (isset($this->request->post['shipping_ups_us_08'])) {
			$data['shipping_ups_us_08'] = $this->request->post['shipping_ups_us_08'];
		} else {
			$data['shipping_ups_us_08'] = $this->config->get('shipping_ups_us_08');
		}

		if (isset($this->request->post['shipping_ups_us_11'])) {
			$data['shipping_ups_us_11'] = $this->request->post['shipping_ups_us_11'];
		} else {
			$data['shipping_ups_us_11'] = $this->config->get('shipping_ups_us_11');
		}

		if (isset($this->request->post['shipping_ups_us_12'])) {
			$data['shipping_ups_us_12'] = $this->request->post['shipping_ups_us_12'];
		} else {
			$data['shipping_ups_us_12'] = $this->config->get('shipping_ups_us_12');
		}

		if (isset($this->request->post['shipping_ups_us_13'])) {
			$data['shipping_ups_us_13'] = $this->request->post['shipping_ups_us_13'];
		} else {
			$data['shipping_ups_us_13'] = $this->config->get('shipping_ups_us_13');
		}

		if (isset($this->request->post['shipping_ups_us_14'])) {
			$data['shipping_ups_us_14'] = $this->request->post['shipping_ups_us_14'];
		} else {
			$data['shipping_ups_us_14'] = $this->config->get('shipping_ups_us_14');
		}

		if (isset($this->request->post['shipping_ups_us_54'])) {
			$data['shipping_ups_us_54'] = $this->request->post['shipping_ups_us_54'];
		} else {
			$data['shipping_ups_us_54'] = $this->config->get('shipping_ups_us_54');
		}

		if (isset($this->request->post['shipping_ups_us_59'])) {
			$data['shipping_ups_us_59'] = $this->request->post['shipping_ups_us_59'];
		} else {
			$data['shipping_ups_us_59'] = $this->config->get('shipping_ups_us_59');
		}

		if (isset($this->request->post['shipping_ups_us_65'])) {
			$data['shipping_ups_us_65'] = $this->request->post['shipping_ups_us_65'];
		} else {
			$data['shipping_ups_us_65'] = $this->config->get('shipping_ups_us_65');
		}

		// Puerto Rico
		if (isset($this->request->post['shipping_ups_pr_01'])) {
			$data['shipping_ups_pr_01'] = $this->request->post['shipping_ups_pr_01'];
		} else {
			$data['shipping_ups_pr_01'] = $this->config->get('shipping_ups_pr_01');
		}

		if (isset($this->request->post['shipping_ups_pr_02'])) {
			$data['shipping_ups_pr_02'] = $this->request->post['shipping_ups_pr_02'];
		} else {
			$data['shipping_ups_pr_02'] = $this->config->get('shipping_ups_pr_02');
		}

		if (isset($this->request->post['shipping_ups_pr_03'])) {
			$data['shipping_ups_pr_03'] = $this->request->post['shipping_ups_pr_03'];
		} else {
			$data['shipping_ups_pr_03'] = $this->config->get('shipping_ups_pr_03');
		}

		if (isset($this->request->post['shipping_ups_pr_07'])) {
			$data['shipping_ups_pr_07'] = $this->request->post['shipping_ups_pr_07'];
		} else {
			$data['shipping_ups_pr_07'] = $this->config->get('shipping_ups_pr_07');
		}

		if (isset($this->request->post['shipping_ups_pr_08'])) {
			$data['shipping_ups_pr_08'] = $this->request->post['shipping_ups_pr_08'];
		} else {
			$data['shipping_ups_pr_08'] = $this->config->get('shipping_ups_pr_08');
		}

		if (isset($this->request->post['shipping_ups_pr_14'])) {
			$data['shipping_ups_pr_14'] = $this->request->post['shipping_ups_pr_14'];
		} else {
			$data['shipping_ups_pr_14'] = $this->config->get('shipping_ups_pr_14');
		}

		if (isset($this->request->post['shipping_ups_pr_54'])) {
			$data['shipping_ups_pr_54'] = $this->request->post['shipping_ups_pr_54'];
		} else {
			$data['shipping_ups_pr_54'] = $this->config->get('shipping_ups_pr_54');
		}

		if (isset($this->request->post['shipping_ups_pr_65'])) {
			$data['shipping_ups_pr_65'] = $this->request->post['shipping_ups_pr_65'];
		} else {
			$data['shipping_ups_pr_65'] = $this->config->get('shipping_ups_pr_65');
		}

		// Canada
		if (isset($this->request->post['shipping_ups_ca_01'])) {
			$data['shipping_ups_ca_01'] = $this->request->post['shipping_ups_ca_01'];
		} else {
			$data['shipping_ups_ca_01'] = $this->config->get('shipping_ups_ca_01');
		}

		if (isset($this->request->post['shipping_ups_ca_02'])) {
			$data['shipping_ups_ca_02'] = $this->request->post['shipping_ups_ca_02'];
		} else {
			$data['shipping_ups_ca_02'] = $this->config->get('shipping_ups_ca_02');
		}

		if (isset($this->request->post['shipping_ups_ca_07'])) {
			$data['shipping_ups_ca_07'] = $this->request->post['shipping_ups_ca_07'];
		} else {
			$data['shipping_ups_ca_07'] = $this->config->get('shipping_ups_ca_07');
		}

		if (isset($this->request->post['shipping_ups_ca_08'])) {
			$data['shipping_ups_ca_08'] = $this->request->post['shipping_ups_ca_08'];
		} else {
			$data['shipping_ups_ca_08'] = $this->config->get('shipping_ups_ca_08');
		}

		if (isset($this->request->post['shipping_ups_ca_11'])) {
			$data['shipping_ups_ca_11'] = $this->request->post['shipping_ups_ca_11'];
		} else {
			$data['shipping_ups_ca_11'] = $this->config->get('shipping_ups_ca_11');
		}

		if (isset($this->request->post['shipping_ups_ca_12'])) {
			$data['shipping_ups_ca_12'] = $this->request->post['shipping_ups_ca_12'];
		} else {
			$data['shipping_ups_ca_12'] = $this->config->get('shipping_ups_ca_12');
		}

		if (isset($this->request->post['shipping_ups_ca_13'])) {
			$data['shipping_ups_ca_13'] = $this->request->post['shipping_ups_ca_13'];
		} else {
			$data['shipping_ups_ca_13'] = $this->config->get('shipping_ups_ca_13');
		}

		if (isset($this->request->post['shipping_ups_ca_14'])) {
			$data['shipping_ups_ca_14'] = $this->request->post['shipping_ups_ca_14'];
		} else {
			$data['shipping_ups_ca_14'] = $this->config->get('shipping_ups_ca_14');
		}

		if (isset($this->request->post['shipping_ups_ca_54'])) {
			$data['shipping_ups_ca_54'] = $this->request->post['shipping_ups_ca_54'];
		} else {
			$data['shipping_ups_ca_54'] = $this->config->get('shipping_ups_ca_54');
		}

		if (isset($this->request->post['shipping_ups_ca_65'])) {
			$data['shipping_ups_ca_65'] = $this->request->post['shipping_ups_ca_65'];
		} else {
			$data['shipping_ups_ca_65'] = $this->config->get('shipping_ups_ca_65');
		}

		// Mexico
		if (isset($this->request->post['shipping_ups_mx_07'])) {
			$data['shipping_ups_mx_07'] = $this->request->post['shipping_ups_mx_07'];
		} else {
			$data['shipping_ups_mx_07'] = $this->config->get('shipping_ups_mx_07');
		}

		if (isset($this->request->post['shipping_ups_mx_08'])) {
			$data['shipping_ups_mx_08'] = $this->request->post['shipping_ups_mx_08'];
		} else {
			$data['shipping_ups_mx_08'] = $this->config->get('shipping_ups_mx_08');
		}

		if (isset($this->request->post['shipping_ups_mx_54'])) {
			$data['shipping_ups_mx_54'] = $this->request->post['shipping_ups_mx_54'];
		} else {
			$data['shipping_ups_mx_54'] = $this->config->get('shipping_ups_mx_54');
		}

		if (isset($this->request->post['shipping_ups_mx_65'])) {
			$data['shipping_ups_mx_65'] = $this->request->post['shipping_ups_mx_65'];
		} else {
			$data['shipping_ups_mx_65'] = $this->config->get('shipping_ups_mx_65');
		}

		// EU
		if (isset($this->request->post['shipping_ups_eu_07'])) {
			$data['shipping_ups_eu_07'] = $this->request->post['shipping_ups_eu_07'];
		} else {
			$data['shipping_ups_eu_07'] = $this->config->get('shipping_ups_eu_07');
		}

		if (isset($this->request->post['shipping_ups_eu_08'])) {
			$data['shipping_ups_eu_08'] = $this->request->post['shipping_ups_eu_08'];
		} else {
			$data['shipping_ups_eu_08'] = $this->config->get('shipping_ups_eu_08');
		}

		if (isset($this->request->post['shipping_ups_eu_11'])) {
			$data['shipping_ups_eu_11'] = $this->request->post['shipping_ups_eu_11'];
		} else {
			$data['shipping_ups_eu_11'] = $this->config->get('shipping_ups_eu_11');
		}

		if (isset($this->request->post['shipping_ups_eu_54'])) {
			$data['shipping_ups_eu_54'] = $this->request->post['shipping_ups_eu_54'];
		} else {
			$data['shipping_ups_eu_54'] = $this->config->get('shipping_ups_eu_54');
		}

		if (isset($this->request->post['shipping_ups_eu_65'])) {
			$data['shipping_ups_eu_65'] = $this->request->post['shipping_ups_eu_65'];
		} else {
			$data['shipping_ups_eu_65'] = $this->config->get('shipping_ups_eu_65');
		}

		if (isset($this->request->post['shipping_ups_eu_82'])) {
			$data['shipping_ups_eu_82'] = $this->request->post['shipping_ups_eu_82'];
		} else {
			$data['shipping_ups_eu_82'] = $this->config->get('shipping_ups_eu_82');
		}

		if (isset($this->request->post['shipping_ups_eu_83'])) {
			$data['shipping_ups_eu_83'] = $this->request->post['shipping_ups_eu_83'];
		} else {
			$data['shipping_ups_eu_83'] = $this->config->get('shipping_ups_eu_83');
		}

		if (isset($this->request->post['shipping_ups_eu_84'])) {
			$data['shipping_ups_eu_84'] = $this->request->post['shipping_ups_eu_84'];
		} else {
			$data['shipping_ups_eu_84'] = $this->config->get('shipping_ups_eu_84');
		}

		if (isset($this->request->post['shipping_ups_eu_85'])) {
			$data['shipping_ups_eu_85'] = $this->request->post['shipping_ups_eu_85'];
		} else {
			$data['shipping_ups_eu_85'] = $this->config->get('shipping_ups_eu_85');
		}

		if (isset($this->request->post['shipping_ups_eu_86'])) {
			$data['shipping_ups_eu_86'] = $this->request->post['shipping_ups_eu_86'];
		} else {
			$data['shipping_ups_eu_86'] = $this->config->get('shipping_ups_eu_86');
		}

		// Other
		if (isset($this->request->post['shipping_ups_other_07'])) {
			$data['shipping_ups_other_07'] = $this->request->post['shipping_ups_other_07'];
		} else {
			$data['shipping_ups_other_07'] = $this->config->get('shipping_ups_other_07');
		}

		if (isset($this->request->post['shipping_ups_other_08'])) {
			$data['shipping_ups_other_08'] = $this->request->post['shipping_ups_other_08'];
		} else {
			$data['shipping_ups_other_08'] = $this->config->get('shipping_ups_other_08');
		}

		if (isset($this->request->post['shipping_ups_other_11'])) {
			$data['shipping_ups_other_11'] = $this->request->post['shipping_ups_other_11'];
		} else {
			$data['shipping_ups_other_11'] = $this->config->get('shipping_ups_other_11');
		}

		if (isset($this->request->post['shipping_ups_other_54'])) {
			$data['shipping_ups_other_54'] = $this->request->post['shipping_ups_other_54'];
		} else {
			$data['shipping_ups_other_54'] = $this->config->get('shipping_ups_other_54');
		}

		if (isset($this->request->post['shipping_ups_other_65'])) {
			$data['shipping_ups_other_65'] = $this->request->post['shipping_ups_other_65'];
		} else {
			$data['shipping_ups_other_65'] = $this->config->get('shipping_ups_other_65');
		}

		if (isset($this->request->post['shipping_ups_display_time'])) {
			$data['shipping_ups_display_time'] = $this->request->post['shipping_ups_display_time'];
		} else {
			$data['shipping_ups_display_time'] = $this->config->get('shipping_ups_display_time');
		}

		if (isset($this->request->post['shipping_ups_display_weight'])) {
			$data['shipping_ups_display_weight'] = $this->request->post['shipping_ups_display_weight'];
		} else {
			$data['shipping_ups_display_weight'] = $this->config->get('shipping_ups_display_weight');
		}

		if (isset($this->request->post['shipping_ups_insurance'])) {
			$data['shipping_ups_insurance'] = $this->request->post['shipping_ups_insurance'];
		} else {
			$data['shipping_ups_insurance'] = $this->config->get('shipping_ups_insurance');
		}

		if (isset($this->request->post['shipping_ups_weight_class_id'])) {
			$data['shipping_ups_weight_class_id'] = $this->request->post['shipping_ups_weight_class_id'];
		} else {
			$data['shipping_ups_weight_class_id'] = $this->config->get('shipping_ups_weight_class_id');
		}

		$this->load->model('localisation/weight_class');

		$data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

		if (isset($this->request->post['shipping_ups_length_code'])) {
			$data['shipping_ups_length_code'] = $this->request->post['shipping_ups_length_code'];
		} else {
			$data['shipping_ups_length_code'] = $this->config->get('shipping_ups_length_code');
		}

		if (isset($this->request->post['shipping_ups_length_class_id'])) {
			$data['shipping_ups_length_class_id'] = $this->request->post['shipping_ups_length_class_id'];
		} else {
			$data['shipping_ups_length_class_id'] = $this->config->get('shipping_ups_length_class_id');
		}

		$this->load->model('localisation/length_class');

		$data['length_classes'] = $this->model_localisation_length_class->getLengthClasses();

		if (isset($this->request->post['shipping_ups_length'])) {
			$data['shipping_ups_length'] = $this->request->post['shipping_ups_length'];
		} else {
			$data['shipping_ups_length'] = $this->config->get('shipping_ups_length');
		}

		if (isset($this->request->post['shipping_ups_width'])) {
			$data['shipping_ups_width'] = $this->request->post['shipping_ups_width'];
		} else {
			$data['shipping_ups_width'] = $this->config->get('shipping_ups_width');
		}

		if (isset($this->request->post['shipping_ups_height'])) {
			$data['shipping_ups_height'] = $this->request->post['shipping_ups_height'];
		} else {
			$data['shipping_ups_height'] = $this->config->get('shipping_ups_height');
		}

		if (isset($this->request->post['shipping_ups_tax_class_id'])) {
			$data['shipping_ups_tax_class_id'] = $this->request->post['shipping_ups_tax_class_id'];
		} else {
			$data['shipping_ups_tax_class_id'] = $this->config->get('shipping_ups_tax_class_id');
		}

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['shipping_ups_geo_zone_id'])) {
			$data['shipping_ups_geo_zone_id'] = $this->request->post['shipping_ups_geo_zone_id'];
		} else {
			$data['shipping_ups_geo_zone_id'] = $this->config->get('shipping_ups_geo_zone_id');
		}

		if (isset($this->request->post['shipping_ups_status'])) {
			$data['shipping_ups_status'] = $this->request->post['shipping_ups_status'];
		} else {
			$data['shipping_ups_status'] = $this->config->get('shipping_ups_status');
		}

		if (isset($this->request->post['shipping_ups_sort_order'])) {
			$data['shipping_ups_sort_order'] = $this->request->post['shipping_ups_sort_order'];
		} else {
			$data['shipping_ups_sort_order'] = $this->config->get('shipping_ups_sort_order');
		}

		if (isset($this->request->post['shipping_ups_debug'])) {
			$data['shipping_ups_debug'] = $this->request->post['shipping_ups_debug'];
		} else {
			$data['shipping_ups_debug'] = $this->config->get('shipping_ups_debug');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/open929/shipping/ups', $data));
	}

	public function save(): void {
		$this->load->language('extension/open929/shipping/ups');

		$json = [];

		if (!$this->user->hasPermission('modify', 'extension/open929/shipping/ups')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['shipping_ups_key']) {
			$json['key'] = $this->language->get('error_key');
		}

		if (!$this->request->post['shipping_ups_username']) {
			$json['username'] = $this->language->get('error_username');
		}

		if (!$this->request->post['shipping_ups_password']) {
			$json['password'] = $this->language->get('error_password');
		}

		if (!$this->request->post['shipping_ups_city']) {
			$json['city'] = $this->language->get('error_city');
		}

		if (!$this->request->post['shipping_ups_state']) {
			$json['state'] = $this->language->get('error_state');
		}

		if (!$this->request->post['shipping_ups_country']) {
			$json['country'] = $this->language->get('error_country');
		}

		if (empty($this->request->post['shipping_ups_length'])) {
			$json['dimension'] = $this->language->get('error_dimension');
		}

		if (empty($this->request->post['shipping_ups_width'])) {
			$json['dimension'] = $this->language->get('error_dimension');
		}

		if (empty($this->request->post['shipping_ups_height'])) {
			$json['dimension'] = $this->language->get('error_dimension');
		}

		if (!$json) {
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting('shipping_ups', $this->request->post);

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json; charset=utf-8');
		$this->response->setOutput(json_encode($json));
	}
}