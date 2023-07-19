<template>
	<div :class="{ 'active': showDropdown, 'share-select': true }">
		<span class="trigger-text" @click="toggleDropdown">
			{{ selectedOption }}
			<DropdownIcon :size="15" />
		</span>
		<div v-if="showDropdown" class="share-select-dropdown-container">
			<div v-for="option in options"
				:key="option"
				class="dropdown-item"
				@click="selectOption(option)">
				{{ option }}
			</div>
		</div>
	</div>
</template>

<script>
import DropdownIcon from 'vue-material-design-icons/ArrowDown.vue'

export default {
	components: {
		DropdownIcon,
	},
	props: {
		options: {
			type: Array,
			required: true,
		},
		value: {
			type: String,
			required: true,
		},
		toggle: {
			type: Boolean,
			default: false,
		},
	},
	data() {
		return {
			showDropdown: this.toggle,
		}
	},
	computed: {
		selectedOption() {
			return this.value
		},
	},
	methods: {
		toggleDropdown() {
			this.showDropdown = !this.showDropdown
		},
		selectOption(option) {
			this.$emit('update:value', option)
			this.showDropdown = false
		},
	},
}
</script>

<style lang="scss" scoped>
.share-select {
    position: relative;
    cursor: pointer;

    .trigger-text {
        display: flex;
        flex-direction: row;
        align-items: center;
        font-size: 12.5px;
        gap: 5px;
        color: var(--color-primary-element);
    }

    .share-select-dropdown-container {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        padding: 4px 0;
        z-index: 1;

        .dropdown-item {
            padding: 8px;
            font-size: 14px;

            &:hover {
                background-color: #f2f2f2;
            }
        }
    }

    /* Optional: Add a transition effect for smoother dropdown animation */
    .share-select-dropdown-container {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    &.active .share-select-dropdown-container {
        max-height: 200px;
        /* Adjust the value to your desired height */
    }
}
</style>
