<!--
  - @copyright Copyright (c) 2023 Ferdinand Thiessen <opensource@fthiessen.de>
  -
  - @author Ferdinand Thiessen <opensource@fthiessen.de>
  -
  - @license AGPL-3.0-or-later
  -
  - This program is free software: you can redistribute it and/or modify
  - it under the terms of the GNU Affero General Public License as
  - published by the Free Software Foundation, either version 3 of the
  - License, or (at your option) any later version.
  -
  - This program is distributed in the hope that it will be useful,
  - but WITHOUT ANY WARRANTY; without even the implied warranty of
  - MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  - GNU Affero General Public License for more details.
  -
  - You should have received a copy of the GNU Affero General Public License
  - along with this program. If not, see <http://www.gnu.org/licenses/>.
  -
  -->

<template>
	<li class="action">
		<ul>
			<NcActionButton v-for="favorite in favorites"
				:key="favorite"
				:aria-hidden="true"
				@click="onFavoriteClick($event, favorite)">
				<template #icon>
					<IconStar :size="20" :class="{'favorite-color': current === favorite}" />
				</template>
				{{ favorite }}
			</NcActionButton>
		</ul>
	</li>
</template>

<script>
import IconStar from 'vue-material-design-icons/Star.vue'
import NcActionButton from '@nextcloud/vue/dist/Components/NcActionButton.js'

export default {
	name: 'FavoritesList',
	components: {
		IconStar,
		NcActionButton,
	},
	props: {
		/**
		 * The current active address
		 */
		current: {
			type: String,
			default: undefined,
		},
		/**
		 * List of all favorite addresses
		 */
		favorites: {
			type: Array,
			default: () => [],
		},
	},
}
</script>
