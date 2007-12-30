<?php
/**
 * Zfx (Zend Framework Xtensions)
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://zfx.netatoo.fr/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to support@netatoo.fr so we can send you a copy immediately.
 *
 * @category   Zfx
 * @package    Zfx_Registry
 * @copyright  Copyright (c) 2007 Netatoo FR S.A.R.L. (http://www.netatoo.fr)
 * @license    http://zfx.netatoo.fr/license/new-bsd     New BSD License
 */

/**
 * Zfx_Regisry_Session
 */
require_once 'Zfx/Registry/Session.php';

/**
 * Zend_Debug
 */
require_once 'Zend/Debug.php';

/**
 * It's very simple to use Zfx_Registry_Session, simply defining the forum in Zend_Registry.
 * Thus, Zfx_Registry_Session registry will supplant the basics:
 */
Zend_Registry::setInstance(new Zfx_Registry_Session('MyNamespace', 3600));

/**
 * No specific change in the use of the Zend_Registry :
 */
Zend_Registry::set('testString', 'ok');
Zend_Registry::set('testArray', array(
	'key1'	=> 'value1',
	'key2'	=> 'value2',
	'key3'	=> 'value3'
));


Zend_Debug::dump(Zend_Registry::get('testString'));
Zend_Debug::dump(Zend_Registry::get('testArray'));

/**
 * We see through a dump of the session, that the data that we have added to 
 * the registry above were registered in the session namespace 'MyNamespace'.
 */
Zend_Debug::dump($_SESSION);