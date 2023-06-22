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

namespace OC\Circles;

use OCP\Circles\Exceptions\EntityManagerNotAvailableException;
use OCP\Circles\IEntityManager;
use OCP\Circles\IEntityViewerSession;
use OCP\Circles\Model\ICircle;
use OCP\Circles\Model\IEntity;
use OCP\Circles\Model\IEntityLink;
use OCP\Circles\Model\IProbeCircle;

class UnavailableEntityManager implements IEntityManager {
	public function isAvailable(): bool {
		return false;
	}

	public function getEntity(string $entityId): IEntity {
		throw new EntityManagerNotAvailableException();
	}

	public function getCircle(string $circleId): ICircle {
		throw new EntityManagerNotAvailableException();
	}

	public function getCircles(IProbeCircle $circle): array {
		throw new EntityManagerNotAvailableException();
	}

	public function getLink(string $childEntityId, string $parentEntityId): IEntityLink {
		throw new EntityManagerNotAvailableException();
	}

	public function isLinked(
		string $childEntityId,
		string $parentEntityId,
		int $minimumLevel = IEntityLink::LEVEL_MEMBER
	): bool {
		throw new EntityManagerNotAvailableException();
	}

	public function asEntity(IEntity $entity): IEntityViewerSession {
		throw new EntityManagerNotAvailableException();
	}

	public function asAccount(string $userId): IEntityViewerSession {
		throw new EntityManagerNotAvailableException();
	}

	public function asCurrent(): IEntityViewerSession {
		throw new EntityManagerNotAvailableException();
	}

	public function asOwner(string $circleId): IEntityViewerSession {
		throw new EntityManagerNotAvailableException();
	}
}
