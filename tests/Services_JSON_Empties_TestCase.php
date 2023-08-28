<?php

use \AKEB\services_json\Services_JSON;

error_reporting(E_ALL);
class Services_JSON_Empties_TestCase extends PHPUnit\Framework\TestCase {

	protected function setUp(): void {
		$this->json_l = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
		$this->json_s = new Services_JSON();

		$this->obj0_j = '{}';
		$this->arr0_j = '[]';

		$this->obj1_j = '{ }';
		$this->arr1_j = '[ ]';

		$this->obj2_j = '{ /* comment inside */ }';
		$this->arr2_j = '[ /* comment inside */ ]';
	}

	function test_type()
	{
		$this->assertEquals('array',   gettype($this->json_l->decode($this->arr0_j)), "should be array");
		$this->assertEquals('object',  gettype($this->json_s->decode($this->obj0_j)), "should be object");

		$this->assertEquals(0,  count($this->json_l->decode($this->arr0_j)), "should be empty array");
		$this->assertEquals(0,  count(get_object_vars($this->json_s->decode($this->obj0_j))), "should be empty object");

		$this->assertEquals('array',   gettype($this->json_l->decode($this->arr1_j)), "should be array, even with space");
		$this->assertEquals('object',  gettype($this->json_s->decode($this->obj1_j)), "should be object, even with space");

		$this->assertEquals(0,  count($this->json_l->decode($this->arr1_j)), "should be empty array, even with space");
		$this->assertEquals(0,  count(get_object_vars($this->json_s->decode($this->obj1_j))), "should be empty object, even with space");

		$this->assertEquals('array',   gettype($this->json_l->decode($this->arr2_j)), "should be array, despite comment");
		$this->assertEquals('object',  gettype($this->json_s->decode($this->obj2_j)), "should be object, despite comment");

		$this->assertEquals(0,  count($this->json_l->decode($this->arr2_j)), "should be empty array, despite comment");
		$this->assertEquals(0,  count(get_object_vars($this->json_s->decode($this->obj2_j))), "should be empty object, despite commentt");
	}
}