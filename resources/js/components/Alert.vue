<template>
    <div
        data-te-modal-init
        data-te-modal-non-invasive="true"
        class="pointer-events-none fixed left-0 top-0 z-[1055] hidden w-full h-full overflow-y-auto overflow-x-hidden outline-none"
        :id="id"
        tabindex="-1"
        aria-labelledby="ModalLabel"
        aria-hidden="true">
        <div data-te-modal-dialog-ref class="p-20 pointer-events-none absolute h-auto w-full flex justify-end translate-x-[100%] opacity-0 transition-all duration-200 ease-in-out">
            <div class="white-substrate max-w-[500px] relative pointer-events-auto">
                <div class="flex justify-between items-center">
                    <slot name="head"></slot>
                    <buttonV data-te-modal-dismiss aria-label="Close" title="Закрыть" icon="cross" class="p-0 btn-gray-hovered-dark"/>
                </div>
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
import {
    Modal,
    initTE,
} from "tw-elements";
import buttonV from "@/components/buttonV.vue";
export default {
    name: "Alert",
    props: {
        id: {
            type: String,
            default: 'Alert'
        },
        expiring: {
            type: Boolean,
            default: false,
        }
    },
    data() {
        return {
            modal: null,
        }
    },
    methods: {
      open() {
          this.modal.show();
      },
      close() {
          this.modal.hide();
      },
    },
    mounted() {
        initTE({ Modal });
        this.modal = new Modal(document.getElementById(this.id));
    },
    components: {buttonV},
}
</script>
