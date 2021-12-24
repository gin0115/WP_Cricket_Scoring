<?php

declare(strict_types=1);

/**
 * Unit tests for Plugin Settings Form Handlers, validation class.
 *
 * @since 0.1.0
 * @author GLynn Quelch <glynn.quelch@gmail.com>
 */

namespace Gin0115\WP_Cricket_Scoring\Tests\Unit\Admin\Page\Form\Validator;

use WP_UnitTestCase;
use Gin0115\WPUnit_Helpers\Objects;
use Gin0115\WP_Cricket_Scoring\Admin\Form\Validator\Settings_Validator;

class Test_Settings_Validator extends WP_UnitTestCase {

	/** @testdox The value set for the LIVE SCORE POLL INTERVAL, must be defined, be numerical and above 0 in value */
	public function test_live_score_poll_interval() {
		$validator = new Settings_Validator();
		$settings  = Objects::invoke_method( $validator, 'rule_set' );
		$this->assertArrayHasKey( 'live_score_poll_interval', $settings );

		// [value, has errors, error count][]
		$cases = array(
			array( 'string', true, 1 ),
			array( -25, true, 1 ),
			array( array( 49, 'f' ), true, 1 ),
			array( '15', false, 0 ),
		);
		foreach ( $cases as list($value, $has_errors, $error_count) ) {
			$rule = clone $settings['live_score_poll_interval'];
			$rule->check( $value );

			$this->assertSame( $has_errors, $rule->has_errors() );
			$this->assertCount( $error_count, $rule->errors() );
		}
	}
}
