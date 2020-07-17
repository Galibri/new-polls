<?php include './includes/header.php';?>

<?php
    $stmt = $conn->prepare("SELECT * FROM questions WHERE is_global=:is_global AND (type=:type OR type=:type2)");
    $stmt->execute([
        'is_global' => 1,
        'type'      => 1,
        'type2'     => 2
    ]);
    $questions = $stmt->fetchAll();
?>

<main>
    <h1>Results</h1>

    <?php foreach ($questions as $question): ?>
    <h3 class="result-q-title mt-3"><?php echo $question['question']; ?></h3>
    <?php
        $answers = get_answers_by_question_id($question['id']);
        $data    = [];
        $labels  = [];
    ?>
    <?php if ($answers > 0): ?>
    <?php foreach ($answers as $answer): ?>
    <?php
        array_push($data, count_global_answers($answer['id']));
        array_push($labels, $answer['answer']);
    ?>
    <?php endforeach;?>
    <?php
        $data = implode(', ', $data);
        $labels = sprintf("'%s'", implode("','", $labels ) );
    ?>
    <?php endif; ?>
    <button class="btn" type="bar" id="change_type_<?php echo $question['id']; ?>">View Pie Chart</button>
    <div class="border-bottom-1 chart_canv_<?php echo $question['id']; ?>"><canvas id="question_<?php echo $question['id']; ?>"></canvas></div>
    <script>
    $(document).ready(function($) {
        loadBarChart( 
            [<?php echo $labels; ?>] , 
            "", 
            [<?php echo $data; ?>] ,
            "question_<?php echo $question['id']; ?>", 
            "<?php echo $question['question']; ?>", 
            $('#change_type_<?php echo $question['id']; ?>').attr('type')
        )
        
        $(document).on('click', '#change_type_<?php echo $question['id']; ?>', function() {
            if($(this).attr('type')  == 'bar') {
                $(this).attr('type', 'pie')
                $(this).text('View Bar Chart')
            } else {
                $(this).attr('type', 'bar')
                $(this).text('View Pie Chart')
            }
            $("#question_<?php echo $question['id']; ?>").remove();
            $(".chart_canv_<?php echo $question['id']; ?>").append('<canvas id="question_<?php echo $question['id']; ?>"></canvas>');

            loadBarChart( 
                [<?php echo $labels; ?>] , 
                "", 
                [<?php echo $data; ?>] ,
                "question_<?php echo $question['id']; ?>", 
                "<?php echo $question['question']; ?>", 
                $('#change_type_<?php echo $question['id']; ?>').attr('type'),
                true
            )
        })
    });
    </script>
    <?php endforeach; ?>

</main>

<?php include './includes/footer.php';?>