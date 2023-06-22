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

use OCP\Circles\Model\IEntity;

/**
 * @since 28.0.0
 */
interface IEntityViewerSession { // naming ?

	public function getCircle(string $circleId): IEntity;

	public function probeCircles(): array;

	public function addMember(): void;

	public function removeMember(): void;

	public function levelMember(): void;

	public function getMembers(): array;

	public function configCircle();

	public function settingsCircle();
}



