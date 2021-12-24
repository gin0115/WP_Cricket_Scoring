<?php

declare(strict_types=1);

/**
 * Abstract validator
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

namespace Gin0115\WP_Cricket_Scoring\Admin\Form\Validator;

use Gin0115\WP_Cricket_Scoring\Admin\Form\Validator\Rule;

abstract class Abstract_Validator {

	/** @var array<int,array{field:string,errors:string[]}> */
	protected array $errors = array();

	/**
	 * Validates a key value representation of a request
	 * against the defined rule set.
	 *
	 * @param array<string, mixed> $data
	 * @return bool
	 */
	public function validate( array $data ): bool {
		foreach ( $this->rule_set() as $key => $rule ) {
			// Attempt to get the value from request
			$value = \array_key_exists( $key, $data )
				? $data[ $key ]
				: null;

			// Validate it passed the rules checks.
			$rule->check( $value );

			// If we have any errors from check, add to global errors.
			if ( $rule->has_errors() ) {
				$this->add_error( $key, $rule->errors() );
			}
		}

		return ! $this->has_errors();
	}

	/**
	 * Returns the validation rules.
	 * Each rule must be passed (not return false or null)
	 *
	 * @return array<string, Rule>
	 */
	abstract protected function rule_set(): array;

	/**
	 * Adds errors based on field to the errors array
	 *
	 * @param string $field
	 * @param string[] $errors
	 * @return void
	 */
	protected function add_error( string $field, array $errors ): void {
		$this->errors[] = array(
			'field'  => $field,
			'errors' => $errors,
		);
	}

	/**
	 * Checks if there are errors.
	 *
	 * @return bool
	 */
	public function has_errors(): bool {
		return count( $this->errors ) >= 1;
	}

	/**
	 * Returns the current error messages.
	 *
	 * @return array<int,array{field:string,errors:string[]}>
	 */
	public function errors(): array {
		return $this->errors;
	}
}
