<?php

declare(strict_types=1);

/**
 * Unit tests for settings page load/update event
 *
 * @since 0.1.0
 * @author GLynn Quelch <glynn.quelch@gmail.com>
 */

namespace Gin0115\WP_Cricket_Scoring\Tests\Unit\Admin\Page\Form\Validator;

use WP_UnitTestCase;
use Gin0115\WPUnit_Helpers\Objects;
use Gin0115\WP_Cricket_Scoring\Admin\Form\Validator\Rule;

class Test_Rule extends WP_UnitTestCase {

	/** @testdox It should be possible to create a rule using a static constructor. */
	public function test_can_create_with_static(): void {
		$rule = Rule::create();
		$this->assertInstanceOf( Rule::class, $rule );
	}

	/** @testdox It should be possible to pass assertion and failure messages when constructing the rule. */
	public function test_can_construct_with_assertions(): void {
		$assertions = array(
			array(
				'assertion' => 'is_string',
				'message'   => 'message',
			),
			array(
				'assertion' => 'is_string',
				'message'   => 'message',
			),
		);

		$rule = new Rule( ...$assertions );
		$this->assertEquals( $assertions, Objects::get_property( $rule, 'assertion' ) );
	}

	/** @testdox It should be possible to add assertions using a fluent api */
	public function test_can_add_assertion_with_fluent_api(): void {
		$rule = Rule::create()
			->assert( 'is_float', 'value should be a float' );

		$expected = array(
			array(
				'assertion' => 'is_float',
				'message'   => 'value should be a float',
			),
		);

		$this->assertEquals( $expected, Objects::get_property( $rule, 'assertion' ) );
	}

	/** @testdox It should be possible to validate if a value passes the rules assertions */
	public function test_should_validate_a_value(): void {
		/** value | generate error */
		$cases = array(
			array( 1, true ),
			array( 1.3, false ),
			array( '1.3', true ),
			array( array( '1.3' ), true ),
			array( null, true ),
			array( true, true ),
		);

		foreach ( $cases as list($value, $has_errors) ) {
			$rule = Rule::create()
				->assert( 'is_float', 'value should be a float' )
				->check( $value );
			$this->assertSame( $has_errors, $rule->has_errors() );
		}
	}

	/** @testdox It should be possible to stack assertions and get error messages for each that fails. */
	public function test_can_use_multiple_validation_rules(): void {
		$cases = array(
			array( 'not array', 2 ),
			array( array( 'small array' ), 1 ),
			array( array( 'correct', 'sized', 'array' ), 0 ),
		);

		foreach ( $cases as list($value, $error_count) ) {
			$rule = Rule::create()
				->assert( 'is_array', 'should be an array' )
				->assert( fn( $e) => count( $e ) === 3, 'must have 3 values' )
				->check( $value );
			$this->assertCount( $error_count, $rule->errors() );
		}
	}

	/** @testdox Any errors or exceptions thrown while running assertion should be caught and added to the error stack, but continue with checks. */
	public function test_catch_exception_log_as_failure(): void {
		$rule = Rule::create()
			->assert( 'count', 'will throw error if not countable.' )
			->check( true );

		$this->assertEquals(
			'count(): Parameter must be an array or an object that implements Countable',
			$rule->errors()[0]
		);
	}

	/** @testdox It should be possible to check if any errors where thrown */
	public function test_can_check_if_has_errors(): void {
		$rule = Rule::create()
			->assert( 'is_string', 'is-string' )
			->check( true );

		$this->assertTrue( $rule->has_errors() );

		$rule = Rule::create()
			->assert( 'is_string', 'is-string' )
			->check( 'hello' );

		$this->assertFalse( $rule->has_errors() );
	}

    /** @testdox It should be possible to access any error messages */
    public function test_can_get_errors(): void
    {
        $rule = Rule::create()
			->assert( 'is_string', 'error message 1' )
			->assert( 'is_float', 'error message 2' )
			->check( true );

        $errors = $rule->errors();
        $this->assertCount(2, $errors);
        $this->assertContains('error message 1', $errors);
        $this->assertContains('error message 2', $errors);
    }
}
