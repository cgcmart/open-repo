<?php
namespace Opencart\Admin\Controller\Extension\Open929\Payment;
class NmiCollectjs extends \Opencart\System\Engine\Controller {
	public function index(): void {
		$this->load->language('extension/open929/payment/nmi_collectjs');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment')
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/open929/payment/nmi_collectjs', 'user_token=' . $this->session->data['user_token'])
		];

		$data['save'] = $this->url->link('extension/open929/payment/nmi_collectjs|save', 'user_token=' . $this->session->data['user_token']);

		$data['back'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment');

		$data['payment_nmi_collectjs'] = [];

		if (isset($this->request->post['payment_nmi_collectjs_username'])) {
			$data['payment_nmi_collectjs_username'] = $this->request->post['payment_nmi_collectjs_username'];
		} else {
			$data['payment_nmi_collectjs_username'] = $this->config->get('payment_nmi_collectjs_username');
		}

		if (isset($this->request->post['payment_nmi_collectjs_password'])) {
			$data['payment_nmi_collectjs_password'] = $this->request->post['payment_nmi_collectjs_password'];
		} else {
			$data['payment_nmi_collectjs_password'] = $this->config->get('payment_nmi_collectjs_password');
		}

		if (isset($this->request->post['payment_nmi_collectjs_api_key'])) {
			$data['payment_nmi_collectjs_api_key'] = $this->request->post['payment_nmi_collectjs_api_key'];
		} else {
			$data['payment_nmi_collectjs_api_key'] = $this->config->get('payment_nmi_collectjs_api_key');
		}

		if (isset($this->request->post['payment_nmi_collectjs_tokenization_key'])) {
			$data['payment_nmi_collectjs_tokenization_key'] = $this->request->post['payment_nmi_collectjs_tokenization_key'];
		} else {
			$data['payment_nmi_collectjs_tokenization_key'] = $this->config->get('payment_nmi_collectjs_tokenization_key');
		}

		if (isset($this->request->post['payment_nmi_collectjs_dup_seconds'])) {
			$data['payment_nmi_collectjs_dup_seconds'] = $this->request->post['payment_nmi_collectjs_dup_seconds'];
		} else {
			$data['payment_nmi_collectjs_dup_seconds'] = $this->config->get('payment_nmi_collectjs_dup_seconds');
		}

		if (isset($this->request->post['payment_nmi_collectjs_method'])) {
			$data['payment_nmi_collectjs_method'] = $this->request->post['payment_nmi_collectjs_method'];
		} else {
			$data['payment_nmi_collectjs_method'] = $this->config->get('payment_nmi_collectjs_method');
		}

		if (isset($this->request->post['payment_nmi_collectjs_debug'])) {
			$data['payment_nmi_collectjs_debug'] = $this->request->post['payment_nmi_collectjs_debug'];
		} else {
			$data['payment_nmi_collectjs_debug'] = $this->config->get('payment_nmi_collectjs_debug');
		}

		if (isset($this->request->post['payment_nmi_collectjs_order_status_id'])) {
			$data['payment_nmi_collectjs_order_status_id'] = $this->request->post['payment_nmi_collectjs_order_status_id'];
		} else {
			$data['payment_nmi_collectjs_order_status_id'] = $this->config->get('payment_nmi_collectjs_order_status_id');
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['payment_nmi_collectjs_geo_zone_id'])) {
			$data['payment_nmi_collectjs_geo_zone_id'] = $this->request->post['payment_nmi_collectjs_geo_zone_id'];
		} else {
			$data['payment_nmi_collectjs_geo_zone_id'] = $this->config->get('payment_nmi_collectjs_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['payment_nmi_collectjs_status'])) {
			$data['payment_nmi_collectjs_status'] = $this->request->post['payment_nmi_collectjs_status'];
		} else {
			$data['payment_nmi_collectjs_status'] = $this->config->get('payment_nmi_collectjs_status');
		}

		if (isset($this->request->post['payment_nmi_collectjs_sort_order'])) {
			$data['payment_nmi_collectjs_sort_order'] = $this->request->post['payment_nmi_collectjs_sort_order'];
		} else {
			$data['payment_nmi_collectjs_sort_order'] = $this->config->get('payment_nmi_collectjs_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/open929/payment/nmi_collectjs', $data));
	}

	public function save(): void {
		$this->load->language('extension/open929/payment/nmi_collectjs');

		$json = [];

		if (!$this->user->hasPermission('modify', 'extension/open929/payment/nmi_collectjs')) {
			$json['error']['warning'] = $this->language->get('error_permission');
		}

		if (!$json) {
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting('payment_nmi_collectjs', $this->request->post);

			$json['success'] = $this->language->get('text_success');
	
		}

		if (!$this->request->post['payment_nmi_collectjs_api_key']) {
			if (!$this->request->post['payment_nmi_collectjs_username']) {
				$json['error']['username'] = $this->language->get('error_username');
			}

			if (!$this->request->post['payment_nmi_collectjs_password']) {
				$json['error']['password'] = $this->language->get('error_password');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}