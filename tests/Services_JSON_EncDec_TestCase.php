<?php

use \AKEB\services_json\Services_JSON;

error_reporting(E_ALL);
class Services_JSON_EncDec_TestCase extends PHPUnit\Framework\TestCase {

	function setUp() {
		$this->json = new Services_JSON();
		$obj = new \stdClass();
		$obj->a_string = '"he":llo}:{world';
		$obj->an_array = array(1, 2, 3);
		$obj->obj = new \stdClass();
		$obj->obj->a_number = 123;

		$this->obj = $obj;
		$this->obj_j = '{"a_string":"\"he\":llo}:{world","an_array":[1,2,3],"obj":{"a_number":123}}';
		$this->obj_d = 'object with properties, nested object and arrays';

		$this->arr = array(null, true, array(1, 2, 3), "hello\"],[world!");
		$this->arr_j = '[null,true,[1,2,3],"hello\"],[world!"]';
		$this->arr_d = 'array with elements and nested arrays';

		$this->str1 = 'hello world';
		$this->str1_j = '"hello world"';
		$this->str1_j_ = "'hello world'";
		$this->str1_d = 'hello world';
		$this->str1_d_ = 'hello world, double quotes';

		$this->str2 = "hello\t\"world\"";
		$this->str2_j = '"hello\\t\\"world\\""';
		$this->str2_d = 'hello world, with tab, double-quotes';

		$this->str3 = "\\\r\n\t\"/";
		$this->str3_j = '"\\\\\\r\\n\\t\\"\\/"';
		$this->str3_d = 'backslash, return, newline, tab, double-quote';

		$this->str4 = 'héllö wørłd';
		$this->str4_j = '"h\u00e9ll\u00f6 w\u00f8r\u0142d"';
		$this->str4_j_ = '"héllö wørłd"';
		$this->str4_d = 'hello world, with unicode';
	}

	function test_to_JSON() {
		$this->assertEquals('null', $this->json->encode(null), 'type case: null');
		$this->assertEquals('true', $this->json->encode(true), 'type case: boolean true');
		$this->assertEquals('false', $this->json->encode(false), 'type case: boolean false');

		$this->assertEquals('1', $this->json->encode(1), 'numeric case: 1');
		$this->assertEquals('-1', $this->json->encode(-1), 'numeric case: -1');
		$this->assertEquals('1.000000', $this->json->encode(1.0), 'numeric case: 1.0');
		$this->assertEquals('1.100000', $this->json->encode(1.1), 'numeric case: 1.1');

		$this->assertEquals($this->str1_j, $this->json->encode($this->str1), "string case: {$this->str1_d}");
		$this->assertEquals($this->str2_j, $this->json->encode($this->str2), "string case: {$this->str2_d}");
		$this->assertEquals($this->str3_j, $this->json->encode($this->str3), "string case: {$this->str3_d}");
		$this->assertEquals($this->str4_j, $this->json->encode($this->str4), "string case: {$this->str4_d}");

		$this->assertEquals($this->arr_j, $this->json->encode($this->arr), "array case: {$this->arr_d}");
		$this->assertEquals($this->obj_j, $this->json->encode($this->obj), "object case: {$this->obj_d}");
	}

	function test_from_JSON() {
		$this->assertEquals(null, $this->json->decode('null'), 'type case: null');
		$this->assertEquals(true, $this->json->decode('true'), 'type case: boolean true');
		$this->assertEquals(false, $this->json->decode('false'), 'type case: boolean false');

		$this->assertEquals(1, $this->json->decode('1'), 'numeric case: 1');
		$this->assertEquals(-1, $this->json->decode('-1'), 'numeric case: -1');
		$this->assertEquals(1.0, $this->json->decode('1.0'), 'numeric case: 1.0');
		$this->assertEquals(1.1, $this->json->decode('1.1'), 'numeric case: 1.1');

		$this->assertEquals(11.0, $this->json->decode('1.1e1'), 'numeric case: 1.1e1');
		$this->assertEquals(11.0, $this->json->decode('1.10e+1'), 'numeric case: 1.10e+1');
		$this->assertEquals(0.11, $this->json->decode('1.1e-1'), 'numeric case: 1.1e-1');
		$this->assertEquals(-0.11, $this->json->decode('-1.1e-1'), 'numeric case: -1.1e-1');

		$this->assertEquals($this->str1, $this->json->decode($this->str1_j),  "string case: {$this->str1_d}");
		$this->assertEquals($this->str1, $this->json->decode($this->str1_j_), "string case: {$this->str1_d_}");
		$this->assertEquals($this->str2, $this->json->decode($this->str2_j),  "string case: {$this->str2_d}");
		$this->assertEquals($this->str3, $this->json->decode($this->str3_j),  "string case: {$this->str3_d}");
		$this->assertEquals($this->str4, $this->json->decode($this->str4_j),  "string case: {$this->str4_d}");
		$this->assertEquals($this->str4, $this->json->decode($this->str4_j_),  "string case: {$this->str4_d}");

		$this->assertEquals($this->arr, $this->json->decode($this->arr_j), "array case: {$this->arr_d}");
		$this->assertEquals($this->obj, $this->json->decode($this->obj_j), "object case: {$this->obj_d}");
	}

	function test_to_then_from_JSON() {
		$this->assertEquals(null, $this->json->decode($this->json->encode(null)), 'type case: null');
		$this->assertEquals(true, $this->json->decode($this->json->encode(true)), 'type case: boolean true');
		$this->assertEquals(false, $this->json->decode($this->json->encode(false)), 'type case: boolean false');

		$this->assertEquals(1, $this->json->decode($this->json->encode(1)), 'numeric case: 1');
		$this->assertEquals(-1, $this->json->decode($this->json->encode(-1)), 'numeric case: -1');
		$this->assertEquals(1.0, $this->json->decode($this->json->encode(1.0)), 'numeric case: 1.0');
		$this->assertEquals(1.1, $this->json->decode($this->json->encode(1.1)), 'numeric case: 1.1');

		$this->assertEquals($this->str1, $this->json->decode($this->json->encode($this->str1)), "string case: {$this->str1_d}");
		$this->assertEquals($this->str2, $this->json->decode($this->json->encode($this->str2)), "string case: {$this->str2_d}");
		$this->assertEquals($this->str3, $this->json->decode($this->json->encode($this->str3)), "string case: {$this->str3_d}");
		$this->assertEquals($this->str4, $this->json->decode($this->json->encode($this->str4)), "string case: {$this->str4_d}");

		$this->assertEquals($this->arr, $this->json->decode($this->json->encode($this->arr)), "array case: {$this->arr_d}");
		$this->assertEquals($this->obj, $this->json->decode($this->json->encode($this->obj)), "object case: {$this->obj_d}");
	}

	function test_from_then_to_JSON() {
		$this->assertEquals('null', $this->json->encode($this->json->decode('null')), 'type case: null');
		$this->assertEquals('true', $this->json->encode($this->json->decode('true')), 'type case: boolean true');
		$this->assertEquals('false', $this->json->encode($this->json->decode('false')), 'type case: boolean false');

		$this->assertEquals('1', $this->json->encode($this->json->decode('1')), 'numeric case: 1');
		$this->assertEquals('-1', $this->json->encode($this->json->decode('-1')), 'numeric case: -1');
		$this->assertEquals('1.0', $this->json->encode($this->json->decode('1.0')), 'numeric case: 1.0');
		$this->assertEquals('1.1', $this->json->encode($this->json->decode('1.1')), 'numeric case: 1.1');

		$this->assertEquals($this->str1_j, $this->json->encode($this->json->decode($this->str1_j)), "string case: {$this->str1_d}");
		$this->assertEquals($this->str2_j, $this->json->encode($this->json->decode($this->str2_j)), "string case: {$this->str2_d}");
		$this->assertEquals($this->str3_j, $this->json->encode($this->json->decode($this->str3_j)), "string case: {$this->str3_d}");
		$this->assertEquals($this->str4_j, $this->json->encode($this->json->decode($this->str4_j)), "string case: {$this->str4_d}");
		$this->assertEquals($this->str4_j, $this->json->encode($this->json->decode($this->str4_j_)), "string case: {$this->str4_d}");

		$this->assertEquals($this->arr_j, $this->json->encode($this->json->decode($this->arr_j)), "array case: {$this->arr_d}");
		$this->assertEquals($this->obj_j, $this->json->encode($this->json->decode($this->obj_j)), "object case: {$this->obj_d}");
	}
}