<?php

declare(strict_types=1);

/**
 * Plugin Settings Menu Page
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package Gin0115\Cricket Scoring
 */

namespace Gin0115\WP_Cricket_Scoring\Plugin_Settings;

use PinkCrab\Nonce\Nonce;
use Gin0115\WP_Cricket_Scoring\Plugin_Settings;
use PinkCrab\Perique_Admin_Menu\Page\Menu_Page;
use Gin0115\WP_Cricket_Scoring\I18N\Translations;
use Gin0115\WP_Cricket_Scoring\Admin\Page\Menu_Page_Slugs;
use Gin0115\WP_Cricket_Scoring\Plugin_Settings\Settings_Keys;

class Settings_Page extends Menu_Page {

	public const SETTINGS_NONCE_HANDLE = 'settings_page';

	/**
	 * The pages position, in relation to other pages in group.
	 *
	 * @var int
	 */
	protected $position = 10;

	/**
	 * The template to be rendered.
	 *
	 * @var string
	 */
	protected $view_template = 'admin.page.settings-page';

	protected Plugin_Settings $plugin_settings;

	public function __construct(
		Translations $translations,
		Settings_Repository $settings_repository
	) {
		// Get the plugin settings.
		$plugin_settings = $settings_repository->get();

		$this->page_slug  = Menu_Page_Slugs::SETTINGS_PAGE;
		$this->menu_title = $translations->admin_menu_translations()->menu_title( 'settings_page' );
		$this->page_title = $translations->admin_menu_translations()->page_title( 'settings_page' );

		// Set the view data.
		$this->view_data = array(
			'settings' => $plugin_settings,
			'nonce'    => ( new Nonce( self::SETTINGS_NONCE_HANDLE ) )->nonce_field(),
			'i18n'     => $translations->admin_menu_translations(),
		) + $this->unpack_settings( $plugin_settings );
	}

	/**
	 * Unpacks the Plugin Settings object into an array of variables.
	 *
	 * @param \Gin0115\WP_Cricket_Scoring\Plugin_Settings $plugin_settings
	 * @return array<string, mixed>
	 */
	protected function unpack_settings( Plugin_Settings $plugin_settings ): array {
		return array(
			Settings_Keys::LIVE_SCORE_POLL_INTERVAL => $plugin_settings->get_live_score_poll_interval(),
		);
	}


}
