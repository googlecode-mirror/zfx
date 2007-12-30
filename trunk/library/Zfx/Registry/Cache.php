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
 * Zend_Registry
 */
require_once 'Zend/Registry.php';

/**
 * Zend_Cache_Frontend_File
 */
require_once 'Zend/Cache.php';

/**
 * @category   Zfx
 * @package    Zfx_Registry
 * @copyright  Copyright (c) 2007 Netatoo FR S.A.R.L. (http://www.netatoo.fr)
 * @license    http://zfx.netatoo.fr/license/new-bsd     New BSD License
 * @uses 	   Zend_Registry
 */
class Zfx_Registry_Cache extends Zend_Registry
{   
	/**
	 * @var Zend_Cache_Core
	 */
	private static $_cache= null;
	
	/**
	 * Constructor
	 * 
	 * @param string $frontend frontend name
	 * @param string $backend backend name
	 * @param array $frontendOptions associative array of options for the corresponding frontend constructor
	 * @param array $backendOptions associative array of options for the corresponding backend constructor
	 * @return void
	 */
	public function __construct($frontendOptions = array(), $backendOptions = array()) 
	{
		// If 'master_file' is undefined, thrown an Exception
		if(!isset($frontendOptions['master_file'])) {
			require_once 'Zend/Exception.php';
			throw new Zend_Exception("You must define the 'master_file' frontend options !");
		}
		
		// If 'automatic_serialization' is undefined, set at TRUE by default
		if(!isset($frontendOptions['automatic_serialization'])) {
			$frontendOptions['automatic_serialization'] = true;
		}
		
		// Set Zend_Cache instance
		self::$_cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
	}
	
	/**
	 * Getter method for session namespace
	 *
	 * @return Zend_Session_Namespace
	 */
	public static function getCache()
	{
		return self::$_cache;
	}
	
	/**
	 * Defined by spl ArrayObject.
	 * Here we are redefining the action to point to the session namespace
	 * 
	 * @param string $index
	 * @return bool
	 */
	public function offsetExists($index) 
	{
		return (bool) isset(self::getSession()->$index);
	}
	
	/**
	 * Defined by spl ArrayObject.
	 * Here we are redefining the action to point to the session namespace
	 * 
	 * @param string $index
	 * @return bool
	 */
	public function offsetGet($index) 
	{
		return self::getSession()->$index;
	}

	/**
	 * Defined by spl ArrayObject.
	 * Here we are redefining the action to point to the session namespace
	 * 
	 * @param string $index
	 * @return bool
	 */
	public function offsetSet($index, $newval) 
	{
		if (self::$_session->isLocked()) {
		    self::$_session->unLock();
		}
		self::getSession()->$index = $newval;
		self::$_session->lock();
	}
} 