<?php

declare(strict_types=1);

/**
 * Event handler for updating plugin settings via Plugin Settings Page
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

use PinkCrab\Perique_Admin_Menu\Page\Page;
use PinkCrab\Perique\Interfaces\Renderable;
use Psr\Http\Message\ServerRequestInterface;
use Gin0115\WP_Cricket_Scoring\Admin\Page\Menu_Page_Slugs;
use Gin0115\WP_Cricket_Scoring\Admin\Page\Page_Notification;
use Gin0115\WP_Cricket_Scoring\Plugin_Settings\Settings_Form_Handler;
use Gin0115\WP_Cricket_Scoring\Admin\Page\Event\Abstract_Load_Page_Event;

class Settings_Upsert_Action extends Abstract_Load_Page_Event {

	protected ServerRequestInterface $request;
	protected Settings_Form_Handler $form_handler;
	protected Renderable $view;

	public function __construct(
		Settings_Form_Handler $form_handler,
		ServerRequestInterface $request,
		Renderable $view
	) {
		$this->view         = $view;
		$this->request      = $request;
		$this->form_handler = $form_handler;
	}

	/**
	 * Returns the hook for the page
	 *
	 * @called on admin_menu priority 15
	 * @return string
	 */
	public function page_hook(): string {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
		return \get_plugin_page_hookname( Menu_Page_Slugs::SETTINGS_PAGE, '' );
	}

	/**
	 * The callback for the page load event.
	 *
	 * @return void
	 */
	public function page_load_event(): void {
		$request_body = (array) $this->request->getParsedBody();
		if ( ! array_key_exists( 'action', $request_body )
		|| 'submit' !== $request_body['action'] ) {
			return;
		}

		$this->form_handler->handle( $this->request );
		$this->render_notifications();
	}

	/**
	 * Render any notifications
	 *
	 * @return void
	 */
	protected function render_notifications(): void {
		$notifications = new Page_Notification();
		$notifications->set_status(
			$this->form_handler->form_processed()
				? Page_Notification::STATUS_SUCCESS
				: Page_Notification::STATUS_FAIL
		);

		$notifications->add_many(
			$this->form_handler->form_processed()
				? array( 'Plugin Settings updated' )
				: $this->form_handler->validator_errors()
		);
		$notifications->set_position( Page_Notification::POSITION_BOTTOM );

		// Render notifications.
		$this->view->render( 'admin.page.notifications', array( 'notifications' => $notifications ) );
	}
}
