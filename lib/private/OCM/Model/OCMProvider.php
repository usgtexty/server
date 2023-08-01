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

namespace OC\OCM\Model;

use JsonSerializable;
use OCP\OCM\Exceptions\OCMArgumentException;
use OCP\OCM\IOCMProvider;

/**
 * @since 28.0.0
 */
class OCMProvider implements IOCMProvider, JsonSerializable {
	private string $url;
	private bool $enabled = false;
	private string $apiVersion = '';
	private string $endPoint = '';
	/** @var OCMResource[] */
	private array $resourceTypes = [];

	public function __construct(string $url = '') {
		$this->url = $url;
	}

	/**
	 * @param bool $enabled
	 *
	 * @return OCMProvider
	 */
	public function setEnabled(bool $enabled): self {
		$this->enabled = $enabled;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isEnabled(): bool {
		return $this->enabled;
	}

	/**
	 * @param string $apiVersion
	 *
	 * @return OCMProvider
	 */
	public function setApiVersion(string $apiVersion): self {
		$this->apiVersion = $apiVersion;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getApiVersion(): string {
		return $this->apiVersion;
	}

	/**
	 * @param string $endPoint
	 *
	 * @return OCMProvider
	 */
	public function setEndPoint(string $endPoint): self {
		if ($this->isSafeUrl(parse_url($endPoint, PHP_URL_PATH) ?? '')) {
			$this->endPoint = $endPoint;
		}

		return $this;
	}

	/**
	 * @return string
	 */
	public function getEndPoint(): string {
		return $this->endPoint;
	}

	/**
	 * @param OCMResource $resource
	 *
	 * @return $this
	 */
	public function addResource(OCMResource $resource): self {
		$this->resourceTypes[] = $resource;

		return $this;
	}

	/**
	 * @param OCMResource[] $resourceTypes
	 *
	 * @return OCMProvider
	 */
	public function setResourceTypes(array $resourceTypes): self {
		$this->resourceTypes = $resourceTypes;

		return $this;
	}

	/**
	 * @return OCMResource[]
	 */
	public function getResourceTypes(): array {
		return $this->resourceTypes;
	}

	/**
	 * @return bool
	 */
	public function looksValid(): bool {
		if ($this->url !== ''
			&& parse_url($this->url, PHP_URL_HOST) !==
			   parse_url($this->getEndPoint(), PHP_URL_HOST)) {
			return false;
		}

		return ($this->getApiVersion() !== '' && $this->getEndPoint() !== '');
	}

	/**
	 * @param string $url
	 *
	 * @return bool
	 */
	protected function isSafeUrl(string $url): bool {
		return (bool)preg_match('/^[\/\.\-A-Za-z0-9]+$/', $url);
	}

	/**
	 * @param string $resourceName
	 * @param string $protocol
	 *
	 * @return string
	 * @throws OCMArgumentException
	 */
	public function extractProtocolUrl(string $resourceName, string $protocol): string {
		$url = $this->extractProtocolEntry($resourceName, $protocol);
		if (!$this->isSafeUrl($url)) {
			throw new OCMArgumentException('url does not looks safe');
		}

		return $url;
	}

	/**
	 * @param string $resourceName
	 * @param string $protocol
	 *
	 * @return string
	 * @throws OCMArgumentException
	 */
	public function extractProtocolEntry(string $resourceName, string $protocol): string {
		foreach ($this->getResourceTypes() as $resource) {
			if ($resource->getName() === $resourceName) {
				$entry = $resource->getProtocols()[$protocol] ?? null;
				if (is_null($entry)) {
					throw new OCMArgumentException('protocol not found');
				}

				return (string)$entry;
			}
		}

		throw new OCMArgumentException('resource not found');
	}

	/**
	 * import data from an array
	 *
	 * @param array|null $data
	 *
	 * @return self
	 * @see self::jsonSerialize()
	 */
	public function import(?array $data): self {
		if (is_null($data)) {
			return $this;
		}

		$this->setEnabled(is_bool($data['enabled'] ?? '') ? $data['enabled'] : false)
			 ->setApiVersion((string)($data['apiVersion'] ?? ''))
			 ->setEndPoint($data['endPoint'] ?? '');

		$resources = [];
		foreach (($data['resourceTypes'] ?? []) as $resourceData) {
			$resource = new OCMResource();
			$resources[] = $resource->import($resourceData);
		}
		$this->setResourceTypes($resources);

		return $this;
	}

	public function jsonSerialize(): array {
		return [
			'enabled' => $this->isEnabled(),
			'apiVersion' => $this->getApiVersion(),
			'endPoint' => $this->getEndPoint(),
			'resourceTypes' => $this->getResourceTypes()
		];
	}
}
