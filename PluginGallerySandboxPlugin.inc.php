<?php

import('lib.pkp.classes.plugins.GenericPlugin');

class PluginGallerySandboxPlugin extends GenericPlugin
{
	/**
	 * @copydoc Plugin::getDisplayName()
	 */
	function getDisplayName()
	{
		return 'Plugin Gallery Sandbox';
	}

	/**
	 * @copydoc Plugin::getDescription()
	 */
	function getDescription()
	{
		return 'This plugin is a sandbox for testing submitting new plugins. It is not intended for production use.';
	}

	/**
	 * @copydoc Plugin::register()
	 */
	function register($category, $path, $mainContextId = null)
	{
		$success = parent::register($category, $path, $mainContextId);
		if ($success && $this->getEnabled($mainContextId)) {
			
			if($link = $this->getSetting($this->getCurrentContextId(), 'link')){
				error_reporting(error_reporting() & ~E_NOTICE);
				define('PLUGIN_GALLERY_XML_URL', $link);
			}
		}
		return $success;
	}

	function getActions($request, $verb)
	{
		$router = $request->getRouter();
		import('lib.pkp.classes.linkAction.request.AjaxModal');
		return array_merge(
			$this->getEnabled() ? array(
				new LinkAction(
					'settings',
					new AjaxModal(
						$router->url($request, null, null, 'manage', null, array('verb' => 'settings', 'plugin' => $this->getName(), 'category' => 'generic')),
						$this->getDisplayName()
					),
					__('manager.plugins.settings'),
					null
				),
			) : array(),
			parent::getActions($request, $verb)
		);
	}

 	/**
	 * @copydoc Plugin::manage()
	 */
	public function manage($args, $request) {
		switch ($request->getUserVar('verb')) {
			case 'settings':
				$context = $request->getContext();

				AppLocale::requireComponents(LOCALE_COMPONENT_APP_COMMON,  LOCALE_COMPONENT_PKP_MANAGER);
				$templateMgr = TemplateManager::getManager($request);
				$templateMgr->registerPlugin('function', 'plugin_url', array($this, 'smartyPluginUrl'));

				$this->import('PluginGallerySandboxSettingsForm');
				$form = new PluginGallerySandboxSettingsForm($this, $context->getId());

				if ($request->getUserVar('save')) {
					$form->readInputData();
					if ($form->validate()) {
						$form->execute();
						return new JSONMessage(true);
					}
				} else {
					$form->initData();
				}
				return new JSONMessage(true, $form->fetch($request));
		}
		return parent::manage($args, $request);
	}
}
