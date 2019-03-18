<?php

use \AKEB\services_json\Services_JSON;

error_reporting(E_ALL);

class Services_JSON_Spaces_Comments_TestCase extends PHPUnit\Framework\TestCase {

	function setUp() {
		$this->json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);

		$this->obj_j = '{"a_string":"\"he\":llo}:{world","an_array":[1,2,3],"obj":{"a_number":123}}';

		$this->obj_js = '{"a_string": "\"he\":llo}:{world",
						  "an_array":[1, 2, 3],
						  "obj": {"a_number":123}}';

		$this->obj_jc1 = '{"a_string": "\"he\":llo}:{world",
						  // here is a comment, hoorah
						  "an_array":[1, 2, 3],
						  "obj": {"a_number":123}}';

		$this->obj_jc2 = '/* this here is the sneetch */ "the sneetch"
						  // this has been the sneetch.';

		$this->obj_jc3 = '{"a_string": "\"he\":llo}:{world",
						  /* here is a comment, hoorah */
						  "an_array":[1, 2, 3 /* and here is another */],
						  "obj": {"a_number":123}}';

		$this->obj_jc4 = '{\'a_string\': "\"he\":llo}:{world",
						  /* here is a comment, hoorah */
						  \'an_array\':[1, 2, 3 /* and here is another */],
						  "obj": {"a_number":123}}';
	}

	function test_spaces()
	{
		$this->assertEquals($this->json->decode($this->obj_j), $this->json->decode($this->obj_js), "checking whether notation with spaces works");
	}

	function test_comments()
	{
		$this->assertEquals($this->json->decode($this->obj_j), $this->json->decode($this->obj_jc1), "checking whether notation with single line comments works");
		$this->assertEquals('the sneetch', $this->json->decode($this->obj_jc2), "checking whether notation with multiline comments works");
		$this->assertEquals($this->json->decode($this->obj_j), $this->json->decode($this->obj_jc3), "checking whether notation with multiline comments works");
		$this->assertEquals($this->json->decode($this->obj_j), $this->json->decode($this->obj_jc4), "checking whether notation with single-quotes and multiline comments works");
	}
}