<?php

declare(strict_types=1);

/**
 * Repository for saving and loading the plugin settings.
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

use Gin0115\WP_Cricket_Scoring\Plugin_Settings;

class Settings_Repository {

	protected string $transient_key;

	public function __construct( string $transient_key = null ) {
		$this->transient_key = $transient_key ?? 'wp_cricket_scorer_settings';
	}

	/**
	 * Attempts to get the current settings from transient
	 * If not set, will return a new instance.
	 *
	 * @return Plugin_Settings
	 */
	public function get(): Plugin_Settings {
		$settings = \get_option( $this->transient_key );
		return is_string( $settings )
			? \unserialize( $settings )
			: new Plugin_Settings();
	}

	/**
	 * Updates the Plugin Settings instance.
	 *
	 * @param \Gin0115\WP_Cricket_Scoring\Plugin_Settings $settings
	 * @return self
	 */
	public function save( Plugin_Settings $settings ): self {
		\update_option( $this->transient_key, \serialize( $settings ) );
		return $this;
	}


}
