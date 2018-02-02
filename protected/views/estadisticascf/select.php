<?php 

if(isset($_POST['result']))
{
	print_r($_POST['result']);

}else{
	echo "NO instanciado";
}


$this->widget(
    'bootstrap.widgets.TbSelect2',
    array(
        'name' => 'group_id_list',
        'data' => array('RU' => 'Russian Federation', 'CA' => 'Canada', 'US' => 'United States of America', 'GB' => 'Great Britain'),
        'htmlOptions' => array(
            'multiple' => 'multiple',
            'id' => 'issue-574-checker-select',
            'class'=>'span6'
        ),
    )
);
echo CHtml::endForm();
$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'label' => 'Click on me with Developer Tools opened!',
        'htmlOptions' => array(
            'onclick' => 'js:$.ajax({
                url: "index.php?r=estadisticas/select",
                type: "POST",
                data: (function () {
                    var select = $("#issue-574-checker-select");
                    var result = {};
                    result[select.attr("name")] = select.val();
                    return result;
                })() // have to use self-evaluating function here
            });'
        )
    )
);

 ?>
