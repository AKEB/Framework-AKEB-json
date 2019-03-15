<?php  // $Id$

use \AKEB\services_json\Services_JSON;

error_reporting(E_ALL);

class Services_JSON_ErrorSuppression_TestCase extends PHPUnit\Framework\TestCase {

	function setUp() {
		$this->json = new Services_JSON();
		$this->json_ = new Services_JSON(SERVICES_JSON_SUPPRESS_ERRORS);

		$this->res = tmpfile();
		$this->res_j_ = 'null';
		$this->res_d = 'naked resource';

		$this->arr = array('a', 1, tmpfile());
		$this->arr_j_ = '["a",1,null]';
		$this->arr_d = 'array with string, number and resource';

		$obj = new \stdClass();
		$obj->a_string = '"he":llo}:{world';
		$obj->an_array = array(1, 2, 3);
		$obj->resource = tmpfile();

		$this->obj = $obj;
		$this->obj_j_ = '{"a_string":"\"he\":llo}:{world","an_array":[1,2,3],"resource":null}';
		$this->obj_d = 'object with properties, array, and nested resource';
	}

	function test_to_JSON()
	{
		$this->assertTrue(Services_JSON::isError($this->json->encode($this->res)), "resource case: {$this->res_d}");
		$this->assertTrue(Services_JSON::isError($this->json->encode($this->arr)), "array case: {$this->arr_d}");
		$this->assertTrue(Services_JSON::isError($this->json->encode($this->obj)), "object case: {$this->obj_d}");
	}

	function test_to_JSON_suppressed()
	{
		$this->assertEquals($this->res_j_, $this->json_->encode($this->res), "resource case: {$this->res_d}");
		$this->assertEquals($this->arr_j_, $this->json_->encode($this->arr), "array case: {$this->arr_d}");
		$this->assertEquals($this->obj_j_, $this->json_->encode($this->obj), "object case: {$this->obj_d}");
	}
}