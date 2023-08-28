<?php

use \AKEB\services_json\Services_JSON;

error_reporting(E_ALL);

class Services_JSON_Object_TestCase extends PHPUnit\Framework\TestCase {

	protected $json_l;
	protected $json_s;
	protected $obj_j;
	protected $obj1;
	protected $obj1_j;
	protected $obj1_d;

	protected function setUp(): void {
		$this->json_l = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
		$this->json_s = new Services_JSON();

		$this->obj_j = '{"a_string":"\"he\":llo}:{world","an_array":[1,2,3],"obj":{"a_number":123}}';

		$car1 = (object)[
			'color' => 'tan',
			'model' => 'sedan',
		];
		$car2 = (object)[
			'color' => 'red',
			'model' => 'sports',
		];
		$this->obj1 = (object)[
			'car1' => $car1,
			'car2' => $car2
		];
		$this->obj1_j = '{"car1":{"color":"tan","model":"sedan"},"car2":{"color":"red","model":"sports"}}';
		$this->obj1_d = 'Object with nested objects';
	}

	function test_type()
	{
		$this->assertEquals('object', gettype($this->json_s->decode($this->obj_j)), "checking whether decoded type is object");
		$this->assertEquals('array',  gettype($this->json_l->decode($this->obj_j)), "checking whether decoded type is array");
	}

	function test_to_JSON()
	{
		$this->assertEquals($this->obj1_j, $this->json_s->encode($this->obj1), "object - strict: {$this->obj1_d}");
		$this->assertEquals($this->obj1_j, $this->json_l->encode($this->obj1), "object - loose: {$this->obj1_d}");
	}

	function test_from_then_to_JSON()
	{
		$this->assertEquals($this->obj_j, $this->json_s->encode($this->json_s->decode($this->obj_j)), "object case");
		$this->assertEquals($this->obj_j, $this->json_l->encode($this->json_l->decode($this->obj_j)), "array case");
	}
}

