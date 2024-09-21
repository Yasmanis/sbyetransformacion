<template>
  <div class="q-pa-md">
    <q-breadcrumbs
      style="font-size: 14px"
      :active-color="$q.dark.isActive ? 'white' : 'dark'"
      class="text-primary"
    >
      <template v-slot:separator>
        <q-icon
          size="1.2em"
          name="arrow_forward"
          :color="$q.dark.isActive ? 'white' : 'dark'"
        />
      </template>
      <q-breadcrumbs-el
        :label="$t('modules.home')"
        icon="home"
        class="cursor-pointer"
        @click="setHome"
      />
      <q-breadcrumbs-el
        :label="$t(`models.${nav.plural_label}`)"
        :icon="nav.ico"
      />
    </q-breadcrumbs>
  </div>
  <q-separator></q-separator>
</template>
<script setup>
import { useRouter } from "vue-router";
import { $t } from "src/services/i18n";
import { useQuasar } from "quasar";
defineOptions({
  name: "BreadcrumbsComponent",
});
const props = defineProps({
  nav: {
    type: Object,
    required: true,
    default: () => {},
  },
});
const emit = defineEmits(["change-url"]);
const $router = useRouter();
const $q = useQuasar();
function setHome() {
  $router.push({ name: "crud" });
  emit("change-url", null);
}
</script>
