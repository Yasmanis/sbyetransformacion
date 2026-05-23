<template>
    <div class="message-wrapper">
        <div
            ref="textRef"
            v-html="text"
            :class="['message-text', { 'clamp-lines': !isExpanded }]"
        ></div>
        <div v-if="isTruncated || isExpanded" class="row justify-end q-mt-xs">
            <q-btn
                flat
                dense
                no-caps
                color="primary"
                size="sm"
                :label="isExpanded ? 'ver menos' : 'ver mas'"
                @click="isExpanded = !isExpanded"
            />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, nextTick } from "vue";

const props = defineProps({
    text: { type: String, required: true },
});

const textRef = ref(null);
const isExpanded = ref(false);
const isTruncated = ref(false);

let resizeObserver = null;

const checkTruncation = () => {
    const el = textRef.value;
    if (!el) return;
    isTruncated.value = el.scrollHeight > el.clientHeight + 3;
};

onMounted(async () => {
    await nextTick();
    checkTruncation();
    if (window.ResizeObserver && textRef.value) {
        resizeObserver = new ResizeObserver(() => {
            requestAnimationFrame(checkTruncation);
        });
        resizeObserver.observe(textRef.value);
    }
});

onBeforeUnmount(() => {
    if (resizeObserver && textRef.value) {
        resizeObserver.unobserve(textRef.value);
    }
});
</script>

<style lang="scss" scoped>
.message-text {
    white-space: pre-line;
    word-break: break-word;
    line-height: 1.5em;

    :deep(p),
    :deep(div) {
        margin: 0;
        display: inline;
    }
}
.message-text > p {
    margin: 0px !important;
    padding: 0px !important;
}

.clamp-lines {
    display: -webkit-box;
    -webkit-line-clamp: 5;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
