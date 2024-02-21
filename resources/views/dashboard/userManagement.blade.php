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
                    <button type="button" class="btn btn-primary" onclick="addMember()">추가</button>
                    <button type="button" class="btn btn-danger" onclick="deleteMember()">삭제</button>
                </div>
                <table class="table table-borderd table-striped tableHeaderFixed">
                    <thead>
                        <tr align="center">
                            <th style="vertical-align: middle;">
                                <input type="checkbox" id="all-checker-member-list"/><label for="all-checker-member-list"></label>
                            </th>
                            <th>ID</th>
                            <th>이름</th>
                            <th>전화번호</th>
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
                <form>
                    <table class="table table-bordered">
                        <tr align="center">
                            <td class="title">이름</td>
                            <td style="width:400px">
                                <input type="text" class="form-control" id="add-member-name" value="" placeholder="이름" />
                            </td>
                            <td class="title">전화번호</td>
                            <td style="width:400px">
                                <input type="text" class="form-control" id="add-member-mobile-phone" value="" placeholder="전화번호" />
                            </td>
                        </tr>                        
                    </table>
                </form>
                    <div class="text-center"> 
                        <button type="button" class="btn btn-primary">추가</button>
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
                <form>
                    <table class="table table-bordered">
                        <tr align="center">
                            <td class="title">이름</td>
                            <td style="width:400px">
                                <input type="text" class="form-control" id="edit-member-name" value="11" placeholder="이름" />
                            </td>
                            <td class="title">전화번호</td>
                            <td style="width:400px">
                                <input type="text" class="form-control" id="edit-member-mobile-phone" value="22" placeholder="전화번호" />
                            </td>
                        </tr>                        
                    </table>
                </form>
                    <div class="text-center"> 
                        <button type="button" class="btn btn-primary">수정</button>
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
                html += `   <td><input type="checkbox" name="member-list-items" value="${item.id_string}"><label for="allChecker"></label></td>`;
                html += `   <td>${item.id_string}</td>`;
                html += `   <td>${item.name}</td>`;                
                html += `   <td>${formatPhoneNumber(item.mobile_phone)}</td>`;
                html += `   <td>${item.created_at}</td>`;
                html += `   <td><button type="button" class="btn btn-primary mt-2" onclick="editMember('${item.id_string}', '${item.name}', '${item.mobile_phone}')">수정</button></td>;`
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

function addMember() {
    $("#member-list").hide();
    $("#add-member").show();
}

function editMember(id_string, name, mobile_phone) {
    // $("#add-list").hide();
    $("#edit-member").show();
    
    $("#edit-member-name").val(name);
    $("#edit-member-mobile-phone").val(mobile_phone);
}

function deleteMember(id_string, name, mobile_phone) {
    $("input[name='member-list-items']").each(function(index, item){
        if ($(item).prop("checked")) {
            const idString = $(item).val();
            console.log(idString);   
        }
    });
}
</script>

@endsection