<div id="modal_<?php echo $day; ?>" class="hidden modal">
    <h1><?php echo $month."/".$day; ?></h1>
    <button id="close_<?php echo $day; ?>" class="close_btn">×</button>
    <form action="scheduleCreate.php" method="POST">
        <h3>SCHEDULE:<input type="text" name="title" placeholder="予定を入力してください"></h3>
        <h3>DETAIL：<input type="text" name="content" placeholder="詳細を入力してください"></h3>
        <h3>URL：<input type="text" name="url" placeholder="ZoomURLを入力してください"></h3>
        <h3 class="time">START：
            <select type="number" name="start_hour" size="1" class="hour">
                <?php
                    for($i=1; $i<=24; $i++){
                        echo "<option value=$i>$i</option>";
                    }
                ?>
            </select>
            <div class="split">：</div>
            <select type="number" name="start_minute" size="1" class="minute">
                <?php
                    for($i=0; $i<60; $i+=10){
                        echo "<option value=$i>".str_pad($i, 2, 0, STR_PAD_LEFT)."</option>";
                    }
                ?>
            </select>
        </h3>
        <h3 class="time">FINISH：
            <select type="number" name="end_hour" size="1" class="hour">
                <?php
                    for($i=1; $i<=24; $i++){
                        echo "<option value=$i>$i</option>";
                    }
                ?>
            </select>
            <div class="split">：</div>
            <select type="number" name="end_minute" class="minute">
                <?php
                    for($i=0; $i<60; $i+=10){
                        echo "<option value=$i>".str_pad($i, 2, 0, STR_PAD_LEFT)."</option>";
                    }
                ?>
            </select>
        </h3>
        <h3 class="member_box">MEMBERs：</h3>
        <select  type="text" size="5" multiple name="join_member[]" class="member">
            <optgroup label="学年" class="group">
                <option value="<?php echo implode(",", $all_list) ?>">全学年</option>
                <?php
                    if (isset($b3_list)){
                        echo "<option value=".implode(",", $b3_list).">B3</option>";
                    }
                ?>
                <?php
                    if (isset($b4_list)){
                        echo "<option value=".implode(",", $b4_list).">B4</option>";
                    }
                ?>
                <?php
                    if (isset($m1_list)){
                        echo "<option value=".implode(",", $m1_list).">M1</option>";
                    }
                ?>
                <?php
                    if (isset($m2_list)){
                        echo "<option value=".implode(",", $m2_list).">M2</option>";
                    }
                ?>
            </optgroup>
            <optgroup label="班" class="group">
                <?php
                    if (isset($future_list)){
                        echo "<option value=".implode(",", $future_list).">未来班</option>";
                    }
                ?>
                <?php
                    if (isset($city_list)){
                        echo "<option value=".implode(",", $city_list).">都市班</option>";
                    }
                ?>
                <?php
                    if (isset($health_list)){
                        echo "<option value=".implode(",", $health_list).">健康班</option>";
                    }
                ?>
                <?php
                    if (isset($history_list)){
                        echo "<option value=".implode(",", $history_list).">伝統建築班</option>";
                    }
                ?>
            </optgroup>
            <optgroup label="係" class="group">
                <?php
                    if (isset($admin_list)){
                        echo "<option value=".implode(",", $admin_list).">運営係</option>";
                    }
                ?>
                <?php
                    if (isset($book_list)){
                        echo "<option value=".implode(",", $book_list).">経理書籍係</option>";
                    }
                ?>
                <?php
                    if (isset($pc_list)){
                        echo "<option value=".implode(",", $pc_list).">PC係</option>";
                    }
                ?>
                <?php
                    if (isset($english_list)){
                        echo "<option value=".implode(",", $english_list).">レク・英語係</option>";
                    }
                ?>
                <?php
                    if (isset($machine_list)){
                        echo "<option value=".implode(",", $machine_list).">計測機器係</option>";
                    }
                ?>
                <?php
                    if (isset($heritage_list)){
                        echo "<option value=".implode(",", $heritage_list).">遺産係</option>";
                    }
                ?>
                <?php
                    if (isset($branding_list)){
                        echo "<option value=".implode(",", $branding_list).">ブランディング係</option>";
                    }
                ?>
            </optgroup>
            <optgroup label="個人" class="group">
                <?php
                    foreach ($user_list as $key => $val){
                        echo "<option value='".$key."' >".$val."</option>";
                    }
                ?>
            </optgroup>
        </select>
        
        <input type="submit" value="ENTER">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION["login"]; ?>">
        <input type="hidden" name="year" value="<?php echo $year; ?>">
        <input type="hidden" name="week" value="<?php echo $week; ?>">
        <input type="hidden" name="month" value="<?php echo $month; ?>">
        <input type="hidden" name="day" value="<?php echo $day; ?>">
    </form>
    
</div>

