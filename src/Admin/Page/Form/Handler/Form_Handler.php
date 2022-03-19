<?php

declare(strict_types=1);

/**
 * Abstract Form Handler
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

namespace Gin0115\WP_Cricket_Scoring\Admin\Page\Form\Handler;

use Psr\Http\Message\ServerRequestInterface;
use Gin0115\WP_Cricket_Scoring\Admin\Page\Form\Validator\Abstract_Validator;

abstract class Form_Handler {

	protected ?Abstract_Validator $validator = null;
	protected bool $form_processed           = false;

	/**
	 * Primary method.
	 *
	 * @param ServerRequestInterface $request
	 * @return void
	 */
	public function handle( ServerRequestInterface $request ): void {
		$payload = $this->get_request_payload( $request );

		// If we have a validator and fail validation, bail.
		if ( $this->validator instanceof Abstract_Validator
		&& ! $this->validator->validate( $payload )
		) {
			return;
		}

		// Attempt to process the request.
		try {
			$this->process_request( $payload );
		} catch ( \Throwable $th ) {
			return;
		}

		// Mark as processed.
		$this->form_processed = true;
	}

	/**
	 * The method which process the request.
	 *
	 * @param array<string,mixed> $request
	 * @return void
	 */
	abstract protected function process_request( array $request): void;

	/**
	 * Gets the request based on its payload.
	 *
	 * @see Perique Ajax_Helper
	 * @param ServerRequestInterface $request
	 * @return array<string,mixed>
	 */
	protected function get_request_payload( ServerRequestInterface $request ): array {
		switch ( $request->getMethod() ) {
			case 'POST':
				// Return different post types.
				if ( str_contains( $request->getHeaderLine( 'Content-Type' ), 'application/x-www-form-urlencoded;' ) ) {
					$params = (array) $request->getParsedBody();
				} else {
					$params = (array) json_decode( (string) $request->getBody(), true ) ?? array();
				}
				break;
			case 'GET':
				$params = $request->getQueryParams();
				break;
			default:
				$params = array();
				break;
		}
		return is_array( $params ) ? $params : array( $params );
	}


	/**
	 * Get the value of validator
	 *
	 * @return Abstract_Validator
	 */
	public function get_validator(): Abstract_Validator {
		return $this->validator;
	}

	/**
	 * Set the value of validator
	 *
	 * @param Abstract_Validator $validator
	 * @return static
	 */
	public function set_validator( Abstract_Validator $validator ): self {
		$this->validator = $validator;
		return $this;
	}

	/**
	 * Has the form been processed.
	 */
	public function form_processed(): bool {
		return $this->form_processed;
	}

	/**
	 * Get the errors from validator, if set
	 *
	 * @return array<int,array{field:string,errors:string[]}>
	 */
	public function validator_errors(): array {
		return null === $this->validator
			? array()
			: $this->map_validation_errors( $this->validator->errors() );
	}

	/**
	 * Maps validation errors (per key) into a single string
	 * per key
	 *
	 * @param array<int,array{field:string,errors:string[]}> $errors
	 * @return string[]
	 */
	public function map_validation_errors( array $errors ): array {
		return \array_reduce(
			$errors,
			function( array $carry, array $field ): array {
				$carry = array_merge(
					$carry,
					array_map(
						function( string $error ) use ( $field ): string {
							return \sprintf(
								'<strong>%s</strong> : %s',
								esc_html( $field['field'] ),
								esc_html( $error )
							);
						},
						$field['errors']
					)
				);

				return $carry;
			},
			array()
		);
	}
}
