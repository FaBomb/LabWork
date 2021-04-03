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
            <div class="history team_box">
                <h2>伝統建築班</h2>
                <div class="content">
                    <div id="history_view" class="view_box"></div>
                    <div id="history_input_0" class="input_box">
                        <input type="text" class="name" id="history_name_0" placeholder="名前">
                        <input type="text" class="title" id="history_title_0" placeholder="タイトル">
                        <input type="text" class="summary" id="history_summary_0" placeholder="発表概要">
                        <input type="text" class="minute" id="history_minute_0_0" placeholder="議事" onkeypress="enter('history', 'minute', 0, 0)">
                        <input type="text" class="decision" id="history_decision_0_0" placeholder="まとめ" onkeypress="enter('history', 'decision', 0, 0)">
                    </div>
                </div>
                <input type="button" value="+" onclick="send('history')">
            </div>
            <div class="city team_box">
                <h2>都市班</h2>
            </div>
            <div class="health team_box">
                <h2>健康班</h2>
            </div>
            <div class="future team_box">
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
    function send(team){
        let param = {};
        
        let name = document.getElementById(team+"_name_0");
        let title = document.getElementById(team+"_title_0");
        let summary = document.getElementById(team+"_summary_0");
        let minute = document.getElementById(team+"_minute_0_0");
        let decision = document.getElementById(team+"_decision_0_0");
        
        param["name"] = name.value;
        param["title"] = title.value;
        param["summary"] = summary.value;
        param["minute"] = minute.value;
        param["decision"] = decision.value;
        conn.send(JSON.stringify(param));

        let view = document.getElementById(team+"_view");
        let input = document.getElementById(team+"_input_0");
        let input_copy = input.cloneNode(true);

        let minute_num = 1;
        let decision_num = 1;
        input_copy.childNodes.forEach(function(elem){
            if (elem.nodeName === "INPUT"){
                if (elem.id.indexOf("name") !== -1){
                    elem.setAttribute("id", team+"_name_"+num);
                }
                else if (elem.id.indexOf("title") !== -1){
                    elem.setAttribute("id", team+"_title_"+num);
                }
                else if (elem.id.indexOf("summary") !== -1){
                    elem.setAttribute("id", team+"_summary_"+num);
                }
                else if (elem.id.indexOf("minute") !== -1){
                    if (elem.id === team+"_minute_0_0"){
                        elem.setAttribute("id", team+"_minute_"+num+"_0");
                        elem.setAttribute("onkeypress", "enter('"+team+"', 'minute', "+num+", 0)");
                    }else{
                        elem.setAttribute("id", team+"_minute_"+num+"_"+minute_num);
                        elem.setAttribute("onkeypress", "enter('"+team+"', 'minute', "+num+", "+minute_num+")");
                        minute_num++;
                    }
                }
                else if (elem.id.indexOf("decision") !== -1){
                    if (elem.id === team+"_decision_0_0"){
                        elem.setAttribute("id", team+"_decision_"+num+"_0");
                        elem.setAttribute("onkeypress", "enter('"+team+"', 'decision', "+num+", 0)");
                    }else{
                        elem.setAttribute("id", team+"_decision_"+num+"_"+decision_num);
                        elem.setAttribute("onkeypress", "enter('"+team+"', 'decision', "+num+", "+decision_num+")");
                        decision_num++;
                    }
                }
            }
        });

        input.childNodes.forEach(function(elem){
            if (elem.nodeName === "INPUT"){
                if (elem.id.indexOf("minute") !== -1){
                    if (elem.id !== team+"_minute_0_0"){
                        elem.setAttribute("class", "delete");
                    }
                }
                else if (elem.id.indexOf("decision") !== -1){
                    if (elem.id !== team+"_decision_0_0"){
                        elem.setAttribute("class", "delete");
                    }
                }
            }
        });
        let del = Array.prototype.slice.call(document.getElementsByClassName("delete"));
        del.forEach(function(elem){
            elem.remove();
        })

        let del_button = document.createElement("input");
        del_button.setAttribute("type", "button");
        del_button.setAttribute("value", "-");
        del_button.setAttribute("onclick", "del('"+team+"', "+num+")");
        input_copy.appendChild(del_button);

        input_copy.setAttribute("id", team+"_input_"+num);
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
            add.setAttribute("class", area);
            add.setAttribute("onkeypress", "enter('"+team+"', '"+area+"', "+mark+", "+count+")");
            add.setAttribute("value", "→");
            
            parent.insertBefore(add, target.nextElementSibling);
            target.nextElementSibling.focus();
            target.nextElementSibling.setSelectionRange(1, 1);

        }else if (window.event.keyCode === 13){
            let add = document.createElement("input");
            count++;
            add.setAttribute("id", team+"_"+area+"_"+mark+"_"+count);
            add.setAttribute("class", area);
            add.setAttribute("onkeypress", "enter('"+team+"', '"+area+"', "+mark+", "+count+")");
            
            parent.insertBefore(add, target.nextElementSibling);
            target.nextElementSibling.focus();
        }
        if (window.event.ctrlKey || window.event.metaKey){
            if (window.event.keyCode === 26){
                if (target.previousElementSibling.id.indexOf(area) !== -1){
                    target.previousElementSibling.focus();
                    target.remove();
                }
            }
        }
    }
    function close(){
        conn.close();
    }

    open();
</script>
</html>