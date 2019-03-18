<?php

use \AKEB\services_json\Services_JSON;

error_reporting(E_ALL);

class Services_JSON_AssocArray_TestCase extends PHPUnit\Framework\TestCase {

	function setUp() {
		$this->json_l = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
		$this->json_s = new Services_JSON();

		$this->arr = array('car1'=> array('color'=> 'tan', 'model' => 'sedan'),
			'car2' => array('color' => 'red', 'model' => 'sports'));
		$this->arr_jo = '{"car1":{"color":"tan","model":"sedan"},"car2":{"color":"red","model":"sports"}}';
		$this->arr_d = 'associative array with nested associative arrays';

		$this->arn = array(0=> array(0=> 'tan\\', 'model\\' => 'sedan'), 1 => array(0 => 'red', 'model' => 'sports'));
		$this->arn_ja = '[{"0":"tan\\\\","model\\\\":"sedan"},{"0":"red","model":"sports"}]';
		$this->arn_d = 'associative array with nested associative arrays, and some numeric keys thrown in';

		$this->arrs = array (1 => 'one', 2 => 'two', 5 => 'five');
		$this->arrs_jo = '{"1":"one","2":"two","5":"five"}';
		$this->arrs_d = 'associative array numeric keys which are not fully populated in a range of 0 to length-1';
	}

	function test_type()
	{
		$this->assertEquals('array',  gettype($this->json_l->decode($this->arn_ja)), "loose type should be array");
		$this->assertEquals('array',  gettype($this->json_s->decode($this->arn_ja)), "strict type should be array");
	}

	function test_to_JSON()
	{
		// both strict and loose JSON should result in an object
		$this->assertEquals($this->arr_jo, $this->json_l->encode($this->arr), "array case - loose: {$this->arr_d}");
		$this->assertEquals($this->arr_jo, $this->json_s->encode($this->arr), "array case - strict: {$this->arr_d}");

		// ...unless the input array has some numeric indeces, in which case the behavior is to degrade to a regular array
		$this->assertEquals($this->arn_ja, $this->json_s->encode($this->arn), "array case - strict: {$this->arn_d}");

		// Test a sparsely populated numerically indexed associative array
		$this->assertEquals($this->arrs_jo, $this->json_l->encode($this->arrs), "sparse numeric assoc array: {$this->arrs_d}");
	}
}