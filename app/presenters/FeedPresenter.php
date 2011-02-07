<?php
class FeedPresenter extends BasePresenter {
	
	protected function startup() {
		parent::startup();
		$this->absoluteUrls = TRUE;
	}
	
	public function renderSitemap() {
		$this->template->items = array();
		foreach (glob(APP_DIR . "/templates/*.latte") as $template) {
			$template = str_replace(".", ":", basename($template, ".latte"));
			if (!preg_match('~@|^Error:|^Feed:~', $template)) {
				$items = array();
                                $this->template->items[] = array("loc" => $this->link($template));
				/*switch ($template) {
					//case "Offer:default": $items = Offer::actives()->select("id, title_" . LANG . " AS slug"); break;
					case "Sign:in": break;
					default: $this->template->items[] = array("loc" => $this->link($template));
				}
				/*foreach ($items as $id => $val) {
					$this->template->items[] = array("loc" => $this->link($template, $id));
				}*/
			}
		}
	}
	
}
