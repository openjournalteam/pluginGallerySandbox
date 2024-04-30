<?php

/**
 * @file plugins/generic/announcementFeed/AnnouncementFeedSettingsForm.inc.php
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2003-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class AnnouncementFeedSettingsForm
 * @ingroup plugins_generic_annoucementFeed
 *
 * @brief Form for journal managers to modify announcement feed plugin settings
 */

import('lib.pkp.classes.form.Form');

class PluginGallerySandboxSettingsForm extends Form {

	/** @var int */
	protected $_journalId;

	/** @var object */
	protected $_plugin;

	/**
	 * Constructor
	 * @param $plugin object
	 * @param $journalId int
	 */
	public function __construct($plugin, $journalId) {
		$this->_journalId = $journalId;
		$this->_plugin = $plugin;

		parent::__construct($plugin->getTemplateResource('settingsForm.tpl'));
		$this->addCheck(new FormValidatorPost($this));
		$this->addCheck(new FormValidatorCSRF($this));
	}

	/**
	 * Initialize form data.
	 */
	public function initData() {
		$journalId = $this->_journalId;
		$plugin = $this->_plugin;

		$this->setData('link', $plugin->getSetting($journalId, 'link'));
	}

	/**
	 * Assign form data to user-submitted data.
	 */
	public function readInputData() {
		$request = Application::get()->getRequest();
		$this->setData('link', $request->getUserVar('link'));
	}

	/**
	 * Fetch the form.
	 * @copydoc Form::fetch()
	 */
	public function fetch($request, $template = null, $display = false) {
		$templateMgr = TemplateManager::getManager($request);
		$templateMgr->assign('pluginName', $this->_plugin->getName());
		return parent::fetch($request, $template, $display);
	}

	/**
	 * @copydoc Form::execute()
	 */
	public function execute(...$functionArgs) {
		$plugin = $this->_plugin;
		$journalId = $this->_journalId;

		$plugin->updateSetting($journalId, 'link', $this->getData('link'));

		parent::execute(...$functionArgs);
	}

}
