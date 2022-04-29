<?php
namespace Opencart\Admin\Controller\Customer;
class CustomerApproval extends \Opencart\System\Engine\Controller {
	public function index(): void {
		$this->load->language('customer/customer_approval');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('customer/customer_approval', 'user_token=' . $this->session->data['user_token'])
		];

		$data['approve'] = $this->url->link('customer/customer_approval|approve', 'user_token=' . $this->session->data['user_token'], true);
		$data['deny'] = $this->url->link('customer/customer_approval|deny', 'user_token=' . $this->session->data['user_token'], true);

		$this->load->model('customer/customer_group');

		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		$data['list'] = $this->getList();

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('customer/customer_approval', $data));	
	}

	public function list(): void {
		$this->load->language('customer/customer_approval');

		$this->response->setOutput($this->getList());
	}

	public function getList(): string {
		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = '';
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = '';
		}
		
		if (isset($this->request->get['filter_customer_group_id'])) {
			$filter_customer_group_id = (int)$this->request->get['filter_customer_group_id'];
		} else {
			$filter_customer_group_id = '';
		}

		if (isset($this->request->get['filter_type'])) {
			$filter_type = $this->request->get['filter_type'];
		} else {
			$filter_type = '';
		}
		
		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = '';
		}
						
		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}

		if (isset($this->request->get['filter_type'])) {
			$url .= '&filter_type=' . $this->request->get['filter_type'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['action'] = $this->url->link('customer/customer_approval|list', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['customer_approvals'] = [];

		$filter_data = [
			'filter_customer'          => $filter_customer,
			'filter_email'             => $filter_email,
			'filter_customer_group_id' => $filter_customer_group_id,
			'filter_type'              => $filter_type,
			'filter_date_added'        => $filter_date_added,
			'start'                    => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit'                    => $this->config->get('config_pagination_admin')
		];

		$this->load->model('customer/customer_approval');	

		$customer_approval_total = $this->model_customer_customer_approval->getTotalCustomerApprovals($filter_data);

		$results = $this->model_customer_customer_approval->getCustomerApprovals($filter_data);

		foreach ($results as $result) {
			$data['customer_approvals'][] = [
				'customer_approval_id' => $result['customer_approval_id'],
				'customer_id'          => $result['customer_id'],
				'customer'             => $result['customer'],
				'email'                => $result['email'],
				'customer_group'       => $result['customer_group'],
				'type'                 => $this->language->get('text_' . $result['type']),
				'date_added'           => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'approve'              => $this->url->link('customer/customer_approval|approve', 'user_token=' . $this->session->data['user_token'] . '&customer_approval_id=' . $result['customer_approval_id'], true),
				'deny'                 => $this->url->link('customer/customer_approval|deny', 'user_token=' . $this->session->data['user_token'] . '&customer_approval_id=' . $result['customer_approval_id'], true),
				'edit'                 => $this->url->link('customer/customer|form', 'user_token=' . $this->session->data['user_token'] . '&customer_id=' . $result['customer_id'], true)
			];
		}

		$url = '';

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
			
		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}
		
		if (isset($this->request->get['filter_type'])) {
			$url .= '&filter_type=' . $this->request->get['filter_type'];
		}
		
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		$data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $customer_approval_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination_admin'),
			'url'   => $this->url->link('customer/customer_approval|customer_approval', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($customer_approval_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($customer_approval_total - $this->config->get('config_pagination_admin'))) ? $customer_approval_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $customer_approval_total, ceil($customer_approval_total / $this->config->get('config_pagination_admin')));

		return $this->load->view('customer/customer_approval_list', $data);
	}

	public function approve(): void {
		$this->load->language('customer/customer_approval');

		$json = [];

		if (!$this->user->hasPermission('modify', 'customer/customer_approval')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			$this->load->model('customer/customer_approval');

			$approvals = [];

			if (isset($this->request->post['selected'])) {
				$approvals = $this->request->post['selected'];
			}

			if (isset($this->request->get['customer_id'])) {
				$approvals[] = (int)$this->request->get['customer_id'];
			}

			foreach ($approvals as $customer_id) {
				if ($this->request->get['type'] == 'customer') {
					$this->model_customer_customer_approval->approveCustomer($customer_id);
				} elseif ($this->request->get['type'] == 'affiliate') {
					$this->model_customer_customer_approval->approveAffiliate($customer_id);
				}
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}	
	
	public function deny(): void {
		$this->load->language('customer/customer_approval');

		$json = [];
				
		if (!$this->user->hasPermission('modify', 'customer/customer_approval')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			$this->load->model('customer/customer_approval');

			$denials = [];

			if (isset($this->request->post['selected'])) {
				$denials = $this->request->post['selected'];
			}

			if (isset($this->request->get['customer_id'])) {
				$denials[] = (int)$this->request->get['customer_id'];
			}

			foreach ($denials as $customer_id) {
				if ($this->request->get['type'] == 'customer') {
					$this->model_customer_customer_approval->denyCustomer($customer_id);
				} elseif ($this->request->get['type'] == 'affiliate') {
					$this->model_customer_customer_approval->denyAffiliate($customer_id);
				}
			}

			$json['success'] = $this->language->get('text_success');
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}