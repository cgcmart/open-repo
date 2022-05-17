<?php
namespace Opencart\Catalog\Controller\Common;
class Search extends \Opencart\System\Engine\Controller {
	public function index(): string {
		$this->load->language('common/search');

		$data['text_search'] = $this->language->get('text_search');

        $data['language'] = $this->config->get('config_language');

		if (isset($this->request->get['search'])) {
			$data['search'] = $this->request->get['search'];
		} else {
			$data['search'] = '';
		}

		return $this->load->view('common/search', $data);
	}
}