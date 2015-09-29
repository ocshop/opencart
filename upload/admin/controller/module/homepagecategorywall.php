<?php
class ControllerModuleHomepagecategorywall extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/homepagecategorywall');

		$this->document->setTitle(strip_tags ($this->language->get('heading_title')));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('homepagecategorywall', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');
		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');

		$this->data['entry_limit_parent_category'] = $this->language->get('entry_limit_parent_category');
		$this->data['entry_limit_sub_category'] = $this->language->get('entry_limit_sub_category');
		
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_category'] = $this->language->get('entry_category');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');				$this->data['entry_cover_status'] = $this->language->get('entry_cover_status');
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->error['image'])) {
			$this->data['error_image'] = $this->error['image'];
		} else {
			$this->data['error_image'] = array();
		}
		
		if (isset($this->error['limit_parent_category'])) {
			$this->data['error_limit_parent_category'] = $this->error['limit_parent_category'];
		} else {
			$this->data['error_limit_parent_category'] = array();
		}
		
		if (isset($this->error['limit_sub_category'])) {
			$this->data['error_limit_sub_category'] = $this->error['limit_sub_category'];
		} else {
			$this->data['error_limit_sub_category'] = array();
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/homepagecategorywall', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/homepagecategorywall', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['modules'] = array();
		
		if (isset($this->request->post['homepagecategorywall_module'])) {
			$this->data['modules'] = $this->request->post['homepagecategorywall_module'];
		} elseif ($this->config->get('homepagecategorywall_module')) { 
			$this->data['modules'] = $this->config->get('homepagecategorywall_module');
		}
		
		$this->load->model('catalog/category');
				
		$this->data['categories'] = $this->model_catalog_category->getCategories(0);
		

		if (isset($this->request->post['homepagecategorywall_category'])) {
			$this->data['homepagecategorywall_category'] = $this->request->post['homepagecategorywall_category'];
		} elseif ($this->config->get('homepagecategorywall_category')) { 
			$this->data['homepagecategorywall_category'] = $this->config->get('homepagecategorywall_category');
		} else {
			$this->data['homepagecategorywall_category'] = array();
		}		
				
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/homepagecategorywall.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/homepagecategorywall')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (isset($this->request->post['homepagecategorywall_module'])) {
			foreach ($this->request->post['homepagecategorywall_module'] as $key => $value) {
				if (!$value['image_width'] || !$value['image_height']) {
					$this->error['image'][$key] = $this->language->get('error_image');
				}
			}
		}
		
		if (isset($this->request->post['homepagecategorywall_module'])) {
			foreach ($this->request->post['homepagecategorywall_module'] as $key => $value) {
				if (!$value['limit_parent_category']) {
					$this->error['limit_parent_category'][$key] = $this->language->get('error_limit_parent_category');
				}
			}
		}
		
		if (isset($this->request->post['homepagecategorywall_module'])) {
			foreach ($this->request->post['homepagecategorywall_module'] as $key => $value) {
				if (!$value['limit_sub_category']) {
					$this->error['limit_sub_category'][$key] = $this->language->get('error_limit_sub_category');
				}
			}
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>