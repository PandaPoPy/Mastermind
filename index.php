<!DOCTYPE html>
<html>
	<head>
        <meta charset="utf-8" />
		<title>index</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <script type="text/javascript" src="jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="mastermind.js"></script>
	</head>
	<body>
        <div id="board">
            <div class="mm-board">
                <div class="mm-line played" id="mm-line-solution" data-line="solution">
                    <?php
                    for($i = 1; $i <= 4; $i++) {
                        echo '<div class="mm-bullet" data-pawn="'.$i.'"></div>'.PHP_EOL;

                    }
                    ?>
                    <div class="mm-score-bullet"></div>
                </div>
                <?php
                for($i = 10; $i > 0; $i--) {
                    echo '<div class="mm-line" data-line="'.$i.'">'.PHP_EOL;
                    for($j = 1; $j <= 4; $j++) {
                        echo '<div class="mm-bullet" data-pawn="'.$j.'"></div>'.PHP_EOL;
                        }
                    echo '<div class="mm-score-bullet"></div>
                </div>';
                }
                ?>
            </div>
            <div id="mm-pawn-board-wrapper">
                <div id="mm-pawn-board">
                    <div class="mm-pawn" data-color="rouge"></div>
                    <div class="mm-pawn" data-color="jaune"></div>
                    <div class="mm-pawn" data-color="vert"></div>
                    <div class="mm-pawn" data-color="bleu"></div>
                    <div class="mm-pawn" data-color="orange"></div>
                    <div class="mm-pawn" data-color="blanc"></div>
                </div>
            </div>
        </div>
	</body>
</html>
