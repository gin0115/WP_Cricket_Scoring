<?php

declare(strict_types=1);

/**
 * Inteface for any Team Repository
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

namespace Gin0115\WP_Cricket_Scoring\Team;

interface Team_Repository {

	/**
	 * Get all teams
	 *
	 * @param int|null $limit If null passed, will get all.
	 * @return Team[]
	 */
	public function get( ?int $offset = 0, ?int $limit = null): array;

	/**
	 * Creates or updates a team
	 *
	 * @param Team $team
	 * @return bool If team we updated/created
	 */
	public function upsert( Team $team): bool;

	/**
	 * Delete a team.
	 *
	 * @param Team $team
	 * @return bool
	 */
	public function delete( Team $team ): bool;

	/**
	 * Carry out a query
	 *
	 * @param string $query
	 * @return array
	 */
	public function sql_query( string $query ): array;


}
