$(document).ready(function () {
    $(".addNote").on("click",function (e) {
        e.preventDefault();
        var employeeId = $(this).data("employeeid");
        var employeeName = $(this).data("employeefullname");
        var ticketId = $(this).data("ticketid");
        var ticketdate = $(this).data("ticketdate");
        var ticketstatus = $(this).data("ticketstatus");
        var ticketsubject = $(this).data("ticketsubject");
        $("#ticketId").val(ticketId);

        $(".ticketId").html(ticketId);
        $(".ticketDate").html(ticketdate);
        $(".ticketSubject").html(ticketsubject);
        $(".ticketStatus").html(ticketstatus);

        $("#employeeId").val(employeeId);
        $("#employeeName").val(employeeName);
        $("#form-modal").modal({'backdrop':'static','show':true});
    })
    $("body").on("click",".close",(e)=>{
        $("form")[0].reset();
    });
})

function editNote(data){
    var employeeId = $(data).data("employeeid");
    var employeeName = $(data).data("employeefullname");
    var ticketId = $(data).data("ticketid");
    var ticketdate = $(data).data("ticketdate");
    var ticketstatus = $(data).data("ticketstatus");
    var ticketsubject = $(data).data("ticketsubject");
    var noteId = $(data).data("noteid");
    var note = $(data).data("note");
    var url = $(data).data('url');
    $("#ticketId").val(ticketId);
    $("#note").val(note);
    $("#noteId").val(noteId);
    $("#form-note").attr("action",url);
    $("#form-note").attr("method","POST");

    $(".ticketId").html(ticketId);
    $(".ticketDate").html(ticketdate);
    $(".ticketSubject").html(ticketsubject);
    $(".ticketStatus").html(ticketstatus);

    $("#employeeId").val(employeeId);
    $("#employeeName").val(employeeName);
    $("#form-modal").modal({'backdrop':'static','show':true});
}