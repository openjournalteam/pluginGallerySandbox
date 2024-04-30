{**
 * plugins/generic/announcementFeed/settingsForm.tpl
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2003-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * Announcement Feed plugin settings
 *
 *}
<script>
	$(function() {ldelim}
		// Attach the form handler.
		$('#pluginGallerySandboxSettingsForm').pkpHandler('$.pkp.controllers.form.AjaxFormHandler');
	{rdelim});
</script>

<form class="pkp_form" id="pluginGallerySandboxSettingsForm" method="post" action="{url router=$smarty.const.ROUTE_COMPONENT op="manage" category="generic" plugin=$pluginName verb="settings" save=true}">
	<div id="pluginGallerySandboxSettings">
		<div id="description">This plugin is a sandbox for testing submitting new plugins to Plugin Gallery by PKP. It is not intended for production use.</div>

		<div class="separator">&nbsp;</div>
		{csrf}
		{include file="common/formErrors.tpl"}

		{fbvFormSection list=true}
			<div>Insert your accessible plugins.xml link here</div>
			{fbvElement type="text" id="link" value=$link label="plugins.generic.pluginGallerySandbox.settings.link.label" size=$fbvStyles.size.HIGH}
		{/fbvFormSection}

		{fbvFormButtons}

		<p><span class="formRequired">{translate key="common.requiredField"}</span></p>
	</div>
</form>
