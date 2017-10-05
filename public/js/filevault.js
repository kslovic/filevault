    $(document).ready(function(){
        $(".editp").hide();
        $("#upsubmit").hide();
        $("#lpublic").hide();
        $(".urlasset").hide();
        $("#myAlert").hide();
        $(".upload").click(function(){
                $("#lpublic").show("slow");
                $("#upsubmit").show("slow");
        });
        $("#close").click(function(){
                $("#myAlert").alert("close");
        });
        $("#closemsg").click(function(){
            $("#phpAlert").alert("close");
        });
        $(function() {
            $('body').on('click', '.pagination a', function (e) {
                e.preventDefault();
                var url = $(this).attr("href");
                console.log(url);
                getAssets(url);
                window.history.pushState("", "", url);
            })
        });
});

    function getAssets(url){
        $.ajax({
            type: "GET",
            url: url,
            success: function(data){
                $('.assets').html(data);
                $(".urlasset").hide();
                $(".editp").hide();
                $("#myAlert").hide();
            }

        });
    }
    function urlshow(x){
        $("#urlasset" + x).toggle("slow");
        $("#copy" + x).toggle("slow");
}
    function editshow(x,y){
        console.log(y);
        if(y === "yes")
            $("#editp" + x).text(" Make private");
        else
            $("#editp" + x).text(" Make public");
        $("#editp" + x).toggle("slow");
}

    function edit(value){
        $.ajax({
            type: "GET",
            url: '/edit/' + value,
            success: function(data) {
                $("#public" + value).text(data['value']);
                $("#phpAlert").alert("close");
                $("#myAlert").hide();
                $("#message").text(data['message']);
                $("#myAlert").toggle("slow");
                if(data['value'] === "yes")
                    $("#editp" + value).text(" Make private");
                else
                    $("#editp" + value).text(" Make public");
                $("#editp" + value).toggle("slow");
                console.log(data);
            }

    });
}

    function downloadshow(value){
        $.ajax({
            type: "GET",
            url: '/downloadshow/' + value,
            success: function(data) {

                $("#download" + value).text(data['value']);
                $("#phpAlert").alert("close");
                $("#myAlert").hide();
                $("#message").text(data['message']);
                $("#myAlert").toggle("slow");
                console.log(data);
            }

    });
}
    var timeout;
    function delaysearch(value){
        clearTimeout(timeout)
       timeout = setTimeout(function() {
           searchterm(value);
       }, 1000);
    }

    function searchterm(value) {
        $.ajax({
            type: "GET",
            url: '/searchajax/' + value,
            success: function (data) {
                $('.assets').html(data);
                $(".urlasset").hide();
                $(".editp").hide();
                $("#myAlert").hide();
            }

        });
    }

    function resize(){
        $("#term").animate({width: '500px'});
    }

    function copyclip(value) {

        // find target element
            console.log("zzzzz");
            $("#urlasset" + value).select();
            try {
                // copy text
               document.execCommand('copy');

            }
            catch (err) {
                alert('please press Ctrl/Cmd+C to copy');
            }

    }


