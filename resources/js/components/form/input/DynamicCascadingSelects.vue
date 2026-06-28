<template>
    <div class="row full-width">
        <div
            v-for="select in selects"
            :key="select.name"
            class="col-12 q-py-xs"
        >
            <select-field
                :name="select.name"
                :label="select.label"
                :loading="select.loading"
                :disable="select.disabled"
                :options="select.options"
                :model-value="select.value"
                @update="
                    (name, val) => {
                        select.value = val;
                        onSelectChange(select);
                    }
                "
            />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch, nextTick, computed } from "vue";
import { useQuasar } from "quasar";
import SelectField from "./SelectField.vue";
import axios from "axios";

defineOptions({
    name: "DynamicCascadingSelects",
});

const props = defineProps({
    fields: {
        type: Array,
        default: () => [],
    },
    modelValue: Object,
    cacheTTL: {
        type: Number,
        default: 300000,
    },
});

const emits = defineEmits(["update", "change"]);

const $q = useQuasar();

const selects = ref([]);
const loadingPromises = ref({});
const isInternalUpdate = ref(false);
const isInitialLoad = ref(true);

class CacheManager {
    constructor(ttl = 300000) {
        this.cache = new Map();
        this.ttl = ttl;
    }

    getKey(selectName, params) {
        return `${selectName}_${JSON.stringify(params)}`;
    }

    get(selectName, params) {
        const key = this.getKey(selectName, params);
        const entry = this.cache.get(key);

        if (!entry) return null;

        if (Date.now() - entry.timestamp > this.ttl) {
            this.cache.delete(key);
            return null;
        }

        return entry.data;
    }

    set(selectName, params, data) {
        const key = this.getKey(selectName, params);
        this.cache.set(key, {
            data: data,
            timestamp: Date.now(),
        });

        this.cleanup();
    }

    clear(selectName = null) {
        if (selectName) {
            for (const [key] of this.cache) {
                if (key.startsWith(`${selectName}_`)) {
                    this.cache.delete(key);
                }
            }
        } else {
            this.cache.clear();
        }
    }

    cleanup() {
        const now = Date.now();
        for (const [key, entry] of this.cache) {
            if (now - entry.timestamp > this.ttl) {
                this.cache.delete(key);
            }
        }
    }
}

const cacheManager = new CacheManager(props.cacheTTL);

const loadSelectOptions = async (
    select,
    skipSync = false,
    forceRefresh = false,
) => {
    if (!select.url) return;

    if (loadingPromises.value[select.name]) {
        return loadingPromises.value[select.name];
    }

    const dependenciesFilled = select.dependsOn.every((name) => {
        const dep = selects.value.find((s) => s.name === name);
        return (
            dep &&
            dep.value !== null &&
            dep.value !== undefined &&
            (Array.isArray(dep.value) ? dep.value.length > 0 : true)
        );
    });

    if (!dependenciesFilled) {
        select.options = [];
        select.value = null;
        select.disabled = true;
        return;
    }

    const params = {};
    select.dependsOn.forEach((name) => {
        const dep = selects.value.find((s) => s.name === name);
        if (dep && dep.value) {
            params[name] = Array.isArray(dep.value) ? dep.value[0] : dep.value;
        }
    });

    if (!forceRefresh) {
        const cachedData = cacheManager.get(select.name, params);
        if (cachedData) {
            select.options = cachedData;
            select.disabled = false;

            if (select.value) {
                const valueExists = cachedData.some((opt) =>
                    Array.isArray(select.value)
                        ? select.value.includes(opt.value)
                        : select.value === opt.value,
                );
                if (!valueExists) {
                    select.value = null;
                }
            }

            return cachedData;
        }
    }

    select.loading = true;
    select.disabled = true;

    const promise = (async () => {
        try {
            const response = await axios[select.method ?? "get"](
                select.url,
                params,
            );
            let options = response?.data?.options ?? [];

            cacheManager.set(select.name, params, options);

            const currentValue = select.value;
            select.options = options;

            if (currentValue) {
                const valueExists = options.some((opt) =>
                    Array.isArray(currentValue)
                        ? currentValue.includes(opt.value)
                        : currentValue === opt.value,
                );

                if (!valueExists) {
                    select.value = null;
                }
            } else {
                if (props.modelValue && props.modelValue[select.name]) {
                    const modelVal = props.modelValue[select.name];
                    const valueExists = options.some((opt) =>
                        Array.isArray(modelVal)
                            ? modelVal.includes(opt.value)
                            : modelVal === opt.value,
                    );
                    if (valueExists) {
                        select.value = modelVal;
                    }
                }
            }

            select.disabled = false;

            if (!skipSync && !isInternalUpdate.value) {
                await syncDependents(select);
            }

            return options;
        } catch (error) {
            console.error(`Error loading ${select.name}:`, error);
            select.options = [];
            select.value = null;
            select.disabled = true;
            throw error;
        } finally {
            select.loading = false;
            delete loadingPromises.value[select.name];
        }
    })();

    loadingPromises.value[select.name] = promise;
    return promise;
};

const syncDependents = async (changedSelect) => {
    const directDependents = selects.value.filter((s) =>
        s.dependsOn.includes(changedSelect.name),
    );

    if (directDependents.length === 0) return;

    const shouldLoad =
        changedSelect.value !== null && changedSelect.value !== undefined;

    const allDependents = [];
    const processDependents = (select) => {
        const deps = selects.value.filter((s) =>
            s.dependsOn.includes(select.name),
        );
        for (const dep of deps) {
            if (!allDependents.find((d) => d.name === dep.name)) {
                allDependents.push(dep);
                dep.value = null;
                dep.options = [];
                dep.disabled = true;
                processDependents(dep);
            }
        }
    };

    processDependents(changedSelect);

    if (!shouldLoad) {
        emitState(changedSelect);
        return;
    }

    for (const dep of directDependents) {
        cacheManager.clear(dep.name);
    }

    const loadPromises = [];
    for (const dep of directDependents) {
        const dependenciesFilled = dep.dependsOn.every((name) => {
            const depSelect = selects.value.find((s) => s.name === name);
            return (
                depSelect &&
                depSelect.value !== null &&
                depSelect.value !== undefined &&
                (Array.isArray(depSelect.value)
                    ? depSelect.value.length > 0
                    : true)
            );
        });

        if (dependenciesFilled) {
            loadPromises.push(loadSelectOptions(dep, true, false));
        }
    }

    if (loadPromises.length > 0) {
        await Promise.all(loadPromises);
    }

    emitState(changedSelect);
};

const onSelectChange = async (changedSelect) => {
    isInternalUpdate.value = true;

    try {
        if (
            !changedSelect.value ||
            (Array.isArray(changedSelect.value) &&
                changedSelect.value.length === 0)
        ) {
            await syncDependents(changedSelect);
            const state = getState();
            emits("update", state);
            emits("change", {
                name: changedSelect.name,
                value: changedSelect.value,
                state,
            });
            return;
        }

        const allDependents = [];
        const processDependents = (select) => {
            const deps = selects.value.filter((s) =>
                s.dependsOn.includes(select.name),
            );
            for (const dep of deps) {
                if (!allDependents.find((d) => d.name === dep.name)) {
                    allDependents.push(dep);
                    dep.value = null;
                    dep.options = [];
                    dep.disabled = true;
                    processDependents(dep);
                }
            }
        };

        processDependents(changedSelect);

        for (const dep of allDependents) {
            cacheManager.clear(dep.name);
        }

        const directDependents = selects.value.filter((s) =>
            s.dependsOn.includes(changedSelect.name),
        );

        const loadPromises = [];
        for (const dep of directDependents) {
            const dependenciesFilled = dep.dependsOn.every((name) => {
                const depSelect = selects.value.find((s) => s.name === name);
                return (
                    depSelect &&
                    depSelect.value !== null &&
                    depSelect.value !== undefined &&
                    (Array.isArray(depSelect.value)
                        ? depSelect.value.length > 0
                        : true)
                );
            });

            if (dependenciesFilled) {
                loadPromises.push(loadSelectOptions(dep, true, false));
            }
        }

        if (loadPromises.length > 0) {
            await Promise.all(loadPromises);
        }

        const state = getState();
        emits("update", state);
        emits("change", {
            name: changedSelect.name,
            value: changedSelect.value,
            state,
        });
    } finally {
        isInternalUpdate.value = false;
    }
};

const refreshDependents = async () => {
    const loadPromises = [];

    for (const select of selects.value) {
        if (select.dependsOn.length > 0) {
            const dependenciesFilled = select.dependsOn.every((name) => {
                const dep = selects.value.find((s) => s.name === name);
                return (
                    dep &&
                    dep.value !== null &&
                    dep.value !== undefined &&
                    (Array.isArray(dep.value) ? dep.value.length > 0 : true)
                );
            });

            if (dependenciesFilled) {
                if (select.options.length === 0) {
                    loadPromises.push(loadSelectOptions(select, true, false));
                } else {
                    select.disabled = false;
                }
            } else {
                select.disabled = true;
                select.options = [];
                select.value = null;
            }
        }
    }

    if (loadPromises.length > 0) {
        await Promise.all(loadPromises);
    }
};

const getState = () => {
    const state = {};
    selects.value.forEach((s) => {
        state[s.name] = {
            value: s.value,
            options: s.options,
            loading: s.loading,
            disabled: s.disabled,
        };
    });
    return state;
};

const emitState = (changedSelect = null) => {
    const state = getState();
    emits("update", state);
    if (changedSelect) {
        emits("change", {
            name: changedSelect.name,
            value: changedSelect.value,
            state,
        });
    }
    return state;
};

watch(
    () => props.modelValue,
    async (newVal, oldVal) => {
        if (!newVal || isInternalUpdate.value || isInitialLoad.value) return;

        let hasChanges = false;
        for (const select of selects.value) {
            const newValue = newVal[select.name];
            const oldValue = oldVal?.[select.name];
            if (JSON.stringify(newValue) !== JSON.stringify(oldValue)) {
                hasChanges = true;
                break;
            }
        }

        if (!hasChanges) return;

        isInternalUpdate.value = true;

        try {
            for (const select of selects.value) {
                if (
                    newVal[select.name] !== undefined &&
                    newVal[select.name] !== null
                ) {
                    const value = newVal[select.name];
                    const valueExists = select.options.some((opt) =>
                        Array.isArray(value)
                            ? value.includes(opt.value)
                            : value === opt.value,
                    );

                    if (valueExists) {
                        select.value = value;
                        if (select.disabled) {
                            select.disabled = false;
                        }
                    }
                }
            }

            await refreshDependents();
        } finally {
            isInternalUpdate.value = false;
        }
    },
    { deep: true },
);

onMounted(async () => {
    isInitialLoad.value = true;

    selects.value = props.fields.map((config) => ({
        ...config,
        options: [...(config.options || [])],
        value: config.value || null,
        loading: false,
        disabled: config.disabled || config.dependsOn.length > 0,
    }));

    const rootSelects = selects.value.filter((s) => s.dependsOn.length === 0);

    if (rootSelects.length > 0) {
        await Promise.all(
            rootSelects.map((s) => loadSelectOptions(s, true, false)),
        );
    }

    await refreshDependents();

    if (props.modelValue) {
        await nextTick();
        isInternalUpdate.value = true;

        for (const select of selects.value) {
            if (
                props.modelValue[select.name] !== undefined &&
                props.modelValue[select.name] !== null
            ) {
                const value = props.modelValue[select.name];
                const valueExists = select.options.some((opt) =>
                    Array.isArray(value)
                        ? value.includes(opt.value)
                        : value === opt.value,
                );

                if (valueExists) {
                    select.value = value;
                    if (select.disabled) {
                        select.disabled = false;
                    }
                }
            }
        }

        for (const select of selects.value) {
            if (select.dependsOn.length > 0 && select.options.length === 0) {
                const dependenciesFilled = select.dependsOn.every((name) => {
                    const dep = selects.value.find((s) => s.name === name);
                    return (
                        dep &&
                        dep.value !== null &&
                        dep.value !== undefined &&
                        (Array.isArray(dep.value) ? dep.value.length > 0 : true)
                    );
                });

                if (dependenciesFilled) {
                    await loadSelectOptions(select, true, false);
                }
            }
        }

        isInternalUpdate.value = false;
        await refreshDependents();
    }

    isInitialLoad.value = false;
});

const resetAll = async () => {
    selects.value.forEach((s) => {
        s.value = null;
        if (s.dependsOn.length > 0) {
            s.options = [];
            s.disabled = true;
        }
    });
    cacheManager.clear();
};

defineExpose({
    resetAll,
});
</script>
