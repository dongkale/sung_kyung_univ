@extends('layouts.app')

@section('title', '메인 대시보드')

@section('content')

<style>
.tableHeaderFixed tbody {
    max-height: 400px;
}
</style>

<div class="row" id="play-list">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="font-size:14px">
                <div style="font-size:20px">사용 목록</div>
            </div>
            <div class="card-body">
                {{-- <div class="text-right float-right mb-2">
                    <button type="button" class="btn btn-primary" onclick="clickAddMember()">추가</button>
                    <button type="button" class="btn btn-danger" onclick="clickDeleteMember()">삭제</button>
                </div> --}}
                <table class="table table-borderd table-striped tableHeaderFixed">
                    <thead>
                        <tr align="center">
                            <th width="7%">ID</th>
                            <th>이름</th>
                            <th width="8%">성별</th>
                            <th>생년월일</th>
                            <th>사용 번호</th>
                            <th>시작 시간</th>
                            <th>종료 시간</th>
                            <th>총 사용 시간(분)</th>
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

{{-- 상세창  --}}
<div class="row" style="display:none" id="play-detail">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="font-size:14px">
                <div style="font-size:20px" id="play-detail-title">상세 정보</div>
            </div>
            <div class="card-body">
                <table class="table table-borderd table-striped tableHeaderFixed">
                    <thead>
                        <tr align="center">
                            <th width="7%">ID</th>
                            <th>이름</th>
                            <th>사용 번호</th>
                            <th>장소</th>
                            <th>순서</th>
                            <th>사용 시간(초)</th>
                            {{-- <th>시작 시간</th>
                            <th>종료 시간</th> --}}
                            <th>실패 횟수</th>
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

<div class="modal fade" id="editPlayDetailModal" tabindex="-1" role="dialog" aria-labelledby="editPlayDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editPlayDetailModalLabel">상세 정보 수정</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="play-id" value="" />
            <input type="hidden" id="member-id" value="" />
            <input type="hidden" id="member-name" value="" />
            <input type="hidden" id="play-seq-no" value="" />

            <input type="hidden" id="play-detail-id" value="" />

            <div class="form-group">
                <label> 장소 </label>
                <input type="text"  id="play-detail-ground" class="form-control" placeholder="장소">
            </div>
            <div class="form-group">
                <label> 순서 </label>
                <input type="number" id="play-detail-step" class="form-control" value="" min="1" max="100"/>
            </div>

            <div class="form-group" style="display: none">
                <label> 시작 시간 </label>
                <input type="datetime-local"
                       id="play-detail-start-date"
                       class="form-control"
                       value=""
                       onChange="onChangeStartDate(this)"/>
            </div>
            <div class="form-group" style="display: none">
                <label> 종료 시간 </label>
                <input type="datetime-local"
                       id="play-detail-end-date"
                       class="form-control"
                       value=""
                       onChange="onChangeEndDate(this)"/>
            </div>

            <div class="form-group">
                <label> 사용 시간(초) </label>
                <input type="number" id="play-detail-actual-time" class="form-control" value="" min="1" max="10000"/>
            </div>

            <div class="form-group">
                <label> 실패 횟수 </label>
                <input type="number" id="play-detail-false-count" class="form-control" value="" min="1" max="100"/>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onClick="clickSubmitPlayDetail()" >수정</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
        </div>
    </div>
</div>

<script>

$(document).ready( function() {
    viewPlayList();
} );


function reformatBirthDate(input) {
    // YYYYDDMM 형식의 문자열을 YYYY-DD-MM 형식으로 변경
    var year = input.substring(0, 4);
    var day = input.substring(4, 6);
    var month = input.substring(6, 8);
    return year + '-' + day + '-' + month;
}

function viewPlayList() {
    callAPI({
        method: 'GET',
        url: '/api/playList'
    }).then(function (response) {
        var html = '';

        if (response.result_code == 0) {
            $("#play-list").find("tbody").children().remove();

            var result_data = response.result_data;
            for (let item of result_data) {
                html += `<tr align="center" style="vertical-align: middle;" class="tr-hover-class" id="tr_${item.p_id}">`;
                html += `   <td width="7%">${item.m_ids}</td>`;
                html += `   <td>${item.m_name}</td>`;
                html += `   <td width="8%">${(item.m_sex == 'M') ? '남성' : '여성'}</td>`;
                html += `   <td>${reformatBirthDate(item.m_birth_date)}</td>`;
                html += `   <td>${item.p_seq_no}</td>`;
                html += `   <td>${item.p_start_date ? item.p_start_date : '-'}</td>`;
                html += `   <td>${item.p_end_date ? item.p_end_date : '-'}</td>`;
                html += `   <td>${Math.floor(item.p_total_time / 60)} 분</td>`;
                html += `   <td>${item.p_created_at}</td>`;
                html += `   <td><button type="button" class="btn btn-primary" onclick="clickPlayDetail('${item.p_id}', '${item.m_ids}', '${item.m_name}', '${item.p_seq_no}')">자세히</button></td>;`
                html += `</tr>`;
            };

            $("#play-list").find("tbody").append(html);
        } else {
            alert("처리 중 문제가 발생하였습니다");
        }
    }).catch(function (error) {
        alert("처리 중 문제가 발생하였습니다");
        console.log(error);
    }).finally(function () {
        ;
    })
}

function viewPlayDetail(playId, memberIds, memberName, playSeqNo) {
    callAPI({
        method: 'GET',
        url: '/api/playDetail',
        data: {
            "play_id": playId
        }
    }).then(function (response) {
        var html = '';

        if (response.result_code == 0) {
            $("#play-detail").find("tbody").children().remove();

            var result_data = response.result_data;
            for (let item of result_data) {
                html += `<tr align="center" style="vertical-align: middle;" class="tr-hover-class">`;
                html += `   <td width="7%">${memberIds}</td>`;
                html += `   <td>${memberName}</td>`;
                html += `   <td>${playSeqNo}</td>`;
                html += `   <td>${item.ground}</td>`;
                html += `   <td>${item.step}</td>`;
                html += `   <td>${item.actual_play_time > 0 ? item.actual_play_time + '초' : '-'} </td>`;
                // html += `   <td>${item.start_date ? item.start_date : '-'}</td>`;
                // html += `   <td>${item.end_date ? item.end_date : '-'}</td>`;
                html += `   <td>${item.false_count}</td>`;
                html += `   <td class="d-flex">`;
                html += `       <button type="button"`;
                html += `               class="btn btn-success"`;
                html += `               data-toggle="modal"`;
                html += `               data-target="#editPlayDetailModal"`;
                html += `               onClick="clickEditPlayDetail('${playId}', '${memberIds}', '${memberName}', '${playSeqNo}', '${item.id}', '${item.ground}', '${item.step}', '${item.start_date}', '${item.end_date}', '${item.actual_play_time}', '${item.false_count}')">수정</button>`;
                html += `       <button type="button"`;
                html += `               class="btn btn-danger ml-2"`;
                html += `               onClick="clickDeletelayDetail('${item.id}', '${playId}', '${memberIds}', '${memberName}', '${playSeqNo}')">삭제</button>`
                html += `   </td>;`;
                html += `</tr>`;
            };

            $("#play-detail").find("tbody").append(html);
        }
    }).catch(function (error) {
        alert("처리 중 문제가 발생하였습니다");
            console.log(error);
    }).finally(function () {
        ;
    })
}

function clickPlayDetail(playId, memberIds, memberName, playSeqNo) {
    $("#play-detail").show();

    //$(`#tr_${ids}_${play_seq_no}`).css('background', 'lightgrey !important');
    // $(`#tr_${ids}_${play_seq_no}`).css('background', 'lightgrey !important');

    viewPlayDetail(playId, memberIds, memberName, playSeqNo);
}

function clickEditPlayDetail(playId, memberIds, memberName, playSeqNo, playDetailId, playDetailGround, playDetailStep, playDetailStartDate, playDetailEndDate, playDetailActualTime, playDetailFalseCount) {
    $("#play-id").val(playId);
    $("#member-id").val(memberIds);
    $("#member-name").val(memberName);
    $("#play-seq-no").val(playSeqNo);

    $("#play-detail-id").val(playDetailId);

    $("#play-detail-ground").val(playDetailGround);
    $("#play-detail-step").val(playDetailStep);
    $("#play-detail-start-date").val(playDetailStartDate);
    $("#play-detail-end-date").val(playDetailEndDate);
    $("#play-detail-actual-time").val(playDetailActualTime);
    $("#play-detail-false-count").val(playDetailFalseCount);
}

function clickSubmitPlayDetail() {
    $('#editPlayDetailModal').trigger('click.dismiss.bs.modal')

    console.log("clickSubmitPlayDetail");

    var playId = $("#play-id").val();
    var memberIds = $("#member-id").val();
    var memberName = $("#member-name").val();
    var playSeqNo = $("#play-seq-no").val();

    var playDetailId = $("#play-detail-id").val();

    var playDetailGround = $("#play-detail-ground").val();
    var playDetailStep = $("#play-detail-step").val();
    var playDetailStartDate = $("#play-detail-start-date").val();
    var playDetailEndDate = $("#play-detail-end-date").val();
    var playDetailFalseCount = $("#play-detail-false-count").val();
    var playActualTime = $("#play-detail-actual-time").val();

    // var startDate = new Date(playDetailStartDate);
    // var endDate   = new Date(playDetailEndDate);
    // var actualPlayTime = (endDate.getTime() - startDate.getTime()) / 1000;
    // console.log(actualPlayTime);

    callAPI({
        method: 'POST',
        url: "/api/editPlayDetail",
        data: {
            "id": playDetailId,
            "ground": playDetailGround,
            "step": playDetailStep,
            "start_date": playDetailStartDate,
            "end_date": playDetailEndDate,
            "false_count": playDetailFalseCount,
            "actual_play_time" : playActualTime
        }
    }).then(function (response) {
        alert(`수정 되었습니다.`);
    }).catch(function (error) {
        console.log(error);
        alert(`수정에 실패하였습니다.`)
    }).finally(function () {
        viewPlayDetail(playId, memberIds, memberName, playSeqNo);
    })
}

function clickDeletelayDetail(playDetailId, playId, memberIds, memberName, playSeqNo) {
    console.log(`clickDelete: ${playDetailId}`);

    if( !confirm("정말로 삭제하시겠습니까?") ) {
        return;
    }

    callAPI({
        method: 'POST',
        url: "/api/deletePlayDetail",
        data: {
            "id": playDetailId
        }
    }).then(function (response) {
        alert(`삭제 되었습니다.`);
    }).catch(function (error) {
        console.log(error);
        alert(`삭제에 실패하였습니다.`)
    }).finally(function () {
        viewPlayDetail(playId, memberIds, memberName, playSeqNo);
    })
}

function onChangeStartDate(t) {

    return;
}

function onChangeEndDate(t) {

    return;
}

</script>

@endsection
