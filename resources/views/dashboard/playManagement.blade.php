@extends('layouts.app')

@section('title', '메인 대시보드')

@section('content')

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
                            <th>총 사용 시간</th>
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
                            <th>사용 시간</th> 
                            <th>시작 시간</th>
                            <th>종료 시간</th>
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
            <div class="form-group">
                <label> Name: </label>
                <input type="text" class="form-control" placeholder="Enter Name">
            </div>
            <div class="form-group">
                <label> Email: </label>
                <input type="email" class="form-control" placeholder="Enter Email Id">
            </div>
            <div class="form-group">
                <label> Contact Number: </label>
                <input type="text" class="form-control" placeholder="Enter contact number">
            </div>           
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary">수정</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">종료</button>            
        </div>
        </div>
    </div>
</div>

<script>

$(document).ready( function() {    
    var menu = "{{$menu}}";

    selectMenu(menu);

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
    $.ajax({
        url: '/api/playList',
        type: 'GET',
        dataType: 'json',        
        success: function(data) {            
            var html = '';            

            $("#play-list").find("tbody").children().remove();

            for (let item of data) {                
                html += `<tr align="center" style="vertical-align: middle;" class="tr-hover-class" id="tr_${item.ids}_${item.seq_no}">`;
                html += `   <td width="7%">${item.ids}</td>`;
                html += `   <td>${item.name}</td>`;                
                html += `   <td width="8%">${(item.sex == 'M') ? '남성' : '여성'}</td>`;                
                html += `   <td>${reformatBirthDate(item.birth_date)}</td>`;
                html += `   <td>${item.seq_no}</td>`;
                html += `   <td>${item.start_date}</td>`;
                html += `   <td>${item.end_date}</td>`;
                html += `   <td>${item.total_time} sec</td>`;                
                html += `   <td>${item.created_at}</td>`;
                html += `   <td><button type="button" class="btn btn-primary mt-2" onclick="clickPlayDetail('${item.id}', '${item.ids}', '${item.name}', '${item.seq_no}')">자세히</button></td>;`
                html += `</tr>`;
            };

            $("#play-list").find("tbody").append(html);
        },
        error: function(r, s, e) {
            alert("처리 중 문제가 발생하였습니다");
            console.log(e);
        }
    });
}

function viewPlayDetail(id, ids, name, play_seq_no) {
    $.ajax({
        url: '/api/playDetail',
        type: 'GET',
        dataType: 'json',  
        data: {
            "id": id,
            "play_seq_no": play_seq_no
        },      
        success: function(data) {            
            var html = '';            

            $("#play-detail").find("tbody").children().remove();

            for (let item of data) {                
                html += `<tr align="center" style="vertical-align: middle;" class="tr-hover-class">`;                
                html += `   <td width="7%">${ids}</td>`;
                html += `   <td>${name}</td>`;
                html += `   <td>${play_seq_no}</td>`;
                html += `   <td>${item.ground}</td>`;
                html += `   <td>${item.step}</td>`;
                html += `   <td>${item.actual_play_time} sec</td>`;
                html += `   <td>${item.start_date}</td>`;
                html += `   <td>${item.end_date}</td>`;
                html += `   <td>${item.false_count}</td>`; 
                // html += `   <td><button type="button" class="btn btn-danger mt-2" onclick="clickEditPlayDetail('${item.id}', '${item.ids}', '${item.name}', '${item.seq_no}')">수정1</button></td>;`        
                html += `   <td><button type="button" class="btn btn-danger mt-2" data-toggle="modal" data-target="#editPlayDetailModal">수정</button></td>;`        
                html += `</tr>`;
            };

            $("#play-detail").find("tbody").append(html);
        },
        error: function(r, s, e) {
            alert("처리 중 문제가 발생하였습니다");
            console.log(e);
        }
    });
}


function clickPlayDetail(id, ids, name, play_seq_no) {    
    $("#play-detail").show();    

    //$(`#tr_${ids}_${play_seq_no}`).css('background', 'lightgrey !important');

    $(`#tr_${ids}_${play_seq_no}`).css('background', 'lightgrey !important');

    viewPlayDetail(ids, ids, name, play_seq_no);
}

// $("#all-checker-member-list").on("change", function(e) {
//     const is_checked = e.target.checked;
//     $("input[name='member-list-items']").prop("checked", is_checked);
// });

// function clickAddMember() {
//     if ($("#save-member").css("display") !== "none") { 
//         alert("수정창을 닫고 입력해주세요.");        
//         return;
//     }    
    
//     $("#save-member-title").text('사용자 추가');
//     $("#save-member-mode").val(SAVE_MODE_ADD);

//     $("#member-id").val('0');
//     $("#member-ids").val('000');
    
//     $("#member-name").val('');
//     $("#member-mobile-phone").val('');
//     $("#member-birth-date").val('');    

//     $("#save-member").show(); 
// }

// function clickEditMember(id, ids, name, mobilePhone, birthDate, sex) {
//     if ($("#save-member-mode").val() === SAVE_MODE_ADD &&
//         $("#save-member").css("display") !== "none") { 
//         alert("추가창을 닫고 입력해주세요.");        
//         return;
//     }
    
//     $("#save-member-title").text('사용자 수정');
//     $("#save-member-mode").val(SAVE_MODE_EDIT);    
    
//     $("#member-id").val(id);
//     $("#member-ids").val(ids);
    
//     $("#member-name").val(name);
//     $("#member-mobile-phone").val(mobilePhone);
//     $("#member-birth-date").val(birthDate);
    
//     if (sex.toUpperCase() === "M") {
//         $('#member-male').prop('checked', true) 
//         $('#member-female').prop('checked', false) 
//     } else {
//         $('#member-male').prop('checked', false) 
//         $('#member-female').prop('checked', true) 
//     }

//     $("#save-member").show();    
// }

// function clickDeleteMember() {
//     var deleteList = [];
//     $("input[name='member-list-items']").each(function(index, item){
//         if ($(item).prop("checked")) {
//             const idString = $(item).val();
//             console.log(idString);   

//             deleteList.push(idString);
//         }
//     });

//     if (deleteList.length === 0) {
//         alert("삭제할 사용자를 선택해주세요.");
//         return;
//     }

//     console.log(deleteList);

//     callAPI({
//         method: 'POST',
//         url: "/api/deleteMember",
//         data: {
//             "idList": deleteList
//         }
//     }).then(function (response) {
//         alert(`삭제 되었습니다.`);
//     }).catch(function (error) {
//         console.log(error);
//         alert(`삭제에 실패하였습니다.`)
//     }).finally(function () {
//         viewMemberList();        
//     })
// }

// function validateMemberData() {
//     var name = $.trim($("#member-name").val());
//     if (name === "") {
//         alert("이름을 입력해주세요.");
//         $("#member-name").focus();
//         return false;
//     }

//     var mobilePhone = $.trim($("#member-mobile-phone").val());
//     if (mobilePhone === "") {
//         alert("휴대폰번호을 입력해주세요.");
//         $("#member-mobile-phone").focus();
//         return false;
//     }

//     if (!isValidPhoneNumber(mobilePhone)) {
//         alert("지정한 형식의 휴대폰번호을 입력해주세요.('-' 제외)");
//         $("#member-mobile-phone").focus();
//         return false;
//     }

//     var birthDate = $.trim($("#member-birth-date").val());
//     if (birthDate === "") {
//         alert("생년월일을 입력해주세요.(YYYYMMDD 형식)");
//         $("#member-birth-date").focus();
//         return false;
//     }

//     if (!isValidDateOfBirth(birthDate)) {
//         alert("지정한 형식의 생년월일을 입력해주세요.(YYYYMMDD 형식)");
//         $("#member-birth-date").focus();
//         return false;
//     }

//     var gender = $('input[name="gender"]:checked').val();
//     if (!gender) {
//         alert("성별을 선택해주세요.");        
//         return false;
//     }

//     return true;
// }

// function clickSaveMember() {
//     if (!validateMemberData()) {
//         return;
//     }

//     var id = $.trim($("#member-id").val());
//     var ids = $.trim($("#member-ids").val());

//     var name = $.trim($("#member-name").val());
//     var email = "test@test.com";
//     var mobilePhone = $.trim($("#member-mobile-phone").val());
//     var birthDate = $.trim($("#member-birth-date").val());
//     var gender = $('input[name="gender"]:checked').val();

//     var url = ($("#save-member-mode").val() == SAVE_MODE_ADD) ? "/api/addMember" : "/api/editMember";
//     var title = ($("#save-member-mode").val() == SAVE_MODE_ADD) ? "추가" : "수정";
    
//     callAPI({
//         method: 'POST',
//         url: url,
//         data: {
//             "id": id,
//             "ids": ids,
//             "name": name,
//             "email": email,
//             "sex": gender,
//             "birthDate": birthDate,
//             "mobilePhone": mobilePhone,                                
//         }
//     }).then(function (response) {
//         alert(`${title} 되었습니다.`);
//     }).catch(function (error) {
//         console.log(error);
//         alert(`${title}에 실패하였습니다.`)
//     }).finally(function () {
//         viewMemberList();

//         clickCloseSaveMember();
//     })
// }

// function clickCloseSaveMember() {
//     $("#save-member").hide();
// }

</script>

@endsection