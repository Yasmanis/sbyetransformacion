import { store } from "quasar/wrappers";
import { createPinia } from "pinia";
import { storePlugin } from "pinia-plugin-store";
import { utils } from "src/helpers/utils";
import { LocalStorage } from "quasar";

export default store((/* { ssrContext } */) => {
  const pinia = createPinia();

  const { encrypt, decrypt } = utils;

  const stores = storePlugin({
    stores: [
      {
        name: "appStore",
        ciphertext:
          process.env.NODE_ENV?.toString() === "production" ||
          process.env.STORAGE_CIPHER?.toString() === "true"
            ? true
            : false,
        storage: localStorage,
      },
    ],
    encrypt,
    decrypt,
  });

  pinia.use(stores);

  return pinia;
});
