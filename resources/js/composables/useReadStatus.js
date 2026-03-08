import { ref } from "vue";

export function useReadStatus(callback) {
    const isRead = ref(false);
    let timeout = null;

    const onVisibilityChange = (entry) => {
        if (isRead.value) return;
        if (entry.isIntersecting) {
            timeout = setTimeout(() => {
                isRead.value = true;
                callback();
            }, 2000);
        } else {
            clearTimeout(timeout);
        }
    };

    return {
        onVisibilityChange,
        isRead,
    };
}
