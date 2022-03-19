<?php

declare (strict_types=1);

/**
 * All classes which should be added to the registration process.
 *
 * @since 0.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 */

use Gin0115\WP_Cricket_Scoring\Admin\Page\Menu_Group;
use Gin0115\WP_Cricket_Scoring\Plugin_Settings\Settings_Upsert_Action;
use Gin0115\WP_Cricket_Scoring\Admin\Page\Event\Plugin_Settings_Page_Pre_Load_Event;

return array(
	// WP-Admin - Pages
	Menu_Group::class,
	// Plugin_Settings_Page_Pre_Load_Event::class,
	Settings_Upsert_Action::class,
);
