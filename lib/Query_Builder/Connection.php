<?php

declare(strict_types=1);

/**
 * Custom implementation of Pixie Query Builder for WordPress
 * @package Gin0115\Query_Builder
 */

namespace Gin0115\Lib\Query_Builder;

use Viocon\Container;
use Pixie\AliasFacade;
use Pixie\QueryBuilder\Raw;
use Pixie\Connection as PixieConnection;

class Connection extends PixieConnection {


	/**
	 * @var Container
	 */
	protected $container;

	/**
	 * @var string
	 */
	protected $adapter;

	/**
	 * @var array
	 */
	protected $adapterConfig;

	/**
	 * @var \PDO
	 */
	protected $pdoInstance;

	/**
	 * @var Connection
	 */
	protected static $storedConnection;

	/**
	 * @var EventHandler
	 */
	protected $eventHandler;

	/**
	 * @param               $adapter
	 * @param array         $adapterConfig
	 * @param null|string   $alias
	 * @param Container     $container
	 */
	public function __construct( $adapter, array $adapterConfig, $alias = null, Container $container = null ) {
		$container = $container ? : new Container();

		$this->container = $container;

		$this->setAdapter( $adapter )->setAdapterConfig( $adapterConfig )->connect();

		// Create event dependency
		$this->eventHandler = $this->container->build( '\\Pixie\\EventHandler' );

		if ( $alias ) {
			$this->createAlias( $alias );
		}
	}

	/**
	 * Create an easily accessible query builder alias
	 *
	 * @param $alias
	 */
	public function createAlias( $alias ) {
		class_alias( 'Pixie\\AliasFacade', $alias );
		$builder = $this->container->build( '\\Pixie\\QueryBuilder\\QueryBuilderHandler', array( $this ) );
		AliasFacade::setQueryBuilderInstance( $builder );
	}

	/**
	 * Returns an instance of Query Builder
	 */
	public function getQueryBuilder() {
		return $this->container->build( '\\Pixie\\QueryBuilder\\QueryBuilderHandler', array( $this ) );
	}


	/**
	 * Create the connection adapter
	 */
	protected function connect() {
		// Build a database connection if we don't have one connected

		// $adapter = '\\Pixie\\ConnectionAdapters\\' . ucfirst( strtolower( $this->adapter ) );

		// $adapterInstance = $this->container->build( $adapter, array( $this->container ) );

		// $pdo = $adapterInstance->connect( $this->adapterConfig );
		$this->setWPDBInstance( $GLOBALS['wpdb'] );

		// Preserve the first database connection with a static property
		if ( ! static::$storedConnection ) {
			static::$storedConnection = $this;
		}
	}

	/**
	 * Sets an instance of WPDB.
	 *
	 * @param \wpdb $wpdb
	 * @return self
	 */
	public function setWPDBInstance( \wpdb $wpdb ): self {
		$this->pdoInstance = $wpdb;
		return $this;
	}

	/**
	 * @return \wpdb
	 */
	public function getWPDBInstance() {
		return $this->pdoInstance;
	}

	/**
	 * @param \PDO $pdo
	 *
	 * @deprecated PDO not used with WPDB
	 * @return $this
	 */
	public function setPdoInstance( \PDO $pdo ) {
		throw new \Exception( 'PDO IS NOT USED WITH THIS VERSION OF PIXIE', 1 );
		$this->pdoInstance = $pdo;
		return $this;
	}

	/**
	 * @return \PDO
	 */
	public function getPdoInstance() {
		// throw new \Exception( 'PDO IS NOT USED WITH THIS VERSION OF PIXIE', 1 );
		return $this->pdoInstance;
	}

	/**
	 * @param $adapter
	 *
	 * @return $this
	 */
	public function setAdapter( $adapter ) {
		$this->adapter = $adapter;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getAdapter() {
		return $this->adapter;
	}

	/**
	 * @param array $adapterConfig
	 *
	 * @return $this
	 */
	public function setAdapterConfig( array $adapterConfig ) {
		$this->adapterConfig = $adapterConfig;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getAdapterConfig() {
		return $this->adapterConfig;
	}

	/**
	 * @return Container
	 */
	public function getContainer() {
		return $this->container;
	}

	/**
	 * @return EventHandler
	 */
	public function getEventHandler() {
		return $this->eventHandler;
	}

	/**
	 * @return Connection
	 */
	public static function getStoredConnection() {
		return static::$storedConnection;
	}
}
