@extends('layouts.app')

@section('title', '메인 대시보드')

@section('content')

<style>
.scroll {
    max-height: 100px;
    overflow-y: auto;
}
</style>

<div class="row">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header" style="font-size:14px">                
                <div>사용자</div>
            </div>
            <div class="card-body">
                <div class="text-right float-right mb-3"> 
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#memberAddModal">추가</button>
                    <button type="button" class="btn btn-danger">삭제</button>
                </div>             
                <table class="table table-borderd"  id="member-list">
                    <thead>
                        <tr align="center">
                            <th>ID</th>
                            <th>이름</th>
                            <th>전화번호</th>
                            <th>생성일</th>
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

<!-- member Added modal-->
<div class="modal fade" id="memberAddModal" tabindex="-1" role="dialog" aria-labelledby="memberAddModalLabel" aria-hidden="true">
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
</div>

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
                html += `<tr align="center">`;
                html += `   <td>${item.id_string}</td>`;
                html += `   <td>${item.name}</td>`;
                html += `   <td>${item.mobile_phone}</td>`;
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

// $('#myModal').on('shown.bs.modal', function () {
//     $('#myInput').trigger('focus')
// })

</script>

@endsection