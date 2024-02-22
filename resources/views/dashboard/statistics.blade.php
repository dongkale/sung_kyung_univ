@extends('layouts.app')

@section('title', '메인 대시보드')

@section('content')

<style>
.tableHeaderFixed {
    width: 100%;
}
.tableHeaderFixed thead, tbody tr {
    display: table;
    width: 100%;
    table-layout: fixed;  
}

.tableHeaderFixed tbody tr td{
    vertical-align: middle;
}

.table tr td {
    align:center;
    vertical-align: middle;
}

.tableHeaderFixed tbody {
    display: block;
    overflow-y: auto;
    table-layout: fixed;  
}
.tableHeaderFixed tbody {
    max-height: 300px;
}
</style>

<!-- 대시보드 컨텐츠 -->
<div class="row">
    <div class="col-md-12">
        <div class="card">            
            <div id="apex_chart" ></div> 
        </div>
    </div>
</div>

<div class="row" id="member-list">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="font-size:14px">                
                <div style="font-size:20px">사용자</div>
            </div>            
            <div class="card-body">                
                <div class="text-right float-right mb-2">                     
                </div>
                <table class="table table-borderd table-striped tableHeaderFixed">
                    <thead>
                        <tr align="center">                            
                            <th>ID</th>
                            <th>이름</th>
                            <th>성별</th>
                            <th>휴대폰번호</th>
                            <th>생년월일</th>
                            <th>생성일</th>                            
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>                
            </div>
        </div>
</div>

{{-- <div class="row">
    <div class="col-md-2">
        <div class="card">
            <div>Some text here</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div>Some text here</div>
        </div>
    </div>
</div> --}}

{{-- <div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                카드 1
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                카드 2
            </div>
        </div>
    </div>
    <!-- 추가적인 대시보드 카드 -->
</div> --}}

{{-- <div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">Header</div>
            <div class="card-body">
                <h5 class="card-title">Primary card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-header">Header</div>
            <div class="card-body">
                <h5 class="card-title">Primary card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
    </div>
</div> --}}

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script type="text/javascript" src="{{asset('/js/util.js')}}"></script>

<script>

$(document).ready( function() {
    var menu = "{{$menu}}";

    selectMenu(menu);

    viewMemberList();

    __testDrawApexChart4(document.querySelector('#apex_chart'));
} );

function reformatBirthDate(input) {
    // YYYYDDMM 형식의 문자열을 YYYY-DD-MM 형식으로 변경
    var year = input.substring(0, 4);
    var day = input.substring(4, 6);
    var month = input.substring(6, 8);
    return year + '-' + day + '-' + month;
}

function viewMemberList() {
    $.ajax({
        url: '/api/memberList',
        type: 'GET',
        dataType: 'json',        
        success: function(data) {            
            var html = '';            

            $("#member-list").find("tbody").children().remove();

            for (let item of data) {                
                html += `<tr align="center" style="vertical-align: middle;">`;
                html += `   <td>${item.ids}</td>`;
                html += `   <td>${item.name}</td>`;                
                html += `   <td>${item.sex}</td>`;                
                html += `   <td>${formatPhoneNumber(item.mobile_phone)}</td>`;
                html += `   <td>${reformatBirthDate(item.birth_date)}</td>`;
                html += `   <td>${item.created_at}</td>`;
                html += `</tr>`;
            };

            $("#member-list").find("tbody").append(html);
        },
        error: function(r, s, e) {
            alert("처리 중 문제가 발생하였습니다");
            console.log(e);
        }
    });
}

function __testDrawApexChart4(draw_id) {
    var options = {
        series: [{
            name: "웹1 사용량",
            data: [450, 650, 400, 700, 600, 800, 700, 900, 850, 1000, 1200, 1400]
        },
        {
            name: "웹2 사용량",
            data: [350, 150, 100, 500, 100, 700, 500, 800, 450, 100, 120, 140]
        }],
        chart: {
            type: 'line',
            height: 350,
            zoom: {
                enabled: false
            },            
        },
        dataLabels: {
            enabled: true,
            formatter: function (val, opts) {
                return val;
            },
            style: {
                fontSize: '8px',
                fontFamily: 'Helvetica, Arial, sans-serif',
                fontWeight: 'bold',
                colors: undefined
            },
            background: {
                enabled: true,
                foreColor: '#fff',
            }
        },
        stroke: {
            width: [3, 3],
            // curve: 'stepline',
            //dashArray: [3, 3]
        },
        grid: {
            borderColor: '#e7e7e7',
            row: {
                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.5
            },
            // position: 'front',
            // borderColor: '#111',
            // strokeDashArray: 1,
        },
        // legend: {
        //   tooltipHoverFormatter: function(val, opts) {
        //     return val + ' - <strong>' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + '</strong>'
        //   }
        // },
        // grid: {
        //   borderColor: '#e7e7e7',
        //   row: {
        //     colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
        //     opacity: 0.5
        //   },
        // },
        markers: {
            size: 1,
        },
        title: {
            text: '월별 웹 사용량',
            align: 'left'
        },
        xaxis: {
            categories: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            // lines: {
            //     show: true,
            // }
            // events: {
            //     click: function (e) { console.log(e); }
            // }
        },
        yaxis: {
            title: {
                text: '방문자 수'
            },
            // lines: {
            //     show: true,
            // }
        },
        // active: {
        //     allowMultipleDataPointsSelection: true,
        // },
        // events:{
        //     dataPointSelection: function(event, chartContext, config) {
        //         console.log(event);
        //     }
        // }
    };

    var chart = new ApexCharts(draw_id, options);
    chart.render();
}
</script>

@endsection