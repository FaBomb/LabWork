<?php 
    // ログインチェック
    include "../loginCheck.php";
    unset($_SESSION["year"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" type="image" href="../img/logo.jpg">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    <title>LabWork</title>
</head>
<body>
    <div class="wrapper">
        <?php include "../header.html.php" ?>
        <div class="advice">

        </div>
        <div class="minute">
            <form action="title.php" method="POST">
                <h1>
                    第
                    <input type="number" name="num">
                    回
                    <select name="title">
                        <option value="自主">自主</option>
                        <option value="本">本</option>
                    </select>
                    ゼミ議事録
                </h1>
                <input type="submit">
            </form>
            <div class="history">
                <h2>伝統建築班</h2>
                <div id="content">
                    <div id="history_view"></div>
                    <div id="history_input_0">
                        <input type="text" id="history_name_0" placeholder="名前"> <br>
                        <input type="text" id="history_title_0" placeholder="タイトル"> <br>
                        <input type="text" id="history_summary_0" placeholder="発表概要"> <br>
                        <input type="text" id="history_minute_0_0" placeholder="議事" onkeypress="enter('history', 'minute', 0, 0)"> <br>
                        <input type="text" id="history_decision_0_0" placeholder="まとめ" onkeypress="enter('history', 'decision', 0, 0)"> <br>
                    </div>
                </div>
                <input type="button" value="+" onclick="send('history')">
            </div>
            <div class="city">
                <h2>都市班</h2>
            </div>
            <div class="health">
                <h2>健康班</h2>
            </div>
            <div class="future">
                <h2>未来班</h2>
            </div>
        </div>
        
        <?php include "../footer.html.php" ?>
    </div>
</body>
<script type="text/javascript">
    var conn = "";

    function open(){

        conn = new WebSocket('ws://localhost:8080');

        conn.onopen = function(e) {
            console.log("connection for comment established!");
        };

        conn.onerror = function(e) {
            alert("エラーが発生しました");
        };

        conn.onmessage = function(e) {
            console.log(e.data);
            // let receive_data = {};
            // receive_data = JSON.parse(e.data);

            // let append_message = receive_data["name"] + ":" + receive_data["message"];
            // let message_box = document.getElementById("message_box");
            // let child = document.createElement("div");

            // child.append(append_message);
            // message_box.append(child);
            // console.log(message_box);
            };

        conn.onclose = function() {
            alert("切断しました");
            setTimeout(open, 5000);
        };

    }
    let num = 1;
    function send(arg){
        let param = {};
        
        let name = document.getElementById(arg+"_name_0");
        let title = document.getElementById(arg+"_title_0");
        let summary = document.getElementById(arg+"_summary_0");
        let minute = document.getElementById(arg+"_minute_0_0");
        let decision = document.getElementById(arg+"_decision_0_0");
        
        param["name"] = name.value;
        param["title"] = title.value;
        param["summary"] = summary.value;
        param["minute"] = minute.value;
        param["decision"] = decision.value;
        conn.send(JSON.stringify(param));

        let view = document.getElementById(arg+"_view");
        let input = document.getElementById(arg+"_input_0");

        let input_copy = input.cloneNode(true);
        input_copy.childNodes.item(1).setAttribute("id", arg+"_name_"+num);
        input_copy.childNodes.item(5).setAttribute("id", arg+"_title_"+num);
        input_copy.childNodes.item(9).setAttribute("id", arg+"_summary_"+num);
        input_copy.childNodes.item(13).setAttribute("id", arg+"_minute_"+num+"_0");
        input_copy.childNodes.item(13).setAttribute("onkeypress", "enter('"+arg+"', 'minute', "+num+", 0)");
        input_copy.childNodes.item(17).setAttribute("id", arg+"_decision_"+num+"_0");
        input_copy.childNodes.item(17).setAttribute("onkeypress", "enter('"+arg+"', 'decision', "+num+", 0)");

        let del_button = document.createElement("input");
        del_button.setAttribute("type", "button");
        del_button.setAttribute("value", "-");
        del_button.setAttribute("onclick", "del('"+arg+"', "+num+")");
        input_copy.appendChild(del_button);

        input_copy.setAttribute("id", arg+"_input_"+num);
        view.appendChild(input_copy);
        num++;

        name.value="";
        title.value="";
        summary.value="";
        minute.value="";
        decision.value="";
    }
    function del(team, mark){
        let target = document.getElementById(team+"_input_"+mark);
        target.remove();
    }
    function enter(team, area, mark, count){
        let target = document.getElementById(team+"_"+area+"_"+mark+"_"+count);
        let parent = document.getElementById(team+"_input_"+mark);
        
        let parents = Array.prototype.slice.call(parent.children);

        searchDup();
        function searchDup(){
            parents.forEach(function(elem){
                let new_count = count+1;
                console.log(elem.id)
                if (elem.id === team+"_"+area+"_"+mark+"_"+new_count){
                    count++;
                    searchDup();
                }
            });
        }

        if (window.event.shiftKey){
            let add = document.createElement("input");
            count++;
            add.setAttribute("id", team+"_"+area+"_"+mark+"_"+count);
            add.setAttribute("onkeypress", "enter('"+team+"', '"+area+"', "+mark+", "+count+")");
            add.setAttribute("value", "→");
            
            parent.insertBefore(add, target.nextElementSibling);
            target.nextElementSibling.focus();
        }else if (window.event.keyCode === 13){
            let add = document.createElement("input");
            count++;
            add.setAttribute("id", team+"_"+area+"_"+mark+"_"+count);
            add.setAttribute("onkeypress", "enter('"+team+"', '"+area+"', "+mark+", "+count+")");
            
            parent.insertBefore(add, target.nextElementSibling);
            target.nextElementSibling.focus();
        }
        if (window.event.ctrlKey || window.event.metaKey){
            if (window.event.keyCode === 26){
                target.previousElementSibling.focus();
                target.remove();
            }
        }
    }
    function close(){
        conn.close();
    }

    open();
</script>
</html>