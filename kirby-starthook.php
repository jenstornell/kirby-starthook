<?php
class starthook {
	public static function return($args = array()) {
		kirby()->set('option', 'starthook', $args);
	}
}

class starthookController extends Kirby\Component\Template {
	public function data($page, $data = []) {
		if($page instanceof Page) {
			kirby()->trigger('starthook', array($page));

			$global_hook = kirby()->get('option', 'starthook');
			$global_hook = (is_array($global_hook)) ? $global_hook : array();

			$data = array_merge(
				$page->templateData(), 
				$data,
				$page->controller($data),
				$global_hook
			);
		}

		return array_merge(array(
			'kirby' => $this->kirby,
			'site'  => $this->kirby->site(),
			'pages' => $this->kirby->site()->children(),
			'page'  => $page
		), $data);
	}
}

$kirby->set('component', 'template', 'starthookController');