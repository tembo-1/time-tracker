<template>
    <div
        data-te-modal-init
        class="bg-black/25 fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
        :id="id"
        tabindex="-1"
        aria-labelledby="ModalLabel"
        aria-hidden="true">
        <div data-te-modal-dialog-ref class="p-20 pointer-events-none relative flex w-auto min-h-full translate-y-[-30px] items-center justify-center opacity-0 transition-all duration-200 ease-in-out">
            <div class="white-substrate shadow-none relative pointer-events-auto">
                <buttonV data-te-modal-dismiss aria-label="Close" title="Закрыть" icon="cross" class="absolute p-0 right-20 top-20 btn-gray-hovered-dark"/>
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
    name: "Modal",
    props: {
        id: {
            type: String,
            default: 'defaultModal'
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
      toggle() {
          this.modal.toggle();
      }
    },
    mounted() {
        initTE({ Modal });
        this.modal = new Modal(document.getElementById(this.id));
        this.modal._element.addEventListener("hide.te.modal", () => {
            this.$emit('modal-hide')
        });
        this.modal._element.addEventListener("hidden.te.modal", () => {
            this.$emit('modal-hidden')
        });
    },
    emits: ['modal-hide', 'modal-hidden'],
    components: {buttonV},
}
</script>
