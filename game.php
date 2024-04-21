<?php
require('sample_database.php');
$base_url        = "http://localhost/pazzle_game/game/";
$error_message   = '';
$success_message = '';
$error           = false;
$success         = false;
$finished        = false;
$count           = isset($_POST['count']) ? (int)$_POST['count'] : 0;
$score           = isset($_POST['score']) ? (int)$_POST['score'] : 0;
$question        = $database[$count][0]['question'];
$answers         = $database[$count][1]['answers'];
$correct_answer  = $database[$count][2]['correct_answer'];
$count += 1;

if(isset($_POST['btn_submit']) && $_POST['btn_submit'] == 'Submit' && $_POST['id'] == '1') {
        $user_answer = $_POST['answer'];
        $pre_correct_answer = $_POST['correct_answer'];

        if ($user_answer == $pre_correct_answer) {
            $score   +=  2;
            $success = true;
            $error   = false;
        } else {
            $error   = true;
            $success = false;  
        }

        if($count == 6){
            $finished = true;
        }
}   
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pazzle Game</title>
    <link rel="stylesheet" href="asset/bootstrap/css/bootstrap.min.css">
    <script src="asset/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <style>
    body {
        background-image: url('images/background.jpg');
        background-repeat: no-repeat;
        background-size: cover;
        width: 100%;
        height: 100vh;
        background-position: center;
    }

    .answer_box {
        cursor: pointer;
    }

    .centered {
        margin-top: 5%;
    }

    .answer_box:hover {
        background-color: #290387;
        color: white;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center p-5 centered">
            <?php if($finished) {
                require('score_box.php');
            } else { ?>
            <?php if($success) { ?>
            <div class="alert alert-success" style="width: 40rem;" role="alert">
                <h4 class="alert-heading">Congratualtions</h4>
                <p style="text-align: center; font-weight: bold;">Your Answer Is Correct.</p>
            </div>
            <?php } ?>
            <?php if($error) { ?>
            <div class="alert alert-danger" style="width: 40rem;" role="alert">
                <h4 class="alert-heading">Good Luck Next Round</h4>
                <p style="text-align: center; font-weight: bold;">Your Answer Is Incorrect.</p>
                <hr>
                <p style="text-align: center; font-weight: bold;">The Correct Answer Is
                    [ <?php echo $pre_correct_answer; ?> ]
                </p>
            </div>
            <?php } ?>
            <div class="d-flex justify-content-end">
                <h5 style="color:red;font-weight: 900;font-size:30px;">Score : <?php echo $score?></h5>
            </div>
            <div class="alert alert-primary text-center h4" role="alert">
                <?php echo $question; ?>
            </div>
            <div class="col-md-5 mt-3">
                <div class="alert alert-warning text-center answer_box" role="alert">
                    <h6 class='answers'><?php echo $answers[0]; ?></h6>
                </div>
            </div>
            <div class="col-md-5 mt-3">
                <div class="alert alert-success text-center answer_box h6" role="alert">
                    <h6 class='answers'><?php echo $answers[1]; ?></h6>
                </div>
            </div>
            <div class="col-md-5 mt-3">
                <div class="alert alert-danger text-center answer_box h6" role="alert">
                    <h6 class='answers'><?php echo $answers[2]; ?></h6>
                </div>
            </div>
            <div class="col-md-5 mt-3">
                <div class="alert alert-dark text-center answer_box h6" role="alert">
                    <h6 class='answers'><?php echo $answers[3]; ?></h6>
                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <form id="submit_form" method="POST">
                        <input type="hidden" name="count" value="<?php echo  $count ?>" />
                        <input type="hidden" name="score" value="<?php echo $score; ?>" />
                        <input type="hidden" name="correct_answer" value="<?php echo $correct_answer; ?>" />
                        <input type="hidden" name="btn_submit" value="Submit" />
                        <input type="hidden" id="answer" name="answer"/>
                        <input type="hidden" name="id" value="1" />
                    </form>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</body>
<script>
$(document).ready(function() {
    $('.answer_box').click(function() {
        let clickedAnswer = $(this).find('h6').text();
        $('#answer').val(clickedAnswer);
        $('#submit_form').submit();
    });
});

function reloadPage() {
    window.location = window.location;
}
</script>

</html>