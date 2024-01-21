<template>
    <div>
        <button data-popover-target="popover-description" data-popover-placement="top-end" type="button" class="group">
            <icon-v name="hint" class="fill-gray group-hover:fill-dark duration-200" />
            <span class="sr-only">Show information</span>
        </button>
        <div data-popover id="popover-description" role="tooltip" class="absolute z-10 invisible inline-block text-sm transition-opacity duration-200 bg-white shadow rounded-5 opacity-0"
        :class="hintClasses">
            <div class="p-10">
                <slot></slot>
            </div>
            <div data-popper-arrow></div>
        </div>
    </div>
</template>

<script>
import iconV from "@/components/iconV.vue";
export default {
    props: {
      hintClasses: String,
    },
    components: {
        iconV,
    }
}
</script>


