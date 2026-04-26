<template>
    <Layout>
        <q-page>
            <table-component
                :documents="$page.props.documents"
                :user="$page.props.auth.user"
                has-title
            ></table-component>
        </q-page>
    </Layout>
</template>

<script setup>
import Layout from "../../layouts/AdminLayout.vue";
import TableComponent from "../../components/modules/document/TableComponent.vue";

defineOptions({
    name: "ListPage",
});
</script>
