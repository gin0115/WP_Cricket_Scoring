<?php

declare(strict_types=1);

/**
 * Team (List, Edit & Create) page
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
use Gin0115\WP_Cricket_Scoring\Plugin_Settings\Settings_Keys;
use Gin0115\WP_Cricket_Scoring\Plugin_Settings\Settings_Page;
use Gin0115\WP_Cricket_Scoring\Admin\Page\Form\Validator\Rule;
use function PinkCrab\FunctionConstructors\Comparisons\not as not;
use Gin0115\WP_Cricket_Scoring\Admin\Page\Form\Validator\Abstract_Validator;
use function PinkCrab\FunctionConstructors\Comparisons\isGreaterThan as greater_than;

class Settings_Form_Validator extends Abstract_Validator {

	/**
	 * Returns the validation rules.
	 * Each rule must be passed (not return false or null)
	 *
	 * @return array<string, Rule>
	 */
	protected function rule_set(): array {
		return array(
			Settings_Keys::LIVE_SCORE_POLL_INTERVAL => Rule::create()
				->assert( not( 'is_null' ), 'Live Score Poll Interval is empty.' )
				->assert( 'is_numeric', 'Live Score Poll Interval must be a number' )
				->assert( not( greater_than( 0 ) ), 'Live Score Poll Interval must be more than 0.' ), // Context here is revered as isGreaterThan() calls "is 0 greater than x", reversed using not for this context.
			'_wpnonce'                              => Rule::create()
				->assert( not( 'is_null' ), 'Live Score Poll Interval is empty.' )
				->assert(
					array( new Nonce( Settings_Page::SETTINGS_NONCE_HANDLE ), 'validate' ),
					'Live Score Poll Interval is empty.'
				),
		);
	}
}
