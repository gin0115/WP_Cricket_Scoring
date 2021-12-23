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

namespace Gin0115\WP_Cricket_Scoring\Admin\Page\Event;

use PinkCrab\Perique\Application\App_Config;
use Psr\Http\Message\ServerRequestInterface;
use Gin0115\WP_Cricket_Scoring\Admin\Page\Menu_Page_Slugs;

class Plugin_Settings_Page_Pre_Load_Event extends Abstract_Load_Page_Event {

	protected ServerRequestInterface $request;

	public function __construct( ServerRequestInterface $request ) {
		$this->request = $request;
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
		echo 'Loaded in before page content';
	}
}
