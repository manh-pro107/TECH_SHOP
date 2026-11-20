
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
              YOUR NEXT LEVEL STARTS HERE
            </span>
  
            <h1>
              Welcome<br />
              to your <span>universe.</span>
            </h1>
  
            <p>
              Đăng nhập để tiếp tục khám phá thế giới công nghệ,
              thiết bị gaming và những lựa chọn dành riêng cho bạn.
            </p>
  
            <div class="feature-pills">
              <span><i class="bx bx-check-shield"></i> Mua sắm an tâm</span>
              <span><i class="bx bx-bolt-circle"></i> Công nghệ mới</span>
              <span><i class="bx bx-headphone"></i> Hỗ trợ tận tâm</span>
            </div>
          </div>
  
          <!-- MÔ HÌNH QUỸ ĐẠO CÔNG NGHỆ -->
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
  
            <div class="scene-caption">
              <span></span> TECHNOLOGY, REIMAGINED
            </div>
          </div>
  
          <div class="visual-footer">
            <span>© 2026 TECHSHOP</span>
            <span>MADE FOR YOUR NEXT MOVE</span>
          </div>
        </aside>
  
        <!-- FORM ĐĂNG NHẬP -->
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
              Chưa có tài khoản?
              <button type="button" @click="$router.push('/dang-ky')">
                Đăng ký <i class="bx bx-arrow-up-right"></i>
              </button>
            </div>
          </div>
  
          <div class="form-content">
            <div class="form-heading">
              <div class="heading-icon">
                <i class="bx bx-fingerprint"></i>
              </div>
  
              <template v-if="!forgotMode">
                  <span class="eyebrow">WELCOME BACK</span>
                  <h2>Đăng nhập <span>tài khoản</span></h2>
                  <p>
                    Chào mừng bạn trở lại. Hãy tiếp tục hành trình
                    công nghệ của mình.
                  </p>
                </template>

                <template v-else>
                  <span class="eyebrow">ACCOUNT RECOVERY</span>

                  <h2>
                    {{
                      forgotStep === 1
                        ? "Quên mật khẩu"
                        : forgotStep === 2
                          ? "Xác minh Gmail"
                          : "Tạo mật khẩu mới"
                    }}
                    <span>.</span>
                  </h2>

                  <p>
                    {{
                      forgotStep === 1
                        ? "Nhập Gmail đã đăng ký để nhận mã xác minh."
                        : forgotStep === 2
                          ? "Nhập mã OTP TECHSHOP vừa gửi đến Gmail của bạn."
                          : "Tạo mật khẩu mới để tiếp tục sử dụng tài khoản."
                    }}
                  </p>
                </template>
            </div>
  
            <form v-if="!forgotMode" class="login-form" @submit.prevent="dangNhap">
              <!-- EMAIL -->
              <div class="field-group">
                <label for="login-email">Email <span>*</span></label>
  
                <div class="input-wrap">
                  <i class="bx bx-envelope field-icon"></i>
                  <input
                    id="login-email"
                    v-model="email"
                    type="email"
                    placeholder="name@example.com"
                    autocomplete="username"
                  />
                </div>
              </div>
  
              <!-- MẬT KHẨU -->
              <div class="field-group">
                <div class="label-row">
                  <label for="login-password">
                    Mật khẩu <span>*</span>
                  </label>
  
                  <button
                    class="forgot"
                    type="button"
                    @click="quenMatKhau"
                  >
                    Quên mật khẩu?
                  </button>
                </div>
  
                <div
                  ref="passwordWrap"
                  class="input-wrap password-wrap"
                  :class="{ 'beam-enabled': beamActive }"
                  :style="beamStyle"
                  @mousemove="moveBeam"
                  @mouseleave="leaveBeam"
                >
                  <i class="bx bx-lock-alt field-icon"></i>
  
                  <!--
                    Input thật vẫn giữ type=password.
                    Lớp chữ bên trên chỉ mô phỏng vùng nhìn thấy.
                  -->
                  <input
                    id="login-password"
                    v-model="password"
                    type="password"
                    placeholder="Nhập mật khẩu của bạn"
                    autocomplete="current-password"
                    spellcheck="false"
                  />
  
                  <!-- LỚP CHỮ CHỈ HIỆN TRONG LUỒNG SÁNG -->
                  <div class="secret-text" aria-hidden="true">
                    <span v-if="password">{{ password }}</span>
                    <span v-else class="secret-placeholder">
                      Nhập mật khẩu của bạn
                    </span>
                  </div>
  
                  <!-- ÁNH SÁNG HÌNH NÓN -->
                  <div class="flashlight-beam" aria-hidden="true"></div>
  
                  <!-- NÚT ĐÈN PIN -->
                  <button
                    class="flashlight-button"
                    :class="{ 'is-active': beamActive }"
                    type="button"
                    aria-label="Bật hoặc tắt đèn pin"
                    :aria-pressed="beamActive"
                    @click="toggleBeam"
                    @mousedown.prevent
                  >
                    <i class="bx bx-bulb"></i>
                  </button>
                </div>
  
                <div class="password-hint">
                  <i class="bx bx-info-circle"></i>
                  Bật đèn pin rồi rê chuột trên ô mật khẩu.
                  Chỉ ký tự trong vùng sáng mới hiện rõ.
                </div>
              </div>
  
              <!-- ĐĂNG NHẬP -->
              <button class="submit-button" type="submit" :disabled="isSubmitting">
                <span>Đăng nhập</span>
                <i class="bx bx-right-arrow-alt"></i>
                <span>{{ isSubmitting ? "Đang đăng nhập..." : "Đăng nhập" }}</span>
              </button>
  
              <div class="divider">
                <span></span>
                <small>YOUR TECH WORLD AWAITS</small>
                <span></span>
              </div>
  
              <div class="secure-note">
                <i class="bx bx-shield-quarter"></i>
                <span>Trải nghiệm công nghệ liền mạch</span>
              </div>
            </form>


<!-- FORM QUÊN MẬT KHẨU -->
<form
  v-else
  class="login-form forgot-form"
  @submit.prevent="xuLyQuenMatKhau"
>

  <!-- BƯỚC 1: NHẬP GMAIL -->
  <template v-if="forgotStep === 1">

    <div class="field-group">
      <label for="forgot-email">Gmail đã đăng ký <span>*</span></label>

      <div class="input-wrap">
        <i class="bx bx-envelope field-icon"></i>
        <input
          id="forgot-email"
          v-model="forgotEmail"
          type="email"
          placeholder="name@gmail.com"
          autocomplete="email"
          maxlength="100"
          required
        />
      </div>
    </div>

    <div class="privacy-note">
      <i class="bx bx-shield-quarter"></i>
      <span>
        Mã OTP sẽ có hiệu lực trong 5 phút. Không chia sẻ mã này với bất kỳ ai.
      </span>
    </div>

    <button
      class="submit-button"
      type="submit"
      :disabled="forgotLoading"
    >
      <span>
        {{ forgotLoading ? "Đang gửi OTP..." : "Gửi mã xác minh" }}
      </span>
      <i class="bx bx-right-arrow-alt"></i>
    </button>

  </template>

  <!-- BƯỚC 2: NHẬP OTP -->
  <template v-else-if="forgotStep === 2">

    <div class="otp-note">
      <div class="otp-note-icon">
        <i class="bx bx-envelope"></i>
      </div>

      <h3>Kiểm tra Gmail của bạn</h3>

      <p>
        Nếu Gmail có tài khoản TECHSHOP, mã xác minh sẽ được gửi đến:
      </p>

      <strong>{{ forgotEmail }}</strong>

      <small>Mã OTP có hiệu lực trong 5 phút.</small>
    </div>

    <div class="field-group">
      <label for="forgot-otp">Mã OTP <span>*</span></label>

      <div class="input-wrap">
        <i class="bx bx-key field-icon"></i>

        <input
          id="forgot-otp"
          v-model="forgotOtp"
          type="text"
          inputmode="numeric"
          maxlength="6"
          placeholder="Nhập mã OTP 6 chữ số"
          autocomplete="one-time-code"
          required
          @input="locForgotOtp"
        />
      </div>
    </div>

    <button
      class="submit-button"
      type="submit"
      :disabled="forgotLoading"
    >
      <span>
        {{ forgotLoading ? "Đang xác minh..." : "Xác minh OTP" }}
      </span>
      <i class="bx bx-check-circle"></i>
    </button>

    <div class="forgot-actions">
      <button
        type="button"
        class="forgot-secondary"
        :disabled="forgotCooldown > 0 || forgotLoading"
        @click="guiLaiOtpQuenMatKhau"
      >
        {{
          forgotCooldown > 0
            ? `Gửi lại mã sau ${forgotCooldown}s`
            : "Gửi lại mã OTP"
        }}
      </button>
    </div>

  </template>

  <!-- BƯỚC 3: ĐẶT MẬT KHẨU MỚI -->
  <template v-else-if="forgotStep === 3">

    <div class="field-group">
      <label for="new-password">Mật khẩu mới <span>*</span></label>

      <div class="input-wrap">
        <i class="bx bx-lock-alt field-icon"></i>

        <input
          id="new-password"
          v-model="newPassword"
          type="password"
          placeholder="Tối thiểu 6 ký tự, không khoảng trắng"
          autocomplete="new-password"
          maxlength="255"
          required
        />
      </div>
    </div>

    <div class="field-group">
      <label for="confirm-new-password">
        Xác nhận mật khẩu mới <span>*</span>
      </label>

      <div class="input-wrap">
        <i class="bx bx-shield-quarter field-icon"></i>

        <input
          id="confirm-new-password"
          v-model="confirmNewPassword"
          type="password"
          placeholder="Nhập lại mật khẩu mới"
          autocomplete="new-password"
          maxlength="255"
          required
        />
      </div>
    </div>

    <div class="privacy-note">
      <i class="bx bx-info-circle"></i>
      <span>
        Mật khẩu mới phải có ít nhất 6 ký tự và không chứa khoảng trắng.
      </span>
    </div>

    <button
      class="submit-button"
      type="submit"
      :disabled="forgotLoading"
    >
      <span>
        {{ forgotLoading ? "Đang cập nhật..." : "Đổi mật khẩu" }}
      </span>
      <i class="bx bx-check-circle"></i>
    </button>

  </template>

  <!-- QUAY LẠI ĐĂNG NHẬP -->
  <div class="forgot-actions">
    <button
      class="forgot-secondary"
      type="button"
      @click="thoatQuenMatKhau"
    >
      <i class="bx bx-left-arrow-alt"></i>
      Quay lại đăng nhập
    </button>
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
  
  export default {
    data() {
      return {
        email: "",
        password: "",
  
        isSubmitting: false,
        // Trạng thái đèn pin
        beamActive: false,
        beamX: 50,
        beamY: 50,

        // QUÊN MẬT KHẨU
        forgotMode: false,
        forgotStep: 1,

        forgotEmail: "",
        forgotOtp: "",
        newPassword: "",
        confirmNewPassword: "",
        resetToken: "",

        forgotLoading: false,
        forgotCooldown: 0,
        forgotTimer: null,
        


      };
    },
    beforeUnmount() {
        this.clearForgotTimer();
    },
    computed: {
      beamStyle() {
        return {
          "--beam-x": `${this.beamX}%`,
          "--beam-y": `${this.beamY}%`,
        };
      },
    },
  
    methods: {
      // Cập nhật vị trí luồng sáng theo chuột
      moveBeam(event) {
        if (!this.beamActive) return;
  
        const rect = event.currentTarget.getBoundingClientRect();
  
        this.beamX = Math.max(
          0,
          Math.min(100, ((event.clientX - rect.left) / rect.width) * 100)
        );
  
        this.beamY = Math.max(
          0,
          Math.min(100, ((event.clientY - rect.top) / rect.height) * 100)
        );
      },
  
      // Rời khỏi ô nhập: tự tắt đèn
      leaveBeam() {
        this.beamActive = false;
      },
  
      // Bật/tắt đèn pin
      toggleBeam() {
        this.beamActive = !this.beamActive;
      },
  
      // Quên mật khẩu: chưa tích hợp chức năng đặt lại thật
      
// MỞ CHỨC NĂNG QUÊN MẬT KHẨU
quenMatKhau() {
    this.forgotMode = true;
    this.forgotStep = 1;

    this.forgotEmail = this.email.trim().toLowerCase();
    this.forgotOtp = "";

    this.newPassword = "";
    this.confirmNewPassword = "";
    this.resetToken = "";
},

// QUAY LẠI ĐĂNG NHẬP
thoatQuenMatKhau() {
    this.forgotMode = false;
    this.forgotStep = 1;

    this.forgotOtp = "";
    this.newPassword = "";
    this.confirmNewPassword = "";
    this.resetToken = "";

    this.clearForgotTimer();
    this.forgotCooldown = 0;
},

// XÓA TIMER
clearForgotTimer() {
    if (this.forgotTimer) {
        clearInterval(this.forgotTimer);
        this.forgotTimer = null;
    }
},

// ĐẾM NGƯỢC GỬI LẠI OTP
startForgotCooldown(seconds = 60) {
    this.clearForgotTimer();

    this.forgotCooldown = seconds;

    this.forgotTimer = setInterval(() => {
        if (this.forgotCooldown > 0) {
            this.forgotCooldown--;
        }

        if (this.forgotCooldown <= 0) {
            this.clearForgotTimer();
        }
    }, 1000);
},

// CHỈ CHO PHÉP NHẬP 6 SỐ OTP
locForgotOtp() {
    this.forgotOtp = this.forgotOtp
        .replace(/\D/g, "")
        .slice(0, 6);
},

// LẤY THÔNG BÁO LỖI
layLoiQuenMatKhau(error, macDinh) {
    const data = error.response?.data;

    if (data?.message) {
        return data.message;
    }

    if (data?.errors) {
        const loiDauTien = Object.values(data.errors).flat()[0];

        if (loiDauTien) return loiDauTien;
    }

    if (!error.response) {
        return "Không kết nối được máy chủ TECHSHOP.";
    }

    return macDinh;
},

// ĐIỀU PHỐI 3 BƯỚC
async xuLyQuenMatKhau() {
    if (this.forgotStep === 1) {
        await this.guiOtpQuenMatKhau();
    } else if (this.forgotStep === 2) {
        await this.xacMinhOtpQuenMatKhau();
    } else if (this.forgotStep === 3) {
        await this.datLaiMatKhau();
    }
},

// BƯỚC 1: GỬI OTP
async guiOtpQuenMatKhau() {
    const toast = useToast();

    const email = this.forgotEmail.trim().toLowerCase();

    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        toast.warning("Vui lòng nhập Gmail hợp lệ.");
        return;
    }

    if (this.forgotLoading) return;

    this.forgotEmail = email;
    this.forgotLoading = true;

    try {
        const response = await axios.post(
            "http://127.0.0.1:8000/api/client/quen-mat-khau/gui-otp",
            {
                Email: email,
            },
            {
                timeout: 20000,
                headers: {
                    Accept: "application/json",
                },
            }
        );

        if (response.data?.status === true) {
            this.forgotStep = 2;
            this.forgotOtp = "";

            this.startForgotCooldown(60);

            toast.success(
                response.data.message || "Yêu cầu gửi OTP đã được tiếp nhận."
            );

            this.$nextTick(() => {
                document.getElementById("forgot-otp")?.focus();
            });
        } else {
            toast.error(
                response.data?.message || "Không thể gửi OTP."
            );
        }
    } catch (error) {
        console.error("Lỗi gửi OTP quên mật khẩu:", error);

        toast.error(
            this.layLoiQuenMatKhau(
                error,
                "Không thể gửi mã OTP. Vui lòng thử lại."
            )
        );

        const retry = error.response?.data?.retry_after;

        if (error.response?.status === 429 && retry) {
            this.startForgotCooldown(Number(retry));
        }
    } finally {
        this.forgotLoading = false;
    }
},

// BƯỚC 2: XÁC MINH OTP
async xacMinhOtpQuenMatKhau() {
    const toast = useToast();

    if (!/^\d{6}$/.test(this.forgotOtp)) {
        toast.warning("Mã OTP phải gồm đúng 6 chữ số.");
        return;
    }

    if (this.forgotLoading) return;

    this.forgotLoading = true;

    try {
        const response = await axios.post(
            "http://127.0.0.1:8000/api/client/quen-mat-khau/xac-minh-otp",
            {
                Email: this.forgotEmail,
                OTP: this.forgotOtp,
            },
            {
                timeout: 20000,
                headers: {
                    Accept: "application/json",
                },
            }
        );

        const token = response.data?.data?.reset_token;

        if (response.data?.status === true && token) {
            this.resetToken = token;
            this.forgotStep = 3;

            this.clearForgotTimer();

            toast.success(
                "Xác minh thành công. Hãy tạo mật khẩu mới."
            );
        } else {
            toast.error(
                response.data?.message || "Xác minh OTP thất bại."
            );
        }
    } catch (error) {
        console.error("Lỗi xác minh OTP:", error);

        toast.error(
            this.layLoiQuenMatKhau(
                error,
                "Mã OTP không chính xác hoặc đã hết hạn."
            )
        );
    } finally {
        this.forgotLoading = false;
    }
},

// GỬI LẠI OTP
async guiLaiOtpQuenMatKhau() {
    const toast = useToast();

    if (this.forgotCooldown > 0 || this.forgotLoading) return;

    // Gửi lại OTP bằng cùng API gửi OTP ban đầu.
    await this.guiOtpQuenMatKhau();
},

// BƯỚC 3: ĐẶT MẬT KHẨU MỚI
async datLaiMatKhau() {
    const toast = useToast();

    if (!this.newPassword || !this.confirmNewPassword) {
        toast.warning("Vui lòng nhập đầy đủ mật khẩu mới.");
        return;
    }

    if (/\s/.test(this.newPassword)) {
        toast.warning("Mật khẩu không được chứa khoảng trắng.");
        return;
    }

    if (this.newPassword.length < 6) {
        toast.warning("Mật khẩu phải có ít nhất 6 ký tự.");
        return;
    }

    if (this.newPassword !== this.confirmNewPassword) {
        toast.error("Mật khẩu xác nhận không khớp.");
        return;
    }

    if (!this.resetToken) {
        toast.error("Phiên xác minh không hợp lệ. Vui lòng làm lại.");
        this.forgotStep = 1;
        return;
    }

    if (this.forgotLoading) return;

    this.forgotLoading = true;

    try {
        const response = await axios.post(
            "http://127.0.0.1:8000/api/client/quen-mat-khau/dat-lai",
            {
                Email: this.forgotEmail,
                reset_token: this.resetToken,
                MatKhau: this.newPassword,
                MatKhau_confirmation: this.confirmNewPassword,
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
                "Đổi mật khẩu thành công! Hãy đăng nhập bằng mật khẩu mới."
            );

            // Điền sẵn Gmail ở trang đăng nhập.
            this.email = this.forgotEmail;

            this.password = "";
            this.newPassword = "";
            this.confirmNewPassword = "";
            this.forgotOtp = "";
            this.resetToken = "";

            this.clearForgotTimer();
            this.forgotCooldown = 0;

            this.forgotMode = false;
            this.forgotStep = 1;
        } else {
            toast.error(
                response.data?.message || "Không thể đổi mật khẩu."
            );
        }
    } catch (error) {
        console.error("Lỗi đặt lại mật khẩu:", error);

        toast.error(
            this.layLoiQuenMatKhau(
                error,
                "Không thể đặt lại mật khẩu. Vui lòng thử lại."
            )
        );
    } finally {
        this.forgotLoading = false;
    }
},

  
      // GIỮ NGUYÊN LOGIC ĐĂNG NHẬP CŨ
      async dangNhap() {
    const toast = useToast();

    if (!this.email.trim() || !this.password) {
        toast.error("Vui lòng nhập đầy đủ email và mật khẩu!");
        return;
    }

    if (this.isSubmitting) return;

    this.isSubmitting = true;

    try {
        const response = await axios.post(
            "http://127.0.0.1:8000/api/client/dang-nhap",
            {
                Email: this.email.trim(),
                MatKhau: this.password,
            },
            {
                timeout: 15000,
            }
        );

        const result = response.data;

        if (
            result.status !== true ||
            !result.data?.token
        ) {
            toast.error(
                result.message || "Đăng nhập thất bại!"
            );
            return;
        }

        const token = result.data.token;
        const nguoiDung = result.data.nguoi_dung;

                // Lưu định danh ổn định để tài khoản dùng đúng cuộc hội thoại
        const customerIdentity = String(
          nguoiDung?.Email ||
          nguoiDung?.email ||
          this.email
        ).trim().toLowerCase();

        localStorage.setItem(
          "techshop_chat_customer_id",
          customerIdentity
        );

        // Lưu token để gọi các API cần đăng nhập
        localStorage.setItem("token", token);

        // Giữ trạng thái đăng nhập mà FE hiện tại đang sử dụng
        localStorage.setItem("isLogin", "true");

        // Lưu thông tin tài khoản để hiển thị trên FE
        if (nguoiDung) {
            const userSafe = { ...nguoiDung };

            // Không lưu trường mật khẩu vào localStorage
            delete userSafe.MatKhau;
            delete userSafe.password;

            localStorage.setItem(
                "user",
                JSON.stringify(userSafe)
            );
        }

        toast.success("Đăng nhập thành công!");

        // Chuyển về trang chủ sau khi đăng nhập
        setTimeout(() => {
            this.$router.push("/trang-chu");
        }, 500);

    } catch (error) {
        console.error("Lỗi đăng nhập khách hàng:", error);

        if (error.response) {
            toast.error(
                error.response.data?.message ||
                "Đăng nhập thất bại. Vui lòng kiểm tra tài khoản."
            );
        } else if (error.code === "ECONNABORTED") {
            toast.error("Máy chủ phản hồi quá lâu. Vui lòng thử lại.");
        } else {
            toast.error(
                "Không kết nối được BE. Hãy kiểm tra Laravel đang chạy."
            );
        }
    } finally {
        this.isSubmitting = false;
    }
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
  
  /* THƯƠNG HIỆU */
  
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
    text-decoration: none;
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
    margin-top: 64px;
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
    font: 700 clamp(38px, 4vw, 56px)/1.08 "Space Grotesk", sans-serif;
    letter-spacing: -2.8px;
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
  
  .feature-pills {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 22px;
  }
  
  .feature-pills span {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 10px;
    border: 1px solid rgba(151,183,235,.15);
    border-radius: 999px;
    color: #c1cde2;
    background: rgba(255,255,255,.025);
    font-size: 10px;
  }
  
  .feature-pills i {
    color: var(--cyan);
    font-size: 14px;
  }
  
  /* QUỸ ĐẠO 3D */
  
  .orbital-scene {
    position: relative;
    width: min(340px, 100%);
    aspect-ratio: 1;
    margin: auto auto 10px;
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
    width: 116px;
    height: 116px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 4px;
    border: 1px solid rgba(120,225,255,.5);
    border-radius: 30px;
    color: #d9fbff;
    background: linear-gradient(145deg, rgba(38,105,148,.55), rgba(35,34,83,.65));
    box-shadow: inset 0 0 35px rgba(99,230,255,.12), 0 0 60px rgba(45,175,255,.15);
    transform: rotate(-8deg);
    animation: float 4s ease-in-out infinite;
  }
  
  .core-chip i {
    font-size: 45px;
    color: var(--cyan);
    filter: drop-shadow(0 0 12px rgba(99,230,255,.55));
  }
  
  .core-chip span {
    font: 700 10px "Space Grotesk", sans-serif;
    letter-spacing: 3px;
  }
  
  .orbit-node {
    position: absolute;
    z-index: 2;
    width: 43px;
    height: 43px;
    display: grid;
    place-items: center;
    border: 1px solid rgba(133,211,255,.28);
    border-radius: 14px;
    color: #9eeeff;
    background: rgba(12,26,49,.94);
    box-shadow: 0 10px 30px rgba(0,0,0,.25);
    font-size: 21px;
    animation: float 4s ease-in-out infinite;
  }
  
  .node-a { top: 14%; left: 24%; animation-delay: -.7s; }
  .node-b { top: 28%; right: 12%; animation-delay: -1.4s; }
  .node-c { bottom: 16%; right: 22%; animation-delay: -2.2s; }
  .node-d { bottom: 23%; left: 10%; animation-delay: -1s; }
  
  .scene-caption {
    position: absolute;
    bottom: 0;
    display: flex;
    align-items: center;
    gap: 9px;
    color: #617494;
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 2px;
  }
  
  .scene-caption span {
    width: 24px;
    height: 1px;
    background: var(--cyan);
    box-shadow: 0 0 8px var(--cyan);
  }
  
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
  
  /* FORM */
  
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
  
  .signin-prompt button,
  .forgot {
    border: 0;
    padding: 0;
    color: var(--cyan);
    background: none;
    font: 700 11px Inter, sans-serif;
    cursor: pointer;
  }
  
  .signin-prompt button:hover,
  .forgot:hover {
    color: white;
  }
  
  .form-content {
    width: 100%;
    max-width: 440px;
    margin: auto;
    padding: 35px 0 28px;
  }
  
  .form-heading {
    margin-bottom: 31px;
  }
  
  .heading-icon {
    width: 42px;
    height: 42px;
    display: grid;
    place-items: center;
    margin-bottom: 20px;
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
  
  .login-form {
    display: flex;
    flex-direction: column;
    gap: 22px;
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
  
  .label-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
  }
  
  .forgot {
    margin-bottom: 9px;
    color: #83dff5;
  }
  
  .input-wrap {
    position: relative;
    display: flex;
    align-items: center;
    min-width: 0;
    height: 54px;
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
    position: relative;
    z-index: 4;
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
  
  /* ĐÈN PIN - MẬT KHẨU LUÔN ĐƯỢC CHE BỞI INPUT */
  
  .password-wrap {
    overflow: hidden;
    isolation: isolate;
    --beam-x: 50%;
    --beam-y: 50%;
  }
  
  /*
    Input thật không hiển thị ký tự.
    Các ký tự hiển thị được vẽ ở lớp secret-text.
  */
  .password-wrap input {
    position: relative;
    z-index: 1;
    color: transparent;
    caret-color: var(--cyan);
    -webkit-text-fill-color: transparent;
    text-shadow: none;
  }
  
  .password-wrap input::placeholder {
    color: transparent;
    -webkit-text-fill-color: transparent;
  }
  
  /* Chữ bí mật: mặc định hoàn toàn tối */
  .secret-text {
    position: absolute;
    z-index: 3;
    left: 43px;
    right: 48px;
    top: 0;
    bottom: 0;
  
    display: flex;
    align-items: center;
    overflow: hidden;
    white-space: pre;
    pointer-events: none;
  
    color: transparent;
    font: 500 12px Inter, sans-serif;
    letter-spacing: normal;
  }
  
  .secret-text > span {
    display: inline-block;
    max-width: 100%;
    overflow: hidden;
    white-space: pre;
  }
  
  /* Placeholder mờ khi chưa nhập mật khẩu */
  .secret-placeholder {
    color: #596985 !important;
  }
  
  /*
    Dùng mask để chỉ phần chữ nằm trong hình nón sáng
    được nhìn thấy. Bên ngoài luồng sáng vẫn trong suốt.
  */
  .beam-enabled .secret-text {
    color: #dffbff;
    text-shadow: 0 0 7px rgba(99,230,255,.9);
    -webkit-mask-image: conic-gradient(
      from 250deg at var(--beam-x) var(--beam-y),
      transparent 0deg,
      #000 22deg,
      #000 45deg,
      transparent 68deg
    );
    mask-image: conic-gradient(
      from 250deg at var(--beam-x) var(--beam-y),
      transparent 0deg,
      #000 22deg,
      #000 45deg,
      transparent 68deg
    );
  }
  
  /* Luồng sáng hình tam giác */
  .flashlight-beam {
    position: absolute;
    z-index: 2;
    inset: 0;
    pointer-events: none;
    opacity: 0;
    background: conic-gradient(
      from 250deg at var(--beam-x) var(--beam-y),
      transparent 0deg,
      rgba(99,230,255,.05) 15deg,
      rgba(99,230,255,.28) 35deg,
      rgba(99,230,255,.12) 50deg,
      transparent 70deg
    );
    transition: opacity .2s;
  }
  
  .beam-enabled .flashlight-beam {
    opacity: 1;
  }
  
  /* Nút đèn pin */
  .flashlight-button {
    position: relative;
    z-index: 5;
    flex-shrink: 0;
    width: 37px;
    height: 37px;
    margin-right: 7px;
    display: grid;
    place-items: center;
    border: 1px solid rgba(99,230,255,.2);
    border-radius: 10px;
    color: #91eaff;
    background: rgba(99,230,255,.07);
    cursor: pointer;
    transition: all .2s;
  }
  
  .flashlight-button:hover,
  .flashlight-button.is-active {
    color: #fff;
    border-color: rgba(99,230,255,.8);
    background: rgba(99,230,255,.2);
    box-shadow: 0 0 18px rgba(99,230,255,.22);
  }
  
  .flashlight-button i {
    font-size: 20px;
  }
  
  .password-hint {
    display: flex;
    align-items: flex-start;
    gap: 6px;
    margin-top: 9px;
    color: #7484a1;
    font-size: 9px;
    line-height: 1.6;
  }
  
  .password-hint i {
    color: #7cdff1;
    font-size: 13px;
    flex-shrink: 0;
  }
  
  /* NÚT ĐĂNG NHẬP */
  
  .submit-button {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    width: 100%;
    height: 55px;
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
  
  /* CHUYỂN ĐỘNG */
  
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
  
  /* TABLET */
  
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
      margin-top: 45px;
    }
  
    .visual-copy h1 {
      font-size: 40px;
    }
  
    .orbital-scene {
      width: min(300px, 100%);
    }
  
    .form-panel {
      padding: 25px 27px 20px;
    }
  }
  
  /* ĐIỆN THOẠI */
  
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
      padding: 22px 23px 15px;
      border-right: 0;
      border-bottom: 1px solid rgba(155,180,255,.14);
    }
  
    .brand-mark {
      width: 37px;
      height: 37px;
    }
  
    .visual-copy {
      margin-top: 27px;
    }
  
    .visual-copy h1 {
      margin: 12px 0 8px;
      font-size: 35px;
      letter-spacing: -1.5px;
    }
  
    .visual-copy p {
      max-width: 480px;
      font-size: 12px;
    }
  
    .feature-pills {
      margin-top: 13px;
    }
  
    .feature-pills span {
      padding: 6px 8px;
      font-size: 9px;
    }
  
    .orbital-scene {
      position: absolute;
      width: 120px;
      right: 12px;
      top: 68px;
      opacity: .3;
    }
  
    .core-chip {
      width: 54px;
      height: 54px;
      border-radius: 15px;
    }
  
    .core-chip i {
      font-size: 23px;
    }
  
    .core-chip span,
    .orbit-node,
    .scene-caption {
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
      padding: 24px 0;
    }
  
    .form-heading {
      margin-bottom: 23px;
    }
  
    .heading-icon {
      margin-bottom: 14px;
    }
  
    .login-form {
      gap: 19px;
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
      font-size: 31px;
    }
  }
  
  /* GIẢM CHUYỂN ĐỘNG THEO CÀI ĐẶT THIẾT BỊ */
  
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



/* FIX AUTOFILL CHROME / COC COC */
.input-wrap input:-webkit-autofill,
.input-wrap input:-webkit-autofill:hover,
.input-wrap input:-webkit-autofill:focus,
.input-wrap input:-webkit-autofill:active,
.input-wrap input:autofill {
    -webkit-text-fill-color: #eef7ff !important;
    caret-color: #eef7ff !important;

    /* Ép nền trình duyệt trở lại màu tối */
    -webkit-box-shadow: 0 0 0 1000px #0b1427 inset !important;
    box-shadow: 0 0 0 1000px #0b1427 inset !important;

    /* Hạn chế trình duyệt tự đổi màu nền */
    transition: background-color 99999s ease-out 0s;
}



/* =========================
   QUÊN MẬT KHẨU - OTP
========================= */

.otp-note {
    text-align: center;
    padding: 10px 5px 18px;
}

.otp-note-icon {
    width: 54px;
    height: 54px;
    display: grid;
    place-items: center;
    margin: 0 auto 13px;
    border: 1px solid rgba(99,230,255,.25);
    border-radius: 16px;
    color: #63e6ff;
    background: rgba(99,230,255,.08);
    font-size: 27px;
}

.otp-note h3 {
    margin: 0 0 9px;
    color: #edf3ff;
    font: 700 19px "Space Grotesk", sans-serif;
}

.otp-note p {
    margin: 0 0 5px;
    color: #8998b5;
    font-size: 11px;
    line-height: 1.7;
}

.otp-note strong {
    display: block;
    color: #63e6ff;
    font-size: 12px;
    overflow-wrap: anywhere;
}

.otp-note small {
    display: block;
    margin-top: 9px;
    color: #65f4c1;
    font-size: 10px;
}

.forgot-actions {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 9px;
    margin-top: 5px;
}

.forgot-secondary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    padding: 6px 10px;
    border: 0;
    color: #63e6ff;
    background: transparent;
    font: 600 11px Inter, sans-serif;
    cursor: pointer;
    transition: color .2s;
}

.forgot-secondary:hover:not(:disabled) {
    color: #ffffff;
}

.forgot-secondary:disabled {
    color: #64738f;
    cursor: not-allowed;
}

.submit-button:disabled {
    opacity: .65;
    cursor: not-allowed;
    transform: none;
}


  </style>
  