<?php
/**
 * @package     Joomla.UnitTest
 * @subpackage  Client
 *
 * @copyright   Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

require_once JPATH_PLATFORM.'/joomla/client/github.php';
require_once JPATH_PLATFORM.'/joomla/client/github/gists.php';

/**
 * Test class for JLDAP.
 * Generated by PHPUnit on 2009-10-08 at 21:48:52.
 */
class JGithubGistsTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @access protected
	 */
	protected function setUp()
	{
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @access protected
	 */
	protected function tearDown()
	{
	}

	public function paginateData()
	{
		return array(
			'No query string, no page, no per page' => array('/gists/test', 0, 0, '/gists/test'),
			'No query string, no page, per page' => array('/gists/test', 0, 50, '/gists/test?per_page=50'),
			'No query string, page, no per page' => array('/gists/test', 5, 0, '/gists/test?page=5'),
			'No query string, page, per page' => array('/gists/test', 5, 30, '/gists/test?page=5&per_page=30'),
			'Query String, no page, no per page' => array('/gists/test?foo=bar', 0, 0, '/gists/test?foo=bar'),
			'Query String, no page, per page' => array('/gists/test?foo=bar', 0, 50, '/gists/test?foo=bar&per_page=50'),
			'Query String, page, no per page' => array('/gists/test?foo=bar', 5, 0, '/gists/test?foo=bar&page=5'),
			'Query String, page, per page' => array('/gists/test?foo=bar', 5, 30, '/gists/test?foo=bar&page=5&per_page=30')
		);
	}

	protected function getMethod($name)
	{
		$class = new ReflectionClass('JGithubGists');
		$method = $class->getMethod($name);
		$method->setAccessible(true);
		return $method;
	}

	/**
	 * Tests the paginate method
	 * 
	 * @dataProvider paginateData
	 */
	public function testPaginate($url, $page, $per_page, $expected)
	{
		$method = $this->getMethod('paginate');
		
		$object = new JGithubGists(null);
		$this->assertEquals($expected, $method->invokeArgs($object, array($url, $page, $per_page)));
	}

	/**
	 * Tests the getAll method
	 */
	public function testGetAll()
	{
		
		$connector = $this->getMock('sendRequest', array('sendRequest'));

		$gists = new JGithubGists($connector);
		$returnData = array('Returned');
		$connector->expects($this->once())
			->method('sendRequest')
			->with('/gists')
			->will($this->returnValue($returnData));

		$this->assertThat(
			$gists->getAll(),
			$this->equalTo($returnData),
			'Get gists not called with the proper arguments'
		);
	}

	/**
	 * Tests the getByUser method
	 */
	public function testGetByUser()
	{
		$connector = $this->getMock('sendRequest', array('sendRequest'));

		require_once JPATH_PLATFORM.'/joomla/client/github/gists.php';
		$gists = new JGithubGists($connector);
		$returnData = array('Returned');
		$connector->expects($this->once())
			->method('sendRequest')
			->with('/users/testUser/gists')
			->will($this->returnValue($returnData));

		$this->assertThat(
			$gists->getByUser('testUser'),
			$this->equalTo($returnData),
			'Get gists by user not called with the proper arguments'
		);
	}

}
