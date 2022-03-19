<?php

declare(strict_types=1);

/**
 * Settings page form handler
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
use Gin0115\WP_Cricket_Scoring\Plugin_Settings\Settings_Keys;
use Gin0115\WP_Cricket_Scoring\Admin\Page\Form\Handler\Form_Handler;
use Gin0115\WP_Cricket_Scoring\Plugin_Settings\Settings_Form_Validator;

class Settings_Form_Handler extends Form_Handler {

	protected Plugin_Settings $settings;
	protected Settings_Repository $repository;

	public function __construct(
		Plugin_Settings $settings,
		Settings_Form_Validator $validator,
		Settings_Repository $repository
	) {
		$this->settings   = $settings;
		$this->repository = $repository;
		$this->set_validator( $validator );
	}

	/**
	 * Process the request, will bail if any exceptions thrown
	 * Request should be validated prior to calling.
	 *
	 * @param array $request
	 * @return void
	 */
	protected function process_request( array $request ): void {
		foreach ( $this->mapper() as $key => $callable ) {
			try {
				$value = \array_key_exists( $key, $request ) ? $request[ $key ] : null;
				$callable( $value );
			} catch ( \Throwable $th ) {
				return;
			}
		}

		// Update options.
		$this->repository->save( $this->settings );
	}

	/**
	 * Returns an array of functions for handling the values.
	 *
	 * @return array
	 */
	protected function mapper(): array {
		return array(
			Settings_Keys::LIVE_SCORE_POLL_INTERVAL => function( $value ) {
				$this->settings->set_live_score_poll_interval( \absint( $value ) );
			},
		);
	}
}
