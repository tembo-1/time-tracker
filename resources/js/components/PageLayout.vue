<template>
    <template v-if="variant === 'default'">
        <HeaderV/>
        <component :is="pageComponent"/>
        <FooterV/>
    </template>

    <template v-else-if="variant === 'minified'">
        <component :is="pageComponent"/>
        <SmallFooter />
    </template>
</template>

<script>
import HeaderV from "@/components/HeaderV.vue";
import FooterV from "@/components/FooterV.vue";
import SmallFooter from "@/components/SmallFooter.vue";

export default {
    name: "PageLayout",
    components: {SmallFooter, FooterV, HeaderV},
    props: {
        pageComponent: Object,
        variant: {
            type: String,
            default: 'default',
            validator(value) {
                return ['default', 'minified'].includes(value)
            }
        }
    }
}
</script>
