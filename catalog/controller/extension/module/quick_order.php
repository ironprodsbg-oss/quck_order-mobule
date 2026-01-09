<?php
class ControllerExtensionModuleQuickOrder extends Controller {
	public function index($setting): string {
		$this->load->language('extension/module/quick_order');

		$data['title'] = $this->language->get('text_quick_order_title');
		$data['text_name'] = $this->language->get('text_name');
		$data['text_phone'] = $this->language->get('text_phone');
		$data['text_comment'] = $this->language->get('text_comment');
		$data['text_submit'] = $this->config->get('module_quick_order_button_text') ?: $this->language->get('text_submit');
		$data['success_message'] = $this->config->get('module_quick_order_success_message') ?: $this->language->get('text_success');

		$data['action'] = $this->url->link('extension/module/quick_order/submit', '', true);

		return $this->load->view('extension/module/quick_order', $data);
	}

	public function submit(): void {
		$this->load->language('extension/module/quick_order');

		$json = [];

		if ($this->request->server['REQUEST_METHOD'] !== 'POST') {
			$json['error'] = $this->language->get('error_phone');
		} else {
			$name = trim($this->request->post['name'] ?? '');
			$phone = trim($this->request->post['phone'] ?? '');

			if ($name === '') {
				$json['error'] = $this->language->get('error_name');
			} elseif ($phone === '') {
				$json['error'] = $this->language->get('error_phone');
			} else {
				$json['success'] = $this->config->get('module_quick_order_success_message') ?: $this->language->get('text_success');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
