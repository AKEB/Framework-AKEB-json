<?php // $Id$

use \AKEB\services_json\Services_JSON;

error_reporting(E_ALL);

class Services_JSON_NestedArray_TestCase extends PHPUnit\Framework\TestCase {

	function setUp() {
		$this->json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);

		$this->str1 = '[{"this":"that"}]';
		$this->arr1 = array(array('this' => 'that'));

		$this->str2 = '{"this":["that"]}';
		$this->arr2 = array('this' => array('that'));

		$this->str3 = '{"params":[{"foo":["1"],"bar":"1"}]}';
		$this->arr3 = array('params' => array(array('foo' => array('1'), 'bar' => '1')));

		$this->str4 = '{"0": {"foo": "bar", "baz": "winkle"}}';
		$this->arr4 = array('0' => array('foo' => 'bar', 'baz' => 'winkle'));

		$this->str5 = '{"params":[{"options": {"old": [ ], "new": {"0": {"elements": {"old": [], "new": {"0": {"elementName": "aa", "isDefault": false, "elementRank": "0", "priceAdjust": "0", "partNumber": ""}}}, "optionName": "aa", "isRequired": false, "optionDesc": null}}}}]}';
		$this->arr5 = array (
		  'params' => array (
			0 => array (
			  'options' =>
			  array (
				'old' => array(),
				'new' => array (
				  0 => array (
					'elements' => array (
					  'old' => array(),
					  'new' => array (
						0 => array (
						  'elementName' => 'aa',
						  'isDefault' => false,
						  'elementRank' => '0',
						  'priceAdjust' => '0',
						  'partNumber' => '',
						),
					  ),
					),
					'optionName' => 'aa',
					'isRequired' => false,
					'optionDesc' => NULL,
				  ),
				),
			  ),
			),
		  ),
		);
	}

	function test_type()
	{
		$this->assertEquals('array', gettype($this->json->decode($this->str1)), "loose type should be array");
		$this->assertEquals('array', gettype($this->json->decode($this->str2)), "loose type should be array");
		$this->assertEquals('array', gettype($this->json->decode($this->str3)), "loose type should be array");
	}

	function test_from_JSON()
	{
		$this->assertEquals($this->arr1, $this->json->decode($this->str1), "simple compactly-nested array");
		$this->assertEquals($this->arr2, $this->json->decode($this->str2), "simple compactly-nested array");
		$this->assertEquals($this->arr3, $this->json->decode($this->str3), "complex compactly nested array");
		$this->assertEquals($this->arr4, $this->json->decode($this->str4), "complex compactly nested array");
		$this->assertEquals($this->arr5, $this->json->decode($this->str5), "super complex compactly nested array");
	}

	function _test_from_JSON()
	{
		$super = '{"params":[{"options": {"old": {}, "new": {"0": {"elements": {"old": {}, "new": {"0": {"elementName": "aa", "isDefault": false, "elementRank": "0", "priceAdjust": "0", "partNumber": ""}}}, "optionName": "aa", "isRequired": false, "optionDesc": ""}}}}]}';
		print("trying {$super}...\n");
		print var_export($this->json->decode($super));
	}
}