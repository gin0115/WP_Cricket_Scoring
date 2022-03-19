<?php

declare(strict_types=1);

/**
 * Page Notification display
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

class Page_Notification {

	public const POSITION_TOP    = 'top';
	public const POSITION_BOTTOM = 'bottom';
	public const POSITION_LEFT   = 'left';
	public const POSITION_RIGHT  = 'right';

	public const STATUS_SUCCESS = 'success';
	public const STATUS_FAIL    = 'fail';
	public const STATUS_NOTICE  = 'notice';

	protected string $position = self::POSITION_BOTTOM;

	protected string $status = self::STATUS_SUCCESS;

	/** @var string[] */
	protected array $notices = array();

	/**
	 * Add a single notice
	 *
	 * @param string $notice
	 * @return self
	 */
	public function add( string $notice ): self {
		$this->notices[] = $notice;
		return $this;
	}

	/**
	 * Add many notices
	 *
	 * @param string[] $notices
	 * @return self
	 */
	public function add_many( array $notices ): self {
		foreach ( $notices as $notice ) {
			$this->add( $notice );
		}
		return $this;
	}

	/**
	 * Set the value of position
	 *
	 * @param string $position
	 * @return self
	 */
	public function set_position( string $position ) {
		$this->position = $position;
		return $this;
	}

	/**
	 * Set the value of status
	 *
	 * @param string $status
	 * @return self
	 */
	public function set_status( string $status ) {
		$this->status = $status;
		return $this;
	}

	/**
	 * Get the value of position
	 *
	 * @return string
	 */
	public function position(): string {
		return $this->position;
	}

	/**
	 * Get the value of status
	 *
	 * @return string
	 */
	public function status(): string {
		return $this->status;
	}

	/**
	 * Get the notices
	 *
	 * @return string[]
	 */
	public function notices(): array {
		return $this->notices;
	}
}
