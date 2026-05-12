<template>
    <Layout>
        <q-page padding>
            <q-table
                class="q-mx-sm"
                row-key="id"
                flat
                color="primary"
                :rows="visibleRows"
                :columns="columns"
                :pagination="{ rowsPerPage: 0 }"
                :loading="loading"
                hide-bottom
                binary-state-sort
            >
                <template v-slot:top>
                    <q-toolbar>
                        <section
                            class="q-my-xs q-mr-sm cursor-pointer text-subtitle1"
                        >
                            <div class="doc-card-title bg-primary text-white">
                                <q-icon
                                    name="mdi-file-account-outline"
                                    size="22px"
                                />
                                modulos
                            </div>
                        </section>
                        <q-input
                            v-model="filterText"
                            dense
                            placeholder="buscar..."
                            class="col"
                            style="max-width: 300px"
                        >
                            <template v-slot:append>
                                <q-icon name="search" />
                            </template>
                        </q-input>
                        <q-space />
                        <btn-reload-component @click="router.reload()" />
                        <q-btn-component
                            icon="mdi-expand-all-outline"
                            tooltips="expandir todo"
                            @click="expandAll"
                        />
                        <q-btn-component
                            icon="mdi-collapse-all-outline"
                            tooltips="contraer todo"
                            @click="collapseAll"
                        />
                    </q-toolbar>
                </template>
                <template v-slot:header="props">
                    <q-tr :props="props">
                        <q-th
                            v-for="col in props.cols"
                            :key="col.name"
                            :props="props"
                            @click="handleSort(col.name)"
                            class="cursor-pointer"
                        >
                            {{ col.label }}
                            <q-icon
                                :name="
                                    sortOrder === 'asc'
                                        ? 'arrow_upward'
                                        : 'arrow_downward'
                                "
                                size="xs"
                                v-if="sortBy === col.name"
                            />
                        </q-th>
                    </q-tr>
                </template>

                <template v-slot:body="props">
                    <q-tr
                        :props="props"
                        draggable="true"
                        @dragstart="onDragStart($event, props.row)"
                        @dragover="onDragOver($event, props.row)"
                        @drop="onDrop($event, props.row)"
                        @dragleave="
                            isDraggingOver = null;
                            dropPosition = null;
                        "
                        :class="{
                            'target-folder-active':
                                isDraggingOver === props.row.id &&
                                dropPosition === 'inside',
                            'drop-before':
                                isDraggingOver === props.row.id &&
                                dropPosition === 'before',
                            'drop-after':
                                isDraggingOver === props.row.id &&
                                dropPosition === 'after',
                        }"
                    >
                        <q-td @click.stop="toggleExpand(props.row)">
                            <div
                                class="row items-center no-wrap"
                                :style="{
                                    paddingLeft: !filterText
                                        ? props.row.level * 20 + 'px'
                                        : null,
                                }"
                            >
                                <div style="width: 30px">
                                    <q-btn
                                        flat
                                        round
                                        dense
                                        :icon="
                                            props.row.expanded
                                                ? 'keyboard_arrow_down'
                                                : 'keyboard_arrow_right'
                                        "
                                        size="sm"
                                        v-if="props.row.has_childs"
                                    />
                                </div>

                                <span class="cursor-pointer">
                                    <q-icon
                                        :name="getIcon(props.row)"
                                        size="xs"
                                    />
                                    {{ props.row.plural_label }}
                                </span>
                            </div>
                        </q-td>
                    </q-tr>
                </template>
            </q-table>
        </q-page>
    </Layout>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeMount } from "vue";
import { format, useQuasar, date, Dark } from "quasar";
import Layout from "../../layouts/AdminLayout.vue";
import QBtnComponent from "../../components/base/QBtnComponent.vue";
import BtnReloadComponent from "../../components/btn/BtnReloadComponent.vue";
import BtnAddComponent from "../../components/btn/BtnAddComponent.vue";
import BtnEditComponent from "../../components/btn/BtnEditComponent.vue";
import BtnDownloadComponent from "../../components/btn/BtnDownloadComponent.vue";
import BtnShowHideComponent from "../../components/btn/BtnShowHideComponent.vue";
import { router, useForm, usePage } from "@inertiajs/vue3";

const $q = useQuasar();
const filterText = ref("");
const expandedIds = ref([]);
const isDraggingOver = ref(null);
const sortBy = ref("name");
const sortOrder = ref("asc");
const loading = ref(false);

const columns = [
    {
        name: "plural_label",
        label: "nombre",
        align: "left",
    },
];

const rows = computed(() => {
    return usePage().props.modules ?? [];
});

const handleSort = (colName) => {
    if (sortBy.value !== colName) {
        sortBy.value = colName;
        sortOrder.value = "asc";
    } else if (sortOrder.value === "asc") {
        sortOrder.value = "desc";
    } else {
        sortBy.value = null;
        sortOrder.value = null;
    }
};

const visibleRows = computed(() => {
    const result = [];
    const presentIds = new Set(rows.value.map((d) => d.id));

    const processItems = (parentId, level) => {
        let children = rows.value.filter((item) => item.parent_id === parentId);

        children.sort((a, b) => {
            if (a.parent_id !== b.parent_id) {
                return b.parent_id - a.parent_id;
            }
            if (!sortBy.value) {
                return (a.order || 0) - (b.order || 0);
            } else {
                const field = sortBy.value;
                const factor = sortOrder.value === "asc" ? 1 : -1;
                if (a[field] < b[field]) return -1 * factor;
                if (a[field] > b[field]) return 1 * factor;
                return 0;
            }
        });

        children.forEach((child) => {
            const matchesFilter = child.plural_label
                .toLowerCase()
                .includes(filterText.value.toLowerCase());
            const isExpanded = expandedIds.value.includes(child.id);

            if (!filterText.value || matchesFilter) {
                result.push({ ...child, level, expanded: isExpanded });
            }

            if (child.has_childs && (isExpanded || filterText.value)) {
                processItems(child.id, level + 1);
            }
        });
    };
    const rootElements = rows.value.filter(
        (item) => item.parent_id === null || !presentIds.has(item.parent_id),
    );
    const rootParentIds = [...new Set(rootElements.map((el) => el.parent_id))];

    rootParentIds.forEach((pId) => {
        processItems(pId, 0);
    });

    return result;
});

const draggedItem = ref(null);

const dropPosition = ref(null);

const isDescendant = (targetId, draggedId) => {
    let current = rows.value.find((d) => d.id === targetId);
    while (current && current.parent_id) {
        if (current.parent_id === draggedId) return true;
        current = rows.value.find((d) => d.id === current.parent_id);
    }
    return false;
};

const onDragStart = (event, row) => {
    draggedItem.value = row;
    event.dataTransfer.setData("itemId", row.id);
    event.dataTransfer.dropEffect = "move";
};

const onDragOver = (event, targetRow) => {
    const draggedId = draggedItem.value?.id;
    if (
        !draggedId ||
        targetRow.id === draggedId ||
        isDescendant(targetRow.id, draggedId)
    ) {
        event.dataTransfer.dropEffect = "none";
        isDraggingOver.value = null;
        dropPosition.value = null;
        return;
    }

    event.preventDefault();
    event.dataTransfer.dropEffect = "move";

    const rect = event.currentTarget.getBoundingClientRect();
    const y = event.clientY - rect.top;
    const threshold = rect.height / 4;

    if (y < threshold) {
        dropPosition.value = "before";
        isDraggingOver.value = targetRow.id;
    } else if (y > rect.height - threshold) {
        dropPosition.value = "after";
        isDraggingOver.value = targetRow.id;
    } else if (targetRow.has_childs) {
        dropPosition.value = "inside";
        isDraggingOver.value = targetRow.id;
    } else {
        dropPosition.value = y < rect.height / 2 ? "before" : "after";
        isDraggingOver.value = targetRow.id;
    }
};

const onDrop = (event, targetRow) => {
    const draggedId = parseInt(event.dataTransfer.getData("itemId"));
    const dragged = rows.value.find((i) => i.id === draggedId);
    const position = dropPosition.value;

    isDraggingOver.value = null;
    dropPosition.value = null;

    if (!dragged || !position || targetRow.id === dragged.id) return;

    let newParentId = dragged.parent_id;

    if (position === "inside") {
        newParentId = targetRow.id;
    } else {
        newParentId = targetRow.parent_id;
    }

    useForm({
        parent_id: newParentId,
        target_id: targetRow.id,
        drop_position: position,
    }).put(`/admin/modules/${dragged.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            if (
                position === "inside" &&
                !expandedIds.value.includes(targetRow.id)
            ) {
                expandedIds.value.push(targetRow.id);
            }
        },
    });
    draggedItem.value = null;
};

const toggleExpand = (row) => {
    if (row.has_childs) {
        const idx = expandedIds.value.indexOf(row.id);
        idx > -1
            ? expandedIds.value.splice(idx, 1)
            : expandedIds.value.push(row.id);
    }
};

const expandAll = () =>
    (expandedIds.value = rows.value
        .filter((i) => i.has_childs)
        .map((i) => i.id));
const collapseAll = () => (expandedIds.value = []);

const getIcon = (row) => {
    let { ico, ico_from_path } = row;
    if (ico_from_path) {
        let img = `img:${usePage().props.public_path}`;
        if (Dark.isActive) {
            ico = ico.replace("black", "white");
        } else {
            ico = ico.replace("white", "black");
        }
        return `${img}${ico}`;
    }
    return ico;
};
</script>
<style>
.target-folder-active {
    background-color: #e3f2fd !important;
    outline: 2px dashed #2196f3;
    outline-offset: -4px;
}

.drop-before td {
    box-shadow: inset 0 2px 0 0 #2196f3 !important;
}

.drop-after td {
    box-shadow: inset 0 -2px 0 0 #2196f3 !important;
}

[draggable="true"] {
    cursor: grab;
}
[draggable="true"]:active {
    cursor: grabbing;
}

.q-table__top {
    padding: 0px !important;
    border-bottom: 1px solid rgba(0, 0, 0, 0.12);
}

.q-table__top .q-btn {
    margin-left: 5px;
}

th:nth-child(1),
tbody > tr > td:nth-child(1) {
    left: 0;
}

.q-table td.actions-def,
th:nth-child(1),
tbody > tr > td:nth-child(1),
.q-table th.last-column-sticky {
    position: sticky;
    z-index: 99;
    background-color: #fff;
}

.q-table--dark td.actions-def,
.q-table--dark th:nth-child(1),
.q-table--dark th.last-column-sticky,
.q-table--dark tbody > tr > td:nth-child(1) {
    background-color: #1d222e;
}

td.actions-def > .q-btn {
    margin-right: 3px;
}

.q-table th.last-column-sticky {
    right: 0;
}
</style>
