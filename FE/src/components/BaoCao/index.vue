<template>

    <div class="report-container">

        <!-- TOP -->
        <div class="top-box">

            <div class="top-title">

                <i class='bx bx-bar-chart-alt-2'></i>

                Báo Cáo Doanh Thu

            </div>

            <div class="top-action">

                <!-- FILTER -->
                <div class="filter-box">

                    <i class='bx bx-calendar'></i>

                    <select v-model="selectedTime">

                        <option value="">
                            Chọn khoảng thời gian
                        </option>

                        <option value="7">
                            7 ngày gần đây
                        </option>

                        <option value="30">
                            30 ngày gần đây
                        </option>

                        <option value="90">
                            3 tháng gần đây
                        </option>

                        <option value="365">
                            1 năm gần đây
                        </option>

                    </select>

                </div>

                <!-- BUTTON -->
                <button
                    class="export-btn"
                    @click="showModal = true"
                >

                    <i class='bx bx-export'></i>

                    Xuất Báo Cáo

                </button>

            </div>

        </div>

        <!-- CARD -->
        <div class="card-grid">

            <!-- CHART 1 -->
            <div class="chart-card">

                <h2>Doanh Thu Theo Tháng</h2>

                <Bar
                    :data="barData"
                    :options="chartOptions"
                />

            </div>

            <!-- CHART 2 -->
            <div class="chart-card">

                <h2>Tỉ Lệ Doanh Thu</h2>

                <Pie
                    :data="pieData"
                    :options="chartOptions"
                />

            </div>

        </div>

        <!-- TABLE -->
        <div class="table-card mb-5">

            <div class="table-title">

                <i class='bx bx-table'></i>

                Bảng Thống Kê Doanh Thu

            </div>

            <table>

                <thead>

                    <tr>

                        <th>Tháng</th>
                        <th>Đơn hàng</th>
                        <th>Doanh thu</th>
                        <th>Lợi nhuận</th>

                    </tr>

                </thead>

                <tbody>

                    <tr
                        v-for="(item,index) in tableData"
                        :key="index"
                    >

                        <td>{{ item.month }}</td>
                        <td>{{ item.order }}</td>
                        <td>{{ item.revenue }}</td>
                        <td>{{ item.profit }}</td>

                    </tr>

                </tbody>

            </table>

        </div>

        <!-- FLOW -->
        <div class="flow-card">

            <div class="flow-title">

                <i class='bx bx-git-branch'></i>

                Quy Trình Báo Cáo Doanh Thu

            </div>

            <div class="flow-grid">

                <div class="flow-step">

                    <div class="circle">1</div>

                    <p>Chọn khoảng thời gian</p>

                </div>

                <div class="line"></div>

                <div class="flow-step">

                    <div class="circle">2</div>

                    <p>Hệ thống kiểm tra dữ liệu</p>

                </div>

                <div class="line"></div>

                <div class="flow-step">

                    <div class="circle">3</div>

                    <p>Hiển thị thống kê doanh thu</p>

                </div>

                <div class="line"></div>

                <div class="flow-step">

                    <div class="circle">4</div>

                    <p>Xuất file báo cáo</p>

                </div>

            </div>

        </div>

        <!-- MODAL -->
        <div
            v-if="showModal"
            class="modal-overlay"
        >

            <div class="export-modal">

                <!-- CLOSE -->
                <div
                    class="close-btn"
                    @click="showModal = false"
                >

                    <i class='bx bx-x'></i>

                </div>

                <!-- TITLE -->
                <div class="modal-title">

                    <i class='bx bx-download'></i>

                    Xuất Báo Cáo

                </div>

                <!-- OPTIONS -->
                <div class="export-grid">

                    <!-- EXCEL -->
                    <div class="export-card excel">

                        <div class="export-icon">

                            <i class='bx bxs-file-export'></i>

                        </div>

                        <h3>Excel</h3>

                        <p>Xuất dữ liệu bảng doanh thu</p>

                        <button>

                            Xuất File

                        </button>

                    </div>

                    <!-- PDF -->
                    <div class="export-card pdf">

                        <div class="export-icon">

                            <i class='bx bxs-file-pdf'></i>

                        </div>

                        <h3>PDF</h3>

                        <p>Xuất báo cáo dạng tài liệu</p>

                        <button>

                            Xuất File

                        </button>

                    </div>

                    <!-- IMAGE -->
                    <div class="export-card image">

                        <div class="export-icon">

                            <i class='bx bxs-image'></i>

                        </div>

                        <h3>Ảnh PNG</h3>

                        <p>Lưu biểu đồ thành hình ảnh</p>

                        <button>

                            Xuất File

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

</template>

<script>

import {
    Bar,
    Pie
} from 'vue-chartjs'

import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    ArcElement,
    CategoryScale,
    LinearScale
} from 'chart.js'

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    ArcElement,
    CategoryScale,
    LinearScale
)

export default {

    components:{
        Bar,
        Pie
    },

    data(){

        return{

            showModal:false,

            selectedTime:'',

            barData:{

                labels:[
                    'T1',
                    'T2',
                    'T3',
                    'T4',
                    'T5',
                    'T6'
                ],

                datasets:[

                    {
                        label:'Doanh thu',

                        data:[
                            120,
                            190,
                            150,
                            220,
                            260,
                            300
                        ],

                        backgroundColor:[
                            '#ff8c42'
                        ],

                        borderRadius:12
                    }

                ]

            },

            pieData:{

                labels:[
                    'Laptop',
                    'Chuột',
                    'Bàn phím',
                    'Tai nghe'
                ],

                datasets:[

                    {
                        data:[
                            45,
                            20,
                            15,
                            20
                        ],

                        backgroundColor:[
                            '#ff7a00',
                            '#ff9a3d',
                            '#ffbe7a',
                            '#ffe2c2'
                        ]
                    }

                ]

            },

            chartOptions:{

                responsive:true,

                plugins:{
                    legend:{
                        labels:{
                            color:'#444',
                            font:{
                                size:14
                            }
                        }
                    }
                },

                scales:{
                    y:{
                        ticks:{
                            color:'#555'
                        },

                        grid:{
                            color:'#f1e2d7'
                        }
                    },

                    x:{
                        ticks:{
                            color:'#555'
                        },

                        grid:{
                            color:'#f1e2d7'
                        }
                    }
                }

            },

            tableData:[

                {
                    month:'Tháng 1',
                    order:120,
                    revenue:'12.000.000đ',
                    profit:'4.000.000đ'
                },

                {
                    month:'Tháng 2',
                    order:180,
                    revenue:'18.000.000đ',
                    profit:'6.500.000đ'
                },

                {
                    month:'Tháng 3',
                    order:220,
                    revenue:'24.000.000đ',
                    profit:'8.000.000đ'
                },

                {
                    month:'Tháng 4',
                    order:310,
                    revenue:'32.000.000đ',
                    profit:'12.000.000đ'
                },

                {
                    month:'Tháng 5',
                    order:310,
                    revenue:'32.000.000đ',
                    profit:'12.000.000đ'
                },

                {
                    month:'Tháng 6',
                    order:310,
                    revenue:'32.000.000đ',
                    profit:'12.000.000đ'
                }

            ]

        }

    }

}

</script>

<style scoped>

*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial;
}

.report-container{
    padding: 30px;

    min-height: 100vh;

    background:
    linear-gradient(
        135deg,
        #fffaf5,
        #fff4ec,
        #fff8f3
    );
}

/* TOP */

.top-box{
    display: flex;
    justify-content: space-between;
    align-items: center;

    margin-bottom: 28px;
}

.top-title{
    font-size: 34px;
    font-weight: 700;

    color: #2b2b2b;

    display: flex;
    align-items: center;
    gap: 12px;
}

.top-title i{
    color: #ff7a00;
}

.top-action{
    display: flex;
    align-items: center;
    gap: 15px;
}

/* FILTER */

.filter-box{
    height: 52px;

    padding: 0 18px;

    background: white;

    border:
    1px solid #f4e6da;

    border-radius: 16px;

    display: flex;
    align-items: center;
    gap: 10px;

    box-shadow:
    0 5px 15px rgba(0,0,0,0.04);
}

.filter-box i{
    color: #ff7a00;

    font-size: 22px;
}

.filter-box select{
    border: none;
    outline: none;

    background: transparent;

    font-size: 15px;

    color: #444;

    cursor: pointer;
}

/* BUTTON */

.export-btn{
    border: none;

    height: 52px;

    padding: 0 28px;

    border-radius: 16px;

    background:
    linear-gradient(
        135deg,
        #ff9a3d,
        #ff7a00
    );

    color: white;

    font-size: 17px;

    font-weight: 600;

    cursor: pointer;

    transition: 0.3s;

    box-shadow:
    0 10px 20px rgba(255,122,0,0.15);
}

.export-btn:hover{
    transform: translateY(-3px);
}

/* GRID */

.card-grid{
    display: grid;

    grid-template-columns:
    repeat(2,1fr);

    gap: 28px;

    margin-bottom: 28px;
}

/* CARD */

.chart-card,
.table-card,
.flow-card{
    background: white;

    border-radius: 30px;

    padding: 28px;

    border:
    1px solid #f4e6da;

    box-shadow:
    0 10px 30px rgba(0,0,0,0.05);
}

.chart-card h2{
    color: #2b2b2b;

    margin-bottom: 20px;

    text-align: center;
}

/* TABLE */

.table-title,
.flow-title{
    color: #2b2b2b;

    font-size: 30px;

    font-weight: 700;

    margin-bottom: 25px;

    display: flex;
    align-items: center;
    gap: 12px;
}

.table-title i,
.flow-title i{
    color: #ff7a00;
}

table{
    width: 100%;
    border-collapse: collapse;
}

table thead{
    background: #fff5eb;
}

table th{
    padding: 18px;
}

table td{
    padding: 18px;

    text-align: center;

    border-top:
    1px solid #f5e6da;

    color: #555;
}

table tbody tr:hover{
    background: #fffaf5;
}

/* FLOW */

.flow-grid{
    display: flex;
    justify-content: space-between;
    align-items: center;

    gap: 18px;
}

.flow-step{
    flex: 1;
    text-align: center;
}

.circle{
    width: 82px;
    height: 82px;

    border-radius: 50%;

    background:
    linear-gradient(
        135deg,
        #ffae5d,
        #ff7a00
    );

    margin: auto;

    display: flex;
    justify-content: center;
    align-items: center;

    color: white;

    font-size: 32px;

    font-weight: bold;

    margin-bottom: 18px;
}

.flow-step p{
    color: #444;

    font-size: 18px;

    font-weight: 600;

    line-height: 1.6;
}

.line{
    height: 4px;

    flex: 0.5;

    background:
    linear-gradient(
        90deg,
        #ffb067,
        #ff7a00
    );

    border-radius: 20px;
}

/* MODAL */

.modal-overlay{
    position: fixed;

    inset: 0;

    background:
    rgba(0,0,0,0.35);

    display: flex;
    justify-content: center;
    align-items: center;

    z-index: 999;
}

.export-modal{
    width: 850px;

    background: white;

    border-radius: 35px;

    padding: 35px;

    position: relative;

    animation: showModal 0.3s ease;
}

@keyframes showModal{
    from{
        transform: scale(0.9);
        opacity: 0;
    }

    to{
        transform: scale(1);
        opacity: 1;
    }
}

.close-btn{
    position: absolute;

    top: 18px;
    right: 20px;

    width: 45px;
    height: 45px;

    border-radius: 50%;

    background: #fff4ec;

    display: flex;
    justify-content: center;
    align-items: center;

    cursor: pointer;

    font-size: 28px;

    color: #ff7a00;
}

.modal-title{
    font-size: 32px;

    font-weight: 700;

    color: #2b2b2b;

    margin-bottom: 30px;

    display: flex;
    align-items: center;
    gap: 12px;
}

.modal-title i{
    color: #ff7a00;
}

.export-grid{
    display: grid;

    grid-template-columns:
    repeat(3,1fr);

    gap: 25px;
}

.export-card{
    background: #fffaf5;

    border:
    1px solid #f4e6da;

    border-radius: 28px;

    padding: 30px 20px;

    text-align: center;

    transition: 0.3s;
}

.export-card:hover{
    transform: translateY(-5px);
}

.export-icon{
    width: 90px;
    height: 90px;

    margin: auto;

    border-radius: 25px;

    display: flex;
    justify-content: center;
    align-items: center;

    font-size: 42px;

    color: white;

    margin-bottom: 20px;
}

.excel .export-icon{
    background:
    linear-gradient(135deg,#34d399,#059669);
}

.pdf .export-icon{
    background:
    linear-gradient(135deg,#ff6b6b,#dc2626);
}

.image .export-icon{
    background:
    linear-gradient(135deg,#60a5fa,#2563eb);
}

.export-card h3{
    margin-bottom: 10px;

    font-size: 24px;

    color: #2b2b2b;
}

.export-card p{
    color: #666;

    line-height: 1.6;

    margin-bottom: 20px;
}

.export-card button{
    border: none;

    padding: 12px 24px;

    border-radius: 14px;

    background:
    linear-gradient(
        135deg,
        #ff9a3d,
        #ff7a00
    );

    color: white;

    font-weight: 600;

    cursor: pointer;
}

canvas{
    max-height: 320px !important;
}

</style>