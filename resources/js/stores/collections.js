import { defineStore } from "pinia";

export const useCollectionsStore = defineStore("collections", () => {
    const pbClient = new PocketBase(
        process.env.POCKETBASE_URL || "http://127.0.0.1:8090"
    );

    async function fetch(collectionName, page, perPage, config) {
        // const records = await pbClient
        //   .collection(collectionName)
        //   .getList(page || 1, perPage || 20, config || null);
        return [];
    }

    async function fetchAll(collectionName, config) {
        // const records = await pbClient
        //   .collection(collectionName)
        //   .getFullList(config || null);
        return [];
    }

    async function first(collectionName, query, config) {
        const record = await pbClient
            .collection(collectionName)
            .getFirstListItem(query, config || null);
        return record;
    }

    async function findById(collectionName, id, config) {
        const record = await pbClient
            .collection(collectionName)
            .getOne(id, config || null);
        return record;
    }

    async function create(collectionName, data) {
        const record = await pbClient.collection(collectionName).create(data);
        return record;
    }

    async function update(collectionName, id, data) {
        const record = await pbClient
            .collection(collectionName)
            .update(id, data);
        return record;
    }

    async function removeConfirm(collectionName, ids) {
        const objects = await pbClient.send(
            `/confirm_delete/${collectionName}`,
            {
                ids: ids,
            }
        );
        return objects;
    }

    async function remove(collectionName, id) {
        await pbClient.collection(collectionName).delete(id);
    }

    async function subscribe(collectionName, field) {
        await pbClient.collection(collectionName).subscribe(
            field,
            function (e) {
                return {
                    action: e.action,
                    record: e.record,
                };
            },
            {
                /* other options like expand, custom headers, etc. */
            }
        );
    }

    async function unsubscribe(collectionName, field) {
        await pbClient.collection(collectionName).unsubscribe(field);
    }

    async function unsubscribeAll(collectionName, field) {
        await pbClient.collection(collectionName).unsubscribe();
    }

    return {
        fetch,
        fetchAll,
        first,
        findById,
        create,
        update,
        removeConfirm,
        remove,
        subscribe,
        unsubscribe,
        unsubscribeAll,
    };
});
