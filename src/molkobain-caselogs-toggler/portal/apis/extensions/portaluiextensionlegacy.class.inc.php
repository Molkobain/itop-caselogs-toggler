<?php
/**
 * Copyright (c) 2015 - 2020 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\CaselogsToggler\Portal\Extension;

use AbstractPortalUIExtension;
use Dict;
use Silex\Application;
use utils;
use Molkobain\iTop\Extension\CaselogsToggler\Common\Helper\ConfigHelper;

// Protection, only for iTop 2.4-2.6
if(version_compare(ITOP_VERSION, '2.3', '>') && version_compare(ITOP_VERSION, '2.7', '<') && (ITOP_VERSION !== 'develop'))
{
	/**
	 * Class PortalUIExtensionLegacy
	 *
	 * @package Molkobain\iTop\Extension\CaselogsToggler\Portal\Extension
	 * @since v1.5.0
	 */
	class PortalUIExtensionLegacy extends AbstractPortalUIExtension
	{
		/**
		 * @inheritdoc
		 */
		public function GetCSSFiles(Application $oApp)
		{
			// Check if enabled
			if(ConfigHelper::IsEnabled() === false)
			{
				return array();
			}

			$sModuleVersion = utils::GetCompiledModuleVersion(ConfigHelper::GetModuleCode());
			$sURLBase = utils::GetAbsoluteUrlModulesRoot() . '/' . ConfigHelper::GetModuleCode() . '/';

			// Note: Here we pass the compiled .css file in order to be compatible with iTop 2.5 and earlier (ApplicationHelper::LoadUIExtensions() refactoring that uses utils::GetCSSFromSASS())
			$aReturn = array(
				$sURLBase . 'common/css/caselogs-toggler.css?v=' . $sModuleVersion,
			);

			return $aReturn;
		}

		/**
		 * @inheritdoc
		 *
		 * @throws \DictExceptionMissingString
		 */
		public function GetJSInline(Application $oApp)
		{
			// Check if enabled
			if(ConfigHelper::IsEnabled() === false)
			{
				return '';
			}

			$sExpandTitle = Dict::S('Molkobain:CaselogsToggler:Entries:OpenAll');
			$sCollapseTitle = Dict::S('Molkobain:CaselogsToggler:Entries:CloseAll');

			$sExpandCssClasses = ConfigHelper::GetSetting('open_all_icon');
			$sCollapseCssClasses = ConfigHelper::GetSetting('close_all_icon');
			$sIconsSeparator = ConfigHelper::GetSetting('icons_separator');

			$sJSInline =
				<<<EOF
// Molkobain caselogs toggler
function InstanciateCaselogsToggler(oElem)
{
    var me = oElem;
    
    // Wrapper element on the right of the field label
    var oWrapperElem = $('<div class="molkobain-caselogs-toggler"></div>')
        .appendTo( me.find('.form_field_label label') );
        
    // Togglers
    var oExpandElem = $('<span class="mct-button {$sExpandCssClasses}" title="{$sExpandTitle}" data-toggle="tooltip"></span>');
    var oCollapseElem = $('<span class="mct-button {$sCollapseCssClasses}" title="{$sCollapseTitle}" data-toggle="tooltip"></span>');
    $('<span class="mct-togglers"></span>')
	    .append(oExpandElem)
	    .append('<span class="mct-separator">{$sIconsSeparator}</span>')
	    .append(oCollapseElem)
	    .appendTo(oWrapperElem);
    
    // Bind listeners
    // - Togglers
    oExpandElem.on('click', function(){
            me.find('.caselog_field_entry_header .caselog_field_entry_button').removeClass('collapsed');
            me.find('.caselog_field_entry_content').addClass('in');
        })
        .tooltip();
    oCollapseElem.on('click', function(){
            me.find('.caselog_field_entry_header .caselog_field_entry_button').addClass('collapsed');
            me.find('.caselog_field_entry_content').removeClass('in');
        })
        .tooltip();
    // - Toggle all on entry header click
    me.on('click', '.caselog_field_entry_header', function(oEvent){
        if(oEvent.altKey === true)
        {
            if($(this).parent().find('.caselog_field_entry_content:first').hasClass('in'))
            {
                oCollapseElem.trigger('click');
            }
            else
            {
                oExpandElem.trigger('click');
            }
        }
    });
}

// Instanciate widget on modals
$('body').on('loaded.bs.modal', function (oEvent) {
    setTimeout(function(){
        var oForm = $(oEvent.target).find('.modal-content form');
        if(oForm.length > 0)
        {
            if(oForm.find('.field_set .form_field_control .caselog_field_entry:first').length > 0)
            {
                InstanciateCaselogsToggler(oForm.find('.field_set .form_field_control .caselog_field_entry:first').closest('.form-group'));
            }
        }
    }, 200);
});

// Instanciate widget on initial elements
$(document).ready(function(){
    $('.field_set .form_field_control .caselog_field_entry:first').each(function(){
        InstanciateCaselogsToggler($(this).closest('.form-group'));
    });
});
EOF;

			return $sJSInline;
		}
	}
}
