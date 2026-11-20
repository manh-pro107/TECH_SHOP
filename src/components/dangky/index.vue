
<template>
    <main class="auth-page">
      <div class="ambient ambient-one"></div>
      <div class="ambient ambient-two"></div>
      <div class="grid-glow"></div>
  
      <div class="auth-shell">
        <!-- KHUNG THƯƠNG HIỆU -->
        <aside class="visual-panel">
          <div class="brand-row">
            <div class="brand-mark">
              <i class="bx bx-chip"></i>
            </div>
            <div class="brand-name">
              TECH<span>SHOP</span>
              <small>GEAR UP. LEVEL UP.</small>
            </div>
          </div>
  
          <div class="visual-copy">
            <span class="eyebrow">
              <span class="status-dot"></span>
              JOIN THE NEXT GENERATION
            </span>
  
            <h1>
              Your journey<br />
              starts <span>here.</span>
            </h1>
  
            <p>
              Tạo tài khoản TECHSHOP để khám phá thế giới công nghệ,
              cập nhật sản phẩm mới và bắt đầu hành trình của riêng bạn.
            </p>
  
            <div class="feature-list">
              <div class="feature-item">
                <span class="feature-icon"><i class="bx bx-shield-quarter"></i></span>
                <div>
                  <b>Không gian của riêng bạn</b>
                  <small>Thông tin tài khoản được quản lý tập trung</small>
                </div>
              </div>
  
              <div class="feature-item">
                <span class="feature-icon"><i class="bx bx-bolt-circle"></i></span>
                <div>
                  <b>Khám phá công nghệ</b>
                  <small>Tìm thiết bị phù hợp với nhu cầu</small>
                </div>
              </div>
  
              <div class="feature-item">
                <span class="feature-icon"><i class="bx bx-rocket"></i></span>
                <div>
                  <b>Sẵn sàng nâng cấp</b>
                  <small>Bắt đầu trải nghiệm TECHSHOP ngay hôm nay</small>
                </div>
              </div>
            </div>
          </div>
  
          <div class="orbital-scene">
            <div class="orbit orbit-a"></div>
            <div class="orbit orbit-b"></div>
            <div class="orbit orbit-c"></div>
  
            <div class="core-chip">
              <i class="bx bx-chip"></i>
              <span>TECHSHOP</span>
            </div>
  
            <div class="orbit-node node-a"><i class="bx bx-laptop"></i></div>
            <div class="orbit-node node-b"><i class="bx bx-microchip"></i></div>
            <div class="orbit-node node-c"><i class="bx bx-game"></i></div>
            <div class="orbit-node node-d"><i class="bx bx-headphone"></i></div>
          </div>
  
          <div class="visual-footer">
            <span>© 2026 TECHSHOP</span>
            <span>BUILT FOR DIGITAL EXPLORERS</span>
          </div>
        </aside>
  
        <!-- FORM ĐĂNG KÝ -->
        <section class="form-panel">
          <div class="form-topline">
            <button
              class="mini-brand"
              type="button"
              @click="$router.push('/trang-chu')"
            >
              <span class="mini-mark"><i class="bx bx-chip"></i></span>
              TECHSHOP
            </button>
  
            <div class="signin-prompt">
              Đã có tài khoản?
              <button type="button" @click="$router.push('/dang-nhap')">
                Đăng nhập <i class="bx bx-arrow-up-right"></i>
              </button>
            </div>
          </div>
  
          <div class="form-content">
            <div class="form-heading">
              <div class="heading-icon">
                <i class="bx bx-user-plus"></i>
              </div>
  
              <span class="eyebrow">CREATE YOUR ACCOUNT</span>
              <h2>Tạo tài khoản <span>mới</span></h2>
              <p>
                Chỉ mất một chút thời gian để gia nhập cộng đồng TECHSHOP.
              </p>
            </div>
  
           
<form class="register-form" @submit.prevent="otpStep ? xacMinhOtp() : dangKy()">

<!-- GIAI ĐOẠN 1: NHẬP THÔNG TIN -->
<template v-if="!otpStep">

  <div class="field-group">
    <label for="register-name">Họ và tên <span>*</span></label>
    <div class="input-wrap">
      <i class="bx bx-user field-icon"></i>
      <input
        id="register-name"
        v-model.trim="hoTen"
        type="text"
        placeholder="Nhập họ và tên"
        autocomplete="name"
        maxlength="100"
      />
    </div>
  </div>

  <div class="field-group">
    <label for="register-email">Gmail <span>*</span></label>
    <div class="input-wrap">
      <i class="bx bx-envelope field-icon"></i>
      <input
        id="register-email"
        v-model="email"
        type="email"
        placeholder="name@gmail.com"
        autocomplete="email"
        maxlength="100"
      />
    </div>
  </div>

  <div class="field-group">
    <label for="register-phone">Số điện thoại</label>
    <div class="input-wrap">
      <i class="bx bx-phone field-icon"></i>
      <input
        id="register-phone"
        v-model="soDienThoai"
        type="tel"
        inputmode="numeric"
        maxlength="10"
        placeholder="Nhập 10 chữ số"
        autocomplete="tel"
        @input="locSoDienThoai"
      />
    </div>
  </div>

  <div class="field-group">
    <label for="register-password">Mật khẩu <span>*</span></label>
    <div class="input-wrap">
      <i class="bx bx-lock-alt field-icon"></i>
      <input
        id="register-password"
        v-model="password"
        type="password"
        placeholder="Tối thiểu 6 ký tự, không có khoảng trắng"
        autocomplete="new-password"
        maxlength="255"
      />
    </div>
  </div>

  <div class="field-group">
    <label for="register-confirm">
      Xác nhận mật khẩu <span>*</span>
    </label>
    <div class="input-wrap">
      <i class="bx bx-shield-quarter field-icon"></i>
      <input
        id="register-confirm"
        v-model="rePassword"
        type="password"
        placeholder="Nhập lại mật khẩu"
        autocomplete="new-password"
        maxlength="255"
      />
    </div>
  </div>

  <div class="privacy-note">
    <i class="bx bx-info-circle"></i>
    <span>
      TECHSHOP sẽ gửi mã OTP đến Gmail để xác minh trước khi tạo tài khoản.
    </span>
  </div>

  <button
    class="submit-button"
    type="submit"
    :disabled="isSubmitting"
  >
    <span>{{ isSubmitting ? "Đang gửi mã..." : "Gửi mã xác minh" }}</span>
    <i class="bx bx-right-arrow-alt"></i>
    <span class="button-glint"></span>
  </button>

</template>

<!-- GIAI ĐOẠN 2: NHẬP OTP -->
<template v-else>

  <div class="otp-note">
    <div class="otp-note-icon">
      <i class="bx bx-envelope"></i>
    </div>
    <h3>Xác minh Gmail</h3>
    <p>
      Mã OTP gồm 6 chữ số đã được gửi đến:
      <strong>{{ email }}</strong>
    </p>
    <small>Mã có hiệu lực trong 5 phút.</small>
  </div>

  <div class="field-group">
    <label for="register-otp">Mã xác minh OTP <span>*</span></label>
    <div class="input-wrap">
      <i class="bx bx-key field-icon"></i>
      <input
        id="register-otp"
        v-model="otp"
        type="text"
        inputmode="numeric"
        maxlength="6"
        placeholder="Nhập mã OTP 6 chữ số"
        autocomplete="one-time-code"
        @input="locOtp"
      />
    </div>
  </div>

  <button
    class="submit-button"
    type="submit"
    :disabled="isVerifying"
  >
    <span>{{ isVerifying ? "Đang xác minh..." : "Xác minh và tạo tài khoản" }}</span>
    <i class="bx bx-check-circle"></i>
    <span class="button-glint"></span>
  </button>

  <div class="otp-actions">
    <button
      type="button"
      class="resend-button"
      :disabled="resendCooldown > 0 || isResending"
      @click="guiLaiOtp"
    >
      {{
        isResending
          ? "Đang gửi lại..."
          : resendCooldown > 0
            ? `Gửi lại mã sau ${resendCooldown}s`
            : "Gửi lại mã OTP"
      }}
    </button>

    <button
      type="button"
      class="resend-button"
      @click="quayLaiDangKy"
    >
      Đổi thông tin đăng ký
    </button>
  </div>

</template>

<div class="divider">
  <span></span>
  <small>YOUR TECH WORLD AWAITS</small>
  <span></span>
</div>

<div class="secure-note">
  <i class="bx bx-shield-quarter"></i>
  <span>Bắt đầu hành trình công nghệ của bạn</span>
</div>

</form>

          </div>
  
          <div class="form-bottom">
            <span>DESIGNED FOR DIGITAL EXPLORERS</span>
            <div class="bottom-dots"><i></i><i></i><i></i></div>
          </div>
        </section>
      </div>
    </main>
  </template>
  

  <script>
  import { useToast } from "vue-toastification";
  import axios from "axios";
  
  const API = "http://127.0.0.1:8000/api/client/dang-ky";
  
  export default {
    data() {
      return {
        hoTen: "",
        email: "",
        soDienThoai: "",
        password: "",
        rePassword: "",
  
        otp: "",
        otpStep: false,
  
        isSubmitting: false,
        isVerifying: false,
        isResending: false,
  
        resendCooldown: 0,
        resendTimer: null,
      };
    },
  
    beforeUnmount() {
      this.clearResendTimer();
    },
  
    methods: {
      // Chỉ cho phép nhập chữ số vào số điện thoại.
      locSoDienThoai() {
        this.soDienThoai = this.soDienThoai
          .replace(/\D/g, "")
          .slice(0, 10);
      },
  
      // Chỉ cho phép nhập 6 chữ số OTP.
      locOtp() {
        this.otp = this.otp.replace(/\D/g, "").slice(0, 6);
      },
  
      // Kiểm tra Gmail.
      kiemTraGmail() {
        const email = this.email.trim().toLowerCase();
  
        // Không cho khoảng trắng.
        if (/\s/.test(this.email)) {
          return "Gmail không được chứa khoảng trắng.";
        }
  
        // Gmail không cho dấu chấm liên tiếp, đầu hoặc cuối tên.
        const gmailRegex =
          /^[a-z0-9]+(?:\.[a-z0-9]+)*@gmail\.com$/;
  
        if (!gmailRegex.test(email)) {
          return "Vui lòng nhập địa chỉ Gmail hợp lệ, ví dụ name@gmail.com.";
        }
  
        this.email = email;
        return "";
      },
  
      // Kiểm tra dữ liệu đăng ký.
      kiemTraDangKy() {
        if (!this.hoTen.trim()) {
          return "Vui lòng nhập họ và tên.";
        }
  
        if (this.hoTen.trim().length < 2) {
          return "Họ tên phải có ít nhất 2 ký tự.";
        }
  
        if (this.hoTen.trim().length > 100) {
          return "Họ tên không được vượt quá 100 ký tự.";
        }
  
        const loiGmail = this.kiemTraGmail();
  
        if (loiGmail) {
          return loiGmail;
        }
  
        if (this.soDienThoai && !/^\d{10}$/.test(this.soDienThoai)) {
          return "Số điện thoại phải gồm đúng 10 chữ số.";
        }
  
        if (!this.password) {
          return "Vui lòng nhập mật khẩu.";
        }
  
        if (/\s/.test(this.password)) {
          return "Mật khẩu không được chứa khoảng trắng.";
        }
  
        if (this.password.length < 6) {
          return "Mật khẩu phải có ít nhất 6 ký tự.";
        }
  
        if (!this.rePassword) {
          return "Vui lòng xác nhận mật khẩu.";
        }
  
        if (this.password !== this.rePassword) {
          return "Mật khẩu nhập lại không khớp.";
        }
  
        return "";
      },
  
      // Lấy thông báo lỗi từ Laravel.
      layThongBaoLoi(error, macDinh) {
        const data = error.response?.data;
  
        if (data?.message) {
          return data.message;
        }
  
        const errors = data?.errors;
  
        if (errors) {
          const firstError = Object.values(errors).flat()[0];
  
          if (firstError) return firstError;
        }
  
        if (!error.response) {
          return "Không kết nối được máy chủ. Hãy kiểm tra Laravel đang chạy.";
        }
  
        return macDinh;
      },
  
      // Bắt đầu đếm ngược gửi lại OTP.
      startResendCooldown(seconds = 60) {
        this.clearResendTimer();
  
        this.resendCooldown = seconds;
  
        this.resendTimer = setInterval(() => {
          if (this.resendCooldown > 0) {
            this.resendCooldown--;
          }
  
          if (this.resendCooldown <= 0) {
            this.clearResendTimer();
          }
        }, 1000);
      },
  
      clearResendTimer() {
        if (this.resendTimer) {
          clearInterval(this.resendTimer);
          this.resendTimer = null;
        }
      },
  
      // API 1: Gửi OTP đăng ký.
      async dangKy() {
        const toast = useToast();
  
        const loi = this.kiemTraDangKy();
  
        if (loi) {
          toast.warning(loi);
          return;
        }
  
        if (this.isSubmitting) return;
  
        this.isSubmitting = true;
  
        try {
          const response = await axios.post(
            `${API}/gui-otp`,
            {
              HoTen: this.hoTen.trim(),
              Email: this.email,
              SoDienThoai: this.soDienThoai || null,
              MatKhau: this.password,
            },
            {
              timeout: 20000,
              headers: {
                Accept: "application/json",
              },
            }
          );
  
          if (response.data?.status === true) {
            this.otpStep = true;
            this.otp = "";
  
            this.startResendCooldown(
              response.data.retry_after || 60
            );
  
            toast.success(
              response.data.message || "Đã gửi mã OTP đến Gmail."
            );
  
            this.$nextTick(() => {
              document.getElementById("register-otp")?.focus();
            });
          } else {
            toast.error(
              response.data?.message || "Không thể gửi mã OTP."
            );
          }
        } catch (error) {
          console.error("Lỗi gửi OTP đăng ký:", error);
  
          toast.error(
            this.layThongBaoLoi(
              error,
              "Không thể gửi OTP. Vui lòng thử lại."
            )
          );
  
          const retryAfter = error.response?.data?.retry_after;
  
          if (error.response?.status === 429 && retryAfter) {
            this.startResendCooldown(Number(retryAfter));
          }
        } finally {
          this.isSubmitting = false;
        }
      },
  
      // API 2: Xác minh OTP.
      async xacMinhOtp() {
        const toast = useToast();
  
        if (!/^\d{6}$/.test(this.otp)) {
          toast.warning("Mã OTP phải gồm đúng 6 chữ số.");
          return;
        }
  
        if (this.isVerifying) return;
  
        this.isVerifying = true;
  
        try {
          const response = await axios.post(
            `${API}/xac-minh-otp`,
            {
              Email: this.email,
              OTP: this.otp,
            },
            {
              timeout: 20000,
              headers: {
                Accept: "application/json",
              },
            }
          );
  
          if (response.data?.status === true) {
            toast.success(
              response.data.message || "Đăng ký tài khoản thành công!"
            );
  
            this.clearResendTimer();
  
            setTimeout(() => {
              this.$router.push("/dang-nhap");
            }, 1200);
          } else {
            toast.error(
              response.data?.message || "Xác minh OTP thất bại."
            );
          }
        } catch (error) {
          console.error("Lỗi xác minh OTP:", error);
  
          toast.error(
            this.layThongBaoLoi(
              error,
              "Không thể xác minh OTP. Vui lòng thử lại."
            )
          );
        } finally {
          this.isVerifying = false;
        }
      },
  
      // Gửi lại mã OTP.
      async guiLaiOtp() {
        const toast = useToast();
  
        if (this.resendCooldown > 0 || this.isResending) return;
  
        this.isResending = true;
  
        try {
          const response = await axios.post(
            `${API}/gui-otp`,
            {
              HoTen: this.hoTen.trim(),
              Email: this.email,
              SoDienThoai: this.soDienThoai || null,
              MatKhau: this.password,
            },
            {
              timeout: 20000,
              headers: {
                Accept: "application/json",
              },
            }
          );
  
          if (response.data?.status === true) {
            this.otp = "";
  
            this.startResendCooldown(60);
  
            toast.success("Mã OTP mới đã được gửi.");
          } else {
            toast.error(
              response.data?.message || "Không thể gửi lại OTP."
            );
          }
        } catch (error) {
          console.error("Lỗi gửi lại OTP:", error);
  
          toast.error(
            this.layThongBaoLoi(
              error,
              "Không thể gửi lại mã OTP."
            )
          );
  
          const retryAfter = error.response?.data?.retry_after;
  
          if (error.response?.status === 429 && retryAfter) {
            this.startResendCooldown(Number(retryAfter));
          }
        } finally {
          this.isResending = false;
        }
      },
  
      // Quay lại sửa thông tin.
      quayLaiDangKy() {
        this.otpStep = false;
        this.otp = "";
        this.clearResendTimer();
        this.resendCooldown = 0;
      },
    },
  };
  </script>
  
  <style scoped>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap');
  
  * {
    box-sizing: border-box;
  }
  
  .auth-page {
    --text: #edf3ff;
    --cyan: #63e6ff;
    --violet: #a78bfa;
  
    position: relative;
    min-height: 100vh;
    width: 100%;
    padding: 28px;
    display: grid;
    place-items: center;
    overflow: hidden;
    isolation: isolate;
    color: var(--text);
    font-family: Inter, Arial, sans-serif;
  
    background:
      radial-gradient(ellipse at 12% 15%, rgba(27,89,145,.22), transparent 36%),
      radial-gradient(ellipse at 92% 85%, rgba(104,56,191,.20), transparent 34%),
      #070b16;
  }
  
  .ambient {
    position: absolute;
    width: 420px;
    height: 420px;
    border-radius: 50%;
    filter: blur(90px);
    opacity: .22;
    pointer-events: none;
    z-index: -1;
    animation: drift 12s ease-in-out infinite alternate;
  }
  
  .ambient-one {
    background: #167dba;
    top: -190px;
    left: -100px;
  }
  
  .ambient-two {
    background: #7047d7;
    bottom: -230px;
    right: -100px;
    animation-delay: -5s;
  }
  
  .grid-glow {
    position: absolute;
    inset: 0;
    z-index: -1;
    opacity: .18;
    pointer-events: none;
    background-image:
      linear-gradient(rgba(119,155,218,.09) 1px, transparent 1px),
      linear-gradient(90deg, rgba(119,155,218,.09) 1px, transparent 1px);
    background-size: 48px 48px;
    mask-image: linear-gradient(to bottom, black, transparent 85%);
  }
  
  .auth-shell {
    width: min(1180px, 100%);
    min-height: min(760px, calc(100vh - 56px));
    display: grid;
    grid-template-columns: .95fr 1.05fr;
    border: 1px solid rgba(155,180,255,.17);
    border-radius: 28px;
    overflow: hidden;
    background: rgba(12,19,36,.83);
    box-shadow: 0 35px 100px rgba(0,0,0,.46), 0 0 70px rgba(64,137,255,.07);
    backdrop-filter: blur(24px);
    animation: shellIn .8s cubic-bezier(.2,.8,.2,1) both;
  }
  
  .visual-panel {
    position: relative;
    display: flex;
    flex-direction: column;
    min-height: 100%;
    padding: 38px 42px 25px;
    overflow: hidden;
    background:
      radial-gradient(ellipse at 55% 55%, rgba(24,91,144,.25), transparent 42%),
      linear-gradient(145deg, rgba(17,32,59,.98), rgba(9,15,30,.98));
    border-right: 1px solid rgba(155,180,255,.14);
  }
  
  .visual-panel::before {
    content: "";
    position: absolute;
    width: 420px;
    height: 420px;
    top: 35%;
    left: 15%;
    border: 1px solid rgba(99,230,255,.08);
    border-radius: 50%;
    box-shadow: 0 0 0 35px rgba(99,230,255,.018), 0 0 0 75px rgba(99,230,255,.014);
    pointer-events: none;
  }
  
  .brand-row,
  .mini-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    color: var(--text);
  }
  
  .brand-mark,
  .mini-mark {
    display: grid;
    place-items: center;
    flex-shrink: 0;
    color: #07121e;
    background: linear-gradient(135deg, #8df0ff, #4ca9ff);
    box-shadow: 0 0 28px rgba(99,230,255,.25);
  }
  
  .brand-mark {
    width: 44px;
    height: 44px;
    border-radius: 14px;
    font-size: 25px;
  }
  
  .brand-name {
    font: 700 18px "Space Grotesk", sans-serif;
    letter-spacing: 1.6px;
  }
  
  .brand-name span {
    color: var(--cyan);
  }
  
  .brand-name small {
    display: block;
    margin-top: 3px;
    color: #7f91b5;
    font: 600 8px Inter, sans-serif;
    letter-spacing: 2.1px;
  }
  
  .visual-copy {
    position: relative;
    z-index: 1;
    margin-top: 48px;
  }
  
  .eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    color: #83dff5;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 1.8px;
  }
  
  .status-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #65f4c1;
    box-shadow: 0 0 12px #65f4c1;
  }
  
  .visual-copy h1 {
    margin: 19px 0 15px;
    font: 700 clamp(38px, 4vw, 54px)/1.08 "Space Grotesk", sans-serif;
    letter-spacing: -2.5px;
  }
  
  .visual-copy h1 span {
    color: transparent;
    background: linear-gradient(95deg, #65e8ff 5%, #b4a4ff 78%);
    background-clip: text;
    -webkit-background-clip: text;
  }
  
  .visual-copy p {
    max-width: 370px;
    color: #a1afc9;
    font-size: 13px;
    line-height: 1.9;
  }
  
  .feature-list {
    display: grid;
    gap: 14px;
    margin-top: 25px;
  }
  
  .feature-item {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  
  .feature-icon {
    width: 39px;
    height: 39px;
    flex-shrink: 0;
    display: grid;
    place-items: center;
    border: 1px solid rgba(99,230,255,.2);
    border-radius: 12px;
    color: var(--cyan);
    background: rgba(99,230,255,.06);
    font-size: 20px;
  }
  
  .feature-item b {
    display: block;
    color: #e0eaff;
    font-size: 11px;
  }
  
  .feature-item small {
    display: block;
    margin-top: 4px;
    color: #7f91b1;
    font-size: 10px;
  }
  
  .orbital-scene {
    position: relative;
    width: min(280px, 100%);
    aspect-ratio: 1;
    margin: auto auto 0;
    display: grid;
    place-items: center;
  }
  
  .orbit {
    position: absolute;
    border: 1px solid rgba(99,230,255,.2);
    border-radius: 50%;
  }
  
  .orbit-a {
    width: 64%;
    height: 64%;
    animation: spin 22s linear infinite;
    border-top-color: rgba(99,230,255,.8);
  }
  
  .orbit-b {
    width: 83%;
    height: 43%;
    transform: rotate(-33deg);
    border-color: rgba(167,139,250,.3);
    animation: spinReverse 28s linear infinite;
  }
  
  .orbit-c {
    width: 83%;
    height: 43%;
    transform: rotate(57deg);
    border-color: rgba(99,230,255,.18);
    animation: spin 34s linear infinite;
  }
  
  .core-chip {
    position: relative;
    width: 100px;
    height: 100px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 4px;
    border: 1px solid rgba(120,225,255,.5);
    border-radius: 27px;
    color: #d9fbff;
    background: linear-gradient(145deg, rgba(38,105,148,.55), rgba(35,34,83,.65));
    box-shadow: inset 0 0 35px rgba(99,230,255,.12), 0 0 60px rgba(45,175,255,.15);
    transform: rotate(-8deg);
    animation: float 4s ease-in-out infinite;
  }
  
  .core-chip i {
    font-size: 39px;
    color: var(--cyan);
    filter: drop-shadow(0 0 12px rgba(99,230,255,.55));
  }
  
  .core-chip span {
    font: 700 9px "Space Grotesk", sans-serif;
    letter-spacing: 3px;
  }
  
  .orbit-node {
    position: absolute;
    z-index: 2;
    width: 40px;
    height: 40px;
    display: grid;
    place-items: center;
    border: 1px solid rgba(133,211,255,.28);
    border-radius: 13px;
    color: #9eeeff;
    background: rgba(12,26,49,.94);
    box-shadow: 0 10px 30px rgba(0,0,0,.25);
    font-size: 20px;
    animation: float 4s ease-in-out infinite;
  }
  
  .node-a { top: 14%; left: 24%; animation-delay: -.7s; }
  .node-b { top: 28%; right: 12%; animation-delay: -1.4s; }
  .node-c { bottom: 16%; right: 22%; animation-delay: -2.2s; }
  .node-d { bottom: 23%; left: 10%; animation-delay: -1s; }
  
  .visual-footer,
  .form-bottom {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    color: #667897;
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 1px;
  }
  
  .form-panel {
    min-width: 0;
    display: flex;
    flex-direction: column;
    padding: 30px clamp(25px, 4vw, 54px) 22px;
    background: linear-gradient(155deg, rgba(16,24,44,.93), rgba(10,15,29,.97));
  }
  
  .form-topline {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
  }
  
  .mini-brand {
    padding: 0;
    border: 0;
    background: transparent;
    cursor: pointer;
    font: 700 14px "Space Grotesk", sans-serif;
    letter-spacing: 1px;
  }
  
  .mini-mark {
    width: 29px;
    height: 29px;
    border-radius: 9px;
    font-size: 17px;
  }
  
  .signin-prompt {
    color: #8998b5;
    font-size: 11px;
    white-space: nowrap;
  }
  
  .signin-prompt button {
    border: 0;
    padding: 0;
    color: var(--cyan);
    background: none;
    font: 700 11px Inter, sans-serif;
    cursor: pointer;
  }
  
  .signin-prompt button:hover {
    color: white;
  }
  
  .form-content {
    width: 100%;
    max-width: 440px;
    margin: auto;
    padding: 28px 0;
  }
  
  .form-heading {
    margin-bottom: 25px;
  }
  
  .heading-icon {
    width: 42px;
    height: 42px;
    display: grid;
    place-items: center;
    margin-bottom: 17px;
    border: 1px solid rgba(99,230,255,.25);
    border-radius: 14px;
    color: var(--cyan);
    background: rgba(99,230,255,.08);
    font-size: 23px;
  }
  
  .form-heading .eyebrow {
    font-size: 9px;
  }
  
  .form-heading h2 {
    margin: 11px 0 9px;
    font: 700 clamp(25px, 3vw, 34px)/1.2 "Space Grotesk", sans-serif;
    letter-spacing: -1px;
  }
  
  .form-heading h2 span {
    color: var(--cyan);
  }
  
  .form-heading p {
    margin: 0;
    color: #8998b5;
    font-size: 12px;
    line-height: 1.7;
  }
  
  .register-form {
    display: flex;
    flex-direction: column;
    gap: 17px;
  }
  
  .field-group label {
    display: block;
    margin-bottom: 9px;
    color: #dfe8f8;
    font-size: 12px;
    font-weight: 700;
  }
  
  .field-group label span {
    color: #68e7ff;
  }
  
  .input-wrap {
    position: relative;
    display: flex;
    align-items: center;
    min-width: 0;
    height: 52px;
    border: 1px solid rgba(146,173,224,.17);
    border-radius: 13px;
    background: rgba(3,9,22,.5);
    transition: border-color .25s, box-shadow .25s, background .25s;
  }
  
  .input-wrap:focus-within {
    border-color: rgba(99,230,255,.72);
    background: rgba(8,20,37,.85);
    box-shadow: 0 0 0 4px rgba(99,230,255,.07), 0 0 24px rgba(99,230,255,.06);
  }
  
  .field-icon {
    flex-shrink: 0;
    margin-left: 15px;
    color: #7185a8;
    font-size: 19px;
    transition: color .2s;
  }
  
  .input-wrap:focus-within .field-icon {
    color: var(--cyan);
  }
  
  .input-wrap input {
    width: 100%;
    min-width: 0;
    height: 100%;
    border: 0;
    outline: 0;
    padding: 0 13px;
    color: #eef7ff;
    background: transparent;
    font: 500 12px Inter, sans-serif;
  }
  
  .input-wrap input::placeholder {
    color: #596985;
    opacity: 1;
  }
  
  .privacy-note {
    display: flex;
    align-items: flex-start;
    gap: 7px;
    color: #7e8eaa;
    font-size: 10px;
    line-height: 1.6;
  }
  
  .privacy-note i {
    color: var(--cyan);
    font-size: 15px;
    flex-shrink: 0;
  }
  
  .submit-button {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    width: 100%;
    height: 54px;
    overflow: hidden;
    border: 1px solid rgba(155,245,255,.65);
    border-radius: 13px;
    color: #07121f;
    background: linear-gradient(100deg, #69e9ff, #88d8ff 50%, #b5a5ff);
    box-shadow: 0 10px 30px rgba(64,193,255,.15);
    font: 800 13px Inter, sans-serif;
    cursor: pointer;
    transition: transform .22s, box-shadow .22s;
  }
  
  .submit-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 36px rgba(64,193,255,.27);
  }
  
  .submit-button:active {
    transform: translateY(0) scale(.99);
  }
  
  .submit-button i {
    font-size: 21px;
    transition: transform .2s;
  }
  
  .submit-button:hover i {
    transform: translateX(4px);
  }
  
  .button-glint {
    position: absolute;
    inset: -80% auto -80% -30%;
    width: 22%;
    transform: rotate(22deg);
    background: rgba(255,255,255,.55);
    filter: blur(9px);
    transition: left .65s;
  }
  
  .submit-button:hover .button-glint {
    left: 120%;
  }
  
  .divider {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #627391;
  }
  
  .divider span {
    flex: 1;
    height: 1px;
    background: rgba(146,173,224,.12);
  }
  
  .divider small {
    font-size: 8px;
    font-weight: 700;
    letter-spacing: 1.3px;
    white-space: nowrap;
  }
  
  .secure-note {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 7px;
    color: #8291ab;
    font-size: 10px;
    text-align: center;
  }
  
  .secure-note i {
    color: #6cddc1;
    font-size: 15px;
  }
  
  .form-bottom {
    margin-top: auto;
    padding-top: 18px;
    border-top: 1px solid rgba(146,173,224,.1);
    font-size: 8px;
    letter-spacing: 1.2px;
  }
  
  .bottom-dots {
    display: flex;
    align-items: center;
    gap: 4px;
  }
  
  .bottom-dots i {
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background: #59708f;
  }
  
  .bottom-dots i:first-child {
    background: var(--cyan);
    box-shadow: 0 0 8px var(--cyan);
  }
  
  @keyframes shellIn {
    from { opacity: 0; transform: translateY(16px) scale(.99); }
    to { opacity: 1; transform: translateY(0) scale(1); }
  }
  
  @keyframes drift {
    to { transform: translate(70px, 45px) scale(1.12); }
  }
  
  @keyframes float {
    0%, 100% { translate: 0 0; }
    50% { translate: 0 -9px; }
  }
  
  @keyframes spin {
    to { rotate: 360deg; }
  }
  
  @keyframes spinReverse {
    to { rotate: -360deg; }
  }
  
  @media (max-width: 900px) {
    .auth-page {
      padding: 18px;
    }
  
    .auth-shell {
      grid-template-columns: .8fr 1.2fr;
      min-height: calc(100vh - 36px);
    }
  
    .visual-panel {
      padding: 30px 25px 22px;
    }
  
    .visual-copy {
      margin-top: 35px;
    }
  
    .visual-copy h1 {
      font-size: 38px;
    }
  
    .orbital-scene {
      width: min(240px, 100%);
    }
  
    .form-panel {
      padding: 25px 27px 20px;
    }
  }
  
  @media (max-width: 680px) {
    .auth-page {
      display: block;
      padding: 0;
      min-height: 100svh;
      overflow: auto;
    }
  
    .auth-shell {
      display: flex;
      flex-direction: column;
      min-height: 100svh;
      border: 0;
      border-radius: 0;
    }
  
    .visual-panel {
      min-height: 0;
      padding: 22px 23px 20px;
      border-right: 0;
      border-bottom: 1px solid rgba(155,180,255,.14);
    }
  
    .visual-copy {
      margin-top: 26px;
    }
  
    .visual-copy h1 {
      font-size: 33px;
      letter-spacing: -1.5px;
    }
  
    .visual-copy p {
      max-width: 480px;
      font-size: 12px;
    }
  
    .feature-list {
      gap: 11px;
      margin-top: 18px;
    }
  
    .orbital-scene {
      position: absolute;
      width: 100px;
      right: 12px;
      top: 60px;
      opacity: .25;
    }
  
    .core-chip {
      width: 50px;
      height: 50px;
      border-radius: 14px;
    }
  
    .core-chip i {
      font-size: 22px;
    }
  
    .core-chip span,
    .orbit-node {
      display: none;
    }
  
    .orbit-a {
      width: 90%;
      height: 90%;
    }
  
    .orbit-b,
    .orbit-c {
      display: none;
    }
  
    .visual-footer {
      display: none;
    }
  
    .form-panel {
      flex: 1;
      padding: 23px 23px 18px;
    }
  
    .form-content {
      padding: 25px 0;
    }
  
    .form-heading {
      margin-bottom: 22px;
    }
  
    .register-form {
      gap: 17px;
    }
  
    .form-bottom {
      margin-top: auto;
    }
  }
  
  @media (max-width: 380px) {
    .form-topline {
      align-items: flex-start;
      flex-direction: column;
    }
  
    .signin-prompt {
      align-self: flex-end;
    }
  
    .form-panel {
      padding-inline: 17px;
    }
  
    .visual-copy h1 {
      font-size: 30px;
    }
  }
  
  @media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
      animation-duration: .01ms !important;
      animation-iteration-count: 1 !important;
      scroll-behavior: auto !important;
      transition-duration: .01ms !important;
    }
  }





/* =========================
   XÁC MINH OTP
========================= */

.otp-note {
  text-align: center;
  padding: 12px 5px 18px;
}

.otp-note-icon {
  width: 54px;
  height: 54px;
  display: grid;
  place-items: center;
  margin: 0 auto 13px;
  border: 1px solid rgba(99,230,255,.3);
  border-radius: 17px;
  color: var(--cyan);
  background: rgba(99,230,255,.08);
  font-size: 28px;
}

.otp-note h3 {
  margin: 0 0 9px;
  color: #edf3ff;
  font: 700 20px "Space Grotesk", sans-serif;
}

.otp-note p {
  margin: 0;
  color: #8998b5;
  font-size: 12px;
  line-height: 1.7;
  overflow-wrap: anywhere;
}

.otp-note p strong {
  color: var(--cyan);
}

.otp-note small {
  display: block;
  margin-top: 8px;
  color: #65f4c1;
  font-size: 10px;
}

.otp-actions {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 12px;
  margin-top: 3px;
}

.resend-button {
  padding: 5px 10px;
  border: 0;
  color: var(--cyan);
  background: transparent;
  font: 600 11px Inter, sans-serif;
  cursor: pointer;
  transition: color .2s;
}

.resend-button:hover:not(:disabled) {
  color: white;
}

.resend-button:disabled {
  color: #64738f;
  cursor: not-allowed;
}

.submit-button:disabled {
  opacity: .65;
  cursor: not-allowed;
  transform: none;
}

  </style>
  