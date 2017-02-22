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

			$starthook = kirby()->get('option', 'starthook');
			$starthook = (is_array($starthook)) ? $starthook : array();

			$data = array_merge(
				$page->templateData(), 
				$data,
				$page->controller($data),
				$starthook
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