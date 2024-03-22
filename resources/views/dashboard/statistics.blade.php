@extends('layouts.app')

@section('title', '메인 대시보드')

@section('content')

<style>
.tableHeaderFixed tbody {
    max-height: 400px;
}
</style>

<!-- 대시보드 컨텐츠 -->
<div class="row">
    <div class="col-md-12">
        <div class="card">   
            <div class="card-header" style="font-size:14px">                
                <div style="font-size:20px">사용자 별 사용 횟수</div>
            </div>     
            <div class="card-body">                
                <div id="play-count-by-member" ></div>                 
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card">   
            <div class="card-header" style="font-size:14px">                
                <div style="font-size:20px;">장소별 분포</div>
            </div>     
            <div class="card-body">                
                <div id="play-ground-count" ></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">   
            <div class="card-header" style="font-size:14px">                
                <div style="font-size:20px;">나이별 분포</div>
            </div>     
            <div class="card-body">                
                <div id="member-age-count"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">   
            <div class="card-header" style="font-size:14px">                
                <div style="font-size:20px">장소별 성공/실패 횟수</div>
            </div>     
            <div class="card-body">                
                <div id="ground-success-false-count"></div>
            </div>
        </div>
    </div>
</div>

<div class="row" style="display:none">
    <div class="col-md-4">
        <div class="card">   
            <div class="card-header" style="font-size:14px">                
                <div style="font-size:20px;">장소별 분포</div>
            </div>     
            <div class="card-body">                
                <div id="member-play-ground-count" ></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">   
            <div class="card-header" style="font-size:14px">                
                <div style="font-size:20px;">------</div>
            </div>     
            <div class="card-body">                
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">   
            <div class="card-header" style="font-size:14px">                
                <div style="font-size:20px">장소별 성공/실패 횟수</div>
            </div>     
            <div class="card-body">                
                <div id="member-ground-success-false-count"></div>
            </div>
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
                    {{-- <button type="button" class="btn btn-primary">Download<i class="bi bi-download"></i></button> --}}
                    {{-- <button class="btn-download rounded-sm" onClick="clickMemberListWithStatToExportProc()"><i class="fa fa-download"></i> Download</button> --}}
                    {{-- <button class="btn-download rounded-sm" onClick="clickMemberListWithStatToExportProc()"><img src="/images/icons8-ms-엑셀-32.png" style="width: 100%;height: 100%;overflow: hidden;"></button> --}}
                    {{-- <button class="btn-excel-download rounded-sm" onClick="clickMemberListWithStatToExportProc()"><img src="/images/icons8-ms-엑셀-48.png" style="width: 80%;height: 80%;overflow: hidden;"></button> --}}
                    <button class="btn-excel-download rounded-sm" onClick="clickMemberListWithStatToExportProc()"></button>
                </div>

                <table class="table table-borderd table-striped tableHeaderFixed">
                    <thead>
                        <tr align="center">    
                            <th width="8%">ID</th>
                            <th>이름</th>
                            <th width="8%">성별</th> 
                            <th>생년월일</th>
                            <th width="10%">나이</th>
                            <th>휴대폰번호</th>
                            <th>사용 횟수</th>
                            <th>사용 시간(분)</th>
                            <th>생성일</th>
                            <th>*</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>                
            </div>
        </div>
    </div>
</div>

<form id="memberListWithStatExportForm" method="POST" action="/api/memberListWithStatExport">
    @csrf
</form>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script type="text/javascript" src="{{mix('/js/util.js')}}"></script>

<script>
    
 var g_chartPlayGroundCount = null;
 var g_chartGroundSuccessFalseCount = null;

$(document).ready( function() {    
    viewMemberListWithStat();

    chartPlayCountByMember();  
    
    chartPlayGroundCount(document.querySelector('#play-ground-count'));

    chartMemberAgeCount(document.querySelector('#member-age-count'));

    // chartGroundFalseCount();    
    chartGroundSuccessFalseCount(document.querySelector('#ground-success-false-count'));
} );

function reformatBirthDate(input) {
    // YYYYDDMM 형식의 문자열을 YYYY-DD-MM 형식으로 변경
    var year = input.substring(0, 4);
    var day = input.substring(4, 6);
    var month = input.substring(6, 8);
    return year + '-' + day + '-' + month;
}

function viewMemberListWithStat() {   
    callAPI({
        method: 'GET',
        url: '/api/memberListWithStat'
    }).then(function (response) {        
        var html = '';            

        if (response.result_code == 0) {            
            $("#member-list").find("tbody").children().remove();

            var result_data = response.result_data; 
            for (let item of result_data) {  
                html += `<tr align="center" style="vertical-align: middle;">`;
                html += `   <td width="8%">${item.ids}</td>`;
                html += `   <td>${item.name}</td>`;
                html += `   <td width="8%">${(item.sex == 'M') ? '남성' : '여성'}</td>`;
                html += `   <td>${reformatBirthDate(item.birth_date)}</td>`;
                html += `   <td width="10%">${item.age}</td>`;
                html += `   <td>${formatPhoneNumber(item.mobile_phone)}</td>`;            
                html += `   <td>${item.play_count}</td>`;
                html += `   <td>${(item.play_total_time/60).toFixed(1)} 분</td>`;
                html += `   <td>${item.created_at}</td>`;
                html += `   <td><button type="button" class="btn btn-primary" onclick="clickMemberStatDetail('${item.id}', '${item.m_ids}', '${item.m_name}')">통계</button></td>;`
                html += `</tr>`;
            };

            $("#member-list").find("tbody").append(html);
        } else {
            console.log("처리 중 문제가 발생하였습니다");
        }    
    }).catch(function (error) {
        alert("처리 중 문제가 발생하였습니다");
        console.log(error);
    }).finally(function () {
        ;
    })
}

function clickMemberListWithStatToExportProc() {
    $("#memberListWithStatExportForm").submit();
}

// 사용자 별 사용 횟수(모든 유저)
async function chartPlayCountByMember() {
    var chart = null;

    await callAPI({
        method: 'GET',
        url: '/api/selectPlayCountByMember'
    }).then(function (response) {        
        var datas = [];
        var categories = [];

        if (response.result_code == 0) {            
            var result_data = response.result_data; 
            for (let item of result_data.play_count) {
                datas.push(item.count);
                categories.push(`${item.name}(${item.ids})`);
            }
            
            // drawPlayCountByMember(document.querySelector('#play-count-by-member'), datas, categories);
            chart = drawNormalBar(document.querySelector('#play-count-by-member'), "", "230px", [{name:'Play', data: datas}], categories);
        } else {
            console.log(`처리 중 문제가 발생하였습니다.(${response.result_code}, ${response.result_message})`);
        }
    }).catch(function (error) {
        alert("처리 중 문제가 발생하였습니다");
        console.log(error);
    }).finally(function () {
        ;
    })

    return chart;
}

// 장소별 분포
async function chartPlayGroundCount(drawId, memberId) {
    var chart = null;

    await callAPI({
        method: 'GET',
        url: '/api/selectPlayGroundCount',
        data : {
            member_id: memberId
        }
    }).then(function (response) {        
        var datas = [];
        var categories = [];

        if (response.result_code == 0) {
            var result_data = response.result_data; 
            for (let item of result_data.ground_count) {                  
                datas.push(item.count);
                categories.push(`${item.ground}`);
            }
            
            // drawPlayGroundCount(document.querySelector('#play-ground-count'), datas, categories);            
            chart = drawNormalDonut(drawId, "", "230px", datas, categories);
        } else {
            console.log(`처리 중 문제가 발생하였습니다.(${response.result_code}, ${response.result_message})`);
        }
    }).catch(function (error) {
        alert("처리 중 문제가 발생하였습니다");
        console.log(error);
    }).finally(function () {
        ;
    })    

    return chart;
}

// 나이별 분포
async function chartMemberAgeCount(drawId) {
    var chart = null;

    await callAPI({
        method: 'GET',
        url: '/api/selectMemberAgeCount'
    }).then(function (response) {        
        var datas = [];
        var categories = [];

        if (response.result_code == 0) {            
            var result_data = response.result_data; 
            for (let item of result_data.member_age_count) {                  
                datas.push(item.count);
                categories.push(`${item.age}세`);
            }
            
            // drawMemberAgeCount(document.querySelector('#member-age-count'), datas, categories);
            chart = drawNormalDonut(drawId, "", "230px", datas, categories);
        } else {
            console.log(`처리 중 문제가 발생하였습니다.(${response.result_code}, ${response.result_message})`);
        }
    }).catch(function (error) {
        alert("처리 중 문제가 발생하였습니다");
        console.log(error);
    }).finally(function () {
        ;
    })    

    return chart;
}

// 장소별 성공/실패 횟수
async function chartGroundSuccessFalseCount(drawId, memberId) {
    var chart = null;

    await callAPI({
        method: 'GET',
        url: '/api/selectGrounSuccessFalseCount',
        data : {
            member_id: memberId
        }
    }).then(function (response) {        
        var successDatas = [];
        var falseDatas = [];
        var categories = [];
        
        if (response.result_code == 0) {            
            var result_data = response.result_data; 
            for (let item of result_data.stat) {
                successDatas.push(item.success_count);
                falseDatas.push(item.false_count);
                categories.push(item.ground ? item.ground : 'FAIL');                
            }

            chart = drawNormalBar(drawId, "", "220px", [{name:'성공', data: successDatas}, {name:'실패', data: falseDatas}], categories);            
        } else {                        
            console.log(`처리 중 문제가 발생하였습니다.(${response.result_code}, ${response.result_message})`);
        }
    }).catch(function (error) {
        alert("처리 중 문제가 발생하였습니다");
        console.log(error);
    }).finally(function () {
        ;
    })

    return chart;
}

async function clickMemberStatDetail(memberId, memberIds, memberName) {    
    if (g_chartPlayGroundCount) {
        g_chartPlayGroundCount.destroy();
    }

    g_chartPlayGroundCount = await chartPlayGroundCount(document.querySelector('#member-play-ground-count'), memberId);

    // chartMemberAgeCount(document.querySelector('#member-age-count'));
    
    if (g_chartGroundSuccessFalseCount) {
        g_chartGroundSuccessFalseCount.destroy();
    }

    g_chartGroundSuccessFalseCount = await chartGroundSuccessFalseCount(document.querySelector('#member-ground-success-false-count'), memberId);
}

function drawNormalDonut(draw_id, title, height, datas, categories) {
    var options = {
        series: datas,
        labels: categories,
        dataLabels: {
            enabled: true,
            formatter(val, opts) {
                const name = opts.w.globals.labels[opts.seriesIndex];
                const data = opts.w.globals.series[opts.seriesIndex];

                // console.log(data);
                viewData = `${name}(${data})`;

                // return [name, data, val.toFixed(1) + '%']
                return [viewData, val.toFixed(1) + '%']
            }
        },
        title: {
            text: title,
            align: 'left'
        }, 
        chart: {          
            type: 'donut',
            width: '100%',
            height: height, // '230px',
            toolbar: {
                show: true
            }
        },     
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 400
                },
                legend: {
                    show: true,
                    position: 'bottom'
                }
            }
        }],        
    };

    var chart = new ApexCharts(draw_id, options);
    chart.render();

    return chart;
}

function drawNormalBar(draw_id, title, height, datas, categories) {
    var options = {
        series: datas,        
        chart: {
            type: 'bar',
            height: height
        },
        title: {
            text: title,
            align: 'left'
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {                        
            categories: categories
        },
        yaxis: {
            title: {
                text: '횟수'
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " 회"
                }
            }
        }
    };

    var chart = new ApexCharts(draw_id, options);
    chart.render();

    return chart;
}

/*
function drawPlayCountByMember(draw_id, datas, categories) {
    // var options = {
    //     series: [{
    //         name: 'Play',
    //         data: datas
    //     }],
    //     chart: {
    //         type: 'bar',
    //         height: 200
    //     },
    //     plotOptions: {
    //         bar: {
    //             horizontal: false,
    //             columnWidth: '55%',
    //             endingShape: 'rounded'
    //         },
    //     },
    //     dataLabels: {
    //         enabled: false
    //     },
    //     stroke: {
    //         show: true,
    //         width: 2,
    //         colors: ['transparent']
    //     },
    //     xaxis: {                        
    //         categories: categories
    //     },
    //     yaxis: {
    //         title: {
    //             text: '횟수'
    //         }
    //     },
    //     fill: {
    //         opacity: 1
    //     },
    //     tooltip: {
    //         y: {
    //             formatter: function (val) {
    //                 return val + " 회"
    //             }
    //         }
    //     }
    // };

    // var chart = new ApexCharts(draw_id, options);
    // chart.render();

    // var reMakeDatas = [];

    //for (let item of datas) {  

    //    reMakeDatas.push({name:'Play', data: item});};
    //}

    drawNormalBar(draw_id, "", 230, [{name:'Play', data: datas}], categories);
}
*/

/*
function drawPlayGroundCount(draw_id, datas, categories) {
    // var options = {
    //     series: datas,
    //     labels: categories,      
    //     dataLabels: {
    //         enabled: true,
    //         formatter(val, opts) {
    //             const name = opts.w.globals.labels[opts.seriesIndex]
    //             return [name, val.toFixed(1) + '%']
    //         }
    //     }, 
    //     chart: {            
    //         type: 'donut',
    //         width: '100%',
    //         height: '280px',
    //         // sparkline: {
    //         //     enabled: true
    //         // },
    //     },        
    //     responsive: [{
    //         breakpoint: 480,
    //         options: {
    //             chart: {
    //                 width: 400,                    
    //             },
    //             legend: {
    //                 show: false,
    //                 position: 'bottom'
    //             }
    //         }
    //     }],
    //     // legend: {
    //     //     position: 'right',
    //     //     offsetY: 0,
    //     //     height: 230,
    //     // }
    // };

    // var chart = new ApexCharts(draw_id, options);
    // chart.render();

    drawNormalDonut(draw_id, "", "230px", datas, categories);
}
*/

/*
function drawMemberAgeCount(draw_id, datas, categories) {
    // var options = {
    //     series: datas,
    //     labels: categories,      
    //     dataLabels: {
    //         formatter(val, opts) {
    //             const name = opts.w.globals.labels[opts.seriesIndex]
    //             return [name, val.toFixed(1) + '%']
    //         }
    //     },
    //     chart: {            
    //         width: '100%',
    //         type: 'pie'
    //     },     
    //     theme: {
    //         monochrome: {
    //             enabled: true
    //         }
    //     },   
    //     plotOptions: {
    //         pie: {
    //             dataLabels: {
    //             offset: -5
    //             }
    //         }
    //     },
    //     title: {
    //       text: ""
    //     },
    //     legend: {
    //       show: false
    //     }
    // };

    // var options = {
    //     series: datas,
    //     labels: categories,      
    //     dataLabels: {
    //         enabled: true,
    //         formatter(val, opts) {
    //             const name = opts.w.globals.labels[opts.seriesIndex]
    //             return [name, val.toFixed(1) + '%']
    //         }
    //     }, 
    //     chart: {            
    //         type: 'donut',
    //         width: '100%',
    //         height: '280px',
    //         // sparkline: {
    //         //     enabled: true
    //         // }
    //     },     
    //     responsive: [{
    //         breakpoint: 480,
    //         options: {
    //             chart: {
    //                 width: 400
    //             },
    //             legend: {
    //                 show: false,
    //                 position: 'bottom'
    //             }
    //         }
    //     }],        
    // };

    // var chart = new ApexCharts(draw_id, options);
    // chart.render();

    drawNormalDonut(draw_id, "", "230px", datas, categories);
}
*/

//////////////////////////////////////////////////////////////////////////////////////////////////////

// function chartGroundFalseCount() {
//     callAPI({
//         method: 'GET',
//         url: '/api/selectGrounFalseCount'
//     }).then(function (response) {        
//         var html = '';         
        
//         var datas = [];
//         var categorys = [];

//         if (response.result_code == 0) {            
//             var result_data = response.result_data; 
//             for (let item of result_data.ground_count) {                  
//                 datas.push(item.false_count);
//                 categorys.push(item.ground);
//             }
            
//             drawNormalBar(document.querySelector('#ground-false-count'), [{name:'Play', data: datas}], categorys);
//         } else {            
//             console.log("처리 중 문제가 발생하였습니다");
//         }
//     }).catch(function (error) {
//         alert("처리 중 문제가 발생하였습니다");
//         console.log(error);
//     }).finally(function () {
//         ;
//     })
// }


function playCountChart(draw_id) {
    var options = {
        series: [{
            name: 'Net Profit',
            data: [0, 6]
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {            
            // categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            categories: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월']
        },
        yaxis: {
            title: {
                text: '횟수'
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return "$ " + val + " thousands"
                }
            }
        }
    };

    var chart = new ApexCharts(draw_id, options);
    chart.render();
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