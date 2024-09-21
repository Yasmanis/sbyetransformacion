import { defineStore } from "pinia";
import app from "src/config/app";
export const useAppStore = defineStore(`${process.env.APP_NAME}_APP`, {
  state: () => ({
    appName: app.name,
    locale: "",
    theme: "",
    dark: false,
    user: null,
    token: "",
    loading: false,
    leftDrawer: {
      show: false,
      mini: false,
      width: 250,
    },
    breadcrumbs: [],
    config: [],
    notifications: [],
  }),
  getters: {
    isDark: (state) => state.dark,
  },
  actions: {
    reset() {
      this.appName = "";
      this.locale = "";
      this.theme = "";
      this.dark = false;
      this.user = null;
      this.token = "";
      this.loading = false;
      this.leftDrawer = {
        show: false,
        mini: false,
        width: 250,
      };
      this.breadcrumbs = [];
      this.config = [];
      this.messages = [];
      this.notifications = [];
    },
    setState(data) {
      if (data.appName) this.appName = data.appName;
      if (data.locale) this.locale = data.locale;
      if (data.theme) this.theme = data.theme;
      if (data.user) this.user = data.user;
      if (data.token) this.token = data.token;
      if (data.locale) this.locale = data.locale;
      if (data.breadcrumbs) this.breadcrumbs = data.breadcrumbs;
      if (data.config) this.config = data.config;
      if (data.notifications) this.notifications = data.notifications;
      if (data.dark) this.dark = data.dark;
      if (data.notifications) this.notifications = data.notifications;
    },
    toggleLeftDrawer() {
      if (!this.leftDrawer.showDrawer && !this.leftDrawer.mini) {
        this.leftDrawer.showDrawer = true;
        this.leftDrawer.mini = false;
      } else if (this.leftDrawer.showDrawer && !this.leftDrawer.mini) {
        this.leftDrawer.mini = true;
      } else if (this.leftDrawer.showDrawer && this.leftDrawer.mini) {
        this.leftDrawer.showDrawer = false;
        this.leftDrawer.mini = false;
      }
    },

    toggleLoading() {
      this.loading = !this.loading;
    },
    toggleFullscreen() {
      this.fullScreen = !this.fullScreen;
    },
  },
});
