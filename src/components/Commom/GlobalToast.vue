<template>
    <Transition name="toast">
      <div
        v-if="toast.hien"
        class="global-toast"
        :class="'toast-' + toast.loai"
      >
        <i :class="icon"></i>
  
        <div class="toast-content">
          <strong>{{ toast.tieuDe }}</strong>
          <div>{{ toast.noiDung }}</div>
        </div>
  
        <button class="toast-close" @click="toast.hien = false">
          &times;
        </button>
      </div>
    </Transition>
  </template>
  
  <script>
  import { reactive, computed } from "vue";
  
  export const toast = reactive({
    hien: false,
    loai: "success",
    tieuDe: "",
    noiDung: "",
  });
  
  let timer = null;
  
  export function hienThongBao(noiDung, loai = "success", tieuDe = "") {
    clearTimeout(timer);
  
    toast.loai = loai;
    toast.tieuDe =
      tieuDe ||
      (loai === "success"
        ? "Thành công"
        : loai === "error"
        ? "Có lỗi xảy ra"
        : "Thông báo");
    toast.noiDung = String(noiDung);
    toast.hien = true;
  
    timer = setTimeout(() => {
      toast.hien = false;
    }, 3000);
  }
  
  export default {
    setup() {
      const icon = computed(() => {
        if (toast.loai === "success") return "fa-solid fa-circle-check";
        if (toast.loai === "error") return "fa-solid fa-circle-xmark";
        return "fa-solid fa-circle-info";
      });
  
      return { toast, icon };
    },
  };
  </script>
  
  <style scoped>
  .global-toast {
    position: fixed;
    top: 24px;
    right: 24px;
    z-index: 999999;
    display: flex;
    align-items: center;
    gap: 14px;
    width: 360px;
    max-width: calc(100vw - 32px);
    padding: 18px;
    background: white;
    color: #333;
    border-left: 5px solid #16a34a;
    border-radius: 12px;
    box-shadow: 0 8px 30px #0002;
  }
  
  .global-toast > i {
    font-size: 27px;
    color: #16a34a;
  }
  
  .toast-error {
    border-left-color: #dc2626;
  }
  
  .toast-error > i {
    color: #dc2626;
  }
  
  .toast-info {
    border-left-color: #2563eb;
  }
  
  .toast-info > i {
    color: #2563eb;
  }
  
  .toast-content {
    flex: 1;
    overflow-wrap: anywhere;
    font-size: 14px;
  }
  
  .toast-content strong {
    display: block;
    margin-bottom: 5px;
  }
  
  .toast-close {
    align-self: flex-start;
    border: 0;
    background: transparent;
    color: #888;
    font-size: 24px;
    cursor: pointer;
  }
  
  .toast-enter-active,
  .toast-leave-active {
    transition: all 0.3s ease;
  }
  
  .toast-enter-from,
  .toast-leave-to {
    opacity: 0;
    transform: translateX(35px);
  }
  </style>