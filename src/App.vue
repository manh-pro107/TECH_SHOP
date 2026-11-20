<!-- <template>
  <component :is="layout">
      <router-view></router-view>

      <GlobalToast />
  </component>
</template>

<script>
 import GlobalToast from "./components/Commom/GlobalToast.vue";
  const default_layout = "default";
export default {
  computed: {
    layout() {
      return (this.$route.meta.layout || default_layout) + "-layout";
    },
  },
};
</script>
<style>
</style> -->
<template>
  <component :is="layout">
    <router-view />
    <GlobalToast />
  </component>
</template>

<script>
import GlobalToast from "./components/Commom/GlobalToast.vue";

const default_layout = "default";

export default {
  components: {
    GlobalToast,
  },

  computed: {
    layout() {
      const currentLayout = this.$route.meta.layout || default_layout;

      // Các trang đăng nhập dùng layout trống, không cần sidebar/header.
      // Dùng thẻ div native để không cần tạo component blank-layout riêng.
      if (currentLayout === "blank") {
        return "div";
      }

      return `${currentLayout}-layout`;
    },
  },
};
</script>
