<?php

declare(strict_types=1);

/**
 * All translateable string for the Settings Form
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

class Admin_Settings_Form {

	/**
	 * Form labels
	 *
	 * @param string $key
	 * @return string passed through esc_html( $string )
	 */
	public function labels( string $key ): string {
		switch ( $key ) {
			case 'live_score_poll_interval':
				$string = _x( 'Live score update', 'Primary Admin Menu group title' );
				break;
			case 'form_submit_button':
				$string = _x( 'Update Settings', 'Primary Admin Menu group title' );
				break;

			default:
				$string = _x( 'Translation Missing', 'Fallback of missing translation for Admin_Settings_Form::labels' );
		}

		return esc_html( $string );
	}

	/**
	 * Generic error messages for validation errors.
	 *
	 * @param string $key
	 * @return string
	 */
	public function validation_errors( string $key ): string {
		switch ( $key ) {
			case 'value_missing':
				$string = _x( 'Is required.', 'Primary Admin Menu group title' );
				break;
			case 'numeric_value_required':
				$string = _x( 'Numerical value expected', 'Primary Admin Menu group title' );
				break;

			default:
				$string = _x( 'Translation Missing', 'Fallback of missing translation for Admin_Settings_Form::validation_errors' );
		}

		return esc_html( $string );
	}
}
