@extends('layouts.app')

@section('title', '메인 대시보드')

@section('content')

<style>
.tableHeaderFixed tbody {
    max-height: 400px;
}
</style>

<div class="row" id="member-list">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="font-size:14px">                
                <div style="font-size:20px">사용자</div>
            </div>            
            <div class="card-body">                
                <div class="text-right float-right mb-2"> 
                    <button type="button" class="btn btn-primary" onclick="clickAddMember()">추가</button>
                    <button type="button" class="btn btn-danger" onclick="clickDeleteMember()">삭제</button>
                </div>
                <table class="table table-borderd table-striped tableHeaderFixed">                    
                    {{-- <colgroup>                        
                        <col width="10px">
                        <col width="10px">
                        <col width="100px">
                        <col width="100px">
                        <col width="100px">
                        <col width="100px">
                        <col width="100px">
                        <col width="100px">
                    </colgroup> --}}
                    <thead>
                        <tr align="center">
                            <th align="center" width="8%" style="vertical-align: middle;">
                                <input type="checkbox" id="all-checker-member-list"/><label for="all-checker-member-list"></label>
                            </th>
                            <th width="10%">ID</th>
                            <th>이름</th>
                            <th width="8%">성별</th> 
                            <th width="12%">생년월일</th>
                            <th width="10%">나이</th>
                            <th width="15%">휴대폰번호</th>
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

    {{-- <div class="col-md-2">
        <div class="card">
            <h2>사용자 추가</h2>
            <form>
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
                
                <div class="text-center"> 
                    <button type="button" class="btn btn-primary">추가</button>                    
                </div> 
            </form>
        </div>
    </div>        --}}
</div>


{{-- <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="font-size:14px">                
                <div style="font-size:20px">사용자 추가</div>
            </div>            
            <div class="card-body">                
                <form>
                    <div class="form-group">
                        <label> 이름: </label>
                        <input type="text" class="form-control" placeholder="Enter Name" style="width:300px">
                    </div>
                    <div class="form-group">
                        <label> 전화번호: </label>
                        <input type="email" class="form-control" placeholder="Enter Email Id" style="width:300px">
                    </div>                    
                    <div class="text-center"> 
                        <button type="button" class="btn btn-primary">추가</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}

{{-- <div class="row" style="display:none" id="add-member">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="font-size:14px">                
                <div style="font-size:20px">사용자 추가</div>
            </div>            
            <div class="card-body">                
                <table class="table table-bordered">
                    <tr>
                        <td class="title" align="center">이름</td>
                        <td style="width:400px">
                            <input type="text" class="form-control" id="add-member-name" value="" placeholder="이름" />                                
                        </td>
                        <td class="title" align="center">휴대폰번호</td>
                        <td style="width:400px">
                            <input type="text" class="form-control" id="add-member-mobile-phone" value="" placeholder="'-' 빼고 입력" />
                        </td>                            
                    </tr>
                    <tr>
                        <td class="title" align="center">생년월일(YYYYMMDD)</td>
                        <td style="width:400px">
                            <input type="text" class="form-control" id="add-member-birth-date" value="" placeholder="생년월일(YYYYMMDD)" /> 
                        </td>
                        <td class="title" align="center">성별</td>
                        <td style="width:400px">
                            <input type="radio" id="add-member-male" name="gender" value="M">
                            <label for="add-member-male">남성</label>
                            <input type="radio" id="add-member-female" name="gender" value="F">
                            <label for="add-member-female">여성</label>
                        </td>
                    </tr>          
                </table>
                <div class="text-center"> 
                    <button type="button" class="btn btn-primary" onclick="clickSubmitAddMember()">추가</button>
                    <button type="button" class="btn btn-secondary" onclick="clickCloseAddMember()">닫기</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" style="display:none" id="edit-member">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="font-size:14px">                
                <div style="font-size:20px">사용자 수정</div>
            </div>            
            <div class="card-body">                
                <table class="table table-bordered">
                    <tr>
                        <td class="title" align="center">이름</td>
                        <td style="width:400px">
                            <input type="text" class="form-control" id="edit-member-name" value="" placeholder="이름" />                                
                        </td>
                        <td class="title" align="center">휴대폰번호</td>
                        <td style="width:400px">
                            <input type="text" class="form-control" id="edit-member-mobile-phone" value="" placeholder="'-' 빼고 입력" />
                        </td>                            
                    </tr>
                    <tr>
                        <td class="title" align="center">생년월일(YYYYMMDD)</td>
                        <td style="width:400px">
                            <input type="text" class="form-control" id="edit-member-birth-date" value="" placeholder="생년월일(YYYYMMDD)" /> 
                        </td>
                        <td class="title" align="center">성별</td>
                        <td style="width:400px">
                            <input type="radio" id="edit-member-male" name="gender" value="M">
                            <label for="edit-member-male">남성</label>
                            <input type="radio" id="edit-member-female" name="gender" value="F">
                            <label for="edit-member-female">여성</label>
                        </td>
                    </tr>          
                </table>

                <div class="text-center"> 
                    <button type="button" class="btn btn-primary" onclick="clickSubmitEditMember()">수정</button>
                    <button type="button" class="btn btn-secondary" onclick="clickCloseEditMember()">닫기</button>
                </div>
            </div>
        </div>
    </div>
</div> --}}

{{-- 추가/수정창  --}}
<div class="row" style="display:none" id="save-member">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="font-size:14px">
                <div style="font-size:20px" id="save-member-title"></div>
                <input type="hidden" id="save-member-mode" value="add" />

                <input type="hidden" id="member-id" value="0" />
                {{-- <input type="hidden" id="member-ids" value="000" /> --}}
            </div>            
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <td class="title" align="center">ID</td>
                        <td style="width:400px">
                            <input type="text" class="form-control" id="member-ids" value="" placeholder="아이디" disabled/>
                        </td>
                        <td class="title" align="center">이름</td>
                        <td style="width:400px">
                            <input type="text" class="form-control" id="member-name" value="" placeholder="이름" />                                
                        </td>
                    </tr>
                    <tr>
                        <td class="title" align="center">성별</td>
                        <td style="width:400px">
                            <input type="radio" id="member-male" name="gender" value="M">
                            <label for="member-male">남성</label>
                            <input type="radio" id="member-female" name="gender" value="F">
                            <label for="member-female">여성</label>
                        </td>
                        <td class="title" align="center">생년월일(YYYYMMDD)</td>
                        <td style="width:400px">
                            <input type="text" class="form-control" id="member-birth-date" value="" placeholder="생년월일(YYYYMMDD)" /> 
                        </td>
                    </tr>
                    <tr>
                        <td class="title" align="center">휴대폰번호</td>
                        <td style="width:400px">
                            <input type="text" class="form-control" id="member-mobile-phone" value="" placeholder="'-' 빼고 입력" />
                        </td>
                        <td class="title" align="center">기타</td>
                        <td style="width:400px">
                            <input type="text" class="form-control" id="member-etc" value="" placeholder="" />
                        </td>
                    </tr>          
                </table>                
                <div class="text-center"> 
                    <button type="button" class="btn btn-primary" onclick="clickSaveMember()">저장</button>
                    <button type="button" class="btn btn-secondary" onclick="clickCloseSaveMember()">닫기</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- member Added modal-->
{{-- <div class="modal fade" id="memberAddModal" tabindex="-1" role="dialog" aria-labelledby="memberAddModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="memberAddModalLabel">Modal title</h5>
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
            <button type="button" class="btn btn-primary">추가</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">종료</button>            
        </div>
        </div>
    </div>
</div> --}}

<script>

const SAVE_MODE_ADD = "add";
const SAVE_MODE_EDIT = "edit";

$(document).ready( function() {        
    viewMemberList();
} );

function reformatBirthDate(input) {
    // YYYYDDMM 형식의 문자열을 YYYY-DD-MM 형식으로 변경
    var year = input.substring(0, 4);
    var day = input.substring(4, 6);
    var month = input.substring(6, 8);
    return year + '-' + day + '-' + month;
}

function viewMemberList() {
    callAPI({
        method: 'GET',
        url: '/api/memberList'
    }).then(function (response) {        
        var html = '';            

        if (response.result_code == 0) {
            $("#member-list").find("tbody").children().remove();

            var result_data = response.result_data; 
            for (let item of result_data) {  
                html += `<tr align="center" style="vertical-align: middle;" class="tr-hover-class">`;
                html += `   <td width="8%"><input type="checkbox" name="member-list-items" value="${item.id}"><label for="allChecker"></label></td>`;
                html += `   <td width="10%">${item.ids}</td>`;
                html += `   <td>${item.name}</td>`;                
                html += `   <td width="8%">${(item.sex == 'M') ? '남성' : '여성'}</td>`;
                html += `   <td width="12%">${reformatBirthDate(item.birth_date)}</td>`;
                html += `   <td width="10%">${item.age}</td>`;
                html += `   <td width="15%">${formatPhoneNumber(item.mobile_phone)}</td>`;                
                html += `   <td>${item.created_at}</td>`;
                html += `   <td><button type="button" class="btn btn-success" onclick="clickEditMember('${item.id}', '${item.ids}', '${item.name}', '${item.mobile_phone}', '${item.birth_date}', '${item.sex}')">수정</button></td>;`
                html += `</tr>`;
            };

            $("#member-list").find("tbody").append(html);
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

// $('#myModal').on('shown.bs.modal', function () {
//     $('#myInput').trigger('focus')
// })

$("#all-checker-member-list").on("change", function(e) {
    const is_checked = e.target.checked;
    $("input[name='member-list-items']").prop("checked", is_checked);
});

function clickAddMember() {
    if ($("#save-member").css("display") !== "none") { 
        alert("수정창을 닫고 입력해주세요.");        
        return;
    }    
    
    $("#save-member-title").text('사용자 추가');
    $("#save-member-mode").val(SAVE_MODE_ADD);

    $("#member-id").val('0');
    $("#member-ids").val('000');
    
    $("#member-name").val('');
    $("#member-mobile-phone").val('');
    $("#member-birth-date").val('');    

    $("#save-member").show(); 
}

function clickEditMember(id, ids, name, mobilePhone, birthDate, sex) {
    if ($("#save-member-mode").val() === SAVE_MODE_ADD &&
        $("#save-member").css("display") !== "none") { 
        alert("추가창을 닫고 입력해주세요.");        
        return;
    }
    
    $("#save-member-title").text('사용자 수정');
    $("#save-member-mode").val(SAVE_MODE_EDIT);    
    
    $("#member-id").val(id);
    $("#member-ids").val(ids);
    
    $("#member-name").val(name);
    $("#member-mobile-phone").val(mobilePhone);
    $("#member-birth-date").val(birthDate);
    
    if (sex.toUpperCase() === "M") {
        $('#member-male').prop('checked', true) 
        $('#member-female').prop('checked', false) 
    } else {
        $('#member-male').prop('checked', false) 
        $('#member-female').prop('checked', true) 
    }

    $("#save-member").show();    
}

function clickDeleteMember() {
    var deleteList = [];
    $("input[name='member-list-items']").each(function(index, item){
        if ($(item).prop("checked")) {
            const idString = $(item).val();
            console.log(idString);   

            deleteList.push(idString);
        }
    });

    if (deleteList.length === 0) {
        alert("삭제할 사용자를 선택해주세요.");
        return;
    }

    console.log(deleteList);

    if (!confirm("정말로 삭제하시겠습니까?")) {
        return;
    }

    callAPI({
        method: 'POST',
        url: "/api/deleteMember",
        data: {
            "id_list": deleteList
        }
    }).then(function (response) {
        alert(`삭제 되었습니다.`);
    }).catch(function (error) {
        console.log(error);
        alert(`삭제에 실패하였습니다.`)
    }).finally(function () {
        viewMemberList();        
    })
}

function validateMemberData() {
    var name = $.trim($("#member-name").val());
    if (name === "") {
        alert("이름을 입력해주세요.");
        $("#member-name").focus();
        return false;
    }

    var mobilePhone = $.trim($("#member-mobile-phone").val());
    if (mobilePhone === "") {
        alert("휴대폰번호을 입력해주세요.");
        $("#member-mobile-phone").focus();
        return false;
    }

    if (!isValidPhoneNumber(mobilePhone)) {
        alert("지정한 형식의 휴대폰번호을 입력해주세요.('-' 제외)");
        $("#member-mobile-phone").focus();
        return false;
    }

    var birthDate = $.trim($("#member-birth-date").val());
    if (birthDate === "") {
        alert("생년월일을 입력해주세요.(YYYYMMDD 형식)");
        $("#member-birth-date").focus();
        return false;
    }

    if (!isValidDateOfBirth(birthDate)) {
        alert("지정한 형식의 생년월일을 입력해주세요.(YYYYMMDD 형식)");
        $("#member-birth-date").focus();
        return false;
    }

    var gender = $('input[name="gender"]:checked').val();
    if (!gender) {
        alert("성별을 선택해주세요.");        
        return false;
    }

    return true;
}

function clickSaveMember() {
    if (!validateMemberData()) {
        return;
    }

    var id = $.trim($("#member-id").val());
    var ids = $.trim($("#member-ids").val());

    var name = $.trim($("#member-name").val());
    var email = "test@test.com";
    var mobilePhone = $.trim($("#member-mobile-phone").val());
    var birthDate = $.trim($("#member-birth-date").val());
    var gender = $('input[name="gender"]:checked').val();

    var url = ($("#save-member-mode").val() == SAVE_MODE_ADD) ? "/api/addMember" : "/api/editMember";
    var title = ($("#save-member-mode").val() == SAVE_MODE_ADD) ? "추가" : "수정";
    
    callAPI({
        method: 'POST',
        url: url,
        data: {
            "id": id,
            "ids": ids,
            "name": name,
            "email": email,
            "sex": gender,
            "birth_date": birthDate,
            "mobile_phone": mobilePhone,                                
        }
    }).then(function (response) {
        alert(`${title} 되었습니다.`);
    }).catch(function (error) {
        console.log(error);
        alert(`${title}에 실패하였습니다.`)
    }).finally(function () {
        viewMemberList();

        clickCloseSaveMember();
    })
}

function clickCloseSaveMember() {
    $("#save-member").hide();
}

</script>

@endsection