<?php
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "../../../../conexao.php";
        
        $outgoing_id = mysqli_real_escape_string($conexao, $_POST['outgoing_id']);
        $incoming_id = mysqli_real_escape_string($conexao, $_POST['incoming_id']);
        $output = "";

        $sql = "SELECT * FROM messages as msg
        LEFT JOIN tb_paciente as pa ON (pa.unique_id = msg.outgoing_msg_id)
        WHERE (outgoing_msg_id = {$outgoing_id} 
        AND incoming_msg_id = {$incoming_id})
        OR (outgoing_msg_id = {$incoming_id} 
        AND incoming_msg_id = {$outgoing_id})
        ORDER BY msg_id";// selecionando todos os btp que correspondem a incoming e outcoming
        
        $query = mysqli_query($conexao, $sql);
        if(mysqli_num_rows($query) > 0){// se isso for igual, entao ele é rementente da mensagem
            while($row = mysqli_fetch_assoc($query)){
                if($row['img'] == null){
                    $img = "fotoperfilvazia.jpg";
                }else{
                    $img = $row['img'];
                }

                if($row['outgoing_msg_id'] === $outgoing_id){
                    $output .= '<div class="chat outgoing">
                                <div class="details">
                                <p>'. $row['msg'].'</p>
                                </div>
                                </div>';
                }else{// esse é o receptor da mensagem
                    $output .= ' <div class="chat incoming">
                                 <img src="../../fotos/'.$img.'" alt="">
                                 <div class="details">
                                 <p>'. $row['msg'].'</p>
                                 </div>
                                 </div> ';
                }
            }
            echo $output;
        }
     
        }else{
            header("../users.php");
        }
    

?>