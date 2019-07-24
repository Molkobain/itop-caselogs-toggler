<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

//
// iTop module definition file
//

/** @noinspection PhpUnhandledExceptionInspection */
SetupWebPage::AddModule(
	__FILE__, // Path to the current file, all other file names are relative to the directory containing this file
	'molkobain-caselogs-toggler/1.4.1',
	array(
		// Identification
		//
		'label' => 'Caselog entries toggler',
		'category' => 'ui',

		// Setup
		//
		'dependencies' => array(
			'molkobain-handy-framework/1.2.4',
			'molkobain-fontawesome5-pack/1.1.1',
			'molkobain-newsroom-provider/1.0.1',
		),
		'mandatory' => false,
		'visible' => true,

		// Components
		//
		'datamodel' => array(
		    'common/confighelper.class.inc.php',
		    'console/applicationuiextension.class.inc.php',
            'portal/apis/extensions/portaluiextension.class.inc.php',
		),
		'webservice' => array(

		),
		'data.struct' => array(
			// add your 'structure' definition XML files here,
		),
		'data.sample' => array(
			// add your sample data XML files here,
		),

		// Documentation
		//
		'doc.manual_setup' => '', // hyperlink to manual setup documentation, if any
		'doc.more_information' => '', // hyperlink to more information, if any

		// Default settings
		//
		'settings' => array(
			// Module specific settings go here, if any
            'enabled' => true,
		),
	)
);
