<?php

declare(strict_types=1);

/**
 * @copyright 2023, Maxence Lange <maxence@artificial-owl.com>
 *
 * @author Maxence Lange <maxence@artificial-owl.com>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCP\Circles;

use OCP\Circles\Exceptions\EntitiesLinkNotFoundException;
use OCP\Circles\Exceptions\EntityManagerNotAvailableException;
use OCP\Circles\Exceptions\EntityNotFoundException;
use OCP\Circles\Model\ICircle;
use OCP\Circles\Model\IEntity;
use OCP\Circles\Model\IEntityLink;
use OCP\Circles\Model\IProbeCircle;

/**
 * @since 28.0.0
 */
interface IEntityManager {

	/**
	 * @return bool
	 */
	public function isAvailable(): bool;

	/**
	 * returns a related IEntity to a unique entityId/singleId
	 *
	 * @param string $entityId
	 *
	 * @return IEntity
	 * @throws EntityNotFoundException
	 * @throws EntityManagerNotAvailableException
	 */
	public function getEntity(string $entityId): IEntity;

	/**
	 * returns the IEntity related to current session.
	 *
	 * @return IEntity
	 * @throws EntityNotFoundException
	 * @throws EntityManagerNotAvailableException
	 */
	public function getCurrent(): IEntity;

	public function getCircle(string $circleId): ICircle;

	public function getCircles(IProbeCircle $circle): array;

	/**
	 * returns the link between 2 entities: one being child and the other parent
	 *
	 * @param string $childEntityId
	 * @param string $parentEntityId
	 *
	 * @return IEntityLink
	 * @throws EntitiesLinkNotFoundException
	 * @throws EntityNotFoundException
	 * @throws EntityManagerNotAvailableException
	 */
	public function getLink(string $childEntityId, string $parentEntityId): IEntityLink;

	/**
	 * @param string $childEntityId
	 * @param string $parentEntityId
	 * @param int $minimumLevel
	 *
	 * @return bool
	 * @throws EntityManagerNotAvailableException
	 * @throws EntityNotFoundException
	 */
	public function isLinked(
		string $childEntityId,
		string $parentEntityId,
		int $minimumLevel = IEntityLink::LEVEL_MEMBER
	): bool;

	/**
	 * returns an IEntityViewerSession with the set IEntity as viewer
	 *
	 * @param IEntity $entity
	 *
	 * @return IEntityViewerSession
	 * @throws EntityManagerNotAvailableException
	 * @throws EntityNotFoundException
	 */
	public function asEntity(IEntity $entity): IEntityViewerSession;

	/**
	 * returns an IEntityViewerSession with the set nextcloud account userid as viewer
	 *
	 * @param string $userId
	 *
	 * @return IEntityViewerSession
	 * @throws EntityManagerNotAvailableException
	 * @throws EntityNotFoundException
	 */
	public function asAccount(string $userId): IEntityViewerSession;

	/**
	 * returns an IEntityViewerSession with the set appid as viewer
	 *
	 * @param string $appId
	 *
	 * @return IEntityViewerSession
	 * @throws EntityManagerNotAvailableException
	 */
	public function asApp(string $appId): IEntityViewerSession;

	/**
	 * returns an IEntityViewerSession with the occ command as viewer
	 *
	 * @return IEntityViewerSession
	 * @throws EntityManagerNotAvailableException
	 */
	public function asOcc(): IEntityViewerSession;

	/**
	 * returns an IEntityViewerSession with current session as viewer
	 *
	 * @return IEntityViewerSession
	 * @throws EntityManagerNotAvailableException
	 */
	public function asCurrent(): IEntityViewerSession;

	/**
	 * returns an IEntityViewerSession with the owner of set circle, identified by its id
	 *
	 * @param string $circleId
	 *
	 * @return IEntityViewerSession
	 * @throws EntityManagerNotAvailableException
	 * @throws EntityNotFoundException
	 */
	public function asOwner(string $circleId): IEntityViewerSession;

	/**
	 * returns an IEntitySuperSession
	 *
	 * @return IEntitySuperSession
	 * @throws EntityManagerNotAvailableException
	 */
	public function asSuper(): IEntitySuperSession;

	/**
	 * returns a IEntityQueryHelper to help generating sql request
	 *
	 * @return IEntityQueryHelper
	 * @throws EntityManagerNotAvailableException
	 */
	public function getQueryHelper(): IEntityQueryHelper;
}
