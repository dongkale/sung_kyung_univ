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

<div class="row" id="member-list">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="font-size:14px">                
                <div style="font-size:20px">사용자</div>
            </div>            
            <div class="card-body">                
                <div class="text-right float-right mb-2"> 
                    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#memberAddModal">추가</button> --}}
                    <button type="button" class="btn btn-primary" onclick="clickAddMember()">추가</button>
                    <button type="button" class="btn btn-danger" onclick="clickDeleteMember()">삭제</button>
                </div>
                <table class="table table-borderd table-striped tableHeaderFixed">
                    <thead>
                        <tr align="center">
                            <th style="vertical-align: middle;">
                                <input type="checkbox" id="all-checker-member-list"/><label for="all-checker-member-list"></label>
                            </th>
                            <th>ID</th>
                            <th>이름</th>
                            <th>성별</th>
                            <th>휴대폰번호</th>
                            <th>생년월일</th>
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

<div class="row" style="display:none" id="add-member">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="font-size:14px">                
                <div style="font-size:20px">사용자 추가</div>
            </div>            
            <div class="card-body">                
                {{-- <form id="form-add-member-name"> --}}
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
                {{-- </form> --}}
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

<script type="text/javascript" src="{{asset('/js/util.js')}}"></script>

<script>

$(document).ready( function() {    
    var menu = "{{$menu}}";

    selectMenu(menu);

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
    $.ajax({
        url: '/api/memberList',
        type: 'GET',
        dataType: 'json',        
        success: function(data) {            
            var html = '';            

            $("#member-list").find("tbody").children().remove();

            for (let item of data) {                
                html += `<tr align="center" style="vertical-align: middle;">`;
                html += `   <td><input type="checkbox" name="member-list-items" value="${item.id}"><label for="allChecker"></label></td>`;
                html += `   <td>${item.ids}</td>`;
                html += `   <td>${item.name}</td>`;                
                html += `   <td>${item.sex}</td>`;                
                html += `   <td>${formatPhoneNumber(item.mobile_phone)}</td>`;
                html += `   <td>${reformatBirthDate(item.birth_date)}</td>`;
                html += `   <td>${item.created_at}</td>`;
                html += `   <td><button type="button" class="btn btn-primary mt-2" onclick="clickEditMember('${item.id}', '${item.ids}', '${item.name}', '${item.mobile_phone}', '${item.birth_date}', '${item.sex}')">수정</button></td>;`
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

// $('#myModal').on('shown.bs.modal', function () {
//     $('#myInput').trigger('focus')
// })

$("#all-checker-member-list").on("change", function(e) {
    const is_checked = e.target.checked;
    $("input[name='member-list-items']").prop("checked", is_checked);
});

function clickAddMember() {
    // $("#member-list").hide();
    if ($('#edit-member').is(':visible')) {
        // $("#edit-member").hide();
        console.log(`edit-member`);   
    }

    $("#add-member").show();
}

function clickEditMember(id, ids, name, mobilePhone, birthDate, sex) {
    if ($('#add-member').is(':visible')) {
        // $("#edit-member").hide();
        console.log(`add-member`);   
    }
    
    $("#edit-member").show();
    
    $("#edit-member-name").val(name);
    $("#edit-member-mobile-phone").val(formatPhoneNumber(mobilePhone));
    $("#edit-member-birth-date").val(reformatBirthDate(birthDate));
    
    if (sex.toUpperCase() === "F") {
        $('#edit-member-male').prop('checked', true) 
        $('#edit-member-female').prop('checked', false) 
    } else {
        $('#edit-member-male').prop('checked', false) 
        $('#edit-member-female').prop('checked', true) 
    } 
}

function clickDeleteMember(id_string, name, mobile_phone) {
    $("input[name='member-list-items']").each(function(index, item){
        if ($(item).prop("checked")) {
            const idString = $(item).val();
            console.log(idString);   
        }
    });
}

function validateAddMember() {
    var name = $.trim($("#add-member-name").val());
    if (name === "") {
        alert("이름을 입력해주세요.");
        $("#add-member-name").focus();
        return false;
    }

    var mobilePhone = $.trim($("#add-member-mobile-phone").val());
    if (mobilePhone === "") {
        alert("휴대폰번호을 입력해주세요.");
        $("#add-member-mobile-phone").focus();
        return false;
    }

    if (!isValidPhoneNumber(mobilePhone)) {
        alert("지정한 형식의 휴대폰번호을 입력해주세요.('-' 제외)");
        $("#add-member-mobile-phone").focus();
        return false;
    }

    var birthDate = $.trim($("#add-member-birth-date").val());
    if (birthDate === "") {
        alert("생년월일을 입력해주세요.(YYYYMMDD 형식)");
        $("#add-member-birth-date").focus();
        return false;
    }

    if (!isValidDateOfBirth(birthDate)) {
        alert("지정한 형식의 생년월일을 입력해주세요.(YYYYMMDD 형식)");
        $("#add-member-birth-date").focus();
        return false;
    }

    var gender = $('input[name="gender"]:checked').val();
    if (!gender) {
        alert("성별을 선택해주세요.");        
        return false;
    }

    return true;
}

function clickSubmitAddMember() {
    if (!validateAddMember()) {
        return;
    }

    var name = $.trim($("#add-member-name").val());
    var email = "test@test.com";
    var mobilePhone = $.trim($("#add-member-mobile-phone").val());
    var birthDate = $.trim($("#add-member-birth-date").val());
    var gender = $('input[name="gender"]:checked').val();
    
    callAPI({
        method: 'POST',
        url: "/api/addMember",
        data: {
            "name": name,
            "email": email,
            "sex": gender,
            "birthDate": birthDate,
            "mobilePhone": mobilePhone,                                
        }
    }).then(function (response) {
        alert('추가되었습니다.');
    }).catch(function (error) {
        console.log(error);
        alert('추가에 실패하였습니다.')
    }).finally(function () {
        viewMemberList();
    })
}

function clickCloseAddMember() {
    $("#add-member").hide();
}

function clickCloseEditMember() {
    $("#edit-member").hide();
}
</script>

@endsection