<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\CaselogsToggler\Console\Extension;

use utils;
use Dict;
use DBObjectSet;
use WebPage;
use iApplicationUIExtension;
use Molkobain\iTop\Extension\CaselogsToggler\Common\Helper\ConfigHelper;

/**
 * Class ApplicationUIExtension
 *
 * @package Molkobain\iTop\Extension\CaselogsToggler\Console\Extension
 */
class ApplicationUIExtension implements iApplicationUIExtension
{
    /**
     * @inheritdoc
     *
     * @throws \DictExceptionMissingString
     */
    public function OnDisplayProperties($oObject, WebPage $oPage, $bEditMode = false)
    {
        // Check if enabled
        if(ConfigHelper::IsEnabled() === false)
        {
            return;
        }

        $sModuleVersion = utils::GetCompiledModuleVersion(ConfigHelper::GetModuleCode());
        $sURLBase = utils::GetAbsoluteUrlModulesRoot() . '/' . ConfigHelper::GetModuleCode() . '/';

        // Add css files
        // Note: Here we pass the compiled .css file in order to be compatible with iTop 2.5 and earlier (utils::GetCSSFromSASS() refactoring)
        $oPage->add_linked_stylesheet($sURLBase . 'common/css/caselogs-toggler.css?v=' . $sModuleVersion);

        $sExpandTitle = Dict::S('Molkobain:CaselogsToggler:Entries:OpenAll');
        $sCollapseTitle = Dict::S('Molkobain:CaselogsToggler:Entries:CloseAll');

        // Instanciate widget on object's caselogs
        $oPage->add_ready_script(
<<<EOF
    // Molkobain caselogs toggler
    $(document).ready(function(){
        // Initializing widget
        $('fieldset > .caselog').each(function(){
            var me = $(this);
            var oExpandElem = $('<span class="mct-button fa fa-plus-square-o fa-lg" title="{$sExpandTitle}" data-toggle="tooltip"></span>');
            var oCollapseElem = $('<span class="mct-button fa fa-minus-square-o fa-lg" title="{$sCollapseTitle}" data-toggle="tooltip"></span>');
            
            // Bind listeners
            oExpandElem.on('click', function(){
                    me.find('.caselog_header').addClass('open');
                    me.find('.caselog_entry, .caselog_entry_html').show();
                })
                .qtip({ style: { name: 'molkobain-dark', tip: 'bottomMiddle' }, position: { corner: { target: 'topMiddle', tooltip: 'bottomMiddle' }, adjust: { y: -20 }} });
            oCollapseElem.on('click', function(){
                    me.find('.caselog_header').removeClass('open');
                    me.find('.caselog_entry, .caselog_entry_html').hide();
                })
                .qtip({ style: { name: 'molkobain-dark', tip: 'bottomMiddle' }, position: { corner: { target: 'topMiddle', tooltip: 'bottomMiddle' }, adjust: { y: -20 }} });
            
            var oWrapperElem = $('<span class="molkobain-caselogs-toggler"></span>');
            oWrapperElem
                .append(oExpandElem)
                .append('<span class="mct-separator">/</span>')
                .append(oCollapseElem);
                
            me.closest('fieldset').find('legend').append(oWrapperElem);
        });
    });
EOF

        );

        return;
    }

    /**
     * @inheritdoc
     */
    public function OnDisplayRelations($oObject, WebPage $oPage, $bEditMode = false)
    {
        // Do nothing
    }

    /**
     * @inheritdoc
     */
    public function OnFormSubmit($oObject, $sFormPrefix = '')
    {
        // Do nothing
    }

    /**
     * @inheritdoc
     */
    public function OnFormCancel($sTempId)
    {
        // Do nothing
    }

    /**
     * @inheritdoc
     */
    public function EnumUsedAttributes($oObject)
    {
        return array();
    }

    /**
     * @inheritdoc
     */
    public function GetIcon($oObject)
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function GetHilightClass($oObject)
    {
        // Possible return values are:
        // HILIGHT_CLASS_CRITICAL, HILIGHT_CLASS_WARNING, HILIGHT_CLASS_OK, HILIGHT_CLASS_NONE
        return HILIGHT_CLASS_NONE;
    }

    /**
     * @inheritdoc
     */
    public function EnumAllowedActions(DBObjectSet $oSet)
    {
        // No action
        return array();
    }
}
