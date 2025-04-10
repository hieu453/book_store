import { reactive } from "vue";

export const useSidebar = reactive({
    isOpen: false,
    dropdownOpen: false,
    toggleOpen() {
        this.isOpen = !this.isOpen
    },
    toggleDropdown() {
        this.dropdownOpen = !this.dropdownOpen
    }
})
