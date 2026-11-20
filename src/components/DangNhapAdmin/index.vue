<template>
    <main class="login-page">
      <section class="login-shell">
        <!-- Bên trái -->
        <div class="login-showcase">
          <div class="brand">
            <div class="brand-icon">
              <i class="fa-solid fa-cube"></i>
            </div>
            <span>TECH<span>SHOP</span></span>
          </div>
  
          <div class="showcase-content">
            <div class="eyebrow">
              <span class="eyebrow-dot"></span>
              ADMINISTRATION PORTAL
            </div>
  
            <h1>
              Quản lý công nghệ.
              <span>Vận hành thông minh.</span>
            </h1>
  
            <p>
              Không gian quản trị tập trung dành cho đội ngũ
              vận hành TECHSHOP.
            </p>
  
            <div class="showcase-graphic">
              <div class="graphic-glow"></div>
  
              <div class="graphic-card card-back">
                <i class="fa-solid fa-chart-line"></i>
                <span>Quản lý hiệu quả</span>
              </div>
  
              <div class="graphic-card card-main">
                <div class="graphic-card-heading">
                  <span class="graphic-dot"></span>
                  SYSTEM OVERVIEW
                </div>
  
                <div class="graphic-bars">
                  <span style="height: 38%"></span>
                  <span style="height: 60%"></span>
                  <span style="height: 47%"></span>
                  <span style="height: 78%"></span>
                  <span style="height: 62%"></span>
                  <span style="height: 92%"></span>
                  <span style="height: 70%"></span>
                </div>
  
                <div class="graphic-card-footer">
                  <span><i class="fa-solid fa-shield-halved"></i> Secure access</span>
                  <span>TECHSHOP</span>
                </div>
              </div>
            </div>
          </div>
  
          <div class="showcase-footer">
            <span>TECHSHOP MANAGEMENT SYSTEM</span>
            <span>© 2026</span>
          </div>
        </div>
  
        <!-- Bên phải -->
        <div class="login-panel">
          <div class="mobile-brand">
            <div class="brand-icon">
              <i class="fa-solid fa-cube"></i>
            </div>
            <span>TECH<span>SHOP</span></span>
          </div>
  
          <div class="login-form-wrap">
            <div class="login-badge">
              <i class="fa-solid fa-lock"></i>
              ADMIN ACCESS
            </div>
  
            <h2>Chào mừng trở lại!</h2>
            <p class="form-description">
              Đăng nhập bằng tài khoản quản trị của bạn.
            </p>
  
            <form @submit.prevent="dangNhap">
              <div class="form-group">
                <label for="email">Địa chỉ email</label>
  
                <div class="input-wrap">
                  <i class="fa-regular fa-envelope input-icon"></i>
  
                  <input
                    id="email"
                    v-model.trim="email"
                    type="email"
                    placeholder="Nhập email quản trị"
                    autocomplete="username"
                    required
                    :disabled="loading"
                  />
                </div>
              </div>
  
              <div class="form-group">
                <div class="password-label">
                  <label for="password">Mật khẩu</label>
                </div>
  
                <div class="input-wrap">
                  <i class="fa-solid fa-key input-icon"></i>
  
                  <input
                    id="password"
                    v-model="password"
                    :type="showPassword ? 'text' : 'password'"
                    placeholder="Nhập mật khẩu"
                    autocomplete="current-password"
                    required
                    :disabled="loading"
                  />
  
                  <button
                    class="password-toggle"
                    type="button"
                    :aria-label="showPassword ? 'Ẩn mật khẩu' : 'Hiện mật khẩu'"
                    @click="showPassword = !showPassword"
                  >
                    <i
                      :class="showPassword
                        ? 'fa-regular fa-eye-slash'
                        : 'fa-regular fa-eye'"
                    ></i>
                  </button>
                </div>
              </div>
  
              <div v-if="errorMessage" class="error-message" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>{{ errorMessage }}</span>
              </div>
  
              <button
                class="login-button"
                type="submit"
                :disabled="loading"
              >
                <i
                  v-if="loading"
                  class="fa-solid fa-spinner fa-spin"
                ></i>
  
                <span>
                  {{ loading ? "Đang xác thực..." : "Đăng nhập hệ thống" }}
                </span>
  
                <i
                  v-if="!loading"
                  class="fa-solid fa-arrow-right"
                ></i>
              </button>
            </form>
  
            <div class="security-note">
              <i class="fa-solid fa-shield-halved"></i>
              <span>Kết nối và xác thực với máy chủ TECHSHOP</span>
            </div>
          </div>
  
          <div class="panel-footer">
            <span>TECHSHOP ADMIN</span>
            <span>Hệ thống quản trị nội bộ</span>
          </div>
        </div>
      </section>
    </main>
  </template>
  
 
<script>
import axios from "axios";

const API = "http://127.0.0.1:8000/api";

export default {
  name: "DangNhapAdmin",

  data() {
    return {
      email: "",
      password: "",
      showPassword: false,
      loading: false,
      errorMessage: ""
    };
  },

  methods: {
    async dangNhap() {
      if (this.loading) return;

      this.loading = true;
      this.errorMessage = "";

      try {
        // Bước 1: Gửi đúng tên trường backend yêu cầu
        const res = await axios.post(`${API}/admin/dang-nhap`, {
          Email: this.email,
          MatKhau: this.password
        });

        if (!res.data.status) {
          this.errorMessage =
            res.data.message || "Đăng nhập thất bại.";
          return;
        }

        // Backend trả token bên trong data
        const token = res.data.data?.token;

        if (!token) {
          this.errorMessage = "Máy chủ chưa trả về token đăng nhập.";
          return;
        }

        // Bước 2: Kiểm tra token Admin
        const check = await axios.get(`${API}/admin/check-token`, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });

        if (!check.data.status) {
          this.errorMessage =
            check.data.message || "Tài khoản không có quyền Admin.";
          return;
        }

        // Bước 3: Lưu thông tin đăng nhập
        const nguoiDung =
          check.data.data || res.data.data?.nguoi_dung;

        localStorage.setItem("admin_token", token);
        localStorage.setItem(
          "admin_name",
          nguoiDung?.HoTen || this.email
        );
        localStorage.setItem("admin_logged_in", "true");

        // Bước 4: Chuyển vào trang quản trị
        await this.$router.replace("/admin/sanpham");

      } catch (error) {
        console.error(
          "Lỗi đăng nhập Admin:",
          error.response?.data || error
        );

        const status = error.response?.status;
        const data = error.response?.data;

        if (status === 422) {
          this.errorMessage =
            Object.values(data.errors || {})
              .flat()
              .join(" ");
        } else if (status === 401) {
          this.errorMessage =
            data.message || "Email hoặc mật khẩu không chính xác.";
        } else if (status === 403) {
          this.errorMessage =
            data.message || "Tài khoản không có quyền Admin.";
        } else {
          this.errorMessage =
            data.message || "Không kết nối được máy chủ TECHSHOP.";
        }
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>

  <style scoped>
  * {
    box-sizing: border-box;
  }
  
  .login-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 28px;
    background:
      radial-gradient(circle at 10% 10%, #e3edff 0, transparent 34%),
      radial-gradient(circle at 90% 90%, #dce7fc 0, transparent 35%),
      #f2f5fb;
    font-family: "Roboto", Arial, sans-serif;
  }
  
  .login-shell {
    display: grid;
    grid-template-columns: 1.05fr 0.95fr;
    width: 100%;
    max-width: 1160px;
    min-height: 690px;
    overflow: hidden;
    background: #fff;
    border: 1px solid rgba(220, 229, 243, 0.8);
    border-radius: 24px;
    box-shadow: 0 28px 85px rgba(20, 43, 83, 0.13);
  }
  
  .login-showcase {
    position: relative;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    padding: 38px 44px 25px;
    color: #fff;
    background:
      radial-gradient(circle at 80% 70%, rgba(47, 104, 228, 0.26), transparent 35%),
      linear-gradient(145deg, #12294d 0%, #0c1931 55%, #101e3a 100%);
  }
  
  .login-showcase::before {
    position: absolute;
    inset: 0;
    pointer-events: none;
    content: "";
    opacity: 0.16;
    background-image:
      linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px),
      linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px);
    background-size: 38px 38px;
    mask-image: linear-gradient(to bottom, black, transparent 90%);
  }
  
  .brand,
  .mobile-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 21px;
    font-weight: 800;
    letter-spacing: 1px;
  }
  
  .brand > span > span,
  .mobile-brand > span > span {
    color: #82adff;
  }
  
  .brand-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 42px;
    height: 42px;
    border: 1px solid rgba(255,255,255,.2);
    border-radius: 12px;
    color: #fff;
    background: linear-gradient(145deg, #4c86ff, #2452c9);
    box-shadow: 0 8px 20px rgba(24, 87, 221, 0.28);
  }
  
  .showcase-content {
    position: relative;
    z-index: 1;
    margin: auto 0;
    padding-top: 36px;
  }
  
  .eyebrow,
  .login-badge {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    color: #8db3ff;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.7px;
  }
  
  .eyebrow-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #6fa1ff;
    box-shadow: 0 0 12px #6fa1ff;
  }
  
  .showcase-content h1 {
    max-width: 470px;
    margin: 24px 0 17px;
    font-size: clamp(32px, 3.2vw, 43px);
    line-height: 1.2;
    font-weight: 800;
    letter-spacing: -1.5px;
  }
  
  .showcase-content h1 span {
    display: block;
    color: #8fb5ff;
  }
  
  .showcase-content > p {
    max-width: 390px;
    margin: 0;
    color: #aebcd4;
    font-size: 14px;
    line-height: 1.8;
  }
  
  .showcase-graphic {
    position: relative;
    height: 230px;
    margin-top: 28px;
  }
  
  .graphic-glow {
    position: absolute;
    top: 30px;
    left: 22%;
    width: 250px;
    height: 150px;
    border-radius: 50%;
    background: rgba(44, 101, 226, 0.2);
    filter: blur(45px);
  }
  
  .graphic-card {
    position: absolute;
    border: 1px solid rgba(191, 211, 248, 0.16);
    border-radius: 15px;
    background: rgba(255,255,255,.055);
    backdrop-filter: blur(12px);
  }
  
  .card-back {
    top: 56px;
    right: 0;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 17px;
    color: #b8c9e8;
    font-size: 11px;
    transform: rotate(4deg);
  }
  
  .card-back i {
    color: #7ea7ff;
    font-size: 20px;
  }
  
  .card-main {
    top: 14px;
    left: 0;
    width: 78%;
    padding: 18px 19px 14px;
    box-shadow: 0 24px 55px rgba(0, 0, 0, 0.17);
  }
  
  .graphic-card-heading {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #b9c8e3;
    font-size: 9px;
    letter-spacing: 1px;
  }
  
  .graphic-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #72e1b0;
  }
  
  .graphic-bars {
    display: flex;
    align-items: flex-end;
    justify-content: space-around;
    gap: 13px;
    height: 112px;
    padding: 18px 5px 0;
    border-bottom: 1px solid rgba(255,255,255,.12);
  }
  
  .graphic-bars span {
    flex: 1;
    max-width: 24px;
    border-radius: 5px 5px 0 0;
    background: linear-gradient(to top, #2d63de, #86b5ff);
    opacity: 0.95;
  }
  
  .graphic-card-footer {
    display: flex;
    justify-content: space-between;
    gap: 10px;
    padding-top: 13px;
    color: #8298bc;
    font-size: 8px;
    letter-spacing: 0.8px;
  }
  
  .graphic-card-footer span:first-child {
    display: flex;
    align-items: center;
    gap: 6px;
  }
  
  .graphic-card-footer i {
    color: #79dfb0;
  }
  
  .showcase-footer {
    position: relative;
    display: flex;
    justify-content: space-between;
    gap: 12px;
    color: #8193b2;
    font-size: 9px;
    letter-spacing: 1px;
  }
  
  .login-panel {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-width: 0;
    padding: 44px clamp(28px, 5vw, 70px) 28px;
  }
  
  .mobile-brand {
    display: none;
    color: #172b4d;
  }
  
  .login-form-wrap {
    width: 100%;
    max-width: 370px;
    margin: auto;
    padding: 36px 0;
  }
  
  .login-badge {
    padding: 8px 11px;
    border: 1px solid #e0eaff;
    border-radius: 7px;
    color: #3869d6;
    background: #f2f6ff;
    font-size: 9px;
    letter-spacing: 1px;
  }
  
  .login-form-wrap h2 {
    margin: 23px 0 9px;
    color: #192d4c;
    font-size: 29px;
    font-weight: 800;
    letter-spacing: -0.8px;
  }
  
  .form-description {
    margin: 0 0 31px;
    color: #8794a9;
    font-size: 13px;
    line-height: 1.7;
  }
  
  .form-group {
    margin-bottom: 21px;
  }
  
  .form-group label {
    display: block;
    margin-bottom: 9px;
    color: #354762;
    font-size: 12px;
    font-weight: 700;
  }
  
  .input-wrap {
    display: flex;
    align-items: center;
    gap: 12px;
    min-height: 49px;
    padding: 0 14px;
    border: 1px solid #dfe6f1;
    border-radius: 9px;
    background: #fbfcfe;
    transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
  }
  
  .input-wrap:focus-within {
    border-color: #7298f4;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(50, 100, 220, 0.08);
  }
  
  .input-icon {
    flex-shrink: 0;
    color: #8495b1;
    font-size: 15px;
  }
  
  .input-wrap input {
    flex: 1;
    width: 100%;
    min-width: 0;
    padding: 14px 0;
    border: 0;
    outline: 0;
    color: #203653;
    background: transparent;
    font-family: inherit;
    font-size: 12px;
  }
  
  .input-wrap input::placeholder {
    color: #a3aec0;
  }
  
  .input-wrap input:disabled {
    cursor: wait;
  }
  
  .password-toggle {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    width: 28px;
    height: 30px;
    padding: 0;
    border: 0;
    color: #8593a8;
    background: transparent;
    cursor: pointer;
  }
  
  .password-toggle:hover {
    color: #285ed8;
  }
  
  .error-message {
    display: flex;
    align-items: flex-start;
    gap: 9px;
    margin: 0 0 18px;
    padding: 12px;
    border: 1px solid #f5d5d8;
    border-radius: 8px;
    color: #be3d4a;
    background: #fff5f5;
    font-size: 12px;
    line-height: 1.6;
  }
  
  .error-message i {
    margin-top: 2px;
  }
  
  .login-button {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 11px;
    width: 100%;
    min-height: 49px;
    margin-top: 26px;
    padding: 0 17px;
    border: 0;
    border-radius: 9px;
    color: #fff;
    background: linear-gradient(110deg, #2f68e8, #2352cb);
    box-shadow: 0 8px 19px rgba(38, 91, 216, 0.2);
    cursor: pointer;
    font-family: inherit;
    font-size: 12px;
    font-weight: 700;
    transition: transform 0.2s, box-shadow 0.2s;
  }
  
  .login-button:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 12px 24px rgba(38, 91, 216, 0.27);
  }
  
  .login-button:disabled {
    opacity: 0.7;
    cursor: wait;
  }
  
  .login-button > span {
    flex: 1;
  }
  
  .security-note {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    margin-top: 25px;
    color: #8b99ad;
    font-size: 10px;
  }
  
  .security-note i {
    color: #2da579;
  }
  
  .panel-footer {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
    color: #9aa6b8;
    font-size: 9px;
  }
  
  .panel-footer span:first-child {
    color: #63738b;
    font-weight: 700;
    letter-spacing: 1px;
  }
  
  @media (max-width: 800px) {
    .login-page {
      padding: 15px;
    }
  
    .login-shell {
      grid-template-columns: 1fr;
      max-width: 470px;
      min-height: 0;
      border-radius: 18px;
    }
  
    .login-showcase {
      display: none;
    }
  
    .login-panel {
      min-height: 620px;
      padding: 25px clamp(24px, 7vw, 44px) 22px;
    }
  
    .mobile-brand {
      display: flex;
    }
  
    .login-form-wrap {
      padding: 35px 0;
    }
  
    .panel-footer {
      justify-content: center;
    }
  }
  
  @media (max-width: 380px) {
    .login-panel {
      padding-right: 20px;
      padding-left: 20px;
    }
  
    .login-form-wrap h2 {
      font-size: 25px;
    }
  }
  </style>