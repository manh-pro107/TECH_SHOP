<template>
  <div class="chat-history-page">
    <div class="page-heading">
      <div>
        <div class="page-eyebrow">TECHSHOP AI ASSISTANT</div>
        <h2>Quản lý hội thoại chatbot</h2>
        <p>Theo dõi các cuộc trò chuyện giữa khách hàng và TECHSHOP AI.</p>
      </div>
      <div class="total-card">
        <span>Tổng cuộc hội thoại</span>
        <strong>{{ total }}</strong>
      </div>
    </div>

    <div class="history-card">
      <div class="toolbar">
        <div class="search-box">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input v-model="keyword" type="text"
            placeholder="Tìm tên khách, mã khách hoặc tin nhắn cuối..."
            @keyup.enter="loadHistory(1)" />
          <button v-if="keyword" type="button" class="clear-search"
            title="Xóa tìm kiếm" @click="resetSearch">×</button>
        </div>
        <button type="button" class="btn-primary-custom"
          :disabled="loading" @click="loadHistory(1)">
          <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm
        </button>
        <button type="button" class="btn-secondary-custom"
          :disabled="loading" @click="resetSearch">
          <i class="fa-solid fa-rotate-right"></i> Làm mới
        </button>
      </div>

      <div v-if="loading" class="state-box">
        <i class="fa-solid fa-spinner fa-spin"></i>
        <span>Đang tải danh sách hội thoại...</span>
      </div>
      <div v-else-if="error" class="state-box error-state">
        <i class="fa-solid fa-circle-exclamation"></i>
        <span>{{ error }}</span>
        <button type="button" class="btn-secondary-custom"
          @click="loadHistory(currentPage)">Thử lại</button>
      </div>
      <div v-else-if="histories.length === 0" class="state-box">
        <div class="empty-icon"><i class="fa-regular fa-comments"></i></div>
        <strong>Chưa có cuộc hội thoại nào</strong>
        <span>Khi khách gửi câu hỏi và AI trả lời thành công, cuộc hội thoại sẽ xuất hiện tại đây.</span>
      </div>

      <div v-else class="table-wrap">
        <table>
          <thead>
            <tr>
              <th class="id-column">Mã</th>
              <th>Khách hàng</th>
              <th>Tin nhắn gần nhất</th>
              <th>Số tin nhắn</th>
              <th>Hoạt động gần nhất</th>
              <th class="action-column">Thao tác</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in histories" :key="item.id">
              <td><span class="id-badge">#{{ item.id }}</span></td>
              <td>
                <div class="customer-cell">
                  <div class="customer-avatar-table"><i class="fa-solid fa-user"></i></div>
                  <div class="customer-details">
                    <strong>{{ customerLabel(item) }}</strong>
                    <small>{{ item.customer_code ? 'Khách hàng đã đăng nhập' : 'Khách vãng lai' }}</small>
                  </div>
                </div>
              </td>
              <td><div class="last-message" :title="item.last_message || ''">
                {{ item.last_message || 'Chưa có tin nhắn' }}
              </div></td>
              <td><span class="message-count">
                <i class="fa-regular fa-comments"></i> {{ item.messages_count || 0 }} tin
              </span></td>
              <td><div class="date-text">
                <i class="fa-regular fa-clock"></i>
                {{ formatDate(item.last_message_at || item.created_at) }}
              </div></td>
              <td class="action-column">
                <button type="button" class="btn-detail"
                  :disabled="detailLoading" @click="viewDetail(item.id)">
                  <i class="fa-regular fa-eye"></i> Xem hội thoại
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-if="!loading && !error && total > 0" class="pagination-bar">
        <span>{{ histories.length }} cuộc hội thoại trên trang ·
          Trang {{ currentPage }}/{{ lastPage }} · Tổng {{ total }} cuộc hội thoại</span>
        <div class="pagination-actions">
          <button type="button" class="page-btn"
            :disabled="currentPage <= 1 || loading"
            @click="loadHistory(currentPage - 1)">
            <i class="fa-solid fa-chevron-left"></i> Trước
          </button>
          <button type="button" class="page-btn"
            :disabled="currentPage >= lastPage || loading"
            @click="loadHistory(currentPage + 1)">
            Sau <i class="fa-solid fa-chevron-right"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- MODAL: toàn bộ tin nhắn của một cuộc hội thoại -->
    <div v-if="showDetail" class="modal-backdrop-custom" @click.self="closeDetail">
      <div class="detail-modal" role="dialog" aria-modal="true"
        aria-labelledby="conversation-detail-title">
        <div class="modal-heading">
          <div class="modal-title-group">
            <div class="ai-icon"><i class="fa-solid fa-robot"></i></div>
            <div class="modal-title-text">
              <div class="page-eyebrow">CHI TIẾT HỘI THOẠI</div>
              <h3 id="conversation-detail-title">
                {{ selectedHistory ? customerLabel(selectedHistory) : 'Đang tải hội thoại...' }}
              </h3>
              <p v-if="selectedHistory" class="modal-subtitle">
                Mã hội thoại #{{ selectedHistory.id }}
                <span v-if="selectedHistory.created_at">· {{ formatDate(selectedHistory.created_at) }}</span>
              </p>
            </div>
          </div>
          <button type="button" class="close-btn" aria-label="Đóng"
            @click="closeDetail">×</button>
        </div>

        <div v-if="detailLoading" class="state-box modal-state">
          <i class="fa-solid fa-spinner fa-spin"></i>
          <span>Đang tải toàn bộ tin nhắn...</span>
        </div>
        <div v-else-if="detailError" class="state-box error-state modal-state">
          <i class="fa-solid fa-circle-exclamation"></i>
          <span>{{ detailError }}</span>
          <button type="button" class="btn-secondary-custom" @click="closeDetail">Đóng</button>
        </div>

        <div v-else-if="selectedHistory" class="conversation-content">
          <div class="conversation-intro">
            <i class="fa-regular fa-comments"></i>
            <span>{{ selectedHistory.messages?.length || 0 }} tin nhắn trong cuộc hội thoại này</span>
          </div>
          <div v-if="!selectedHistory.messages?.length" class="state-box">
            Cuộc hội thoại chưa có tin nhắn.
          </div>

          <div v-for="msg in selectedHistory.messages || []" :key="msg.id"
            class="thread-row"
            :class="msg.sender === 'user' ? 'user-message' : 'assistant-message'">
            <div v-if="msg.sender !== 'user'" class="thread-avatar ai-thread-avatar">
              <i class="fa-solid fa-robot"></i>
            </div>
            <div class="thread-message">
              <div class="thread-sender">
                {{ msg.sender === 'user' ? 'Khách hàng' : 'TECHSHOP AI' }}
              </div>
              <div class="thread-bubble">{{ msg.content }}</div>
              <div class="thread-time">{{ formatDate(msg.created_at) }}</div>
            </div>
            <div v-if="msg.sender === 'user'" class="thread-avatar customer-thread-avatar">
              <i class="fa-solid fa-user"></i>
            </div>
          </div>
        </div>

        <div class="modal-footer-custom">
          <button type="button" class="btn-primary-custom" @click="closeDetail">
            Đóng hội thoại
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "AdminChatbotHistory",

  data() {
    return {
      histories: [],
      keyword: "",
      loading: false,
      error: "",
      currentPage: 1,
      lastPage: 1,
      total: 0,
      showDetail: false,
      selectedHistory: null,
      detailLoading: false,
      detailError: "",
    };
  },

  mounted() {
    this.loadHistory(1);
  },

  methods: {
    async loadHistory(page = 1) {
      this.loading = true;
      this.error = "";

      try {
        const token = localStorage.getItem("admin_token");
        if (!token) {
          this.error = "Bạn chưa đăng nhập Admin. Vui lòng đăng nhập lại.";
          return;
        }

        const response = await axios.get(
          "http://127.0.0.1:8000/api/admin/chatbot-histories",
          {
            headers: { Authorization: `Bearer ${token}` },
            params: { page, q: this.keyword.trim() },
          }
        );

        const result = response?.data?.data;
        if (!response?.data?.status || !result) {
          throw new Error("INVALID_HISTORY_RESPONSE");
        }

        this.histories = result.data || [];
        this.currentPage = result.current_page || 1;
        this.lastPage = result.last_page || 1;
        this.total = result.total || 0;
      } catch (error) {
        console.error("Lỗi tải lịch sử chatbot:", error);
        if (error?.response?.status === 401 || error?.response?.status === 403) {
          this.error = "Bạn chưa đăng nhập hoặc tài khoản không có quyền xem lịch sử chatbot.";
        } else {
          this.error = "Không tải được lịch sử. Hãy kiểm tra API và máy chủ Laravel.";
        }
      } finally {
        this.loading = false;
      }
    },

    async viewDetail(id) {
      this.showDetail = true;
      this.selectedHistory = null;
      this.detailLoading = true;
      this.detailError = "";

      try {
        const token = localStorage.getItem("admin_token");
        if (!token) {
          this.detailError = "Bạn chưa đăng nhập Admin. Vui lòng đăng nhập lại.";
          return;
        }

        const response = await axios.get(
          `http://127.0.0.1:8000/api/admin/chatbot-histories/${id}`,
          { headers: { Authorization: `Bearer ${token}` } }
        );

        if (!response?.data?.status || !response?.data?.data) {
          throw new Error("CONVERSATION_NOT_FOUND");
        }

        this.selectedHistory = response.data.data;
      } catch (error) {
        console.error("Lỗi xem chi tiết hội thoại:", error);
        this.detailError =
          error?.response?.status === 401 || error?.response?.status === 403
            ? "Bạn không có quyền xem hội thoại này."
            : "Không tải được nội dung hội thoại. Vui lòng thử lại.";
      } finally {
        this.detailLoading = false;
      }
    },

    customerLabel(item) {
      if (!item) return "Cuộc hội thoại";
      if (item.customer_name && item.customer_name !== "Khách vãng lai") {
        return item.customer_name;
      }
      const guestId = item.visitor_key
        ? String(item.visitor_key).slice(0, 4).toUpperCase()
        : item.id;
      return `Khách vãng lai #${guestId}`;
    },

    closeDetail() {
      this.showDetail = false;
      this.selectedHistory = null;
      this.detailError = "";
    },

    resetSearch() {
      this.keyword = "";
      this.loadHistory(1);
    },

    formatDate(value) {
      if (!value) return "—";
      const date = new Date(value);
      if (Number.isNaN(date.getTime())) return value;
      return date.toLocaleString("vi-VN", {
        dateStyle: "short",
        timeStyle: "short",
      });
    },
  },
};
</script>

<style scoped>
/* =========================================================
   BẢNG MÀU & BIẾN DÙNG CHUNG
   ========================================================= */
.chat-history-page {
  --primary: #4f46e5;
  --primary-2: #2563eb;
  --accent: #06b6d4;
  --navy: #0f172a;
  --text: #1e293b;
  --muted: #64748b;
  --line: #e2e8f0;
  --soft: #f1f5f9;
  --grad-primary: linear-gradient(135deg, #4f46e5 0%, #2563eb 55%, #06b6d4 100%);
  --grad-danger: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
  --shadow-sm: 0 2px 8px rgba(15, 23, 42, 0.06);
  --ease: cubic-bezier(0.22, 1, 0.36, 1);

  min-width: 0;
  padding: 26px;
  color: var(--text);
  font-family: "Roboto", "Inter", Arial, sans-serif;
}

.chat-history-page * {
  box-sizing: border-box;
}

/* =========================================================
   KEYFRAMES
   ========================================================= */
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(16px); }
  to { opacity: 1; transform: translateY(0); }
}

@keyframes rowIn {
  from { opacity: 0; transform: translateX(-10px); }
  to { opacity: 1; transform: translateX(0); }
}

@keyframes shine {
  from { transform: translateX(-120%) skewX(-20deg); }
  to { transform: translateX(260%) skewX(-20deg); }
}

@keyframes overlayIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes modalIn {
  from { opacity: 0; transform: translateY(28px) scale(0.95); }
  to { opacity: 1; transform: translateY(0) scale(1); }
}

@keyframes bubbleInLeft {
  from { opacity: 0; transform: translateX(-18px) scale(0.92); }
  to { opacity: 1; transform: translateX(0) scale(1); }
}

@keyframes bubbleInRight {
  from { opacity: 0; transform: translateX(18px) scale(0.92); }
  to { opacity: 1; transform: translateX(0) scale(1); }
}

@keyframes floatIcon {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-4px); }
}

@keyframes aiGlow {
  0%, 100% { box-shadow: 0 8px 18px rgba(79, 70, 229, 0.35); }
  50% { box-shadow: 0 8px 26px rgba(6, 182, 212, 0.55); }
}

.page-heading { animation: fadeUp 0.5s var(--ease) both; }
.history-card { animation: fadeUp 0.6s var(--ease) 0.15s both; }

tbody tr { animation: rowIn 0.4s var(--ease) both; }
tbody tr:nth-child(1) { animation-delay: 0.04s; }
tbody tr:nth-child(2) { animation-delay: 0.08s; }
tbody tr:nth-child(3) { animation-delay: 0.12s; }
tbody tr:nth-child(4) { animation-delay: 0.16s; }
tbody tr:nth-child(5) { animation-delay: 0.2s; }
tbody tr:nth-child(6) { animation-delay: 0.24s; }
tbody tr:nth-child(7) { animation-delay: 0.28s; }
tbody tr:nth-child(8) { animation-delay: 0.32s; }

/* =========================================================
   TIÊU ĐỀ
   ========================================================= */
.page-heading {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
  margin-bottom: 26px;
}

.page-eyebrow {
  display: inline-flex;
  margin-bottom: 10px;
  padding: 4px 12px;
  border-radius: 999px;
  color: var(--primary);
  background: #e0e7ff;
  font-size: 10.5px;
  font-weight: 800;
  letter-spacing: 1.4px;
}

.page-heading h2 {
  margin: 0 0 8px;
  font-size: clamp(25px, 3vw, 31px);
  font-weight: 800;
  letter-spacing: -0.5px;
  background: linear-gradient(90deg, #0f172a 0%, #4f46e5 100%);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}

.page-heading p {
  margin: 0;
  color: var(--muted);
  font-size: 14px;
  line-height: 1.6;
}

/* thẻ tổng cuộc hội thoại */
.total-card {
  position: relative;
  overflow: hidden;
  min-width: 190px;
  padding: 18px 22px;
  border-radius: 16px;
  color: #fff;
  background: var(--grad-primary);
  box-shadow: 0 12px 28px rgba(79, 70, 229, 0.35);
  transition: transform 0.3s var(--ease), box-shadow 0.3s var(--ease);
}

.total-card::before {
  content: "";
  position: absolute;
  top: -34px;
  right: -34px;
  width: 110px;
  height: 110px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.16);
  transition: transform 0.5s var(--ease);
}

.total-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 18px 38px rgba(79, 70, 229, 0.45);
}

.total-card:hover::before { transform: scale(1.5); }

.total-card span,
.total-card strong {
  position: relative;
  display: block;
}

.total-card span {
  color: rgba(255, 255, 255, 0.85);
  font-size: 12px;
  font-weight: 600;
}

.total-card strong {
  margin-top: 6px;
  color: #fff;
  font-size: 32px;
  font-weight: 800;
  line-height: 1.1;
}

/* =========================================================
   KHUNG DANH SÁCH
   ========================================================= */
.history-card {
  overflow: hidden;
  border: 1px solid var(--line);
  border-radius: 18px;
  background: #fff;
  box-shadow: 0 8px 30px rgba(15, 23, 42, 0.06);
}

.toolbar {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 18px 20px;
  border-bottom: 1px solid var(--line);
  background: #f8fafc;
}

.search-box {
  display: flex;
  align-items: center;
  gap: 10px;
  flex: 1;
  min-width: 150px;
  max-width: 560px;
  height: 46px;
  padding: 0 14px;
  border: 1.5px solid var(--line);
  border-radius: 12px;
  color: var(--muted);
  background: #fff;
  transition: all 0.25s var(--ease);
}

.search-box:hover { border-color: #c7d2fe; }

.search-box:focus-within {
  color: var(--primary);
  border-color: var(--primary);
  box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
}

.search-box > i { font-size: 13px; }

.search-box input {
  width: 100%;
  min-width: 0;
  height: 100%;
  border: 0;
  outline: none;
  background: transparent;
  color: var(--navy);
  font-size: 13px;
}

.search-box input::placeholder { color: #94a3b8; }

.clear-search {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 24px;
  height: 24px;
  padding: 0;
  border: 0;
  border-radius: 50%;
  color: #64748b;
  background: #e2e8f0;
  font-size: 17px;
  line-height: 1;
  cursor: pointer;
  transition: all 0.2s;
}

.clear-search:hover {
  color: #fff;
  background: #f43f5e;
  transform: rotate(90deg);
}

/* =========================================================
   NÚT
   ========================================================= */
.btn-primary-custom,
.btn-secondary-custom,
.btn-detail,
.page-btn {
  position: relative;
  overflow: hidden;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  min-height: 42px;
  padding: 0 16px;
  border-radius: 11px;
  font-size: 12.5px;
  font-weight: 700;
  white-space: nowrap;
  cursor: pointer;
  transition: transform 0.25s var(--ease), box-shadow 0.25s var(--ease),
    background 0.25s, border-color 0.25s, filter 0.25s;
}

.btn-primary-custom {
  border: 0;
  color: #fff;
  background: var(--grad-primary);
  background-size: 140% 140%;
  background-position: 0% 50%;
  box-shadow: 0 8px 18px rgba(79, 70, 229, 0.32);
}

.btn-primary-custom::after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 40%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.35), transparent);
  transform: translateX(-120%) skewX(-20deg);
  pointer-events: none;
}

.btn-primary-custom:hover:not(:disabled) {
  transform: translateY(-2px);
  background-position: 100% 50%;
  box-shadow: 0 12px 26px rgba(79, 70, 229, 0.42);
}

.btn-primary-custom:hover:not(:disabled)::after {
  animation: shine 0.8s var(--ease);
}

.btn-primary-custom:active:not(:disabled) { transform: scale(0.97); }

.btn-secondary-custom,
.page-btn {
  border: 1.5px solid var(--line);
  color: #475569;
  background: #fff;
}

.btn-secondary-custom:hover:not(:disabled),
.page-btn:hover:not(:disabled) {
  color: var(--primary);
  border-color: #c7d2fe;
  background: #eef2ff;
  transform: translateY(-2px);
}

.btn-detail {
  min-height: 36px;
  padding: 0 14px;
  border: 0;
  color: #fff;
  background: linear-gradient(135deg, #6366f1, #2563eb);
  box-shadow: 0 5px 12px rgba(79, 70, 229, 0.3);
}

.btn-detail:hover:not(:disabled) {
  transform: translateY(-3px);
  filter: brightness(1.06);
  box-shadow: 0 10px 20px rgba(79, 70, 229, 0.45);
}

.btn-detail:active:not(:disabled) { transform: scale(0.95); }

button:disabled {
  cursor: not-allowed;
  opacity: 0.55;
}

/* =========================================================
   BẢNG
   ========================================================= */
.table-wrap {
  width: 100%;
  overflow-x: auto;
}

table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  text-align: left;
}

.table-wrap table { min-width: 940px; }

th {
  padding: 15px 18px;
  color: #3730a3;
  background: linear-gradient(180deg, #eef2ff, #e0e7ff);
  font-size: 11px;
  font-weight: 800;
  letter-spacing: 0.5px;
  text-transform: uppercase;
  white-space: nowrap;
}

td {
  padding: 16px 18px;
  border-bottom: 1px solid #eef2f7;
  font-size: 13px;
  vertical-align: middle;
  transition: background 0.25s;
}

tbody tr:hover td { background: #f5f7ff; }
tbody tr:hover td:first-child { box-shadow: inset 4px 0 0 var(--primary); }
tbody tr:last-child td { border-bottom: 0; }

.id-column { width: 80px; }

.action-column {
  text-align: right;
  white-space: nowrap;
}

.id-badge {
  display: inline-flex;
  align-items: center;
  padding: 6px 11px;
  border-radius: 8px;
  color: #4338ca;
  background: #e0e7ff;
  font-size: 11.5px;
  font-weight: 800;
}

.customer-cell {
  display: flex;
  align-items: center;
  gap: 12px;
  min-width: 190px;
}

.customer-avatar-table {
  display: grid;
  width: 42px;
  height: 42px;
  flex-shrink: 0;
  place-items: center;
  border: 2px solid #fff;
  border-radius: 50%;
  color: #fff;
  background: var(--grad-primary);
  box-shadow: 0 0 0 2px #c7d2fe, 0 4px 10px rgba(79, 70, 229, 0.18);
  transition: transform 0.3s var(--ease), box-shadow 0.3s var(--ease);
}

tbody tr:hover .customer-avatar-table {
  transform: scale(1.1);
  box-shadow: 0 0 0 2px var(--primary), 0 8px 16px rgba(79, 70, 229, 0.3);
}

.customer-details strong,
.customer-details small { display: block; }

.customer-details strong {
  color: var(--navy);
  font-size: 12.5px;
  font-weight: 700;
  transition: color 0.2s;
}

tbody tr:hover .customer-details strong { color: var(--primary); }

.customer-details small {
  margin-top: 4px;
  color: #94a3b8;
  font-size: 10.5px;
}

.last-message {
  max-width: 320px;
  overflow: hidden;
  color: #334155;
  font-weight: 500;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.message-count {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  padding: 7px 12px;
  border-radius: 999px;
  color: #fff;
  background: linear-gradient(135deg, #818cf8, #4f46e5);
  box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
  font-size: 11.5px;
  font-weight: 700;
  white-space: nowrap;
  transition: transform 0.3s var(--ease);
}

tbody tr:hover .message-count { transform: scale(1.08); }

.date-text {
  display: flex;
  align-items: center;
  gap: 8px;
  color: var(--muted);
  font-size: 12px;
  white-space: nowrap;
}

.date-text i { color: var(--primary); }

/* =========================================================
   TRẠNG THÁI TẢI / LỖI / TRỐNG
   ========================================================= */
.state-box {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 12px;
  min-height: 210px;
  padding: 30px;
  color: var(--muted);
  font-size: 13px;
  text-align: center;
}

.state-box > i {
  font-size: 28px;
  color: var(--primary);
}

.error-state {
  color: #be123c;
  background: linear-gradient(180deg, #fff1f2, #fff);
}

.error-state > i { color: #f43f5e; }

.empty-icon {
  display: grid;
  width: 76px;
  height: 76px;
  place-items: center;
  border-radius: 50%;
  color: var(--primary);
  background: #e0e7ff;
  font-size: 30px;
  animation: floatIcon 2.4s ease-in-out infinite;
}

.state-box strong {
  color: var(--navy);
  font-size: 15px;
  font-weight: 800;
}

.state-box span {
  max-width: 420px;
  line-height: 1.7;
}

/* =========================================================
   PHÂN TRANG
   ========================================================= */
.pagination-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 14px;
  padding: 15px 22px;
  border-top: 1px solid var(--line);
  background: #f8fafc;
  color: var(--muted);
  font-size: 12px;
}

.pagination-actions {
  display: flex;
  gap: 8px;
}

.page-btn {
  min-height: 38px;
  padding: 0 14px;
}

/* =========================================================
   MODAL HỘI THOẠI (KIỂU MESSENGER)
   ========================================================= */
.modal-backdrop-custom {
  position: fixed;
  inset: 0;
  z-index: 3000;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
  background: rgba(15, 23, 42, 0.58);
  backdrop-filter: blur(5px);
  animation: overlayIn 0.25s ease both;
}

.detail-modal {
  display: flex;
  flex-direction: column;
  width: min(780px, 100%);
  max-height: min(88vh, 900px);
  overflow: hidden;
  border-radius: 20px;
  background: #fff;
  box-shadow: 0 30px 90px rgba(15, 23, 42, 0.32);
  animation: modalIn 0.4s var(--ease) both;
}

.modal-heading {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 15px;
  padding: 22px 26px;
  background: var(--grad-primary);
}

.modal-title-group {
  display: flex;
  align-items: center;
  gap: 14px;
  min-width: 0;
}

.ai-icon {
  display: grid;
  width: 50px;
  height: 50px;
  flex-shrink: 0;
  place-items: center;
  border: 2px solid rgba(255, 255, 255, 0.55);
  border-radius: 16px;
  color: #4f46e5;
  background: #fff;
  font-size: 21px;
  animation: aiGlow 2.4s ease-in-out infinite;
}

.modal-title-text { min-width: 0; }

.modal-heading .page-eyebrow {
  margin-bottom: 6px;
  color: #fff;
  background: rgba(255, 255, 255, 0.22);
}

.modal-heading h3 {
  margin: 0;
  color: #fff;
  font-size: 19px;
  font-weight: 800;
  overflow-wrap: anywhere;
}

.modal-subtitle {
  margin: 5px 0 0;
  color: rgba(255, 255, 255, 0.85);
  font-size: 11.5px;
}

.close-btn {
  display: grid;
  width: 38px;
  height: 38px;
  flex-shrink: 0;
  place-items: center;
  border: 0;
  border-radius: 50%;
  color: #fff;
  background: rgba(255, 255, 255, 0.2);
  font-size: 26px;
  line-height: 1;
  cursor: pointer;
  transition: transform 0.3s var(--ease), background 0.2s;
}

.close-btn:hover {
  background: rgba(255, 255, 255, 0.35);
  transform: rotate(90deg);
}

.modal-state { min-height: 240px; }

.conversation-content {
  overflow-y: auto;
  padding: 22px 26px;
  background:
    radial-gradient(circle at 15% 10%, rgba(99, 102, 241, 0.06), transparent 40%),
    radial-gradient(circle at 85% 90%, rgba(6, 182, 212, 0.06), transparent 40%),
    #f8fafc;
}

.conversation-intro {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  width: fit-content;
  margin: 0 auto 24px;
  padding: 6px 14px;
  border-radius: 999px;
  color: var(--primary);
  background: #e0e7ff;
  font-size: 11.5px;
  font-weight: 700;
}

/* tin nhắn */
.thread-row {
  display: flex;
  align-items: flex-end;
  gap: 10px;
  margin-bottom: 22px;
}

.thread-row.user-message {
  justify-content: flex-end;
  animation: bubbleInRight 0.45s var(--ease) both;
}

.thread-row.assistant-message {
  justify-content: flex-start;
  animation: bubbleInLeft 0.45s var(--ease) both;
}

.thread-row:nth-child(3) { animation-delay: 0.05s; }
.thread-row:nth-child(4) { animation-delay: 0.1s; }
.thread-row:nth-child(5) { animation-delay: 0.15s; }
.thread-row:nth-child(6) { animation-delay: 0.2s; }
.thread-row:nth-child(7) { animation-delay: 0.25s; }
.thread-row:nth-child(8) { animation-delay: 0.3s; }

.thread-avatar {
  display: grid;
  width: 36px;
  height: 36px;
  flex-shrink: 0;
  place-items: center;
  border-radius: 50%;
  font-size: 14px;
}

.ai-thread-avatar {
  color: #fff;
  background: var(--grad-primary);
  box-shadow: 0 6px 14px rgba(79, 70, 229, 0.35);
}

.customer-thread-avatar {
  color: #fff;
  background: linear-gradient(135deg, #94a3b8, #64748b);
  box-shadow: 0 6px 14px rgba(100, 116, 139, 0.3);
}

.thread-message {
  max-width: min(82%, 560px);
  min-width: 0;
}

.thread-sender {
  margin-bottom: 6px;
  color: var(--muted);
  font-size: 10.5px;
  font-weight: 700;
}

.user-message .thread-sender,
.user-message .thread-time { text-align: right; }

.thread-bubble {
  padding: 13px 16px;
  border-radius: 18px;
  font-size: 13px;
  line-height: 1.8;
  overflow-wrap: anywhere;
  white-space: pre-wrap;
  transition: transform 0.25s var(--ease), box-shadow 0.25s var(--ease);
}

.thread-bubble:hover { transform: translateY(-2px); }

.user-message .thread-bubble {
  border: 0;
  border-bottom-right-radius: 5px;
  color: #fff;
  background: var(--grad-primary);
  box-shadow: 0 8px 18px rgba(79, 70, 229, 0.3);
}

.user-message .thread-bubble:hover {
  box-shadow: 0 12px 24px rgba(79, 70, 229, 0.4);
}

.assistant-message .thread-bubble {
  border: 1px solid var(--line);
  border-bottom-left-radius: 5px;
  color: #1e293b;
  background: #fff;
  box-shadow: 0 4px 12px rgba(15, 23, 42, 0.06);
}

.assistant-message .thread-bubble:hover {
  box-shadow: 0 8px 18px rgba(15, 23, 42, 0.1);
}

.thread-time {
  margin-top: 5px;
  color: #94a3b8;
  font-size: 10.5px;
}

.modal-footer-custom {
  display: flex;
  justify-content: flex-end;
  padding: 16px 26px;
  border-top: 1px solid var(--line);
  background: #fff;
}

/* thanh cuộn gọn */
.table-wrap::-webkit-scrollbar,
.conversation-content::-webkit-scrollbar { width: 8px; height: 8px; }

.table-wrap::-webkit-scrollbar-thumb,
.conversation-content::-webkit-scrollbar-thumb {
  border-radius: 8px;
  background: #c7d2fe;
}

.table-wrap::-webkit-scrollbar-thumb:hover,
.conversation-content::-webkit-scrollbar-thumb:hover { background: #818cf8; }

/* =========================================================
   RESPONSIVE
   ========================================================= */
@media (max-width: 900px) {
  .chat-history-page { padding: 18px; }
}

@media (max-width: 650px) {
  .chat-history-page { padding: 12px; }
  .page-heading { align-items: flex-start; flex-direction: column; }
  .total-card { width: 100%; }
  .toolbar { flex-wrap: wrap; padding: 13px; }
  .search-box { flex-basis: 100%; max-width: none; }
  .pagination-bar { align-items: flex-start; flex-direction: column; padding: 14px 15px; }
  .modal-backdrop-custom { padding: 8px; }
  .detail-modal { max-height: 92vh; border-radius: 16px; }
  .modal-heading,
  .conversation-content { padding: 16px; }
  .modal-heading h3 { font-size: 15.5px; }
  .ai-icon { width: 42px; height: 42px; font-size: 18px; }
  .thread-message { max-width: 86%; }
  .modal-footer-custom { padding: 12px 16px; }
}

/* Tôn trọng người dùng tắt hiệu ứng chuyển động */
@media (prefers-reduced-motion: reduce) {
  .chat-history-page *,
  .chat-history-page *::before,
  .chat-history-page *::after {
    animation: none !important;
    transition: none !important;
  }
}
</style>