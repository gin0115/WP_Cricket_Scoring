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

namespace Gin0115\WP_Cricket_Scoring\Migration;

use PinkCrab\Table_Builder\Schema;
use PinkCrab\Perique\Migration\Migration;
use PinkCrab\Perique\Application\App_Config;

class Team_Migration extends Migration {

	protected App_Config $config;

	public function __construct( App_Config $config ) {
		$this->config = $config;
		parent::__construct();
	}

	/**
	 * Table name from config
	 *
	 * @return string
	 */
	protected function table_name(): string {
		return $this->config->db_tables( 'teams' );
	}

	/**
	 * Drop on deactivation.
	 *
	 * @return bool
	 */
	public function drop_on_deactivation(): bool {
		return true;
	}

	/**
	 * Defines the schema for the migration.
	 *
	 * @param Schema $schema_config
	 * @return void
	 */
	public function schema( Schema $schema ): void {
		$schema->column( 'id' )
			->unsigned_int( 11 )
			->auto_increment();

		$schema->column( 'club' )
			->varchar( 50 );

		$schema->column( 'squad' )
			->varchar( 50 );

		$schema->column( 'additional' )
			->text( 255 );

		$schema->column( 'created' )
			->datetime( 'CURRENT_TIMESTAMP' );

		$schema->column( 'updated' )
			->datetime( 'CURRENT_TIMESTAMP' );

		$schema->index( 'id' )->primary();
	}


}
