<?php
/**
 * Copyright (c) 2015 - 2018 Molkobain.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Molkobain\iTop\CaselogsToggler\Console\Extension;

use utils;
use Dict;
use MetaModel;
use DBObjectSet;
use WebPage;
use iApplicationUIExtension;
use Molkobain\iTop\CaselogsToggler\Common\Helper\ConfigHelper;

/**
 * Class ConsoleUIExtension
 *
 * @package Molkobain\iTop\CaselogsToggler\Console\Extension
 */
class ConsoleUIExtension implements iApplicationUIExtension
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
                .qtip({ style: { name: 'dark', tip: 'bottomMiddle' }, position: { corner: { target: 'topMiddle', tooltip: 'bottomMiddle' }, adjust: { y: -20 }} });
            oCollapseElem.on('click', function(){
                    me.find('.caselog_header').removeClass('open');
                    me.find('.caselog_entry, .caselog_entry_html').hide();
                })
                .qtip({ style: { name: 'dark', tip: 'bottomMiddle' }, position: { corner: { target: 'topMiddle', tooltip: 'bottomMiddle' }, adjust: { y: -20 }} });
            
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
