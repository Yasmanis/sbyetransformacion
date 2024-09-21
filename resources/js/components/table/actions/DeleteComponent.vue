<template>
  <q-btn-component
    :tooltips="$q.lang.label.remove"
    :size="size"
    icon="mdi-minus"
    color="red"
    @click="handleConfirm"
  />

  <q-dialog v-model="showDialog">
    <q-card style="width: 700px; max-width: 80vw">
      <q-card-section class="row items-center header">
        <div class="text-h6">
          <q-icon name="fa fa-question-circle"></q-icon> Confirmaci&oacute;n
        </div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>
      <q-separator inset />
      <q-card-section>
        <div class="title text-justify" v-if="objects.length === 1">
          {{
            $t("notifications.sConfirmDelete", {
              object: objectStr,
            })
          }}
        </div>
        <div class="title text-justify" v-else>
          {{
            $t("notifications.mConfirmDelete", {
              name: $t(`models.${collection}`),
            })
          }}
        </div>
        <q-tree :nodes="nodes" node-key="collectionId" default-expand-all />
        <div class="text-center">Desea continuar?</div>
      </q-card-section>
      <q-separator inset />
      <q-card-actions align="right" class="bg-white text-teal">
        <q-btn flat color="red" label="Si" @click="handleDelete">
          <template v-slot:loading>
            <q-spinner-hourglass class="on-left" />
          </template>
        </q-btn>
        <q-btn flat label="No" color="secondary" v-close-popup />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script setup>
import { ref } from "vue";
import { useQuasar, runSequentialPromises } from "quasar";
import QBtnComponent from "src/components/base/QBtnComponent.vue";
import { useCollectionsStore } from "src/stores/collections";
import { $t } from "src/services/i18n";
import { success, error, errorException } from "src/helpers/notifications";
defineOptions({
  name: "DeleteComponent",
});

const props = defineProps({
  collection: String,
  modelName: String,
  objects: {
    type: Array,
    required: true,
    default: () => [],
  },
  size: {
    type: String,
    default: "sm",
  },
});

const emit = defineEmits(["deleted"]);

const $q = useQuasar();

const store = useCollectionsStore();

const nodes = ref(null);

const objectStr = ref(null);

const showDialog = ref(false);

const handleConfirm = async () => {
  try {
    if (props.objects.length === 0) {
      error($t("notifications.emptySelected"));
    } else {
      const data = await store.removeConfirm(
        props.collection,
        JSON.stringify(props.objects.map((o) => o.id))
      );
      nodes.value = [data.tree];
      objectStr.value = data.objectStr;
      showDialog.value = true;
    }
  } catch (e) {
    errorException(e);
  }
};

const handleDelete = async () => {
  try {
    const temp = [];
    for (let index = 0; index < props.objects.length; index++) {
      temp.push(() => store.remove(props.collection, props.objects[index].id));
    }
    runSequentialPromises(temp)
      .then((result) => {
        success(
          $t("notifications.deleted", {
            model: $t(`models.${props.modelName ? props.modelName : "object"}`),
          })
        );
        showDialog.value = false;
        emit("deleted", props.objects);
      })
      .catch((errResult) => {
        console.error(`Error encountered on job #${errResult.key}:`);
        console.error(errResult.reason);
        console.log("Managed to get these results before this error:");
        console.log(errResult.result);
      });
  } catch (e) {
    errorException(e);
  } finally {
  }
};
</script>
