<template>
	<footer class="admin-footer">
	  <span>© {{ year }} <strong>TECHSHOP</strong></span>
	  <span class="footer-divider"></span>
	  <span>Admin Console <i class="bx bx-heart"></i> Mạnh Prime</span>
	</footer>
  </template>
  
  <script>
  export default {
	name: 'FootedCDIO',
	data() {
	  return { year: new Date().getFullYear() }
	}
  }
  </script>
  
  <style scoped>
  .admin-footer{display:flex;align-items:center;justify-content:center;gap:10px;min-height:42px;margin:0 18px 10px;padding:10px 16px;border:1px solid #e8edf5;border-radius:13px;background:rgba(255,255,255,.88);color:#8995a7;font-size:10px;letter-spacing:.1px}.admin-footer strong{color:#52627a;font-weight:800;letter-spacing:.6px}.footer-divider{width:1px;height:13px;background:#dfe5ee}.admin-footer i{color:#1687ff;font-size:12px;vertical-align:-1px}@media(max-width:560px){.admin-footer{flex-wrap:wrap;gap:6px;margin:0 8px 8px;font-size:9px}}
  </style>
  