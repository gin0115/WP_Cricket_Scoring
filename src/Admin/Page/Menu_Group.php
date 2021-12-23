<?php

declare(strict_types=1);

/**
 * Primary admin menu group for pages
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

namespace Gin0115\WP_Cricket_Scoring\Admin\Page;

use PinkCrab\Perique_Admin_Menu\Group\Abstract_Group;
use Gin0115\WP_Cricket_Scoring\Admin\Page\Plugin_Settings_Page;
use Gin0115\WP_Cricket_Scoring\I18N\Translations\Admin_Menu_Translations;

class Menu_Group extends Abstract_Group {

	protected $primary_page = Plugin_Settings_Page::class;

	protected $pages = array();

	protected $capability = 'manage_options';

	protected $icon = 'dashicons-admin-generic';

	protected $position = 65;

	public function __construct( Admin_Menu_Translations $translations ) {
		$this->group_title = $translations->menu_title( 'menu_group' );
	}
}
