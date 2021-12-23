<?php

declare(strict_types=1);

/**
 * Primary class for all translations.
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

namespace Gin0115\WP_Cricket_Scoring\I18N\Translations;

class Admin_Menu_Translations {

	/**
	 * Returns the menu titles
	 *
	 * @param string $key
	 * @return string
	 */
	public function menu_title( string $key ): string {
		switch ( $key ) {
			case 'menu_group':
				return _x( 'Cricket Scoring', 'Primary Admin Menu group title' );

			case 'settings_page':
				return _x( 'Settings', 'Primary Admin Menu group title' );

			case 'team_page':
				return _x( 'Team Management', 'Primary Admin Menu group title' );

			case 'game_page':
				return _x( 'Game Management', 'Primary Admin Menu group title' );

			default:
				return _x( 'Translation Missing', 'Fallback of missing translation for Admin_Menu_Translations::menu_title' );
		}
	}

	/**
	 * Returns the page title based on its key.
	 *
	 * @param string $key
	 * @return string
	 */
	public function page_title( string $key ): string {
		switch ( $key ) {
			case 'menu_group':
				return _x( 'Cricket Scoring', 'Primary Admin Menu group title' );

			case 'settings_page':
				return _x( 'Settings', 'Primary Admin Menu group title' );

			case 'team_page':
				return _x( 'Team Page', 'Primary Admin Menu group title' );

			case 'game_page':
				return _x( 'Game Management', 'Primary Admin Menu group title' );
			default:
				return _x( 'Translation Missing', 'Fallback of missing translation for Admin_Menu_Translations::page_title' );
		}
	}
}
