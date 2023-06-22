<?php

namespace OCP\Circles\Model;

use OCP\Circles\Exceptions\OriginUnknownException;

interface IEntity {

	/**
	 * returns the unique and single id of the entity
	 *
	 * @return string
	 */
	public function getsingleId(): string;

	public function getUserId(): string;

	/**
	 * get the type of the entity
	 * listed as ICircle::TYPE_*
	 *
	 * @return int
	 */
	public function getUserType(): int;

	/**
	 * get display name of the entity
	 *
	 * @return string
	 */
	public function getDisplayName(): string;

	/**
	 * returns the instance the entity belongs to
	 *
	 * @return string empty string if instance is local
	 */
	public function getInstance(): string;

	/**
	 * entity is local and belongs to current instance
	 *
	 * @return bool
	 */
	public function isLocal(): bool;

	/**
	 * @return ICircle
	 * @throws OriginUnknownException current Entity have unknown origin, most likely does not exist in
	 *   local database and should not be trusted (yet) unless you already know it.
	 */
	public function getOrigin(): ICircle;
}
