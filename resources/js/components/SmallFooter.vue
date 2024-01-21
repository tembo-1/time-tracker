<template>
    <footer id="smallFooter" class="h-[10vh] bg-malachite-tech-pattern bg-center bg-no-repeat bg-cover">
        <div class="container flex justify-center items-center h-full">
            <h6 class="text-white text-sm font-semibold">© {{new Date().getFullYear()}} <a href="/" class="hover:underline">СЭНДИС</a> | ВСЕ ПРАВА ЗАЩИЩЕНЫ</h6>
        </div>
    </footer>
</template>

<script>
export default {
    name: "SmallFooter"
}
</script>
