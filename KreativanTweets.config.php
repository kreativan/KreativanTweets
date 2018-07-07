<?php
/**
 *  KreativanTweets Config
 *
 *  @author Ivan Milincic <lokomotivan@gmail.com>
 *  @copyright 2018 Ivan Milincic
 *
 *
*/

class KreativanTweetsConfig extends ModuleConfig {

	public function getInputfields() {
		$inputfields = parent::getInputfields();

			// create templates options array
			$templatesArr = array();
			foreach($this->templates as $tmp) {
				$templatesArr["$tmp"] = $tmp->name;
			}

			$wrapper = new InputfieldWrapper();

		//----------------------------------------------------------------------
		//  Options
		//----------------------------------------------------------------------
			$module_options = $this->wire('modules')->get("InputfieldFieldset");
			$module_options->label = __("Module Options");
			//$module_options->collapsed = 1;
			$module_options->icon = "fa-cog";
			$module_options->notes = __("You may obtain the above pieces of information by creating a Twitter application at [https://dev.twitter.com/apps](https://dev.twitter.com/apps).");
			$wrapper->add($module_options);

			// twitter_consumer_key
			$f = $this->wire('modules')->get("InputfieldText");
			$f->attr('name', 'twitter_consumer_key');
			$f->label = 'Twitter Consumer Key';
			$f->columnWidth = "50%";
			$module_options->add($f);

			// twitter_consumer_secret
			$f = $this->wire('modules')->get("InputfieldText");
			$f->attr('name', 'twitter_consumer_secret');
			$f->label = 'Twitter Consumer Secret';
			$f->columnWidth = "50%";
			$module_options->add($f);

			// twitter_access_token
			$f = $this->wire('modules')->get("InputfieldText");
			$f->attr('name', 'twitter_access_token');
			$f->label = 'Twitter Access Token';
			$f->columnWidth = "50%";
			$module_options->add($f);

			// twitter_access_token_secret
			$f = $this->wire('modules')->get("InputfieldText");
			$f->attr('name', 'twitter_access_token_secret');
			$f->label = 'Twitter Access Token Secret';
			$f->columnWidth = "50%";
			$module_options->add($f);

			// render fieldset
			$inputfields->add($module_options);

		// render fields
		return $inputfields;

	}

}
