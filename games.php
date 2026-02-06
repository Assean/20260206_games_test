<?php session_start();

/*
當畫面載入的時候,要能偵測games 資料夾中,有多少個遊戲,
並將遊戲資料.json的資訊,放入到$games的陣列中
*/
$games=[];
$handle=opendir('games');
if($handle){
    while(false!==($entry=readdir($handle))){

        if($entry !="." && $entry !=".."){
            echo "<script>console.log($entry)</script>";
            $json_path = "games/".$entry."/game.json";
            if(file_exists($json_path)){
                $data=json_decode(file_get_contents($json_path),true);
                $data['path']="games/".$entry."/index.html";
                $games[]=$data;
            }
        }
    }
    closedir($handle);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FunTech 社群網站</title>
    <link rel="stylesheet" href="by/css/bootstrap.css">
    <link rel="stylesheet" href="by/css/index.css">
    <script src="by/js/jquery-3.7.1.min.js"></script>
    <!-- <script src=""></script> -->
    <script>
        let activeGame;

        function receiveGameResult(data) {
            // console.log(data)
            $("#gameTitle").text(data.game)
            // $("") == document.get....
            // $("#") == document.getElementById()
            $("#gameStatus").text(data.data.result)
            $("#gameTime").text(data.data.time)
            $("#resultBlock").removeClass("d-none");
            $("#resultBlock").addClass("d-block");
            //1. 是否有登入?
            //  1.1 有登入->取得帳號
            //  1.2 沒有登入-> 使用guest

            $("#result_modal").modal("show");
            $("#submit_name").click(() => {
                console.log($("#name").val())
            })
            // $.get("api/check_login.php", (res) => {
            //     // if(res=='0'){
            //     //     data['user']='guest'
            //     // }else{
            //     //     let user=JSON.parse(res)
            //     //     data['user']=user.user
            //     // }
            //     let username = prompt("請輸入姓名");
            //     data['user'] = username;

            //     //2. 寫入資料庫
            //     $.post('api/save_result.php', data, (res) => {
            //         alert("遊戲結果已儲存")
            //     })

            // })

        }
        function openGame(url, title) {
            activeGame = title
            window.open(url, 'GameWindow', 'width=800,height=600')
        }



    </script>
</head>

<body>
    <?php include_once "header.php";?>

    <div id="main-content" class='container' style='min-height:700px'>
        <h1 class="text-center my-4">遊戲平台</h1>
        <div id="resultBlock" class="d-none border rounded bg-success text-white p-3">
            <div class="my-2">遊戲名稱:<span id="gameTitle"></span></div>
            <div class="my-2">遊戲狀態:<span id="gameStatus"></span></div>
            <div class="my-2">遊戲時間:<span id="gameTime"></span></div>
        </div>

        <div class="row flex-wrap">
            <?php 
        foreach($games as $game):
        ?>
            <div class="w-50 p-3">
                <div class="border rounded p-2" style="height:150px">
                    <div>遊戲名稱:
                        <?=$game['title'];?>
                    </div>
                    <div>遊戲說明:
                        <?=$game['description'];?>
                    </div>
                    <button class="btn btn-primary"
                        onclick="openGame('<?=$game['path'];?>','<?=$game['title'];?>')">開始遊戲</button>
                </div>
            </div>
            <?php
        endforeach;
        ?>
        </div>
        <div class="modal" tabindex="-1" id="result_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">輸入姓名</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="name" id="name">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="submit_name" class="btn btn-primary">確認</button>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div id="footer" class='text-center bg-primary text-white' style="height:45px;line-height:45px">Copyright © 2026
        FunTech. All rights reserved.</div>

    <script src="by/js/bootstrap.js"></script>
</body>

</html>