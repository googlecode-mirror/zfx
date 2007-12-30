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
 * Zend_Session_Namespace
 */
require_once 'Zend/Session/Namespace.php';

/**
 * @category   Zfx
 * @package    Zfx_Registry
 * @copyright  Copyright (c) 2007 Netatoo FR S.A.R.L. (http://www.netatoo.fr)
 * @license    http://zfx.netatoo.fr/license/new-bsd     New BSD License
 * @uses 	   Zend_Registry
 */
class Zfx_Registry_Session extends Zend_Registry
{
	/**
	 * @var Zend_Session_Namespace
	 */
	private static $_session = null;
	
	/**
	 * @var string
	 */
	private static $_namespace = 'Zfx_Registry_Session';
    
	/**
	 * Constructor, set optionnaly custom expiration seconds
	 * 
	 * @param int $expirationSeconds
	 * @return void
	 */
	public function __construct($namespace = 'Zfx_Registry_Session', $expirationSeconds = 1800) 
	{
		self::$_namespace = $namespace;
		self::$_session = new Zend_Session_Namespace($namespace);
		self::$_session->setExpirationSeconds($expirationSeconds);
		self::$_session->lock();
	}
	
	/**
     * Getter method for session namespace
     *
     * @return Zend_Session_Namespace
     */
    public static function getSession()
    {
        return self::$_session;
    }
    
	/**
     * Unset the default registry instance.
     * Primarily used in tearDown() in unit tests.
     * @returns void
     */
    public static function _unsetInstance()
    {
        self::getSession()->unsetAll();
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
} 