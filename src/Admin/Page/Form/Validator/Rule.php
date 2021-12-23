<?php

declare(strict_types=1);

/**
 * Validation rule
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

class Rule {

	/** @var array{assertion:callable, message:string}[]  */
	protected array $assertion = array();

	/** @var string[]  */
	protected array $errors = array();

	/**
	 * @param array{assertion:callable, message:string} ...$assertion
	 */
	public function __construct( array ...$assertion ) {
		$this->assertion = $assertion;
	}

	/**
	 * Static constructor
	 *
	 * @return self
	 */
	public static function create(): self {
		return new Rule();
	}

	/**
	 * Adds an assertion to the rule.
	 *
	 * @param callable $assertion
	 * @param string $message
	 * @return self
	 */
	public function assert( callable $assertion, string $message ): self {
		$this->assertion[] = array(
			'assertion' => $assertion,
			'message'   => $message,
		);
		return $this;
	}

	/**
	 * Checks a passed value through each assertion callback.
	 *
	 * @param mixed $value
	 * @return self
	 */
	public function check( $value ): self {
		foreach ( $this->assertion as $assert ) {
			try {
				$result = (bool) ( $assert['assertion'] )( $value );
				if ( false === $result ) {
					$this->errors[] = $assert['message'];
				}
			} catch ( \Throwable $th ) {
				$this->errors[] = $th->getMessage();
			}
		}
		return $this;
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
	 * @return string[]
	 */
	public function errors(): array {
		return $this->errors;
	}
}
