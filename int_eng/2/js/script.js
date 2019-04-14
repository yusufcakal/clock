$(document).ready(function(){
        
     $("button").click(function(){
        var first = $("#first").val();
        var second = $("#second").val();

        var a = $("select").val();
        var result;
        if (a == "+") {
            result = parseInt(first)+parseInt(second);
        }else if (a == "-") {
            result = parseInt(first)-parseInt(second);
        }else if (a == "*") {
            result = parseInt(first)*parseInt(second);
        }else if (a == "/") {
            result = parseInt(first)/parseInt(second);
        }

        var str = "" + result;

        $("input[name='location[state_id]'").val(str);

    });    

});