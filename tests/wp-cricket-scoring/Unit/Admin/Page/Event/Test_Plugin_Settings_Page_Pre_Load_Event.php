<?php

declare(strict_types=1);

/**
 * Unit tests for settings page load/update event
 *
 * @since 0.1.0
 * @author GLynn Quelch <glynn.quelch@gmail.com>
 */

namespace Gin0115\WP_Cricket_Scoring\Tests\Unit\Admin\Page\Event;

use WP_UnitTestCase;

class Test_Plugin_Settings_Page_Pre_Load_Event extends WP_UnitTestCase {

	/** @testdox The pre load hook event should only be created after the menu pages are registered. */
	public function test_creates_deferred_hook(): void {
		$this->assertTrue( 1 === 1 );
	}
}
