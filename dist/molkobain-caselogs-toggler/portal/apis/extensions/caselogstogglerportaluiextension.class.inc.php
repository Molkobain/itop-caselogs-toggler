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

namespace Molkobain\iTop\Portal\CaselogsToggler\Extension;

use utils;
use Dict;
use MetaModel;
use AbstractPortalUIExtension;
use Silex\Application;

/**
 * Class CaselogsTogglerPortalUIExtension
 *
 * @package Molkobain\iTop\Portal\CaselogsToggler\Extension
 */
class CaselogsTogglerPortalUIExtension extends AbstractPortalUIExtension
{
    const MODULE_CODE = 'molkobain-caselogs-toggler';

    const DEFAULT_ENABLED = true;

    /**
     * @inheritdoc
     */
    public function GetCSSFiles(Application $oApp)
    {
        $sModuleVersion = utils::GetCompiledModuleVersion(static::MODULE_CODE);
        $sURLBase = utils::GetAbsoluteUrlModulesRoot() . '/' . static::MODULE_CODE . '/';

        $aReturn = array(
            $sURLBase . 'common/css/caselogs-toggler.css?v=' . $sModuleVersion,
        );

        return $aReturn;
    }

    /**
     * @inheritdoc
     */
    public function GetJSFiles(Application $oApp)
    {
        $aJSFiles = array();

        return $aJSFiles;
    }

    /**
     * @inheritdoc
     *
     * @throws \DictExceptionMissingString
     */
    public function GetJSInline(Application $oApp)
    {
        // Check if enabled
        if(MetaModel::GetConfig()->GetModuleSetting(static::MODULE_CODE, 'enabled', static::DEFAULT_ENABLED) === false)
        {
            return '';
        }

        $sExpandTitle = Dict::S('Molkobain:CaselogsToggler:Entries:OpenAll');
        $sCollapseTitle = Dict::S('Molkobain:CaselogsToggler:Entries:CloseAll');

        $sJSInline =
<<<EOF

// Molkobain caselogs toggler
function InstanciateCaselogsToggler(oElem)
{
    var me = oElem;
    var oExpandElem = $('<span class="mct-button fa fa-envelope-open-o" title="{$sExpandTitle}" data-toggle="tooltip"></span>');
    var oCollapseElem = $('<span class="mct-button fa fa-envelope-o" title="{$sCollapseTitle}" data-toggle="tooltip"></span>');
    
    // Bind listeners
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
    
    var oWrapperElem = $('<span class="molkobain-caselogs-toggler"></span>');
    oWrapperElem
        .append(oExpandElem)
        .append('<span class="mct-separator">-</span>')
        .append(oCollapseElem);
        
    me.find('.form_field_label label').append(oWrapperElem);
}

// Instanciate widget on modals
$('body').on('loaded.bs.modal', function (oEvent) {
    var oForm = $(oEvent.target).find('.modal-content form');
    if(oForm.length > 0)
    {
        if(oForm.find('.field_set .form_field_control .caselog_field_entry:first').length > 0)
        {
            InstanciateCaselogsToggler(oForm.find('.field_set .form_field_control .caselog_field_entry:first').closest('.form-group'));
        }
    }
    
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
