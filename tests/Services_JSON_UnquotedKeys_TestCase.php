<?php

use \AKEB\services_json\Services_JSON;

error_reporting(E_ALL);

class Services_JSON_UnquotedKeys_TestCase extends PHPUnit\Framework\TestCase {

	protected $json;
	protected $arn;
	protected $arn_ja;
	protected $arn_d;
	protected $arrs;
	protected $arrs_jo;
	protected $arrs_d;

	protected function setUp(): void {
		$this->json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);

		$this->arn = array(0 => array(0 => 'tan', 'model' => 'sedan'), 1 => array(0 => 'red', 'model' => 'sports'));
		$this->arn_ja = '[{0:"tan","model":"sedan"},{"0":"red",model:"sports"}]';
		$this->arn_d = 'associative array with unquoted keys, nested associative arrays, and some numeric keys thrown in';

		$this->arrs = array(1 => 'one', 2 => 'two', 5 => 'fi"ve');
		$this->arrs_jo = '{"1":"one",2:"two","5":\'fi"ve\'}';
		$this->arrs_d = 'associative array with unquoted keys, single-quoted values, numeric keys which are not fully populated in a range of 0 to length-1';
	}

	function test_from_JSON() {
		// ...unless the input array has some numeric indeces, in which case the behavior is to degrade to a regular array
		$this->assertEquals($this->arn, $this->json->decode($this->arn_ja), "array case - strict: {$this->arn_d}");

		// Test a sparsely populated numerically indexed associative array
		$this->assertEquals($this->arrs, $this->json->decode($this->arrs_jo), "sparse numeric assoc array: {$this->arrs_d}");
	}
}